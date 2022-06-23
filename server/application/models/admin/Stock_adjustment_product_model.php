<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Stock_adjustment_product_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	function create($data)
	{
		$query = $this->db->insert(TABLE_STOCK_ADJUSTMENT_PRODUCT, $data);
		return $query;
	}
	function update($data, $id)
	{
		$this->db->where('id', $id);
		$query = $this->db->update(TABLE_STOCK_ADJUSTMENT_PRODUCT, $data);
		return $query;
	}
	function delete($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->delete(TABLE_STOCK_ADJUSTMENT_PRODUCT);
		return $query;
	}
	function get_products_where($where)
	{
		$query = $this->db->get_where(TABLE_STOCK_ADJUSTMENT_PRODUCT, $where);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return null;
		}
	}
}
