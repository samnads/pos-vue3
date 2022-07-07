<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Stock_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	function create($data)
	{
		$data['date'] = date('Y-m-d H:i:s');
		$query = $this->db->insert(TABLE_STOCK_ADJUSTMENT, $data);
		return $query;
	}
}
