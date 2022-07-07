<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tax_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_all_taxes($all = false)
    {
        $all ? $this->db->select('*') : $this->db->select('
		tr.id as id,
        tr.name as name,
		tr.code as code,
        tr.type as type,
        tr.rate as rate,
        tr.description as description');
        $this->db->from(TABLE_TAX_RATE . '  tr');
        $query = $this->db->get();
        return $query->result();
    }
    function listTaxes($search, $offset, $limit, $order_by, $order)
    {
        $search = trim($search);
        $this->db->select('
		tr.id as id,
        tr.name as name,
		tr.code as code,
        tr.rate as rate,
		tr.type as type,
		tr.description as description,
        tr.updated_at as updated_at');
        $this->db->from(TABLE_TAX_RATE . ' tr');

        $this->db->or_like('tr.code', $search);
        $this->db->or_like('tr.name', $search);
        $this->db->or_like('tr.type', $search);
        $this->db->or_like('tr.rate', $search);
        $this->db->or_like('tr.description', $search);

        $this->db->order_by($order_by, $order);
        $query = $this->db->get('', $limit, $offset);
        //die($this->db->last_query());
        //die(print_r($query));
        return $query;
    }
    function listTaxes_FilteredCount($search)
    {
        $search = trim($search);
        $this->db->select('COUNT(*) as count');
        $this->db->from(TABLE_TAX_RATE . ' tr');
        $this->db->or_like('tr.code', $search);
        $this->db->or_like('tr.name', $search);
        $this->db->or_like('tr.type', $search);
        $this->db->or_like('tr.rate', $search);
        $this->db->or_like('tr.description', $search);

        $query = $this->db->get();
        $query    = $query->row();
        return $query->count;
    }
    function totalRows()
    {
        $this->db->select('count(id)');
        $query = $this->db->get(TABLE_TAX_RATE);
        $cnt = $query->row_array();
        return $cnt['count(id)'];
    }
    function deleteById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete(TABLE_TAX_RATE);
        return $query;
    }
    function deleteByIds($ids)
    {
        $this->db->where_in('id', $ids);
        $query = $this->db->delete(TABLE_TAX_RATE);
        return $query;
    }
}
