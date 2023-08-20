<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Product_stock_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	function new($product, $warehouse, $quantity)
	{
		$query = $this->db->insert(TABLE_PRODUCT_STOCK, array('product' => $product, 'warehouse' => $warehouse, 'quantity' => $quantity));
		return $query;
	}
}
