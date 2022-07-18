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
		$this->db->from(TABLE_CATEGORY_NEW . ' c');
		$query = $this->db->get();
		return $query->result();
	}
	function dropdown_level_0_active()
	{
		$query = $this->db->get(TABLE_CATEGORY);
		return $query->result();
	}
	function get_category_by_column($cnmae, $value)
	{
		$query = $this->db->get_where(TABLE_CATEGORY, array($cnmae => $value));
		return $query;
	}
	function dropdown_level_1_active($catid)
	{
		$this->db->select('
		sc.id as id,
		sc.code as code,
		sc.name as name,
		sc.slug as slug,
		sc.image as image,
		sc.description as description,
		sc.category as category');
		$this->db->where(array('sc.category' => $catid));
		$query = $this->db->get(TABLE_SUB_CATEGORY . ' sc');
		return $query->result();
	}
	function listCategoriesWithCount($search, $offset, $limit, $order_by, $order)
	{
		$search = trim($search);
		$this->db->select('
		c.id as id,
		c.code as code,
		c.name as name,
		c.slug as slug,
		c.image as image,
		c.description as description,
        DATE_FORMAT(c.added_at,"%d/%b/%Y") 		as added_at,
		DATE_FORMAT(c.updated_at,"%d/%b/%Y") 	as updated_at,
		count(DISTINCT sc.id) as sc_count,
		count(DISTINCT p.id) as p_count,
		count(DISTINCT b.id) as b_count');
		$this->db->from(TABLE_CATEGORY . ' c');
		$this->db->join(TABLE_SUB_CATEGORY . '    sc', 'sc.category = c.id', 'left');
		$this->db->join(TABLE_PRODUCT . '         p',	'p.category = c.id', 'left');
		$this->db->join(TABLE_BRAND . '           b',	'b.id = p.brand', 'left');

		$this->db->or_like('c.code', $search);
		$this->db->or_like('c.name', $search);
		$this->db->or_like('c.slug', $search);
		$this->db->or_like('c.description', $search);

		$this->db->or_like('sc.code', $search);
		$this->db->or_like('sc.name', $search);
		$this->db->or_like('sc.slug', $search);
		$this->db->or_like('sc.description', $search);

		$this->db->order_by($order_by, $order);
		$this->db->group_by('c.id');
		$query = $this->db->get('', $limit, $offset);
		//die($this->db->last_query());
		//die(print_r($query));
		return $query;
	}
	function listCategories_FilteredCount($search)
	{
		$search = trim($search);
		$this->db->select('COUNT(*) as count');
		$this->db->from(TABLE_CATEGORY . ' c');
		$this->db->or_like('c.code', $search);
		$this->db->or_like('c.name', $search);
		$this->db->or_like('c.slug', $search);
		$this->db->or_like('c.description', $search);
		$query = $this->db->get();
		$query	= $query->row();
		return $query->count;
	}
	function listSubCategoriesWithCount($search, $cid, $offset, $limit, $order_by, $order)
	{
		$search = trim($search);

		$this->db->select('
		sc.id as id,
		sc.category as category,
		sc.code as code,
		sc.name as name,
		sc.slug as slug,
		sc.image as image,
		sc.description as description,
		c.name as category_name,
        DATE_FORMAT(sc.added_at,"%d/%b/%Y") 	as added_at,
		DATE_FORMAT(sc.updated_at,"%d/%b/%Y") 	as updated_at,
		count(DISTINCT p.id) as count_product,
		count(DISTINCT b.id) as count_brand');

		$this->db->from(TABLE_SUB_CATEGORY . ' sc');
		$this->db->join(TABLE_CATEGORY . '		c',	'c.id = sc.category', 'left');
		$this->db->join(TABLE_PRODUCT . '       p',	'p.sub_category = sc.id', 'left');
		$this->db->join(TABLE_BRAND . '         b',	'b.id = p.brand', 'left');

		$this->db->where('sc.category', $cid);

		$this->db->group_start();
		$this->db->or_like(array('sc.code' => $search, 'sc.name' => $search, 'sc.slug' => $search, 'sc.description' => $search));
		$this->db->group_end();

		$this->db->order_by($order_by, $order);
		$this->db->group_by('sc.id');
		$query = $this->db->get('', $limit, $offset);
		//die($this->db->last_query());
		//die(print_r($query));
		return $query;
	}
	function testQuery($search, $offset, $limit, $order_by, $order)
	{
		$search = trim($search);
		$this->db->select('
				sc.id as id,
				sc.code as code,
				sc.name as name,
				sc.slug as slug,
				sc.image as image,
				sc.description as description,

				c.id as category_id,
				c.code as category_code,
				c.name as category_name,
				c.slug as category_slug,
				c.image as category_image,
				c.description as category_description');
		$this->db->from(TABLE_CATEGORY . ' c');
		$this->db->join(TABLE_SUB_CATEGORY . ' sc', 'sc.category=c.id', 'left');


		$this->db->order_by('c.id', 'DESC');
		$this->db->order_by('sc.updated_at', 'DESC');




		$query = $this->db->get('', 100, $offset);
		//die($this->db->last_query());
		//die(print_r($query));
		return $query;
	}
	function listSubCategories_FilteredCount($search, $cid)
	{
		$search = trim($search);
		$this->db->select('COUNT(*) as count');
		$this->db->from(TABLE_SUB_CATEGORY . ' sc');

		$this->db->where('sc.category', $cid);

		$this->db->group_start();
		$this->db->or_like(array('sc.code' => $search, 'sc.name' => $search, 'sc.slug' => $search, 'sc.description' => $search));
		$this->db->group_end();

		$query = $this->db->get();
		$query	= $query->row();
		return $query->count;
	}
	function SubCategoriestotalRows($cid)
	{
		$this->db->select('count(id)');
		$this->db->from(TABLE_SUB_CATEGORY . ' sc');
		$this->db->where('sc.category', $cid);
		$query = $this->db->get();
		$cnt = $query->row_array();
		return $cnt['count(id)'];
	}
	function listCategoriesTEST($search, $offset, $limit, $order_by, $order)
	{
		$this->db->select('
		c.id as c_id,
		c.code as c_code,
		c.name as c_name,
		c.slug as c_slug,
		c.description as c_description,
        DATE_FORMAT(c.added_at,"%d/%b/%Y") 		as c_added_at,
		DATE_FORMAT(c.updated_at,"%d/%b/%Y") 	as c_updated_at,
		sc.id as sc_id,
		sc.code as sc_code,
		sc.name as sc_name,
		sc.slug as sc_slug,
		sc.description as sc_description,');
		$this->db->from(TABLE_CATEGORY . ' c');
		$this->db->join(TABLE_SUB_CATEGORY . '		sc',	'c.id = sc.category',	'left');
		//$this->db->where(array('p.category' => 1,'p.BRAND IS NOT NULL'));
		//$this->db->group_by('sc.id',FALSE);
		//$this->db->group_by('c.id');
		$query = $this->db->get('', $limit, $offset);
		return $query;
	}
	function totalRows()
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
	function deleteSubCat($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->delete(TABLE_SUB_CATEGORY);
		return $query;
	}
	function deletesCat($ids)
	{
		$this->db->where_in('id', $ids);
		$query = $this->db->delete(TABLE_CATEGORY);
		return $query;
	}
	function deletesSubCat($ids)
	{
		$this->db->where_in('id', $ids);
		$query = $this->db->delete(TABLE_SUB_CATEGORY);
		return $query;
	}
	function get_total_subcats_where($where)
	{
		$this->db->select('COUNT(DISTINCT sc.id)	as	total_subcats');
		$this->db->from(TABLE_SUB_CATEGORY . '    sc');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result['total_subcats'];
	}
	function updateCategory($data, $where)
	{
		$this->db->set($data);
		$this->db->where($where);
		$query = $this->db->update(TABLE_CATEGORY);
		return $query;
	}
}
