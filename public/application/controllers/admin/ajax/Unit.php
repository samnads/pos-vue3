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
				switch ($action = $this->input->get('action')) {
					case 'list_base': // get all unit rows
						$result['data'] = $this->Unit_model->get_all_units();
						$result['success'] = true;
						echo json_encode($result);
						break;
					case 'list_sub': // get subunits from base unit
						$id = $this->input->get('id');
						$result['data'] = $this->Unit_model->get_bulk_units($id);
						$result['success'] = true;
						echo json_encode($result);
						break;
					case 'datatable': // get all unit rows
						$data = array();
						$limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
						$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
						$order = $this->input->get('order')[0]['dir']; // order asc or desc
						$search = $this->input->get('search')['value']; // search query
						$offset = $this->input->get('start'); // start position
						$results = $this->Unit_model->datatable_units($search, $offset, $limit, $order_by, $order);
						$data['data'] = $results;
						$data["draw"] = $this->input->get('draw'); // unique
						$data["recordsTotal"] = $this->Unit_model->totalRows();
						$data["recordsFiltered"] = $this->Unit_model->datatable_units_count($search);
						$data['success'] = true;
						//$data['error'] = 'An error occured !';
						echo json_encode($data);
						break;
					case 'datatable_sub': // get all sub unit rows
						$data = array();
						$limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
						$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
						$order = $this->input->get('order')[0]['dir']; // order asc or desc
						$search = $this->input->get('search')['value']; // search query
						$offset = $this->input->get('start'); // start position
						$results = $this->Unit_model->datatable_subunits($search, $offset, $limit, $order_by, $order);
						$data['data'] = $results;
						$data["draw"] = $this->input->get('draw'); // unique
						$data["recordsTotal"] = $this->Unit_model->sub_totalRows();
						$data["recordsFiltered"] = $this->Unit_model->sub_datatable_units_count($search);
						$data['success'] = true;
						//$data['error'] = 'An error occured !';
						echo json_encode($data);
						break;
					case 'defunit': // get default unit from settings
						$id = $this->input->post('id');
						$result = $this->Unit_model->getSingleUnit($id);
						echo json_encode($result);
						break;
					case 'unit':
						$id = $this->input->post('id');
						$result = $this->Unit_model->getSingleUnit($id);
						echo json_encode($result);
						break;
					default:
						$error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Action !');
						echo json_encode($error);
				}
				break;
			case 'POST': // create
				$_POST = $this->input->post('data');
				if ($this->input->post('unit')) { // NEW SUB UNIT
					$data = array(
						'unit'			=> $this->input->post('unit')['id'],
						'value'			=> $this->input->post('quantity'),

						'name'			=> $this->input->post('name'),
						'code'			=> $this->input->post('code'),
						'description'	=> $this->input->post('description') == NULL ? NULL : $this->input->post('description')
					);
					$ruleName	= 'callback_sub_name_check[' . $this->input->post('unit')['id'] . ']';
					$ruleCode	= 'callback_sub_code_check[' . $this->input->post('unit')['id'] . ']';
					$this->form_validation->set_data($data);
					$config = array(
						array(
							'field' => 'unit',
							'label' => 'Unit ID',
							'rules' => 'required|is_numeric|xss_clean|trim'
						),
						array(
							'field' => 'name',
							'label' => 'Unit Name',
							'rules' => 'required|max_length[50]|' . $ruleName . '|xss_clean|trim'
						),
						array(
							'field' => 'code',
							'label' => 'Unit Code',
							'rules' => 'required|max_length[10]|' . $ruleCode . '|xss_clean|trim'
						),
						array(
							'field' => 'description',
							'label' => 'Unit Description',
							'rules' => 'max_length[100]|xss_clean|trim'
						),
						array(
							'field' => 'value',
							'label' => 'Quantity',
							'rules' => 'required|is_numeric|xss_clean|trim'
						)
					);
					$this->form_validation->set_rules($config);
					if ($this->form_validation->run() == FALSE) {
						echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
					} else {
						//$data['manual_error'] = 'error';
						$this->db->insert(TABLE_UNIT_BULK, $data);
						if ($this->db->affected_rows() == 1) {
							echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->db->insert_id(), 'message' => 'Successfully added new sub unit <strong><em>' . $data['name'] . '</em></strong> for unit ' . $this->input->post('unit')['name'] . ' !'));
						} else {
							$error = $this->db->error();
							echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
						}
					}
				} else { // NEW BASE UNIT
					$data = array(
						'name'			=> $this->input->post('name'),
						'code'			=> $this->input->post('code'),
						'description'	=> $this->input->post('description') == NULL ? NULL : $this->input->post('description')
					);
					//$data['name'] = null;
					$this->form_validation->set_data($data);
					$config = array(
						array(
							'field' => 'name',
							'label' => 'Unit Name',
							'rules' => 'required|max_length[50]|is_unique[' . TABLE_UNIT . '.name]|xss_clean|trim'
						),
						array(
							'field' => 'code',
							'label' => 'Unit Code',
							'rules' => 'required|max_length[10]|is_unique[' . TABLE_UNIT . '.code]|xss_clean|trim'
						),
						array(
							'field' => 'description',
							'label' => 'Unit Description',
							'rules' => 'max_length[100]|xss_clean|trim'
						)
					);
					$this->form_validation->set_rules($config);
					if ($this->form_validation->run() == FALSE) {
						echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
					} else {
						//$data['manual_error'] = 'error';
						$this->db->insert(TABLE_UNIT, $data);
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
				if ($this->input->post('sub')) { // EDIT SUB UNIT
					$data = array(
						'unit'			=> $this->input->post('db')['unit_id'], // parent unit id
						'value'			=> $this->input->post('value'),

						'name'			=> $this->input->post('name'),
						'code'			=> $this->input->post('code'),
						'description'	=> $this->input->post('description') == NULL ? NULL : $this->input->post('description')
					);
					$ruleName	= 'callback_sub_edit_unique_name[' . $this->input->post('db')['unit_id'] . ']';
					$ruleCode	= 'callback_sub_edit_unique_code[' . $this->input->post('db')['unit_id'] . ']';
					$this->form_validation->set_data($data);
					$config = array(
						array(
							'field' => 'unit',
							'label' => 'Unit ID',
							'rules' => 'required|is_numeric|xss_clean|trim'
						),
						array(
							'field' => 'name',
							'label' => 'Unit Name',
							'rules' => 'required|max_length[50]|' . $ruleName . '|xss_clean|trim'
						),
						array(
							'field' => 'code',
							'label' => 'Unit Code',
							'rules' => 'required|max_length[10]|' . $ruleCode . '|xss_clean|trim'
						),
						array(
							'field' => 'description',
							'label' => 'Unit Description',
							'rules' => 'max_length[100]|xss_clean|trim'
						),
						array(
							'field' => 'value',
							'label' => 'Quantity',
							'rules' => 'required|is_numeric|xss_clean|trim'
						)
					);
					$this->form_validation->set_rules($config);
					if ($this->form_validation->run() == FALSE) {
						echo json_encode(array('success' => false, 'message' => $this->form_validation->error_array()));
					} else {
						//$data['manual_error'] = 'error';
						$this->db->update(TABLE_UNIT_BULK, $data, array('id' => $this->input->post('db')['id']));
						if ($this->db->affected_rows() == 1) {
							echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->db->insert_id(), 'message' => 'Successfully updated sub unit <strong><em>' . $this->input->post('db')['name'] . '</em></strong> !'));
						} else if ($this->db->affected_rows() == 0) {
							echo json_encode(array('success' => true, 'type' => 'info', 'id' => $this->input->post('db')['id'], 'message' => 'No data changed for sub unit <strong><em>' . $this->input->post('db')['name'] . '</em></strong> !', 'timeout' => 5000));
						} else {
							$error = $this->db->error();
							echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
						}
					}
				} else { // EDIT PARENT UNIT
					$data = array(
						'name'			=> $this->input->post('name'),
						'code'			=> $this->input->post('code'),
						'description'	=> $this->input->post('description') == NULL ? NULL : $this->input->post('description')
					);
					$this->form_validation->set_data($data);
					$ruleName	= 'callback_edit_unique_name[' . $this->input->post('db')['id'] . ']';
					$ruleCode	= 'callback_edit_unique_code[' . $this->input->post('db')['id'] . ']';
					$config = array(
						array(
							'field' => 'name',
							'label' => 'Unit Name',
							'rules' => 'required|max_length[50]|' . $ruleName . '|xss_clean|trim'
						),
						array(
							'field' => 'code',
							'label' => 'Unit Code',
							'rules' => 'required|max_length[10]|' . $ruleCode . '|xss_clean|trim'
						),
						array(
							'field' => 'description',
							'label' => 'Unit Description',
							'rules' => 'max_length[100]|xss_clean|trim'
						)
					);
					$this->form_validation->set_rules($config);
					if ($this->form_validation->run() == FALSE) {
						echo json_encode(array('success' => false, 'message' => $this->form_validation->error_array()));
					} else {
						//$data['manual_error'] = 'error';
						$this->db->update(TABLE_UNIT, $data, array('id' => $this->input->post('db')['id']));
						if ($this->db->affected_rows() == 1) {
							echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->db->insert_id(), 'message' => 'Successfully updated unit <strong><em>' . $this->input->post('db')['name'] . '</em></strong> !'));
						} else if ($this->db->affected_rows() == 0) {
							echo json_encode(array('success' => true, 'type' => 'info', 'id' => $this->input->post('db')['id'], 'message' => 'No data changed for unit <strong><em>' . $this->input->post('db')['name'] . '</em></strong> !', 'timeout' => 5000));
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
					$this->Unit_model->delete_unit($id);
					$error = $this->db->error();
					if ($error['code'] == 1451) {
						echo json_encode(array('success' => false, 'type' => 'danger', 'id' => $id, 'timeout' => 5000, 'message' => 'Delete all data associated with the unit <strong><em>' . $this->input->post('name') . '</em></strong> then try again !'));
					} else if ($error['code'] == 0 && $this->db->affected_rows() == 1) {
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
	/******************************************************************** */
	public function sub_edit_unique_name($name, $unit)
	{
		$id = $this->input->post('db')['id'];
		$this->db->select('id');
		$this->db->from(TABLE_UNIT_BULK);
		$this->db->where(array('name' => $name, 'unit' => $unit, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('sub_edit_unique_name', 'Already exist.');
			return FALSE;
		}
		return TRUE;
	}
	public function sub_edit_unique_code($code, $unit)
	{
		$id = $this->input->post('db')['id'];
		$this->db->select('id,unit');
		$this->db->from(TABLE_UNIT_BULK);
		$this->db->where(array('code' => $code, 'unit' => $unit, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('sub_edit_unique_code', 'Already exist.');
			return FALSE;
		}
		return TRUE;
	}
	/******************************************************************** */
	public function sub_name_check($name, $unit)
	{ // check if new sub unit name exist in subs of parent unit
		$this->db->select('id');
		$this->db->from(TABLE_UNIT_BULK);
		$this->db->where(array('unit' => $unit, 'name' => $name));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('sub_name_check', 'Already exist.');
			return FALSE;
		}
		return TRUE;
	}
	public function sub_code_check($code, $unit)
	{ // check if new sub unit code exist in subs of parent unit
		$this->db->select('id');
		$this->db->from(TABLE_UNIT_BULK);
		$this->db->where(array('unit' => $unit, 'code' => $code));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('sub_code_check', 'Already exist.');
			return FALSE;
		}
		return TRUE;
	}
}
