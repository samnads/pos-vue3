<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Role_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_current_role()
    {
        $this->db->select('r.*');
        $this->db->from(TABLE_ROLE . ' r');
        $this->db->join(TABLE_USER . ' u', 'u.role=r.id', 'left');
        $this->db->where('u.id', $this->session->id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function get_all_roles($all = false)
    {
        $all ? $this->db->select('*') : $this->db->select('
		r.id as id,
        r.name as name,
		r.limit as limit');
        $this->db->from(TABLE_ROLE . ' r');
        $query = $this->db->get();
        return $query->result();
    }
    function datatable_recordsTotal()
    {
        $this->db->select('count(id)');
        $this->db->from(TABLE_ROLE);
        $this->db->where(array('deleted_at' => NULL)); // select only not deleted rows
        $query = $this->db->get();
        $cnt = $query->row_array();
        return $cnt['count(id)'];
    }
    function datatable_data($search, $offset, $limit, $order_by, $order, $columns = null)
    {
        $search = trim($search);

        $columns ? $this->db->select($columns) : $this->db->select(
            '

		r.id as id,
		r.name as name,
        r.description as description,

        r.editable as editable,
        r.updatable_rights as updatable_rights,
        r.deletable as deletable,
        r.deleted_at as deleted_at,
        r.limit as limit,

        
		COUNT(case when u.status = 3 then u.status end) as count_active,
		COUNT(case when u.status = 4 then u.status end) as count_inactive,
		COUNT(case when u.status = 5 then u.status end) as count_pending,
        COUNT(case when u.status = 15 then u.status end) as count_blocked,
        COUNT(u.id) as count_user,
        ' . $this->session->role . ' as self_role'
        );

        $this->db->join(TABLE_USER . ' u', 'u.role=r.id', 'left');
        $this->db->join(TABLE_STATUS . ' s', 's.id=u.status', 'left');

        $this->db->where(array('r.deleted_at' => NULL)); // select only not deleted rows

        $this->db->group_start();
        $this->db->or_like('r.name', $search);
        $this->db->or_like('r.description', $search);
        $this->db->group_end();

        $this->db->group_by('r.id');

        $order_by ? $this->db->order_by($order_by, $order) : $this->db->order_by('r.id', 'ASC');

        $query = $this->db->get(TABLE_ROLE . ' r', $limit, $offset);

        return $query->result();
    }
    function datatable_recordsFiltered($search)
    {
        $search = trim($search);

        $this->db->select('COUNT(*) as count');

        $this->db->where(array('r.deleted_at' => NULL)); // select only not deleted rows

        $this->db->from(TABLE_ROLE . ' r');

        $this->db->like('r.name', $search);

        $query = $this->db->get();
        $query    = $query->row();
        return $query->count;
    }
    function getRoleData($role_id, $columns = null)
    {

        $columns ? $this->db->select($columns) : $this->db->select('
		r.id as id,
		r.name as name,
        r.description as description,
		r.editable as editable,
        r.deletable as deletable,
		r.limit as limit,
        
		COUNT(r.id) as count_user,
		COUNT(case when u.status = "ACTIVE" then u.status end) as count_active,
		COUNT(case when u.status = "INACTIVE" then u.status end) as count_inactive,
		COUNT(case when u.status = "PENDING" then u.status end) as count_pending');

        $this->db->from(TABLE_ROLE . ' r');
        $this->db->join(TABLE_USER . ' u', 'u.role=r.id', 'left');

        $this->db->where('r.id', $role_id);
        $this->db->group_by('r.id');

        $query = $this->db->get();
        return  $query->row_array();
    }
    function getRoleRights($role_id)
    {

        $this->db->select('
				m.name as module,
				p.name as permission,
                p.id as permission_id,
				rp.allow as allow');

        $this->db->from(TABLE_ROLE_PERMISSION . ' rp');
        $this->db->join(TABLE_ROLE . ' r', 'rp.role_id=r.id', 'left');
        $this->db->join(TABLE_MODULE . ' m', 'rp.module_id=m.id', 'left');
        $this->db->join(TABLE_PERMISSION . ' p', 'rp.permission_id=p.id', 'left');

        $this->db->where('r.id', $role_id);

        $this->db->group_by('p.id');
        $this->db->group_by('m.id');

        $query = $this->db->get();
        $results =  $query->result_array();

        $result = [];
        foreach ($results as $res) {
            $result[$res['module']][$res['permission']] = (bool)$res['allow'];
        }
        return $result;
    }
    function insert_role($data)
    {
        $query = $this->db->insert(TABLE_ROLE, $data);
        return $query;
    }
    function set_deleted_at($id) // mark as deleted
    {
        $this->db->where(array('id' => $id, 'deletable' => NULL, 'deleted_at' => NULL));
        $this->db->set('deleted_at', 'NOW()', FALSE); // deleted rows have a timestamp
        $query = $this->db->update(TABLE_ROLE);
        return $query;
    }
}
