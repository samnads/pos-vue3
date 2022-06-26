<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Product extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Product_model');
	}
	public function index() // view products
	{
		$data = array(
			'meta_title' => 'Products',
			'meta_description' => '',

			'css' => array(),
			'js' => array('listProdCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Products" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/products_view');
		$this->load->view('admin/footer_admin');
	}
	public function new() // add new product
	{
		$data = array(
			'meta_title' => 'New Product',
			'meta_description' => '',
			'css' => array('bootstrap-datepicker.min', 'bootstrap-select.min'),
			'js' => array('bootstrap-datepicker.min', 'bootstrap-select.min', 'newProdCtrl', 'newCatCtrl', 'newUnitCtrl', 'newBrandCtrl', 'newTaxCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Products" => "/admin/products",
			"New Product" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/products_new_view');
		$this->load->view('admin/modal/new_cat'); // bs modal
		$this->load->view('admin/modal/modal_tax'); // bs modal
		$this->load->view('admin/modal/modal_brand'); // brand modal
		$this->load->view('admin/modal/modal_unit'); // bs modal
		$this->load->view('admin/footer_admin');
	}
	public function edit() // edit product
	{
		$id = $this->uri->segment(4);
		$query = $this->Product_model->getProduct($id);
		$row = $query->row();
		$data = array(
			'meta_title' => 'Edit Product - ' . $row->name,
			'meta_description' => '',
			'css' => array('bootstrap-datepicker.min'),
			'js' => array('bootstrap-datepicker.min', 'newProdCtrl', 'newCatCtrl', 'newUnitCtrl', 'newBrandCtrl', 'newTaxCtrl'),

			'css_links' => array(),
			'js_links' => array(),

			'row' => $row
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Products" => "/admin/products",
			"Edit Product" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/products_new_view');
		$this->load->view('admin/modal/new_cat'); // bs modal
		$this->load->view('admin/modal/modal_tax'); // bs modal
		$this->load->view('admin/modal/modal_brand'); // brand modal
		$this->load->view('admin/modal/modal_unit'); // bs modal
		$this->load->view('admin/footer_admin');
	}
	public function copy() // copy product
	{
		$id = $this->uri->segment(4);
		$query = $this->Product_model->getProduct($id);
		$row = $query->row();
		$data = array(
			'meta_title' => 'Copy Product - ' . $row->name,
			'meta_description' => '',
			'css' => array('bootstrap-datepicker.min'),
			'js' => array('bootstrap-datepicker.min', 'newProdCtrl', 'newCatCtrl', 'newUnitCtrl', 'newBrandCtrl', 'newTaxCtrl'),


			'css_links' => array(),
			'js_links' => array(),

			'row' => $row
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Products" => "/admin/products",
			"Copy Product" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/products_new_view');
		$this->load->view('admin/modal/new_cat'); // bs modal
		$this->load->view('admin/modal/modal_tax'); // bs modal
		$this->load->view('admin/modal/modal_brand'); // brand modal
		$this->load->view('admin/modal/modal_unit'); // bs modal
		$this->load->view('admin/footer_admin');
	}
	public function print() // print labels
	{
		$data = array(
			'meta_title' => 'Print Barcode',
			'meta_description' => '',
			'css' => array('bootstrap-select.min'),
			'js' => array('bootstrap-select.min', 'printBarcodeCtrl'),

			'css_links' => array('https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/af-2.3.5/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/cr-1.5.3/date-1.0.3/fc-3.3.2/fh-3.1.8/kt-2.6.1/r-2.2.7/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.3/datatables.min.css'),
			'js_links' => array('https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/af-2.3.5/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/cr-1.5.3/date-1.0.3/fc-3.3.2/fh-3.1.8/kt-2.6.1/r-2.2.7/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.3/datatables.min.js')
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Products" => "/admin/products",
			"Print" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/print_barcode');
		$this->load->view('admin/footer_admin');
	}
}
