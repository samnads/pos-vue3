<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Customer extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data = array(
			'meta_title' => 'Customers',
			'meta_description' => '',
			'css' => array(),
			'js' => array('setCustCtrl', 'newCustCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Customers" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/Customers');
		$this->load->view('admin/modal/modal_customer'); // bs modal
		$this->load->view('admin/footer_admin');
	}
}
