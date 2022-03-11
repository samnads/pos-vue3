<?php defined('BASEPATH') or exit('No direct script access allowed');

$search = 's';
$this->db->select('
rp.role_id,
rp.module_id,
rp.permission_id,

r.name as role_name,
m.name as module_name,
p.name as permission_name,
rp.allow,');

//COUNT(r.id) as user_count
$this->db->from('role_permission' . ' rp');
$this->db->join('role' . ' r', 'rp.role_id=r.id', 'left');
$this->db->join('module' . ' m', 'rp.module_id=m.id', 'left');
$this->db->join('permission' . ' p', 'rp.permission_id=p.id', 'left');

$this->db->where('r.id', 1);
$this->db->where('m.name', 'product');
$this->db->where('p.name', "DELETE");
//$this->db->group_by('p.id');
//$this->db->group_by('m.id');
//$this->db->group_by('p.id');
//$this->db->order_by('r.id', 'ASC');

//$this->db->join(TABLE_UNIT_BULK . '		ub',	'ub.unit=u.id', 'left');
//$this->db->order_by($order_by, $order);
//$this->db->limit($offset, $limit);
//$query = $this->db->get();

//$this->db->where(array('p.category' => 1,'p.BRAND IS NOT NULL'));
//$this->db->group_by('u.id', FALSE);

//$this->db->group_by('u.id');
//$this->db->group_by('ub.id');

//$this->db->join(TABLE_UNIT_BULK . '		ub',	'ub.unit=u.id', 'left');
//$this->db->order_by($order_by, $order);
//$this->db->limit($offset, $limit);
//$query = $this->db->get();

//$this->db->where(array('p.category' => 1,'p.BRAND IS NOT NULL'));
//$this->db->group_by('u.id', FALSE);

//$this->db->group_by('u.id');
//$this->db->group_by('ub.id');
$results = $this->db->get()->result_array();


echo $this->db->last_query() . '<br><br><br><br>';

?>
<table class="table table-sm">
	<caption><?php echo count((array)$results); ?> : Results</caption>
	<thead class="thead-dark">
		<tr>
			<?php foreach ($results[0] as $key => $value) { ?>
				<th scope="col"><?php echo $key; ?></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($results as $key => $value) { ?>
			<tr>

				<?php foreach ($results[$key] as $key1 => $value1) { ?>
					<th scope="col"><?php echo $value1; ?></th>
				<?php } ?>
			</tr>

		<?php } ?>
	</tbody>
</table>

<!--

COUNT(p.code)												as total_p,
		COUNT(sc.category)											as total_sc
,