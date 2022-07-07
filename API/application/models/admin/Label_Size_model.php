<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Label_Size_model extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function getAll()
    {
        $query = $this->db->get(TABLE_LABEL_SIZE);
        return $query->result();
    }
}
?>