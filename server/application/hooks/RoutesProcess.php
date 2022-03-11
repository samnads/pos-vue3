<?php
class Classname
{
    private $CI;
    function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model("admin/Permission_model");
    }
    function checkAdminLogin() // logged in or not ?
    {
        if (!$this->CI->session->login && !isset($this->CI->login_redirect)) { // not logged in
            if ($this->CI->uri->segment(2) != "ajax") { // not an ajax request
                $this->CI->session->set_userdata('redirect', uri_string()); // save link for later
                redirect('admin/login', 'location', 302);
            } else { // ajax request
                die(json_encode(array('success' => false, 'type' => "danger", 'error' => "Login to continue !", 'location' => "admin/login")));
            }
        } else {
            /*
            $module = $this->CI->uri->segment(2);
            $row = $this->CI->Permission_model->get_role_module_permission($this->CI->session->role_id, $module, 'TEST');
            if ($row['allow'] !== 1) {
                $alert['denied'] = array('type' => 'danger', 'message' => 'Page Access Denied ! - ' . uri_string(), 'timeout' => 5000);
                $this->CI->session->set_flashdata('alert', $alert);
                redirect('admin/roles', 'location', 302);
                //$denied = array('success' => false, 'type' => 'danger', 'error' => 'You don\'t have the right to perform this action !');
                //die(json_encode($denied));
            }*/
        }
    }
    function ajaxPermCheck() // check for allowed ajax action
    {
        if ($this->CI->uri->segment(2) == 'ajax') {
            if ($this->CI->session->login && ($this->CI->uri->segment(3) != "logout" && $this->CI->uri->segment(3) != "login")) {
                $module = $this->CI->uri->segment(3);
                $row = $this->CI->Permission_model->get_role_module_permission($this->CI->session->role_id, $module, $_SERVER['REQUEST_METHOD']);
                if ($row['allow'] !== 1) {
                    $denied = array('success' => false, 'type' => 'danger', 'error' => 'You don\'t have the right to perform this action !');
                    die(json_encode($denied));
                }
            }
        }
    }
}
