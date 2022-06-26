<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div ng-controller="listCatCtrl" id="listProdCtrl" ng-ini="initTable()">
	<div class="form-inline menubar">
		<div class="form-row title">
			<div class="col-auto">
				<span class="icon"><i class="fas fa-layer-group"></i></span>
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
				<input class="form-control" id="search" type="search" placeholder="Search..." ng-model="searchText">
			</div>
		</div>
	</div>
	<div class="menubar_content">
		<!--- List Categories Table -->
		<div class="table-responsive-lg table-responsive-xl table-responsive-md table-responsive-sm">
			<table class="table table-sm table-bordered table-hover w-auto" id="catTable">
				<thead>
					<tr class="text-center">
						<th><i class="fas fa-image"></i></th>
						<th>Name</th>
						<th>Code</th>
						<th>Slug</th>
						<th>Sub Cats.</th>
						<th>Products</th>
						<th>Brands</th>
						<th><i class='fas fa-plus'></i></i></th>
						<th><i class="fas fa-bars"></i></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
					<tr class="text-center">
						<th><i class="fas fa-image"></i></th>
						<th>Name</th>
						<th>Code</th>
						<th>Slug</th>
						<th>Sub Cats.</th>
						<th>Products</th>
						<th>Brands</th>
						<th><i class='fas fa-plus'></i></i></th>
						<th><i class="fas fa-bars"></i></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<!--- List sub cats Table -->
	<div class="form-inline menubar" ng-show="subCatTable">
		<div class="form-row title">
			<div class="col-auto">
				<span class="icon"><i class="fas fa-layer-group"></i></span>
				<span class="">Subcategories</span>
			</div>
		</div>
		<div class="form-row ml-auto">
			<div class="col-auto">
				<select class="custom-select" name="sub_length_change" id="sub_length_change">
					<option value="3" selected>3</option>
					<option value="5">5</option>
					<option value="10">10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="100">100</option>
					<option value="250">250</option>
					<option value="500">500</option>
					<option value="-1">All</option>
				</select>
			</div>
			<span id="sub_buttons"></span>
			<div class="col-auto">
				<input class="form-control" id="sub_search" type="search" placeholder="Search..." ng-model="sub_searchText">
			</div>
		</div>
	</div>
	<div class="menubar_content" ng-show="subCatTable">
		<div class="table-responsive-lg table-responsive-xl table-responsive-md table-responsive-sm">
			<table class="table table-sm table-bordered table-hover w-100" id="subCatTable">
				<thead>
					<tr class="text-center">
						<th><i class="fas fa-image"></i></th>
						<th>Name</th>
						<th>Code</th>
						<th>Slug</th>
						<th>Products</th>
						<th>Brands</th>
						<th><i class="fas fa-bars"></i></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
					<tr class="text-center">
						<th><i class="fas fa-image"></i></th>
						<th>Name</th>
						<th>Code</th>
						<th>Slug</th>
						<th>Products</th>
						<th>Brands</th>
						<th><i class="fas fa-bars"></i></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<!--- Delete Individual Product Confirm Modal -->
	<div class="modal" id="singDel" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-danger text-white">
					<h5 class="modal-title">Confirm Delete {{delData.category ? 'Subcategory' : 'Category'}} ?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body text-center">{{catRow['name']}} | {{catRow['code']}}</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-danger mr-auto" ng-click="delete()"><i class='fa fa-trash align-left' aria-hidden='true'></i>&nbsp;&nbsp;YES</button>
					<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class='fa fa-stop' aria-hidden='true'></i>&nbsp;&nbsp;NO</button>
				</div>
			</div>
		</div>
	</div>
	<!--- Prtoduct Info Modal -->
	<div class="modal" id="catInfo" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-secondary text-white">
					<h5 class="modal-title">{{catInfo['name']}}</h5>
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
					<a href="#" <?php echo base_url('admin/products/print/'); ?>{{row['id']}} class="btn btn-primary" title="Print" ng-click="add_label(row['code'])"> <i class="fa fa-print"></i> <span>Print Labels</span> </a> <a href="<?php echo base_url('admin/products/edit/'); ?>{{row['id']}}" class="btn btn-warning" title="Edit"> <i class="fa fa-pencil-alt"></i> <span>EDIT</span> </a> <a href="<?php echo base_url('admin/products/copy/'); ?>{{row['id']}}" class="btn btn-secondary" title="Duplicate"> <i class="fa fa-copy"></i> <span>COPY</span> </a>
				</div>
			</div>
		</div>
	</div>
</div>
<!--<pre>products : {{rows | json}}</pre>-->
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