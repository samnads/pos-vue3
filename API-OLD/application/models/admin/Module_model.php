<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Module_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_all_modules()
    {
        $this->db->select('m.id,m.name');
        $this->db->from(TABLE_MODULE . ' m');
        $query = $this->db->get();
        return $query->result_array();
    }
    function available_module_permissions()
    {
        $this->db->select('
		mp.module		as module,
        mp.permission	as permission,
		m.name		    as module_name,
        p.name		    as permission_name');
        $this->db->from(TABLE_MODULE_PERMISSION . ' mp');
        $this->db->join(TABLE_MODULE . '		m',    'm.id=mp.module', 'left');
        $this->db->join(TABLE_PERMISSION . '	p',    'p.id=mp.permission', 'left');
        $query = $this->db->get();
        die($this->db->last_query());
        return $query->result_array();
    }
}
