<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Status_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function getall_active_4_frontend()
    {
        $this->db->select('*');
        $this->db->from(TABLE_STATUS . ' s');
        $query = $this->db->get();
        return $query->result();
    }
}
