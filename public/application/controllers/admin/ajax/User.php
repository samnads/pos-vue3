<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{
	public function index() // view products
	{
		header('Content-Type: application/json; charset=utf-8');
		$this->load->model('admin/User_model');
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
						$data['data'] = $this->User_model->datatable_data(null, $search, $offset, $limit, $order_by, $order);
						$data["draw"] = $this->input->get('draw'); // unique
						$data["recordsTotal"] = $this->User_model->datatable_recordsTotal();
						$data["recordsFiltered"] = $this->User_model->datatable_recordsFiltered($search);
						$data['success'] = true;
						//$data[ 'error' ] = '';
						echo json_encode($data);
						break;
					default:
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Unknown Action !'));
				}
				break;
			case 'POST': // create
				$_POST = $_POST['data'];
				$data = array(
					'first_name'	=> $this->input->post('first_name'),
					'gender'		=> $this->input->post('gender'),
					'date_of_birth'	=> $this->input->post('dob'),
					'username'		=> $this->input->post('username'),
					'role'			=> $this->input->post('role'),
					'status'		=> $this->input->post('status'),
					'password'		=> $this->input->post('password'),
					'r_password'	=> $this->input->post('r_password'),
					'email'			=> $this->input->post('email'),
					'phone'			=> $this->input->post('phone'),
					'last_name'		=> $this->input->post('last_name') ?: NULL,
					'place'			=> $this->input->post('place') ?: NULL,
					'company_name'	=> $this->input->post('company_name') ?: NULL,
					'avatar'		=> $this->input->post('avatar') ?: NULL,
					'country'		=> $this->input->post('country') ?: NULL,
					'city'			=> $this->input->post('city') ?: NULL,
					'place'			=> $this->input->post('place') ?: NULL,
					'pin_code'		=> $this->input->post('pin') ?: NULL,
					'address'		=> $this->input->post('address') ?: NULL,
					'description'	=> $this->input->post('description') ?: NULL
				);
				//$data['role'] = '5';
				$this->form_validation->set_data($data);
				$rule_username = 'is_unique[' . TABLE_USER . '.username]';
				$rule_email = 'is_unique[' . TABLE_USER . '.email]';
				$rule_phone = 'is_unique[' . TABLE_USER . '.phone]';
				$rule_password = 'callback_password_check[' .  $data['r_password'] . ']';
				$rule_avatar = 'is_unique[' . TABLE_USER . '.avatar]';
				$config = array(
					array(
						'field' => 'first_name',
						'label' => 'First Name',
						'rules' => 'required|max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'last_name',
						'label' => 'Last Name',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'gender',
						'label' => 'Gender',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'date_of_birth',
						'label' => 'Date of Birth',
						'rules' => 'trim|xss_clean'
					),
					array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'required|min_length[3]|max_length[200]|' . $rule_username . '|xss_clean|trim'
					),
					array(
						'field' => 'role',
						'label' => 'Role',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'status',
						'label' => 'Status',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'required|valid_email|' . $rule_email . '|xss_clean|trim'
					),
					array(
						'field' => 'phone',
						'label' => 'Phone',
						'rules' => 'required|min_length[5]|max_length[40]|' . $rule_phone . '|xss_clean|trim'
					),
					array(
						'field' => 'company_name',
						'label' => 'Company Name',
						'rules' => 'max_length[200]|xss_clean|trim'
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
						'field' => 'place',
						'label' => 'Place',
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
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'description',
						'label' => 'Description',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'avatar',
						'label' => 'Avatar',
						'rules' => 'max_length[200]|' . $rule_avatar . '|xss_clean|trim'
					),
					array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'required|min_length[8]|' . $rule_password . '|xss_clean|trim'
					),
					array(
						'field' => 'r_password',
						'label' => 'Repeat Password',
						'rules' => 'required|xss_clean|trim'
					),
				);
				//$data['error'] = '0';
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
					unset($data['r_password']);
					$this->User_model->insert_user($data);
					if ($this->db->affected_rows() == 1) {
						$alert['added'] = array('success' => true, 'type' => 'success', 'id' => $this->db->insert_id(), 'message' => 'Successfully added user <strong><em>' .  $data['first_name'] . ' ' . $data['last_name'] . '</em></strong> !', 'location' => "admin/user");
						$this->session->set_flashdata('alert', $alert);
						echo json_encode($alert['added']);
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
					}
				}
				break;
			case 'PUT': // update
				$_POST = $_POST['data'];
				$id = $this->input->post('db')['id'];
				$data = array(
					'first_name'	=> $this->input->post('first_name'),
					'gender'		=> $this->input->post('gender'),
					'date_of_birth'	=> $this->input->post('dob'),
					'username'		=> $this->input->post('username'),
					'role'			=> $this->input->post('role'),
					'status'		=> $this->input->post('status'),
					'password'		=> $this->input->post('password'),
					'r_password'	=> $this->input->post('r_password'),
					'email'			=> $this->input->post('email'),
					'phone'			=> $this->input->post('phone'),
					'last_name'		=> $this->input->post('last_name') ?: NULL,
					'place'			=> $this->input->post('place') ?: NULL,
					'company_name'	=> $this->input->post('company_name') ?: NULL,
					'avatar'		=> $this->input->post('avatar') ?: NULL,
					'country'		=> $this->input->post('country') ?: NULL,
					'city'			=> $this->input->post('city') ?: NULL,
					'place'			=> $this->input->post('place') ?: NULL,
					'pin_code'		=> $this->input->post('pin') ?: NULL,
					'address'		=> $this->input->post('address') ?: NULL,
					'description'	=> $this->input->post('description') ?: NULL
				);
				//$data['name'] = '';
				$this->form_validation->set_data($data);
				$rule_username = 'callback_update_same_username_check[' .  $this->input->post('db')['id'] . ']';
				$rule_email = 'callback_update_same_email_check[' . $this->input->post('db')['id'] . ']';
				$rule_phone = 'callback_update_same_phone_check[' . $this->input->post('db')['id'] . ']';
				$rule_avatar = $this->input->post('avatar') == null ? '' : 'callback_update_same_avatar_check[' . $this->input->post('db')['id'] . ']';
				$config = array(
					array(
						'field' => 'first_name',
						'label' => 'First Name',
						'rules' => 'required|max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'last_name',
						'label' => 'Last Name',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'gender',
						'label' => 'Gender',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'date_of_birth',
						'label' => 'Date of Birth',
						'rules' => 'trim|xss_clean'
					),
					array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'required|min_length[3]|max_length[200]|' . $rule_username . '|xss_clean|trim'
					),
					array(
						'field' => 'role',
						'label' => 'Role',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'status',
						'label' => 'Status',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'required|valid_email|' . $rule_email . '|xss_clean|trim'
					),
					array(
						'field' => 'phone',
						'label' => 'Phone',
						'rules' => 'required|min_length[5]|max_length[40]|' . $rule_phone . '|xss_clean|trim'
					),
					array(
						'field' => 'company_name',
						'label' => 'Company Name',
						'rules' => 'max_length[200]|xss_clean|trim'
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
						'field' => 'place',
						'label' => 'Place',
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
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'description',
						'label' => 'Description',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'avatar',
						'label' => 'Avatar',
						'rules' => 'max_length[200]|' . $rule_avatar . '|xss_clean|trim'
					)
				);
				if ($data['password'] || $data['r_password']) { // change password trigger
					$rule_password = 'callback_password_check[' .  $data['r_password'] . ']';
					$config[] = array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'required|min_length[8]|' . $rule_password . '|xss_clean|trim'
					);
					$config[] = array(
						'field' => 'r_password',
						'label' => 'Confirm Password',
						'rules' => 'required|xss_clean|trim'
					);
				}
				//$data['error'] = '0';
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					if ($data['password']) {
						$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
					} else {
						unset($data['password']);
					}
					unset($data['r_password']);
					$user = $this->User_model->getUser(array('u.id' => $id));
					if ($user['editable'] === NULL) { // edit allowed
						$this->User_model->update_user($data, array('id' => $id));
						$error = $this->db->error();
						if ($this->db->affected_rows() == 1) {
							echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully updated user <strong><em>' . $user['first_name'] . '</em></strong> !'));
						} else if ($this->db->affected_rows() == 0) {
							echo json_encode(array('success' => true, 'type' => 'info', 'id' => $id, 'message' => $this->lang->line('no_data_changed_after_query')));
						} else {
							echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
						}
					} else {
						echo json_encode(array('success' => false, 'type' => 'danger', 'message' => 'User <i>' . $user['first_name'] . "</i> is protected you can't edit it."));
					}
				}
				break;
			case 'DELETE': // delete
				$_POST = $this->input->post('data');
				$id = $this->input->post('id');
				$user = $this->User_model->getUser(array('u.id' => $id));
				if ($user['id']) {
					if ($user['deletable'] === NULL) { // delete allowed
						$this->User_model->set_deleted_at($id);
						$error = $this->db->error();
						if ($this->db->affected_rows() == 1) {
							echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully deleted user <strong><em>' . $user['first_name'] . '</em></strong> !'));
						} else {
							echo json_encode(array('success' => false, 'type' => 'danger', 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
						}
					} else {
						echo json_encode(array('success' => false, 'type' => 'danger', 'message' => 'User <i>' . $user['first_name'] . "</i> is protected you can't delete it."));
					}
				} else {
					echo json_encode(array('success' => false, 'type' => 'danger', 'message' => $this->lang->line('query_no_row_found')));
				}
				break;
			default:
				echo json_encode(array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method Found !'));
		}
	}
	public function update_same_username_check($value, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_USER);
		$this->db->where(array('username' => $value, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('update_same_username_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	public function update_same_email_check($value, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_USER);
		$this->db->where(array('email' => $value, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('update_same_email_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	public function update_same_phone_check($value, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_USER);
		$this->db->where(array('phone' => $value, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('update_same_phone_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	public function update_same_avatar_check($value, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_USER);
		$this->db->where(array('avatar' => $value, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('update_same_avatar_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	public function password_check($password, $r_password)
	{
		if ($password != $r_password) {
			$this->form_validation->set_message('password_check', 'Passwords does not match.');
			return FALSE;
		}
		return TRUE;
	}
}
