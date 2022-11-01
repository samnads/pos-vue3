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
		/********************************************************************************************/ // warehouse based stock calculation
		/******************************************************/ // calc quantity using stock adjustments
		$this->db->select('p.id as p_id,sa.id as sa_id,wh.id as wh_id,wh.name as wh_name,SUM(sap.quantity) as total_sap_quantity');
		$this->db->from(TABLE_WAREHOUSE . ' as wh');
		$this->db->join(TABLE_STOCK_ADJUSTMENT . ' as sa',    'sa.warehouse = wh.id', 'left');
		$this->db->join(TABLE_STOCK_ADJUSTMENT_PRODUCT . ' as sap',    'sap.stock_adjustment = sa.id', 'left');
		$this->db->join(TABLE_PRODUCT . ' as p',    'p.id = sap.product', 'left');
		$this->db->where(array('p.id' => $id));
		$this->db->group_by('p_id');
		$this->db->group_by('wh.id');
		$query_sap = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($query_sap);
		/******************************************************/ // calc quantity using pos sales
		$this->db->select('p.id as p_id,ps.id as ps_id,wh.id as wh_id,wh.name as wh_name,SUM(psp.quantity) as total_psp_quantity');
		$this->db->from(TABLE_WAREHOUSE . ' as wh');
		$this->db->join(TABLE_POS_SALE . ' as ps',    'ps.warehouse = wh.id', 'left');
		$this->db->join(TABLE_POS_SALE_PRODUCT . ' as psp',    'psp.pos_sale = ps.id', 'left');
		$this->db->join(TABLE_PRODUCT . ' as p',    'p.id = psp.product', 'left');
		$this->db->where(array('p.id' => $id));
		$this->db->group_by('p_id');
		$this->db->group_by('wh.id');
		$query_psp = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($query_psp);
		/******************************************************/ // calc quantity using purchase - received status
		$this->db->select('p.id as p_id,pc.id as pc_id,wh.id as wh_id,wh.name as wh_name,,SUM(IFNULL(u.step,1) * pp.quantity) as total_pp_quantity');
		$this->db->from(TABLE_WAREHOUSE . ' as wh');
		$this->db->join(TABLE_PURCHASE . ' as pc',    'pc.warehouse = wh.id', 'left');
		$this->db->join(TABLE_PURCHASE_PRODUCT . ' as pp',    'pp.purchase = pc.id', 'left');
		$this->db->join(TABLE_PRODUCT . ' as p',    'p.id = pp.product', 'left');
		$this->db->join(TABLE_UNIT . ' as u',    'u.id = pp.unit', 'left'); // useful for bulk quantity calc
		$this->db->where('pc.deleted_at', NULL); // select only not deleted rows
		$this->db->where('pc.status', 22); // 22 - for received status
		$this->db->where(array('p.id' => $id));
		$this->db->group_by('p.id');
		$this->db->group_by('wh.id');
		//$this->db->where('pc.warehouse', 27); // change this for warehouse based stock, remove for all warehouse
		$this->db->group_by('pp.product');
		$query_pur_product = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($query_pur_product);
		/******************************************************/ // join all
		$this->db->select('wh.name as warehouse_name,qsap.p_id as sap_product,qpsp.p_id as psp_product,total_sap_quantity,total_psp_quantity,(IFNULL(qsap.total_sap_quantity,0) - IFNULL(qpsp.total_psp_quantity,0) + IFNULL(qpp.total_pp_quantity,0)) total_wh_quantity');
		$this->db->from(TABLE_WAREHOUSE . ' as wh');
		$this->db->join('(' . $query_sap . ') as qsap', 'qsap.wh_id = wh.id', 'left');
		$this->db->join('(' . $query_psp . ') as qpsp', 'qpsp.wh_id = wh.id', 'left');
		$this->db->join('(' . $query_pur_product . ') as qpp', 'qpp.wh_id = wh.id', 'left');
		$this->db->where(array('wh.deleted_at' => NULL));
		$query_stock = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($query_stock);
		/********************************************************************************************/ // product more details
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
		
		t.name 		as type_name,
		
		bs.code 	as symbology_code,
		
		c.name 		as category_name,
		
		b.code 		as brand_code,
		b.name 		as brand_name,

		u.code 		as unit_code,
		u.name 		as unit_name,

		tr.code		as tax_code,
		tr.name		as tax_name,
		tr.rate		as tax_rate');
		$this->db->from(TABLE_PRODUCT . ' as p');
		$this->db->join(TABLE_PRODUCT_TYPE . ' as t',	't.id=p.type',	'left');
		$this->db->join(TABLE_BARCODE_SYMBOLOGY . ' as bs',	'bs.id=p.symbology',	'left');
		$this->db->join(TABLE_CATEGORY . ' as c',	'c.id=p.category',	'left');
		$this->db->join(TABLE_BRAND . ' as b',	'b.id=p.brand',	'left');
		$this->db->join(TABLE_UNIT . ' as u',	'u.id=p.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr',	'tr.id=p.tax_rate',	'left');
		$this->db->where('p.id',	$id);
		$data = $this->db->get();
		$data = $data->row();
		$query_stock = $this->db->query($query_stock);
		$data->stock = $query_stock->result_array();
		return $data;
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
		$this->db->join(TABLE_BRAND . '				b',	'b.id=p.brand',	'left');
		$this->db->join(TABLE_UNIT . '				u',	'u.id=p.unit',	'left');
		$this->db->join(TABLE_TAX_RATE . '			tr',	'tr.id=p.tax_rate',	'left');
		$this->db->where(array('p.id' => $id));
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
	function datatable_data($search, $offset, $limit, $order_by, $order)
	{
		/******************************************************/ // calc quantity using stock adjustments
		$this->db->select('sap.id as sap_id,sap.product as sap_product,SUM(sap.quantity) as total_sap_quantity');
		$this->db->from(TABLE_STOCK_ADJUSTMENT_PRODUCT . ' as sap');
		$this->db->join(TABLE_STOCK_ADJUSTMENT . ' as sa',    'sa.id = sap.stock_adjustment', 'left');
		$this->db->join(TABLE_PRODUCT . ' as p',    'p.id = sap.product', 'left');
		$this->db->where('sa.deleted_at', NULL); // select only not deleted rows
		//$this->db->where('sa.warehouse', 27); // change this for warehouse based stock, remove for all warehouse
		$this->db->group_by('sap.product');
		$query_stock_adj_product = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($query_stock_adj_product);
		/******************************************************/ // calc quantity using pos sales
		$this->db->select('psp.product as psp_product,SUM(-psp.quantity) as total_psp_quantity');
		$this->db->from(TABLE_POS_SALE_PRODUCT . ' as psp');
		$this->db->join(TABLE_POS_SALE . ' as ps',    'ps.id = psp.pos_sale', 'left');
		$this->db->join(TABLE_PRODUCT . ' as p',    'p.id = psp.product', 'left');
		$this->db->where('ps.deleted_at', NULL); // select only not deleted rows
		//$this->db->where('ps.warehouse', 27); // change this for warehouse based stock, remove for all warehouse
		$this->db->group_by('psp.product');
		$query_pos_sale_product = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($query_pos_sale_product);
		/******************************************************/ // calc quantity using purchase - received status
		$this->db->select('pp.product as pp_product,SUM(IFNULL(u.step,1) * pp.quantity) as total_pp_quantity');
		$this->db->from(TABLE_PURCHASE_PRODUCT . ' as pp');
		$this->db->join(TABLE_PURCHASE . ' as pc',    'pc.id = pp.purchase', 'left');
		$this->db->join(TABLE_PRODUCT . ' as p',    'p.id = pp.product', 'left');
		$this->db->join(TABLE_UNIT . ' as u',    'u.id = pp.unit', 'left'); // useful for bulk quantity calc
		$this->db->where('pc.deleted_at', NULL); // select only not deleted rows
		$this->db->where('pc.status', 22); // 22 - for received status
		//$this->db->where('pc.warehouse', 27); // change this for warehouse based stock, remove for all warehouse
		$this->db->group_by('pp.product');
		$query_pur_product = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($query_pur_product);
		/******************************************************/ // calc quantity using purchase return - received status
		$this->db->select('pp.product as pr_product,SUM(IFNULL(u.step,1) * rpp.quantity) as total_pr_quantity');
		$this->db->from(TABLE_RETURN_PURCHASE_PRODUCT . ' as rpp');
		$this->db->join(TABLE_RETURN_PURCHASE . ' as rp',    'rp.id = rpp.return_purchase', 'left');
		$this->db->join(TABLE_PURCHASE_PRODUCT . ' as pp',    'pp.id = rpp.purchase_product', 'left');
		$this->db->join(TABLE_PURCHASE . ' as pc',    'pc.id = pp.purchase', 'left');
		$this->db->join(TABLE_PRODUCT . ' as p',    'p.id = pp.product', 'left');
		$this->db->join(TABLE_UNIT . ' as u',    'u.id = pp.unit', 'left'); // useful for bulk quantity calc
		$this->db->where(array('rp.deleted_at' => NULL, 'rpp.deleted_at' => NULL, 'pc.deleted_at' => NULL, 'pp.deleted_at' => NULL,'pc.status'=> 22));
		$this->db->group_by('pp.id');
		$query_pur_ret_product = $this->db->get_compiled_select();
		$this->db->reset_query();
		//die($query_pur_ret_product);
		/******************************************************/
		$search = trim($search);
		$this->db->select(
			'
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
		p.deletable			as deletable,
		p.deleted_at		as deleted_at,
		
		t.id 		as type,
		t.name 		as type_name,
		
		bs.code 	as symbology_code,
		
		c.id 		as category,
		c.name 		as category_name,
		
		b.id 		as brand,
		b.code 		as brand_code,
		b.name 		as brand_name,

		u.id 		as unit,
		u.code 		as unit_code,
		u.name 		as unit_name,

		p.p_unit 	as p_unit,
		p.s_unit 	as s_unit,

		tr.id		as tax_rate,
		tr.code		as tax_code,
		tr.name		as tax_name,
		IFNULL(qsap.total_sap_quantity, 0) + IFNULL(qpsp.total_psp_quantity, 0) + IFNULL(qpp.total_pp_quantity, 0) - IFNULL(qpr.total_pr_quantity, 0) as quantity'
		);
		$this->db->from(TABLE_PRODUCT . ' as p');
		$this->db->join(TABLE_PRODUCT_TYPE . ' as t',		't.id=p.type',			'left');
		$this->db->join(TABLE_BARCODE_SYMBOLOGY . ' as bs',	'bs.id=p.symbology',	'left');
		$this->db->join(TABLE_CATEGORY . ' as c',		'c.id=p.category',		'left');
		$this->db->join(TABLE_BRAND . ' as b',		'b.id=p.brand',			'left');
		$this->db->join(TABLE_UNIT . ' as u',		'u.id=p.unit',			'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr',	'tr.id=p.tax_rate',		'left');
		$this->db->join('(' . $query_stock_adj_product . ') as qsap', 'qsap.sap_product = p.id', 'left');
		$this->db->join('(' . $query_pos_sale_product . ') as qpsp', 'qpsp.psp_product = p.id', 'left');
		$this->db->join('(' . $query_pur_product . ') as qpp', 'qpp.pp_product = p.id', 'left');
		$this->db->join('(' . $query_pur_ret_product . ') as qpr', 'qpr.pr_product = p.id', 'left');
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
		$this->db->or_like('b.name',	$search);
		$this->db->or_like('tr.code',	$search);
		$this->db->or_like('tr.name',	$search);
		$this->db->or_like('tr.rate',	$search);
		$this->db->group_end();
		$query = $this->db->get('', $limit, $offset);
		//die($this->db->last_query());
		return $query;
	}
	function datatable_recordsFiltered($search)
	{
		$search = trim($search);
		$this->db->select('COUNT(*) as count');
		$this->db->from(TABLE_PRODUCT . ' as p');
		$this->db->join(TABLE_PRODUCT_TYPE . ' as t',		't.id=p.type',			'left');
		$this->db->join(TABLE_BARCODE_SYMBOLOGY . ' as bs',	'bs.id=p.symbology',	'left');
		$this->db->join(TABLE_CATEGORY . ' as c',		'c.id=p.category',		'left');
		$this->db->join(TABLE_BRAND . ' as b',		'b.id=p.brand',			'left');
		$this->db->join(TABLE_UNIT . ' as u',		'u.id=p.unit',			'left');
		$this->db->join(TABLE_TAX_RATE . ' as tr',	'tr.id=p.tax_rate',		'left');

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
	function set_deleted_at($where) // mark as deleted
	{
		$this->db->where($where);
		$this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
		$query = $this->db->update(TABLE_PRODUCT);
		return $query;
	}
	function multi_set_deleted_at($ids, $where) // mark as deleted
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
