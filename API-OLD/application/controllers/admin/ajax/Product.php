<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Product extends CI_Controller
{
    public function index() // view products
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('admin/Product_model');
        $this->load->model('admin/Product_Type_model');
        $this->load->model('admin/Stock_adjustment_model');
        $this->load->model('admin/Stock_adjustment_product_model');
        $this->load->model('admin/Product_stock_model');
        $this->load->model('admin/Barcode_Symbology_model');
        $this->load->model('admin/Brand_model');
        $this->load->model('admin/Category_model');
        $this->load->model('admin/Unit_model');
        $this->load->model('admin/Tax_model');
        $this->load->model('admin/Warehouse_model');
        $_POST = raw_input_to_post();
        $action = $this->input->get('action') ?: $this->input->post('action');
        $dropdown = $this->input->get('dropdown') ?: $this->input->post('dropdown');
        if (!$dropdown) {
            switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
                case 'GET':
                    switch ($action) {
                        case 'datatable':
                            $data = array();
                            $limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
                            $order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
                            $order = $this->input->get('order')[0]['dir']; // order asc or desc
                            $search = $this->input->get('search')['value']; // search query
                            $offset = $this->input->get('start'); // start position
                            $query = $this->Product_model->datatable_data($search, $offset, $limit, $order_by, $order);
                            $data['data'] = $query->result();
                            $data["draw"] = $this->input->get('draw'); // unique
                            $data["recordsTotal"] = $this->Product_model->datatable_recordsTotal();
                            $data["recordsFiltered"] = $this->Product_model->datatable_recordsFiltered($search);
                            $data["success"] = true;
                            //$data[ 'error' ] = '';
                            echo json_encode($data);
                            break;
                        case 'details':
                            $data['data'] = $this->Product_model->getInfo($this->input->get('id'));
                            $data['success'] = true;
                            echo json_encode($data);
                            break;
                        default:
                    }
                    break;
                case 'POST':
                    switch ($this->input->post('action')) {
                        case 'create':
                            $_POST = $this->input->post('data');
                            $data = array(
                                'type' => $this->input->post('type'),
                                'code' => $this->input->post('code'),
                                'symbology' => $this->input->post('symbology'),
                                'name' => $this->input->post('name'),
                                'slug' => $this->input->post('slug'),
                                'weight' => $this->input->post('weight') ?: NULL,
                                'category' => $this->input->post('category'),
                                'brand' => $this->input->post('brand') ?: NULL,
                                'mrp' => $this->input->post('mrp') ?: NULL,
                                'unit' => $this->input->post('unit'),
                                'p_unit' => $this->input->post('p_unit') ?: NULL,
                                's_unit' => $this->input->post('s_unit') ?: NULL,
                                'cost' => $this->input->post('cost') ?: NULL,
                                'markup' => $this->input->post('markup') ?: NULL,
                                'price' => $this->input->post('tag_price'),
                                'auto_discount' => $this->input->post('auto_discount'),
                                'mfg_date' => $this->input->post('mfg_date') ? date('Y-m-d', strtotime($this->input->post('mfg_date'))) : NULL,
                                'exp_date' => $this->input->post('exp_date') ? date('Y-m-d', strtotime($this->input->post('exp_date'))) : NULL,
                                'tax_method' => $this->input->post('tax_method'),
                                'tax_rate' => $this->input->post('tax_rate') ?: NULL,
                                'alert_quantity' => is_numeric($this->input->post('alert_quantity')) ? $this->input->post('alert_quantity') : NULL,
                                'alert' => is_numeric($this->input->post('alert_quantity')) ? '1' : '0',
                                //
                                'pos_sale' => $this->input->post('pos_sale') ? '1' : '0',
                                'pos_min_sale_qty' => $this->input->post('pos_min_sale_qty'),
                                'pos_max_sale_qty' => $this->input->post('pos_max_sale_qty'),
                                'pos_sale_note' => $this->input->post('pos_sale_note') ? '1' : '0',
                                'pos_custom_discount' => $this->input->post('pos_custom_discount') ? '1' : '0',
                                'pos_custom_tax' => $this->input->post('pos_custom_tax') ? '1' : '0',
                                'pos_data_field_1' => $this->input->post('pos_data_field_1') ?: NULL,
                                'pos_data_field_2' => $this->input->post('pos_data_field_2') ?: NULL,
                                'pos_data_field_3' => $this->input->post('pos_data_field_3') ?: NULL,
                                'pos_data_field_4' => $this->input->post('pos_data_field_4') ?: NULL,
                                'pos_data_field_5' => $this->input->post('pos_data_field_5') ?: NULL,
                                'pos_data_field_6' => $this->input->post('pos_data_field_6') ?: NULL
                            );
                            $this->form_validation->set_data($data);
                            $config = array(
                                array(
                                    'field' => 'type',
                                    'label' => 'Product Type',
                                    'rules' => 'required|trim|numeric|xss_clean',
                                ),
                                array(
                                    'field' => 'code',
                                    'label' => 'Product Code',
                                    'rules' => 'required|trim|min_length[3]|max_length[255]|is_unique[' . TABLE_PRODUCT . '.code]|xss_clean|regex_match[/^[a-zA-Z0-9 -&]+$/]'
                                ),
                                array(
                                    'field' => 'symbology',
                                    'label' => 'Barcode Symbology',
                                    'rules' => 'required|trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 'name',
                                    'label' => 'Product Name',
                                    'rules' => 'required|trim|min_length[3]|max_length[50]|is_unique[' . TABLE_PRODUCT . '.name]|xss_clean|regex_match[/^[a-zA-Z0-9._ -]+$/]'
                                ),
                                array(
                                    'field' => 'slug',
                                    'label' => 'URL Slug',
                                    'rules' => 'required|trim|min_length[3]|max_length[50]|is_unique[' . TABLE_PRODUCT . '.slug]|xss_clean|regex_match[/^[a-z0-9-]+$/]'
                                ),
                                array(
                                    'field' => 'weight',
                                    'label' => 'Product Weight',
                                    'rules' => 'trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 'category',
                                    'label' => 'Product Category',
                                    'rules' => 'required|trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 'brand',
                                    'label' => 'Brand Name',
                                    'rules' => 'trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 'mrp',
                                    'label' => 'Product MRP',
                                    'rules' => 'trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 'unit',
                                    'label' => 'Product Unit',
                                    'rules' => 'required|trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 'p_unit',
                                    'label' => 'Purchase Unit',
                                    'rules' => 'trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 's_unit',
                                    'label' => 'Sale Unit',
                                    'rules' => 'trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 'cost',
                                    'label' => 'Cost',
                                    'rules' => 'trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 'markup',
                                    'label' => 'Profit Margin',
                                    'rules' => 'trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 'price',
                                    'label' => 'Price',
                                    'rules' => 'required|trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 'auto_discount',
                                    'label' => 'Auto Discount',
                                    'rules' => 'trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 'mfg_date',
                                    'label' => 'Mfg. Date',
                                    'rules' => 'trim|xss_clean'
                                ),
                                array(
                                    'field' => 'exp_date',
                                    'label' => 'Exp. Date',
                                    'rules' => 'trim|xss_clean'
                                ),
                                array(
                                    'field' => 'tax_method',
                                    'label' => 'Tax Method',
                                    'rules' => 'trim|min_length[1]|max_length[1]|xss_clean'
                                ),
                                array(
                                    'field' => 'tax_rate',
                                    'label' => 'Tax Rate',
                                    'rules' => 'trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 'alert',
                                    'label' => 'Alert',
                                    'rules' => 'trim|numeric|xss_clean'
                                ),
                                array(
                                    'field' => 'alert_quantity',
                                    'label' => 'Alert Quantity',
                                    'rules' => 'trim|numeric|xss_clean'
                                ),
                                //
                                array(
                                    'field' => 'pos_data_field_1',
                                    'label' => 'POS Data Field 1',
                                    'rules' => 'trim|max_length[30]|xss_clean'
                                ),
                                array(
                                    'field' => 'pos_data_field_2',
                                    'label' => 'POS Data Field 2',
                                    'rules' => 'trim|max_length[30]|xss_clean'
                                ),
                                array(
                                    'field' => 'pos_data_field_3',
                                    'label' => 'POS Data Field 3',
                                    'rules' => 'trim|max_length[30]|xss_clean'
                                ),
                                array(
                                    'field' => 'pos_data_field_4',
                                    'label' => 'POS Data Field 4',
                                    'rules' => 'trim|max_length[30]|xss_clean'
                                ),
                                array(
                                    'field' => 'pos_data_field_5',
                                    'label' => 'POS Data Field 5',
                                    'rules' => 'trim|max_length[30]|xss_clean'
                                ),
                                array(
                                    'field' => 'pos_data_field_6',
                                    'label' => 'POS Data Field 6',
                                    'rules' => 'trim|max_length[30]|xss_clean'
                                )
                            );
                            $this->form_validation->set_rules($config);
                            if ($this->form_validation->run() == FALSE) { // check product data fields
                                die(json_encode(array('success' => false, 'errors' => $this->form_validation->error_array())));
                            }
                            // for table fields
                            $data_product = $data;
                            /* --------------------------------------------- */
                            $data = array(
                                'ref_no' => $this->input->post('ref_no') ?: NULL,
                                'stock_adj_note' => $this->input->post('stock_adj_note') ?: NULL,
                                'warehouse' => $this->input->post('warehouse')
                            );
                            $this->form_validation->set_data($data);
                            $config = array(
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
                            if ($this->form_validation->run() == FALSE) { // check stock adj. fields
                                die(json_encode(array('success' => false, 'errors' => $this->form_validation->error_array())));
                            }
                            // for table fields
                            $data_stock_adjustment['warehouse']     = $data['warehouse'];
                            $data_stock_adjustment['added_by']      = $this->session->id;
                            $data_stock_adjustment['reference_no']  = $data['ref_no'];
                            $data_stock_adjustment['note']          = $data['stock_adj_note'];
                            /* --------------------------------------------- */
                            $data = array(
                                'stock_adj_count' => $this->input->post('stock_adj_count') ?: NULL
                            );
                            $this->form_validation->set_data($data);
                            $config = array(
                                array(
                                    'field' => 'stock_adj_count',
                                    'label' => 'Adjustment Quantity',
                                    'rules' => 'trim|numeric|xss_clean'
                                )
                            );
                            $this->form_validation->set_rules($config);
                            if ($this->form_validation->run() == FALSE) { // check stock adj. prod. fields
                                die(json_encode(array('success' => false, 'errors' => $this->form_validation->error_array())));
                            }
                            // for table fields
                            $data_stock_adjustment_product['quantity']   = $data['stock_adj_count'];
                            /* -------------------------------------------------------- */
                            $this->db->trans_begin();
                            $this->Product_model->create($data_product); // add product
                            if ($this->db->affected_rows() == 1) { // success - add product
                                $product_id = $this->db->insert_id();
                                if ($data_stock_adjustment_product['quantity']) { // do stock adjust
                                    $this->Stock_adjustment_model->create_with_new_product($data_stock_adjustment); // add product adjustment
                                    if ($this->db->affected_rows() == 1) { // success - product adjustment
                                        $stock_adjustment_id = $this->db->insert_id();
                                        $data_stock_adjustment_product['stock_adjustment'] = $stock_adjustment_id;
                                        $data_stock_adjustment_product['product'] = $product_id;
                                        $this->Stock_adjustment_product_model->create($data_stock_adjustment_product); // add adjustment product data
                                        if ($this->db->affected_rows() == 1) { // success - adjustment product data
                                            $this->Product_stock_model->new($product_id, $data_stock_adjustment['warehouse'], $data_stock_adjustment_product['quantity']); // add product stock
                                            if ($this->db->affected_rows() == 1) { // success - add product stock
                                                $this->db->trans_commit(); // all query ok
                                                echo json_encode(array('success' => true, 'type' => 'success', 'id' => $product_id, 'timeout' => '5000', 'message' => 'Successfully added new product <strong><em>' . $data_product['name'] . '</strong></em> !<br>[ Opening Stock Added ]', 'location' => "admin/product"));
                                            } else {
                                                $error = $this->db->error();
                                                $this->db->trans_rollback();
                                                echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                                            }
                                        } else {
                                            $error = $this->db->error();
                                            $this->db->trans_rollback();
                                            echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                                        }
                                    } else {
                                        $error = $this->db->error();
                                        $this->db->trans_rollback();
                                        echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                                    }
                                } else {
                                    $this->db->trans_commit(); // all query ok
                                    echo json_encode(array('success' => true, 'type' => 'success', 'id' => $product_id, 'timeout' => '5000', 'message' => 'Successfully added new product <strong><em>' . $data_product['name'] . '</strong></em> !', 'location' => "admin/product"));
                                }
                            } else {
                                $error = $this->db->error();
                                $this->db->trans_rollback();
                                echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                            }
                            break;
                        default:
                    }
                    break;
                case 'PUT':
                    $_POST = $this->input->post('data');
                    $data = array(
                        'type' => $this->input->post('type'),
                        'code' => $this->input->post('code'),
                        'symbology' => $this->input->post('symbology'),
                        'name' => $this->input->post('name'),
                        'slug' => $this->input->post('slug'),
                        'weight' => $this->input->post('weight') ?: NULL,
                        'category' => $this->input->post('category'),
                        'brand' => $this->input->post('brand') ?: NULL,
                        'mrp' => $this->input->post('mrp') ?: NULL,
                        'unit' => $this->input->post('unit'),
                        'p_unit' => $this->input->post('p_unit') ?: NULL,
                        's_unit' => $this->input->post('s_unit') ?: NULL,
                        'cost' => $this->input->post('cost') ?: NULL,
                        'markup' => $this->input->post('markup') ?: NULL,
                        'price' => $this->input->post('tag_price'),
                        'auto_discount' => $this->input->post('auto_discount'),
                        'mfg_date' => $this->input->post('mfg_date') ? date('Y-m-d', strtotime($this->input->post('mfg_date'))) : NULL,
                        'exp_date' => $this->input->post('exp_date') ? date('Y-m-d', strtotime($this->input->post('exp_date'))) : NULL,
                        'tax_method' => $this->input->post('tax_method'),
                        'tax_rate' => $this->input->post('tax_rate') ?: NULL,
                        'alert_quantity' => is_numeric($this->input->post('alert_quantity')) ? $this->input->post('alert_quantity') : NULL,
                        'alert' => is_numeric($this->input->post('alert_quantity')) ? '1' : '0',
                        //
                        'pos_sale' => $this->input->post('pos_sale') ? '1' : '0',
                        'pos_min_sale_qty' => $this->input->post('pos_min_sale_qty'),
                        'pos_max_sale_qty' => $this->input->post('pos_max_sale_qty'),
                        'pos_sale_note' => $this->input->post('pos_sale_note') ? '1' : '0',
                        'pos_custom_discount' => $this->input->post('pos_custom_discount') ? '1' : '0',
                        'pos_custom_tax' => $this->input->post('pos_custom_tax') ? '1' : '0',
                        'pos_data_field_1' => $this->input->post('pos_data_field_1') ?: NULL,
                        'pos_data_field_2' => $this->input->post('pos_data_field_2') ?: NULL,
                        'pos_data_field_3' => $this->input->post('pos_data_field_3') ?: NULL,
                        'pos_data_field_4' => $this->input->post('pos_data_field_4') ?: NULL,
                        'pos_data_field_5' => $this->input->post('pos_data_field_5') ?: NULL,
                        'pos_data_field_6' => $this->input->post('pos_data_field_6') ?: NULL
                    );
                    //$data['type'] = 'error';
                    $this->form_validation->set_data($data);
                    $config = array(
                        array(
                            'field' => 'type',
                            'label' => 'Product Type',
                            'rules' => 'required|trim|numeric|xss_clean',
                        ),
                        array(
                            'field' => 'code',
                            'label' => 'Product Code',
                            'rules' => 'required|trim|min_length[3]|max_length[40]|xss_clean|regex_match[/^[a-zA-Z0-9 -&]+$/]'
                        ),
                        array(
                            'field' => 'symbology',
                            'label' => 'Barcode Symbology',
                            'rules' => 'required|trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'name',
                            'label' => 'Product Name',
                            'rules' => 'required|trim|min_length[3]|max_length[50]|xss_clean|regex_match[/^[a-zA-Z0-9._ -]+$/]'
                        ),
                        array(
                            'field' => 'slug',
                            'label' => 'URL Slug',
                            'rules' => 'required|trim|min_length[3]|max_length[50]|xss_clean|regex_match[/^[a-z0-9-]+$/]'
                        ),
                        array(
                            'field' => 'weight',
                            'label' => 'Product Weight',
                            'rules' => 'trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'category',
                            'label' => 'Product Category',
                            'rules' => 'required|trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'sub_category',
                            'label' => 'Product Sub Category',
                            'rules' => 'trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'brand',
                            'label' => 'Brand Name',
                            'rules' => 'trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'mrp',
                            'label' => 'Product MRP',
                            'rules' => 'trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'unit',
                            'label' => 'Product Unit',
                            'rules' => 'required|trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'p_unit',
                            'label' => 'Purchase Unit',
                            'rules' => 'trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 's_unit',
                            'label' => 'Sale Unit',
                            'rules' => 'trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'is_auto_cost',
                            'label' => 'Auto Cost',
                            'rules' => 'trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'cost',
                            'label' => 'Cost',
                            'rules' => 'trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'price',
                            'label' => 'Price',
                            'rules' => 'required|trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'auto_discount',
                            'label' => 'Auto Discount',
                            'rules' => 'trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'mfg_date',
                            'label' => 'Mfg. Date',
                            'rules' => 'trim|xss_clean'
                        ),
                        array(
                            'field' => 'exp_date',
                            'label' => 'Exp. Date',
                            'rules' => 'trim|xss_clean'
                        ),
                        array(
                            'field' => 'tax_method',
                            'label' => 'Tax Method',
                            'rules' => 'trim|min_length[1]|max_length[1]|xss_clean'
                        ),
                        array(
                            'field' => 'tax_rate',
                            'label' => 'Tax Rate',
                            'rules' => 'trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'alert',
                            'label' => 'Alert',
                            'rules' => 'trim|numeric|xss_clean'
                        ),
                        array(
                            'field' => 'alert_quantity',
                            'label' => 'Alert Quantity',
                            'rules' => 'trim|numeric|xss_clean'
                        )
                    );
                    $this->form_validation->set_rules($config);
                    if ($this->form_validation->run() == FALSE) {
                        echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
                    } else {
                        //$data['manual_error'] = 'error';
                        $this->Product_model->update($this->input->post('db')['id'], $data);
                        $error = $this->db->error();
                        if ($this->db->affected_rows() == 1) {
                            $alert['added'] = array('success' => true, 'type' => 'success', 'id' => (int)$this->input->post('db')['id'], 'timeout' => '5000', 'message' => 'Successfully updated product <strong><i>' . $data['name'] . '</strong></i> !', 'location' => "admin/product/list");
                            $this->session->set_flashdata('alert', $alert);
                            echo json_encode($alert['added']);
                        } else if ($error['code'] == 0) {
                            echo json_encode(array('success' => true, 'type' => 'notice', 'id' => (int)$this->input->post('db')['id'], 'timeout' => '5000', 'message' => $this->lang->line('no_data_changed_after_query')));
                        } else {
                            echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                        }
                    }
                    break;
                case 'DELETE': // delete
                    if (isset($this->input->post('data')['bulk'])) { // multi row delete
                        $ids = array();
                        foreach ($this->input->post('data')['rows'] as $key => $value) {
                            array_push($ids, $value['id']);
                        }
                        $query = $this->Product_model->multi_set_deleted_at($ids, array('deletable' => NULL, 'deleted_at' => NULL,));
                        $error = $this->db->error();
                        if ($this->db->affected_rows() >= 1) {
                            echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Product' . (($this->db->affected_rows() > 1) ? 's' : '') . '(' . $this->db->affected_rows() . ' of ' . count($ids) . ') successfully deleted !'));
                        } else {
                            echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                        }
                    } else { // single row delete
                        $_POST = $this->input->post('data');
                        $id = $this->input->post('id');
                        $query = $this->Product_model->set_deleted_at(array('id' => $id, 'deletable' => NULL));
                        $error = $this->db->error();
                        if ($this->db->affected_rows() == 1) {
                            echo json_encode(array('success' => true, 'type' => 'success', 'id' => (int)$id, 'message' => 'Successfully deleted product ' . $this->input->post('name') . ' !'));
                        } else {
                            echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
                        }
                    }
                    break;
                default:
            }
        }
        switch ($dropdown) { // dropdown jobs
            case 'product_types':
                $result['data'] = $this->Product_Type_model->dropdown_active();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'barcode_symbologies':
                $result['data'] = $this->Barcode_Symbology_model->dropdown_active();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'brands':
                $result['data'] = $this->Brand_model->dropdown_active();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'categories':
                $result['data'] = $this->Category_model->dropdown_categories();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'categories_subs':
                $result['data'] = $this->Category_model->dropdown_categories_subs($this->input->get('id'));
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'categories_level_0':
                $result['data'] = $this->Category_model->dropdown_level_0_active();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'categories_level_1':
                $result['data'] = $this->Category_model->dropdown_level_1_active($this->input->get('id'));
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'base_units':
                $result['data'] = $this->Unit_model->dropdown_main_active();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'sub_units':
                $id = $this->input->get('id');
                $result['data'] = $this->Unit_model->dropdown_sub_active($id);
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'tax_rates':
                $result['data'] = $this->Tax_model->dropdown_active();
                $result['success'] = true;
                echo json_encode($result);
                break;
            case 'warehouses':
                $result['data'] = $this->Warehouse_model->dropdown_active();
                $result['success'] = true;
                echo json_encode($result);
                break;
            default:
        }
        die();
        /**********************************************                OLD                                  ************************************** */
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET': // read
                switch ($this->input->get('action')) {
                    case 'edit':
                        $query = $this->Product_model->getProduct($this->input->get('id'));
                        $data['data'] = $query->row();
                        $data['success'] = true;
                        echo json_encode($data);
                        break;
                    case 'autocomplete': // search products for add to cart
                        $type = $this->input->get('type');
                        switch ($type) {
                            case 'adjustment': // search product
                                $query["offset"] = 0;
                                $query["limit"] = 10;
                                $query["order_by"] = 'label';
                                $query["order"] = 'asc';
                                $query["search"] = $this->input->get('search');
                                $query = $this->Product_model->suggestProdsForAdjustment($query["search"], $query["offset"], $query["limit"], $query["order_by"], $query["order"]);
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
                    default:
                        $error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Action !');
                        echo json_encode($error);
                }
                break;
            default:
                $error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method Found !');
                echo json_encode($error);
        }
    }
}
