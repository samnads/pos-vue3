<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends CI_Controller
{
	public function index()
	{
		$data = array(
			'meta_title' => 'Admin',
			'meta_description' => '',
			'css' => array(),
			'js' => array(),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/footer_admin');
	}
}
