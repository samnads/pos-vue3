<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="form-inline menubar">
	<div class="form-row title">
		<div class="col-auto">
			<span class="icon"><i class="fas fa-shopping-cart"></i></span>
			<span class=""><?php end($breadcrumbs);
							echo key($breadcrumbs); ?></span>
		</div>
	</div>
	<div class="form-row ml-auto">
		<span id="buttons"></span>
		<div class="col-auto">
			<button type="submit" ng-scope="sumbit" class="btn btn-light" ng-disabled="products.length < 1 || barForm.$invalid || !paper" ng-click="printStart()">Print</button>
		</div>
		<div class="col-auto">
			<button type="button" class="btn btn-light" ng-disable="barForm.$pristine" ng-click="reset()">Reset</button>
		</div>
	</div>
</div>
<div class="menubar_content" ng-controller="printBarcodeCtrl" ng-ini="printBarcodeInit()">
	<?php echo form_open('', array('id' => 'barForm', 'name' => 'barForm', 'ng-submit' => 'submit()', 'role' => 'form', 'novalidate' => 'novalidate')); ?>
	<div class="form-row">
		<div class="col-lg-8">
			<div class="form-group">
				<label><strong>Search &amp; Add Product *</strong></label>
				<div class="input-group">
					<div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><i class="fas fa-barcode"></i></span> </div>
					<input type="text" id="pSearch" class="form-control" name="pSearch" ng-model="pSearch" placeholder="Enter any product name / code..." ng-model="data.name" ng-change="nameC(data.name)" ng-disabled="tableLoading">
					<div class="input-group-append" ng-if="search"> <span class="input-group-text">
							<div class="spinner-grow spinner-grow-sm" role="status"> <span class="sr-only">Loading...</span> </div>
						</span> </div>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<label><strong>Paper Size &amp; Style *</strong></label>
				<div class="input-group">
					<select class="custom-select" ng-model="size" name="size" ng-min="0" ng-change="pChange(size)" ng-class="{ 'is-invalid' : barForm.paper.$touched && barForm.paper.$invalid}" ng-disabled="!labels" ng-required="true">
						<option ng-if="!labels" ng-value="0">{{string.inLoad}}</option>
						<option ng-if="labels" ng-value="null">-- Select label style --</option>
						<option ng-repeat="label in labels" ng-value="{{label.id}}">{{label.name}}</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="form-row">
		<div class="col-lg-12">
			<div class="table-responsie">
				<table class="table table-sm table-bordered table-hover text-center" id="bcodeTable">
					<thead class="thead-light">
						<tr class="text-center d-flex">
							<th scope="col" class="col-1">#</th>
							<th scope="col" class="col-1"><i class="fas fa-image"></i></th>
							<th scope="col" class="col-5">Product Name</th>
							<th scope="col" class="col-2">Code</th>
							<th scope="col" class="col-1">Price</th>
							<th scope="col" class="col-1">Quantity</th>
							<th scope="col" class="col-1"><button ng-click="remove('conf')" class="btn btn-sm btn-block" style="padding-bottom:  0px;padding-top:  0px" ng-class="{ 'text-danger' : products.length > 0}"><i class="fa fa-trash" aria-hidden="true"></i></button></th>
						</tr>
					</thead>
					<tbody>
						<tr class="d-flex" ng-repeat="product in products | orderBy: reverse:true">
							<th class="col-1">{{$index+1}}</th>
							<td class="col-1 text-center"><img ng-src="{{product.thumbnail}}" class="rounded thumbnail" /></td>
							<td class="col-5 text-left">{{product.value}}</td>
							<td class="col-2">{{product.code}}</td>
							<td class="col-1">{{product.price | number:2}}</td>
							<td class="col-1">
								<div class="input-group input-group-sm">
									<input type="number" class="form-control text-center" ng-class="{ 'is-invalid' : barForm['quantity'+$index].$dirty && barForm['quantity'+$index].$invalid}" ng-min="1" ng-max="100" ng-change="cQuantity($index,quantity[$index])" ng-model="quantity[$index]" name="quantity{{$index}}" ng-value="product.quantity" ng-required="true">
								</div>
							</td>
							<td class="col-1">
								<a href="#" ng-click="remove($index)" title="Remove {{p.value}}" class="text-secondary"><i class="fa fa-times" aria-hidden="true"></i></a>
							</td>
						</tr>
						<tr ng-if="!tableLoading && products.length == 0">
							<td colspan="12">Empty Label Print Data !</td>
						</tr>
						<tr ng-if="tableLoading">
							<td colspan="12">
								<div class="spinner-border" role="status">
									<span class="sr-only">Loading...</span>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!--- Delete ALl Confirm Modal -->
		<div class="modal" id="confDelAll" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header bg-danger text-white">
						<h5 class="modal-title">Confirm Delete All ?</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					</div>
					<div class="modal-body">Do you want to delete all products from this print list ?</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-danger mr-auto" ng-click="remove('ok')"><i class='fa fa-trash align-left' aria-hidden='true'></i>&nbsp;&nbsp;YES</button>
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class='fa fa-stop' aria-hidden='true'></i>&nbsp;&nbsp;NO</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12">
			<div class="form-group">
				<button type="submit" ng-scope="sumbit" class="btn btn-success pull-left" ng-disabled="products.length < 1 || barForm.$invalid || !paper" ng-click="printStart()">Print</button>
				<button type="button" class="btn btn-warning float-right" ng-disable="barForm.$pristine" ng-click="reset()">Reset</button>
			</div>
		</div>
		<!--<pre>products : {{products | json}}</pre>
	<br>
	<pre>tempProd : {{tempProd | json}}</pre>-->
	</div>
	</form>
	<style>
		.icon-container {
			position: absolute;
			right: 10px;
			top: calc(50% - 50px);
		}

		.loader {
			position: relative;
			height: 20px;
			width: 20px;
			display: inline-block;
			animation: around 5.4s infinite;
		}

		@keyframes around {
			0% {
				transform: rotate(0deg)
			}

			100% {
				transform: rotate(360deg)
			}
		}

		.loader::after,
		.loader::before {
			content: "";
			background: white;
			position: absolute;
			display: inline-block;
			width: 100%;
			height: 100%;
			border-width: 2px;
			border-color: #333 #333 transparent transparent;
			border-style: solid;
			border-radius: 20px;
			box-sizing: border-box;
			top: 0;
			left: 0;
			animation: around 0.7s ease-in-out infinite;
		}

		.loader::after {
			animation: around 0.7s ease-in-out 0.1s infinite;
			background: transparent;
		}

		.thumbnail {
			width: 25px;
		}
	</style>