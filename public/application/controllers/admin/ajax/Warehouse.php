<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Warehouse extends CI_Controller
{
	public function index()
	{
		header('Content-Type: application/json; charset=utf-8');
		$this->load->model('admin/Warehouse_model');
		$_POST = raw_input_to_post();

		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET': // read
				switch ($action = $this->input->get('action')) {
					case 'datatable':
						$query = $this->input->get('query');
						$result['data'] = $this->Warehouse_model->search_warehouses($query);
						$result['success'] = true;
						echo json_encode($result);
						break;
					case 'dropdown':
						$result['data'] = $this->Warehouse_model->dropdown_all();
						$result['success'] = true;
						echo json_encode($result);
						break;
					default:
						$error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Action !');
						echo json_encode($error);
				}
				break;
			case 'POST': // create
				$_POST = $this->input->post('data');
				$data = array(
					'name'			=> $this->input->post('name'),
					'code'			=> $this->input->post('code'),
					'phone'			=> $this->input->post('phone'),
					'email'			=> $this->input->post('email'),
					'address'		=> $this->input->post('address') == NULL ? NULL : $this->input->post('address'),
					'description'	=> $this->input->post('description') == NULL ? NULL : $this->input->post('description')
				);
				//$data['email'] = "error";
				$this->form_validation->set_data($data);
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Warehouse Name',
						'rules' => 'required|max_length[150]|max_length[150]|is_unique[' . TABLE_WAREHOUSE . '.name]|xss_clean|trim'
					),
					array(
						'field' => 'code',
						'label' => 'Warehouse Code',
						'rules' => 'required|max_length[50]|is_unique[' . TABLE_WAREHOUSE . '.code]|xss_clean|trim'
					),
					array(
						'field' => 'phone',
						'label' => 'Warehouse Phone',
						'rules' => 'required|max_length[40]|is_unique[' . TABLE_WAREHOUSE . '.code]|xss_clean|trim'
					),
					array(
						'field' => 'email',
						'label' => 'Warehouse Email',
						'rules' => 'required|valid_email|max_length[255]|is_unique[' . TABLE_WAREHOUSE . '.code]|xss_clean|trim'
					),
					array(
						'field' => 'address',
						'label' => 'Warehouse Address',
						'rules' => 'required|max_length[255]|xss_clean|trim'
					),
					array(
						'field' => 'description',
						'label' => 'Warehouse Description',
						'rules' => 'max_length[255]|xss_clean|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					//$data['manual_error'] = 'error';
					$this->db->insert(TABLE_WAREHOUSE, $data);
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->db->insert_id(), 'message' => 'Successfully added new warehouse <strong><em>' . $data['name'] . '</em></strong> !'));
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}
				}
				break;
			case 'PUT': // update
				$_POST = $this->input->post('data');
				$id = (int)$this->input->post('db')['id'];
				$rule_name = 'callback_edit_unique_name[' . $id . ']';
				$rule_code = 'callback_edit_unique_code[' . $id . ']';
				$rule_phone = 'callback_edit_unique_phone[' . $id . ']';
				$rule_email = 'callback_edit_unique_email[' . $id . ']';
				$data = array(
					'name'			=> $this->input->post('name'),
					'code'			=> $this->input->post('code'),
					'phone'			=> $this->input->post('phone'),
					'email'			=> $this->input->post('email'),
					'address'		=> $this->input->post('address') == NULL ? NULL : $this->input->post('address'),
					'description'	=> $this->input->post('description') == NULL ? NULL : $this->input->post('description')
				);
				$this->form_validation->set_data($data);
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Warehouse Name',
						'rules' => 'required|max_length[150]|max_length[150]|' . $rule_name . '|xss_clean|trim'
					),
					array(
						'field' => 'code',
						'label' => 'Warehouse Code',
						'rules' => 'required|max_length[50]|' . $rule_code . '|xss_clean|trim'
					),
					array(
						'field' => 'phone',
						'label' => 'Warehouse Phone',
						'rules' => 'required|max_length[40]|' . $rule_phone . '|xss_clean|trim'
					),
					array(
						'field' => 'email',
						'label' => 'Warehouse Email',
						'rules' => 'required|valid_email|max_length[255]|' . $rule_email . '|xss_clean|trim'
					),
					array(
						'field' => 'address',
						'label' => 'Warehouse Address',
						'rules' => 'required|max_length[255]|xss_clean|trim'
					),
					array(
						'field' => 'description',
						'label' => 'Warehouse Description',
						'rules' => 'max_length[255]|xss_clean|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'message' => $this->form_validation->error_array()));
				} else {
					//$data['manual_error'] = 'error';
					$this->db->update(TABLE_WAREHOUSE, $data, array('id' => $id));
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully updated warehouse <strong><em>' . $this->input->post('db')['name'] . '</em></strong> !'));
					} else if ($this->db->affected_rows() == 0) {
						echo json_encode(array('success' => true, 'type' => 'info', 'id' => $id, 'message' => $this->lang->line('no_data_changed_after_query'), 'timeout' => 5000));
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}
				}
				break;
			case 'DELETE': // delete
				$_POST = $this->input->post('data');
				$id = (int)$this->input->post('id');
				$query = $this->Warehouse_model->deleteById($id);
				$error = $this->db->error();
				if ($error['code'] == 1451) {
					echo json_encode(array('success' => false, 'type' => 'danger', 'id' => $id, 'timeout' => 5000, 'message' => 'Delete all data associated with the warehouse <strong><em>' . $this->input->post('name') . '</em></strong> then try again !'));
				} else if ($error['code'] == 0 && $this->db->affected_rows() == 1) {
					echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully deleted warehouse <strong><em>' . $this->input->post('name') . '</em></strong> !'));
				} else {
					echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
				}
				break;
			default:
				$error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method Found !');
				echo json_encode($error);
		}
	}
	public function edit_unique_name($name, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_WAREHOUSE);
		$this->db->where(array('name' => $name, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_unique_name', '%s already exist.');
			return FALSE;
		}
		return TRUE;
	}
	public function edit_unique_code($code, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_WAREHOUSE);
		$this->db->where(array('code' => $code, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_unique_code', '%s already exist.');
			return FALSE;
		}
		return TRUE;
	}
	public function edit_unique_phone($phone, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_WAREHOUSE);
		$this->db->where(array('phone' => $phone, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_unique_phone', '%s already exist.');
			return FALSE;
		}
		return TRUE;
	}
	public function edit_unique_email($email, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_WAREHOUSE);
		$this->db->where(array('email' => $email, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_unique_email', '%s already exist.');
			return FALSE;
		}
		return TRUE;
	}
}
