<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Customer_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	function suggestCustomerForPos($search, $offset, $limit, $order_by, $order)
	{
		//CONCAT(c.name,"  ~  ",c.place)	as name,
		$search = trim($search);
		$this->db->select('
		c.id	as id,
		c.name	as name,
		c.place	as place');
		$this->db->from(TABLE_CUSTOMER . ' c');
		$this->db->or_like('c.name', $search);
		$this->db->or_like('c.place', $search);
		$this->db->or_like('c.email', $search);
		$this->db->or_like('c.phone', $search);
		$this->db->or_like('c.address', $search);
		$this->db->order_by($order_by, $order);
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query;
	}
	function datatable_recordsTotal()
	{
		$this->db->select('count(id)');
		$this->db->from(TABLE_CUSTOMER . ' c');
		$this->db->where(array('c.deleted_at' => NULL)); // select only not deleted rows
		$query = $this->db->get();
		$cnt = $query->row_array();
		return $cnt['count(id)'];
	}
	function datatable_data($search, $offset, $limit, $order_by, $order, $columns = null)
	{
		$search = trim($search);

		$columns == null ? $this->db->select('
		c.id as id,
        c.name as name,
		c.code as code,
        c.place as place,
        c.email as email,
        c.phone as phone,
		c.address as address,
		c.description as description,
		c.city as city,
		c.pin_code as pin_code,
		c.editable as editable,
		c.deletable as deletable,
		c.deleted_at as deleted_at,
        c.updated_at as updated_at,
        
		cg.id as group,
		cg.name as group_name,
		cg.percentage as group_percentage') : $this->db->select($columns);

		$this->db->join(TABLE_CUSTOMER_GROUP . ' cg', 'cg.id=c.group', 'left');

		$this->db->where(array('c.deleted_at' => NULL)); // select only not deleted rows
		$this->db->group_start();
		$this->db->or_like('c.name', $search);
		$this->db->or_like('c.place', $search);
		$this->db->or_like('c.address', $search);
		$this->db->or_like('c.email', $search);
		$this->db->or_like('c.phone', $search);
		$this->db->or_like('cg.name', $search);
		$this->db->group_end();

		$this->db->order_by($order_by, $order);
		$this->db->order_by('c.id', 'DESC');

		$query = $this->db->get(TABLE_CUSTOMER . ' c', $limit, $offset);

		return $query->result();
	}
	function getCustomer($where, $columns = null)
	{
		$columns ? $this->db->select($columns) : $this->db->select('
		c.id as id,
        c.name as name,
        c.place as place,
        c.email as email,
        c.phone as phone,
		c.address as address,
		c.description as description,
		c.city as city,
		c.pin_code as pin_code,
		c.editable as editable,
		c.deletable as deletable,
		c.deleted_at as deleted_at,
        c.updated_at as updated_at');

		$this->db->from(TABLE_CUSTOMER . ' c');

		$this->db->where($where);

		$query = $this->db->get();
		return  $query->row_array();
	}
	function datatable_recordsFiltered($search)
	{
		$search = trim($search);

		$this->db->select('COUNT(*) as count');

		$this->db->from(TABLE_CUSTOMER . ' c');
		$this->db->join(TABLE_CUSTOMER_GROUP . ' cg', 'cg.id=c.group', 'left');

		$this->db->where(array('c.deleted_at' => NULL)); // select only not deleted rows
		$this->db->group_start();
		$this->db->or_like('c.name', $search);
		$this->db->or_like('c.place', $search);
		$this->db->or_like('c.address', $search);
		$this->db->or_like('c.email', $search);
		$this->db->or_like('c.phone', $search);
		$this->db->or_like('cg.name', $search);
		$this->db->group_end();

		$query = $this->db->get();
		$query    = $query->row();
		return $query->count;
	}
	function get_AUTO_INCREMENT()
	{
		$this->db->select('AUTO_INCREMENT');
		$this->db->from('INFORMATION_SCHEMA.TABLES');
		$this->db->where(array('TABLE_NAME' => TABLE_CUSTOMER, 'TABLE_SCHEMA' => $this->db->database));
		$query = $this->db->get();
		$cnt = $query->row_array();
		return $cnt['AUTO_INCREMENT'];
	}
	function insert_customer($data)
	{
		$query = $this->db->insert(TABLE_CUSTOMER, $data);
		return $query;
	}
	function update_customer($data, $where)
	{
		$query = $this->db->update(TABLE_CUSTOMER, $data, $where);
		return $query;
	}
	function set_deleted_at($where) // mark as deleted
	{
		$this->db->where($where);
		$this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
		$query = $this->db->update(TABLE_CUSTOMER);
		return $query;
	}
	function set_deleted_at_multi($ids, $where) // mark rows as deleted
	{
		$this->db->where_in('id', $ids);
		$this->db->where($where);
		$this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
		$query = $this->db->update(TABLE_CUSTOMER);
		return $query;
	}
}
