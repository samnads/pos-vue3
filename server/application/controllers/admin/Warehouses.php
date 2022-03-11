<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Warehouses extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Warehouse_model');
	}
	public function index()
	{
		$data = array(
			'meta_title' => 'Warehouse',
			'meta_description' => '',
			'css' => array(),
			'js' => array('setWarehouseCtrl', 'newWarehouseCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Settings" => "/admin/settings",
			"Warehouses" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/warehouses_view');
		$this->load->view('admin/modal/modal_warehouse'); // bs modal
		$this->load->view('admin/footer_admin');
	}
}
