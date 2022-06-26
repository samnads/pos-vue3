<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{
	public $login_redirect = FALSE;
	public function index()
	{
		if ($this->session->login) {
			$this->session->mark_as_flash('redirect');
			redirect($this->session->flashdata('redirect') ? $this->session->flashdata('redirect') : "admin", 'location', 302);
		} else {
			$data = array(
				'meta_title' => 'Admin Login',
				'meta_description' => 'Login from here',
				'css' => array('cyberlikes'),
				'js' => array('adminLoginCtrl'),

				'css_links' => array(),
				'js_links' => array('https://www.google.com/recaptcha/api.js'),

				'admin' => array()
			);
			$this->load->view('admin/admin_login_header', $data);
			$this->load->view('admin/admin_login');
			$this->load->view('admin/admin_login_footer');
		}
	}
}
