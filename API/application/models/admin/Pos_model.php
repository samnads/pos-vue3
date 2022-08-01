<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pos_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	function suggestProdsForPosCart($search, $offset, $limit, $order_by, $order)
	{
		$search = trim($search);
		$this->db->select('
		p.id														as id,
		p.code														as code,
		p.name														as name,
		p.price														as price,
		p.mrp														as mrp,
		p.thumbnail													as thumbnail,
		p.auto_discount												as auto_discount,
		IFNULL(p.pos_min_sale_qty, 1)								as min_sale_qty,
		p.pos_max_sale_qty											as max_sale_qty,
		p.pos_custom_discount										as allow_custom_discount,
		p.tax_method												as tax_method,
		IFNULL(p.pos_min_sale_qty, 1)								as quantity,
		DATE_FORMAT(p.mfg_date,"%d/%b/%Y")							as mfg_date,
		DATE_FORMAT(p.exp_date,"%d/%b/%Y")							as exp_date,

		pt.name														as type,

		bs.code														as symbology,

		c.id														as category_id,
		c.name														as category_name,

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
		$this->db->join(TABLE_BRAND . '				b',	'b.id=p.brand',	'left');
		$this->db->join(TABLE_UNIT . '				u',	'u.id=p.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . '			tr',	'tr.id=p.tax_rate',	'left');
		$this->db->order_by($order_by, $order);
		$this->db->or_like('p.code',	$search);
		$this->db->or_like('p.name',	$search);
		$query = $this->db->get('', $limit, $offset);
		return $query;
	}
	function get_products_where_in($where, $subcats, $brands, $offset, $limit, $order_by, $order)
	{
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
		$this->db->join(TABLE_CATEGORY . '		sc',	'sc.id=p.sub_category',	'left');
		$this->db->join(TABLE_BRAND . '				b',	'b.id=p.brand',	'left');
		$this->db->join(TABLE_UNIT . '				u',	'u.id=p.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . '			tr',	'tr.id=p.tax_rate',	'left');
		$this->db->order_by($order_by, $order);
		$this->db->where($where);
		$subcats ? $this->db->where_in('sc.id', $subcats) : null;
		$brands ? $this->db->where_in('b.id', $brands) : null;
		$query = $this->db->get('', $limit, $offset);
		return $query;
	}
	function get_customer_groups($columns)
	{
		$this->db->select($columns);
		$this->db->from(TABLE_CUSTOMER_GROUP . ' cg');
		$query = $this->db->get();
		return $query;
	}
}
