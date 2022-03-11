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
	function recordsTotal()
	{
		$this->db->select('count(id)');
		$query = $this->db->get(TABLE_CUSTOMER);
		$cnt = $query->row_array();
		return $cnt['count(id)'];
	}
	function get_all_customer($all = false, $columns = null, $search, $offset, $limit, $order_by, $order)
	{
		$search = trim($search);

		$all ? $this->db->select('*') : ($columns == null ? $this->db->select('
		c.id as id,
        c.name as name,
        c.place as place,
        c.email as email,
        c.phone as phone,
		c.address as address,
		c.editable as editable,
		c.deletable as deletable,
        c.updated_at as updated_at,
        
		cg.id as group,
		cg.name as group_name,
		cg.percentage as group_percentage') : $this->db->select($columns));

		$this->db->join(TABLE_CUSTOMER_GROUP . ' cg', 'cg.id=c.group', 'left');

		$this->db->or_like('c.name', $search);
		$this->db->or_like('c.place', $search);
		$this->db->or_like('c.address', $search);
		$this->db->or_like('c.email', $search);
		$this->db->or_like('c.phone', $search);
		$this->db->or_like('cg.name', $search);

		$this->db->order_by($order_by, $order);
		$this->db->order_by('c.id', 'DESC');

		$query = $this->db->get(TABLE_CUSTOMER . ' c', $limit, $offset);

		return $query->result();
	}
	function getCustomer($id, $columns)
	{

		$columns ? $this->db->select($columns) : $this->db->select('
		c.id as id,
		c.name as name,
		c.place as place,
		c.email as email,
		c.phone as phone,
		c.address as address,
        c.editable as editable,
		c.deletable as deletable');

		$this->db->from(TABLE_CUSTOMER . ' c');

		$this->db->where(array('c.id' => $id));

		$query = $this->db->get();
		return  $query->row_array();
	}
	function get_all_customer_recordsFiltered($search)
	{
		$search = trim($search);

		$this->db->select('COUNT(*) as count');

		$this->db->from(TABLE_CUSTOMER . ' c');
		$this->db->join(TABLE_CUSTOMER_GROUP . ' cg', 'cg.id=c.group', 'left');

		$this->db->or_like('c.name', $search);
		$this->db->or_like('c.place', $search);
		$this->db->or_like('c.address', $search);
		$this->db->or_like('c.email', $search);
		$this->db->or_like('c.phone', $search);
		$this->db->or_like('cg.name', $search);

		$query = $this->db->get();
		$query    = $query->row();
		return $query->count;
	}
	function get_AUTO_INCREMENT()
	{
		$this->db->select('AUTO_INCREMENT');
		$this->db->from('INFORMATION_SCHEMA.TABLES');
		$this->db->where(array('TABLE_NAME' => TABLE_CUSTOMER));
		$query = $this->db->get();
		$cnt = $query->row_array();
		return $cnt['AUTO_INCREMENT'];
	}
	function delete_where($where)
	{
		$this->db->where($where);
		$query = $this->db->delete(TABLE_CUSTOMER);
		return $query;
	}
	function delete_wherein_id($ids)
	{
		$this->db->where_in('id', $ids);
		$query = $this->db->delete(TABLE_CUSTOMER);
		return $query;
	}
}
