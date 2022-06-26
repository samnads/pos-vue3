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
    function recordsTotal()
    {
        $this->db->select('count(id)');
        $query = $this->db->get(TABLE_USER);
        $cnt = $query->row_array();
        return $cnt['count(id)'];
    }
    function get_all_users($columns = null, $search, $offset, $limit, $order_by, $order)
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
        u.place as place,
        u.address as address,
        u.status as status,
        u.deletable as deletable,
        u.updated_at as updated_at,
        
		r.id as role,
		r.name as role_name,
		r.limit as role_limit');

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

        $this->db->order_by($order_by, $order);
        $this->db->order_by('u.id', 'DESC');

        $query = $this->db->get('', $limit, $offset);

        return $query->result();
    }
    function get_all_users_recordsFiltered($search)
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
    function getUserData($id, $columns = null)
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

        $this->db->where('u.id', $id);

        $query = $this->db->get();
        return  $query->row();
    }
    function delete_where($where)
    {
        $this->db->where($where);
        $query = $this->db->delete(TABLE_USER);
        return $query;
    }
}
