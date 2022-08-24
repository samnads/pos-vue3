<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchase_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	function datatable_data($search, $offset, $limit, $order_by, $order)
	{
		$search = trim($search);
		$this->db->select(
			'
		p.id		as id,
		p.return_id	as symbology,
		p.warehouse		as code,
		p.status		as name,
		p.created_by		as slug,
		p.updated_by	as thumbnail,
		p.supplier	as weight,
		p.date	as weight,
		p.discount	as weight,
		p.shipping_charge	as weight,
		p.packing_charge	as weight,
		p.round_off	as weight,
		p.payment_note	as weight,
		p.note	as note,
		p.created_at	as created_at,
		p.updated_at	as updated_at,
		p.deleted_at	as deleted_at,
		
		cast(p.mrp AS decimal(10,2)) AS mrp,
		cast(p.cost AS decimal(10,2)) AS cost,
		cast(p.price AS decimal(10,2)) AS price,
		cast(p.markup AS decimal(10,2)) AS markup,
		cast(p.auto_discount AS decimal(10,2)) AS auto_discount,
		p.tax_method as tax_method,
		p.alert 	as alert,
		p.alert_quantity 	as alert_quantity,
		p.mfg_date 	as mfg_date,
		p.exp_date 	as exp_date,
		p.pos_sale 	as pos_sale,
		p.pos_custom_discount 	as pos_custom_discount,
		p.pos_custom_tax 	as pos_custom_tax,
		p.pos_sale_note 	as pos_sale_note,
		p.pos_data_field_1 	as pos_data_field_1,
		p.pos_data_field_2 	as pos_data_field_2,
		p.pos_data_field_3 	as pos_data_field_3,
		p.pos_data_field_4 	as pos_data_field_4,
		p.pos_data_field_5 	as pos_data_field_5,
		p.pos_data_field_6 	as pos_data_field_6,
		p.editable			as editable,
		p.deletable			as deletable,
		p.deleted_at		as deleted_at,
		
		t.id 		as type,
		t.name 		as type_name,
		
		bs.code 	as symbology_code,
		
		c.id 		as category,
		c.name 		as category_name,
		
		b.id 		as brand,
		b.code 		as brand_code,
		b.name 		as brand_name,

		u.id 		as unit,
		u.code 		as unit_code,
		u.name 		as unit_name,

		p.p_unit 	as p_unit,
		p.s_unit 	as s_unit,

		tr.id		as tax_rate,
		tr.code		as tax_code,
		tr.name		as tax_name,
		IFNULL(qsap.total_sap_quantity, 0)+IFNULL(qpsp.total_psp_quantity, 0) as quantity'
		);
		$this->db->from(TABLE_PURCHASE . ' as p');

		$this->db->order_by($order_by, $order);
		//$this->db->group_by('p.id');
		$this->db->where(array('p.deleted_at' => NULL)); // select only not deleted rows
		$this->db->group_start();
		$this->db->or_like('p.date',			$search);
		$this->db->or_like('p.discount',		$search);
		$this->db->or_like('p.shipping_charge',	$search);
		$this->db->or_like('p.packing_charge',	$search);
		$this->db->or_like('p.round_off',		$search);
		$this->db->or_like('p.payment_note',	$search);
		$this->db->or_like('p.note',			$search);
		$this->db->or_like('p.created_at',		$search);
		$this->db->or_like('p.updated_at',		$search);
		$this->db->group_end();
		$query = $this->db->get('', $limit, $offset);
		//die($this->db->last_query());
		return $query;
	}
	
}
