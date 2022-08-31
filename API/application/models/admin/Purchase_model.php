<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchase_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	function datatable_data($search, $offset, $limit, $order_by, $order)
	{
		/******************************************************/ // calculate total paid using all payment methods
		$this->db->select('*,SUM(amount) as total_paid')->from(TABLE_PURCHASE_PAYMENT)->group_by('purchase');
		$subquery_payment = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($subquery_payment);
		/******************************************************/ // calculate each product_total excluding tax rate
		$this->db->select('*')->from(TABLE_PURCHASE_PRODUCT)->group_by(array('purchase', 'product'));
		$subquery_product = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($subquery_product);
		/******************************************************/ // calculate each product total tax
		$this->db->select('*,
		tr.rate as tax_rate,
		(IFNULL(tr.rate, 0) / 100) * psp.product_total_without_tax as product_total_tax');
		$this->db->from(TABLE_PURCHASE_PRODUCT . ' as psp');
		$this->db->join(TABLE_TAX_RATE . ' as tr',    'tr.id = psp.tax_id', 'left');
		$this->db->group_by(array('psp.purchase', 'psp.product'));
		$product_total_tax = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($product_total_tax);
		/******************************************************/
		$search = trim($search);
		$this->db->select(
			'
		p.id		as id,
		p.reference_id		as reference_id,
		p.return_id	as return_id,
		p.warehouse		as warehouse,
		p.status		as status,
		p.created_by		as created_by,
		p.updated_by	as updated_by,
		p.supplier	as supplier,
		p.date	as date,
		p.discount	as discount,
		p.shipping_charge	as shipping_charge,
		p.packing_charge	as packing_charge,
		p.round_off	as round_off,
		p.payment_note	as payment_note,
		p.note	as note,
		p.created_at	as created_at,
		p.updated_at	as updated_at,
		p.deleted_at	as deleted_at,
		COUNT(case when pup.product then pup.product end) as product_count,
		s.name as supplier_name,
		w.name as warehouse_name,
		st.name as status_name,
		st.css_class as css_class,
		SUM(pup.product_total_without_tax) as product_total_without_unit_tax,
		SUM(pup.product_total_without_tax) + SUM(ptt.product_total_tax) as product_total_with_unit_tax,


		(CASE 
			WHEN tr_p.type = "P" THEN (IFNULL(tr_p.rate, 0) / 100) * (SUM(ptt.product_total_tax) + SUM(pup.product_total_without_tax)-p.discount)
			ELSE IFNULL(tr_p.rate, 0)
		END) as purchase_tax_value,


		(CASE 
			WHEN tr_p.type = "P" THEN (IFNULL(tr_p.rate, 0) / 100) * (SUM(pup.product_total_without_tax) + SUM(ptt.product_total_tax) - p.discount)
			ELSE IFNULL(tr_p.rate, 0)
		END) + (SUM(pup.product_total_without_tax) + SUM(ptt.product_total_tax) - p.discount) as product_total_with_tax,


		p.shipping_charge as shipping_charge,


		(CASE 
			WHEN tr_s.type = "P" THEN (IFNULL(tr_s.rate, 0) / 100) * p.shipping_charge
			ELSE IFNULL(tr_s.rate, 0)
		END) as shipping_tax_value,


		p.packing_charge as packing_charge,


		(CASE 
			WHEN tr_pk.type = "P" THEN (IFNULL(tr_pk.rate, 0) / 100) * p.packing_charge
			ELSE IFNULL(tr_pk.rate, 0)
		END) as packing_tax_value,


		(CASE 
			WHEN tr_p.type = "P" THEN (IFNULL(tr_p.rate, 0) / 100) * (SUM(pup.product_total_without_tax) + SUM(ptt.product_total_tax) - p.discount)
			ELSE IFNULL(tr_p.rate, 0)
		END) + (SUM(pup.product_total_without_tax) + SUM(ptt.product_total_tax) - p.discount) +
		(CASE 
			WHEN tr_s.type = "P" THEN (IFNULL(tr_s.rate, 0) / 100) * p.shipping_charge
			ELSE IFNULL(tr_s.rate, 0)
		END) +
		p.shipping_charge +
		(CASE 
			WHEN tr_pk.type = "P" THEN (IFNULL(tr_pk.rate, 0) / 100) * p.packing_charge
			ELSE IFNULL(tr_pk.rate, 0)
		END) +
		p.packing_charge -
		p.round_off as total_payable,

		ROUND(IFNULL(ppy.total_paid, 0)) as total_paid,
		
		
		(CASE 
			WHEN tr_p.type = "P" THEN (IFNULL(tr_p.rate, 0) / 100) * (SUM(pup.product_total_without_tax) + SUM(ptt.product_total_tax) - p.discount)
			ELSE IFNULL(tr_p.rate, 0)
		END) + (SUM(pup.product_total_without_tax) + SUM(ptt.product_total_tax) - p.discount) +
		(CASE 
			WHEN tr_s.type = "P" THEN (IFNULL(tr_s.rate, 0) / 100) * p.shipping_charge
			ELSE IFNULL(tr_s.rate, 0)
		END) +
		p.shipping_charge +
		(CASE 
			WHEN tr_pk.type = "P" THEN (IFNULL(tr_pk.rate, 0) / 100) * p.packing_charge
			ELSE IFNULL(tr_pk.rate, 0)
		END) +
		p.packing_charge -
		p.round_off - IFNULL(ppy.total_paid, 0) as balance_return,
		
		
		(CASE 
			WHEN tr_p.type = "P" THEN (IFNULL(tr_p.rate, 0) / 100) * (SUM(pup.product_total_without_tax) + SUM(ptt.product_total_tax) - p.discount)
			ELSE IFNULL(tr_p.rate, 0)
		END) + (SUM(pup.product_total_without_tax) + SUM(ptt.product_total_tax) - p.discount) +
		(CASE 
			WHEN tr_s.type = "P" THEN (IFNULL(tr_s.rate, 0) / 100) * p.shipping_charge
			ELSE IFNULL(tr_s.rate, 0)
		END) +
		p.shipping_charge +
		(CASE 
			WHEN tr_pk.type = "P" THEN (IFNULL(tr_pk.rate, 0) / 100) * p.packing_charge
			ELSE IFNULL(tr_pk.rate, 0)
		END) +
		p.packing_charge -
		p.round_off - IFNULL(ppy.total_paid, 0) as due'
		);
		$this->db->from(TABLE_PURCHASE . ' as p');
		$this->db->join(TABLE_SUPPLIER . ' as s',    's.id = p.supplier', 'left');
		$this->db->join(TABLE_WAREHOUSE . ' as w',    'w.id = p.warehouse', 'left');
		$this->db->join(TABLE_STATUS . ' as st',    'st.id = p.status', 'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr_p',    'tr_p.id = p.purchase_tax', 'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr_s',    'tr_s.id = p.shipping_tax', 'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr_pk',    'tr_pk.id = p.packing_tax', 'left');
		$this->db->join('(' . $subquery_payment . ')  as ppy', 'ppy.purchase = p.id', 'left');
		$this->db->join('(' . $subquery_product . ') as pup', 'pup.purchase = p.id', 'left');
		$this->db->join('(' . $product_total_tax . ') as ptt', 'ptt.purchase = p.id AND ptt.product = pup.product', 'left');
		$this->db->order_by($order_by, $order);
		$this->db->group_by('p.id');
		$this->db->where(array('p.deleted_at' => NULL)); // select only not deleted rows
		$this->db->group_start();
		$this->db->or_like('p.date',			$search);
		$this->db->or_like('p.discount',		$search);
		$this->db->or_like('p.shipping_charge',	$search);
		$this->db->or_like('p.packing_charge',	$search);
		$this->db->or_like('p.round_off',		$search);
		$this->db->or_like('p.payment_note',	$search);
		$this->db->or_like('p.note',			$search);
		$this->db->or_like('p.created_at',		$search);
		$this->db->or_like('p.updated_at',		$search);
		$this->db->or_like('w.name',			$search);
		$this->db->or_like('s.name',			$search);
		$this->db->or_like('st.name',			$search);
		$this->db->or_like('st.name',			$search);
		$this->db->or_like('ppy.total_paid',	$search);
		$this->db->group_end();
		$query = $this->db->get('', $limit, $offset);
		//die($this->db->last_query());
		return $query;
	}
	function suggestProdsForPurchase($search, $offset, $limit, $order_by, $order)
	{
		$search = trim($search);
		$this->db->select('
		p.id														as id,
		p.code														as code,
		p.name														as name,
		p.name														as value,
		p.cost														as cost,
		p.mrp														as mrp,
		p.thumbnail													as thumbnail,
		p.tax_method												as tax_method,
		1															as quantity,
		DATE_FORMAT(p.mfg_date,"%d/%b/%Y")							as mfg_date,
		DATE_FORMAT(p.exp_date,"%d/%b/%Y")							as exp_date,
		IFNULL(p.p_unit,p.unit)										as p_unit,

		pt.name														as type,

		bs.code														as symbology,

		c.id														as category,
		c.name														as category_name,

		b.id														as brand,
		b.name														as brand_name,
		b.code														as brand_code,

		u.id														as unit,
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
	function get_AUTO_INCREMENT()
	{
		$this->db->select('AUTO_INCREMENT');
		$this->db->from('INFORMATION_SCHEMA.TABLES');
		$this->db->where(array('TABLE_NAME' => TABLE_PURCHASE, 'TABLE_SCHEMA' => $this->db->database));
		$query = $this->db->get();
		$cnt = $query->row_array();
		return $cnt['AUTO_INCREMENT'];
	}
	function insert_purchase($data)
	{
		$query = $this->db->insert(TABLE_PURCHASE, $data);
		return $query;
	}
	function insert_purchase_product($data)
	{
		$query = $this->db->insert(TABLE_PURCHASE_PRODUCT, $data);
		return $query;
	}
}
