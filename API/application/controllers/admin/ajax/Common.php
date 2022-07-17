<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Common extends CI_Controller
{
    public function index() // view products
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('admin/Common_model');
        $this->load->model('admin/Product_Type_model');
        $this->load->model('admin/Barcode_Symbology_model');
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
                    case 'dropdown_product_types':
                        $result['data'] = $this->Product_Type_model->getAll();
                        $result['success'] = true;
                        echo json_encode($result);
                        break;
                    case 'dropdown_barcode_symbologies':
                        $result['data'] = $this->Barcode_Symbology_model->options();
                        $result['success'] = true;
                        echo json_encode($result);
                        break;
                    case 'module_permission':
                        $this->db->select('
                        mp.module		as module,
                        mp.permission	as permission,
                        mp.checked      as checked,
		                m.name		    as module_name,
                        m.description   as module_description,
                        p.name		    as permission_name,
                        p.usage		    as usage');
                        $this->db->from(TABLE_MODULE_PERMISSION . ' mp');
                        $this->db->join(TABLE_MODULE . '		m',    'm.id=mp.module', 'left');
                        $this->db->join(TABLE_PERMISSION . '	p',    'p.id=mp.permission', 'left');
                        $query = $this->db->get();
                        //die($this->db->last_query());
                        $results = $query->result_array();
                        $new = array();
                        foreach ($results as $objKey => $object) { // group roles by modules
                            $new[$object['module']][] = $object;
                        }
                        echo json_encode(array('success' => true, 'type' => 'success', 'data' => $new));
                        break;
                    case 'test_query':
                        $this->db->select('*');
                        $this->db->from(TABLE_CATEGORY_NEW . ' c');
                        $query = $this->db->get();
                        //die($this->db->last_query());
                        echo json_encode(array('success' => true, 'type' => 'success', 'data' => $query->result_array()));
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
