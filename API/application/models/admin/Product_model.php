<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Product_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	function getAll()
	{
		$query = $this->db->get(TABLE_PRODUCT);
		return $query->result();
	}
	function getInfo($id)
	{
		$id = trim($id);
		$this->db->select('
		p.id		as id,
		p.code		as code,
		p.name		as name,
		p.slug		as slug,
		p.thumbnail	as thumbnail,
		p.weight	as weight,
		p.mrp 		as mrp,
		p.cost 		as cost,
		p.price 	as price,
		p.mfg_date 	as mfg_date,
		p.exp_date 	as exp_date,
		p.quantity	as quantity,
		
		t.name 		as type_name,
		
		bs.code 	as symbology_code,
		
		c.name 		as category_name,
		sc.name 	as sub_category_name,
		
		b.code 		as brand_code,
		b.name 		as brand_name,

		u.code 		as unit_code,
		u.name 		as unit_name,

		tr.code		as tax_code,
		tr.name		as tax_name,
		tr.rate		as tax_rate');
		$this->db->from(TABLE_PRODUCT . '				p');
		$this->db->join(TABLE_PRODUCT_TYPE . '		t',	't.id=p.type',	'left');
		$this->db->join(TABLE_BARCODE_SYMBOLOGY . '	bs',	'bs.id=p.symbology',	'left');
		$this->db->join(TABLE_CATEGORY . '			c',	'c.id=p.category',	'left');
		$this->db->join(TABLE_SUB_CATEGORY . '		sc',	'sc.id=p.sub_category',	'left');
		$this->db->join(TABLE_BRAND . '				b',	'b.id=p.brand',	'left');
		$this->db->join(TABLE_UNIT . '				u',	'u.id=p.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . '			tr',	'tr.id=p.tax_rate',	'left');
		$this->db->where('p.id',	$id);
		$query = $this->db->get();
		return $query;
	}
	function datatable_recordsTotal()
	{
		$this->db->select('count(id)');
		$this->db->from(TABLE_PRODUCT . ' p');
		$this->db->where(array('p.deleted_at' => NULL)); // select only not deleted rows
		$query = $this->db->get();
		$cnt = $query->row_array();
		return $cnt['count(id)'];
	}
	function getProduct($id)
	{
		$this->db->select('*, DATE_FORMAT(mfg_date,"%d-%m-%Y")	as mfg_date,
		DATE_FORMAT(exp_date,"%d-%m-%Y")						as exp_date');
		$query = $this->db->get_where(TABLE_PRODUCT, array('id' => $id));
		//die($this->db->last_query());
		return $query;
	}
	function suggestProdsForBarcode($search, $offset, $limit, $order_by, $order)
	{
		$search = trim($search);
		$this->db->select('
		p.id														as id,
		p.code														as code,
		bs.code														as symbology,
		CONCAT(p.name," | ",p.code," | Rs. ",TRUNCATE(p.price,2))	as label,
		p.price														as price,
		p.thumbnail													as thumbnail,
		DATE_FORMAT(p.mfg_date,"%d/%b/%Y")							as mfg_date,
		DATE_FORMAT(p.exp_date,"%d/%b/%Y")							as exp_date,
		p.name														as value,
		1 															as quantity');
		$this->db->from(TABLE_PRODUCT . '				p');
		$this->db->join(TABLE_PRODUCT_TYPE . '		t',	't.id=p.type',	'left');
		$this->db->join(TABLE_BARCODE_SYMBOLOGY . '	bs',	'bs.id=p.symbology',	'left');
		$this->db->join(TABLE_CATEGORY . '			c',	'c.id=p.category',	'left');
		$this->db->join(TABLE_SUB_CATEGORY . '		sc',	'sc.id=p.sub_category',	'left');
		$this->db->join(TABLE_BRAND . '				b',	'b.id=p.brand',	'left');
		$this->db->join(TABLE_UNIT . '				u',	'u.id=p.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . '			tr',	'tr.id=p.tax_rate',	'left');
		$this->db->order_by($order_by, $order);
		$this->db->or_like('p.code',	$search);
		$this->db->or_like('p.name',	$search);
		$query = $this->db->get('', $limit, $offset);
		return $query;
	}
	function addProdsForBarcode($search, $offset, $limit, $order_by, $order)
	{
		$this->db->select('
		p.id														as id,
		p.code														as code,
		bs.code														as symbology,
		CONCAT(p.name," | ",p.code," | Rs. ",TRUNCATE(p.price,2))	as label,
		p.price														as price,
		p.thumbnail													as thumbnail,
		DATE_FORMAT(p.mfg_date,"%d/%b/%Y")							as mfg_date,
		DATE_FORMAT(p.exp_date,"%d/%b/%Y")							as exp_date,
		p.name														as value,
		1 															as quantity');
		$this->db->from(TABLE_PRODUCT . '				p');
		$this->db->join(TABLE_PRODUCT_TYPE . '		t',	't.id=p.type',	'left');
		$this->db->join(TABLE_BARCODE_SYMBOLOGY . '	bs',	'bs.id=p.symbology',	'left');
		$this->db->join(TABLE_CATEGORY . '			c',	'c.id=p.category',	'left');
		$this->db->join(TABLE_SUB_CATEGORY . '		sc',	'sc.id=p.sub_category',	'left');
		$this->db->join(TABLE_BRAND . '				b',	'b.id=p.brand',	'left');
		$this->db->join(TABLE_UNIT . '				u',	'u.id=p.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . '			tr',	'tr.id=p.tax_rate',	'left');
		$this->db->order_by($order_by, $order);
		$this->db->where_in('p.code', $search);
		$query = $this->db->get('', $limit, $offset);
		return $query;
	}
	function suggestProdForBarcode($id)
	{
		$this->db->select('
		p.id														as id,
		p.code														as code,
		bs.code														as symbology,
		CONCAT(p.name," | ",p.code," | Rs. ",TRUNCATE(p.price,2))	as label,
		p.price														as price,
		p.thumbnail													as thumbnail,
		DATE_FORMAT(p.mfg_date,"%d/%b/%Y")							as mfg_date,
		DATE_FORMAT(p.exp_date,"%d/%b/%Y")							as exp_date,
		p.name														as value,
		1 															as quantity');
		$this->db->from(TABLE_PRODUCT . '				p');
		$this->db->join(TABLE_PRODUCT_TYPE . '		t',	't.id=p.type',	'left');
		$this->db->join(TABLE_BARCODE_SYMBOLOGY . '	bs',	'bs.id=p.symbology',	'left');
		$this->db->join(TABLE_CATEGORY . '			c',	'c.id=p.category',	'left');
		$this->db->join(TABLE_SUB_CATEGORY . '		sc',	'sc.id=p.sub_category',	'left');
		$this->db->join(TABLE_BRAND . '				b',	'b.id=p.brand',	'left');
		$this->db->join(TABLE_UNIT . '				u',	'u.id=p.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . '			tr',	'tr.id=p.tax_rate',	'left');
		$this->db->where(array('p.id' => $id));
		$query = $this->db->get();
		return $query;
	}
	function datatable_data($search, $offset, $limit, $order_by, $order)
	{
		$search = trim($search);
		$this->db->select('
		p.id		as id,
		p.symbology	as symbology,
		p.code		as code,
		p.name		as name,
		p.slug		as slug,
		p.thumbnail	as thumbnail,
		p.weight	as weight,
		cast(p.mrp AS decimal(10,2)) AS mrp,
		cast(p.cost AS decimal(10,2)) AS cost,
		cast(p.price AS decimal(10,2)) AS price,
		cast(p.markup AS decimal(10,2)) AS markup,
		cast(p.auto_discount AS decimal(10,2)) AS auto_discount,
		p.tax_method as tax_method,
		p.alert 	as alert,
		p.alert_quantity 	as alert_quantity,
		p.mfg_date 	as mfg_date,
		p.exp_date 	as exp_date,
		p.pos_sale 	as pos_sale,
		p.pos_custom_discount 	as pos_custom_discount,
		p.pos_custom_tax 	as pos_custom_tax,
		p.pos_sale_note 	as pos_sale_note,
		p.pos_data_field_1 	as pos_data_field_1,
		p.pos_data_field_2 	as pos_data_field_2,
		p.pos_data_field_3 	as pos_data_field_3,
		p.pos_data_field_4 	as pos_data_field_4,
		p.pos_data_field_5 	as pos_data_field_5,
		p.pos_data_field_6 	as pos_data_field_6,
		p.editable			as editable,
		p.deleted_at		as deleted_at,
		
		t.id 		as type,
		t.name 		as type_name,
		
		bs.code 	as symbology_code,
		
		c.id 		as category,
		c.name 		as category_name,
		sc.id 		as sub_category,
		sc.name 	as sub_category_name,
		
		b.id 		as brand,
		b.code 		as brand_code,
		b.name 		as brand_name,

		u.id 		as unit,
		u.code 		as unit_code,
		u.name 		as unit_name,

		ubp.id 		as p_unit,
		ubs.id 		as s_unit,

		tr.id		as tax_rate,
		tr.code		as tax_code,
		tr.name		as tax_name,
		
		COALESCE(SUM(ps.quantity),0)  as quantity');
		$this->db->from(TABLE_PRODUCT . '			p');
		$this->db->join(TABLE_PRODUCT_TYPE . '		t',		't.id=p.type',			'left');
		$this->db->join(TABLE_BARCODE_SYMBOLOGY . '	bs',	'bs.id=p.symbology',	'left');
		$this->db->join(TABLE_CATEGORY . '			c',		'c.id=p.category',		'left');
		$this->db->join(TABLE_SUB_CATEGORY . '		sc',	'sc.id=p.sub_category',	'left');
		$this->db->join(TABLE_BRAND . '				b',		'b.id=p.brand',			'left');
		$this->db->join(TABLE_UNIT . '				u',		'u.id=p.unit',			'left');
		$this->db->join(TABLE_UNIT_BULK . '			ubp',	'ubp.id=p.p_unit',		'left');
		$this->db->join(TABLE_UNIT_BULK . '			ubs',	'ubs.id=p.s_unit',		'left');
		$this->db->join(TABLE_TAX_RATE . '			tr',	'tr.id=p.tax_rate',		'left');
		$this->db->join(TABLE_PRODUCT_STOCK . '		ps',	'ps.product=p.id',		'left');
		$this->db->order_by($order_by, $order);
		$this->db->group_by('p.id');

		$this->db->where(array('p.deleted_at' => NULL)); // select only not deleted rows
		$this->db->group_start();
		$this->db->or_like('p.code',	$search);
		$this->db->or_like('p.name',	$search);
		$this->db->or_like('p.slug',	$search);
		$this->db->or_like('p.weight',	$search);
		$this->db->or_like('p.mrp',		$search);
		$this->db->or_like('p.cost',	$search);
		$this->db->or_like('p.price',	$search);
		$this->db->or_like('p.mfg_date', $search);
		$this->db->or_like('p.exp_date', $search);
		$this->db->or_like('t.name',	$search);
		$this->db->or_like('bs.code',	$search);
		$this->db->or_like('c.name',	$search);
		$this->db->or_like('sc.name',	$search);
		$this->db->or_like('b.name',	$search);
		$this->db->or_like('tr.code',	$search);
		$this->db->or_like('tr.name',	$search);
		$this->db->or_like('tr.rate',	$search);
		$this->db->group_end();
		$query = $this->db->get('', $limit, $offset);
		//die($this->db->last_query());
		//die(print_r($query));
		return $query;
	}
	function datatable_recordsFiltered($search)
	{
		$search = trim($search);
		$this->db->select('COUNT(*) as count');
		$this->db->from(TABLE_PRODUCT . '				p');
		$this->db->join(TABLE_PRODUCT_TYPE . '		t',	't.id=p.type',	'left');
		$this->db->join(TABLE_BARCODE_SYMBOLOGY . '	bs',	'bs.id=p.symbology',	'left');
		$this->db->join(TABLE_CATEGORY . '			c',	'c.id=p.category',	'left');
		$this->db->join(TABLE_SUB_CATEGORY . '		sc',	'sc.id=p.sub_category',	'left');
		$this->db->join(TABLE_BRAND . '				b',	'b.id=p.brand',	'left');
		$this->db->join(TABLE_UNIT . '				u',	'u.id=p.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . '			tr',	'tr.id=p.tax_rate',	'left');

		$this->db->where(array('p.deleted_at' => NULL)); // select only not deleted rows
		$this->db->group_start();
		$this->db->or_like('p.code',	$search);
		$this->db->or_like('p.name',	$search);
		$this->db->or_like('p.slug',	$search);
		$this->db->or_like('p.weight',	$search);
		$this->db->or_like('p.mrp',		$search);
		$this->db->or_like('p.cost',	$search);
		$this->db->or_like('p.price',	$search);
		$this->db->or_like('p.mfg_date', $search);
		$this->db->or_like('p.exp_date', $search);
		$this->db->or_like('t.name',	$search);
		$this->db->or_like('bs.code',	$search);
		$this->db->or_like('c.name',	$search);
		$this->db->or_like('sc.name',	$search);
		$this->db->or_like('b.name',	$search);
		$this->db->or_like('tr.code',	$search);
		$this->db->or_like('tr.name',	$search);
		$this->db->or_like('tr.rate',	$search);
		$this->db->group_end();
		$query = $this->db->get();
		$query	= $query->row();
		return $query->count;
	}
	function suggestProdsForAdjustment($search, $offset, $limit, $order_by, $order)
	{
		$search = trim($search);
		$this->db->select('
		p.id														as id,
		p.code														as code,
		p.name														as name,
		p.name														as value,
		p.price														as price,
		(p.price-p.auto_discount)									as unit_price,
		p.mrp														as mrp,
		p.thumbnail													as thumbnail,
		p.auto_discount												as unit_discount,
		p.auto_discount												as discount,
		p.tax_method												as tax_method,
		1															as quantity,
		DATE_FORMAT(p.mfg_date,"%d/%b/%Y")							as mfg_date,
		DATE_FORMAT(p.exp_date,"%d/%b/%Y")							as exp_date,

		pt.name														as type,

		bs.code														as symbology,

		c.id														as category_id,
		c.name														as category_name,
		sc.id														as sub_category_id,
		sc.name														as sub_category_name,

		b.id														as brand_id,
		b.name														as brand_name,
		b.code														as brand_code,

		u.id														as unit_id,
		u.name														as unit_name,
		u.code														as unit_code,

		tr.id														as tax_id,
		tr.code														as tax_code,
		tr.name														as tax_name,
		tr.rate														as tax_rate,

		CONCAT(p.name," | ",p.code," | Rs. ",TRUNCATE(p.price,2))	as label');
		$this->db->from(TABLE_PRODUCT . '				p');
		$this->db->join(TABLE_PRODUCT_TYPE . '		pt',	'pt.id=p.type',	'left');
		$this->db->join(TABLE_BARCODE_SYMBOLOGY . '	bs',	'bs.id=p.symbology',	'left');
		$this->db->join(TABLE_CATEGORY . '			c',	'c.id=p.category',	'left');
		$this->db->join(TABLE_SUB_CATEGORY . '		sc',	'sc.id=p.sub_category',	'left');
		$this->db->join(TABLE_BRAND . '				b',	'b.id=p.brand',	'left');
		$this->db->join(TABLE_UNIT . '				u',	'u.id=p.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . '			tr',	'tr.id=p.tax_rate',	'left');
		$this->db->order_by($order_by, $order);
		$this->db->or_like('p.code',	$search);
		$this->db->or_like('p.name',	$search);
		$query = $this->db->get('', $limit, $offset);
		return $query;
	}
	function set_deleted_at($where) // mark as deleted
	{
		$this->db->where($where);
		$this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
		$query = $this->db->update(TABLE_PRODUCT);
		return $query;
	}
	function multi_set_deleted_at($ids,$where) // mark as deleted
	{
		$this->db->where_in('id', $ids);
		$this->db->where($where);
		$this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
		$query = $this->db->update(TABLE_PRODUCT);
		return $query;
	}
	function create($data)
	{
		$query = $this->db->insert(TABLE_PRODUCT, $data);
		return $query;
	}
	function update($id, $data)
	{
		$this->db->where('id', $id);
		$query = $this->db->update(TABLE_PRODUCT, $data);
		return $query;
	}
	function get_total_products_where($where)
	{
		$this->db->select('COUNT(DISTINCT p.id)	as	total_products');
		$this->db->from(TABLE_PRODUCT . '		p');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result['total_products'];
	}

	function get_total_brands_where($where)
	{
		$this->db->select('COUNT(DISTINCT p.brand)	as	total_brands');
		$this->db->from(TABLE_PRODUCT . '		p');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result['total_brands'];
	}
}
