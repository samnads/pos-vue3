<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Stock_adjustment extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Stock_model');
	}
	public function index()
	{
		$data = array(
			'meta_title' => 'Stock Adjustments',
			'meta_description' => '',

			'css' => array(),
			'js' => array('listStockAdjCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Stock Adjustments" => "/admin/stock_adjustment",
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/stock_adj_view');
		$this->load->view('admin/footer_admin');
	}
	public function new()
	{
		$data = array(
			'meta_title' => 'New Stock Adjustment',
			'meta_description' => '',

			'css' => array('bootstrap-datepicker.min', 'bootstrap-select.min', 'bootstrap-select.min', 'select2.min', 'select2-bootstrap4.min'),
			'js' => array('bootstrap-datepicker.min', 'bootstrap-select.min', 'bootstrap-select.min', 'select2.min', 'stockAdjNewCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Stock Adjustments" => "/admin/stock_adjustment",
			"New Stock Adjustment" => null,
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/Stock_adj_new_view');
		$this->load->view('admin/footer_admin');
	}
}
