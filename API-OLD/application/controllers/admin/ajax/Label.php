<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Label extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Label_Size_model');
	}
	public function index() // view products
	{
		header('Content-Type: application/json; charset=utf-8');
		$_POST = raw_input_to_post();
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				switch ($action = $this->input->get('action')) {
					case 'all':
						$result = $this->Label_Size_model->getAll();
						$result = array('success' => true, 'type' => 'success', 'data' => $result);
						die(json_encode($result));
						break;
					default:
						$error = array('success' => false, 'type' => 'danger', 'message' => 'No Action Found !');
						die(json_encode($error));
				}
			default:
				$error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method Found !');
				echo json_encode($error);
		}
	}
}
