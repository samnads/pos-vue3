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
                        $data['products'] = $this->Purchase_model->getPurchaseProductsDetails(array('purchase' => (int)$this->input->get('id')));
                        $data['purchase'] = $this->Purchase_model->getPurchaseDetails(array('purchase' => (int)$this->input->get('id')));
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
                            'payment_note'      => trim($this->input->post('payment_note')) ?: NULL,
                            'note'              => trim($this->input->post('note')) ?: NULL,
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
                                    'product' => $product['product'],
                                    'quantity' =>  $product['quantity'],
                                    'unit' =>  $product['p_unit'],
                                    'unit_cost' => $product['unit_cost'],
                                    'unit_discount' => $product['unit_discount'],
                                    'tax_id' => $product['tax_id'] ?: null,
                                    'created_by'        => $this->session->id
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
                            $this->Purchase_model->create_purchase_payment($data);
                            if ($this->db->affected_rows() != 1) {
                                $error = $this->db->error();
                                $this->db->trans_rollback();
                                die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                            }
                        }
                        $this->db->trans_commit();
                        echo json_encode(array('success' => true, 'type' => 'success', 'message' =>'Successfully Added Purchase Payment !', 'location' => "admin/purchase/list"));
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
                        $changed_purchase = false; // purchase
                        $changed_payment = false; // purchase payment
                        // get all payments for the purchase
                        $db_payments = $this->Purchase_model->getPurchasePayments(array('pp.purchase' => (int)$purchase['id']));
                        if (!$db_payments) { // error
                            $error = $this->db->error();
                            $this->db->trans_rollback();
                            echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                        } else {
                            $this->db->trans_begin();
                            $existing_ids = array(); // id exist in both -  ui & db (for updating)
                            $new_pays = array(); // exist in ui only - new (for adding)
                            $delete_ids = array(); // id exist in db only -  for deleting
                            foreach ($ui_payments as $ui_payment) { // loop through ui payments - update existing id, remove from ui array
                                // check and get same from db
                                $db_payment = $this->Purchase_model->get_purchase_payment_row(array('pp.id' => $ui_payment['id'], 'pp.purchase' => (int)$purchase['id']));
                                if (isset($db_payment['id'])) { // same id exist in db
                                    array_push($existing_ids, $db_payment['id']); // add to existing array
                                    // update on db using unique id
                                    /* prepare for db data */
                                    unset($ui_payment['purchase']);
                                    unset($ui_payment['id']);
                                    unset($ui_payment['payment_mode_name']);
                                    $ui_payment['payment_mode'] = $ui_payment['mode'];
                                    unset($ui_payment['mode']);
                                    $ui_payment['transaction_id'] = trim($ui_payment['transaction_id']) ? trim($ui_payment['transaction_id']) : NULL;
                                    $ui_payment['reference_no'] = trim($ui_payment['reference_no']) ? trim($ui_payment['reference_no']) : NULL;
                                    $ui_payment['note'] = trim($ui_payment['note']) ? trim($ui_payment['note']) : NULL;
                                    $this->Purchase_model->update_purchase_payment($ui_payment, array('id' => $db_payment['id'], 'purchase' => (int)$purchase['id'])); // UPDATE pay row
                                    if ($this->db->affected_rows() == 1) {
                                        $changed_payment = true;
                                        // data change found so change updated_by
                                        $ui_payment['updated_by'] = $this->session->id;
                                        $this->Purchase_model->update_purchase_payment($ui_payment, array('id' => $db_payment['id'], 'purchase' => (int)$purchase['id'])); // UPDATE pay row
                                        if ($this->db->affected_rows() == 1) { // updated updated_by
                                            //
                                        } else if ($this->db->affected_rows() == 0) { // same updated_by found
                                            //
                                        } else {
                                            $error = $this->db->error();
                                            $this->db->trans_rollback();
                                            die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                        }
                                    } else if ($this->db->affected_rows() == 0) {
                                        // nothing changed
                                    } else { // error
                                        $error = $this->db->error();
                                        $this->db->trans_rollback();
                                        die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                    }
                                } else { // new payment found
                                    // add to db
                                    /* prepare for db data - FOR BATCH ADDING  */
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
                            $affected_rows = $this->Purchase_model->create_purchase_payment_batch($new_pays); // ADD new pays (batch add)
                            if ($affected_rows >= 1) {
                                $changed_payment = true;
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
                                $this->Purchase_model->set_deleted_at_purchase_payment_ids($delete_ids); // DELETE not exist pays
                            }
                            //print_r($this->db->last_query());
                            if ($this->db->affected_rows() >= 1) {
                                $changed_payment = true;
                            } else if ($this->db->affected_rows() == 0) {
                                // nothing changed
                            } else {
                                $error = $this->db->error();
                                $this->db->trans_rollback();
                                die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                            }
                            // payments updated
                            /********************* update payment note ****************/
                            $this->Purchase_model->update_purchase(array('payment_note' => trim($this->input->post('payment_note')) ? trim($this->input->post('payment_note')) : NULL), $purchase['id']);
                            if ($this->db->affected_rows() == 1) { // payment note changed
                                $changed_purchase = true;
                                $this->Purchase_model->update_purchase(array('updated_by' => $this->session->id), $purchase['id']);
                                if ($this->db->affected_rows() == 1) { // updated updated_by
                                } else if ($this->db->affected_rows() == 0) { // same updated_by found
                                    //
                                } else {
                                    $error = $this->db->error();
                                    $this->db->trans_rollback();
                                    die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                }
                            } else if ($this->db->affected_rows() == 0) {
                                // nothing changed
                            } else { // error
                                $error = $this->db->error();
                                $this->db->trans_rollback();
                                die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                            }
                            //
                            if ($changed_payment == true) {
                                $this->db->trans_commit();
                                echo json_encode(array('success' => true, 'type' => 'success', 'message' =>'Successfully Updated Purchase Payment !', 'location' => "admin/purchase/list"));
                            }
                            else if ($changed_purchase == true) {
                                $this->db->trans_commit();
                                echo json_encode(array('success' => true, 'type' => 'success', 'message' =>'Successfully Updated Purchase Payment Note !', 'location' => "admin/purchase/list"));
                            } else {
                                $this->db->trans_rollback();
                                echo json_encode(array('success' => true, 'type' => 'notice', 'timeout' => '5000', 'message' => $this->lang->line('no_data_changed_after_query')));
                            }
                        }
                        break;
                    default: // update purchase
                        $_POST = $this->input->post('data');
                        /****************************************************** */ // update only possible with 0 return record
                        $data = $this->Purchase_model->get_purchase_row_by_id(array('purchase' => $this->input->post('id')));
                        if ($data['total_return'] > 0) {
                            die(json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Not allowed (return record found) !')));
                        }
                        /************************************************************ */ // first update product table
                        $this->db->trans_begin();
                        $db_products_updated = false; // purchase product
                        $db_purchase_updated = false; // purchase
                        $purchase_id = $this->input->post('id');
                        $ui_products = $this->input->post('products'); // list of purchased products for updating (may contain new and edited or old deleted)
                        // compare one by one and take action
                        $db_products = $this->Purchase_model->getPurchaseProductsDetails(array('purchase' => $purchase_id)); // all products for this purchase from db
                        if (!$db_products) { // nothing retrieved means error
                            $error = $this->db->error();
                            $this->db->trans_rollback();
                            die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                        }
                        $existing_ids = array(); // id exist in both -  ui & db (for updating)
                        $new_products = array(); // exist in ui only - new (for adding)
                        $delete_ids = array(); // id exist in db only -  for deleting
                        foreach ($ui_products as $ui_product) { // loop through ui products - update existing id, remove from ui array
                            // check and get same from db
                            $db_product = $this->Purchase_model->get_purchase_product_row(array('id' => $ui_product['id'], 'purchase' => $purchase_id));
                            if (isset($db_product['id'])) { // same ui id exist in db
                                array_push($existing_ids, $db_product['id']); // add to existing array
                                // update on db using unique id
                                /* prepare for db data */
                                $ui_product['unit'] = $ui_product['p_unit'];
                                unset($ui_product['id']);
                                unset($ui_product['code']);
                                unset($ui_product['name']);
                                unset($ui_product['p_unit']);
                                unset($ui_product['db_cost']);
                                unset($ui_product['unit_name']);
                                unset($ui_product['unit_code']);
                                unset($ui_product['tax_rate']);
                                unset($ui_product['hsn']);
                                unset($ui_product['discount']);
                                unset($ui_product['db_unit']);
                                unset($ui_product['brand']);
                                unset($ui_product['brand_code']);
                                unset($ui_product['brand_name']);
                                unset($ui_product['category']);
                                unset($ui_product['category_name']);
                                unset($ui_product['exp_date']);
                                unset($ui_product['label']);
                                unset($ui_product['mfg_date']);
                                unset($ui_product['mrp']);
                                unset($ui_product['symbology']);
                                unset($ui_product['tax_code']);
                                unset($ui_product['tax_code']);
                                unset($ui_product['tax_method']);
                                unset($ui_product['tax_name']);
                                unset($ui_product['thumbnail']);
                                unset($ui_product['type']);
                                $this->Purchase_model->update_purchase_product($ui_product, array('id' => (int)$db_product['id'])); // UPDATE product row
                                if ($this->db->affected_rows() == 1) { // updated found and updated but not changed updated_by, so change again
                                    $db_products_updated = true;
                                    $ui_product['updated_by'] = $this->session->id;
                                    $this->Purchase_model->update_purchase_product($ui_product, array('id' => (int)$db_product['id'])); // UPDATE product row updated_by
                                    if ($this->db->affected_rows() == 1) { // updated updated_by
                                    } else if ($this->db->affected_rows() == 0) { // same updated_by found
                                        //
                                    } else {
                                        $error = $this->db->error();
                                        $this->db->trans_rollback();
                                        die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                    }
                                } else if ($this->db->affected_rows() == 0) { // no data changed on both
                                    //
                                } else {
                                    $error = $this->db->error();
                                    $this->db->trans_rollback();
                                    die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                }
                            } else { // new product found
                                // add to db
                                /* prepare for db data */
                                $ui_product['purchase'] = $purchase_id;
                                $ui_product['unit'] = $ui_product['p_unit'];
                                unset($ui_product['id']);
                                unset($ui_product['code']);
                                unset($ui_product['name']);
                                unset($ui_product['p_unit']);
                                unset($ui_product['db_cost']);
                                unset($ui_product['unit_name']);
                                unset($ui_product['unit_code']);
                                unset($ui_product['tax_rate']);
                                unset($ui_product['hsn']);
                                unset($ui_product['discount']);
                                unset($ui_product['db_unit']);
                                unset($ui_product['brand']);
                                unset($ui_product['brand_code']);
                                unset($ui_product['brand_name']);
                                unset($ui_product['category']);
                                unset($ui_product['category_name']);
                                unset($ui_product['exp_date']);
                                unset($ui_product['label']);
                                unset($ui_product['mfg_date']);
                                unset($ui_product['mrp']);
                                unset($ui_product['symbology']);
                                unset($ui_product['tax_code']);
                                unset($ui_product['tax_code']);
                                unset($ui_product['tax_method']);
                                unset($ui_product['tax_name']);
                                unset($ui_product['thumbnail']);
                                unset($ui_product['type']);
                                $ui_product['created_by'] = $this->session->id;
                                $new_products[] = $ui_product;
                            }
                        }
                        $affected_rows = $this->Purchase_model->create_purchase_product_batch($new_products); // ADD new products (batch add)
                        if ($affected_rows >= 1) {
                            $db_products_updated = true;
                        } else if ($affected_rows == 0) {
                            //
                        } else {
                            $error = $this->db->error();
                            $this->db->trans_rollback();
                            die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                        }
                        // DELETE ui removed products
                        foreach ($db_products as $db_product) { // loop through db products - delete that not exist in ui products
                            // check with existing_ids
                            if (array_search($db_product['id'], $existing_ids) !== false) { // same exist in ui
                                // don't delete from db
                            } else {
                                // delete from db
                                array_push($delete_ids, $db_product['id']); // save ids for delete
                            }
                        }
                        if (count($delete_ids) > 0) { // products need to be set deleted on db
                            $this->Purchase_model->set_deleted_at_purchase_product_ids($delete_ids); // DELETE not exist products
                            if ($this->db->affected_rows() >= 1) {
                                $db_products_updated = true;
                            } else if ($this->db->affected_rows() == 0) {
                                //
                            } else {
                                $error = $this->db->error();
                                $this->db->trans_rollback();
                                die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                            }
                        }
                        // product update completed !
                        /******************************************************************************* */ // update purchase table start
                        $data = array(
                            'warehouse'         => $this->input->post('warehouse'),
                            'date'              => $this->input->post('date'),
                            'time'              => $this->input->post('date'),
                            'status'            => $this->input->post('purchase_status'),
                            'supplier'          => $this->input->post('supplier'),
                            'discount'          => $this->input->post('discount'),
                            'purchase_tax'      => $this->input->post('tax_rate') ?: NULL,
                            'shipping_charge'   => $this->input->post('shipping'),
                            'shipping_tax'      => $this->input->post('shipping_tax') ?: NULL,
                            'packing_charge'    => $this->input->post('packing'),
                            'packing_tax'       => $this->input->post('packing_tax') ?: NULL,
                            'round_off'         => $this->input->post('roundoff'),
                            'payment_note'      => trim($this->input->post('payment_note')) ?: NULL,
                            'note'              => trim($this->input->post('note')) ?: NULL,
                        );
                        if ($db_products_updated == true) {
                            $data['updated_by'] = $this->session->id;
                        }
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
                        $this->Purchase_model->update_purchase($data, $purchase_id);
                        if ($this->db->affected_rows() == 1) { // updated found and updated but not changed updated_by, so change again
                            $db_purchase_updated = true;
                            $data['updated_by'] = $this->session->id;
                            $this->Purchase_model->update_purchase($data, $purchase_id); // UPDATE
                            if ($this->db->affected_rows() == 1) { // updated updated_by
                            } else if ($this->db->affected_rows() == 0) { // same updated_by found
                                //
                            } else {
                                $error = $this->db->error();
                                $this->db->trans_rollback();
                                die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                            }
                        } else if ($this->db->affected_rows() == 0) { // no changed on row
                            //
                        } else {
                            $error = $this->db->error();
                            $this->db->trans_rollback();
                            die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                        }
                        /******************************************************************************* */
                        if (
                            $db_purchase_updated == true || $db_products_updated == true
                        ) {
                            $this->db->trans_commit();
                            echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully Updated Purchase !', 'location' => "admin/purchase/list"));
                        } else {
                            $this->db->trans_rollback();
                            echo json_encode(array('success' => true, 'type' => 'notice', 'timeout' => '5000', 'message' => $this->lang->line('no_data_changed_after_query')));
                        }
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
            case 'product_for_add':
            case 'product_for_edit':
                $query["offset"] = 0;
                $query["limit"] = 100;
                $query["order_by"] = 'label';
                $query["order"] = 'asc';
                $query["query"] = $this->input->get('query');
                $query = $this->Purchase_model->suggestProdsForNewPurchase($query["query"], $query["offset"], $query["limit"], $query["order_by"], $query["order"]);
                $error = $this->db->error();
                if ($error['code'] == 0) {
                    echo json_encode(array('success' => true, 'type' => 'success', 'data' => $query->result()));
                } else {
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                }
                break;
            default:
        }
        switch ($job) {
            case 'purchase_data':
                $where = array('purchase' => $this->input->get('id'));
                $data = $this->Purchase_model->get_purchase_row_by_id($where);
                if ($data['total_return'] > 0) {
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Not allowed (return record found) !', 'location' => "admin/purchase/list"));
                } elseif ($data['id']) {
                    $data['products'] = $this->Purchase_model->get_purchase_products_by_purchase($where);
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
