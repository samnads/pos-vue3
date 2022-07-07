<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Cutomer_group_model extends CI_Model
{
	function getall($columns)
	{
		$this->db->select($columns);
		$this->db->from(TABLE_CUSTOMER_GROUP . ' cg');
		$query = $this->db->get();
		return $query;
	}
}
