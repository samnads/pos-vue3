<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
	public function index()
	{
		$data = array(
			'meta_title' => 'Dashboard',
			'meta_description' => '',
			'css' => array(),
			'js' => array(),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Dashboard" => null
		);
		$this->load->view('admin/header_admin',$data);
		$this->load->view('admin/admin_dashboard');
		$this->load->view('admin/footer_admin');
	}
}