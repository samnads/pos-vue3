<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Brand_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function dropdown_active($columns = false)
    {
        $columns ? $this->db->select('*') : $this->db->select('
		b.id as id,
        b.name as name');
        $this->db->from(TABLE_BRAND . ' b');
        $query = $this->db->get();
        return $query->result_array();
    }
    function datatable_data($search, $offset, $limit, $order_by, $order, $columns = null)
    {
        $search = trim($search);

        $columns ? $this->db->select($columns) : $this->db->select('
		b.id as id,
        b.code as code,
        b.name as name,
        b.image as image,
        b.description as description,
        b.editable as editable,
        b.deletable as deletable,
        b.added_at as added_at,
        b.updated_at as updated_at,
        b.deleted_at as deleted_at');

        $this->db->from(TABLE_BRAND . ' b');

        $this->db->where(array('b.deleted_at' => NULL)); // select only not deleted rows
        $this->db->group_start();
        $this->db->or_like('b.code', $search);
        $this->db->or_like('b.name', $search);
        $this->db->or_like('b.image', $search);
        $this->db->or_like('b.description', $search);
        $this->db->group_end();

        $this->db->order_by($order_by, $order);
        $this->db->order_by('b.id', 'DESC');

        $query = $this->db->get('', $limit, $offset);

        return $query->result();
    }
    function datatable_recordsFiltered($search)
    {
        $search = trim($search);

        $this->db->select('COUNT(*) as count');

        $this->db->from(TABLE_BRAND . ' b');

        $this->db->where(array('b.deleted_at' => NULL)); // select only not deleted rows
        $this->db->group_start();
        $this->db->or_like('b.code', $search);
        $this->db->or_like('b.name', $search);
        $this->db->or_like('b.image', $search);
        $this->db->or_like('b.description', $search);
        $this->db->group_end();

        $query = $this->db->get();
        $query    = $query->row();
        return $query->count;
    }
    function datatable_recordsTotal()
    {
        $this->db->select('count(id)');
        $this->db->from(TABLE_BRAND . ' b');
        $this->db->where(array('b.deleted_at' => NULL)); // select only not deleted rows
        $query = $this->db->get();
        $cnt = $query->row_array();
        return $cnt['count(id)'];
    }
    function get_AUTO_INCREMENT()
    {
        $this->db->select('AUTO_INCREMENT');
        $this->db->from('INFORMATION_SCHEMA.TABLES');
        $this->db->where(array('TABLE_NAME' => TABLE_BRAND, 'TABLE_SCHEMA' => $this->db->database));
        $query = $this->db->get();
        $cnt = $query->row_array();
        return $cnt['AUTO_INCREMENT'];
    }
    function insert_brand($data)
    {
        $query = $this->db->insert(TABLE_BRAND, $data);
        return $query;
    }
    function update_brand($data, $where)
    {
        $query = $this->db->update(TABLE_BRAND, $data, $where);
        return $query;
    }
    function set_deleted_at($where) // mark as deleted
    {
        $this->db->where($where);
        $this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
        $query = $this->db->update(TABLE_BRAND);
        return $query;
    }
}
