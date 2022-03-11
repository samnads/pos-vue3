<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Role extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Role_model');
	}
	public function index()
	{
		$data = array(
			'meta_title' => 'Roles',
			'meta_description' => '',
			'css' => array(),
			'js' => array('rolesCtrl'),

			'css_links' => array(),
			'js_links' => array()
		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Roles" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/Roles_table_view');
		$this->load->view('admin/footer_admin');
	}
	public function new()
	{
		$data = array(
			'meta_title' => 'Create New Role',
			'meta_description' => '',
			'css' => array(),
			'js' => array('roleNewCtrl'),

			'css_links' => array(),
			'js_links' => array()

		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Roles" => "/admin/roles",
			"New" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/Roles_new_view');
		$this->load->view('admin/footer_admin');
	}
	public function edit()
	{
		$row = $this->Role_model->getRoleData($this->uri->segment(4));
		if ($row && $row['editable'] == 0) { // comment for debug
			// strictly not editable role
			/*
			$alert['denied'] = array('success' => false, 'type' => 'danger', 'message' => 'Access Denied !');
			$this->session->set_flashdata('alert', $alert);
			redirect(base_url('admin/role'));
			die();
			*/
		} else if (!$row) {
			$alert['nodata'] = array('success' => false, 'type' => 'danger', 'message' => 'No data found for the specified role ! ');
			$this->session->set_flashdata('alert', $alert);
			redirect(base_url('admin/role'));
		}
		$rights = $this->Role_model->getRoleRights($this->uri->segment(4));
		$data = array(
			'meta_title' => 'Edit Role - ' . $row['name'],
			'meta_description' => '',
			'css' => array(),
			'js' => array('roleNewCtrl'),

			'css_links' => array(),
			'js_links' => array(),
			'row' => $row,
			'rights' => $rights

		);
		$data['breadcrumbs'] = array(
			"Home" => "/admin",
			"Roles" => "/admin/role",
			"Edit" => null
		);
		$this->load->view('admin/header_admin', $data);
		$this->load->view('admin/Roles_new_view');
		$this->load->view('admin/footer_admin');
	}
}
