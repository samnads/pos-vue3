<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Validate_model extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_categories()
    {
        $query = $this->db->get('category');
        return $query->result();
    }
    function get_category_by_column($cnmae,$value)
    {
        $query = $this->db->get_where('category', array($cnmae => $value));
        return $query;
    }
    function get_sub_categories($catid)
    {
        $query = $this->db->get_where('sub_category', array('category_id' => $catid));
        return $query->result();
    }
}
?>