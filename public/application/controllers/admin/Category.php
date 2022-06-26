<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Category extends CI_Controller
{
	public function index()
	{
		$data = array(
			'meta_title' => 'Categories',
			'meta_description' => '',
			'css' => array(),
			'js' => array('listCatCtrl', 'newCatCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Categories" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/index_categories');
		$this->load->view('admin/modal/new_cat'); // bs modal
		$this->load->view('admin/footer_admin');
	}
}
