<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Permission_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_all_permissions()
    {
        $this->db->select('p.id,p.name');
        $this->db->from(TABLE_PERMISSION . ' p');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_role_module_permission($role, $module, $permission = 'GET')
    {
        $this->db->select('
        rp.role_id,
        rp.module_id,
        rp.permission_id,
        r.name as role_name,
        m.name as module_name,
        p.name as permission_name,
        rp.allow');

        $this->db->from(TABLE_ROLE_PERMISSION . ' rp');
        $this->db->join(TABLE_ROLE . ' r', 'rp.role_id=r.id', 'left');
        $this->db->join(TABLE_MODULE . ' m', 'rp.module_id=m.id', 'left');
        $this->db->join(TABLE_PERMISSION . ' p', 'rp.permission_id=p.id', 'left');

        $this->db->where('r.id', $role);
        $this->db->where('m.name', $module);
        $this->db->where('p.name', $permission);

        $query  = $this->db->get();
        return $query->row_array();
    }
}
