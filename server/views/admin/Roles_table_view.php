<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div ng-controller="rolesCtrl" id="rolesCtrl" ng-init="init()">
	<div class="form-inline menubar">
		<div class="form-row title">
			<div class="col-auto">
				<span class="icon"><i class="fas fa-user-check"></i></span>
				<span class=""><?php end($breadcrumbs);
								echo key($breadcrumbs); ?></span>
			</div>
		</div>
		<div class="form-row ml-auto">
			<div class="col-auto">
				<div class="input-group flex-nowrap">
					<select data-toggle="tooltip" title="Page Length" class="custom-select" name="length_change" ng-model="lenOption" id="length_change" ng-init="lenOption = (lengths | filter:{id:SET.defLength}:true)[0]" ng-options="option.name for option in lengths track by option.id">
					</select>
					<div class="input-group-append">
						<span class="input-group-text"><i class="fas fa-table"></i></span>
					</div>
				</div>
			</div>
			<span id="buttons"></span>
			<div class="col-auto">
				<input class="form-control" data-toggle="tooltip" title="Search" id="searchRole" type="search" placeholder="Search...">
			</div>
		</div>
	</div>
	<div class="menubar_content">
		<!--- List Taxes Table -->
		<div class="table-responsive-lg table-responsive-xl table-responsive-md table-responsive-sm">
			<table class="table table-sm table-bordered table-hover w-auto" id="roleTable">
				<thead>
					<tr>
						<th></th>
						<th>Role</th>
						<th>Description</th>
						<th>Active Users</th>
						<th>Inactive Users</th>
						<th>Pending Users</th>
						<th>Total Users</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<!--- Delete Confirm Modal -->
	<div class="modal" id="delModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-danger">
					<h5 class="modal-title">Confirm Delete Role ?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body text-center">
					<span>{{delRow.name}}</span>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-danger mr-auto" ng-click="delete()"><i class='fa fa-trash align-left' aria-hidden='true'></i>&nbsp;&nbsp;YES</button>
					<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class='fa fa-stop' aria-hidden='true'></i>&nbsp;&nbsp;NO</button>
				</div>
			</div>
		</div>
	</div>
	<!--- cust Info Modal -->
	<div class="modal info" id="supInfoModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Role - {{roleInfo.name}}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<div class="d-flex justify-content-center" ng-show="infoSpinner">
						<div class="spinner-grow text-info" role="status"> <span class="sr-only">Loading...</span> </div>
					</div>
					<div class="table-responsive">
						<table class="table table-bordered table-sm text-center">
							<tbody>
								<tr>
									<th scope="row">Active</th>
									<th scope="row">Inactive</th>
									<th scope="row">Pending</th>
								</tr>
								<tr>
									<td>{{roleInfo.active_count}}</td>
									<td>{{roleInfo.inactive_count}}</td>
									<td>{{roleInfo.pending_count}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light mr-auto" ng-click="confDel({data:roleInfo})">
						<i class='fa fa-trash fa-fw' aria-hidden='true'></i>&nbsp;DELETE
					</button>
					<a href="#" class="btn btn-light" title="Print" ng-click="add_label(row['code'])">
						<i class="fa fa-print fa-fw"></i>&nbsp;Print
					</a>
					<a href="#" class="btn btn-light" title="Edit" ng-click="showNewUserForm({data:roleInfo,edit:true})">
						<i class="fa fa-edit fa-fw"></i>&nbsp;EDIT
					</a>
				</div>
			</div>
		</div>
	</div>
</div>