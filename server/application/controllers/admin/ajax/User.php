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
				switch ($action = $this->input->get('action')) {
					case 'datatable':
						$data = array();
						$limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
						$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
						$order = $this->input->get('order')[0]['dir']; // order asc or desc
						$search = $this->input->get('search')['value']; // search query
						$offset = $this->input->get('start'); // start position
						$data['data'] = $this->User_model->get_all_users(null, $search, $offset, $limit, $order_by, $order);
						$data["draw"] = $this->input->get('draw'); // unique
						$data["recordsTotal"] = $this->User_model->recordsTotal();
						$data["recordsFiltered"] = $this->User_model->get_all_users_recordsFiltered($search);
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
				$_POST = $_POST['data'];
				$data = array(
					'role'			=> $this->input->post('role'),
					'username'		=> $this->input->post('username'),
					'first_name'	=> $this->input->post('first_name'),
					'date_of_birth'	=> $this->input->post('date_of_birth') ? date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_of_birth')))) : NULL,
					'email'			=> $this->input->post('email'),
					'phone'			=> $this->input->post('phone'),
					'password'		=> $this->input->post('password'),
					'r_password'	=> $this->input->post('r_password'),
					'gender'		=> $this->input->post('gender'),
					'status'		=> $this->input->post('status'),
					'last_name'		=> $this->input->post('last_name') ?: NULL,
					'place'			=> $this->input->post('place') ?: NULL,
					'address'		=> $this->input->post('address') ?: NULL,
					'company_name'	=> $this->input->post('company_name') ?: NULL,
					'avatar'		=> $this->input->post('avatar') ?: NULL
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
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'required|min_length[8]|' . $rule_password . '|xss_clean|trim'
					),
					array(
						'field' => 'r_password',
						'label' => 'Repeat Password',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'role',
						'label' => 'Role',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'gender',
						'label' => 'Gender',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'required|min_length[3]|max_length[200]|' . $rule_username . '|xss_clean|trim'
					),
					array(
						'field' => 'first_name',
						'label' => 'First Name',
						'rules' => 'required|min_length[3]|max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'last_name',
						'label' => 'Last Name',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'company_name',
						'label' => 'Company Name',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'date_of_birth',
						'label' => 'Date of Birth',
						'rules' => 'max_length[200]|xss_clean|trim'
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
						'field' => 'avatar',
						'label' => 'Avatar',
						'rules' => 'max_length[200]|' . $rule_avatar . '|xss_clean|trim'
					),
					array(
						'field' => 'place',
						'label' => 'Place',
						'rules' => 'min_length[3]|max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'address',
						'label' => 'Address',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'status',
						'label' => 'Status',
						'rules' => 'required|max_length[50]|xss_clean|trim'
					)
				);
				//$data['error'] = '0';
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
					unset($data['r_password']);
					$this->db->insert(TABLE_USER, $data);
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
				$data = array(
					'role'			=> $this->input->post('role'),
					'username'		=> $this->input->post('username'),
					'first_name'	=> $this->input->post('first_name'),
					'date_of_birth'	=> $this->input->post('date_of_birth') ? date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('date_of_birth')))) : NULL,
					'email'			=> $this->input->post('email'),
					'phone'			=> $this->input->post('phone'),
					'password'		=> $this->input->post('password'),
					'r_password'	=> $this->input->post('r_password'),
					'gender'		=> $this->input->post('gender'),
					'status'		=> $this->input->post('status'),
					'last_name'		=> $this->input->post('last_name') ?: NULL,
					'place'			=> $this->input->post('place') ?: NULL,
					'address'		=> $this->input->post('address') ?: NULL,
					'company_name'	=> $this->input->post('company_name') ?: NULL,
					'avatar'		=> $this->input->post('avatar') ?: NULL
				);
				//$data['name'] = '';
				$this->form_validation->set_data($data);
				$rule_username = 'callback_update_same_username_check[' .  $this->input->post('db')['id'] . ']';
				$rule_email = 'callback_update_same_email_check[' . $this->input->post('db')['id'] . ']';
				$rule_phone = 'callback_update_same_phone_check[' . $this->input->post('db')['id'] . ']';
				$rule_avatar = $this->input->post('avatar') == null ? '' : 'callback_update_same_avatar_check[' . $this->input->post('db')['id'] . ']';
				$config = array(
					array(
						'field' => 'role',
						'label' => 'Role',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'gender',
						'label' => 'Gender',
						'rules' => 'required|xss_clean|trim'
					),
					array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'required|min_length[3]|max_length[200]|' . $rule_username . '|xss_clean|trim'
					),
					array(
						'field' => 'first_name',
						'label' => 'First Name',
						'rules' => 'required|min_length[3]|max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'last_name',
						'label' => 'Last Name',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'company_name',
						'label' => 'Company Name',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'date_of_birth',
						'label' => 'Date of Birth',
						'rules' => 'max_length[200]|xss_clean|trim'
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
						'field' => 'avatar',
						'label' => 'Avatar',
						'rules' => 'max_length[200]|' . $rule_avatar . '|xss_clean|trim'
					),
					array(
						'field' => 'place',
						'label' => 'Place',
						'rules' => 'min_length[3]|max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'address',
						'label' => 'Address',
						'rules' => 'max_length[200]|xss_clean|trim'
					),
					array(
						'field' => 'status',
						'label' => 'Status',
						'rules' => 'required|max_length[50]|xss_clean|trim'
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
						'label' => 'Repeat Password',
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
					$this->db->update(TABLE_USER, $data, array('id' => $this->input->post('db')['id']));
					if ($this->db->affected_rows() == 1) {
						$alert['updated'] = array('success' => true, 'type' => 'success', 'id' => $this->input->post('db')['id'], 'message' => 'Successfully updated user <strong><em>' .  $this->input->post('db')['first_name'] . '</em></strong> !', 'location' => "admin/user");
						$this->session->set_flashdata('alert', $alert);
						echo json_encode($alert['updated']);
					} else if ($this->db->affected_rows() == 0) {
						$alert['updated'] = array('success' => true, 'type' => 'info', 'id' => $this->input->post('db')['id'], 'message' => 'No data changed for user <strong><em>' . $this->input->post('db')['first_name'] . '</em></strong> !', 'location' => "admin/user");
						$this->session->set_flashdata('alert', $alert);
						echo json_encode($alert['updated']);
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
					}
				}
				break;
			case 'DELETE': // delete
				$_POST = $this->input->post('data');
				$id = $this->input->post('id');
				$this->User_model->delete_where(array('id' => $id, 'deletable' => 1));
				$error = $this->db->error();
				if ($error['code'] == 1451) {
					echo json_encode(array('success' => false, 'type' => 'danger', 'id' => $id, 'error' => 'Delete all data associated with the user <strong><i>' . $this->input->post('first_name') . '</i></strong> then try again !'));
				} else if ($error['code'] == 0 && $this->db->affected_rows() == 1) {
					echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'message' => 'Successfully deleted user <strong><em>' . $this->input->post('first_name') . '</em></strong> !'));
				} else {
					echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
				}
				break;
			default:
				$error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method Found !');
				echo json_encode($error);
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
