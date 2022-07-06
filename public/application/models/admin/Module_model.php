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
}
