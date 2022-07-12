<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tax_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function datatable_data($search, $offset, $limit, $order_by, $order)
    {
        $search = trim($search);
        $this->db->select('
		tr.id as id,
        tr.name as name,
		tr.code as code,
        tr.rate as rate,
		tr.type as type,
        tr.editable as editable,
        tr.deletable as deletable,
        tr.deleted_at as deleted_at,
		tr.description as description,
        tr.updated_at as updated_at');
        $this->db->from(TABLE_TAX_RATE . ' tr');
        $this->db->where(array('tr.deleted_at' => NULL)); // select only not deleted rows
        $this->db->group_start();
        $this->db->or_like('tr.code', $search);
        $this->db->or_like('tr.name', $search);
        $this->db->or_like('tr.type', $search);
        $this->db->or_like('tr.rate', $search);
        $this->db->or_like('tr.description', $search);
        $this->db->group_end();
        $this->db->order_by($order_by, $order);
        $query = $this->db->get('', $limit, $offset);
        //die($this->db->last_query());
        //die(print_r($query));
        return $query;
    }
    function datatable_recordsFiltered($search)
    {
        $search = trim($search);
        $this->db->select('COUNT(*) as count');
        $this->db->from(TABLE_TAX_RATE . ' tr');
        $this->db->where(array('tr.deleted_at' => NULL)); // select only not deleted rows
        $this->db->group_start();
        $this->db->or_like('tr.code', $search);
        $this->db->or_like('tr.name', $search);
        $this->db->or_like('tr.type', $search);
        $this->db->or_like('tr.rate', $search);
        $this->db->or_like('tr.description', $search);
        $this->db->group_end();
        $query = $this->db->get();
        $query    = $query->row();
        return $query->count;
    }
    function datatable_recordsTotal()
    {
        $this->db->select('count(id)');
        $this->db->from(TABLE_TAX_RATE . ' tr');
        $this->db->where(array('tr.deleted_at' => NULL)); // select only not deleted rows
        $query = $this->db->get();
        $cnt = $query->row_array();
        return $cnt['count(id)'];
    }
    function set_deleted_at($where) // mark as deleted
    {
        $this->db->where($where);
        $this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
        $query = $this->db->update(TABLE_TAX_RATE);
        return $query;
    }
    function insert_tax_rate($data)
    {
        $query = $this->db->insert(TABLE_TAX_RATE, $data);
        return $query;
    }
    function update_tax_rate($data, $where)
    {
        $query = $this->db->update(TABLE_TAX_RATE, $data, $where);
        return $query;
    }



    function deleteByIds($ids)
    {
        $this->db->where_in('id', $ids);
        $query = $this->db->delete(TABLE_TAX_RATE);
        return $query;
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
}
