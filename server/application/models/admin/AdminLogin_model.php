<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AdminLogin_model extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function getRow($where)
    {
        $this->db->select('*');
        $this->db->from(TABLE_ADMIN);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();
    }
    function updateLogin($id)
    {
        $this->db->set('login_at','NOW()',FALSE);
        $this->db->set('client_ip',$this->input->ip_address());
        $this->db->where('id',$id);
        $query = $this->db->update(TABLE_ADMIN);
        return $query;
    }
    function updateLogout($id)
    {
        $this->db->set('logout_at','NOW()',FALSE);
        $this->db->set('client_ip',$this->input->ip_address());
        $this->db->where('id',$id);
        $query = $this->db->update(TABLE_ADMIN);
        return $query;
    }
}
?>