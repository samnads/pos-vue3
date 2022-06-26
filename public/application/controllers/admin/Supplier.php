<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Supplier extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/User_model');
	}
	public function index()
	{
		$data = array(
			'meta_title' => 'Supplier',
			'meta_description' => '',
			'css' => array(),
			'js' => array('setSuppCtrl', 'newSuppCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Suppliers" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/Suppliers');
		$this->load->view('admin/modal/modal_supplier'); // bs modal
		$this->load->view('admin/footer_admin');
	}
}
