<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchase_return extends CI_Controller
{
    public function index() // view products
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('admin/Purchase_return_model');
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
                        $query = $this->Purchase_return_model->datatable_data($search, $offset, $limit, $order_by, $order);
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
                        $data['products'] = $this->Purchase_return_model->getPurchaseProductsDetails(array('pp.purchase' => (int)$this->input->get('id')));
                        $data['purchase'] = $this->Purchase_return_model->getPurchaseDetails(array('p.id' => (int)$this->input->get('id')));
                        echo json_encode(array('success' => true, 'type' => 'success', 'data' => $data));
                        break;
                    case 'payment_details':
                        $data = array();
                        $data['payments'] = $this->Purchase_return_model->getPurchasePayments(array('pp.purchase' => (int)$this->input->get('id')));
                        echo json_encode(array('success' => true, 'type' => 'success', 'data' => $data));
                        break;
                    default:
                        die(json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Action not found !')));
                }
                break;
            case 'POST': // add new purchase return
                $_POST = $this->input->post('data');
                switch ($action) {
                    case 'create':
                        /************************************************** */
                        $data = $this->Purchase_return_model->get_purchase_row_by_id(array('purchase' => $this->input->post('purchase')));
                        if ($data['id'] && $data['status'] == 22) {
                        } else if ($data['id'] && $data['status'] != 22) {
                            die(json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Purchase not received for return !')));
                        } else {
                            die(json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Purchase not found !', 'location' => "admin/purchase/list")));
                        }
                        /************************************************** */
                        $auto_id = $this->Purchase_return_model->get_AUTO_INCREMENT();
                        $auto_id = trim(reduce_multiples(sprintf("REF-RET-PUR-%05s", $auto_id), " "));
                        $data = array(
                            'reference_id'      => $auto_id,
                            'purchase'         => $this->input->post('purchase'),
                            'date'              => $this->input->post('date'),
                            'time'              => $this->input->post('date'),
                            'status'            => $this->input->post('return_status'),
                            'created_by'        => $this->session->id,
                            'discount'          => $this->input->post('discount'),
                            'return_tax'      => $this->input->post('tax_rate') ?: NULL,
                            'shipping_charge'   => $this->input->post('shipping'),
                            'shipping_tax'      => $this->input->post('shipping_tax') ?: NULL,
                            'packing_charge'    => $this->input->post('packing'),
                            'packing_tax'       => $this->input->post('packing_tax') ?: NULL,
                            'round_off'         => $this->input->post('roundoff'),
                            'payment_note'      => $this->input->post('payment_note') ?: NULL,
                            'note'               => $this->input->post('note') ?: NULL,
                        );
                        $this->form_validation->set_data($data);
                        $config = array(array(
                            'field' => 'purchase',
                            'label' => 'Purchase',
                            'rules' => 'required|trim|numeric|xss_clean',
                        ));
                        $this->form_validation->set_rules($config);
                        if ($this->form_validation->run() == FALSE) { // check data fields
                            die(json_encode(array('success' => false, 'errors' => $this->form_validation->error_array())));
                        }
                        /************************************************************ */
                        $this->db->trans_begin();
                        $this->Purchase_return_model->insert_purchase_return($data);
                        if ($this->db->affected_rows() == 1) { // success - add purchase
                            $purchase_id = $this->db->insert_id();
                            $products = $this->input->post('products'); // list of purchased products
                            foreach ($products as $product) { // add products
                                $data = array(
                                    'return_purchase' => $purchase_id,
                                    'purchase_product' => $product['purchase_product'],
                                    'quantity' =>  $product['quantity']
                                );
                                $this->Purchase_return_model->insert_purchase_return_product($data);
                                if ($this->db->affected_rows() != 1) {
                                    $error = $this->db->error();
                                    $this->db->trans_rollback();
                                    die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                }
                            }
                            $this->db->trans_commit();
                            echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully added new return purchase !', 'location' => "admin/purchase/list"));
                        } else {
                            $error = $this->db->error();
                            $this->db->trans_rollback();
                            echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                        }
                        /************************************************************ */
                        break;
                    case 'payment':
                        $return_purchase = $this->input->post('return_purchase');
                        $payments = $this->input->post('payments');
                        $this->Purchase_return_model->update_return_purchase(array('payment_note' => $this->input->post('payment_note')), $return_purchase['id']);
                        $this->db->trans_begin();
                        foreach ($payments as $payment) { // add payments
                            $data = array(
                                'return_purchase' => $return_purchase['id'],
                                'payment_mode' => $payment['mode'],
                                'amount' =>  $payment['amount'],
                                'date_time' => $payment['date_time'],
                                'transaction_id' =>  $payment['transaction_id'] ? trim($payment['transaction_id']) : NULL,
                                'reference_no' =>  $payment['reference_no'] ? trim($payment['reference_no']) : NULL,
                                'note' =>  $payment['note'] ? trim($payment['note']) : NULL,
                                'created_by' => $this->session->id

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
                            $this->Purchase_return_model->create_return_purchase_payment($data);
                            if ($this->db->affected_rows() != 1) {
                                $error = $this->db->error();
                                $this->db->trans_rollback();
                                die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                            }
                        }
                        $this->db->trans_commit();
                        echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully Added Return Purchase Payment !'));
                        break;
                    default:
                }
                break;
            case 'PUT': // update purchase payment
                switch ($action) {
                    case 'update_payment':
                        $_POST = $this->input->post('data');
                        $purchase = $this->input->post('purchase');
                        $ui_payments = $this->input->post('payments');
                        $changed_db1 = false; // purchase
                        $changed_db2 = false; // purchase payment
                        //$this->db->trans_begin();
                        // update payment note
                        $this->Purchase_return_model->update_purchase(array('payment_note' => $this->input->post('payment_note') ?: NULL), $purchase['id']);
                        if ($this->db->affected_rows() == 1) {
                            $changed_db1 = true;
                        } else if ($this->db->affected_rows() == 0) {
                            //
                        } else {
                            $error = $this->db->error();
                            $this->db->trans_rollback();
                            die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                        }
                        // get all payment for the purchase
                        $db_payments = $this->Purchase_return_model->getPurchasePayments(array('pp.purchase' => (int)$purchase['id']));
                        if (!$db_payments) {
                            $error = $this->db->error();
                            $this->db->trans_rollback();
                            die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                        }
                        $existing_ids = array(); // id exist in both -  ui & db (for updating)
                        $new_pays = array(); // exist in ui only - new (for adding)
                        $delete_ids = array(); // id exist in db only -  for deleting
                        foreach ($ui_payments as $ui_payment) { // loop through ui payments - update existing id, remove from ui array
                            // check and get same from db
                            $db_payment = $this->Purchase_return_model->get_purchase_payment_row(array('pp.id' => $ui_payment['id'], 'pp.purchase' => (int)$purchase['id']));
                            if ($db_payment['id']) { // same id exist in db
                                array_push($existing_ids, $db_payment['id']); // add to existing array
                                // update on db using unique id
                                /* prepare for db data */
                                unset($ui_payment['purchase']);
                                unset($ui_payment['id']);
                                unset($ui_payment['payment_mode_name']);
                                $ui_payment['payment_mode'] = $ui_payment['mode'];
                                unset($ui_payment['mode']);
                                $ui_payment['updated_by'] = $this->session->id;
                                $this->Purchase_return_model->update_purchase_payment($ui_payment, array('id' => $db_payment['id'], 'purchase' => (int)$purchase['id'])); // UPDATE pay row
                                if ($this->db->affected_rows() == 1) {
                                    $changed_db2 = true;
                                } else if ($this->db->affected_rows() == 0) {
                                    //
                                } else {
                                    $error = $this->db->error();
                                    $this->db->trans_rollback();
                                    die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                }
                            } else { // new payment found
                                // add to db
                                /* prepare for db data */
                                $ui_payment['purchase'] = $purchase['id'];
                                unset($ui_payment['id']);
                                $ui_payment['payment_mode'] = $ui_payment['mode'];
                                unset($ui_payment['mode']);
                                $ui_payment['transaction_id'] = $ui_payment['transaction_id'] ?: NULL;
                                $ui_payment['reference_no'] = $ui_payment['reference_no'] ?: NULL;
                                $ui_payment['note'] = $ui_payment['note'] ?: NULL;
                                $ui_payment['created_by'] = $this->session->id;
                                $new_pays[] = $ui_payment;
                            }
                        }
                        $affected_rows = $this->Purchase_return_model->create_purchase_payment_batch($new_pays); // ADD new pays (batch add)
                        if ($affected_rows >= 1) {
                            $changed_db2 = true;
                        } else if ($affected_rows == 0) {
                            //
                        } else {
                            $error = $this->db->error();
                            $this->db->trans_rollback();
                            die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                        }
                        // DELETE ui reomved payment
                        foreach ($db_payments as $db_payment) { // loop through db payments - delete not that not exist in ui pays
                            // check with existing_ids
                            if (array_search($db_payment['id'], $existing_ids) !== false) { // same exist in ui
                                // don't delete from db
                            } else {
                                // delete from db
                                array_push($delete_ids, $db_payment['id']); // save ids for delete
                            }
                        }
                        if (count($delete_ids) > 0) {
                            $this->Purchase_return_model->set_deleted_at_purchase_payment_ids($delete_ids); // DELETE not exist pays
                        }
                        //print_r($this->db->last_query());
                        if ($this->db->affected_rows() >= 1) {
                            $changed_db2 = true;
                        } else if ($this->db->affected_rows() == 0) {
                            //
                        } else {
                            $error = $this->db->error();
                            $this->db->trans_rollback();
                            die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                        }

                        if ($changed_db1 == true || $changed_db2 == true) {
                            echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully Updated Purchase Payment !'));
                        } else {
                            echo json_encode(array('success' => true, 'type' => 'notice', 'timeout' => '5000', 'message' => $this->lang->line('no_data_changed_after_query')));
                        }
                        break;
                    default: // update purchase return
                        $_POST = $this->input->post('data');
                        $data = array(
                            'date'              => $this->input->post('date'),
                            'time'              => $this->input->post('date'),
                            'status'            => $this->input->post('return_status'),
                            'updated_by'        => $this->session->id,
                            'discount'          => $this->input->post('discount'),
                            'return_tax'      => $this->input->post('tax_rate') ?: NULL,
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
                                'field' => 'status',
                                'label' => 'Status',
                                'rules' => 'required|trim|numeric|xss_clean',
                            )
                        );
                        $this->form_validation->set_rules($config);
                        if ($this->form_validation->run() == FALSE) { // check data fields
                            die(json_encode(array('success' => false, 'errors' => $this->form_validation->error_array())));
                        }
                        /************************************************************ */
                        $this->db->trans_begin();
                        $return_purchase_id = $this->input->post('id');
                        $this->Purchase_return_model->update_return_purchase($data, $return_purchase_id);
                        $error = $this->db->error();
                        if ($this->db->affected_rows() == 1 || $error['code'] == 0) { // success or no change - update return purchase
                            if ($this->db->affected_rows() == 1) { // data changed
                            }
                            $products = $this->input->post('products'); // list of purchased products for updating (may contain new and edited or old deleted)
                            // its best to delete previous all from db then insert new data from request
                            /***************************************** */
                            $this->Purchase_return_model->delete_return_purchase_products_SET_TIME(array('return_purchase' => $return_purchase_id, 'deleted_at' => NULL));
                            if ($this->db->affected_rows() <= 0) {
                                $error = $this->db->error();
                                $this->db->trans_rollback();
                                die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                            }
                            /***************************************** */
                            foreach ($products as $product) { // add products
                                $data = array(
                                    'return_purchase' => $return_purchase_id,
                                    'purchase_product' => $product['id'],
                                    'quantity' =>  $product['quantity'],
                                );
                                $this->Purchase_return_model->insert_purchase_return_product($data);
                                if ($this->db->affected_rows() != 1) {
                                    $error = $this->db->error();
                                    $this->db->trans_rollback();
                                    die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                }
                            }
                            $this->db->trans_commit();
                            echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully updated return purchase !', 'location' => "admin/purchase_return/list"));
                        } else {
                            $this->db->trans_rollback();
                            echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                        }
                        /************************************************************ */
                }
                break;
            case 'DELETE':
                $_POST = $this->input->post('data');
                $id = $this->input->post('id');
                $query = $this->Purchase_return_model->set_deleted_at(array('id' => $id, 'deleted_at' => NULL));
                $error = $this->db->error();
                if ($this->db->affected_rows() == 1) {
                    echo json_encode(array('success' => true, 'type' => 'success', 'id' => (int)$id, 'message' => 'Successfully deleted return purchase !'));
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
            case 'product_for_add':
                $query["offset"] = 0;
                $query["limit"] = 100;
                $query["order_by"] = 'label';
                $query["order"] = 'asc';
                $query["query"] = $this->input->get('query');
                $data = $this->Purchase_return_model->get_purchase_row_by_id(array('purchase' => $this->input->get('purchase')));
                $where = array('purchase' => $data['id']);
                $query = $this->Purchase_return_model->suggestProdsForReturnAdd($query["query"], $query["offset"], $query["limit"], $query["order_by"], $query["order"], $where);
                $error = $this->db->error();
                if ($error['code'] == 0) {
                    echo json_encode(array('success' => true, 'type' => 'success', 'data' => $query->result()));
                } else {
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                }
                break;
            case 'product_for_edit':
                $query["offset"] = 0;
                $query["limit"] = 100;
                $query["order_by"] = 'label';
                $query["order"] = 'asc';
                $query["query"] = $this->input->get('query');
                $data = $this->Purchase_return_model->get_purchase_return_row_by_id(array('return_purchase' => $this->input->get('purchase_return')));
                $where = array('purchase' => $data['purchase'], 'return_purchase' => $data['id']);
                $query = $this->Purchase_return_model->suggestProdsForReturnEdit($query["query"], $query["offset"], $query["limit"], $query["order_by"], $query["order"], $where);
                $error = $this->db->error();
                if ($error['code'] == 0) {
                    echo json_encode(array('success' => true, 'type' => 'success', 'data' => $query->result()));
                } else {
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                }
                break;
            default:
        }
        switch ($job) { // jobs
            case 'purchase_with_return_data_for_add':
                $data = $this->Purchase_return_model->get_purchase_row_by_id(array('purchase' => $this->input->get('id')));
                if ($data['id'] && $data['status'] == 22) {
                    $data['products'] = $this->Purchase_return_model->get_return_purchase_products_for_add(array('purchase' => (int)$this->input->get('id')));
                    $data['units'] = $this->Unit_model->getall_active_4_frontend();
                    $data['tax_rates'] = $this->Tax_model->dropdown_active();
                    echo json_encode(array('success' => true, 'type' => 'success', 'data' => $data));
                } else if ($data['id'] && $data['status'] != 22) {
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Purchase not received for return !', 'location' => "admin/purchase/list"));
                } else {
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Purchase not found !', 'location' => "admin/purchase/list"));
                }
                break;
            case 'purchase_with_return_data_for_edit':
                $data = $this->Purchase_return_model->get_purchase_return_row_by_id(array('return_purchase' => $this->input->get('id')));
                if ($data['id']) {
                    $data['products'] = $this->Purchase_return_model->get_return_purchase_products_for_edit(array('return_purchase' => (int)$this->input->get('id'), 'purchase' => $data['purchase']));
                    $data['units'] = $this->Unit_model->getall_active_4_frontend();
                    $data['tax_rates'] = $this->Tax_model->dropdown_active();
                    echo json_encode(array('success' => true, 'type' => 'success', 'data' => $data));
                } else {
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Purchase return not found !', 'location' => "admin/purchase_return/list"));
                }
                break;
            default:
        }
    }
}
