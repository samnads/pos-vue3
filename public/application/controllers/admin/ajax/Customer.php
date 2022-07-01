<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Customer extends CI_Controller
{
	public function index() // view products
	{
		header('Content-Type: application/json; charset=utf-8');
		$this->load->model('admin/Customer_model');
		$_POST = raw_input_to_post();
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET': // read
				switch ($this->input->get('action')) {
					case 'suggest': // read
						$type = $this->input->get('type');
						switch ($type) {
							case 'pos': // ui auto complete
								$query["offset"] = 0;
								$query["limit"] = 10;
								$query["order_by"] = 'id';
								$query["order"] = 'asc';
								$query["search"] = $this->input->get('search');
								$query = $this->Customer_model->suggestCustomerForPos($query["search"], $query["offset"], $query["limit"], $query["order_by"], $query["order"]);
								$error = $this->db->error();
								if ($error['code'] == 0) {
									echo json_encode(array('success' => true, 'type' => 'success', 'data' => $query->result_array()));
								} else {
									echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
								}
								break;
							default:
								echo json_encode(array('success' => false, 'type' => 'warning', 'message' => 'Suggest Action Not Exist !'));
								break;
						}
						break;
					case 'datatable': // for customers datatble in admin panel
						$data = array();
						$limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
						$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
						$order = $this->input->get('order')[0]['dir']; // order asc or desc
						$search = $this->input->get('search')['value']; // search query
						$offset = $this->input->get('start'); // start position
						$columns = null;
						$data['data'] = $this->Customer_model->datatable_data($search, $offset, $limit, $order_by, $order, $columns);
						$data["draw"] = $this->input->get('draw'); // unique
						$data["recordsTotal"] = $this->Customer_model->datatable_recordsTotal();
						$data["recordsFiltered"] = $this->Customer_model->datatable_recordsFiltered($search);
						$data['success'] = true;
						//$data[ 'error' ] = '';
						echo json_encode($data);
						break;
					default:
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Unknown GET Action !'));
				}
				break;
			case 'POST': // create
				$_POST = $this->input->post('data');
				$auto_id = $this->Customer_model->get_AUTO_INCREMENT();
				if (!$auto_id) {
					$error = $this->db->error();
					echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured (AUTO_INCREMENT) !")));
					die();
				}
				$data = array(
					'name'			=> $this->input->post('name'),
					'code'			=> sprintf("CUST%04s", $auto_id),
					'group'			=> $this->input->post('group'),
					'place'			=> $this->input->post('place'),
					'city'			=> $this->input->post('city') ?: null,
					'pin_code'		=> $this->input->post('pin') ?: null,
					'email'			=> $this->input->post('email') ?: null,
					'phone'			=> $this->input->post('phone') ?: null,
					'address'		=> $this->input->post('address') ?: null,
					'description'	=> $this->input->post('description') ?: null,
				);
				//$data['name'] = '';
				$this->form_validation->set_data($data);
				$rule_name = 'callback_same_name_place_check[' . $data['place'] . ']';
				$rule_email = $this->input->post('email') == null ? '' : 'is_unique[' . TABLE_CUSTOMER . '.email]';
				$rule_phone = $this->input->post('phone') == null ? '' : 'is_unique[' . TABLE_CUSTOMER . '.phone]';
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'required|min_length[3]|max_length[200]|' . $rule_name . '|xss_clean|trim'
					),
					array(
						'field' => 'code',
						'label' => 'Code',
						'rules' => 'required|max_length[20]|is_unique[' . TABLE_CUSTOMER . '.code]|xss_clean|trim'
					),
					array(
						'field' => 'group',
						'label' => 'Customer Group',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'place',
						'label' => 'Place',
						'rules' => 'required|min_length[3]|max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'valid_email|' . $rule_email . '|xss_clean|trim'
					),
					array(
						'field' => 'city',
						'label' => 'City',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'pin_code',
						'label' => 'PIN Code',
						'rules' => 'max_length[15]|xss_clean|trim'
					),
					array(
						'field' => 'phone',
						'label' => 'Phone',
						'rules' => 'min_length[5]|max_length[40]|' . $rule_phone . '|xss_clean|trim'
					),
					array(
						'field' => 'address',
						'label' => 'Address',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'description',
						'label' => 'Description',
						'rules' => 'max_length[250]|xss_clean|trim'
					)
				);
				//$data['error'] = '0';
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					$this->Customer_model->insert_customer($data);
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'data' => array('id' => $this->db->insert_id(), 'name' => $data['name'], 'place' => $data['place']), 'message' => 'Successfully added new customer <strong><em>' . $data['name'] . '</em></strong> !'));
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
					}
				}
				break;
			case 'PUT': // update
				$_POST = $this->input->post('data');
				$data = array(
					'name'			=> $this->input->post('name'),
					'group'			=> $this->input->post('group'),
					'place'			=> $this->input->post('place'),
					'city'			=> $this->input->post('city') ?: null,
					'pin_code'		=> $this->input->post('pin') ?: null,
					'email'			=> $this->input->post('email') ?: null,
					'phone'			=> $this->input->post('phone') ?: null,
					'address'		=> $this->input->post('address') ?: null,
					'description'	=> $this->input->post('description') ?: null,
				);
				//$data['name'] = '';
				$this->form_validation->set_data($data);
				$rule_name = 'callback_update_same_name_place_check[' . $data['place'] . ']';
				$rule_email = $this->input->post('email') == null ? '' : 'callback_update_same_email_check[' . $this->input->post('db')['id'] . ']';
				$rule_phone = $this->input->post('phone') == null ? '' : 'callback_update_same_phone_check[' . $this->input->post('db')['id'] . ']';
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'required|min_length[3]|max_length[200]|' . $rule_name . '|xss_clean|trim'
					),
					array(
						'field' => 'group',
						'label' => 'Customer Group',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'place',
						'label' => 'Place',
						'rules' => 'required|min_length[3]|max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'city',
						'label' => 'City',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'pin_code',
						'label' => 'PIN Code',
						'rules' => 'max_length[15]|xss_clean|trim'
					),
					array(
						'field' => 'phone',
						'label' => 'Phone',
						'rules' => 'min_length[5]|max_length[40]|' . $rule_phone . '|xss_clean|trim'
					),
					array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'valid_email|' . $rule_email . '|xss_clean|trim'
					),
					array(
						'field' => 'address',
						'label' => 'Address',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'description',
						'label' => 'Description',
						'rules' => 'max_length[250]|xss_clean|trim'
					)
				);
				//$data['error'] = '0';
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					$customer = $this->Customer_model->getCustomer(array('id' => $this->input->post('db')['id']));
					if ($customer['id']) {
						if ($customer['editable'] !== 0 && $customer['deleted_at'] == 0) {
							$this->Customer_model->update_customer($data, array('id' => $this->input->post('db')['id'], 'deleted_at' => NULL, 'editable' => NULL));
							if ($this->db->affected_rows() == 1) {
								echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully updated customer <strong><em>' .  $customer['name'] . '</em></strong> !'));
							} else if ($this->db->affected_rows() == 0) {
								echo json_encode(array('success' => false, 'type' => 'info', 'id' => $customer['id'], 'message' => 'No data changed for customer <strong><em>' . $customer['name'] . '</em></strong> !', 'timeout' => 5000));
							} else {
								$error = $this->db->error();
								echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
							}
						} else {
							echo json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Customer <i>' . $customer['name'] . "</i> is protected you can't edit it."));
						}
					} else {
						echo json_encode(array('success' => false, 'type' => 'danger', 'message' => "Customer doesn't exist !"));
					}
				}
				break;
			case 'DELETE': // delete
				if (isset($this->input->post('data')['id'])) { // single delete
					$_POST = $this->input->post('data');
					$id = (int)$this->input->post('id');
					$customer = $this->Customer_model->getCustomer(array('id' => $id));
					if ($customer['id']) {
						if ($customer['deletable'] !== 0) {
							$this->Customer_model->set_deleted_at($id);
							$error = $this->db->error();
							if ($error['code'] == 1451) {
								echo json_encode(array('success' => false, 'type' => 'danger', 'id' => $id, 'timeout' => 5000, 'message' => 'Delete all data associated with the customer <strong><em>' . $customer['name'] . '</em></strong> then try again !'));
							} else if ($error['code'] == 0 && $this->db->affected_rows() == 1) {
								echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully deleted customer <strong><em>' . $customer['name'] . '</em></strong> !'));
							} else {
								echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
							}
						} else {
							echo json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Customer <i>' . $customer['name'] . "</i> is protected you can't delete it."));
						}
					} else {
						echo json_encode(array('success' => false, 'type' => 'danger', 'message' => "Specified customer doesn't exist !"));
					}
					break;
				} else {
					$ids = array();
					foreach ($this->input->post('data') as $key => $value) {
						array_push($ids, $value['id']);
					}
					$this->Customer_model->set_deleted_at_multi($ids);
					$error = $this->db->error();
					/*if ($error['code'] == 1451) {
						echo json_encode(array('success' => false, 'type' => 'danger', 'ids' => $ids, 'error' => 'Delete all data associated with the customers then try again !'));
					}*/
					if ($error['code'] == 0) {
						echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Customer(s) successfully deleted !'));
					} else {
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}
					break;
				}
				break;
			default:
				echo json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method !'));
		}
	}
	public function same_name_place_check($name, $place)
	{
		$this->db->select('id');
		$this->db->from(TABLE_CUSTOMER);
		$this->db->where(array('name' => $name, 'place' => $place));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('same_name_place_check', $this->lang->line('form_validation_is_unique') . ' [same place]');
			return FALSE;
		}
		return TRUE;
	}
	public function update_same_name_place_check($name, $place)
	{
		$this->db->select('id');
		$this->db->from(TABLE_CUSTOMER);
		$this->db->where(array('name' => $name, 'place' => $place, 'id !=' => $this->input->post('db')['id']));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('update_same_name_place_check', $this->lang->line('form_validation_is_unique') . ' [same place]');
			return FALSE;
		}
		return TRUE;
	}
	public function update_same_email_check($email, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_CUSTOMER);
		$this->db->where(array('email' => $email, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('update_same_email_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	public function update_same_phone_check($phone, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_CUSTOMER);
		$this->db->where(array('phone' => $phone, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('update_same_phone_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
}
