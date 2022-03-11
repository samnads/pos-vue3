<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Product_Type_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function getAll($all = false)
    {
        $all ? $this->db->select('*') : $this->db->select('
		pt.id as id,
        pt.name as name');
        $this->db->from(TABLE_PRODUCT_TYPE . ' pt');
        $query = $this->db->get();
        return $query->result();
    }
    function getDefault()
    {
    }
}
