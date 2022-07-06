<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Stock_adjustment extends CI_Controller
{
    public function index() // view products
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('admin/Stock_adjustment_model');
        $this->load->model('admin/Stock_adjustment_product_model');
        $_POST = raw_input_to_post();
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET': // read
                switch ($this->input->get('action')) {
                    case 'datatable':
                        $data = array();
                        $limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
                        $order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
                        $order = $this->input->get('order')[0]['dir']; // order asc or desc
                        $search = $this->input->get('search')['value']; // search query
                        $offset = $this->input->get('start'); // start position
                        $query = $this->Stock_adjustment_model->listStockAdjustments($search, $offset, $limit, $order_by, $order);
                        //print_r($this->db->last_query());
                        $data['data'] = $query->result();
                        $data["draw"] = $this->input->get('draw'); // unique
                        $data["recordsTotal"] = $this->Stock_adjustment_model->totalRows();
                        $data["recordsFiltered"] = $this->Stock_adjustment_model->listStockAdjustments_FilteredCount($search);
                        $data["success"] = true;
                        //$data[ 'error' ] = '';
                        echo json_encode($data);
                        break;
                    case 'details':
                        $query = $this->Stock_adjustment_model->getInfo($this->input->get('id'));
                        $data['data'] = $query->result_array();
                        $data['success'] = true;
                        echo json_encode($data);
                        break;
                    default:
                        $error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Action !');
                        echo json_encode($error);
                }
                break;
            case 'POST': // add new stock adjustment
                /******************** CHECK STOCK ADJUSTMENT DATA */
                $_POST = $this->input->post('data');
                $products = $this->input->post('products');
                $data = array(
                    'warehouse' => $this->input->post('warehouse') ?: NULL,
                    'date' => $this->input->post('date') ?: NULL,
                    'ref_no' => $this->input->post('ref_no') ?: NULL,
                    'note' => $this->input->post('note') ?: NULL,
                );
                $this->form_validation->set_data($data);
                $config = array(
                    array(
                        'field' => 'date',
                        'label' => 'Date',
                        'rules' => 'required|trim|max_length[20]'
                    ),
                    array(
                        'field' => 'warehouse',
                        'label' => 'Warehouse',
                        'rules' => 'required|trim'
                    ),
                    array(
                        'field' => 'ref_no',
                        'label' => 'Reference No.',
                        'rules' => 'trim|xss_clean'
                    ),
                    array(
                        'field' => 'note',
                        'label' => 'Adjustment Note',
                        'rules' => 'trim|xss_clean'
                    )
                );
                $this->form_validation->set_rules($config);
                if ($this->form_validation->run() == FALSE) { // check adj data fields
                    echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
                } else if (empty($products)) {
                    $error = array('success' => false, 'type' => 'danger', 'error' => 'Please add some products !');
                    echo json_encode($error);
                } else {
                    // for table fields
                    $data_stock_adjustment['warehouse']     = $data['warehouse'];
                    $data_stock_adjustment['date']          = $data['date'];
                    $data_stock_adjustment['time']          = $data['date'];
                    $data_stock_adjustment['added_by']      = $this->session->id;
                    $data_stock_adjustment['reference_no']  = $data['ref_no'];
                    $data_stock_adjustment['note']          = $data['note'];
                    /******************** CHECK STOCK ADJUSTMENT PRODUCT DATA */
                    $products = array_reverse($products, false);
                    foreach ($products as $key => $product) {
                        $data['quantity' . $key] = $product['quantity'] ?: NULL;
                        $data['note' . $key] = isset($product['note']) ? $product['note'] : NULL;
                        $this->form_validation->set_data($data);
                        $this->form_validation->set_rules('quantity' . $key, 'Quantity', 'required|trim');
                        $this->form_validation->set_rules('note' . $key, 'Note', 'trim|alpha_numeric|max_length[10]');
                        $data_stock_adjustment_product[$key]['product'] = $product['id'];
                        $data_stock_adjustment_product[$key]['quantity'] = $data['quantity' . $key];
                        $data_stock_adjustment_product[$key]['note'] = $data['note' . $key];
                    }
                    //array_reverse($data_stock_adjustment_product, true);
                    if ($this->form_validation->run() == FALSE) {
                        echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
                    } else {
                        /******************** START DB */
                        $this->db->trans_begin();
                        $this->Stock_adjustment_model->create($data_stock_adjustment); // add stock adjustment
                        if ($this->db->affected_rows() == 1) { // success - add stock adjustment
                            $stock_adjustment_id = $this->db->insert_id();
                            foreach ($products as $key => $product) {
                                $data_stock_adjustment_product[$key]['stock_adjustment'] = $stock_adjustment_id;
                                $this->Stock_adjustment_product_model->create($data_stock_adjustment_product[$key]); // add each adjustment product data
                                if ($this->db->affected_rows() == 1) { // success - each adjustment product data
                                    if ($key === array_key_last($products)) {
                                        $this->db->trans_commit(); // all query ok
                                        $alert['added'] = array('success' => true, 'type' => 'success', 'id' => $stock_adjustment_id, 'timeout' => '5000', 'message' => 'Successfully added new stock adjustment !', 'location' => "admin/adjustment/list");
                                        $this->session->set_flashdata('alert', $alert);
                                        echo json_encode($alert['added']);
                                    }
                                } else {
                                    $error = $this->db->error();
                                    $this->db->trans_rollback();
                                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                                    break;
                                }
                            }
                        } else {
                            $error = $this->db->error();
                            $this->db->trans_rollback();
                            echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                        }
                    }
                }
                break;
            case 'PUT': // update stock adjustment
                /******************** CHECK STOCK ADJUSTMENT DATA */
                $_POST = $this->input->post('data');
                $products = $this->input->post('products');
                $data = array(
                    'warehouse' => $this->input->post('warehouse') ?: NULL,
                    'date' => $this->input->post('date') ?: NULL,
                    'time' => $this->input->post('time') ?: NULL,
                    'ref_no' => $this->input->post('ref_no') ?: NULL,
                    'note' => $this->input->post('note') ?: NULL,
                );
                $this->form_validation->set_data($data);
                $config = array(
                    array(
                        'field' => 'date',
                        'label' => 'Date',
                        'rules' => 'required|trim|max_length[20]'
                    ),
                    array(
                        'field' => 'warehouse',
                        'label' => 'Warehouse',
                        'rules' => 'required|trim'
                    ),
                    array(
                        'field' => 'ref_no',
                        'label' => 'Reference No.',
                        'rules' => 'trim|xss_clean'
                    ),
                    array(
                        'field' => 'note',
                        'label' => 'Adjustment Note',
                        'rules' => 'trim|xss_clean'
                    )
                );
                $this->form_validation->set_rules($config);
                if ($this->form_validation->run() == FALSE) { // check adj data fields
                    echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
                } else if (empty($products)) {
                    $error = array('success' => false, 'type' => 'danger', 'error' => 'Please add some products !');
                    echo json_encode($error);
                } else {
                    // for table fields
                    $data_stock_adjustment['warehouse']     = $data['warehouse'];
                    $data_stock_adjustment['date']          = $data['date'];
                    $data_stock_adjustment['time']          = $data['date'];
                    $data_stock_adjustment['added_by']      = $this->session->id;
                    $data_stock_adjustment['reference_no']  = $data['ref_no'];
                    $data_stock_adjustment['note']          = $data['note'];
                    /******************** CHECK STOCK ADJUSTMENT PRODUCT DATA (form) */
                    $products = array_reverse($products, false);
                    foreach ($products as $key => $product) {
                        $data['quantity' . $key] = $product['quantity'] ?: NULL;
                        $data['note' . $key] = isset($product['note']) ? $product['note'] : NULL;
                        $this->form_validation->set_data($data);
                        $this->form_validation->set_rules('quantity' . $key, 'Quantity', 'required|trim');
                        $this->form_validation->set_rules('note' . $key, 'Note', 'trim|alpha_numeric|max_length[10]');
                        $data_stock_adjustment_product[$key]['product'] = $product['id'];
                        $data_stock_adjustment_product[$key]['quantity'] = $data['quantity' . $key];
                        $data_stock_adjustment_product[$key]['note'] = $data['note' . $key] ?: NULL;
                    }
                    //array_reverse($data_stock_adjustment_product, true);
                    if ($this->form_validation->run() == FALSE) {
                        echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
                    } else {
                        /******************** START DB */
                        $this->db->trans_begin();
                        $changed_db1 = false;
                        $changed_db2 = false;
                        $this->Stock_adjustment_model->update($data_stock_adjustment, $this->input->post('id')); // update stock adjustment
                        $error = $this->db->error();
                        if ($this->db->affected_rows() == 1 || $error['code'] == 0) { // success or no change - update stock adjustment
                            if ($this->db->affected_rows() == 1) { // data changed
                                $changed_db1 = true;
                            }
                            $stock_adjustment_id = $this->input->post('id');
                            // get all prods with same adj id
                            $db_rows = $this->Stock_adjustment_product_model->get_products_where(array('stock_adjustment' => $stock_adjustment_id)); // get all prods with same adj id
                            /****** DELETE FROM DB OR UPDATE FIRST (existing on both) ***/
                            foreach ((array)$db_rows as $key => $db_row) {
                                if (array_search($db_row['product'], array_column($products, 'id')) !== FALSE) { // found on both - update
                                    $form_key = array_search($db_row['product'], array_column($products, 'id'));
                                    $this->Stock_adjustment_product_model->update($data_stock_adjustment_product[$form_key], $db_row['id']); // update existing
                                    if ($this->db->affected_rows() == 1) { // data changed on db - success
                                        $changed_db2 = true;
                                    } else { // error or not changed anything
                                        $error = $this->db->error();
                                        if ($error['code'] == 0) { // not changed anything
                                        } else { // error on updating
                                            $this->db->trans_rollback();
                                            die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                        }
                                    }
                                    //echo $this->db->last_query();
                                } else { // not on form, but on db - delete from db
                                    $this->Stock_adjustment_product_model->delete($db_row['id']);
                                    if ($this->db->affected_rows() == 1) { // data changed on db - success
                                        $changed_db2 = true;
                                    } else { // error or not changed anything
                                        $error = $this->db->error();
                                        $this->db->trans_rollback();
                                        die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                    }
                                }
                            }
                            /****** ADD TO DB (existing on form only) ***/
                            foreach ($products as $key => $product) {
                                $data_stock_adjustment_product[$key]['stock_adjustment'] = $stock_adjustment_id;
                                if (array_search($product['id'], array_column((array)$db_rows, 'product')) !== FALSE) { // found on both - update
                                    // don't do anthing, already done for existing
                                } else { // not on db, but on form - add to db
                                    $this->Stock_adjustment_product_model->create($data_stock_adjustment_product[$key]); // add stock adjustment product
                                    if ($this->db->affected_rows() == 1) { // data added to db - success
                                        $changed_db2 = true;
                                    } else { // error
                                        $error = $this->db->error();
                                        $this->db->trans_rollback();
                                        die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                    }
                                }
                            }
                            if ($changed_db1 == false && $changed_db2 == true) { // because db1 will not update updated time if db1 have no value update, but in db2
                                $this->Stock_adjustment_model->update_updated_at($stock_adjustment_id); // update stock adjustment updated at time
                                if ($this->db->affected_rows() == 1) { // time updated
                                    $changed_db1 = true;
                                } else { // error
                                    $error = $this->db->error();
                                    $this->db->trans_rollback();
                                    die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                }
                            }
                            $this->db->trans_commit();
                            if ($changed_db1 == true || $changed_db2 == true) {
                                $alert['added'] = array('success' => true, 'type' => 'success', 'id' => $stock_adjustment_id, 'timeout' => '5000', 'message' => 'Successfully updated stock adjustment !', 'location' => "admin/adjustment/list");
                            } else {
                                $alert['added'] = array('success' => true, 'type' => 'notice', 'id' => $stock_adjustment_id, 'timeout' => '5000', 'message' => $this->lang->line('no_data_changed_after_query'));
                            }
                            echo json_encode($alert['added']);
                        } else { // failed
                            $this->db->trans_rollback();
                            echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error 1 , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                        }
                    }
                }
                break;
            default:
                $error = array('success' => false, 'type' => 'danger', 'error' => 'Request Method Not Defined !');
                echo json_encode($error);
        }
    }
}
