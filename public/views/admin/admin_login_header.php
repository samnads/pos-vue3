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
</head>

<body>