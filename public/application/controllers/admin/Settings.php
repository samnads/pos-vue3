<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Settings extends CI_Controller
{
	public function index()
	{
		$data = array(
			'meta_title' => 'Tax',
			'meta_description' => '',
			'css' => array(),
			'js' => array('listCatCtrl', 'newCatCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Tax" => null
		);
		$this->load->view('admin/header_admin', $data);
		echo 'Settings';
		$this->load->view('admin/footer_admin');
	}
}
