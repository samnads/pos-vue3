<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Unit_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function dropdown_main_active()
    {
        $query = $this->db->get_where(TABLE_UNIT, array('base' => NULL));
        return $query->result();
    }
    function dropdown_sub_active($id)
    {
        $query = $this->db->get_where(TABLE_UNIT, array('base' => $id));
        return $query->result();
    }
    function datatable_data($search, $offset, $limit, $order_by, $order)
    {
        $search = trim($this->security->xss_clean($search));
        $this->db->select('
        DISTINCT(u.id)     as id,
        u.code   as code,
        u.name   as name,
        u.allow_decimal   as allow_decimal,
        u.base  as base,
        u.operator   as operator,
        u.step   as step,
        u1.code  as base_code,
        u1.name  as base_name,
        u.deletable   as deletable,
        u.editable   as editable,
        u.deleted_at as deleted_at,
        u.description      as description');
        $this->db->from(TABLE_UNIT . ' u');
        $this->db->join(TABLE_UNIT . ' u1',    'u1.id=u.base', 'left');
        $this->db->where(array('u.deleted_at' => NULL)); // select only not deleted rows
        $this->db->group_start();
        $this->db->or_like('u.name',    $search);
        $this->db->or_like('u.code',    $search);
        $this->db->or_like('u.step',    $search);
        $this->db->or_like('u.operator',    $search);
        $this->db->or_like('u.description',    $search);
        $this->db->group_end();
        $this->db->order_by($order_by, $order);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('');
        return $query->result();
    }
    function datatable_recordsFiltered($search)
    {
        $search = trim($this->security->xss_clean($search));
        $this->db->select('COUNT(*) as count');
        $this->db->where(array('u.deleted_at' => NULL)); // select only not deleted rows
        $this->db->group_start();
        $this->db->or_like('u.name',    $search);
        $this->db->or_like('u.code',    $search);
        $this->db->or_like('u.step',    $search);
        $this->db->or_like('u.operator',    $search);
        $this->db->or_like('u.description',    $search);
        $this->db->group_end();
        $query = $this->db->get(TABLE_UNIT . ' u');
        $query    = $query->row();
        return $query->count;
    }
    function datatable_recordsTotal()
    {
        $this->db->select('count(id)');
        $this->db->from(TABLE_UNIT . ' u');
        $this->db->where(array('u.deleted_at' => NULL)); // select only not deleted rows
        $query = $this->db->get();
        $cnt = $query->row_array();
        return $cnt['count(id)'];
    }
    function insert_unit($data)
    {
        $query = $this->db->insert(TABLE_UNIT, $data);
        return $query;
    }
    function insert_sub_unit($data)
    {
        $query = $this->db->insert(TABLE_UNIT, $data);
        return $query;
    }
    function update_unit($data, $where)
    {
        $query = $this->db->update(TABLE_UNIT, $data, $where);
        return $query;
    }
    function update_sub_unit($data, $where)
    {
        $query = $this->db->update(TABLE_UNIT, $data, $where);
        return $query;
    }
    function set_deleted_at($where) // mark as deleted
    {
        $this->db->where($where);
        $this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
        $query = $this->db->update(TABLE_UNIT);
        return $query;
    }
}
