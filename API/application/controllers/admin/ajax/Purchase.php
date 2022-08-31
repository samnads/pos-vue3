<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchase extends CI_Controller
{
    public function index() // view products
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('admin/Purchase_model');
        $this->load->model('admin/Warehouse_model');
        $this->load->model('admin/Supplier_model');
        $this->load->model('admin/Status_model');
        $this->load->model('admin/Unit_model');
        $this->load->model('admin/Tax_model');
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
                        $data["recordsTotal"] = 0; //$this->Product_model->datatable_recordsTotal();
                        $data["recordsFiltered"] = 0; //$this->Product_model->datatable_recordsFiltered($search);
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
                $_POST = $this->input->post('data');
                $auto_id = $this->Purchase_model->get_AUTO_INCREMENT();
                $auto_id = trim(reduce_multiples(sprintf("REF-PUR-%05s", $auto_id), " "));
                $data = array(
                    'reference_id'      => $auto_id,
                    'warehouse'         => $this->input->post('warehouse'),
                    'date'              => $this->input->post('date'),
                    'time'              => $this->input->post('date'),
                    'status'            => $this->input->post('purchase_status'),
                    'created_by'        => $this->session->id,
                    'supplier'          => $this->input->post('supplier'),
                    'discount'          => $this->input->post('discount'),
                    'purchase_tax'      => $this->input->post('tax_rate') ?: NULL,
                    'shipping_charge'   => $this->input->post('shipping'),
                    'shipping_tax'      => $this->input->post('shipping_tax') ?: NULL,
                    'packing_charge'    => $this->input->post('packing'),
                    'packing_tax'       => $this->input->post('packing_tax') ?: NULL,
                    'round_off'         => $this->input->post('roundoff'),
                    'payment_note'      => $this->input->post('payment_note') ?: NULL,
                    'note'               => $this->input->post('note') ?: NULL,
                );
                $this->form_validation->set_data($data);
                $config = array(
                    array(
                        'field' => 'warehouse',
                        'label' => 'Warehouse',
                        'rules' => 'required|trim|numeric|xss_clean',
                    )
                );
                $this->form_validation->set_rules($config);
                if ($this->form_validation->run() == FALSE) { // check data fields
                    die(json_encode(array('success' => false, 'errors' => $this->form_validation->error_array())));
                }
                /************************************************************ */
                $this->db->trans_begin();
                $this->Purchase_model->insert_purchase($data);
                if ($this->db->affected_rows() == 1) { // success - add purchase
                    $purchase_id = $this->db->insert_id();
                    $products = $this->input->post('products'); // list of purchased products
                    foreach ($products as $product) { // add products
                        $data = array(
                            'purchase' => $purchase_id,
                            'product' => $product['id'],
                            'quantity' =>  $product['quantity'],
                            'unit' =>  $product['p_unit'],
                            'unit_cost' => $product['cost'],
                            'unit_discount' => $product['discount'],
                            'tax_id' => $product['tax_id'] ?: null,
                        );
                        $this->Purchase_model->insert_purchase_product($data);
                        if ($this->db->affected_rows() != 1) {
                            $error = $this->db->error();
                            $this->db->trans_rollback();
                            die(json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error"))));
                        }
                    }
                    $this->db->trans_commit();
                    echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'ok'));
                } else {
                    $error = $this->db->error();
                    $this->db->trans_rollback();
                    echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                }
                /************************************************************ */
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
            case 'suppliers':
                $result['data'] = $this->Supplier_model->dropdown_active();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'statuses':
                $result['data'] = $this->Status_model->getall_active_4_frontend();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'units':
                $result['data'] = $this->Unit_model->getall_active_4_frontend();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'tax_rates':
                $result['data'] = $this->Tax_model->dropdown_active();
                $result['success'] = true;
                echo json_encode($result);
                break;
            default:
        }
        switch ($search) { // dropdown jobs
            case 'product':
                $query["offset"] = 0;
                $query["limit"] = 100;
                $query["order_by"] = 'label';
                $query["order"] = 'asc';
                $query["query"] = $this->input->get('query');
                $query = $this->Purchase_model->suggestProdsForPurchase($query["query"], $query["offset"], $query["limit"], $query["order_by"], $query["order"]);
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
}
