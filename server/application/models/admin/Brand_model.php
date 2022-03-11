<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Brand_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_all_brands()
    {
        $query = $this->db->get(TABLE_BRAND);
        return $query->result();
    }
    function search_brands($query)
    {
        $query = trim($query);
        $this->db->select('*');
        $this->db->from(TABLE_BRAND . ' b');
        $this->db->or_like('b.name', $query);
        $this->db->or_like('b.code', $query);
        $this->db->or_like('b.description', $query);
        $query = $this->db->get();
        return $query->result();
    }
    function deleteById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete(TABLE_BRAND);
        return $query;
    }
}
