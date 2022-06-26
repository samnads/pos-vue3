<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Brands extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data = array(
			'meta_title' => 'Brand',
			'meta_description' => '',
			'css' => array(),
			'js' => array('setBrandCtrl', 'newBrandCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Settings" => "/admin/settings",
			"Brands" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/brands_view');
		$this->load->view('admin/modal/modal_brand'); // bs modal
		$this->load->view('admin/footer_admin');
	}
}
