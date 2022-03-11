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
                switch ($action = $this->input->get('action')) {
                    case 'getInfo':
                        $query = $this->Stock_adjustment_model->getInfo($this->input->get('id'));
                        $data['data'] = $query->result_array();
                        $data['success'] = true;
                        echo json_encode($data);
                        break;
                    case 'all':
                        $query["offset"] = 0;
                        $query["limit"] = 500;
                        $query["order_by"] = 'id';
                        $query["order"] = 'asc';
                        $query["search"] = NULL;
                        $query = $this->Product_model->listProducts($query["search"], $query["offset"], $query["limit"], $query["order_by"], $query["order"]);
                        $data['data'] = $query->result();
                        $data["filtered"] = $query->num_rows();
                        $data["records"] = $this->Product_model->totalRows();
                        die(json_encode($data));
                        break;
                    case 'suggest':
                        switch ($type = $this->input->get('type')) {
                            case 'getall': // ui auto complete
                                $query["offset"] = 0;
                                $query["limit"] = 10;
                                $query["order_by"] = 'label';
                                $query["order"] = 'asc';
                                $query["search"] = $this->input->post('search');
                                $query = $this->Product_model->suggestProdsForBarcode($query["search"], $query["offset"], $query["limit"], $query["order_by"], $query["order"]);
                                $error = $this->db->error();
                                if ($error['code'] == 0) {
                                    echo json_encode(array('success' => true, 'type' => 'success', 'data' => $query->result()));
                                } else {
                                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                                }
                                break;
                            case 'get':
                                $id = $this->input->post('search');
                                $query = $this->Product_model->suggestProdForBarcode($id);
                                $data = array('success' => true, 'type' => 'success', 'data' => $query->row());
                                echo json_encode($data);
                                break;
                            case 'auto':
                                $query["offset"] = 0;
                                $query["limit"] = NULL;
                                $query["order_by"] = 'label';
                                $query["order"] = 'asc';
                                $query["search"] = $this->input->post('search');
                                $query = $this->Product_model->addProdsForBarcode($query["search"], $query["offset"], $query["limit"], $query["order_by"], $query["order"]);
                                $error = $this->db->error();
                                if ($error['code'] == 0) {
                                    echo json_encode(array('success' => true, 'type' => 'success', 'data' => $query->result()));
                                } else {
                                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                                }
                                break;
                            default:
                                echo json_encode(array('success' => false, 'type' => 'warning', 'message' => 'Suggest Action Not Exist !'));
                                break;
                        }
                        break;
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
                    case 'validate':
                        $_GET = json_decode($this->input->get('data'), true);
                        $field = $this->input->get('field');
                        $value = $this->input->get('value');
                        $data = array();
                        $data[$field] = $value;
                        $this->form_validation->set_data($data);
                        switch ($field) {
                            case 'code':
                                $this->form_validation->set_rules(
                                    'code',
                                    'Code',
                                    'required|min_length[3]|max_length[200]|is_unique[' . TABLE_PRODUCT . '.code]|xss_clean|trim'
                                );
                                break;
                            case 'name':
                                $this->form_validation->set_rules(
                                    'name',
                                    'Name',
                                    'required|min_length[3]|max_length[200]|is_unique[' . TABLE_PRODUCT . '.name]|xss_clean|trim'
                                );
                                break;
                            case 'slug':
                                $this->form_validation->set_rules(
                                    'slug',
                                    'Slug',
                                    'required|min_length[3]|max_length[200]|is_unique[' . TABLE_PRODUCT . '.slug]|xss_clean|trim'
                                );
                                break;
                            default:
                                echo json_encode(array('success' => false, 'type' => 'warning', 'message' => 'Unknown Field Name !'));
                                break;
                        }
                        if ($this->form_validation->run() == FALSE) {
                            echo json_encode(array('success' => false, 'error' => $this->form_validation->error_array()[$field]));
                        } else {
                            echo json_encode(array('success' => true, 'message' => 'Perfect !'));
                        }
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
                    'stock_adj_note' => $this->input->post('stock_adj_note') ?: NULL,
                );
                $this->form_validation->set_data($data);
                $config = array(
                    array(
                        'field' => 'date',
                        'label' => 'Date',
                        'rules' => 'required|trim|max_length[10]'
                    ),
                    array(
                        'field' => 'ref_no',
                        'label' => 'Reference No.',
                        'rules' => 'trim|xss_clean'
                    ),
                    array(
                        'field' => 'stock_adj_note',
                        'label' => 'Adjustment Note',
                        'rules' => 'trim|xss_clean'
                    )
                );
                $this->form_validation->set_rules($config);
                if ($this->form_validation->run() == FALSE) { // check product data fields
                    echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
                } else if (empty($products)) {
                    $error = array('success' => false, 'type' => 'danger', 'error' => 'Please add some products !');
                    echo json_encode($error);
                } else {
                    // for table fields
                    $data_stock_adjustment['warehouse']     = $data['warehouse'];
                    $data_stock_adjustment['date']          = $data['date'];
                    $data_stock_adjustment['added_by']      = $this->session->id;
                    $data_stock_adjustment['reference_no']  = $data['ref_no'];
                    $data_stock_adjustment['note']          = $data['stock_adj_note'];
                    /******************** CHECK STOCK ADJUSTMENT PRODUCT DATA */
                    $products = array_reverse($products, false);
                    foreach ($products as $key => $product) {
                        $data['quantity' . $key] = $product['quantity'] ?: NULL;
                        $data['note' . $key] = $product['note'] ?: NULL;
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
                                        $alert['added'] = array('success' => true, 'type' => 'success', 'id' => $stock_adjustment_id, 'timeout' => '5000', 'message' => 'Successfully added new stock adjustment !', 'location' => "admin/stock_adjustment");
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
            default:
                $error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method Found !');
                echo json_encode($error);
        }
    }
}
