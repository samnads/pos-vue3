<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tax extends CI_Controller
{
	public function index()
	{
		header('Content-Type: application/json; charset=utf-8');
		$this->load->model('admin/Tax_model');
		$_POST = raw_input_to_post();
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET': // read
				switch ($this->input->get('action')) {
					case 'datatable': // get all brand rows
						$data = array();
						$limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
						$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
						$order = $this->input->get('order')[0]['dir']; // order asc or desc
						$search = $this->input->get('search')['value']; // search query
						$offset = $this->input->get('start'); // start position
						$query = $this->Tax_model->datatable_data($search, $offset, $limit, $order_by, $order);
						$data['data'] = $query->result();
						$data["draw"] = $this->input->get('draw'); // unique
						$data["recordsTotal"] = $this->Tax_model->datatable_recordsTotal();
						$data["recordsFiltered"] = $this->Tax_model->datatable_recordsFiltered($search);
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
				$data = array(
					'name'			=> $this->input->post('name'),
					'code'			=> $this->input->post('code'),
					'rate'			=> $this->input->post('rate'),
					'type'			=> $this->input->post('type') ?: 'P',
					'description'	=> $this->input->post('description') ?: NULL
				);
				//$data['rate'] = 'error';
				$this->form_validation->set_data($data);
				$rule_rate = 'callback_same_name_rate_check[' . $data['name'] . ']';
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'required|max_length[50]|xss_clean|trim'
					),
					array(
						'field' => 'code',
						'label' => 'Code',
						'rules' => 'required|max_length[50]|is_unique[' . TABLE_TAX_RATE . '.code]|xss_clean|trim'
					),
					array(
						'field' => 'rate',
						'label' => 'Rate',
						'rules' => 'required|numeric|max_length[10]|' . $rule_rate . '|xss_clean|trim'
					),
					array(
						'field' => 'type',
						'label' => 'Type',
						'rules' => 'required|in_list[P,F]|min_length[1]|xss_clean|trim'
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
					$this->Tax_model->insert_tax_rate($data);
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->db->insert_id(), 'message' => 'Successfully added new tax <strong><em>' . $data['name'] . '</em></strong> !', 'timeout' => 5000));
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
					'code'			=> $this->input->post('code'),
					'rate'			=> $this->input->post('rate'),
					'type'			=> $this->input->post('type') ?: 'P',
					'description'	=> $this->input->post('description') ?: NULL
				);
				$id = $this->input->post('db')['id'];
				//$data['rate'] = 'error';
				$this->form_validation->set_data($data);
				$rule_code = 'callback_edit_unique_code_check[' . $id . ']';
				$rule_rate = 'callback_edit_same_name_rate_check[' . $data['name'] . ']';
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'required|max_length[50]|xss_clean|trim'
					),
					array(
						'field' => 'code',
						'label' => 'Code',
						'rules' => 'required|max_length[50]|' . $rule_code . '|xss_clean|trim'
					),
					array(
						'field' => 'rate',
						'label' => 'Rate',
						'rules' => 'required|numeric|max_length[10]|' . $rule_rate . '|xss_clean|trim'
					),
					array(
						'field' => 'type',
						'label' => 'Type',
						'rules' => 'required|in_list[P,F]|min_length[1]|xss_clean|trim'
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
					 $this->Tax_model->update_tax_rate($data, array('id' => $id, 'editable' => NULL, 'deleted_at' => NULL));
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->input->post('db')['id'], 'message' => 'Successfully updated tax <strong><em>' . $this->input->post('db')['name'] . '</em></strong> !', 'timeout' => 5000));
					} else if ($this->db->affected_rows() == 0) {
						echo json_encode(array('success' => true, 'type' => 'info', 'id' => $this->input->post('db')['id'], 'message' => $this->lang->line('no_data_changed_after_query'), 'timeout' => 5000));
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}
				}
				break;
			case 'DELETE': // delete
				if (isset($this->input->post('data')['id'])) { // single delete
					$_POST = $this->input->post('data');
					$id = $this->input->post('id');
					$this->Tax_model->set_deleted_at(array('id' => $id, 'deletable' => NULL, 'deleted_at' => NULL));
					$error = $this->db->error();
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully deleted tax <strong><em>' . $this->input->post('name') . '</em></strong> !'));
					} else {
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}
				} else {
					/*$ids = array();
					foreach ($this->input->post('data') as $key => $value) {
						array_push($ids, $value['id']);
					}
					$query = $this->Tax_model->deleteByIds($ids);
					$error = $this->db->error();
					if (
						$error['code'] == 1451
					) {
						echo json_encode(array('success' => false, 'type' => 'danger', 'ids' => $ids, 'error' => 'Delete all data associated with the taxes then try again !'));
					} else if ($error['code'] == 0) {
						echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Taxes successfully deleted !'));
					} else {
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}*/
				}
				break;
			default:
				echo json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method !'));
		}
	}
	public function same_name_rate_check($rate, $name)
	{
		$this->db->select('id');
		$this->db->from(TABLE_TAX_RATE);
		$this->db->where(array('rate' => $rate, 'name' => $name, 'type' => $this->input->post('type')));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('same_name_rate_check', '%s already exist for the same tax name and type.');
			return FALSE;
		}
		return TRUE;
	}
	public function edit_unique_code_check($code, $id)
	{ // check if new tax rate exist for same tax name
		$this->db->select('id');
		$this->db->from(TABLE_TAX_RATE);
		$this->db->where(array('code' => $code, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_unique_code_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	public function edit_same_name_rate_check($rate, $name)
	{
		$this->db->select('id');
		$this->db->from(TABLE_TAX_RATE);
		$this->db->where(array('rate' => $rate, 'name' => $name, 'type' => $this->input->post('type'), 'id !=' => $this->input->post('db')['id']));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_same_name_rate_check', '%s already exist for the same tax name and type.');
			return FALSE;
		}
		return TRUE;
	}
}
