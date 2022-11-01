<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchase_return_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	function datatable_data($search, $offset, $limit, $order_by, $order)
	{
		/******************************************** */ // get return purchase payment
		$this->db->select('
		rp.id as	id,
		SUM(rppy.amount) as amount
		');
		$this->db->from(TABLE_RETURN_PURCHASE_PAYMENT . ' as rppy');
		$this->db->join(TABLE_RETURN_PURCHASE . ' as rp',    'rp.id = rppy.return_purchase', 'left');
		$this->db->where(array('rppy.deleted_at' => NULL, 'rp.deleted_at' => NULL));
		$this->db->group_by(array('rp.id'));
		$return_purchase_payment = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($return_purchase_payment);
		/******************************************** */
		$product_total_without_tax = "(SUM((pp.unit_cost - pp.unit_discount) * rpp.quantity))";
		$product_total_tax = "(CASE 
			WHEN tr_pp.type = 'P' 
			THEN
				(IFNULL(tr_pp.rate, 0) / 100) * (SUM((pp.unit_cost - pp.unit_discount) * rpp.quantity))
			ELSE
				IFNULL(tr_pp.rate, 0)
		END)";
		$product_total_with_tax = "(" . $product_total_without_tax . " + " . $product_total_tax . ")";
		$product_total_with_tax_after_discount = "((" . $product_total_without_tax . " + " . $product_total_tax . ") - rp.discount)";
		$shipping_tax_value = "(CASE 
			WHEN tr_rp_s.type = 'P' THEN (IFNULL(tr_rp_s.rate, 0) / 100) * rp.shipping_charge
			ELSE IFNULL(tr_rp_s.rate, 0)
		END)";
		$shipping_total = "(" . $shipping_tax_value . " + rp.shipping_charge)";
		$order_tax = "(CASE 
			WHEN tr_o.type = 'P' 
			THEN
				(IFNULL(tr_o.rate, 0) / 100) * " . $product_total_with_tax_after_discount . "
			ELSE
				IFNULL(tr_o.rate, 0)
		END)";
		$packing_tax_value = "(CASE 
			WHEN tr_rp_p.type = 'P' THEN (IFNULL(tr_rp_p.rate, 0) / 100) * rp.packing_charge
			ELSE IFNULL(tr_rp_p.rate, 0)
		END)";
		$packing_total = "(" . $packing_tax_value . " + rp.packing_charge)";
		$total_payable_decimal = "(" . $product_total_with_tax_after_discount . "+" . $order_tax . "+" . $shipping_total . "+" . $packing_total . ")";
		$total_payable = "(ROUND(" . $product_total_with_tax_after_discount . "+" . $order_tax . "+" . $shipping_total . "+" . $packing_total . ",0))";
		$rounf_off = "(" . $total_payable_decimal . "-" . $total_payable . ")";
		$balance_return = "(IFNULL(rppy.amount,0) - " . $total_payable . ")";
		$due = "(IFNULL(" . $total_payable . " - IFNULL(rppy.amount,0),0))";

		$this->db->select('
		rp.id as id,
		rp.reference_id as reference_id,
		pc.reference_id as purchase_reference_id,
		rp.purchase as purchase,
		rp.date as date,
		COUNT(DISTINCT(pp.id)) as product_count,
		rp.discount as discount,
		rp.created_at as created_at,
		rp.payment_note as payment_note,
		s.name as supplier_name,
		w.name as warehouse_name,
		st.name as status_name,
		st.css_class as css_class,
		IFNULL(rppy.amount,0) as total_paid,
		' . $product_total_without_tax .' as product_total_without_tax,
		' . $product_total_tax .' as product_total_tax,
		' . $product_total_with_tax .' as product_total_with_tax,
		' . $product_total_with_tax_after_discount .' as product_total_with_tax_after_discount,
		' . $shipping_tax_value . '	as shipping_tax_value,
		' . $shipping_total .' as shipping_total,
		' . $packing_total .' as packing_total,
		' . $total_payable .' as total_payable,
		' . $rounf_off .' as rounf_off,
		' . $balance_return . ' as balance_return,
		' . $due . ' as due');
		$this->db->from(TABLE_RETURN_PURCHASE . ' as rp');
		$this->db->join(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp',	'rpp.return_purchase = rp.id', 'left');
		$this->db->join(TABLE_PURCHASE_PRODUCT . ' as pp',	'pp.id = rpp.purchase_product', 'left');
		$this->db->join(TABLE_PURCHASE . ' as pc',	'pc.id = rp.purchase', 'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr_pp', 'tr_pp.id = pp.tax_id', 'left');
		$this->db->join(TABLE_TAX_RATE . 				' as tr_rp_s', 'tr_rp_s.id = rp.shipping_tax', 'left');
		$this->db->join(TABLE_TAX_RATE . 				' as tr_rp_p', 'tr_rp_p.id = rp.packing_tax', 'left');
		$this->db->join(TABLE_TAX_RATE . 				' as tr_o', 'tr_o.id = rp.return_tax', 'left');
		$this->db->join(TABLE_STATUS . 					' as st',	'st.id = rp.status', 'left');
		$this->db->join(TABLE_SUPPLIER . 				' as s',	's.id = pc.supplier', 'left');
		$this->db->join(TABLE_WAREHOUSE . 				' as w',	'w.id = pc.warehouse', 'left');
		$this->db->join('(' . $return_purchase_payment . ')  as rppy', 'rppy.id = rp.id', 'left');
		$this->db->group_start();
		$this->db->or_like('rp.reference_id',	$search);
		$this->db->or_like('pc.reference_id',	$search);
		$this->db->or_like('w.name',	$search);
		$this->db->or_like('s.name',	$search);
		$this->db->or_like('st.name',	$search);
		$this->db->or_like('rppy.amount',	$search);
		$this->db->group_end();
		$this->db->where(array('rp.deleted_at' => NULL,'rpp.deleted_at' => NULL, 'pc.deleted_at' => NULL, 'pp.deleted_at' => NULL));
		$this->db->group_by(array('rp.id'));
		$this->db->order_by($order_by, $order);
		$query = $this->db->get('', $limit, $offset);
		//die($this->db->last_query());
		return $query;
	}
	function suggestProdsForReturnAdd($search, $offset, $limit, $order_by, $order, $where)
	{
		/******************************************** */ // get return count except this return
		$this->db->select('
		rpp.purchase_product	as	id,
		SUM(rpp.quantity)		as	returned_quantity
		');
		$this->db->from(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp');
		$this->db->join(TABLE_RETURN_PURCHASE . ' as rp',    'rp.id = rpp.return_purchase', 'left');
		$this->db->join(TABLE_PURCHASE . ' as p',    'p.id = rp.purchase', 'left');
		$this->db->where(array('p.id' => $where['purchase'], 'rp.deleted_at' => NULL, 'p.deleted_at' => NULL, 'rpp.deleted_at' => NULL));
		$this->db->group_by(array('rpp.purchase_product'));
		$return_purchase_product_count = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($return_purchase_product_count);
		/******************************************** */ // get purchase product count
		$this->db->select("
		pp.id as 																id,
		pp.product as 															product,
		1 as 																	quantity,
		rppc.returned_quantity as 												returned_quantity,
		pp.quantity - IFNULL(rppc.returned_quantity,0)	as						to_be_return_quantity,
		pp.quantity as															purchase_quantity,
		pr.code	as																code,
		pr.name	as																name,
		pr.tax_method as 														tax_method,
		pp.unit as																unit,
		pp.unit	as																p_unit,
		pp.unit_cost as															unit_cost,
		IFNULL(pp.unit_discount,0)	as											unit_discount,
		IFNULL(u.step,1) as														step,
		pp.tax_id as															tax_id,
		tr.rate as																tax_rate,
		CONCAT('<span class=\'text-primary\'>',pr.name,'</span>',' | ',pr.code,' | PQ : ',pp.quantity)	as label
		");
		$this->db->from(TABLE_PURCHASE_PRODUCT . ' as pp');
		$this->db->join(TABLE_PURCHASE . ' as p',    'p.id = pp.purchase', 'left');
		$this->db->join(TABLE_PRODUCT . ' as pr',    'pr.id = pp.product', 'left');
		$this->db->join(TABLE_UNIT . ' as u',	'u.id=pp.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr',	'tr.id=pp.tax_id',	'left');
		$this->db->join('(' . $return_purchase_product_count . ')  as rppc', 'rppc.id = pp.id', 'left');
		$this->db->where(array('p.id' => $where['purchase'], 'p.deleted_at' => NULL, 'pp.deleted_at' => NULL));
		$this->db->group_by(array('pp.id'));
		$this->db->group_start();
		$this->db->order_by($order_by, $order);
		$this->db->or_like('pr.code',	$search);
		$this->db->or_like('pr.name',	$search);
		$this->db->group_end();
		$query = $this->db->get('', $limit, $offset);
		//die($this->db->last_query());
		return $query ? $query : false;
	}
	function suggestProdsForReturnEdit($search, $offset, $limit, $order_by, $order, $where)
	{
		/******************************************** */ // get return count except this return
		$this->db->select('
		rpp.purchase_product	as	id,
		SUM(rpp.quantity)		as	returned_quantity
		');
		$this->db->from(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp');
		$this->db->join(TABLE_RETURN_PURCHASE . ' as rp',    'rp.id = rpp.return_purchase', 'left');
		$this->db->join(TABLE_PURCHASE . ' as p',    'p.id = rp.purchase', 'left');
		$this->db->where(array('rp.purchase' => $where['purchase'], 'rp.deleted_at' => NULL, 'p.deleted_at' => NULL, 'rpp.deleted_at' => NULL));
		$this->db->where(array('rp.id !=' => $where['return_purchase'])); // edits don't count self data
		$this->db->group_by(array('rpp.purchase_product'));
		$return_purchase_product_count = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($return_purchase_product_count);
		/******************************************** */ // get return count for this return
		$this->db->select('
		rpp.purchase_product	as	id,
		IFNULL(rpp.quantity,0)			as	quantity,
		');
		$this->db->from(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp');
		$this->db->join(TABLE_RETURN_PURCHASE . ' as rp',    'rp.id = rpp.return_purchase', 'left');
		$this->db->join(TABLE_PURCHASE . ' as p',    'p.id = rp.purchase', 'left');
		$this->db->where(array('rp.purchase' => $where['purchase'], 'rp.deleted_at' => NULL, 'p.deleted_at' => NULL, 'rpp.deleted_at' => NULL));
		$this->db->where(array('rp.id' => $where['return_purchase'])); // count self data
		$this->db->group_by(array('rpp.purchase_product'));
		$get_this_return_count = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($get_this_return_count);
		/******************************************** */ // get purchase product count
		$this->db->select("
		pp.id as 																id,
		(CASE 
			WHEN pp.quantity - IFNULL(rppc.returned_quantity,0) = 0
			THEN
				0
			ELSE
				gtrc.quantity
		END) as 																quantity,
		IFNULL(rppc.returned_quantity,0)	as 									returned_quantity,
		pp.quantity - IFNULL(rppc.returned_quantity,0) as 						to_be_return_quantity,
		pp.quantity as															purchase_quantity,
		pr.code	as																code,
		pr.name	as																name,
		pr.tax_method as 														tax_method,
		pp.unit as																unit,
		pp.unit	as																p_unit,
		pp.unit_cost	as														unit_cost,
		IFNULL(u.step,1) as														step,
		pp.unit_discount as														unit_discount,
		pp.tax_id as															tax_id,
		tr.rate as																tax_rate,
		CONCAT('<span class=\'text-primary\'>',pr.name,'</span>',' | ',pr.code,' | PQ : ',pp.quantity)	as label
		");
		$this->db->from(TABLE_PURCHASE_PRODUCT . ' as pp');
		$this->db->join(TABLE_PURCHASE . ' as p',    'p.id = pp.purchase', 'left');
		$this->db->join(TABLE_PRODUCT . ' as pr',    'pr.id = pp.product', 'left');
		$this->db->join(TABLE_UNIT . ' as u',	'u.id=pp.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr',	'tr.id=pp.tax_id',	'left');
		$this->db->join('(' . $return_purchase_product_count . ')  as rppc', 'rppc.id = pp.id', 'left');
		$this->db->join('(' . $get_this_return_count . ')  as gtrc', 'gtrc.id = pp.id', 'left');
		$this->db->where(array('p.id' => $where['purchase'], 'p.deleted_at' => NULL, 'pp.deleted_at' => NULL));
		$this->db->group_by(array('pp.id'));
		$this->db->group_start();
		$this->db->order_by($order_by, $order);
		$this->db->or_like('pr.code',	$search);
		$this->db->or_like('pr.name',	$search);
		$this->db->group_end();
		$query = $this->db->get('', $limit, $offset);
		//die($this->db->last_query());
		return $query ? $query : false;
	}
	function get_AUTO_INCREMENT()
	{
		$this->db->select('AUTO_INCREMENT');
		$this->db->from('INFORMATION_SCHEMA.TABLES');
		$this->db->where(array('TABLE_NAME' => TABLE_RETURN_PURCHASE, 'TABLE_SCHEMA' => $this->db->database));
		$query = $this->db->get();
		$cnt = $query->row_array();
		return $cnt['AUTO_INCREMENT'];
	}
	function get_purchase_row_by_id($where)
	{
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
		');
		$this->db->from(TABLE_PURCHASE . ' as p');
		$this->db->where(array('p.id' => $where['purchase'], 'p.deleted_at' => NULL));
		$query = $this->db->get();
		return $query ? $query->row_array() : false;
	}
	function get_purchase_return_row_by_id($where)
	{
		$this->db->select('
		`rp.id as id`,
		`rp.purchase as purchase`,
		`rp.reference_id as reference_id`,
		`p.reference_id as purchase_reference_id`,
		`rp.date`,
		`rp.time`,
		`rp.status`,
		`rp.discount`,
		`rp.return_tax`,
		`rp.shipping_charge`,
		`rp.shipping_tax`,
		`rp.packing_charge`,
		`rp.packing_tax`,
		`rp.return_tax`,
		`rp.round_off`,
		`rp.payment_note`,
		`rp.note`,
		');
		$this->db->from(TABLE_RETURN_PURCHASE . ' as rp');
		$this->db->join(TABLE_PURCHASE . ' as p',	'p.id=rp.purchase',	'left');
		$this->db->where(array('rp.id' => $where['return_purchase'], 'rp.deleted_at' => NULL));
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query ? $query->row_array() : false;
	}
	function getPurchaseReturnProductsDetails($where)
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
		rpp.quantity												as quantity,
		p.unit														as unit,
		u.name														as unit_name,
		u.code														as unit_code,
		tr.rate														as tax_rate');
		$this->db->from(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp');
		$this->db->join(TABLE_RETURN_PURCHASE . ' as rp',	'rp.id=rpp.return_purchase',	'left');
		$this->db->join(TABLE_PURCHASE_PRODUCT . ' as pp',	'pp.id=rpp.purchase_product',	'left');
		$this->db->join(TABLE_PURCHASE . ' as pc',	'pc.id=pp.purchase',	'left');
		$this->db->join(TABLE_PRODUCT . ' as p',	'p.id=pp.product',	'left');
		$this->db->join(TABLE_UNIT . ' as u',	'u.id=pp.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr',	'tr.id=pp.tax_id',	'left');
		$this->db->where(array('rp.id' => $where['return_purchase'], 'rp.deleted_at' => NULL, 'pc.deleted_at' => NULL, 'rpp.deleted_at' => NULL));
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query ? $query->result() : false;
	}
	function getPurchaseReturnDetails($where)
	{
		$this->db->select('
		rp.reference_id										as reference_id,
		p.reference_id										as purchase_reference_id,
		w.name												as warehouse_name,
		rp.date												as date,
		rp.time												as time,
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
		$this->db->from(TABLE_RETURN_PURCHASE . ' as rp');
		$this->db->join(TABLE_PURCHASE . ' as p',	'p.id=rp.purchase',	'left');
		$this->db->join(TABLE_WAREHOUSE . ' as w',	'w.id=p.warehouse',	'left');
		$this->db->join(TABLE_SUPPLIER . ' sp',	'sp.id=p.supplier',	'left');
		$this->db->join(TABLE_STATUS . ' as s',	's.id=rp.status',	'left');
		$this->db->join(TABLE_USER . ' as cu',	'cu.id=rp.created_by',	'left');
		$this->db->join(TABLE_USER . ' as uu',	'uu.id=rp.updated_by',	'left');
		$this->db->where(array('rp.id' => $where['return_purchase'], 'rp.deleted_at' => NULL));
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query ? $query->row_array() : false;
	}
	function getPurchaseReturnPayments($where)
	{
		$this->db->select('
		rpp.id										as id,
		rpp.date_time								as date_time,
		pm.name										as payment_mode_name,
		pm.id										as mode,
		rpp.amount									as amount,
		rpp.transaction_id							as transaction_id,
		rpp.reference_no							as reference_no,
		rpp.note									as note');
		$this->db->from(TABLE_RETURN_PURCHASE_PAYMENT . ' as rpp');
		$this->db->join(TABLE_PAYMENT_MODE . ' as pm',	'pm.id=rpp.payment_mode',	'left');
		$this->db->join(TABLE_RETURN_PURCHASE . ' as rp',	'rp.id=rpp.return_purchase',	'left');
		$this->db->join(TABLE_PURCHASE . ' as p',	'p.id=rp.purchase',	'left');
		$this->db->where(array('rpp.return_purchase' => $where['purchase_return'], 'rpp.deleted_at' => NULL, 'rp.deleted_at' => NULL, 'p.deleted_at' => NULL));
		$this->db->order_by("rpp.date_time", "desc");
		$this->db->group_by(array('rpp.id'));
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query ? $query->result_array() : false;
	}
	function get_return_purchase_products_for_add($where)
	{
		/******************************************************/
		$this->db->select('rpp.purchase_product as purchase_product,SUM(rpp.quantity) as returned_quantity');
		$this->db->from(TABLE_RETURN_PURCHASE . ' as rp');
		$this->db->join(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp',    'rpp.return_purchase = rp.id', 'left');
		$this->db->where(array('rp.deleted_at' => NULL, 'rp.purchase' => $where['purchase'], 'rpp.deleted_at' => NULL));
		$this->db->group_by(array('rpp.purchase_product'));
		$return_purchase_product_count = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($return_purchase_product_count);
		/******************************************************/
		$this->db->select('
		pp.id														as id,
		pp.id														as purchase_product,
		p.code														as code,
		p.name														as name,
		pp.unit														as p_unit,
		pp.unit_cost												as unit_cost,
		(pp.unit_cost / IFNULL(u.step,1))							as db_cost,
		pp.unit_discount											as unit_discount,
		pp.tax_id													as tax_id,
		0															as quantity,
		pp.quantity													as purchase_quantity,
		IFNULL(rppc.returned_quantity,0)							as returned_quantity,
		IFNULL((pp.quantity - IFNULL(rppc.returned_quantity,0)),0)	as to_be_return_quantity,
		p.unit														as unit,
		u.name														as unit_name,
		u.code														as unit_code,
		tr.rate														as tax_rate');
		$this->db->from(TABLE_PURCHASE_PRODUCT . ' as pp');
		$this->db->join(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp',	'rpp.purchase_product = pp.id',	'left');
		$this->db->join(TABLE_PRODUCT . ' as p',	'p.id = pp.product',	'left');
		$this->db->join(TABLE_UNIT . ' as u',	'u.id=pp.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr',	'tr.id=pp.tax_id',	'left');
		$this->db->join('(' . $return_purchase_product_count . ')  as rppc', 'rppc.purchase_product = rpp.purchase_product', 'left');
		$this->db->where(array('pp.purchase' => $where['purchase'], 'pp.deleted_at' => NULL, 'rpp.deleted_at' => NULL));
		$this->db->group_by(array('pp.id'));
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query ? $query->result() : false;
	}
	function get_return_purchase_products_for_edit($where)
	{
		/******************************************** */ // get return count except this return
		$this->db->select('
		rpp.purchase_product	as	id,
		SUM(rpp.quantity)		as	returned_quantity
		');
		$this->db->from(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp');
		$this->db->join(TABLE_RETURN_PURCHASE . ' as rp',    'rp.id = rpp.return_purchase', 'left');
		$this->db->join(TABLE_PURCHASE . ' as p',    'p.id = rp.purchase', 'left');
		$this->db->where(array('rp.purchase' => $where['purchase'], 'rp.deleted_at' => NULL, 'p.deleted_at' => NULL, 'rpp.deleted_at' => NULL));
		$this->db->where(array('rp.id !=' => $where['return_purchase'])); // edits dont count self data
		$this->db->group_by(array('rpp.purchase_product'));
		$return_purchase_product_count = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($return_purchase_product_count);
		/******************************************** */ // get return count for this return
		$this->db->select('
		rpp.purchase_product	as	id,
		IFNULL(rpp.quantity,0)			as	quantity,
		');
		$this->db->from(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp');
		$this->db->join(TABLE_RETURN_PURCHASE . ' as rp',    'rp.id = rpp.return_purchase', 'left');
		$this->db->join(TABLE_PURCHASE . ' as p',    'p.id = rp.purchase', 'left');
		$this->db->where(array('rp.purchase' => $where['purchase'], 'rp.deleted_at' => NULL, 'p.deleted_at' => NULL, 'rpp.deleted_at' => NULL));
		$this->db->where(array('rp.id' => $where['return_purchase'])); // count self data
		$this->db->group_by(array('rpp.purchase_product'));
		$get_this_return_count = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($get_this_return_count);
		/******************************************** */ // get purchase product count
		$this->db->select('
		pp.id as 																id,
		(CASE 
			WHEN pp.quantity - IFNULL(rppc.returned_quantity,0) = 0
			THEN
				0
			ELSE
				gtrc.quantity
		END) as 																quantity,
		IFNULL(rppc.returned_quantity,0)	as 									returned_quantity,
		pp.quantity - IFNULL(rppc.returned_quantity,0) as 						to_be_return_quantity,
		pp.product as															product,
		pp.quantity as															purchase_quantity,
		pr.code	as																code,
		pr.name	as																name,
		pp.unit as																unit,
		pp.unit	as																p_unit,
		pp.unit_cost	as														unit_cost,
		(pp.unit_cost / IFNULL(u.step,1)) as									db_cost,
		IFNULL(u.step,1) as														step,
		pp.unit_discount as														unit_discount,
		pp.tax_id as															tax_id,
		tr.rate as																tax_rate,
		');
		$this->db->from(TABLE_PURCHASE_PRODUCT . ' as pp');
		$this->db->join(TABLE_PURCHASE . ' as p',    'p.id = pp.purchase', 'left');
		$this->db->join(TABLE_PRODUCT . ' as pr',    'pr.id = pp.product', 'left');
		$this->db->join(TABLE_UNIT . ' as u',	'u.id=pp.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr',	'tr.id=pp.tax_id',	'left');
		$this->db->join('(' . $return_purchase_product_count . ')  as rppc', 'rppc.id = pp.id', 'left');
		$this->db->join('(' . $get_this_return_count . ')  as gtrc', 'gtrc.id = pp.id', 'left');
		$this->db->where(array('p.id' => $where['purchase'], 'p.deleted_at' => NULL, 'pp.deleted_at' => NULL));
		$this->db->group_by(array('pp.id'));
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query ? $query->result() : false;
	}
	function insert_purchase_return($data)
	{
		$query = $this->db->insert(TABLE_RETURN_PURCHASE, $data);
		return $query;
	}
	function update_return_purchase($data, $id)
	{
		$this->db->where(array('id' => $id, 'deleted_at' => NULL));
		$query = $this->db->update(TABLE_RETURN_PURCHASE, $data);
		return $query;
	}
	function set_deleted_at($where) // mark as deleted
	{
		$this->db->where($where);
		$this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
		$this->db->set('deleted_by', $this->session->id);
		$query = $this->db->update(TABLE_RETURN_PURCHASE);
		return $query;
	}
	function insert_purchase_return_product($data)
	{
		$query = $this->db->insert(TABLE_RETURN_PURCHASE_PRODUCT, $data);
		return $query;
	}
	function delete_return_purchase_products_SET_TIME($where)
	{
		$this->db->where($where);
		$this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
		$query = $this->db->update(TABLE_RETURN_PURCHASE_PRODUCT);
		return $query;
	}
	function create_return_purchase_payment($data) // for add payment option
	{
		$query = $this->db->insert(TABLE_RETURN_PURCHASE_PAYMENT, $data);
		return $query;
	}
	function update_return_purchase_payment($data, $where)
	{
		$this->db->set($data);
		$this->db->where($where);
		$query = $this->db->update(TABLE_RETURN_PURCHASE_PAYMENT . ' as rpp');
		return $query;
	}
	function create_purchase_return_payment_batch($data) // for batch add payment option
	{
		$query = $this->db->insert_batch(TABLE_RETURN_PURCHASE_PAYMENT, $data);
		return $query;
	}
	function set_deleted_at_purchase_return_payment_ids($ids)
	{
		$this->db->where_in('id', $ids);
		$this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
		$this->db->set('deleted_by', $this->session->id);
		$query = $this->db->update(TABLE_RETURN_PURCHASE_PAYMENT);
		return $query;
	}
	function get_purchase_return_payment_row($where)
	{
		$this->db->select('*');
		$this->db->from(TABLE_RETURN_PURCHASE_PAYMENT . ' as rpp');
		$this->db->where(array('rpp.id'=>$where['id'], 'rpp.return_purchase'=> $where['return_purchase']));
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query ? $query->row_array() : false;
	}
}
