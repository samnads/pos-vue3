<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pos extends CI_Controller
{
    public function index() // view products
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('admin/Pos_model');
        $this->load->model('admin/Product_model');
        $_POST = raw_input_to_post();
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET': // read
                switch ($action = $this->input->get('action')) {
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
                        $type = $this->input->get('type');
                        switch ($type) {
                            case 'c_sc_b': // filter by category, sub cat & brand
                                $query["offset"] = 0;
                                $query["limit"] = 20;
                                $query["order_by"] = 'p.id';
                                $query["order"] = 'desc';
                                $data = json_decode($this->input->get('data'), true);
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
                }
                break;
            case 'POST': // create
                break;
            case 'PUT': // update
                break;
            case 'DELETE': // delete
                break;
            default:
                $error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method !');
                echo json_encode($error);
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
