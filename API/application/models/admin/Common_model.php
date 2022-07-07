<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Common_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	function getGenders($columns = null)
	{
		$columns == null ? $this->db->select('
		g.id as id,
        g.name as name') : $this->db->select($columns);
		$this->db->from(TABLE_GENDER . ' g');
		$query = $this->db->get();
		return  $query->result_array();
	}
	function getRoles($columns = null)
	{
		$columns == null ? $this->db->select('
		r.id as id,
        r.name as name') : $this->db->select($columns);
		$this->db->from(TABLE_ROLE . ' r');
		$query = $this->db->get();
		return  $query->result_array();
	}
	function getStatuses($type, $columns = null)
	{
		$columns == null ? $this->db->select('
		s.id as id,
        s.name as name') : $this->db->select($columns);
		$this->db->from(TABLE_STATUS . ' s');
		$this->db->where(array($type => 1));
		$query = $this->db->get();
		return  $query->result_array();
	}
}
