<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchase extends CI_Controller
{
    public function index() // view products
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('admin/Purchase_model');
        //$this->load->model('admin/Product_model');
        //$this->load->model('admin/Stock_adjustment_model');
        //$this->load->model('admin/Stock_adjustment_product_model');
        //$this->load->model('admin/Warehouse_model');
        $_POST = raw_input_to_post();
        $action = $this->input->get('action') ?: $this->input->post('action');
        $dropdown = $this->input->get('dropdown') ?: $this->input->post('dropdown');
        $search = $this->input->get('search') ?: $this->input->post('search');
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
                        $data["recordsTotal"] = 0;//$this->Product_model->datatable_recordsTotal();
                        $data["recordsFiltered"] = 0;//$this->Product_model->datatable_recordsFiltered($search);
                        $data["success"] = true;
                        //$data[ 'error' ] = '';
                        echo json_encode($data);
                        break;
                    case 'details':
                        break;
                    default:
                }
                break;
            case 'POST': // add new stock adjustment
                break;
            case 'PUT': // update stock adjustment
                break;
            default:
        }
        switch ($dropdown) { // dropdown jobs
            case 'warehouses':
                $result['data'] = $this->Warehouse_model->dropdown_active();
                $result['success'] = true;
                echo json_encode($result);
                break;
            default:
        }
        switch ($search) { // dropdown jobs
            case 'product':
                break;
            default:
        }
        die();
    }
}
