<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Barcode_Symbology_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function options($all = false)
    {
        $all ? $this->db->select('*') : $this->db->select('
		bs.id as id,
        bs.code as code');
        $this->db->from(TABLE_BARCODE_SYMBOLOGY . ' bs');
        $query = $this->db->get();
        return $query->result_array();
    }
    function getDefault()
    {
    }
}
