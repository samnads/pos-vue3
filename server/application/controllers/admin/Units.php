<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Units extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Unit_model');
	}
	public function index()
	{
		$data = array(
			'meta_title' => 'Units',
			'meta_description' => '',
			'css' => array(),
			'js' => array('setUnitCtrl', 'newUnitCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Settings" => "/admin/settings",
			"Units" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/units_view');
		$this->load->view('admin/modal/modal_unit'); // bs modal
		$this->load->view('admin/footer_admin');
	}
}
