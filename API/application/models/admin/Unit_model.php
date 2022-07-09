<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Unit_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_all_units()
    {
        $query = $this->db->get(TABLE_UNIT);
        return $query->result();
    }
    function getDefUnit()
    {
        $query = $this->db->get_where(TABLE_UNIT, array('id' => 1));;
        return $query->row();
    }
    function getSingleUnit($id)
    {
        $query = $this->db->get_where(TABLE_UNIT, array('id' => $id));;
        return $query->row();
    }
    function get_bulk_units($id)
    {
        $query = $this->db->get_where(TABLE_UNIT_BULK, array('unit' => $id));
        return $query->result();
    }
    function list_unit_and_bulk($search, $offset, $limit, $order_by, $order)
    {
        $search = $this->security->xss_clean($search);
        $search = trim($search);
        $this->db->select('ub.id    as id,
                        ub.name     as name,
                        ub.code     as code,
                        u.name     as unit,
                        ub.value       as value');
        $this->db->from(TABLE_UNIT_BULK . ' ub');
        $this->db->join(TABLE_UNIT . '		u',    'u.id=ub.unit',    'left');
        $this->db->or_like('ub.code',    $search);
        $this->db->or_like('ub.name',    $search);
        //$this->db->order_by($order_by, $order);

        $query1 = $this->db->get_compiled_select();
        // $results_unit_bulk = $this->db->get()->result_array();

        $this->db->select('u.id     as id,
                        u.name      as name,
                        u.code      as code,
                       (NULL)    as unit,
                        (NULL)     as value');
        $this->db->from(TABLE_UNIT . ' u');
        $this->db->or_like('u.code',    $search);
        $this->db->or_like('u.name',    $search);
        //$this->db->order_by($order_by, $order);

        $query2 = $this->db->get_compiled_select();
        // $results_unit = $this->db->get()->result_array();
        //$results = array_merge($results_unit, $results_unit_bulk);
        //return $results;
        $this->db->order_by($order_by, $order);
        $query = $this->db->query($query1 . " UNION " . $query2 . " order by " . $order_by . " " . $order . " limit " . $offset . "," . $limit);
        return $query->result();
    }
    function datatable_data($search, $offset, $limit, $order_by, $order)
    {
        $search = trim($this->security->xss_clean($search));
        $this->db->select('
        u.id     as id,
        u.name   as name,
        u.code   as code,
        u.deletable   as deletable,
        u.editable   as editable,
        u.deleted_at as deleted_at,
        u.description      as description');

        $this->db->where(array('u.deleted_at' => NULL)); // select only not deleted rows

        $this->db->group_start();
        $this->db->or_like('u.name',    $search);
        $this->db->or_like('u.code',    $search);
        $this->db->or_like('u.description',    $search);
        $this->db->group_end();

        $this->db->order_by($order_by, $order);
        $this->db->limit($limit, $offset);
        $query = $this->db->get(TABLE_UNIT . ' u');
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
    function sub_datatable_units($search, $offset, $limit, $order_by, $order)
    {
        $search = trim($this->security->xss_clean($search));
        $this->db->select(' u.id     as id,
                            u.name      as name,
                            u.code      as code,
                            u.description      as description');
        $this->db->or_like('u.name',    $search);
        $this->db->or_like('u.code',    $search);
        $this->db->or_like('u.description',    $search);
        $this->db->order_by($order_by, $order);
        $this->db->limit($limit, $offset);
        $query = $this->db->get(TABLE_UNIT_BULK . ' u');
        return $query->result();
    }
    function sub_datatable_units_count($search)
    {
        $search = trim($this->security->xss_clean($search));
        $this->db->select('COUNT(*) as count');
        $this->db->or_like('u.name', $search);
        $this->db->or_like('u.code', $search);
        $this->db->or_like('u.description', $search);
        $query = $this->db->get(TABLE_UNIT_BULK . ' u');
        $query    = $query->row();
        return $query->count;
    }
    function sub_totalRows()
    {
        $this->db->select('count(id)');
        $query = $this->db->get(TABLE_UNIT_BULK);
        $cnt = $query->row_array();
        return $cnt['count(id)'];
    }
    function datatable_subunits($search, $offset, $limit, $order_by, $order)
    {
        $search = trim($this->security->xss_clean($search));
        $this->db->select('ub.id               as id,
                        ub.name             as name,
                        ub.code             as code,
                        ub.value            as value,
                        ub.description      as description,
                        u.id                as unit_id,
                        u.name              as unit_name,
                        u.code              as unit_code,
                        u.description       as unit_description');
        $this->db->from(TABLE_UNIT_BULK . ' ub');
        $this->db->join(TABLE_UNIT . '		u',    'u.id=ub.unit',    'left');
        $this->db->or_like('ub.name',    $search);
        $this->db->or_like('ub.code',    $search);
        $this->db->or_like('ub.description',    $search);
        $this->db->order_by($order_by, $order);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('');
        return $query->result();
    }
    function delete_subunit($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete(TABLE_UNIT_BULK);
        return $query;
    }
    function delete_unit($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete(TABLE_UNIT);
        return $query;
    }


    function insert_unit($data)
    {
        $query = $this->db->insert(TABLE_UNIT, $data);
        return $query;
    }
    function update_unit($data, $where)
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
