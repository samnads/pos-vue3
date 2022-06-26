<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div ng-controller="setWarehouseCtrl" id="setWarehouseCtrl" ng-init="initialise()">
	<div class="form-inline menubar">
		<div class="form-row title">
			<div class="col-auto">
				<span class="icon"><i class="fas fa-warehouse"></i></span>
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
			<div class="col-auto pl-0">
				<button type="button" class="btn btn-light" ng-click="tableWarehouses({search:searchText})"><i class="fas fa-sync"></i></button>
			</div>
			<div class="col-auto pl-0">
				<button type="button" class="btn btn-light" ng-click="newWarehouse()"><i class="fas fa-plus"></i>&nbsp;New</button>
			</div>
			<div class="col-auto pl-0">
				<input class="form-control" id="search" type="search" placeholder="Search..." ng-model="searchText" ng-change="tableWarehouses({search:searchText})" ng-model-options='{ debounce: 300 }'>
			</div>
		</div>
	</div>
	<div class="menubar_content">
		<div class="d-flex justify-content-center" ng-if="!db.warehouses">
			<div class="spinner-border text-info" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
		<div class="alert alert-warning text-center" role="alert" ng-show="db.warehouses.length == 0">
			<span ng-show="searchText && db.warehouses.length == 0" ng-bind-html="'No warehouse were found for the query <strong><em>'+searchText+'</em></strong> !'"></span>
			<span ng-show="!searchText && db.warehouses.length == 0">No warehouse were found !</span>
		</div>
		<div class="row">
			<div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 col-12 pb-2" ng-repeat="warehouse in db.warehouses track by $index">
				<div class="card mb-2">
					<img src="https://d1nhio0ox7pgb.cloudfront.net/_img/g_collection_png/standard/512x512/warehouse.png" class="card-img-top pointer" ng-click="info($index,warehouse.id)">
					<div class=" card-body">
						<h5 class="card-title">{{warehouse.name}}</h5>
					</div>
					<div class="card-footer">
						<div class="row">
							<span class="mr-auto">
								<span class="btn"><i class='fa fa-info-circle text-dark' aria-hidden='true'></i></span>
							</span>
							<div class="dropdown">
								<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Action
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
									<button class="dropdown-item" type="button" ng-click="info($index,warehouse.id)"><i class='fa fa-info-circle' aria-hidden='true'></i>Details</button>
									<button class="dropdown-item" type="button" ng-click="newWarehouse({data:warehouse,edit:true})"><i class='fa fa-edit' aria-hidden='true'></i>Edit</button>
									<button class="dropdown-item" type="button" ng-click="confDel($index,warehouse)"><i class='fa fa-trash' aria-hidden='true'></i>Delete</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--- Delete Individual Brand Confirm Modal -->
	<div class="modal" id="singDel" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-danger text-white">
					<h5 class="modal-title">Confirm Delete Warehouse ?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body text-center">{{delete.warehouse['name']}}</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-danger mr-auto" ng-click="delete(delete.warehouse)"><i class='fa fa-trash align-left' aria-hidden='true'></i>&nbsp;&nbsp;YES</button>
					<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class='fa fa-stop' aria-hidden='true'></i>&nbsp;&nbsp;NO</button>
				</div>
			</div>
		</div>
	</div>
	<!--- Brand Info Modal -->
	<div class="modal" id="brandInfo" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-secondary text-white">
					<h5 class="modal-title">{{brand.name}}</h5>
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
					<a href="<?php echo base_url('admin/products/print/'); ?>{{row['id']}}" class="btn btn-primary" title="Print" ng-click="add_label(row['code'])"> <i class="fa fa-print"></i> <span>Print Labels</span> </a>
					<a href="#" class="btn btn-warning" title="Edit" ng-click="newBrand({data:brand,edit:true})"> <i class="fa fa-pencil-alt"></i> <span>EDIT</span> </a>
				</div>
			</div>
		</div>
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
<!--- Inline Styles -->
<style type="text/css">
	#catTable tbody tr {
		cursor: pointer;
	}

	#catInfo .img-thumbnail {
		width: 200px;
	}

	.table-responsive .thumbnail {
		width: 25px;
		height: 25px;
	}

	.table td.fit,
	.table th.fit {
		white-space: nowrap;
		width: 1%;
	}
</style>