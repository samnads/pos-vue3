<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Common extends CI_Controller
{
    public function index() // view products
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('admin/Common_model');
        $_POST = raw_input_to_post();
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET': // read
                switch ($this->input->get('action')) {
                    case 'gender':
                        $data = $this->Common_model->getGenders();
                        echo json_encode(array('success' => true, 'type' => 'success', 'data' => $data));
                        break;
                    case 'role':
                        $data = $this->Common_model->getRoles();
                        echo json_encode(array('success' => true, 'type' => 'success', 'data' => $data));
                        break;
                    case 'status':
                        $data = $this->Common_model->getStatuses($this->input->get('type'));
                        echo json_encode(array('success' => true, 'type' => 'success', 'data' => $data));
                        break;
                    default:
                        echo json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Unknown GET Action !'));
                }
                break;
            case 'POST': // create
                break;
            case 'PUT': // update
                break;
            case 'DELETE': // delete
                break;
            default:
                echo json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method !'));
        }
    }
}
