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
            case 'GET': // read
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
                            'status' => 20,
                            'date_time' => '',
                            'warehouse' => 20,
                            'customer' => $customer['id'],
                            'created_by' => $this->session->id,
                            'cart_discount' => $this->input->post('discount'),
                            'shipping_charge' => $this->input->post('shipping'),
                            'packing_charge' => $this->input->post('packing'),
                            'round_off' => $this->input->post('roundoff'),
                        );
                        $this->Pos_model->create_pos_sale($data);
                        if ($this->db->affected_rows() == 1) {
                            $pos_sale_id = $this->db->insert_id();
                            $this->db->trans_commit();
                            echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Pos Sale Added !'));
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
