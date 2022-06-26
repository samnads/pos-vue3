<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div ng-controller="setUserCtrl" id="setUserCtrl" ng-init="init()">
	<div class="form-inline menubar">
		<div class="form-row title">
			<div class="col-auto">
				<span class="icon"><i class="fas fa-user"></i></span>
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
				<input class="form-control" data-toggle="tooltip" title="Search" id="searchUser" type="search" placeholder="Search...">
			</div>
		</div>
	</div>
	<div class="menubar_content">
		<!--- List Taxes Table -->
		<div class="table-responsive-lg table-responsive-xl table-responsive-md table-responsive-sm">
			<table class="table table-sm table-bordered table-hover w-auto" id="supTable">
				<thead>
					<tr>
						<th></th>
						<th><i class="fas fa-id-card-alt"></i></th>
						<th>Username</th>
						<th>Role</th>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Place</th>
						<th>Status</th>
						<th>Updated @</th>
						<th class="text-center"><i class="far fa-caret-square-down"></i></th>
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
					<h5 class="modal-title">Confirm Delete User ?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<span class="badge badge-secondary">{{delRow.username}}</span> {{delRow.first_name}} | {{delRow.email}}
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
					<h5 class="modal-title">{{custInfo.name}} | {{custInfo.group_name}}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<div class="d-flex justify-content-center" ng-show="infoSpinner">
						<div class="spinner-grow text-info" role="status"> <span class="sr-only">Loading...</span> </div>
					</div>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-sm">
							<tbody>
								<tr>
									<th scope="row">Name</th>
									<td>{{custInfo.name}}</td>
									<th scope="row">Place</th>
									<td>{{custInfo.place}}</td>
									<th scope="row">Group</th>
									<td>{{custInfo.group_name}}</td>
								</tr>
								<tr>
									<th scope="row">Phone</th>
									<td>{{custInfo.phone}}</td>
									<th scope="row">Email</th>
									<td>{{custInfo.email}}</td>
									<th scope="row">Address</th>
									<td>{{custInfo.address}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light mr-auto" ng-click="confDel({data:custInfo})">
						<i class='fa fa-trash fa-fw' aria-hidden='true'></i>&nbsp;DELETE
					</button>
					<a href="#" class="btn btn-light" title="Print" ng-click="add_label(row['code'])">
						<i class="fa fa-print fa-fw"></i>&nbsp;Print
					</a>
					<a href="#" class="btn btn-light" title="Edit" ng-click="showNewUserForm({data:custInfo,edit:true})">
						<i class="fa fa-edit fa-fw"></i>&nbsp;EDIT
					</a>
				</div>
			</div>
		</div>
	</div>
</div>