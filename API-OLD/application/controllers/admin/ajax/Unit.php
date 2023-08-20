<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Unit extends CI_Controller
{
	public function index() // view products
	{
		header('Content-Type: application/json; charset=utf-8');
		$this->load->model('admin/Unit_model');
		$_POST = raw_input_to_post();
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET': // read
				switch ($this->input->get('action')) {
					case 'datatable': // get all unit rows
						$data = array();
						$limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
						$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
						$order = $this->input->get('order')[0]['dir']; // order asc or desc
						$search = $this->input->get('search')['value']; // search query
						$offset = $this->input->get('start'); // start position
						$results = $this->Unit_model->datatable_data($search, $offset, $limit, $order_by, $order);
						$data['data'] = $results;
						$data["draw"] = $this->input->get('draw'); // unique
						$data["recordsTotal"] = $this->Unit_model->datatable_recordsTotal();
						$data["recordsFiltered"] = $this->Unit_model->datatable_recordsFiltered($search);
						$data['success'] = true;
						//$data = array('success' => false, 'type' => 'danger', 'error' => 'Error Test OK !');
						echo json_encode($data);
						break;
					default:
						$error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Action !');
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Unknown Action !'));
				}
				break;
			case 'POST': // create
				$_POST = $this->input->post('data');
				if ($this->input->post('unit')) { // NEW SUB UNIT
					$data = array(
						'base'			=> $this->input->post('unit'), // base unit id
						'name'			=> $this->input->post('name'),
						'code'			=> $this->input->post('code'),
						'step'			=> $this->input->post('step') ?: NULL,
						'allow_decimal'	=> $this->input->post('allow_decimal') ? 1 : 0,
						'description'	=> $this->input->post('description') ?: NULL
					);
					//$ruleName	= 'callback_sub_name_check[' . $this->input->post('unit')['id'] . ']';
					//$ruleCode	= 'callback_sub_code_check[' . $this->input->post('unit')['id'] . ']';
					$this->form_validation->set_data($data);
					$config = array(
						array(
							'field' => 'base',
							'label' => 'Base Unit ID',
							'rules' => 'required|is_numeric|xss_clean|trim'
						),
						array(
							'field' => 'name',
							'label' => 'Name',
							'rules' => 'required|max_length[50]|is_unique[' . TABLE_UNIT . '.name]|xss_clean|trim'
						),
						array(
							'field' => 'code',
							'label' => 'Code',
							'rules' => 'required|max_length[10]|is_unique[' . TABLE_UNIT . '.code]|xss_clean|trim'
						),
						array(
							'field' => 'step',
							'label' => 'Step',
							'rules' => 'required|is_numeric|xss_clean|trim'
						),
						array(
							'field' => 'allow_decimal',
							'label' => 'Allow Decimal',
							'rules' => 'required|xss_clean|trim'
						),
						array(
							'field' => 'description',
							'label' => 'Description',
							'rules' => 'max_length[100]|xss_clean|trim'
						)
					);
					$this->form_validation->set_rules($config);
					if ($this->form_validation->run() == FALSE) {
						echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
					} else {
						//$data['manual_error'] = 'error';
						$this->Unit_model->insert_sub_unit($data);
						if ($this->db->affected_rows() == 1) {
							echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->db->insert_id(), 'message' => 'Successfully added new sub unit <strong><em>' . $data['name'] . '</em></strong> !'));
						} else {
							$error = $this->db->error();
							echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
						}
					}
				} else { // NEW BASE UNIT
					$data = array(
						'name'			=> $this->input->post('name'),
						'code'			=> $this->input->post('code'),
						'allow_decimal'	=> $this->input->post('allow_decimal') ? 1 : 0,
						'description'	=> $this->input->post('description') ?: NULL
					);
					//$data['name'] = null;
					$this->form_validation->set_data($data);
					$config = array(
						array(
							'field' => 'name',
							'label' => 'Name',
							'rules' => 'required|max_length[50]|is_unique[' . TABLE_UNIT . '.name]|xss_clean|trim'
						),
						array(
							'field' => 'code',
							'label' => 'Code',
							'rules' => 'required|max_length[10]|is_unique[' . TABLE_UNIT . '.code]|xss_clean|trim'
						),
						array(
							'field' => 'allow_decimal',
							'label' => 'Allow Decimal',
							'rules' => 'required|xss_clean|trim'
						),
						array(
							'field' => 'description',
							'label' => 'Description',
							'rules' => 'max_length[100]|xss_clean|trim'
						)
					);
					$this->form_validation->set_rules($config);
					if ($this->form_validation->run() == FALSE) {
						echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
					} else {
						//$data['manual_error'] = 'error';
						$data['operator'] = NULL; // def for base unit
						$data['step'] = NULL; // def for base unit
						$this->Unit_model->insert_unit($data);
						if ($this->db->affected_rows() == 1) {
							echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->db->insert_id(), 'message' => 'Successfully added new unit <strong><em>' . $data['name'] . '</em></strong> !'));
						} else {
							$error = $this->db->error();
							echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
						}
					}
				}
				break;
			case 'PUT': // update
				$_POST = $this->input->post('data');
				if ($this->input->post('unit')) { // EDIT SUB UNIT
					$data = array(
						'base'			=> $this->input->post('unit'), // base unit id
						'name'			=> $this->input->post('name'),
						'code'			=> $this->input->post('code'),
						'allow_decimal'	=> $this->input->post('allow_decimal') ? 1 : 0,
						'description'	=> $this->input->post('description') ?: NULL,
						'step'			=> $this->input->post('step') ?: NULL
					);
					$ruleName	= 'callback_edit_unique_name[' . $this->input->post('id') . ']';
					$ruleCode	= 'callback_edit_unique_code[' . $this->input->post('id') . ']';
					$this->form_validation->set_data($data);
					$config = array(
						array(
							'field' => 'base',
							'label' => 'Base Unit ID',
							'rules' => 'required|is_numeric|xss_clean|trim'
						),
						array(
							'field' => 'name',
							'label' => 'Name',
							'rules' => 'required|max_length[50]|' . $ruleName . '|xss_clean|trim'
						),
						array(
							'field' => 'code',
							'label' => 'Code',
							'rules' => 'required|max_length[10]|' . $ruleCode . '|xss_clean|trim'
						),
						array(
							'field' => 'step',
							'label' => 'Step',
							'rules' => 'required|is_numeric|xss_clean|trim'
						),
						array(
							'field' => 'allow_decimal',
							'label' => 'Allow Decimal',
							'rules' => 'required|xss_clean|trim'
						),
						array(
							'field' => 'description',
							'label' => 'Description',
							'rules' => 'max_length[100]|xss_clean|trim'
						)
					);
					$this->form_validation->set_rules($config);
					if ($this->form_validation->run() == FALSE) {
						echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
					} else {
						//$data['manual_error'] = 'error';
						$this->Unit_model->update_sub_unit($data, array('id' => $this->input->post('id'), 'editable' => NULL, 'deleted_at' => NULL));
						if ($this->db->affected_rows() == 1) {
							echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully updated sub unit <strong><em>' . $data['name'] . '</em></strong> !'));
						} else if ($this->db->affected_rows() == 0) {
							echo json_encode(array('success' => true, 'type' => 'info', 'message' => $this->lang->line('no_data_changed_after_query'), 'timeout' => 5000));
						} else {
							$error = $this->db->error();
							echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
						}
					}
				} else { // EDIT PARENT UNIT
					$data = array(
						'name'			=> $this->input->post('name'),
						'code'			=> $this->input->post('code'),
						'allow_decimal'	=> $this->input->post('allow_decimal') ? 1 : 0,
						'description'	=> $this->input->post('description') ?: NULL
					);
					$this->form_validation->set_data($data);
					$ruleName	= 'callback_edit_unique_name[' . $this->input->post('id') . ']';
					$ruleCode	= 'callback_edit_unique_code[' . $this->input->post('id') . ']';
					$config = array(
						array(
							'field' => 'name',
							'label' => 'Name',
							'rules' => 'required|max_length[50]|' . $ruleName . '|xss_clean|trim'
						),
						array(
							'field' => 'code',
							'label' => 'Code',
							'rules' => 'required|max_length[10]|' . $ruleCode . '|xss_clean|trim'
						),
						array(
							'field' => 'allow_decimal',
							'label' => 'Allow Decimal',
							'rules' => 'required|xss_clean|trim'
						),
						array(
							'field' => 'description',
							'label' => 'Description',
							'rules' => 'max_length[100]|xss_clean|trim'
						)
					);
					$this->form_validation->set_rules($config);
					if ($this->form_validation->run() == FALSE) {
						echo json_encode(array('success' => false, 'message' => $this->form_validation->error_array()));
					} else {
						//$data['manual_error'] = 'error';
						$this->Unit_model->update_unit($data, array('id' => $this->input->post('id'), 'editable' => NULL, 'deleted_at' => NULL));
						if ($this->db->affected_rows() == 1) {
							echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully updated unit <strong><em>' . $data['name'] . '</em></strong> !'));
						} else if ($this->db->affected_rows() == 0) {
							echo json_encode(array('success' => true, 'type' => 'info', 'message' => $this->lang->line('no_data_changed_after_query'), 'timeout' => 5000));
						} else {
							$error = $this->db->error();
							echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
						}
					}
				}
				break;
			case 'DELETE': // delete
				$_POST = $_POST['data'];
				$id = $this->input->post('id');
				if ($this->input->post('sub')) { // sub unit
					$this->Unit_model->delete_subunit($id);
					$error = $this->db->error();
					if ($error['code'] == 1451) {
						echo json_encode(array('success' => false, 'type' => 'danger', 'id' => $id, 'timeout' => 5000, 'message' => 'Delete all data associated with the subunit <strong><em>' . $this->input->post('name') . '</em></strong> then try again !'));
					} else if ($error['code'] == 0 && $this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully deleted subunit <strong><em>' . $this->input->post('name') . '</em></strong> !'));
					} else {
						echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}
				} else { // base unit
					$this->Unit_model->set_deleted_at(array('id' => $id, 'deletable' => NULL, 'deleted_at' => NULL));
					$error = $this->db->error();
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully deleted unit <strong><em>' . $this->input->post('name') . '</em></strong> !'));
					} else {
						echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}
				}
				break;
			default:
				$error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method Found !');
				echo json_encode($error);
		}
	}
	/******************************************************************** */
	public function edit_unique_name($name, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_UNIT);
		$this->db->where(array('name' => $name, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_unique_name', 'Already exist.');
			return FALSE;
		}
		return TRUE;
	}
	public function edit_unique_code($code, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_UNIT);
		$this->db->where(array('code' => $code, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_unique_code', 'Already exist.');
			return FALSE;
		}
		return TRUE;
	}
}
