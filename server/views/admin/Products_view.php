<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div ng-controller="listProdCtrl" id="listProdCtrl" ng-init="init()">
	<div class="form-inline menubar">
		<div class="form-row title">
			<div class="col-auto">
				<span class="icon"><i class="fas fa-shopping-cart"></i></span>
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
		<!--- List Products Table -->
		<div class="table-responsive-xl">
			<table class="table table-sm table-bordered table-striped table-hover w-auto" id="productsTable">
				<thead>
					<tr class="text-center">
						<th ng-click="bulkCheck()"><input type="checkbox" ng-model="checkall"></th>
						<th><i class="fas fa-image"></i></th>
						<th>ID</th>
						<th>Code</th>
						<th>Name</th>
						<th>Brand</th>
						<th>Category</th>
						<th>MRP</th>
						<th>Stock</th>
						<th>Unit</th>
						<th>Cost</th>
						<th>Price</th>
						<th><i class="fas fa-bars"></i></th>
					</tr>
				</thead>
			</table>
		</div>
		<!--- Delete Multiple Product Confirm Modal -->
		<div class="modal" id="bulkDel" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header bg-danger text-white">
						<h5 class="modal-title">Confirm Delete {{rows.length == 1 ? '' : rows.length}} Product{{rows.length == 1 ? '' : 's'}} ?</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					</div>
					<div class="modal-body"> <span ng-if="rows.length == 1">{{rows[0].code}} | {{rows[0].name}}</span>
						<div class="accordion" id="accordionExample" ng-if="rows.length != 1">
							<div class="card">
								<div class="card-header">
									<h2 class="mb-0">
										<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Click to view {{rows.length}} selected products</button>
									</h2>
								</div>
								<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
									<div class="card-body">
										<p ng-repeat="row in rows">{{row.code}} | {{row.name}}</p>
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
		<!--- Delete Individual Product Confirm Modal -->
		<div class="modal" id="singDel" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header bg-danger text-white">
						<h5 class="modal-title">Confirm Delete Product ?</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					</div>
					<div class="modal-body">{{row['code']}} | {{row['name']}} </div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-danger mr-auto" ng-click="delete(false)"><i class='fa fa-trash align-left' aria-hidden='true'></i>&nbsp;&nbsp;YES</button>
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class='fa fa-stop' aria-hidden='true'></i>&nbsp;&nbsp;NO</button>
					</div>
				</div>
			</div>
		</div>
		<!--- Prtoduct Info Modal -->
		<div class="modal" id="prodInfo" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-secondary text-white">
						<h5 class="modal-title">{{row['name']}} | {{row['code']}}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					</div>
					<div class="modal-body">
						<div class="d-flex justify-content-center" ng-show="infoSpinner">
							<div class="spinner-grow text-info" role="status"> <span class="sr-only">Loading...</span> </div>
						</div>
						<div class="row" ng-hide="infoSpinner">
							<div class="col-lg-4 text-center"> <img ng-src="{{product['thumbnail']}}" class="img-thumbnail" alt="..."> </div>
							<div class="col-lg-3">
								<div class="row"></div>
								<div class="row">
									<table class="table table-sm table-striped">
										<tbody>
											<tr>
												<th scope="row">MRP</th>
												<td>{{product['mrp']}}</td>
											</tr>
											<tr>
												<th scope="row">Cost</th>
												<td>{{product['cost']}}</td>
											</tr>
											<tr>
												<th scope="row">Price</th>
												<td>{{product['price']}}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-lg-5">
								<table class="table table-sm table-striped">
									<tbody>
										<tr>
											<th scope="row">Name</th>
											<td>{{product['name']}}</td>
										</tr>
										<tr>
											<th scope="row">Code</th>
											<td>{{product['code']}}</td>
										</tr>
										<tr>
											<th scope="row">Category</th>
											<td>{{product['category_name']}}</td>
										</tr>
										<tr>
											<th scope="row">Sub Category</th>
											<td>{{product['sub_category_name']}}</td>
										</tr>
										<tr>
											<th scope="row">Brand</th>
											<td>{{product['brand_name']}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-danger mr-auto" ng-click="confDelInfo()" ng-disabled="infoSpinner"><i class='fa fa-trash' aria-hidden='true'></i>&nbsp;&nbsp;DELETE</button>
						<a href="#" <?php echo base_url('admin/products/print/'); ?>{{row['id']}} class="btn btn-primary" title="Print" ng-click="add_label(row['code'])"> <i class="fa fa-print"></i> <span>Print</span> </a> <a href="<?php echo base_url('admin/products/edit/'); ?>{{row['id']}}" class="btn btn-warning" title="Edit"> <i class="fa fa-pencil-alt"></i> <span>EDIT</span> </a> <a href="<?php echo base_url('admin/products/copy/'); ?>{{row['id']}}" class="btn btn-secondary" title="Duplicate"> <i class="fa fa-copy"></i> <span>COPY</span> </a>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /# container end -->
</div>