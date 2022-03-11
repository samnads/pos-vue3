<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pos extends CI_Controller
{
	public function index()
	{
		$data = array(
			'meta_title' => 'POS',
			'meta_description' => '',
			'css' => array('bootstrap-select.min', 'select2.min', 'select2-bootstrap4.min'),
			'js' => array('bootstrap-select.min', 'select2.min', 'posCtrl', 'newCustCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbsX'] = array(
			"Home" => 'admin',
			"POS" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/pos_admin', $data);
		$this->load->view('admin/modal/modal_customer'); // bs modal
		$this->load->view('admin/footer_admin');
	}
}
