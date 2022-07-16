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
				switch ($this->input->get('action')) {
					case 'datatable':
						$data = array();
						$limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
						$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
						$order = $this->input->get('order')[0]['dir']; // order asc or desc
						$search = $this->input->get('search')['value']; // search query
						$offset = $this->input->get('start'); // start position
						$data['data'] = $this->Warehouse_model->datatable_data($search, $offset, $limit, $order_by, $order);
						$data["draw"] = $this->input->get('draw'); // unique
						$data["recordsTotal"] = $this->Warehouse_model->datatable_recordsTotal();
						$data["recordsFiltered"] = $this->Warehouse_model->datatable_recordsFiltered($search);
						$data['success'] = true;
						//$data[ 'error' ] = '';
						echo json_encode($data);
						break;
					default:
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Unknown Action !'));
				}
				break;
			case 'POST': // create
				$_POST = $this->input->post('data');
				$auto_id = $this->Warehouse_model->get_AUTO_INCREMENT();
				if (!$auto_id) {
					$error = $this->db->error();
					echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured (AUTO_INCREMENT) !")));
					die();
				}
				$data = array(
					'name'			=> $this->input->post('name'),
					'code'			=> sprintf("WARE%04s", $auto_id),
					'place'			=> $this->input->post('place'),
					'date_of_open'	=> $this->input->post('date_of_open'),
					'status'		=> $this->input->post('status'),
					'email'			=> $this->input->post('email'),
					'phone'			=> $this->input->post('phone'),
					'status_reason'	=> $this->input->post('status_reason') ?: NULL,
					'country'		=> $this->input->post('country') ?: NULL,
					'city'			=> $this->input->post('city') ?: NULL,
					'pin_code'		=> $this->input->post('pin_code') ?: NULL,
					'address'		=> $this->input->post('address') ?: NULL,
					'description'	=> $this->input->post('description') ?: NULL
				);
				//$data['email'] = "error";
				$this->form_validation->set_data($data);
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'required|max_length[150]|max_length[150]|is_unique[' . TABLE_WAREHOUSE . '.name]|xss_clean|trim'
					),
					array(
						'field' => 'code',
						'label' => 'Code',
						'rules' => 'required|max_length[50]|is_unique[' . TABLE_WAREHOUSE . '.code]|xss_clean|trim'
					),
					array(
						'field' => 'place',
						'label' => 'Place',
						'rules' => 'required|max_length[150]|xss_clean|trim'
					),
					array(
						'field' => 'date_of_open',
						'label' => 'Date of Open',
						'rules' => 'required|max_length[150]|xss_clean|trim'
					),
					array(
						'field' => 'status',
						'label' => 'Status',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'status_reason',
						'label' => 'Status Reason',
						'rules' => 'max_length[100]|xss_clean|trim'
					),
					array(
						'field' => 'phone',
						'label' => 'Phone',
						'rules' => 'required|max_length[40]|is_unique[' . TABLE_WAREHOUSE . '.phone]|xss_clean|trim'
					),
					array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'required|valid_email|max_length[255]|is_unique[' . TABLE_WAREHOUSE . '.email]|xss_clean|trim'
					),
					array(
						'field' => 'country',
						'label' => 'Country',
						'rules' => 'min_length[3]|max_length[50]|xss_clean|trim'
					),
					array(
						'field' => 'city',
						'label' => 'City',
						'rules' => 'min_length[3]|max_length[50]|xss_clean|trim'
					),
					array(
						'field' => 'pin_code',
						'label' => 'Pin Code',
						'rules' => 'min_length[3]|max_length[15]|xss_clean|trim'
					),
					array(
						'field' => 'address',
						'label' => 'Address',
						'rules' => 'max_length[255]|xss_clean|trim'
					),
					array(
						'field' => 'description',
						'label' => 'Description',
						'rules' => 'max_length[255]|xss_clean|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					//$data['manual_error'] = 'error';
					$this->Warehouse_model->insert_warehouse($data);
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
				$rule_phone = 'callback_edit_unique_phone[' . $id . ']';
				$rule_email = 'callback_edit_unique_email[' . $id . ']';
				$data = array(
					'name'			=> $this->input->post('name'),
					'place'			=> $this->input->post('place'),
					'date_of_open'	=> $this->input->post('date_of_open'),
					'status'		=> $this->input->post('status'),
					'email'			=> $this->input->post('email'),
					'phone'			=> $this->input->post('phone'),
					'status_reason'	=> $this->input->post('status_reason') ?: NULL,
					'country'		=> $this->input->post('country') ?: NULL,
					'city'			=> $this->input->post('city') ?: NULL,
					'pin_code'		=> $this->input->post('pin_code') ?: NULL,
					'address'		=> $this->input->post('address') ?: NULL,
					'description'	=> $this->input->post('description') ?: NULL
				);
				$this->form_validation->set_data($data);
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'required|max_length[150]|max_length[150]|' . $rule_name . '|xss_clean|trim'
					),
					array(
						'field' => 'place',
						'label' => 'Place',
						'rules' => 'required|max_length[150]|xss_clean|trim'
					),
					array(
						'field' => 'date_of_open',
						'label' => 'Date of Open',
						'rules' => 'required|max_length[150]|xss_clean|trim'
					),
					array(
						'field' => 'status',
						'label' => 'Status',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'status_reason',
						'label' => 'Status Reason',
						'rules' => 'max_length[100]|xss_clean|trim'
					),
					array(
						'field' => 'phone',
						'label' => 'Phone',
						'rules' => 'required|max_length[40]|' . $rule_phone . '|xss_clean|trim'
					),
					array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'required|valid_email|max_length[255]|' . $rule_email . '|xss_clean|trim'
					),
					array(
						'field' => 'country',
						'label' => 'Country',
						'rules' => 'min_length[3]|max_length[50]|xss_clean|trim'
					),
					array(
						'field' => 'city',
						'label' => 'City',
						'rules' => 'min_length[3]|max_length[50]|xss_clean|trim'
					),
					array(
						'field' => 'pin_code',
						'label' => 'Pin Code',
						'rules' => 'min_length[3]|max_length[15]|xss_clean|trim'
					),
					array(
						'field' => 'address',
						'label' => 'Address',
						'rules' => 'max_length[255]|xss_clean|trim'
					),
					array(
						'field' => 'description',
						'label' => 'Description',
						'rules' => 'max_length[255]|xss_clean|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					//$data['manual_error'] = 'error';
					$this->Warehouse_model->update_warehouse($data, array('id' => $id));
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
				$this->Warehouse_model->set_deleted_at(array('id' => $id, 'deletable' => NULL, 'deleted_at' => NULL));
				if ($this->db->affected_rows() == 1) {
					echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully deleted warehouse <strong><em>' . $this->input->post('name') . '</em></strong> !'));
				} else {
					$error = $this->db->error();
					echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
				}
				break;
			default:
				echo json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method Found !'));
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
