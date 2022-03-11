<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div ng-controller="setCustCtrl" id="setCustCtrl" ng-init="init()">
	<div class="form-inline menubar">
		<div class="form-row title">
			<div class="col-auto">
				<span class="icon"><i class="fas fa-male"></i><i class="fas fa-female"></i></span>
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
		<!--- List Taxes Table -->
		<div class="table-responsive-lg table-responsive-xl table-responsive-md table-responsive-sm">
			<table class="table table-sm table-bordered table-hover w-auto" id="supTable">
				<thead>
					<tr class="text-center">
						<th ng-click="checkAll()"><input type="checkbox" ng-model="checkall"></th>
						<th></th>
						<th>Name</th>
						<th>Group</th>
						<th>Place</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Address</th>
						<th>Updated @</th>
						<th><i class="fas fa-bars"></i></th>
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
					<h5 class="modal-title" ng-show="!delRows.length || delRows.length == 1">Confirm Delete Customer ?</h5>
					<h5 class="modal-title" ng-show=" delRows.length > 1">Confirm Delete {{delRows.length}} Customers ?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<li ng-if="!delRows.length">{{delRows.name}} | {{delRows.place}} | {{delRows.group_name}}</li>
					<li ng-if="delRows.length == 1">{{delRows[0].name}} | {{delRows[0].place}} | {{delRows[0].group_name}}</li>
					<div class="accordion" id="accordionExample" ng-if="delRows.length > 1">
						<div class="card">
							<div class="card-header">
								<h2 class="mb-0">
									<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Click to view {{delRows.length}} selected customers</button>
								</h2>
							</div>
							<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
								<div class="card-body">
									<li ng-repeat="row in delRows">{{row.name}} | {{row.place}} | {{row.group_name}}</li>
								</div>
							</div>
						</div>
					</div>
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
					<a href="#" class="btn btn-light" title="Edit" ng-click="showNewCustForm({data:custInfo,edit:true})">
						<i class="fa fa-edit fa-fw"></i>&nbsp;EDIT
					</a>
				</div>
			</div>
		</div>
	</div>
</div>