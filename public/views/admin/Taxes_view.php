<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div ng-controller="setTaxCtrl" id="setTaxCtrl" ng-init="init()">
	<div class="form-inline menubar">
		<div class="form-row title">
			<div class="col-auto">
				<span class="icon"><i class="fas fa-percent"></i></span>
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
						<span class="input-group-text"><i class="fas fa-table text-black-50"></i></span>
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
			<table class="table table-sm table-bordered table-hover w-auto" id="taxTable">
				<thead>
					<tr class="text-center">
						<th ng-click="bulkCheckTaxes()"><input type="checkbox" ng-model="checkalltaxes"></th>
						<th>Name</th>
						<th>Code</th>
						<th>Tax Rate</th>
						<th>Type</th>
						<th>Description</th>
						<th>Updated @</th>
						<th><i class="fas fa-bars"></i></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<!--- Delete Multiple Tax Confirm Modal -->
	<div class="modal" id="bulkDel" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-danger text-white">
					<h5 class="modal-title">Confirm Delete {{taxRows.length == 1 ? '' : taxRows.length}} {{taxRows.length == 1 ? 'tax' : 'taxes'}} ?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body text-center">
					<span ng-if="taxRows.length == 1">{{taxRows[0].name}} | {{taxRows[0].rate | number : 2}}{{taxRows[0].type == 'P' ? ' %' : ' (Fixed)'}}</span>
					<div class="accordion" id="accordionExample" ng-if="taxRows.length > 1">
						<div class="card">
							<div class="card-header">
								<h2 class="mb-0">
									<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Click to view {{rows.length}} selected taxes</button>
								</h2>
							</div>
							<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
								<div class="card-body">
									<p ng-repeat="row in taxRows">{{row.name}} | {{row.rate | number : 2}}{{row.type == 'P' ? ' %' : ' (Fixed)'}}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-danger mr-auto" ng-click="delete(true)"><i class='fa fa-trash align-left' aria-hidden='true'></i>&nbsp;&nbsp;YES</button>
					<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class='fa fa-stop' aria-hidden='true'></i>&nbsp;&nbsp;NO</button>
				</div>
			</div>
		</div>
	</div>
	<!--- Delete Individual Tax Confirm Modal -->
	<div class="modal" id="singDel" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-danger text-white">
					<h5 class="modal-title">Confirm Delete Tax ?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body text-center">{{taxRow['name']}} | {{taxRow['rate'] | number : 2}}{{taxRow['type'] == 'P' ? ' %' : ' (Fixed)'}}</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-danger mr-auto" ng-click="delete(false)"><i class='fa fa-trash align-left' aria-hidden='true'></i>&nbsp;&nbsp;YES</button>
					<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class='fa fa-stop' aria-hidden='true'></i>&nbsp;&nbsp;NO</button>
				</div>
			</div>
		</div>
	</div>
	<!--- Tax Info Modal -->
	<div class="modal" id="taxInfoModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-secondary text-white">
					<h5 class="modal-title">Tax - {{taxInfo.name}}</h5>
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