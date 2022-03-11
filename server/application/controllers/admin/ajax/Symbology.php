<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Symbology extends CI_Controller
{
    public function index() // view products
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('admin/Barcode_Symbology_model');
        $_POST = raw_input_to_post();
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET': // read
                switch ($action = $this->input->get('action')) {
                    case 'dropdown':
                        $result['data'] = $this->Barcode_Symbology_model->options();
                        $result['success'] = true;
                        echo json_encode($result);
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
                $error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method Found !');
                echo json_encode($error);
        }
    }
}
