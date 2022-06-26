<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div ng-controller="setUnitCtrl" id="setUnitCtrl" ng-init="init()">
	<div class="form-inline menubar">
		<div class="form-row title">
			<div class="col-auto">
				<span class="icon"><i class="fas fa-balance-scale-right"></i></span>
				<span class=""><?php end($breadcrumbs);
								echo key($breadcrumbs); ?></span>
			</div>
		</div>
		<div class="form-row ml-auto">
			<div class="col-auto">
				<div class="input-group flex-nowrap">
					<select class="custom-select" name="length_change" ng-model="lenOption" id="length_change" ng-init="lenOption = (lengths | filter:{id:SET.defLength}:true)[0]" ng-options="option.name for option in lengths track by option.id">
					</select>
					<div class="input-group-append">
						<span class="input-group-text"><i class="fas fa-table"></i></span>
					</div>
				</div>
			</div>
			<span id="buttons"></span>
			<div class="col-auto">
				<input class="form-control" id="search" type="search" placeholder="Search...">
			</div>
		</div>
	</div>
	<div class="menubar_content">
		<!--- List units Table -->
		<div class="table-responsive-lg table-responsive-xl table-responsive-md table-responsive-sm">
			<table class="table table-sm table-bordered table-hover text-center w-auto" id="table">
				<thead>
					<tr>
						<th>id</th>
						<th>Name</th>
						<th>Code</th>
						<th>Description</th>
						<th>Sub Unit</i></th>
						<th><i class="fas fa-bars"></i></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<div class="form-inline menubar mt-3">
		<div class=" form-row title">
			<div class="col-auto">
				<span class="mr-2 pl-2 pr-2 border-right pt-0"><i class="fas fa-balance-scale-left"></i></span>
				<span class="">Subunits</span>
			</div>
		</div>
		<div class="form-row ml-auto">
			<div class="col-auto">
				<div class="input-group flex-nowrap">
					<select class="custom-select" name="length_change" ng-model="lenOption_s" id="length_change" ng-init="lenOption_s = (lengths | filter:{id:SET.defLength_s}:true)[0]" ng-options="option.name for option in lengths track by option.id">
					</select>
					<div class="input-group-append">
						<span class="input-group-text"><i class="fas fa-table"></i></span>
					</div>
				</div>
			</div>
			<span id="sub_buttons"></span>
			<div class="col-auto">
				<input class="form-control" id="sub_search" type="search" placeholder="Search...">
			</div>
		</div>
	</div>
	<div class="menubar_content">
		<!--- List sub unit Table -->
		<div class="table-responsive-lg table-responsive-xl table-responsive-md table-responsive-sm">
			<table class="table table-sm table-bordered table-hover text-center w-auto" id="sub_table">
				<thead>
					<tr class="text-center">
						<th>id</th>
						<th>Name</th>
						<th>Code</th>
						<th>Base Unit</th>
						<th>Description</th>
						<th><i class="fas fa-bars"></i></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<!--- delete unit confirm modal -->
	<div class="modal" id="singDel" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-danger text-white">
					<h5 class="modal-title">Confirm Delete {{newUnit.delete.sub ? 'Subunit' : 'Unit'}} ?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body text-center">{{newUnit.delete.name}}</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-danger mr-auto" ng-click="delete()"><i class='fa fa-trash align-left' aria-hidden='true'></i>&nbsp;&nbsp;YES</button>
					<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class='fa fa-stop' aria-hidden='true'></i>&nbsp;&nbsp;NO</button>
				</div>
			</div>
		</div>
	</div>
</div>