<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Customer_group extends CI_Controller
{
    public function index() // view products
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('admin/Cutomer_group_model');
        $_POST = raw_input_to_post();
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET': // read
                switch ($this->input->get('action')) {
                    case 'getall':
                        $query = $this->Cutomer_group_model->getall(array('cg.id', 'cg.name', 'cg.percentage'));
                        echo json_encode(array('success' => true, 'type' => 'success', 'data' => $query->result()));
                        break;
                    default:
                        $error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Action !');
                        echo json_encode($error);
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
}
