<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Taxes extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data = array(
			'meta_title' => 'Tax',
			'meta_description' => '',
			'css' => array(),
			'js' => array('setTaxCtrl', 'newTaxCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Settings" => "/admin/settings",
			"Tax Rates" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/taxes_view');
		$this->load->view('admin/modal/modal_tax'); // bs modal
		$this->load->view('admin/footer_admin');
	}
}
