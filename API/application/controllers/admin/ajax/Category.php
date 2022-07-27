<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Category extends CI_Controller
{
	public function index() // view products
	{
		header('Content-Type: application/json; charset=utf-8');
		$this->load->model('admin/Category_model');
		$this->load->model('admin/Product_model');
		$this->load->model('admin/Brand_model');
		$_POST = raw_input_to_post();
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET': // read
				switch ($action = $this->input->get('action')) {
					case 'getInfo':
						$results = array();
						$results['total_prods'] = $this->Product_model->get_total_products_where(array('p.category' => $this->input->post('id')));
						$results['total_sub_cats'] = $this->Category_model->get_total_subcats_where(array('sc.category' => $this->input->post('id')));
						$results['total_brands'] = $this->Product_model->get_total_brands_where(array('p.category' => $this->input->post('id'), 'p.brand IS NOT NULL'));

						$results['thumbnail'] = 'https://images-na.ssl-images-amazon.com/images/I/51p-op7Jq-L._SL1000_.jpg';
						$data = array('success' => true, 'type' => 'success', 'data' => $results);
						echo json_encode($data);
						break;
					case 'defcat':
						$result = array("id" => 113); // can change in user settings
						echo json_encode($result);
						break;
					case 'datatable':
						$data = array();
						$limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
						$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
						$order = $this->input->get('order')[0]['dir']; // order asc or desc
						$search = $this->input->get('search')['value']; // search query
						$offset = $this->input->get('start'); // start position
						$query = $this->Category_model->datatable_data($search, $offset, $limit, $order_by, $order);
						$data['data'] = $query->result();
						$data["draw"] = $this->input->get('draw'); // unique
						$data["recordsTotal"] = $this->Category_model->datatable_recordsTotal();
						$data["recordsFiltered"] = $this->Category_model->datatable_recordsFiltered($search);
						$data['success'] = true;
						//$data[ 'error' ] = '';
						echo json_encode($data);
						break;
					case 'test':
						$data = array();
						$limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
						$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
						$order = $this->input->get('order')[0]['dir']; // order asc or desc
						$search = $this->input->get('search')['value']; // search query
						$offset = $this->input->get('start'); // start position
						$query = $this->Category_model->testQuery($search, $offset, $limit, $order_by, $order);
						$data['data'] = $query->result();
						$data["draw"] = $this->input->get('draw'); // unique
						$data["recordsTotal"] = $this->Category_model->totalRows();
						$data["recordsFiltered"] = $this->Category_model->listCategories_FilteredCount($search);
						$data['success'] = true;
						//$data[ 'error' ] = '';
						echo json_encode($data);
						break;
					case 'subdatatable':
						$data = array();
						$limit = $this->input->get('length') <= 0 ? NULL : $this->input->get('length'); // limit
						$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data']; // order by column
						$order = $this->input->get('order')[0]['dir']; // order asc or desc
						$search = $this->input->get('search')['value']; // search query
						$offset = $this->input->get('start');
						$cid = $this->input->get('id'); // start position
						$query = $this->Category_model->listSubCategoriesWithCount($search, $cid, $offset, $limit, $order_by, $order);
						$data['data'] = $query->result();
						$data["draw"] = $this->input->get('draw'); // unique
						$data["recordsTotal"] = $this->Category_model->SubCategoriestotalRows($cid);
						$data["recordsFiltered"] = $this->Category_model->listSubCategories_FilteredCount($search, $cid);
						$data['success'] = true;
						//$data[ 'error' ] = '';
						echo json_encode($data);
						break;
					default:
						$error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Action !');
						echo json_encode($error);
				}
				break;
			case 'POST': // create
				$_POST = $this->input->post('data');
				$auto_id = $this->Category_model->get_AUTO_INCREMENT();
				if (!$auto_id) {
					$error = $this->db->error();
					die(json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured (AUTO_INCREMENT) !"))));
				}
				$data = array(
					'name'			=> trim(reduce_multiples($this->input->post('name'), " ")),
					'code'			=> trim(reduce_multiples($this->input->post('code') ?: sprintf("CAT%04s", $auto_id), " ")),
					'slug'			=> trim(reduce_multiples($this->input->post('slug') ?: NULL, " ")),
					'allow_sub'		=> $this->input->post('allow_sub') ? NULL : 0,
					'description'	=> trim(reduce_multiples($this->input->post('description') ?: NULL, " "))
				);
				//$data['error'] = "error";
				$table		= TABLE_CATEGORY;
				if ($this->input->post('category')) { // if sub category
					$data['parent'] = $this->input->post('category'); // parent category field name (if sub cat)
					$ruleName	= 'callback_sub_name_check[' . $this->input->post('category') . ']|callback_allow_sub_check[' . $this->input->post('category') . ']';
				} else { // new main category
					$ruleName	= 'callback_main_name_check[]';
				}
				//$data['name'] = null;
				$this->form_validation->set_data($data);
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'required|min_length[3]|max_length[50]|' . $ruleName . '|xss_clean|regex_match[/^[a-zA-Z0-9-& ]+$/]'
					),
					array(
						'field' => 'slug',
						'label' => 'Slug',
						'rules' => 'required|min_length[3]|max_length[50]|is_unique[' . $table . '.slug]|xss_clean|regex_match[/^[a-z0-9-]+$/]'
					),
					array(
						'field' => 'code',
						'label' => 'Code',
						'rules' => 'required|min_length[3]|max_length[10]|is_unique[' . $table . '.code]|xss_clean|regex_match[/^[a-zA-Z0-9]+$/]'
					),
					array(
						'field' => 'description',
						'label' => 'Description',
						'rules' => 'max_length[100]|is_unique[' . $table . '.description]xss_clean'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					if ($this->input->post('category')) { // if sub category
						$this->Category_model->insert_sub_category($data);
					} else { // new main category
						$this->Category_model->insert_main_category($data);
					}
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->db->insert_id(), 'message' => 'Successfully added new ' . ($this->input->post('category') ? 'sub' : '') . 'category <strong><em>' . $data['name'] . '</em></strong> !'));
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
					}
				}
				break;
			case 'PUT': // update
				$_POST = $this->input->post('data');
				$data = array(
					'name'			=> trim(reduce_multiples($this->input->post('name'), " ")),
					'code'			=> trim(reduce_multiples($this->input->post('code') ?: NULL, " ")),
					'slug'			=> trim(reduce_multiples($this->input->post('slug') ?: NULL, " ")),
					'allow_sub'		=> $this->input->post('allow_sub') ? NULL : 0,
					'description'	=> trim(reduce_multiples($this->input->post('description') ?: NULL, " "))
				);
				//$data['error'] = "error";
				$id = $this->input->post('db')['id'];
				$table		= TABLE_CATEGORY;
				if ($this->input->post('db')['parent'] != null) { // if sub category
					$ruleName	= 'callback_edit_sub_name_check[' . $id . ']';
					$ruleCode	= 'callback_edit_sub_code_check[' . $id . ']';
					$ruleSlug	= 'callback_edit_sub_slug_check[' . $id . ']';
				} else { // main category
					$ruleName	= 'callback_edit_name_check[' . $id . ']';
					$ruleCode	= 'callback_edit_code_check[' . $id . ']';
					$ruleSlug	= 'callback_edit_slug_check[' . $id . ']';
				}
				//$data['code'] = null;
				$this->form_validation->set_data($data);
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'required|min_length[3]|max_length[50]|' . $ruleName . '|xss_clean|trim|regex_match[/^[a-zA-Z0-9-& ]+$/]'
					),
					array(
						'field' => 'slug',
						'label' => 'Slug',
						'rules' => 'required|min_length[3]|max_length[50]|' . $ruleSlug . '|xss_clean|trim|regex_match[/^[a-z0-9-]+$/]'
					),
					array(
						'field' => 'code',
						'label' => 'Code',
						'rules' => 'required|min_length[3]|max_length[10]|' . $ruleCode . '|xss_clean|trim|regex_match[/^[a-zA-Z0-9]+$/]'
					),
					array(
						'field' => 'description',
						'label' => 'Description',
						'rules' => 'max_length[100]|xss_clean|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					if ($this->input->post('db')['parent'] != null) { // if sub category
						$this->Category_model->update_main_category($data, array('id' => $id, 'editable' => NULL, 'deleted_at' => NULL));
					} else { // main category
						$this->Category_model->update_sub_category($data, array('id' => $id, 'editable' => NULL, 'deleted_at' => NULL));
					}
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'message' => 'Successfully updated ' . ($this->input->post('db')['parent'] != null ? 'subcategory' : 'category') . ' <strong><em>' . $data['name'] . '</em></strong> !'));
					} else if ($this->db->affected_rows() == 0) {
						echo json_encode(array('success' => true, 'type' => 'info',  'message' => $this->lang->line('no_data_changed_after_query')));
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "An unexpected database error occurred !")));
					}
				}
				break;
			case 'DELETE': // delete
				$_POST = $this->input->post('data');
				$id = $this->input->post('id'); // unique db id
				if ($this->input->post('category')) { // sub category
					$query = $this->Category_model->deleteSubCat($id);
				} else { // parent category
					$query = $this->Category_model->deleteCat($id);
				}
				$error = $this->db->error();
				if ($error['code'] == 1451) {
					echo json_encode(array('success' => false, 'type' => 'danger', 'id' => $id, 'timeout' => 10000, 'message' => 'Delete all data associated with the ' . ($this->input->post('category') ? 'subcategory ' : 'category <strong><em>') . $this->input->post('name') . '</em></strong> then try again !'));
				} else if ($this->db->affected_rows() == 1) {
					echo json_encode(array('success' => true, 'type' => 'success', 'id' => $id, 'timeout' => 5000, 'message' => 'Successfully deleted ' . ($this->input->post('category') ? 'subcategory' : 'category') . ' <strong><em>' . $this->input->post('name') . '</em></strong> !'));
				} else if ($this->db->affected_rows() == 0) {
					echo json_encode(array('success' => true, 'type' => 'warning', 'id' => $id, 'timeout' => 5000, 'message' => 'No ' . ($this->input->post('category') ? 'subcategory' : 'category') . ' were deleted !'));
				} else {
					echo json_encode(array('success' => false, 'type' => 'danger', 'id' => $id, 'timeout' => 10000, 'message' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unexpected error occured !")));
				}
				break;
			default:
				$error = array('success' => false, 'type' => 'danger', 'error' => 'Unknown Request Method Found !');
				echo json_encode($error);
		}
	}
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	public function sub_name_check($name, $parent)
	{
		$this->db->select('id');
		$this->db->from(TABLE_CATEGORY);
		$this->db->where(array('parent' => $parent, 'name' => $name));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('sub_name_check', $this->lang->line('form_validation_is_unique') . ' [ same level ]');
			return FALSE;
		}
		return TRUE;
	}
	public function allow_sub_check($name, $parent)
	{
		$this->db->select('allow_sub');
		$this->db->from(TABLE_CATEGORY);
		$this->db->where(array('id' => $parent));
		$query = $this->db->get();
		$row	= $query->row_array();
		if ($query->num_rows() > 0 && $row['allow_sub'] === 0) {
			$this->form_validation->set_message('allow_sub_check', 'You can\'t create category under this level ! [ Level Locked ]');
			return FALSE;
		}
		return TRUE;
	}
	public function main_name_check($name)
	{
		$this->db->select('id');
		$this->db->from(TABLE_CATEGORY);
		$this->db->where(array('parent' => NULL, 'name' => $name));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('main_name_check', $this->lang->line('form_validation_is_unique') . ' [ top level ]');
			return FALSE;
		}
		return TRUE;
	}
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	public function edit_sub_name_check($name, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_CATEGORY);
		$this->db->where(array('name' => $name, 'parent' => $this->input->post('db')['parent'], 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_sub_name_check', $this->lang->line('form_validation_is_unique') . '[ same level ]');
			return FALSE;
		}
		return TRUE;
	}
	public function edit_sub_code_check($code, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_CATEGORY);
		$this->db->where(array('code' => $code, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_sub_code_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	public function edit_sub_slug_check($slug, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_CATEGORY);
		$this->db->where(array('slug' => $slug, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_sub_slug_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	public function edit_name_check($name, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_CATEGORY);
		$this->db->where(array('name' => $name, 'parent' => NULL, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_name_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	public function edit_code_check($code, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_CATEGORY);
		$this->db->where(array('code' => $code, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_code_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	public function edit_slug_check($slug, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_CATEGORY);
		$this->db->where(array('slug' => $slug, 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_slug_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
}
