<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	public function index()
	{

		$this->load->library('pagination');
		$data = array(
			'meta_title' => 'Test Query',
			'meta_description' => '',
			
			'css' => array('bootstrap-select.min'),
			'js' => array('bootstrap-select.min','posCtrl'),
			
			'css_links' => array(),
			'js_links' => array()
		);

		$this->load->view('admin/header_admin',$data);
		$this->load->view('admin/test');
		$this->load->view('admin/footer_admin');


		
	}
}

/*

sc.id														as sc_id,
		sc.category													as sc_category,
		sc.code														as sc_code,
		sc.name														as sc_name,
		sc.slug														as sc_slug,

		COUNT(c.id)													as total_cats,
		*/