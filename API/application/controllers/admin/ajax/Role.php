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
		$table = TABLE_ROLE;
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET': // read
				switch ($action = $this->input->get('action')) {
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
				$_POST = $this->input->post('data');
				$rights = $this->input->post('rights');
				$data = array(
					'name'			=> $this->input->post('name'),
					'limit'			=> $this->input->post('limit'),
					'description'	=> $this->input->post('description')
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
					$this->Role_model->insert_role($data);
					if ($this->db->affected_rows() == 1) {
						// role added
						$role_id = $this->db->insert_id();
						// get module id's
						$rows_modules = $this->Module_model->get_all_modules();
						$rows_permissions = $this->Permission_model->get_all_permissions();
						// create array for ids
						$modules = array();
						$permissions = array();
						foreach ($rows_modules as $module) {
							$modules[$module['name']] = $module['id']; // modules
						}
						foreach ($rows_permissions as $permission) {
							$permissions[$permission['name']] = $permission['id']; // permissions
						}
						// save role permissions
						if (is_array($rights) || is_object($rights)) {
							foreach ($rights as $module => $permissions2) {
								foreach ($permissions2 as $permission => $allow) {
									if (filter_var(
										$allow,
										FILTER_VALIDATE_BOOLEAN
									)) { // ALLOW
										$update_row = array(
											'role_id' => $role_id,
											'module_id' => $modules[$module],
											'permission_id' => $permissions[$permission],
											'allow' => 1
										);
										$this->db->insert(TABLE_ROLE_PERMISSION, $update_row);
									}
								}
							}
						}
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $role_id, 'message' => 'Successfully added new role <strong><em>' . $data['name'] . '</em></strong> !', 'timeout' => 5000));
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
					}
				}
				break;
			case 'PUT': // update role
				$role_id_db = $this->input->post('data')['db']['id'];
				$role_limit_db = $this->input->post('data')['db']['limit'];
				$role_name_db = $this->input->post('data')['db']['name'];
				$role_desc_db = $this->input->post('data')['db']['description'];

				$role_name_new = isset($this->input->post('data')['name']) ? $this->input->post('data')['name'] : null;
				$role_limit_new = isset($this->input->post('data')['limit']) ? $this->input->post('data')['limit'] : null;
				$role_desc_new = isset($this->input->post('data')['description']) ? $this->input->post('data')['description'] : null;
				// update role name or limit
				if ($role_name_db != $role_name_new || $role_limit_db != $role_limit_new || $role_desc_db != $role_desc_new) { // name or limit changed
					$data = array(
						'name'			=> $role_name_new,
						'limit'			=> $role_limit_new,
						'description'	=> $role_desc_new
					);
					$this->form_validation->set_data($data);
					$config = array(
						array(
							'field' => 'name',
							'label' => 'Role Name',
							'rules' => 'required|max_length[100]|xss_clean|trim'
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
						die(json_encode(array('success' => false, 'errors' => $this->form_validation->error_array())));
					} else {
						//$data['manual_error'] = 'error';
						// update role table
						$this->db->update(TABLE_ROLE, $data, array('id' => $role_id_db, 'editable' => 1));
						if ($this->db->affected_rows() == 1) {
							if ($role_name_db != $role_name_new) {
								$alert['updated_name'] = array('success' => true, 'type' => 'success',  'timeout' => '5000', 'message' => 'Successfully updated role name from <strong><em>' . $role_name_db . '</em></strong> to <strong><em>' . $role_name_new . '</em></strong> !');
							}
							if ($role_limit_db != $role_limit_new) {
								$alert['updated_limit'] = array('success' => true, 'type' => 'success',  'timeout' => '5000', 'message' => 'Successfully updated role user limit for <strong><em>' . ($role_name_new ? $role_name_new : $role_name_db) . '</em></strong> !');
							}
							if ($role_desc_db != $role_desc_new) {
								$alert['updated_desc'] = array('success' => true, 'type' => 'success',  'timeout' => '5000', 'message' => 'Successfully updated role description for <strong><em>' . ($role_name_new ? $role_name_new : $role_name_db) . '</em></strong> !');
							}
							// role updated
						} else if ($this->db->affected_rows() == 0) {
							// role data not changed
						} else {
							$error = $this->db->error();
							die(json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !"))));
						}
					}
				}
				$_POST = $this->input->post('data');
				// update rights
				$rights = $this->input->post('rights');
				// get module id's
				$rows_modules = $this->Module_model->get_all_modules(null);
				$rows_permissions = $this->Permission_model->get_all_permissions(null);
				// create array for ids
				$modules = array();
				$permissions = array();
				foreach ($rows_modules as $module) {
					$modules[$module['name']] = $module['id']; // modules
				}
				foreach ($rows_permissions as $permission) {
					$permissions[$permission['name']] = $permission['id']; // permissions
				}
				// save updates
				foreach ($rights as $module => $permissions2) {
					foreach ($permissions2 as $permission => $allow) {
						$update_row = array(
							'role_id' => $this->input->post('db')['id'],
							'module_id' => $modules[$module],
							'permission_id' => $permissions[$permission],
							'allow' => $allow || 0
						);
						$update_where = array(
							'role_id' => $this->input->post('db')['id'],
							'module_id' => $modules[$module],
							'permission_id' => $permissions[$permission],
							'readonly' => NULL,
						);
						if (filter_var($allow, FILTER_VALIDATE_BOOLEAN)) { // ALLOW
							//$this->db->replace(TABLE_ROLE_PERMISSION, $update_row, $update_where);
							$this->db->replace(TABLE_ROLE_PERMISSION, $update_row, $update_where);
						} else {
							$this->db->delete(TABLE_ROLE_PERMISSION, $update_where);
						}
					}
				}
				if ($this->db->affected_rows() >= 0) {
					$alert['updated'] = array('success' => true, 'type' => 'success',  'timeout' => '5000', 'message' => 'Successfully updated permissions for role <strong><em>' . ($role_name_new ? $role_name_new : $role_name_db) . '</em></strong> !');
					$this->session->set_flashdata('alert', $alert);
					echo json_encode(array('success' => true, 'location' => "admin/role"));
				} else {
					$error = $this->db->error();
					echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
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
}
