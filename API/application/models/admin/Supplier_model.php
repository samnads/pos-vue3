<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Supplier_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function dropdown_active()
    {
        $this->db->select('s.id,s.name');
        $this->db->from(TABLE_SUPPLIER . ' s');
        $query = $this->db->get();
        return $query->result();
    }
    function get_all_supplier($all, $columns, $search, $offset, $limit, $order_by, $order)
    {
        $search = trim($search);

        $all ? $this->db->select('*') : ($columns == null ? $this->db->select('
		s.id as id,
        s.name as name,
		s.code as code,
        s.place as place,
        s.address as address,
        s.pin_code as pin_code,
        s.city as city,
        s.email as email,
        s.phone as phone,
        s.gst_no as gst_no,
        s.tax_no as tax_no,
        s.description as description,
        s.editable as editable,
        s.deletable as deletable,
        s.deleted_at as deleted_at,
        s.updated_at as updated_at') : $this->db->select($columns));

        $this->db->where(array('s.deleted_at' => NULL)); // select only not deleted rows
        $this->db->group_start();
        $this->db->or_like('s.name', $search);
        $this->db->or_like('s.code', $search);
        $this->db->or_like('s.place', $search);
        $this->db->or_like('s.address', $search);
        $this->db->or_like('s.pin_code', $search);
        $this->db->or_like('s.city', $search);
        $this->db->or_like('s.email', $search);
        $this->db->or_like('s.phone', $search);
        $this->db->or_like('s.gst_no', $search);
        $this->db->or_like('s.tax_no', $search);
        $this->db->group_end();

        $this->db->order_by($order_by, $order);

        $query = $this->db->get(TABLE_SUPPLIER . ' s', $limit, $offset);

        return $query->result();
    }
    function get_all_supplier_recordsFiltered($search)
    {
        $search = trim($search);

        $this->db->select('COUNT(*) as count');

        $this->db->from(TABLE_SUPPLIER . ' s');

        $this->db->where(array('s.deleted_at' => NULL)); // select only not deleted rows
        $this->db->group_start();
        $this->db->or_like('s.name', $search);
        $this->db->or_like('s.code', $search);
        $this->db->or_like('s.place', $search);
        $this->db->or_like('s.address', $search);
        $this->db->or_like('s.pin_code', $search);
        $this->db->or_like('s.city', $search);
        $this->db->or_like('s.email', $search);
        $this->db->or_like('s.phone', $search);
        $this->db->or_like('s.gst_no', $search);
        $this->db->or_like('s.tax_no', $search);
        $this->db->group_end();

        $query = $this->db->get();
        $query    = $query->row();
        return $query->count;
    }
    function getSupplier($id, $columns)
    {

        $columns ? $this->db->select($columns) : $this->db->select('
		s.id as id,
        s.name as name,
		s.code as code,
        s.place as place,
        s.address as address,
        s.pin_code as pin_code,
        s.city as city,
        s.email as email,
        s.phone as phone,
        s.gst_no as gst_no,
        s.tax_no as tax_no,
        s.description as description,
        s.editable as editable,
        s.deletable as deletable,
        s.deleted_at as deleted_at,
        s.updated_at as updated_at');

        $this->db->from(TABLE_SUPPLIER . ' s');

        $this->db->where(array('s.id' => $id));

        $query = $this->db->get();
        return  $query->row_array();
    }
    function recordsTotal()
    {
        $this->db->select('count(id)');
        $this->db->from(TABLE_SUPPLIER . ' s');
        $this->db->where(array('s.deleted_at' => NULL)); // select only not deleted rows
        $query = $this->db->get();
        $cnt = $query->row_array();
        return $cnt['count(id)'];
    }
    function get_AUTO_INCREMENT()
    {
        $this->db->select('AUTO_INCREMENT');
        $this->db->from('INFORMATION_SCHEMA.TABLES');
        $this->db->where(array('TABLE_NAME' => TABLE_SUPPLIER, 'TABLE_SCHEMA' => $this->db->database));
        $query = $this->db->get();
        $cnt = $query->row_array();
        return $cnt['AUTO_INCREMENT'];
    }
    function update($id, $data)
    {
        $this->db->where(array('id' => $id, 'editable' => NULL, 'deleted_at' => NULL));
        $query = $this->db->update(TABLE_SUPPLIER, $data);
        return $query;
    }
    function set_deleted_at($where)
    {
        $this->db->where($where);
        $this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
        $query = $this->db->update(TABLE_SUPPLIER);
        return $query;
    }
    function delete_wherein_id($ids, $where)
    {
        $this->db->where_in('id', $ids);
        $this->db->where($where);
        $query = $this->db->delete(TABLE_SUPPLIER);
        return $query;
    }
}
