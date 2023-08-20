<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{
    public $login_redirect = FALSE;
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json; charset=utf-8');
        $this->load->model('admin/User_model');
    }
    public function index()
    {
        $post = $this->input->raw_input_stream;
        $post = json_decode($post);
        $_POST = json_decode(json_encode($post), true);
        switch ($this->input->post('action')) {
            case 'login':
                $_POST = $this->input->post('data');
                $row = $this->User_model->getRow(array('username' => $this->input->post('username')));
                if ($row) { // username exist
                    if (password_verify($this->input->post('password'), $row['password'])) { // password correct
                        $session = array('login' => true, 'id' => $row['id'], 'username' => $row['username'], 'first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'avatar' => $row['avatar'], 'role' => $row['role']);
                        $this->session->set_userdata($session); // set session
                        $query = $this->User_model->updateLogin($row['id']); // update db
                        $alert['login'] = array('type' => 'success', 'message' => 'Hi, ' . $this->session->first_name . ' ' . $this->session->last_name . ' what\'s up ?', 'timeout' => 5000);
                        if (date_format(date_create($row['date_of_birth']), 'm-d') == date('m-d')) : // if birthday
                            $alert['birthday'] = array('type' => 'info', 'message' => ' Happy Birthday ' . $this->session->first_name . ' ' . $this->session->last_name . '. What\'s wrong, this is your day. Enjoy :)', 'timeout => 5000');
                        endif;
                        $this->session->set_flashdata('alert', $alert);
                        $this->session->mark_as_flash('redirect'); // use already saved redirect link
                        $data = array('success' => true, 'type' => 'success', 'message' => 'Logged in, Please wait...', 'location' => $this->session->flashdata('redirect') ? base_url($this->session->flashdata('redirect')) : "admin");
                    } else { // password incorrect
                        $data = array('success' => false, 'type' => 'danger', 'message' => 'Incorrect password !', 'timeout' => '');
                    }
                } else {
                    $data = array('success' => false, 'type' => 'danger', 'message' => 'Username you entered doesn\'t exist.', 'timeout' => '5000');
                }
                echo json_encode($data);
                break;
            case 'logout':
                if ($this->input->server('REQUEST_METHOD') === 'POST') {
                    $this->User_model->updateLogout($this->session->id); // update db
                    $this->session->sess_destroy();
                    $data = array('success' => true, 'location' => "admin/login");
                    echo json_encode($data);
                } else {
                    redirect('admin/login', 'location', 301);
                }
                break;
            default:
                echo json_encode(array('success' => false, 'type' => 'danger', 'message' => 'Data Error - Unknown Action !', 'timeout' => '5000'));
        }
    }
}
