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
				$data = array(
					'name'			=> $this->input->post('name'),
					'code'			=> $this->input->post('code'),
					'slug'			=> $this->input->post('slug'),
					'description'	=> $this->input->post('description')
				);
				//$data['error'] = "error";
				if ($this->input->post('category')) { // if sub category
					$data['category'] = $this->input->post('category'); // parent category field name (if sub cat)
					$table		= TABLE_SUB_CATEGORY;
					$ruleName	= 'callback_sub_name_check[' . $data['category'] . ']';
					$ruleCode	= 'callback_sub_code_check[' . $data['category'] . ']';
				} else { // main category
					$table		= TABLE_CATEGORY;
					$ruleName	= 'is_unique[' . $table . '.name]';
					$ruleCode	= 'is_unique[' . $table . '.code]';
				}
				//$data['name'] = null;
				$this->form_validation->set_data($data);
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Category Name',
						'rules' => 'required|min_length[3]|max_length[50]|' . $ruleName . '|xss_clean|trim|regex_match[/^[a-zA-Z0-9-& ]+$/]'
					),
					array(
						'field' => 'slug',
						'label' => 'Category Slug',
						'rules' => 'required|min_length[3]|max_length[50]|is_unique[' . $table . '.slug]|xss_clean|trim|regex_match[/^[a-z0-9-]+$/]'
					),
					array(
						'field' => 'code',
						'label' => 'Category Code',
						'rules' => 'required|min_length[1]|max_length[5]|' . $ruleCode . '|xss_clean|trim|regex_match[/^[a-zA-Z0-9]+$/]'
					),
					array(
						'field' => 'description',
						'label' => 'Category Description',
						'rules' => 'max_length[100]|is_unique[' . $table . '.description]xss_clean|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					$this->db->insert($table, $data);
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->db->insert_id(), 'message' => 'Successfully added new ' . (isset($data['category']) ? 'sub' : '') . 'category <strong><em>' . $data['name'] . '</em></strong> !'));
					} else {
						$error = $this->db->error();
						echo json_encode(array('success' => false, 'type' => 'danger', 'error' => '<strong>Database error , </strong>' . ($error['message'] ? $error['message'] : "Unknown error")));
					}
				}
				break;
			case 'PUT': // update
				$_POST = $this->input->post('data');
				$data = array(
					'name'			=> $this->input->post('name'),
					'code'			=> $this->input->post('code'),
					'slug'			=> $this->input->post('slug'),
					'description'	=> $this->input->post('description') ?: NULL,
					'image'			=> $this->input->post('image') ?: NULL,
				);
				//$data['error'] = "error";
				$id = $this->input->post('db')['id'];
				if (isset($this->input->post('db')['category'])) { // if sub category
					$table		= TABLE_SUB_CATEGORY;
					$ruleName	= 'callback_edit_sub_name_check[' . $id . ']';
					$ruleCode	= 'callback_edit_sub_code_check[' . $id . ']';
					$ruleSlug	= 'callback_edit_sub_slug_check[' . $id . ']';
				} else { // main category
					$table		= TABLE_CATEGORY;
					$ruleName	= 'callback_edit_name_check[' . $id . ']';
					$ruleCode	= 'callback_edit_code_check[' . $id . ']';
					$ruleSlug	= 'callback_edit_slug_check[' . $id . ']';
				}
				//$data['code'] = null;
				$this->form_validation->set_data($data);
				$config = array(
					array(
						'field' => 'name',
						'label' => 'Category Name',
						'rules' => 'required|min_length[3]|max_length[50]|' . $ruleName . '|xss_clean|trim|regex_match[/^[a-zA-Z0-9-& ]+$/]'
					),
					array(
						'field' => 'slug',
						'label' => 'Category Slug',
						'rules' => 'required|min_length[3]|max_length[50]|' . $ruleSlug . '|xss_clean|trim|regex_match[/^[a-z0-9-]+$/]'
					),
					array(
						'field' => 'code',
						'label' => 'Category Code',
						'rules' => 'required|min_length[1]|max_length[5]|' . $ruleCode . '|xss_clean|trim|regex_match[/^[a-zA-Z0-9]+$/]'
					),
					array(
						'field' => 'description',
						'label' => 'Category Description',
						'rules' => 'max_length[100]|xss_clean|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE) {
					echo json_encode(array('success' => false, 'errors' => $this->form_validation->error_array()));
				} else {
					if (isset($this->input->post('db')['category'])) { // if sub category
						$this->db->update(TABLE_SUB_CATEGORY, $data, array('id' => $this->input->post('db')['id']));
					} else { // main category
						$this->db->update(TABLE_CATEGORY, $data, array('id' => $this->input->post('db')['id']));
					}
					if ($this->db->affected_rows() == 1) {
						echo json_encode(array('success' => true, 'type' => 'success', 'id' => $this->input->post('db')['id'], 'message' => 'Successfully updated ' . (isset($this->input->post('db')['category']) ? 'subcategory' : 'category') . ' <strong><em>' . $data['name'] . '</em></strong> !'));
					} else if ($this->db->affected_rows() == 0) {
						echo json_encode(array('success' => true, 'type' => 'warning', 'id' => $this->input->post('db')['id'], 'message' => $this->lang->line('no_data_changed_after_query')));
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
	public function sub_name_check($name, $category)
	{
		$this->db->select('id');
		$this->db->from(TABLE_SUB_CATEGORY);
		$this->db->where(array('category' => $category, 'name' => $name));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('sub_name_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	public function sub_code_check($code, $category)
	{
		$this->db->select('id');
		$this->db->from(TABLE_SUB_CATEGORY);
		$this->db->where(array('category' => $category, 'code' => $code));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('sub_code_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	public function edit_sub_name_check($name, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_SUB_CATEGORY);
		$this->db->where(array('name' => $name, 'category' => $this->input->post('db')['category'], 'id !=' => $id));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('edit_sub_name_check', $this->lang->line('form_validation_is_unique'));
			return FALSE;
		}
		return TRUE;
	}
	public function edit_sub_code_check($code, $id)
	{
		$this->db->select('id');
		$this->db->from(TABLE_SUB_CATEGORY);
		$this->db->where(array('code' => $code, 'category' => $this->input->post('db')['category'], 'id !=' => $id));
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
		$this->db->from(TABLE_SUB_CATEGORY);
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
		$this->db->where(array('name' => $name, 'id !=' => $id));
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
