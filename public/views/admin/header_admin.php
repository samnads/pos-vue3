<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en" ng-app="cyberlikes" ng-controller="mainCtrl">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="framework" content="CodeIgniter <?php echo CI_VERSION; ?>">
	<!-- angular js files -->
	<script src="<?php echo base_url('assets/js/angular.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/angular-route.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/angular-cookies.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/angular-sanitize.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/angular-animate.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/angular-messages.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/ngStorage.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/ui-bootstrap-tpls-3.0.6.js'); ?>"></script>
	<!-- other js files -->
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/fontawesome/css/all.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/cyberlikes.css?v=' . time());; ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/DataTables/datatables.min.css'); ?>"><!-- DataTables CSS -->

	<link rel="stylesheet" href="">
	<!-- linked css per page -->
	<?php
	foreach ($css_links as $value) {
	?>
		<link rel="stylesheet" href="<?php echo $value; ?>">
	<?php
	}
	foreach ($css as $value) {
	?>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/' . $value . '.css?v=' . time()); ?>">
	<?php
	}
	?>

	<!-- CSS Per Page -->
	<title><?php echo $meta_title; ?></title>
	<!-- Inline JS Things -->
	<script type="text/javascript">
		var user = {};
		user.id = <?php echo $this->session->id; ?>;
		user.username = "<?php echo $this->session->username; ?>";
		user.first_name = "<?php echo $this->session->first_name; ?>";
		user.last_name = "<?php echo $this->session->last_name; ?>";
		user.avatar = "<?php echo $this->session->avatar; ?>";
		user.role_id = <?php echo $this->session->role_id; ?>;
	</script>
</head>

<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light fixed-top">
			<a class="navbar-brand" href="#"><i class="fab fa-bootstrap"></i>
				<span class="text-light">CyberLikes</span>
			</a>
			<!--<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#side-bar" aria-controls="side-bar" aria-expanded="false" aria-label="Toggle Side Navigation"> <i class="fas fa-align-left"></i> </button>-->
			<button type="button" class="navbar-toggler btn btn-primary" data-toggle="collapse" data-target="#top-bar" aria-controls="top-bar" aria-expanded="false" aria-label="Toggle Top Navigation"> <i class="fas fa-align-left"></i> </button>
			<div class="collapse navbar-collapse" id="top-bar">
				<ul class="navbar-nav ">
					<li class="nav-item active"> <a class="nav-link" href="<?php echo base_url('admin/dashboard'); ?>">Dashboard <span class="sr-only">(current)</span></a> </li>
					<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Products </a>
						<div class="dropdown-menu"> <a class="dropdown-item" href="<?php echo base_url('admin/product'); ?>">List All</a> <a class="dropdown-item" href="<?php echo base_url('admin/product/new'); ?>">Add New </a><a class="dropdown-item" href="<?php echo base_url('admin/stock_adjustment'); ?>">Adjustments </a><a class="dropdown-item" href="<?php echo base_url('admin/stock_adjustment/new'); ?>">Add Adjustment </a><a class="dropdown-item" href="<?php echo base_url('admin/products/import'); ?>">Import via CSV </a> <a class="dropdown-item" href="<?php echo base_url('admin/product/print'); ?>">Print Labels</a> </div>
					</li>
					<li class="nav-item"> <a class="nav-link" href="#">Sales</a> </li>
					<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Categories </a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="<?php echo base_url('admin/category'); ?>">View / Manage</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
					<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Contacts </a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="<?php echo base_url('admin/supplier'); ?>">Suppliers</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/customer'); ?>">Customers</a>
						</div>
					</li>
					<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> User Manage </a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="<?php echo base_url('admin/user'); ?>">Users</a>
							<a class="dropdown-item" href="<?php echo base_url('admin/user/new'); ?>">New User</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/role'); ?>">Roles</a>
							<a class="dropdown-item" href="<?php echo base_url('admin/role/new'); ?>">New Role</a>
						</div>
					</li>
					<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Settings </a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="<?php echo base_url('admin/taxes'); ?>">Tax Rates</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/brands'); ?>">Brands</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/units'); ?>">Units</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url('admin/warehouses'); ?>">Warehouses</a>
						</div>
					</li>
					<li class="nav-item"> <a class="nav-link" href="<?php echo base_url('admin/pos'); ?>">POS</a> </li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item active"> <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> </li>
					<li class="nav-item"> <a class="nav-link" href="#">Link</a> </li>
					<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Dropdown </a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"> <a class="dropdown-item" href="#">Action</a> <a class="dropdown-item" href="#">Another action</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
					<li class="nav-item dropdown"> <a class="nav-item nav-link dropdwn-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="<?php echo base_url('gd/20/20'); ?>"> </a>
						<div class="dropdown-menu dropdown-menu-md-right" aria-labelledby="bd-versions"> <a class="dropdown-item" href="/docs/4.5/"><i class="fas fa-user-cog"></i>&nbsp;&nbsp;Profile</a>
							<a class="dropdown-item" href="/docs/4.5/"><i class="fas fa-cog"></i>&nbsp;&nbsp;Settings</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#" ng-click="adminLO()"><i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Log Out</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<main role="main">
		<!-- breadcrumbs -->
		<?php if (isset($breadcrumbs)) : ?>
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-0">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb rounded-0 border-bottom">
						<?php if (isset($breadcrumbs)) : foreach ($breadcrumbs as $name => $link) : if ($link != null) : ?>
									<li class="breadcrumb-item"><a href="<?php echo base_url($link); ?>"><?php echo $name; ?></a> </li>
								<?php else : ?>
									<li class="breadcrumb-item active" aria-current="page"><?php echo $name; ?></li>
						<?php endif;
							endforeach;
						endif; ?>
					</ol>
				</nav>
			</div>
		<?php endif; ?>
		<div id="page-content" ng-cloak>
			<span ng-show="loading">Loading, please wait</span>
			<!-- /#top-menu-bar -->
			<div class="row m-0">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div uib-alert ng-repeat="alert in alerts" ng-class="'alert alert-' + (alert.type || 'warning')" close="closeAlert($index)" dismiss-on-timeout="{{alert.timeout == 0 ? null : alert.timeout || 5000}}">
						<span ng-bind-html="alert.message"></span>
					</div>
					<?php
					//$alert['login'] = array('type' => 'success', 'message' => 'test', 'timeout' => 5000);
					//$this->session->set_flashdata('alert', $alert);
					if (is_array($this->session->flashdata('alert'))) :
						foreach ($this->session->flashdata('alert') as $alert) {
					?>
							<div uib-alert class="alert alert-<?php echo isset($alert['type']) ? $alert['type'] : 'warning'; ?> alert-dismissible fade show" dismiss-on-timeout="5000">
								<?php echo $alert['message']; ?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<audio class="d-none" controls autopla>
								<source src="<?php echo base_url('assets/sounds/' . $alert['type'] . '.ogg'); ?>" type="audio/ogg">
								Your browser does not support the audio element.
							</audio>
					<?php
						}
					endif;
					?>