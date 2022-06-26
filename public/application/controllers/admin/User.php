<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/User_model');
	}
	public function index()
	{
		check_perm_redirect("GET");
		$data = array(
			'meta_title' => 'Users',
			'meta_description' => '',
			'css' => array(),
			'js' => array('setUserCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Users" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/Users_view');
		$this->load->view('admin/footer_admin');
	}
	public function new()
	{
		check_perm_redirect("POST");
		$data = array(
			'meta_title' => 'New User',
			'meta_description' => '',
			'css' => array('bootstrap-datepicker.min'),
			'js' => array('bootstrap-datepicker.min', 'newUserCtrl'),

			'css_links' => array(),
			'js_links' => array()

		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Users" => "/admin/users",
			"New User" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/Users_new_view');
		$this->load->view('admin/footer_admin');
	}
	public function edit()
	{
		check_perm_redirect("PUT");
		$row = $this->User_model->getUserData($this->uri->segment(4));
		if (!$row) {
			$alert['nodata'] = array('success' => false, 'type' => 'danger', 'message' => 'No data found for the specified user ! ');
			$this->session->set_flashdata('alert', $alert);
			redirect(base_url('admin'));
		}
		$data = array(
			'meta_title' => 'Update User - ' . $row->username,
			'meta_description' => '',
			'css' => array('bootstrap-datepicker.min'),
			'js' => array('bootstrap-datepicker.min', 'newUserCtrl'),

			'css_links' => array(),
			'js_links' => array(),

			'row' => $row

		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Users" => "/admin/users",
			"Update User [ " . $row->username . " ]" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/Users_new_view');
		$this->load->view('admin/footer_admin');
	}
}
