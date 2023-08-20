<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pos extends CI_Controller
{
    public function index() // view products
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('admin/Pos_model');
        $this->load->model('admin/Product_model');
        $this->load->model('admin/Customer_model');
        $_POST = raw_input_to_post();
        $action = $this->input->get('action') ?: $this->input->post('action');
        $search = $this->input->get('search') ?: $this->input->post('search');
        $dropdown = $this->input->get('dropdown') ?: $this->input->post('dropdown');
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                switch ($action) {
                    case 'datatable':
                        $data = array();
                        $limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
                        $order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
                        $order = $this->input->get('order')[0]['dir']; // order asc or desc
                        $search = $this->input->get('search')['value']; // search query
                        $offset = $this->input->get('start'); // start position
                        $query = $this->Pos_model->datatable_data($search, $offset, $limit, $order_by, $order);
                        $data['data'] = $query->result();
                        $data["draw"] = $this->input->get('draw'); // unique
                        $data["recordsTotal"] = 0;
                        $data["recordsFiltered"] = 0;
                        $data["success"] = true;
                        //$data[ 'error' ] = '';
                        echo json_encode($data);
                        break;
                    default:
                }
                break;
            case 'POST': // create
                switch ($action) {
                    case 'create': // search products for add to cart
                        $_POST = $this->input->post('data');
                        $customer = $this->input->post('customer');
                        $products = $this->input->post('products');
                        $payments = $this->input->post('payments');
                        /************************************************************ */
                        $this->db->trans_begin();
                        $data = array(
                            'status' => 20, //20 - completed, 21 - returned
                            'warehouse' => 20,
                            'customer' => $customer['id'],
                            'created_by' => $this->session->id,
                            'cart_discount' => $this->input->post('discount'),
                            'shipping_charge' => $this->input->post('shipping'),
                            'packing_charge' => $this->input->post('packing'),
                            'round_off' => $this->input->post('roundoff'),
                            'payment_note' => trim($this->input->post('payment_note')) ?: NULL,
                            'sale_note' => trim($this->input->post('sale_note')) ?: NULL,
                        );
                        $this->Pos_model->create_pos_sale($data);
                        if ($this->db->affected_rows() == 1) {
                            $pos_sale_id = $this->db->insert_id();
                            foreach ($products as $product) { // add products
                                $data = array(
                                    'pos_sale' => $pos_sale_id,
                                    'product' => $product['id'],
                                    'quantity' =>  $product['quantity'],
                                    'unit_price' => $product['price'],
                                    'auto_discount' => $product['auto_discount'],
                                    'discount' => $product['discount'],
                                    'tax_id' => $product['tax_id'] ?: null,
                                );
                                $this->Pos_model->create_pos_sale_product($data);
                                if ($this->db->affected_rows() != 1) {
                                    $error = $this->db->error();
                                    $this->db->trans_rollback();
                                    die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                }
                            }
                            foreach ($payments as $payment) { // add payments
                                $data = array(
                                    'pos_sale' => $pos_sale_id,
                                    'payment_mode' => $payment['mode'],
                                    'amount' =>  $payment['amount'],
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
                                /***************************/
                                $this->Pos_model->create_pos_sale_payment($data);
                                if ($this->db->affected_rows() != 1) {
                                    $error = $this->db->error();
                                    $this->db->trans_rollback();
                                    die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                                }
                            }
                            $this->db->trans_commit();
                            echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully Added POS Sale !'));
                        } else {
                            $error = $this->db->error();
                            $this->db->trans_rollback();
                            echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                        }
                        /************************************************************ */
                        //die(json_encode(array('success' => true, 'type' => 'success', 'message' => 'Success !')));
                        break;
                    default:
                        die(json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Unknown Action !')));
                }
                break;
            case 'PUT': // update
                break;
            case 'DELETE': // delete
                break;
            default:
                die(json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method !')));
        }
        switch ($search) { // dropdown jobs
            case 'product':
                $query["offset"] = 0;
                $query["limit"] = 10;
                $query["order_by"] = 'label';
                $query["order"] = 'asc';
                $query["query"] = $this->input->get('query');
                $query = $this->Pos_model->suggestProdsForPosCart($query["query"], $query["offset"], $query["limit"], $query["order_by"], $query["order"]);
                $error = $this->db->error();
                if ($error['code'] == 0) {
                    echo json_encode(array('success' => true, 'type' => 'success', 'data' => $query->result()));
                } else {
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                }
                break;
            case 'customer':
                $query["offset"] = 0;
                $query["limit"] = 10;
                $query["order_by"] = 'id';
                $query["order"] = 'asc';
                $query["search"] = $this->input->get('query');
                $query = $this->Customer_model->suggestCustomerForPos($query["search"], $query["offset"], $query["limit"], $query["order_by"], $query["order"]);
                $error = $this->db->error();
                if ($error['code'] == 0) {
                    echo json_encode(array('success' => true, 'type' => 'success', 'data' => $query->result_array()));
                } else {
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                }
                break;
            default:
        }
        switch ($dropdown) { // dropdown jobs
            case 'payment_modes':
                $query = $this->Pos_model->getPaymentModes(null, null);
                $error = $this->db->error();
                if ($error['code'] == 0) {
                    echo json_encode(array('success' => true, 'type' => 'success', 'data' => $query->result()));
                } else {
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                }
                break;
            default:
        }
    }










    /*$post = $this->input->raw_input_stream;
        $post = json_decode($post);
        $_POST = json_decode(json_encode($post), true);
        switch ($action = $this->input->post('action')) {
            case 'autocomplete': // search products for add to cart
                $type = $this->input->post('type');
                switch ($type) {
                    case 'product': // search product
                        $query["offset"] = 0;
                        $query["limit"] = 10;
                        $query["order_by"] = 'label';
                        $query["order"] = 'asc';
                        $query["search"] = $this->input->post('search');
                        $query = $this->Pos_model->suggestProdsForPos($query["search"], $query["offset"], $query["limit"], $query["order_by"], $query["order"]);
                        $error = $this->db->error();
                        if ($error['code'] == 0) {
                            echo json_encode(array('success' => true, 'type' => 'success', 'data' => $query->result()));
                        } else {
                            echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                        }
                        break;
                    default:
                        echo json_encode(array('success' => false, 'type' => 'warning', 'message' => 'Suggest Action Not Exist !', 'timeout' => 30000));
                        break;
                }
                break;
            case 'filter':
                $type = $this->input->post('type');
                switch ($type) {
                    case 'c_sc_b': // filter by category, sub cat & brand
                        $query["offset"] = 0;
                        $query["limit"] = 20;
                        $query["order_by"] = 'p.id';
                        $query["order"] = 'desc';
                        $query["id"] = $this->input->post('id');
                        $data = $_POST['data'];
                        //$data = $this->input->post('data');
                        $query["where"] = array('p.category' => $data['category']);
                        $query["where_in_sc"] = $data['subcategories'];
                        $query["where_in_b"] = $data['brands'];
                        $query = $this->Pos_model->get_products_where_in($query["where"], $query["where_in_sc"], $query["where_in_b"], $query["offset"], $query["limit"], $query["order_by"], $query["order"]);
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
            case 'customer_groups':
                $columns = array('cg.id', 'cg.name', 'cg.percentage');
                $query = $this->Pos_model->get_customer_groups($columns);
                echo json_encode($query->result());
                break;
            default:
                echo json_encode(array('success' => false, 'type' => 'warning', 'message' => 'Invalid / No Action !'));
        }
    }*/
}
