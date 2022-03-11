<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Brand extends CI_Controller
{
	public function index()
	{
		header('Content-Type: application/json; charset=utf-8');
		$this->load->model('admin/Brand_model');
		$_POST = raw_input_to_post();
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET': // read
				switch ($action = $this->input->get('action')) {
					case 'dropdown': // get all brand rows
						$query = $this->input->get('query');
						$result['data'] = $this->Brand_model->search_brands($query);
						$result['success'] = true;
						echo json_encode($result);
						break;
					case 'datatable': // get all brand rows
						$query = $this->input->get('query');
						$result['data'] = $this->Brand_model->search_brands($query);
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
					'description'	=> $this->input->post('description') == NULL ? NULL : $this->input->post('description')
				);
				//$data['code'] = 'error_error_error_error_error_';
				$this->form_validation->set_data($data);
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Brand Name',
						'rules' => 'required|max_length[50]|is_unique[' . TABLE_BRAND . '.name]|xss_clean|trim'
					),
					array(
						'field' => 'code',
						'label' => 'Brand Code',
						'rules' => 'required|max_length[10]|is_unique[' . TABLE_BRAND . '.code]|xss_clean|trim'
					),
					array(
						'field' => 'description',
						'label' => 'Brand Description',
						'rules' => 'max_length[100]|is_unique[' . TABLE_BRAND . '.description]|xss_clean|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					//$data['manual_error'] = 'error';
					$this->db->insert(TABLE_BRAND, $data);
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->db->insert_id(), 'message' => 'Successfully added new brand <strong><em>' . $data['name'] . '</em></strong> !'));
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}
				}
				break;
			case 'PUT': // update
				$_POST = $this->input->post('data');
				$id = $this->input->post('id');
				$rule_name = 'callback_edit_unique_name_check[' . $id . ']';
				$rule_code = 'callback_edit_unique_code_check[' . $id . ']';
				$data = array(
					'name'			=> $this->input->post('name'),
					'code'			=> $this->input->post('code'),
					'description'	=> $this->input->post('description') == NULL ? NULL : $this->input->post('description')
				);
				//$data['code'] = 'error_error_error_error_error_';
				$this->form_validation->set_data($data);
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Brand Name',
						'rules' => 'required|max_length[50]|' . $rule_name . '|xss_clean|trim'
					),
					array(
						'field' => 'code',
						'label' => 'Brand Code',
						'rules' => 'required|max_length[10]|' . $rule_code . '|xss_clean|trim'
					),
					array(
						'field' => 'description',
						'label' => 'Brand Description',
						'rules' => 'max_length[100]|xss_clean|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					//$data['manual_error'] = 'error';
					$this->db->update(TABLE_BRAND, $data, array('id' => $id));
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully updated brand <strong><em>' . $this->input->post('db')['name'] . '</em></strong> !'));
					} else if ($this->db->affected_rows() == 0) {
						echo json_encode(array('success' => true, 'type' => 'info', 'id' => $id, 'message' => 'No data changed for brand <strong><em>' . $this->input->post('name') . '</em></strong> !', 'timeout' => 5000));
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}
				}
				break;
			case 'DELETE': // delete
				$_POST = $this->input->post('data');
				$id = $this->input->post('id');
				$query = $this->Brand_model->deleteById($id);
				$error = $this->db->error();
				if ($error['code'] == 1451) {
					echo json_encode(array('success' => false, 'type' => 'danger', 'id' => $id, 'timeout' => 5000, 'error' => 'Delete all data associated with the brand <strong><em>' . $this->input->post('name') . '</em></strong> then try again !'));
				} else if ($this->db->affected_rows() == 1) {
					echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully deleted brand <strong><em>' . $this->input->post('name') . '</em></strong> !'));
				} else if ($error['code'] == 0) {
					echo json_encode(array('success' => true, 'type' => 'primary', 'id' => $id, 'message' => 'No data found for deleting brand <strong><em>' . $this->input->post('name') . '</em></strong> !'));
				} else {
					echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
				}
				break;
			default:
				$error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method Found !');
				echo json_encode($error);
		}
	}
	public function edit_unique_name_check($name, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_BRAND);
		$this->db->where(array('name' => $name, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_unique_name_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	public function edit_unique_code_check($code, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_BRAND);
		$this->db->where(array('code' => $code, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_unique_code_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
}
