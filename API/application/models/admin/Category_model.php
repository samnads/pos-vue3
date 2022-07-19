<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Category_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	function dropdown_categories()
	{
		$this->db->select('
        c.id as id,
        c.parent as parent,
        c.name as name');
		$this->db->from(TABLE_CATEGORY . ' c');
		$query = $this->db->get();
		return $query->result();
	}
	function get_category_by_column($cnmae, $value)
	{
		$query = $this->db->get_where(TABLE_CATEGORY, array($cnmae => $value));
		return $query;
	}
	function datatable_data($search, $offset, $limit, $order_by, $order)
	{
		$search = trim($search);
		$this->db->select('
		c.id as id,
		c.parent as parent,
		c.code as code,
		c.name as name,
		c.slug as slug,
		c.image as image,
		c.description as description,
        DATE_FORMAT(c.added_at,"%d/%b/%Y") 		as added_at,
		DATE_FORMAT(c.updated_at,"%d/%b/%Y") 	as updated_at,
		count(DISTINCT p.id) as p_count,
		count(DISTINCT b.id) as b_count');
		$this->db->from(TABLE_CATEGORY . ' c');
		$this->db->join(TABLE_PRODUCT . ' p',	'p.category = c.id', 'left');
		$this->db->join(TABLE_BRAND . ' b',	'b.id = p.brand', 'left');
		$this->db->group_start();
		$this->db->or_like('c.code', $search);
		$this->db->or_like('c.name', $search);
		$this->db->or_like('c.slug', $search);
		$this->db->or_like('c.description', $search);
		$this->db->group_end();
		$this->db->order_by($order_by, $order);
		$this->db->group_by('c.id');
		$query = $this->db->get('', $limit, $offset);
		//die($this->db->last_query());
		//die(print_r($query));
		return $query;
	}
	function datatable_recordsFiltered($search)
	{
		$search = trim($search);
		$this->db->select('COUNT(*) as count');
		$this->db->from(TABLE_CATEGORY . ' c');
		$this->db->group_start();
		$this->db->or_like('c.code', $search);
		$this->db->or_like('c.name', $search);
		$this->db->or_like('c.slug', $search);
		$this->db->or_like('c.description', $search);
		$this->db->group_end();
		$query = $this->db->get();
		$query	= $query->row();
		return $query->count;
	}
	function datatable_recordsTotal()
	{
		$this->db->select('count(id)');
		$query = $this->db->get(TABLE_CATEGORY);
		$cnt = $query->row_array();
		return $cnt['count(id)'];
	}
	function deleteCat($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->delete(TABLE_CATEGORY);
		return $query;
	}
	function deletesCat($ids)
	{
		$this->db->where_in('id', $ids);
		$query = $this->db->delete(TABLE_CATEGORY);
		return $query;
	}
	function updateCategory($data, $where)
	{
		$this->db->set($data);
		$this->db->where($where);
		$query = $this->db->update(TABLE_CATEGORY);
		return $query;
	}
}
