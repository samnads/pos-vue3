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
		$this->db->select('purchase,SUM(amount) as total_paid')->from(TABLE_PURCHASE_PAYMENT)->where(array('deleted_at' => NULL))->group_by('purchase');
		$subquery_payment = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($subquery_payment);
		/******************************************************/ // calculate each product_total excluding tax rate
		$this->db->select('
		purchase,
		product,quantity,
		unit,
		unit_cost,
		unit_discount,
		tax_id,
		net_unit_cost,
		product_total_without_tax
		')->from(TABLE_PURCHASE_PRODUCT)->group_by(array('purchase', 'product'));
		$subquery_product = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($subquery_product);
		/******************************************************/ // calculate each product total tax
		$this->db->select('psp.purchase,
		psp.product,
		tr.rate as tax_rate,
		(IFNULL(tr.rate, 0) / 100) * psp.product_total_without_tax as product_total_tax');
		$this->db->from(TABLE_PURCHASE_PRODUCT . ' as psp');
		$this->db->join(TABLE_TAX_RATE . ' as tr',    'tr.id = psp.tax_id', 'left');
		$this->db->group_by(array('psp.purchase', 'psp.product'));
		$product_total_tax = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($product_total_tax);
		/******************************************************/
		$this->db->select('purchase,COUNT(purchase) as total_return')->from(TABLE_RETURN_PURCHASE)->where(array('deleted_at' => NULL))->group_by('purchase');
		$subquery_return_count = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($subquery_return_count);
		/******************************************************/
		$search = trim($search);
		$this->db->select(
			'
		p.id		as id,
		p.reference_id		as reference_id,
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
		IFNULL(rc.total_return,0) as total_return,
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


		ROUND((CASE 
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
		p.round_off,2) as total_payable,

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
		$this->db->join('(' . $subquery_return_count . ') as rc', 'rc.purchase = p.id', 'left');
		$this->db->order_by($order_by, $order);
		$this->db->group_by('p.id');
		$this->db->where(array('p.deleted_at' => NULL)); // select only not deleted rows
		$this->db->group_start();
		$this->db->or_like('p.reference_id',	$search);
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

		pt.name														as type,

		bs.code														as symbology,

		c.id														as category,
		c.name														as category_name,

		b.id														as brand,
		b.name														as brand_name,
		b.code														as brand_code,

		p.unit														as unit,
		u.name														as unit_name,
		u.code														as unit_code,
		IFNULL(p.p_unit,p.unit)										as p_unit,

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
	function get_purchase_row_by_id($where)
	{
		/******************************************************/ // count purchase returns by purchase
		$this->db->select('purchase,IFNULL(COUNT(purchase),0) as total_return')->from(TABLE_RETURN_PURCHASE)->where(array('purchase' => $where['purchase'], 'deleted_at' => NULL))->group_by('purchase');
		$subquery_return_count = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($subquery_return_count);
		/******************************************************/
		$this->db->select('
		`p.id`,
		`p.reference_id`,
		`p.warehouse`,
		`p.date`,
		`p.time`,
		`p.status`,
		`p.created_by`,
		`p.updated_by`,
		`p.supplier`,
		`p.discount`,
		`p.purchase_tax`,
		`p.shipping_charge`,
		`p.shipping_tax`,
		`p.packing_charge`,
		`p.packing_tax`,
		`p.round_off`,
		`p.payment_note`,
		`p.note`,
		`rc.total_return`
		');
		$this->db->from(TABLE_PURCHASE . ' as p');
		$this->db->join('(' . $subquery_return_count . ') as rc', 'rc.purchase = p.id', 'left');
		$this->db->where(array('p.id' => $where['purchase'], 'p.deleted_at' => NULL));
		$query = $this->db->get();
		return $query ? $query->row_array() : false;
	}
	function getPurchaseProductsDetails($where)
	{
		$this->db->select('
		p.id														as id,
		p.code														as code,
		p.name														as name,
		pp.unit														as p_unit,
		pp.unit_cost												as unit_cost,
		(pp.unit_cost / IFNULL(u.step,1))							as db_cost,
		pp.unit_discount											as unit_discount,
		pp.tax_id													as tax_id,
		pp.quantity													as quantity,
		
		p.unit														as unit,
		u.name														as unit_name,
		u.code
																	as unit_code,
		tr.rate														as tax_rate');
		$this->db->from(TABLE_PURCHASE_PRODUCT . ' pp');
		$this->db->join(TABLE_PRODUCT . ' p',	'p.id=pp.product',	'left');
		$this->db->join(TABLE_UNIT . ' u',	'u.id=pp.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . ' tr',	'tr.id=pp.tax_id',	'left');
		$this->db->where($where);
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query ? $query->result() : false;
	}
	function getPurchaseDetails($where)
	{
		$this->db->select('
		p.reference_id										as reference_id,
		w.name												as warehouse_name,
		p.date												as date,
		p.time												as time,
		s.name												as status_name,
		sp.email											as supplier_email,
		sp.phone											as supplier_phone,
		sp.place											as supplier_place,
		sp.city												as supplier_city,
		sp.address											as supplier_address,
		CONCAT(cu.first_name," ",cu.last_name)				as created_by_name,
		CONCAT(uu.first_name," ",uu.last_name)				as updated_by_name,
		sp.name												as supplier_name,
		s.css_class											as status_css_class');
		$this->db->from(TABLE_PURCHASE . ' p');
		$this->db->join(TABLE_WAREHOUSE . ' w',	'w.id=p.warehouse',	'left');
		$this->db->join(TABLE_STATUS . ' s',	's.id=p.status',	'left');
		$this->db->join(TABLE_USER . ' cu',	'cu.id=p.created_by',	'left');
		$this->db->join(TABLE_USER . ' uu',	'uu.id=p.updated_by',	'left');
		$this->db->join(TABLE_SUPPLIER . ' sp',	'sp.id=p.supplier',	'left');
		$this->db->where($where);
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query ? $query->row_array() : false;
	}
	function getPurchasePayments($where)
	{
		$this->db->select('
		pp.id										as id,
		pp.date_time								as date_time,
		pm.name										as payment_mode_name,
		pm.id										as mode,
		pp.amount									as amount,
		pp.transaction_id							as transaction_id,
		pp.reference_no								as reference_no,
		pp.note												as note');
		$this->db->from(TABLE_PURCHASE_PAYMENT . ' pp');
		$this->db->join(TABLE_PAYMENT_MODE . ' pm',	'pm.id=pp.payment_mode',	'left');
		$this->db->where($where);
		$this->db->where(array('deleted_at' => NULL));
		$this->db->order_by("pp.date_time", "desc");
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query ? $query->result_array() : false;
	}
	function get_purchase_products_by_purchase($where)
	{
		$this->db->select('
		p.id														as id,
		p.code														as code,
		p.name														as name,
		pp.unit														as p_unit,
		pp.unit_cost												as unit_cost,
		(pp.unit_cost / IFNULL(u.step,1))							as db_cost,
		pp.unit_discount											as unit_discount,
		pp.tax_id													as tax_id,
		pp.quantity													as quantity,
		p.unit														as unit,
		u.name														as unit_name,
		u.code														as unit_code,
		tr.rate														as tax_rate');
		$this->db->from(TABLE_PURCHASE_PRODUCT . ' as pp');
		$this->db->join(TABLE_PURCHASE . ' as pu',	'pu.id=pp.purchase',	'left');
		$this->db->join(TABLE_PRODUCT . ' as p',	'p.id=pp.product',	'left');
		$this->db->join(TABLE_UNIT . ' as u',	'u.id=pp.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr',	'tr.id=pp.tax_id',	'left');
		$this->db->where(array('pp.purchase' => $where['purchase'], 'pu.deleted_at' => NULL));
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query ? $query->result() : false;
	}
	function insert_purchase($data)
	{
		$query = $this->db->insert(TABLE_PURCHASE, $data);
		return $query;
	}
	function update_purchase($data, $id)
	{
		$this->db->where(array('id' => $id, 'deleted_at' => NULL));
		$query = $this->db->update(TABLE_PURCHASE, $data);
		return $query;
	}
	function set_deleted_at($where) // mark as deleted
	{
		$this->db->where($where);
		$this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
		$query = $this->db->update(TABLE_PURCHASE);
		return $query;
	}
	function insert_purchase_product($data)
	{
		$query = $this->db->insert(TABLE_PURCHASE_PRODUCT, $data);
		return $query;
	}
	function delete_purchase_products($where)
	{
		$this->db->where($where);
		$query = $this->db->delete(TABLE_PURCHASE_PRODUCT);
		return $query;
	}
	function create_purchase_payment($data) // for add payment option
	{
		$query = $this->db->insert(TABLE_PURCHASE_PAYMENT, $data);
		return $query;
	}
	function update_purchase_payment($data, $where)
	{
		$this->db->set($data);
		$this->db->where($where);
		$query = $this->db->update(TABLE_PURCHASE_PAYMENT . ' pp');
		return $query;
	}
	function create_purchase_payment_batch($data) // for batch add payment option
	{
		$query = $this->db->insert_batch(TABLE_PURCHASE_PAYMENT, $data);
		return $query;
	}
	function set_deleted_at_purchase_payment_ids($ids)
	{
		$this->db->where_in('id', $ids);
		$this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
		$this->db->set('deleted_by', $this->session->id);
		$query = $this->db->update(TABLE_PURCHASE_PAYMENT . ' pp');
		return $query;
	}
	function get_purchase_payment_row($where)
	{
		$this->db->select('*');
		$this->db->from(TABLE_PURCHASE_PAYMENT . ' pp');
		$this->db->where($where);
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query ? $query->row_array() : false;
	}
}
