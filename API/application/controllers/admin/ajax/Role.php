<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Role extends CI_Controller
{
	public function index()
	{
		//echo $this->router->fetch_method();
		header('Content-Type: application/json; charset=utf-8');
		$this->load->model('admin/Module_model');
		$this->load->model('admin/Permission_model');
		$this->load->model('admin/Role_model');
		$_POST = raw_input_to_post();
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET': // read
				switch ($this->input->get('action')) {
					case 'list':
						$result['data'] = $this->Role_model->get_all_roles();
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
						$data['data'] = $this->Role_model->datatable_data($search, $offset, $limit, $order_by, $order);
						$data["draw"] = $this->input->get('draw'); // unique
						$data["recordsTotal"] = $this->Role_model->datatable_recordsTotal();
						$data["recordsFiltered"] = $this->Role_model->datatable_recordsFiltered($search);
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
				switch ($this->input->post('job')) {
					case 'module_permission':
						$this->db->select('
                        mp.module		as module,
                        mp.permission	as permission,
                        mp.checked      as checked,
						mp.read_only	as read_only,
		                m.name		    as module_name,
                        m.description   as module_description,
                        p.name		    as permission_name,
                        p.usage		    as usage');
						$this->db->from(TABLE_MODULE_PERMISSION . ' mp');
						$this->db->join(TABLE_MODULE . '		m',    'm.id=mp.module', 'left');
						$this->db->join(TABLE_PERMISSION . '	p',    'p.id=mp.permission', 'left');
						$query = $this->db->get();
						//die($this->db->last_query());
						$results = $query->result_array();
						$new = array();
						foreach ($results as $objKey => $object) { // group roles by modules
							$new[$object['module']][] = $object;
						}
						$data = array("rights" => $new);
						echo json_encode(array('success' => true, 'type' => 'success', 'data' => $data));
						break;
					default:
						$_POST = $this->input->post('data');
						$rights = $this->input->post('rights');
						$data = array(
							'name'			=> $this->input->post('name') ?: NULL,
							'limit'			=> $this->input->post('limit') ?: NULL,
							'description'	=> $this->input->post('description') ?: NULL
						);
						$this->form_validation->set_data($data);
						$config = array(
							array(
								'field' => 'name',
								'label' => 'Role Name',
								'rules' => 'required|max_length[100]|is_unique[' . TABLE_ROLE . '.name]|xss_clean|trim'
							),
							array(
								'field' => 'limit',
								'label' => 'Role User Limit',
								'rules' => 'required|is_numeric|greater_than[0]|xss_clean|trim'
							),
							array(
								'field' => 'description',
								'label' => 'Description',
								'rules' => 'required|xss_clean|trim'
							)
						);
						$this->form_validation->set_rules($config);
						if ($this->form_validation->run() == FALSE) {
							echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
						} else {
							$this->db->trans_begin();
							$this->Role_model->insert_role($data);
							if ($this->db->affected_rows() == 1) {
								// role added
								$role_id = $this->db->insert_id();
								// save role permissions
								if (is_array($rights) || is_object($rights)) {
									foreach ($rights as $module => $permObj) {
										foreach ($permObj as $permission => $allow) {
											if (filter_var(
												$allow,
												FILTER_VALIDATE_BOOLEAN
											)) { // ALLOW
												$insert_data = array(
													'role_id' => $role_id,
													'module_id' => $module,
													'permission_id' => $permission,
													'allow' => 1
												);
												$this->Role_model->insert_role_permission($insert_data);
												if ($this->db->affected_rows() != 1) { // one of insertion failure
													$error = $this->db->error();
													$this->db->trans_rollback();
													die(json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !"))));
												}
											}
										}
									}
									$this->db->trans_commit();
									echo json_encode(array('success' => true, 'type' => 'success', 'id' => $role_id, 'message' => 'Successfully added new role <strong><em>' . $data['name'] . '</em></strong> !', 'timeout' => 5000, 'location' => "admin/role/list"));
								} else { // rights data not found
									$this->db->trans_rollback();
									echo json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Rights data not found !'));
								}
							} else {
								$error = $this->db->error();
								$this->db->trans_rollback();
								echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
							}
						}
				}
				break;
			case 'PUT': // update role
				switch ($this->input->post('job')) {
					case 'module_permission_role_permission':
						$this->db->select('
                        mp.module		as module,
                        mp.permission	as permission,
                        mp.checked      as checked,
		                m.name		    as module_name,
                        m.description   as module_description,
                        p.name		    as permission_name,
                        p.usage		    as usage,
						rp.allow		as allow,
						rp.read_only	as read_only,
						r.name			as name,
						r.limit			as limit,
						r.description	as description');
						$this->db->from(TABLE_MODULE_PERMISSION . ' mp');
						$this->db->join(TABLE_MODULE . '		m',    'm.id=mp.module', 'left');
						$this->db->join(TABLE_PERMISSION . '	p',    'p.id=mp.permission', 'left');
						$this->db->join(TABLE_ROLE_PERMISSION . '	rp',    'rp.module_id=mp.module AND rp.permission_id=mp.permission AND rp.role_id=' . $this->input->post('id'), 'left');
						$this->db->join(TABLE_ROLE . '	r',    'r.id=rp.role_id', 'left');
						$query = $this->db->get();
						//die($this->db->last_query());
						$results = $query->result_array();
						$rights = array();
						foreach ($results as $objKey => $object) { // group roles by modules
							$rights[$object['module']][] = $object;
						}
						$data = $this->Role_model->get_role_data($this->input->post('id'));
						$data['rights'] = $rights;
						echo json_encode(array('success' => true, 'type' => 'success', 'data' => $data));
						break;
					default:
						$id = $this->input->post('data')['db']['id']; // unique bd id
						//
						$rule_name = 'callback_edit_unique_name[' . $id . ']';
						// update role name or limit
						$data = array(
							'name'			=> $this->input->post('data')['name'] ?:  NULL,
							'limit'			=> $this->input->post('data')['limit'] ?: NULL,
							'description'	=> $this->input->post('data')['description'] ?: NULL
						);
						$this->form_validation->set_data($data);
						$config = array(
							array(
								'field' => 'name',
								'label' => 'Role Name',
								'rules' => 'required|max_length[100]|' . $rule_name . '|xss_clean|trim'
							),
							array(
								'field' => 'limit',
								'label' => 'Role User Limit',
								'rules' => 'required|is_numeric|greater_than[0]|xss_clean|trim'
							),
							array(
								'field' => 'description',
								'label' => 'Description',
								'rules' => 'required|xss_clean|trim'
							)
						);
						$this->form_validation->set_rules($config);
						$role_changed = false;
						if ($this->form_validation->run() == FALSE) {
							die(json_encode(array('success' => false, 'errors' => $this->form_validation->error_array())));
						} else {
							//$data['manual_error'] = 'error';
							// update role table
							$this->db->trans_begin();
							$this->Role_model->update_role($data, array('id' => $id, 'editable' => NULL, 'deleted_at' => NULL));
							if ($this->db->affected_rows() == 1) {
								// role data changed
								$role_changed = true;
							} else if ($this->db->affected_rows() == 0) {
								// role data not changed
							} else {
								$error = $this->db->error();
								$this->db->trans_rollback();
								die(json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !"))));
							}
						}
						// update rights
						$_POST = $this->input->post('data');
						$rights = $this->input->post('rights');
						// save updates
						if (is_array($rights) || is_object($rights)) {
							foreach ($rights as $module => $permObject) {
								foreach ($permObject as $permission => $allow) {
									$update_row = array(
										'allow' => $allow || 0
									);
									$where = array(
										'role_id' => $id,
										'module_id' => $module,
										'permission_id' => $permission,
										'readonly' => NULL,
									);
									if (filter_var($allow, FILTER_VALIDATE_BOOLEAN)) { // ALLOW
										$this->Role_model->update_role_permission($update_row, $where);
									} else {
										$this->Role_model->delete_role_permission($where);
									}
									if ($this->db->affected_rows() != 1 && $this->db->affected_rows() != 0) {
										$this->db->trans_rollback();
										die(json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Role-Permission updation failed !')));
									}
								}
							}
							$this->db->trans_commit();
							echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully updated permissions for role <strong><em>' . $data['name'] . '</em></strong> !', 'timeout' => 5000, 'location' => "admin/role/list"));
						} else { // rights data not found
							$this->db->trans_rollback();
							echo json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Rights data not found !'));
						}
				}
				break;
			case 'DELETE': // delete
				$_POST = $this->input->post('data');
				$id = (int)$this->input->post('id');
				$role = $this->Role_model->getRoleData($id);
				if ($role['id']) {
					if ($role['deletable'] === NULL) {
						$this->Role_model->set_deleted_at(array('id' => $id, 'deletable' => NULL, 'deleted_at' => NULL));
						$error = $this->db->error();
						if ($this->db->affected_rows() == 1) {
							echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully deleted role <strong><em>' . $role['name'] . '</em></strong> !'));
						} else {
							echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
						}
					} else {
						echo json_encode(array('success' => false, 'type' => 'danger', 'message' => $role['name'] . " role is protected you can't delete it."));
					}
				} else {
					echo json_encode(array('success' => false, 'type' => 'danger', 'message' => "Specified role doesn't exist !"));
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
		$this->db->from(TABLE_ROLE);
		$this->db->where(array('name' => $name, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_unique_name', '%s already exist.');
			return FALSE;
		}
		return TRUE;
	}
}
