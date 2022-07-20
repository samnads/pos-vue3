<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Stock_adjustment_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	function create($data)
	{
		$query = $this->db->insert(TABLE_STOCK_ADJUSTMENT, $data);
		return $query;
	}
	function create_with_new_product($data)
	{
		$this->db->set('date', 'CURRENT_DATE()', FALSE);
		$this->db->set('time', 'CURRENT_TIME()', FALSE);
		$query = $this->db->insert(TABLE_STOCK_ADJUSTMENT, $data);
		return $query;
	}
	function update($data, $id)
	{
		$this->db->where('id', $id);
		$query = $this->db->update(TABLE_STOCK_ADJUSTMENT, $data);
		return $query;
	}
	function update_updated_at($id)
	{
		$this->db->where('id', $id);
		$this->db->set('updated_at', 'NOW()', FALSE);
		$query = $this->db->update(TABLE_STOCK_ADJUSTMENT);
		return $query;
	}
	function totalRows()
	{
		$this->db->select('count(id)');
		$query = $this->db->get(TABLE_STOCK_ADJUSTMENT);
		$cnt = $query->row_array();
		return $cnt['count(id)'];
	}
	function listStockAdjustments($search, $offset, $limit, $order_by, $order)
	{
		$search = trim($search);
		$this->db->select('
		sa.id		as id,
		w.id		as warehouse,
		w.name		as warehouse_name,
		CONCAT(u.first_name," ",u.last_name)	as added_by,
		sa.date as date,
		sa.time as time,
		sa.reference_no	as reference_no,
		sa.note	as note,
		COUNT(DISTINCT sap.product)	as	total_products,
		COALESCE(sa.updated_at , sa.added_at) as	updated_at');

		$this->db->from(TABLE_STOCK_ADJUSTMENT . '			sa');
		$this->db->join(TABLE_WAREHOUSE . '		w',	'w.id=sa.warehouse',	'left');
		$this->db->join(TABLE_USER . '	u',	'u.id=sa.added_by',	'left');
		$this->db->join(TABLE_STOCK_ADJUSTMENT_PRODUCT . '			sap',	'sap.stock_adjustment=sa.id',	'left');
		$this->db->join(TABLE_PRODUCT . '			p',	'p.id=sap.product',	'left');
		$this->db->order_by($order_by, $order);

		$this->db->or_like('sa.date',	$search);
		$this->db->or_like('sa.reference_no',	$search);
		$this->db->or_like('sa.note',	$search);

		$this->db->or_like('w.name',	$search);

		$this->db->or_like('u.first_name',	$search);
		$this->db->or_like('u.last_name',	$search);

		$this->db->or_like('p.name',	$search);

		$this->db->group_by('sa.id');

		$query = $this->db->get('', $limit, $offset);
		//die($this->db->last_query());
		//die(print_r($query));
		return $query;
	}
	function listStockAdjustments_FilteredCount($search)
	{
		$search = trim($search);
		$this->db->select('COUNT(DISTINCT(sa.id)) as count');
		$this->db->from(TABLE_STOCK_ADJUSTMENT . '			sa');
		$this->db->join(TABLE_WAREHOUSE . '		w',	'w.id=sa.warehouse',	'left');
		$this->db->join(TABLE_USER . '	u',	'u.id=sa.added_by',	'left');
		$this->db->join(TABLE_STOCK_ADJUSTMENT_PRODUCT . '			sap',	'sap.stock_adjustment=sa.id',	'left');
		$this->db->join(TABLE_PRODUCT . '			p',	'p.id=sap.product',	'left');

		$this->db->or_like('sa.date',	$search);
		$this->db->or_like('sa.reference_no',	$search);
		$this->db->or_like('sa.note',	$search);

		$this->db->or_like('w.name',	$search);

		$this->db->or_like('u.first_name',	$search);
		$this->db->or_like('u.last_name',	$search);

		$this->db->or_like('p.name',	$search);

		$query = $this->db->get();
		//die($this->db->last_query());
		$query	= $query->row();
		return $query->count;
	}
	function getInfo($id)
	{
		$id = trim($id);
		$this->db->select('
		p.id		as id,
		p.name	as name,
		p.code	as code,
		sap.note as note,
		cast(sap.quantity AS decimal(10,2)) AS quantity');

		$this->db->from(TABLE_STOCK_ADJUSTMENT_PRODUCT . '			sap');
		$this->db->join(TABLE_STOCK_ADJUSTMENT . '			sa',	'sa.id=sap.stock_adjustment',	'left');
		$this->db->join(TABLE_WAREHOUSE . '		w',	'w.id=sa.warehouse',	'left');
		$this->db->join(TABLE_USER . '	u',	'u.id=sa.added_by',	'left');
		$this->db->join(TABLE_PRODUCT . '			p',	'p.id=sap.product',	'left');

		$this->db->where('sap.stock_adjustment',	$id);
		$query = $this->db->get();
		return $query;
	}
}
