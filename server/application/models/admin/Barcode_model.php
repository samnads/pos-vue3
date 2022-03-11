<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Barcode_model extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_symbols()
    {
        $query = $this->db->get(TABLE_BARCODE_SYMBOLOGY);
        return $query->result();
    }
}
?>