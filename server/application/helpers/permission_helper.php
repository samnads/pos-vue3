<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function check_perm_redirect($permission)
{
    $CI = &get_instance();
    $role_id = $CI->session->role_id;
    $module = $CI->uri->segment(2);
    $row = $CI->Permission_model->get_role_module_permission($role_id, $module, $permission);
    if ($row['allow'] !== 1) {
        $alert['denied'] = array('success' => false, 'type' => 'danger', 'message' => 'You don\'t have the right to access this page!');
        $CI->session->set_flashdata('alert', $alert);
        redirect(base_url('admin'));
        die();
    }
}
