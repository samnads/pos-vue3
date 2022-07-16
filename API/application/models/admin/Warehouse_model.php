<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Warehouse_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function dropdown_active()
    {
        $this->db->select('wh.id,wh.name');
        $this->db->from(TABLE_WAREHOUSE . ' wh');
        $query = $this->db->get();
        return $query->result();
    }
    function datatable_data($search, $offset, $limit, $order_by, $order, $columns = null)
    {
        $search = trim($search);

        $columns ? $this->db->select($columns) : $this->db->select('
		wh.id as id,
        wh.code as code,
        wh.name as name,
        wh.place as place,
        wh.phone as phone,
        wh.email as email,
        wh.address as address,
        wh.country as country,
        wh.city as city,
        wh.pin_code as pin_code,
        wh.description as description,
        wh.date_of_open as date_of_open,
        wh.status_reason as status_reason,
        wh.editable as editable,
        wh.deletable as deletable,
        wh.deleted_at as deleted_at,
        
        s.id as status,
        s.name as status_name,
        s.css_class as css_class,');

        $this->db->from(TABLE_WAREHOUSE . ' wh');
        $this->db->join(TABLE_STATUS . ' s', 's.id=wh.status', 'left');

        $this->db->where(array('wh.deleted_at' => NULL)); // select only not deleted rows
        $this->db->group_start();
        $this->db->or_like('wh.code', $search);
        $this->db->or_like('wh.name', $search);
        $this->db->or_like('wh.place', $search);
        $this->db->or_like('wh.email', $search);
        $this->db->or_like('wh.address', $search);
        $this->db->or_like('wh.phone', $search);
        $this->db->or_like('wh.date_of_open', $search);
        $this->db->or_like('wh.status_reason', $search);
        $this->db->or_like('wh.description', $search);
        $this->db->group_end();

        $this->db->order_by($order_by, $order);
        $this->db->order_by('wh.id', 'DESC');

        $query = $this->db->get('', $limit, $offset);

        return $query->result();
    }
    function datatable_recordsTotal()
    {
        $this->db->select('count(id)');
        $this->db->from(TABLE_WAREHOUSE . ' wh');
        $this->db->where(array('wh.deleted_at' => NULL)); // select only not deleted rows
        $query = $this->db->get();
        $cnt = $query->row_array();
        return $cnt['count(id)'];
    }
    function datatable_recordsFiltered($search)
    {
        $search = trim($search);

        $this->db->select('COUNT(*) as count');

        $this->db->from(TABLE_WAREHOUSE . ' wh');

        $this->db->where(array('wh.deleted_at' => NULL)); // select only not deleted rows
        $this->db->group_start();
        $this->db->or_like('wh.code', $search);
        $this->db->or_like('wh.name', $search);
        $this->db->or_like('wh.place', $search);
        $this->db->or_like('wh.email', $search);
        $this->db->or_like('wh.address', $search);
        $this->db->or_like('wh.phone', $search);
        $this->db->or_like('wh.date_of_open', $search);
        $this->db->or_like('wh.status_reason', $search);
        $this->db->or_like('wh.description', $search);
        $this->db->group_end();

        $query = $this->db->get();
        $query    = $query->row();
        return $query->count;
    }
    function get_AUTO_INCREMENT()
    {
        $this->db->select('AUTO_INCREMENT');
        $this->db->from('INFORMATION_SCHEMA.TABLES');
        $this->db->where(array('TABLE_NAME' => TABLE_WAREHOUSE, 'TABLE_SCHEMA' => $this->db->database));
        $query = $this->db->get();
        $cnt = $query->row_array();
        return $cnt['AUTO_INCREMENT'];
    }
    function insert_warehouse($data)
    {
        $query = $this->db->insert(TABLE_WAREHOUSE, $data);
        return $query;
    }
    function update_warehouse($data, $where)
    {
        $query = $this->db->update(TABLE_WAREHOUSE, $data, $where);
        return $query;
    }
    function set_deleted_at($where) // mark as deleted
    {
        $this->db->where($where);
        $this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
        $query = $this->db->update(TABLE_WAREHOUSE);
        return $query;
    }
}
