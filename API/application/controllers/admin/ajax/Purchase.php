<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchase extends CI_Controller
{
    public function index() // view products
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('admin/Purchase_model');
        $this->load->model('admin/Warehouse_model');
        $this->load->model('admin/Supplier_model');
        $this->load->model('admin/Status_model');
        $this->load->model('admin/Unit_model');
        $this->load->model('admin/Tax_model');
        $_POST = raw_input_to_post();
        $action = $this->input->get('action') ?: $this->input->post('action');
        $dropdown = $this->input->get('dropdown') ?: $this->input->post('dropdown');
        $search = $this->input->get('search') ?: $this->input->post('search');
        $job = $this->input->get('job') ?: $this->input->post('job');
        switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
            case 'GET': // read
                switch ($action) {
                    case 'datatable':
                        $data = array();
                        $limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
                        $order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
                        $order = $this->input->get('order')[0]['dir']; // order asc or desc
                        $search = $this->input->get('search')['value']; // search query
                        $offset = $this->input->get('start'); // start position
                        $query = $this->Purchase_model->datatable_data($search, $offset, $limit, $order_by, $order);
                        $data['data'] = $query->result();
                        $data["draw"] = $this->input->get('draw'); // unique
                        $data["recordsTotal"] = 0; //$this->Product_model->datatable_recordsTotal();
                        $data["recordsFiltered"] = 0; //$this->Product_model->datatable_recordsFiltered($search);
                        $data["success"] = true;
                        //$data[ 'error' ] = '';
                        echo json_encode($data);
                        break;
                    case 'create':
                        break;
                    case 'update':
                        break;
                    case 'details':
                        $data = array();
                        $data['products'] = $this->Purchase_model->getPurchaseProductsDetails(array('pp.purchase' => (int)$this->input->get('id')));
                        $data['purchase'] = $this->Purchase_model->getPurchaseDetails(array('p.id' => (int)$this->input->get('id')));
                        echo json_encode(array('success' => true, 'type' => 'success', 'data' => $data));
                        break;
                    case 'payment_details':
                        $data = array();
                        $data['payments'] = $this->Purchase_model->getPurchasePayments(array('pp.purchase' => (int)$this->input->get('id')));
                        echo json_encode(array('success' => true, 'type' => 'success', 'data' => $data));
                        break;
                    default:
                        die(json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Action not found !')));
                }
                break;
            case 'POST': // add new purchase
                $_POST = $this->input->post('data');
                switch ($action) {
                    case 'create':
                        $auto_id = $this->Purchase_model->get_AUTO_INCREMENT();
                        $auto_id = trim(reduce_multiples(sprintf("REF-PUR-%05s", $auto_id), " "));
                        $data = array(
                            'reference_id'      => $auto_id,
                            'warehouse'         => $this->input->post('warehouse'),
                            'date'              => $this->input->post('date'),
                            'time'              => $this->input->post('date'),
                            'status'            => $this->input->post('purchase_status'),
                            'created_by'        => $this->session->id,
                            'supplier'          => $this->input->post('supplier'),
                            'discount'          => $this->input->post('discount'),
                            'purchase_tax'      => $this->input->post('tax_rate') ?: NULL,
                            'shipping_charge'   => $this->input->post('shipping'),
                            'shipping_tax'      => $this->input->post('shipping_tax') ?: NULL,
                            'packing_charge'    => $this->input->post('packing'),
                            'packing_tax'       => $this->input->post('packing_tax') ?: NULL,
                            'round_off'         => $this->input->post('roundoff'),
                            'payment_note'      => $this->input->post('payment_note') ?: NULL,
                            'note'               => $this->input->post('note') ?: NULL,
                        );
                        $this->form_validation->set_data($data);
                        $config = array(
                            array(
                                'field' => 'warehouse',
                                'label' => 'Warehouse',
                                'rules' => 'required|trim|numeric|xss_clean',
                            )
                        );
                        $this->form_validation->set_rules($config);
                        if ($this->form_validation->run() == FALSE) { // check data fields
                            die(json_encode(array('success' => false, 'errors' => $this->form_validation->error_array())));
                        }
                        /************************************************************ */
                        $this->db->trans_begin();
                        $this->Purchase_model->insert_purchase($data);
                        if ($this->db->affected_rows() == 1) { // success - add purchase
                            $purchase_id = $this->db->insert_id();
                            $products = $this->input->post('products'); // list of purchased products
                            foreach ($products as $product) { // add products
                                $data = array(
                                    'purchase' => $purchase_id,
                                    'product' => $product['id'],
                                    'quantity' =>  $product['quantity'],
                                    'unit' =>  $product['p_unit'],
                                    'unit_cost' => $product['cost'],
                                    'unit_discount' => $product['discount'],
                                    'tax_id' => $product['tax_id'] ?: null,
                                );
                                $this->Purchase_model->insert_purchase_product($data);
                                if ($this->db->affected_rows() != 1) {
                                    $error = $this->db->error();
                                    $this->db->trans_rollback();
                                    die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                }
                            }
                            $this->db->trans_commit();
                            echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully added new purchase !', 'location' => "admin/purchase/list"));
                        } else {
                            $error = $this->db->error();
                            $this->db->trans_rollback();
                            echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                        }
                        /************************************************************ */
                        break;
                    case 'payment':
                        $purchase = $this->input->post('purchase');
                        $payments = $this->input->post('payments');
                        $this->Purchase_model->update_purchase(array('payment_note' => $this->input->post('payment_note')), $purchase['id']);
                        $this->db->trans_begin();
                        foreach ($payments as $payment) { // add payments
                            $data = array(
                                'purchase' => $purchase['id'],
                                'payment_mode' => $payment['mode'],
                                'amount' =>  $payment['amount'],
                                'date_time' => $payment['date_time'],
                                'transaction_id' =>  $payment['transaction_id'] ? trim($payment['transaction_id']) : NULL,
                                'reference_no' =>  $payment['reference_no'] ? trim($payment['reference_no']) : NULL,
                                'note' =>  $payment['note'] ? trim($payment['note']) : NULL
                            );
                            /***************************/ // validate each payment methods
                            $this->form_validation->set_data($data);
                            $config = array(
                                array(
                                    'field' => 'amount',
                                    'label' => 'Amount',
                                    'rules' => 'trim|numeric|greater_than[0]'
                                ),
                                array(
                                    'field' => 'transaction_id',
                                    'label' => 'Transaction ID',
                                    'rules' => 'trim'
                                ),
                                array(
                                    'field' => 'reference_no',
                                    'label' => 'Reference No.',
                                    'rules' => 'trim'
                                ),
                                array(
                                    'field' => 'note',
                                    'label' => 'Note',
                                    'rules' => 'trim'
                                )
                            );
                            $this->form_validation->set_rules($config);
                            if ($this->form_validation->run() == FALSE) {
                                $this->db->trans_rollback();
                                die(json_encode(array('success' => false, 'errors' => $this->form_validation->error_array())));
                            }
                            $this->Purchase_model->create_purchase_sale_payment($data);
                            if ($this->db->affected_rows() != 1) {
                                $error = $this->db->error();
                                $this->db->trans_rollback();
                                die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                            }
                        }
                        $this->db->trans_commit();
                        echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully Added Purchase Payment !'));
                        break;
                    default:
                }
                break;
            case 'PUT': // update purchase
                switch ($action) {
                    case 'update_payment':
                        $_POST = $this->input->post('data');
                        $purchase = $this->input->post('purchase');
                        $ui_payments = $this->input->post('payments');
                        //print_r($ui_payments);
                        // update payment note
                        $this->Purchase_model->update_purchase(array('payment_note' => $this->input->post('payment_note')), $purchase['id']);
                        $this->db->trans_begin();
                        // get all payment for the purchase
                        $db_payments = $this->Purchase_model->getPurchasePayments(array('pp.purchase' => (int)$purchase['id']));
                        //print_r($db_payments);
                        // find data for update (check in both arrays)

                        $result = array_intersect_key(array_column($ui_payments, null, 'id'), array_flip($db_payments));

                        print_r($result);


                        foreach ($ui_payments as $ui_payment) { // loop through ui payments
                            $db_payment = $this->Purchase_model->get_purchase_payment_row(array('pp.id' => $ui_payment['id'], 'pp.purchase' => (int)$purchase['id']));
                            if ($db_payment['id']) { // same exist in db
                                // update on db using unique id

                                // delete from ui array ( so at last only new pays exist for adding )
                                $key = array_search($ui_payment['id'], array_column($ui_payments, 'id'));
                                unset($ui_payments[$key]);
                                array_values($ui_payments);
                                //print_r($ui_payments[$key]);
                            } else { // new payment found
                                // add to db
                            }


                            /* $data = array(
                                'purchase' => $purchase['id'],
                                'payment_mode' => $payment['mode'],
                                'amount' =>  $payment['amount'],
                                'date_time' => $payment['date_time'],
                                'transaction_id' =>  $payment['transaction_id'] ? trim($payment['transaction_id']) : NULL,
                                'reference_no' =>  $payment['reference_no'] ? trim($payment['reference_no']) : NULL,
                                'note' =>  $payment['note'] ? trim($payment['note']) : NULL
                            );
                            $this->form_validation->set_data($data);
                            $config = array(
                                array(
                                    'field' => 'amount',
                                    'label' => 'Amount',
                                    'rules' => 'trim|numeric|greater_than[0]'
                                ),
                                array(
                                    'field' => 'transaction_id',
                                    'label' => 'Transaction ID',
                                    'rules' => 'trim'
                                ),
                                array(
                                    'field' => 'reference_no',
                                    'label' => 'Reference No.',
                                    'rules' => 'trim'
                                ),
                                array(
                                    'field' => 'note',
                                    'label' => 'Note',
                                    'rules' => 'trim'
                                )
                            );
                            $this->form_validation->set_rules($config);
                            if ($this->form_validation->run() == FALSE) {
                                $this->db->trans_rollback();
                                die(json_encode(array('success' => false, 'errors' => $this->form_validation->error_array())));
                            }
                            $this->Purchase_model->create_purchase_sale_payment($data);
                            if ($this->db->affected_rows() != 1) {
                                $error = $this->db->error();
                                $this->db->trans_rollback();
                                die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                            }*/
                        }
                        //print_r($ui_payments);
                        $this->db->trans_commit();
                        echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully Updated Purchase Payment !'));
                        break;
                    default:
                        $_POST = $this->input->post('data');
                        $data = array(
                            'warehouse'         => $this->input->post('warehouse'),
                            'date'              => $this->input->post('date'),
                            'time'              => $this->input->post('date'),
                            'status'            => $this->input->post('purchase_status'),
                            'updated_by'        => $this->session->id,
                            'supplier'          => $this->input->post('supplier'),
                            'discount'          => $this->input->post('discount'),
                            'purchase_tax'      => $this->input->post('tax_rate') ?: NULL,
                            'shipping_charge'   => $this->input->post('shipping'),
                            'shipping_tax'      => $this->input->post('shipping_tax') ?: NULL,
                            'packing_charge'    => $this->input->post('packing'),
                            'packing_tax'       => $this->input->post('packing_tax') ?: NULL,
                            'round_off'         => $this->input->post('roundoff'),
                            'payment_note'      => $this->input->post('payment_note') ?: NULL,
                            'note'               => $this->input->post('note') ?: NULL,
                        );
                        $this->form_validation->set_data($data);
                        $config = array(
                            array(
                                'field' => 'warehouse',
                                'label' => 'Warehouse',
                                'rules' => 'required|trim|numeric|xss_clean',
                            )
                        );
                        $this->form_validation->set_rules($config);
                        if ($this->form_validation->run() == FALSE) { // check data fields
                            die(json_encode(array('success' => false, 'errors' => $this->form_validation->error_array())));
                        }
                        $changed_db1 = false;
                        $changed_db2 = false;
                        /************************************************************ */
                        $this->db->trans_begin();
                        $purchase_id = $this->input->post('id');
                        $this->Purchase_model->update_purchase($data, $purchase_id);
                        $error = $this->db->error();
                        if ($this->db->affected_rows() == 1 || $error['code'] == 0) { // // success or no change - update purchase
                            if ($this->db->affected_rows() == 1) { // data changed
                                $changed_db1 = true;
                            }
                            $products = $this->input->post('products'); // list of purchased products for updating (may contain new and edited or old deleted)
                            // its best to delete previous all from db then insert new data from request
                            /***************************************** */
                            $this->Purchase_model->delete_purchase_products(array('purchase' => $purchase_id));
                            /***************************************** */
                            foreach ($products as $product) { // add products
                                $data = array(
                                    'purchase' => $purchase_id,
                                    'product' => $product['id'],
                                    'quantity' =>  $product['quantity'],
                                    'unit' =>  $product['p_unit'],
                                    'unit_cost' => $product['cost'],
                                    'unit_discount' => $product['discount'],
                                    'tax_id' => $product['tax_id'] ?: null,
                                );
                                $this->Purchase_model->insert_purchase_product($data);
                                if ($this->db->affected_rows() != 1) {
                                    $error = $this->db->error();
                                    $this->db->trans_rollback();
                                    die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                }
                            }
                            $this->db->trans_commit();
                            echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully updated purchase !', 'location' => "admin/purchase/list"));
                        } else {
                            $this->db->trans_rollback();
                            echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                        }
                        /************************************************************ */
                        break;
                }
                break;
            case 'DELETE':
                $_POST = $this->input->post('data');
                $id = $this->input->post('id');
                $query = $this->Purchase_model->set_deleted_at(array('id' => $id, 'deleted_at' => NULL));
                $error = $this->db->error();
                if ($this->db->affected_rows() == 1) {
                    echo json_encode(array('success' => true, 'type' => 'success', 'id' => (int)$id, 'message' => 'Successfully deleted purchase !'));
                } else {
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                }
                break;
            default:
        }
        switch ($dropdown) { // dropdown jobs
            case 'warehouses':
                $result['data'] = $this->Warehouse_model->dropdown_active();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'suppliers':
                $result['data'] = $this->Supplier_model->dropdown_active();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'statuses':
                $result['data'] = $this->Status_model->getall_active_4_frontend();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'units':
                $result['data'] = $this->Unit_model->getall_active_4_frontend();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'tax_rates':
                $result['data'] = $this->Tax_model->dropdown_active();
                $result['success'] = true;
                echo json_encode($result);
                break;
            default:
        }
        switch ($search) { // dropdown jobs
            case 'product':
                $query["offset"] = 0;
                $query["limit"] = 100;
                $query["order_by"] = 'label';
                $query["order"] = 'asc';
                $query["query"] = $this->input->get('query');
                $query = $this->Purchase_model->suggestProdsForPurchase($query["query"], $query["offset"], $query["limit"], $query["order_by"], $query["order"]);
                $error = $this->db->error();
                if ($error['code'] == 0) {
                    echo json_encode(array('success' => true, 'type' => 'success', 'data' => $query->result()));
                } else {
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                }
                break;
            default:
        }
        switch ($job) { // dropdown jobs
            case 'purchase_data':
                $data = $this->Purchase_model->get_purchase_row_by_id(array('id' => $this->input->get('id'), 'deleted_at' => NULL));
                if ($data['id']) {
                    $data['products'] = $this->Purchase_model->get_purchase_products_by_purchase(array('pp.purchase' => (int)$this->input->get('id')));
                    $data['units'] = $this->Unit_model->getall_active_4_frontend();
                    $data['tax_rates'] = $this->Tax_model->dropdown_active();
                    echo json_encode(array('success' => true, 'type' => 'success', 'data' => $data));
                } else {
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Purchase not found !', 'location' => "admin/purchase/list"));
                }
                break;
            default:
        }
    }
}
