<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Supplier extends CI_Controller
{
	public function index()
	{
		header('Content-Type: application/json; charset=utf-8');
		$this->load->model('admin/Supplier_model');
		$_POST = raw_input_to_post();
		/*
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET': // read
			case 'POST': // create
			case 'PUT': // update
			case 'DELETE': // delete
			default:
				$error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method Found !');
				echo json_encode($error);
		}
		*/
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET': // read
				switch ($action = $this->input->get('action')) {
					case 'list':
						$result['data'] = $this->Supplier_model->get_all_taxes();
						$result['success'] = true;
						echo json_encode($result);
						break;
					case 'datatable':
						$data = array();
						$limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
						$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
						$order = $this->input->get('order')[0]['dir']; // order asc or desc
						$search = $this->input->get('search')['value']; // search query
						$offset = $this->input->get('start'); // start position
						$data['data'] = $this->Supplier_model->get_all_supplier(false, null, $search, $offset, $limit, $order_by, $order);
						$data["draw"] = $this->input->get('draw'); // unique
						$data["recordsTotal"] = $this->Supplier_model->recordsTotal();
						$data["recordsFiltered"] = $this->Supplier_model->get_all_supplier_recordsFiltered($search);
						$data['success'] = true;
						//$data[ 'error' ] = '';
						echo json_encode($data);
						break;
					default:
						$error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Action !');
						echo json_encode($error);
				}
				break;
			case 'POST': // create
				$_POST = $this->input->post('data');
				$auto_id = $this->Supplier_model->get_AUTO_INCREMENT();
				if (!$auto_id) {
					$error = $this->db->error();
					echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured (AUTO_INCREMENT) !")));
					die();
				}
				$data = array(
					'name'			=> $this->input->post('name'),
					'code'			=> sprintf("SUPP%04s", $auto_id),
					'place'			=> $this->input->post('place'),
					'address'		=> $this->input->post('address') == NULL ? NULL : $this->input->post('address'),
					'pin_code'		=> $this->input->post('pin_code') == NULL ? NULL : $this->input->post('pin_code'),
					'city'			=> $this->input->post('city') == NULL ? NULL : $this->input->post('city'),
					'phone'			=> $this->input->post('phone'),
					'email'			=> $this->input->post('email') == NULL ? NULL : $this->input->post('email'),
					'gst_no'		=> $this->input->post('gst_no') == NULL ? NULL : $this->input->post('gst_no'),
					'tax_no'		=> $this->input->post('tax_no') == NULL ? NULL : $this->input->post('tax_no'),
					'description'	=> $this->input->post('description') == NULL ? NULL : $this->input->post('description')
				);
				//$data['rate'] = 'error';
				$this->form_validation->set_data($data);
				$rule_rate = 'callback_same_name_rate_check[' . $data['name'] . ']';
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'required|max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'code',
						'label' => 'Code',
						'rules' => 'required|max_length[20]|is_unique[' . TABLE_SUPPLIER . '.code]|xss_clean|trim'
					),
					array(
						'field' => 'place',
						'label' => 'Place',
						'rules' => 'required|max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'address',
						'label' => 'Address',
						'rules' => 'max_length[250]|xss_clean|trim'
					),
					array(
						'field' => 'pin_code',
						'label' => 'PIN Code',
						'rules' => 'max_length[15]|xss_clean|trim'
					),
					array(
						'field' => 'city',
						'label' => 'City',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'phone',
						'label' => 'Phone',
						'rules' => 'required|max_length[50]|is_unique[' . TABLE_SUPPLIER . '.phone]|xss_clean|trim'
					),
					array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'valid_email|max_length[200]|is_unique[' . TABLE_SUPPLIER . '.email]|xss_clean|trim'
					),
					array(
						'field' => 'gst_no',
						'label' => 'GST No.',
						'rules' => 'max_length[100]|xss_clean|trim'
					),
					array(
						'field' => 'tax_no',
						'label' => 'Tax No.',
						'rules' => 'max_length[100]|xss_clean|trim'
					),
					array(
						'field' => 'description',
						'label' => 'Description',
						'rules' => 'max_length[250]|xss_clean|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					//$data['manual_error'] = 'error';
					$auto_id = $this->Supplier_model->get_AUTO_INCREMENT();
					$this->db->insert(TABLE_SUPPLIER, $data);
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->db->insert_id(), 'message' => 'Successfully added new supplier <strong><em>' . $data['name'] . '</em></strong> !', 'timeout' => 5000));
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}
				}
				break;
			case 'PUT': // update
				$_POST = $this->input->post('data');
				$data = array(
					'name'			=> $this->input->post('name'),
					'place'			=> $this->input->post('place'),
					'address'		=> $this->input->post('address') == NULL ? NULL : $this->input->post('address'),
					'pin_code'		=> $this->input->post('pin') == NULL ? NULL : $this->input->post('pin'),
					'city'			=> $this->input->post('city') == NULL ? NULL : $this->input->post('city'),
					'phone'			=> $this->input->post('phone'),
					'email'			=> $this->input->post('email') == NULL ? NULL : $this->input->post('email'),
					'gst_no'		=> $this->input->post('gst') == NULL ? NULL : $this->input->post('gst'),
					'tax_no'		=> $this->input->post('tax') == NULL ? NULL : $this->input->post('tax'),
					'description'	=> $this->input->post('description') == NULL ? NULL : $this->input->post('description')
				);
				$id = $this->input->post('db')['id'];
				//$data['email'] = 'error';
				$this->form_validation->set_data($data);
				$rule_phone = 'callback_edit_unique_phone_check[' . $id . ']';
				$rule_email = $this->input->post('email') == null ? '' : 'callback_edit_unique_email_check[' . $id . ']';
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'required|max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'place',
						'label' => 'Place',
						'rules' => 'required|max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'address',
						'label' => 'Address',
						'rules' => 'max_length[250]|xss_clean|trim'
					),
					array(
						'field' => 'pin_code',
						'label' => 'PIN Code',
						'rules' => 'max_length[15]|xss_clean|trim'
					),
					array(
						'field' => 'city',
						'label' => 'City',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'phone',
						'label' => 'Phone',
						'rules' => 'required|max_length[50]|' . $rule_phone . '|xss_clean|trim'
					),
					array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'valid_email|max_length[200]|' . $rule_email . '|xss_clean|trim'
					),
					array(
						'field' => 'gst_no',
						'label' => 'GST No.',
						'rules' => 'max_length[100]|xss_clean|trim'
					),
					array(
						'field' => 'tax_no',
						'label' => 'Tax No.',
						'rules' => 'max_length[100]|xss_clean|trim'
					),
					array(
						'field' => 'description',
						'label' => 'Description',
						'rules' => 'max_length[250]|xss_clean|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					//$data['manual_error'] = 'error';
					$this->db->update(TABLE_SUPPLIER, $data, array('id' => $this->input->post('db')['id']));
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->input->post('db')['id'], 'message' => 'Successfully updated supplier <strong><em>' . $this->input->post('db')['code'] . '</em></strong> !', 'timeout' => 5000));
					} else if ($this->db->affected_rows() == 0) {
						echo json_encode(array('success' => false, 'type' => 'info', 'id' => $this->input->post('db')['id'], 'message' => 'No data changed for supplier <strong><em> ' . $this->input->post('db')['code'] . '</em></strong> !', 'timeout' => 5000));
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}
				}
				break;
			case 'DELETE': // delete
				if (isset($this->input->post('data')['id'])) { // single delete
					$_POST = $this->input->post('data');
					$id = (int)$this->input->post('id');
					$supplier = $this->Supplier_model->getSupplier($id, null);
					if ($supplier['id']) {
						if ($supplier['deletable'] !== 0) {
							$this->Supplier_model->delete_where(array('id' => $id));
							$error = $this->db->error();
							if ($error['code'] == 1451) {
								echo json_encode(array('success' => false, 'type' => 'danger', 'id' => $id, 'timeout' => 5000, 'message' => 'Delete all data associated with the supplier <strong><em>' . $supplier['name'] . '</em></strong> then try again !'));
							} else if ($error['code'] == 0 && $this->db->affected_rows() == 1) {
								echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully deleted supplier <strong><em>' . $supplier['name'] . '</em></strong> !'));
							} else {
								echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
							}
						} else {
							echo json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Supplier <i>' . $supplier['name'] . "</i> is protected you can't delete it."));
						}
					} else {
						echo json_encode(array('success' => false, 'type' => 'danger', 'message' => "Specified supplier doesn't exist !"));
					}
				} else {
					$ids = array();
					foreach ($this->input->post('data') as $key => $value) {
						array_push($ids, $value['id']);
					}
					$this->Supplier_model->delete_wherein_id($ids);
					$error = $this->db->error();
					if ($error['code'] == 1451) {
						echo json_encode(array('success' => false, 'type' => 'danger', 'ids' => $ids, 'error' => 'Delete all data associated with the suppliers then try again !'));
					} else if ($error['code'] == 0) {
						echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Supplier(s) successfully deleted !'));
					} else {
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}
				}
				break;
			default:
				$error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method Found !');
				echo json_encode($error);
		}
	}
	public function edit_unique_phone_check($phone, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_SUPPLIER);
		$this->db->where(array('phone' => $phone, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_unique_phone_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	public function edit_unique_email_check($email, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_SUPPLIER);
		$this->db->where(array('email' => $email, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_unique_email_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
}
