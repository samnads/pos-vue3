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
		$product_total_without_tax = "(SUM(((pp.unit_cost - pp.unit_discount) * rpp.quantity)))";
		$product_total_tax = "(CASE 
			WHEN tr_pp.type = 'P' 
			THEN
				(IFNULL(tr_pp.rate, 0) / 100) * SUM(((pp.unit_cost - pp.unit_discount) * rpp.quantity))
			ELSE
				IFNULL(tr_pp.rate, 0)
		END)";
		$product_total_with_tax = "(" . $product_total_without_tax . " + " . $product_total_tax . ")";
		$product_total_with_tax_after_discount = "((" . $product_total_without_tax . " + " . $product_total_tax . ") - rp.discount)";
		$order_tax = "(CASE 
			WHEN tr_o.type = 'P' 
			THEN
				(IFNULL(tr_o.rate, 0) / 100) * " . $product_total_with_tax_after_discount . "
			ELSE
				IFNULL(tr_o.rate, 0)
		END)";
		$shipping_tax_value = "(CASE 
			WHEN tr_rp_s.type = 'P' THEN (IFNULL(tr_rp_s.rate, 0) / 100) * rp.shipping_charge
			ELSE IFNULL(tr_rp_s.rate, 0)
		END)";
		$shipping_total = "(" . $shipping_tax_value . " + rp.shipping_charge)";
		$packing_tax_value = "(CASE 
			WHEN tr_rp_p.type = 'P' THEN (IFNULL(tr_rp_p.rate, 0) / 100) * rp.packing_charge
			ELSE IFNULL(tr_rp_p.rate, 0)
		END)";
		$packing_total = "(" . $packing_tax_value . " + rp.packing_charge)";
		$total_payable_decimal = "(" . $product_total_with_tax_after_discount . "+" . $order_tax . "+" . $shipping_total . "+" . $packing_total . ")";
		$total_payable = "(ROUND(" . $product_total_with_tax_after_discount . "+" . $order_tax . "+" . $shipping_total . "+" . $packing_total . ",0))";
		$rounf_off = "(" . $total_payable_decimal . "-" . $total_payable . ")";
		$balance_return = "(SUM(rppy.amount)-" . $total_payable . ")";
		$due = "(" . $total_payable . "-SUM(rppy.amount))";
		$this->db->select('rp.id as id,
		rp.reference_id as reference_id,
		rp.purchase as purchase,
		rp.date as date,
		pc.reference_id as purchase_reference_id,
		SUM(rpp.quantity) as total_return_quantity,
		COUNT(DISTINCT(pp.product)) as product_count,
		st.name as status_name,
		st.css_class as css_class,
		SUM(pp.quantity) as total_purchase_quantity,
		' . $product_total_without_tax . ' as product_total_without_tax,
		' . $product_total_tax . ' as product_total_tax,
		' . $product_total_with_tax . ' as product_total_with_tax,
		' . $order_tax . ' as order_tax,
		rp.discount as discount,
		rp.shipping_charge			as shipping_charge,
		' . $shipping_tax_value . '	as shipping_tax_value,
		' . $shipping_total . '		as shipping_total,
		rp.packing_charge			as packing_charge,
		' . $packing_tax_value . '	as packing_tax_value,
		' . $packing_total . '		as packing_total,
		' . $product_total_with_tax_after_discount . ' as product_total_with_tax_after_discount,
		uc.first_name as created_by,
		uu.first_name as updated_by,
		s.name as supplier_name,
		w.name as warehouse_name,
		rp.created_at as created_at,
		' . $total_payable . ' as total_payable,
		' . $rounf_off . ' as rounf_off,
		SUM(rppy.amount) as total_paid,
		SUM(rppy.amount),
		' . $balance_return . ' as balance_return,
		' . $due . ' as due	
		');
		$this->db->from(TABLE_RETURN_PURCHASE .			' as rp');
		$this->db->join(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp',	'rpp.return_purchase = rp.id', 'left');
		$this->db->join(TABLE_PURCHASE_PRODUCT . 		' as pp',	'pp.id = rpp.purchase_product', 'left');
		$this->db->join(TABLE_PURCHASE . 				' as pc',	'pc.id = pp.purchase', 'left');
		$this->db->join(TABLE_PRODUCT . 				' as p',	'p.id = pp.product', 'left');
		$this->db->join(TABLE_TAX_RATE . 				' as tr_pp', 'tr_pp.id = pp.tax_id', 'left');
		$this->db->join(TABLE_TAX_RATE . 				' as tr_rp_s', 'tr_rp_s.id = rp.shipping_tax', 'left');
		$this->db->join(TABLE_TAX_RATE . 				' as tr_rp_p', 'tr_rp_p.id = rp.packing_tax', 'left');
		$this->db->join(TABLE_TAX_RATE . 				' as tr_o', 'tr_o.id = rp.return_tax', 'left');
		$this->db->join(TABLE_STATUS . 					' as st',	'st.id = rp.status', 'left');
		$this->db->join(TABLE_USER . 					' as uc',	'uc.id = rp.created_by', 'left');
		$this->db->join(TABLE_USER . 					' as uu',	'uc.id = rp.updated_by', 'left');
		$this->db->join(TABLE_SUPPLIER . 				' as s',	's.id = pc.supplier', 'left');
		$this->db->join(TABLE_WAREHOUSE . 				' as w',	'w.id = pc.warehouse', 'left');
		$this->db->join(TABLE_RETURN_PURCHASE_PAYMENT .	' as rppy',	'rppy.return_purchase = rp.id', 'left');
		$this->db->group_start();
		$this->db->or_like('rp.reference_id',	$search);
		$this->db->or_like('pc.reference_id',	$search);
		$this->db->or_like('rp.date',			$search);
		$this->db->or_like('rp.discount',		$search);
		$this->db->or_like('rp.shipping_charge', $search);
		$this->db->or_like('rp.packing_charge',	$search);
		$this->db->or_like('rp.round_off',		$search);
		$this->db->or_like('rp.payment_note',	$search);
		$this->db->or_like('rp.note',			$search);
		$this->db->or_like('rp.created_at',		$search);
		$this->db->or_like('rp.updated_at',		$search);
		$this->db->or_like('st.name',			$search);
		//$this->db->or_like('rppy.amount',		$search);
		$this->db->group_end();
		$this->db->where(array('rp.deleted_at' => NULL, 'pc.deleted_at' => NULL, 'rppy.deleted_at' => NULL));
		$this->db->group_by(array('rpp.return_purchase'));
		$this->db->order_by($order_by, $order);
		$query = $this->db->get('', $limit, $offset);
		//die($this->db->last_query());
		return $query;
	}
	function suggestProdsForReturn($search, $offset, $limit, $order_by, $order, $where)
	{
		/******************************************************/ // calculate returned qty
		$this->db->select('pp.product as product,rpp.purchase_product as purchase_product,SUM(rpp.quantity) as returned_quantity');
		$this->db->from(TABLE_PURCHASE_PRODUCT . ' as pp');
		$this->db->join(TABLE_PURCHASE . ' as p',    'p.id = pp.purchase', 'left');
		$this->db->join(TABLE_RETURN_PURCHASE . ' as rp',    'rp.id = pp.purchase', 'left');
		$this->db->join(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp',    'rpp.purchase_product = pp.id', 'left');
		$this->db->where(array('pp.purchase' => $where['purchase'], 'rp.deleted_at' => NULL));
		$this->db->group_by(array('pp.id', 'rpp.purchase_product'));
		$return_purchase_product_count = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($return_purchase_product_count);
		/******************************************************/
		$search = trim($search);
		$this->db->select("
		p.id														as id,
		p.code														as code,
		p.name														as name,
		p.name														as value,
		p.cost														as cost,
		p.mrp														as mrp,
		p.thumbnail													as thumbnail,
		p.tax_method												as tax_method,
		1															as quantity,

		pp.quantity													as purchase_quantity,
		IFNULL(rppc.returned_quantity,0)							as returned_quantity,
		IFNULL((pp.quantity - IFNULL(rppc.returned_quantity,0)),0)	as to_be_return_quantity,


		DATE_FORMAT(p.mfg_date,'%d/%b/%Y')							as mfg_date,
		DATE_FORMAT(p.exp_date,'%d/%b/%Y')							as exp_date,


		p.unit														as unit,
		u.name														as unit_name,
		u.code														as unit_code,
		IFNULL(p.p_unit,p.unit)										as p_unit,

		tr.id														as tax_id,
		tr.code														as tax_code,
		tr.name														as tax_name,
		tr.rate														as tax_rate,

		CONCAT('<span class=\'text-primary\'>',p.name,'</span>',' | ',p.code)	as label");

		$this->db->from(TABLE_PURCHASE_PRODUCT . ' as pp');
		$this->db->join(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp',	'rpp.purchase_product = pp.id',	'left');
		$this->db->join(TABLE_PRODUCT . ' as p',	'p.id = pp.product',	'left');
		$this->db->join(TABLE_UNIT . ' as u',	'u.id=pp.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr',	'tr.id=pp.tax_id',	'left');
		$this->db->join('(' . $return_purchase_product_count . ')  as rppc', 'rppc.purchase_product = rpp.purchase_product', 'left');
		$this->db->where(array('pp.purchase' => $where['purchase']));
		$this->db->group_by(array('pp.id'));
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
		$this->db->where($where);
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
	function get_return_purchase_products($where)
	{
		/******************************************************/
		$this->db->select('rpp.purchase_product as purchase_product,SUM(rpp.quantity) as returned_quantity');
		$this->db->from(TABLE_RETURN_PURCHASE . ' as rp');
		$this->db->join(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp',    'rpp.return_purchase = rp.id', 'left');
		$this->db->where(array('rp.deleted_at' => NULL, 'rp.purchase' => $where['purchase']));
		$this->db->group_by(array('rpp.purchase_product'));
		$return_purchase_product_count = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($return_purchase_product_count);
		/******************************************************/

		/******************************************************/
		$this->db->select('
		p.id														as id,
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
		$this->db->where(array('pp.purchase' => $where['purchase']));
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
		SUM(rpp.quantity)		as	returned_quantity,
		rpp.quantity			as	quantity,
		');
		$this->db->from(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp');
		$this->db->join(TABLE_RETURN_PURCHASE . ' as rp',    'rp.id = rpp.return_purchase', 'left');
		$this->db->join(TABLE_PURCHASE . ' as p',    'p.id = rp.purchase', 'left');
		$this->db->where(array('rp.purchase' => $where['purchase'], 'rp.deleted_at' => NULL, 'p.deleted_at' => NULL));
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
		$this->db->where(array('rp.purchase' => $where['purchase'], 'rp.deleted_at' => NULL, 'p.deleted_at' => NULL));
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
		$this->db->join('(' . $get_this_return_count . ')  as gtrc', 'gtrc.id = rppc.id', 'left');
		$this->db->where(array('p.id' => $where['purchase'],'p.deleted_at' => NULL));
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
	function delete_purchase_products($where)
	{
		$this->db->where($where);
		$query = $this->db->delete(TABLE_PURCHASE_PRODUCT);
		return $query;
	}
	function create_return_purchase_payment($data) // for add payment option
	{
		$query = $this->db->insert(TABLE_RETURN_PURCHASE_PAYMENT, $data);
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
