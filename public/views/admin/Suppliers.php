<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div ng-controller="setSuppCtrl" id="setSuppCtrl" ng-init="init()">
	<div class="form-inline menubar">
		<div class="form-row title">
			<div class="col-auto">
				<span class="icon"><i class="fas fa-truck"></i></span>
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
						<th>Code</th>
						<th>Name</th>
						<th>Place</th>
						<th>Phone</th>
						<th>Email</th>
						<th>City</th>
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
					<h5 class="modal-title" ng-show="!delRows.length || delRows.length == 1">Confirm Delete Supplier ?</h5>
					<h5 class="modal-title" ng-show=" delRows.length > 1">Confirm Delete {{delRows.length}} Suppliers ?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<li ng-if="!delRows.length">{{delRows.code}} | {{delRows.name}} | {{delRows.place}}</li>
					<li ng-if="delRows.length == 1">{{delRows[0].code}} | {{delRows[0].name}} | {{delRows[0].place}}</li>
					<div class="accordion" id="accordionExample" ng-if="delRows.length > 1">
						<div class="card">
							<div class="card-header">
								<h2 class="mb-0">
									<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Click to view {{delRows.length}} selected suppliers</button>
								</h2>
							</div>
							<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
								<div class="card-body">
									<li ng-repeat="row in delRows">{{row.code}} | {{row.name}} | {{row.place}}</li>
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
	<!--- Tax Info Modal -->
	<div class="modal" id="supInfoModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h5 class="modal-title">Supplier - {{taxInfo.name}}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<div class="d-flex justify-content-center" ng-show="infoSpinner">
						<div class="spinner-grow text-info" role="status"> <span class="sr-only">Loading...</span> </div>
					</div>
					<div class="row" ng-hide="infoSpinner">
						<div class="col-lg-4 text-center"> <img ng-src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAH0lEQVR42mNk+P+/noGKgHHUwFEDRw0cNXDUwJFqIAAczzHZPJWe1QAAAABJRU5ErkJggg==" class="img-thumbnail" alt="..."> </div>
						<div class="col-lg-3">
							<div class="row"></div>
							<div class="row">
								<table class="table table-sm table-striped">
									<tbody>
										<tr>
											<th scope="row">Created</th>
											<td>{{catInfo['added_at']}}</td>
										</tr>
										<tr>
											<th scope="row">Updated</th>
											<td>{{catInfo['updated_at']}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-5">
							<table class="table table-sm table-striped">
								<tbody>
									<tr>
										<th scope="row">Products</th>
										<td>{{catInfo['p_count']}}</td>
									</tr>
									<tr>
										<th scope="row">Sub Categories</th>
										<td>{{catInfo['sc_count']}}</td>
									</tr>
									<tr>
										<th scope="row">Brands</th>
										<td>{{catInfo['b_count']}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-danger mr-auto" ng-click="confDelInfo()" ng-disabled="infoSpinner"><i class='fa fa-trash' aria-hidden='true'></i>&nbsp;&nbsp;DELETE</button>
					<a href="<?php echo base_url('admin/products/print/'); ?>{{row['id']}}" class="btn btn-primary" title="Print" ng-click="add_label(row['code'])"> <i class="fa fa-print"></i> <span>Print Labels</span> </a> <a href="<?php echo base_url('admin/products/edit/'); ?>{{row['id']}}" class="btn btn-warning" title="Edit"> <i class="fa fa-pencil-alt"></i> <span>EDIT</span> </a> <a href="<?php echo base_url('admin/products/copy/'); ?>{{row['id']}}" class="btn btn-secondary" title="Duplicate"> <i class="fa fa-copy"></i> <span>COPY</span> </a>
				</div>
			</div>
		</div>
	</div>
</div>