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
            if ($this->CI->session->login && ($this->CI->uri->segment(3) != "auth")) {
                $module = $this->CI->uri->segment(3);
                $getData = $this->CI->input->get();
                $postData = $this->CI->input->post();
                $action = null;
                if (isset($getData['action'])) {
                    $action = $getData['action'];
                } else if (isset($postData['action'])) {
                    $action = $postData['action'];
                } else {
                    $post = raw_input_to_post();
                    if (!isset($post['action'])) {
                        die(json_encode(array('success' => false, 'type' => 'danger', 'error' => 'There is no action specified in your request !')));
                    }
                    $action = $post['action'];
                }
                //$row = $this->CI->Permission_model->get_role_module_permission($this->CI->session->role, $module, $_SERVER['REQUEST_METHOD']);
                $row = $this->CI->Permission_model->get_role_module_permission($this->CI->session->role, $module, $action);
                if ($row['allow'] !== 1 && $module != "common") {
                    die(json_encode(array('success' => false, 'type' => 'danger', 'error' => 'You don\'t have the right to perform [' . $module . ' - ' . $action . '] action !')));
                }
            }
        }
    }
}
