<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Warehouse_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_all_data()
    {
        $this->db->select('*');
        $this->db->from(TABLE_WAREHOUSE . ' wh');
        $query = $this->db->get();
        return $query->result();
    }
    function dropdown_all()
    {
        $this->db->select('wh.id,wh.name');
        $this->db->from(TABLE_WAREHOUSE . ' wh');
        $query = $this->db->get();
        return $query->result();
    }
    function get_all_warehouses_filter_column($columns = array('wh.id', 'wh.name', 'wh.code', 'wh.phone', 'wh.email', 'wh.address', 'wh.description', 'wh.longitude', 'wh.latitude'))
    {
        $this->db->select($columns);
        $this->db->from(TABLE_WAREHOUSE . ' wh');
        $query = $this->db->get();
        return $query->result();
    }
    function search_warehouses($query, $columns = array('wh.id', 'wh.name', 'wh.code', 'wh.phone', 'wh.email', 'wh.address', 'wh.description', 'wh.longitude', 'wh.latitude'))
    {
        $query = trim($query);
        $this->db->select($columns);
        $this->db->from(TABLE_WAREHOUSE . ' wh');
        $this->db->or_like('wh.name', $query);
        $this->db->or_like('wh.code', $query);
        $this->db->or_like('wh.phone', $query);
        $this->db->or_like('wh.email', $query);
        $this->db->or_like('wh.address', $query);
        $this->db->or_like('wh.description', $query);
        $query = $this->db->get();
        return $query->result();
    }
    function deleteById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete(TABLE_WAREHOUSE);
        return $query;
    }
}
