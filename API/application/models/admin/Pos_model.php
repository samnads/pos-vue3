<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pos_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	function datatable_data($search, $offset, $limit, $order_by, $order)
	{
		/******************************************************/ // calculate total paid using all payment methods
		$this->db->select('*,SUM(amount) as total_paid')->from(TABLE_POS_SALE_PAYMENT)->group_by('pos_sale');
		$subquery_payment = $this->db->get_compiled_select();
		$this->db->reset_query();
		/******************************************************/ // calculate each product_total excluding tax rate
		$this->db->select('*,(unit_price * quantity)-(auto_discount * quantity)-discount as product_total_without_tax')->from(TABLE_POS_SALE_PRODUCT)->group_by(array('pos_sale', 'product'))->group_by('product');
		$subquery_product = $this->db->get_compiled_select();
		$this->db->reset_query();
		/******************************************************/ // calculate each product total tax
		$this->db->select('*,
		(IFNULL(tr.rate, 0) / 100) * (psp.quantity * (psp.unit_price - psp.auto_discount - psp.discount)) as product_total_tax');
		$this->db->from(TABLE_POS_SALE_PRODUCT . ' psp');
		$this->db->join(TABLE_TAX_RATE . ' tr',    'tr.id = psp.tax_id', 'left');
		$this->db->group_by(array('psp.pos_sale', 'psp.product'));
		$product_total_tax = $this->db->get_compiled_select();
		$this->db->reset_query();
		/******************************************************/
		$this->db->select('
        ps.id as id,
        ps.created_at as created_at,
        CONCAT(u.first_name," ",u.last_name) as created_by_name,
        c.name as customer_name,
        ps.return_id as return,
        w.name as warehouse_name,
        s.name as status,
		s.css_class as css_class,
		COUNT(case when psp.product then psp.product end) as product_count,
		ROUND(SUM(psp.product_total_without_tax) + SUM(ptt.product_total_tax) + ps.shipping_charge + ps.packing_charge - ps.cart_discount + ps.round_off) as total_payable,
		ROUND(IFNULL(pspy.total_paid, 0)) as total_paid,
		ROUND(SUM(psp.product_total_without_tax) + SUM(ptt.product_total_tax) + ps.shipping_charge + ps.packing_charge - ps.cart_discount + ps.round_off - IFNULL(pspy.total_paid, 0)) as balance_return,
		ROUND(SUM(psp.product_total_without_tax) + SUM(ptt.product_total_tax) + ps.shipping_charge + ps.packing_charge - ps.cart_discount + ps.round_off - IFNULL(pspy.total_paid, 0)) as due,
        ps.updated_at as updated_at,
        ps.deleted_at as deleted_at');
		$this->db->from(TABLE_POS_SALE . ' ps');
		$this->db->join(TABLE_CUSTOMER . ' c',    'c.id = ps.customer', 'left');
		$this->db->join(TABLE_USER . ' u',    'u.id = ps.created_by', 'left');
		$this->db->join(TABLE_STATUS . ' s',    's.id = ps.status', 'left');
		$this->db->join(TABLE_WAREHOUSE . ' w',    'w.id = ps.warehouse', 'left');
		$this->db->join('(' . $subquery_payment . ')  pspy', 'pspy.pos_sale = ps.id', 'left');
		$this->db->join('(' . $subquery_product . ')  psp', 'psp.pos_sale = ps.id', 'left');
		$this->db->join('(' . $product_total_tax . ')  ptt', 'ptt.pos_sale = ps.id AND ptt.product = psp.product', 'left');
		$this->db->order_by($order_by, $order);
		$this->db->group_by('ps.id');
		$this->db->where(array('ps.deleted_at' => NULL)); // select only not deleted rows
		$this->db->group_start();
		$this->db->or_like('ps.created_at',	$search);
		$this->db->or_like('u.first_name',	$search);
		$this->db->or_like('u.last_name',	$search);
		$this->db->or_like('c.name',	$search);
		$this->db->or_like('w.name',	$search);
		$this->db->or_like('s.name',	$search);
		$this->db->or_like('pspy.total_paid',	$search);
		$this->db->or_like('ps.updated_at', $search);
		$this->db->group_end();
		$query = $this->db->get('', $limit, $offset);
		//die($this->db->last_query());
		return $query;
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
	function getPaymentModes($columns, $where)
	{
		$columns ? $this->db->select($columns) : $this->db->select('
		pm.id as id,
        pm.name as name,
		pm.description as description');
		$this->db->from(TABLE_PAYMENT_MODE . ' pm');
		$where ? $this->db->where($where) : null;
		$query = $this->db->get();
		return $query;
	}
	function create_pos_sale($data)
	{
		$query = $this->db->insert(TABLE_POS_SALE, $data);
		return $query;
	}
	function create_pos_sale_product($data)
	{
		$query = $this->db->insert(TABLE_POS_SALE_PRODUCT, $data);
		return $query;
	}
	function create_pos_sale_payment($data)
	{
		$query = $this->db->insert(TABLE_POS_SALE_PAYMENT, $data);
		return $query;
	}
}
