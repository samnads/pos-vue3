<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Cutomer_group_model extends CI_Model
{
	function dropdown_customer_group($columns = false)
	{
		$columns ? $this->db->select('*') : $this->db->select('
		cg.id as id,
        cg.name as name,
		cg.percentage as percentage');
		$this->db->from(TABLE_CUSTOMER_GROUP . ' cg');
		$query = $this->db->get();
		return $query->result_array();
	}
}
