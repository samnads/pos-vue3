<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function getRow($where)
    {
        $this->db->select('*');
        $this->db->from(TABLE_USER);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();
    }
    function updateLogin($id)
    {
        $this->db->set('login_at', 'NOW()', FALSE);
        $this->db->set('client_ip', $this->input->ip_address());
        $this->db->where('id', $id);
        $query = $this->db->update(TABLE_USER);
        return $query;
    }
    function updateLogout($id)
    {
        $this->db->set('logout_at', 'NOW()', FALSE);
        $this->db->set('client_ip', $this->input->ip_address());
        $this->db->where('id', $id);
        $query = $this->db->update(TABLE_USER);
        return $query;
    }
    function datatable_recordsTotal()
    {
        $this->db->select('count(id)');
        $query = $this->db->get(TABLE_USER);
        $cnt = $query->row_array();
        return $cnt['count(id)'];
    }
    function datatable_data($columns = null, $search, $offset, $limit, $order_by, $order)
    {
        $search = trim($search);

        $columns ? $this->db->select($columns) : $this->db->select('
		u.id as id,
        u.username as username,
        u.first_name as first_name,
        u.last_name as last_name,
        u.company_name as company_name,
		u.email as email,
        u.phone as phone,
        u.avatar as avatar,
        u.gender as gender,
        u.date_of_birth as date_of_birth,
        u.country as country,
        u.city as city,
        u.place as place,
        u.address as address,
        u.pin_code as pin_code,
        u.status as status,
        u.editable as editable,
        u.deletable as deletable,
        u.description as description,
        u.updated_at as updated_at,
        u.deleted_at as deleted_at,

        s.id as status,
        s.name as status_name,
        s.css_class as css_class,
        
		r.id as role,
		r.name as role_name,
		r.limit as role_limit,

        
        ' . $this->session->id . ' as self_id');

        $this->db->from(TABLE_USER . ' u');
        $this->db->join(TABLE_ROLE . ' r', 'r.id=u.role', 'left');
        $this->db->join(TABLE_STATUS . ' s', 's.id=u.status', 'left');

        $this->db->where(array('u.deleted_at' => NULL)); // select only not deleted rows
        $this->db->group_start();
        $this->db->or_like('u.first_name', $search);
        $this->db->or_like('u.last_name', $search);
        $this->db->or_like('u.username', $search);
        $this->db->or_like('u.company_name', $search);
        $this->db->or_like('u.email', $search);
        $this->db->or_like('u.phone', $search);
        $this->db->or_like('u.place', $search);
        $this->db->or_like('u.address', $search);
        $this->db->or_like('s.name', $search);
        $this->db->group_end();

        $this->db->order_by($order_by, $order);
        $this->db->order_by('u.id', 'DESC');

        $query = $this->db->get('', $limit, $offset);

        return $query->result();
    }
    function datatable_recordsFiltered($search)
    {
        $search = trim($search);

        $this->db->select('COUNT(*) as count');

        $this->db->from(TABLE_USER . ' u');
        $this->db->join(TABLE_ROLE . ' r', 'r.id=u.role', 'left');

        $this->db->or_like('u.first_name', $search);
        $this->db->or_like('u.last_name', $search);
        $this->db->or_like('u.username', $search);
        $this->db->or_like('u.company_name', $search);
        $this->db->or_like('u.email', $search);
        $this->db->or_like('u.phone', $search);
        $this->db->or_like('u.place', $search);
        $this->db->or_like('u.address', $search);
        $this->db->or_like('u.status', $search);

        $query = $this->db->get();
        $query    = $query->row();
        return $query->count;
    }
    function getUserData($where, $columns = null)
    {
        $columns ? $this->db->select($columns) : $this->db->select('
		u.id as id,
        u.username as username,
        u.first_name as first_name,
        u.last_name as last_name,
        u.company_name as company_name,
        DATE_FORMAT(u.date_of_birth,"%d/%m/%Y") as date_of_birth,
		u.email as email,
        u.phone as phone,
        u.avatar as avatar,
        u.gender as gender,
        u.place as place,
        u.address as address,
        u.status as status,
        u.added_at as added_at,
        u.updated_at as updated_at,
        
		r.id as role,
		r.name as role_name,
		r.limit as role_limit');

        $this->db->from(TABLE_USER . ' u');
        $this->db->join(TABLE_ROLE . ' r', 'r.id=u.role', 'left');

        $this->db->where($where);

        $query = $this->db->get();
        return  $query->row();
    }
    function getUser($where, $columns = null)
    {
        $columns ? $this->db->select($columns) : $this->db->select('
		u.id as id,
        u.username as username,
        u.first_name as first_name,
        u.last_name as last_name,
        u.company_name as company_name,
        DATE_FORMAT(u.date_of_birth,"%d/%m/%Y") as date_of_birth,
		u.email as email,
        u.phone as phone,
        u.avatar as avatar,
        u.gender as gender,
        u.place as place,
        u.address as address,
        u.status as status,
        u.added_at as added_at,
        u.updated_at as updated_at,
        u.editable as editable,
        u.deletable as deletable,

		r.id as role,
		r.name as role_name,
		r.limit as role_limit');

        $this->db->from(TABLE_USER . ' u');
        $this->db->join(TABLE_ROLE . ' r', 'r.id=u.role', 'left');

        $this->db->where($where);

        $query = $this->db->get();
        return  $query->row_array();
    }
    function get_AUTO_INCREMENT()
    {
        $this->db->select('AUTO_INCREMENT');
        $this->db->from('INFORMATION_SCHEMA.TABLES');
        $this->db->where(array('TABLE_NAME' => TABLE_USER, 'TABLE_SCHEMA' => $this->db->database));
        $query = $this->db->get();
        $cnt = $query->row_array();
        return $cnt['AUTO_INCREMENT'];
    }
    function set_deleted_at($where) // mark as deleted
    {
        $this->db->where($where);
        $this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
        $query = $this->db->update(TABLE_USER);
        return $query;
    }
    function insert_user($data)
    {
        $query = $this->db->insert(TABLE_USER, $data);
        return $query;
    }
    function update_user($data, $where)
    {
        $query = $this->db->update(TABLE_USER, $data, $where);
        return $query;
    }
}
