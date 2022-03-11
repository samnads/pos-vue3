<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-info">
   <a class="navbar-brand" href="#">CyberLikes</a>
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
   </button>
   <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
         <li class="nav-item active bg-secondary">
            <a class="nav-link" href="#">Analytics <span class="sr-only">(current)</span></a>
         </li>
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               Products
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
               <a class="dropdown-item" href="<?php echo base_url('admin/products'); ?>">List All Products</a>
               <a class="dropdown-item" href="<?php echo base_url('admin/products/new'); ?>">New </a>
				<a class="dropdown-item" href="<?php echo base_url('admin/products/new'); ?>">Import via CSV </a>
               <a class="dropdown-item" href="<?php echo base_url('admin/products/print'); ?>">Print Labels</a>
            </div>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#">Sales</a>
         </li>
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               Categories
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
               <a class="dropdown-item" href="#">Action</a>
               <a class="dropdown-item" href="#">Another action</a>
               <a class="dropdown-item" href="#">Something else here</a>
            </div>
         </li>
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               Reports
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
               <a class="dropdown-item" href="#">Daily Sales</a>
               <a class="dropdown-item" href="#">Customers</a>
               <a class="dropdown-item" href="#">Purchase</a>
               <a class="dropdown-item" href="#">Brand</a>
            </div>
         </li>
         <li class="nav-item">
            <a class="nav-link bg-primary" href="#">POS</a>
         </li>
      </ul>
      <ul class="navbar-nav ml-md-auto">
         <li class="nav-item dropdown">
            <a class="nav-item nav-link dropdwn-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <img src="#">
            </a>
            <div class="dropdown-menu dropdown-menu-md-right" aria-labelledby="bd-versions">
               <a class="dropdown-item" href="/docs/4.5/">Profile</a>
               <a class="dropdown-item" href="/docs/4.5/">Settings</a>
               <div class="dropdown-divider"></div>
               <a class="dropdown-item" href="/docs/versions/">Log Out</a>
            </div>
         </li>
      </ul>
   </div>
</nav>
<div class="row mr-0">
   <div class="col-lg-2 bg-secondary">Sidebar Here</div>
   <div class="col-lg-8 col-md-8">
      <div class="row mt-3">
         <div class="col-lg-12 col-md-12">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">Products</li>
               </ol>
            </nav>
         </div>
      </div>
      <div class="alert alert-{{alert.type}} alert-dismissible fade show" role="alert" ng-repeat="alert in alerts">
         <span ng-bind-html="alert.message"></span>
         <button type="button" class="close" data-dismiss="alert" aria-label="Close" ng-click="rmAlert($index)"> <span aria-hidden="true">&times;</span>
         </button>
      </div>