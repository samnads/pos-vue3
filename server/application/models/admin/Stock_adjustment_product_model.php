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
}
