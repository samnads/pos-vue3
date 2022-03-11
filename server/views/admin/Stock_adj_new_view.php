<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div ng-controller="listStockAdjCtrl" id="listProdCtrl" ng-init="init()">
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
				<span class="btn invisible">Invisible</span>
			</div>
		</div>
	</div>
	<div class="menubar_content">
		<?php echo form_open('', array('id' => 'form', 'name' => 'form', 'ng-submit' => 'submit($event)', 'role' => 'form', 'novalidate' => 'novalidate')); ?>
		<div class="form-row">
			<div class="col-lg-12 mb-2 ng-scope" ng-if="SET.new">
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title text-primary">Basic Details</h5>
								<hr>
								<div class="form-row">
									<div class="col-lg-2">
										<div class="form-group">
											<label for="type">Date <strong>*</strong></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"> <i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input id="date" type="text" ng-change="fdChange('date')" ng-model="data.date" name="date" class="form-control" ng-class="{'is-invalid' : (form.date.$touched || form.date.$dirty) && form.date.$invalid}" ng-require="true">
											</div>
											<small class="form-text float-left">&nbsp;</small>
											<small class="form-text text-info float-right" ng-messages="form.date.$error">
												<span ng-message="required" class="text-danger" ng-show="form.date.$touched && form.date.$invalid">Required!</span>
												<span ng-message="error" class="text-danger">{{form.date.$error.error}}</span>
											</small>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
											<label for="type">Warehouse <strong>*</strong></label>
											<div class="input-group">
												<select class="custom-select" ng-model="data.warehouse" name="warehouse" ng-class="{ 'is-invalid' : form.warehouse.$touched && form.warehouse.$invalid}" ng-disabled="!db.warehouses" ng-required="true">
													<option ng-if="!db.warehouses" ng-value="undefined">{{string.inLoad}}</option>
													<option ng-if="db.warehouses" ng-value="null">-- Select warehouse --</option>
													<option ng-repeat="warehouse in db.warehouses" ng-value="{{warehouse.id}}">{{warehouse.name}}</option>
												</select>
											</div>
											<small class="form-text float-left">&nbsp;</small>
											<small class="form-text text-info float-right" ng-messages="form.warehouse.$error">
												<span ng-message="required" class="text-danger" ng-show="form.warehouse.$touched && form.warehouse.$invalid">Required!</span>
												<span ng-message="error" class="text-danger">{{form.warehouse.$error.error}}</span>
											</small>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label for="type">Reference No.</label>
											<div class="input-group">
												<input ng-model="data.ref_no" name="ref_no" class="form-control" ng-class="{'is-invalid' : (form.ref_no.$touched || form.ref_no.$dirty) && form.ref_no.$invalid}">
											</div>
											<small class="form-text float-left">&nbsp;</small>
											<small class="form-text text-info float-right" ng-messages="form.ref_no.$error">
												<span ng-message="required" class="text-danger" ng-show="form.ref_no.$touched && form.ref_no.$invalid">Required!</span>
												<span ng-message="error" class="text-danger">{{form.ref_no.$error.error}}</span>
											</small>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label for="type">Note</label>
											<div class="input-group">
												<textarea type="text" class="form-control" name="stock_adj_note" ng-model="data.stock_adj_note"></textarea>
											</div>
											<small class="form-text float-left">&nbsp;</small>
											<small class="form-text text-info float-right" ng-messages="form.stock_adj_note.$error">
												<span ng-message="required" class="text-danger" ng-show="form.stock_adj_note.$touched && form.stock_adj_note.$invalid">Required!</span>
												<span ng-message="error" class="text-danger">{{form.stock_adj_note.$error.error}}</span>
											</small>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
											<label for="type">File</label>
											<div class="input-group">
												<div class="custom-file">
													<input type="file" class="custom-file-input">
													<label class="custom-file-label font-weight-normal" for="inputGroupFile01">-- Select file --</label>
												</div>
											</div>
											<small class="form-text float-left">&nbsp;</small>
											<small class="form-text text-info float-right" ng-messages="form.file.$error">
												<span ng-message="required" class="text-danger" ng-show="form.file.$touched && form.file.$invalid">Required!</span>
												<span ng-message="error" class="text-danger">{{form.file.$error.error}}</span>
											</small>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-row">
			<div class="col-lg-12 mb-2 ng-scope">
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title text-primary">Products</h5>
								<hr>
								<div class="input-group input-group-md mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-barcode"></i></span>
									</div>
									<input type="text" class="form-control" placeholder="Scan or type product name..." id="pSearch" name="pSearch" ng-model="pSearch">
									<div class="input-group-append" ng-if="search">
										<span class="input-group-text">
											<div class="spinner-grow spinner-grow-sm" role="status">
												<span class="sr-only">Loading...</span>
											</div>
										</span>
									</div>
								</div>
								<div class="table-responsive-xl">
									<table class="table table-sm table-bordered table-striped table-hover" id="productsTabl">
										<thead class="thead-dark">
											<tr class="text-center">
												<th>Code | Name</th>
												<th class="fit">Type</th>
												<th>Quantity</th>
												<th>Note</th>
												<th class="fit"><i class="far fa-trash-alt"></i></th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat="product in products | orderBy: reverse:true track by $index" ng-init="$last && finished($index)">
												<td class="col-2 align-middle">{{product.code}} | {{product.name}}</td>
												<td class="col-2 align-middle text-center fit">
													<span ng-if="product.quantity >= 0" class="text-success">Addition</span>
													<span ng-if="product.quantity < 0" class="text-danger">Subtraction</span>
												</td>
												<td class="col-2 align-middle">
													<div class="input-group input-group-sm">
														<div class="input-group-prepend">
															<button type="button" class="btn btn-outline-secondary" ng-click="qChangeMinus($index,product.quantity)"><i class="fas fa-minus"></i></button>
														</div>
														<input type="number" class="form-control text-center" ng-value="product.quantity" ng-model="quantity[$index]" name="quantity{{$index}}" id="quantity{{$index}}" ng-blur="qChange($index,quantity[$index],$event)" ng-required="true" select-on-click />
														<div class="input-group-append">
															<button type="button" class="btn btn-outline-secondary" ng-click="qChangePlus($index,product.quantity)"><i class="fas fa-plus"></i></button>
														</div>
													</div>
													<small class="form-text text-danger float-right" ng-messages="form['quantity'+$index].$error">
														<span ng-message="error" class="text-danger">{{form['quantity'+$index].$error.error}}</span>
														<span ng-message="min" class="text-danger">Invalid minimum quantity!</span>
													</small>
												</td>
												<td class="col-2 align-middle">
													<div class="input-group">
														<input type="text" class="form-control" ng-value="product.note" ng-model="note[$index]" name="note{{$index}}" id="note{{$index}}" ng-required="false" ng-change="nChange($index,note[$index])" />
													</div>
													<small class="form-text text-danger float-right" ng-messages="form['note'+$index].$error">
														<span ng-message="error" class="text-danger">{{form['note'+$index].$error.error}}</span>
													</small>
												</td>
												<td class="col-1 text-center align-middle fit">
													<button type="button" class="btn btn-sm text-danger" title="Remove {{product.value}}" data-toggle="modal" data-target="#delProdModal" data-index="{{$index}}"><i class="far fa-trash-alt"></i></button>
												</td>
											</tr>
											<td colspan="5" class="text-muted text-center" ng-hide="products.length > 0">Empty product list, use the search bar to add products...</td>
										</tbody>
									</table>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="delProdModal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header bg-danger text-white">
						<h5 class="modal-title">Delete product from adjustment list ?</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					</div>
					<div class="modal-body text-center"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-danger mr-auto" ng-click="delProd()"><i class='fa fa-trash align-left' aria-hidden='true'></i>&nbsp;&nbsp;YES</button>
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class='fa fa-stop' aria-hidden='true'></i>&nbsp;&nbsp;NO</button>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix pt-3">
			<button type="submit" class="btn float-left" ng-class="{'btn-secondary' : products.length  == 0 || form.$invalid,'btn-info' : products.length > 0 && form.$valid}" ng-disable="products.length  == 0 || form.$invalid"><i class='fa fa-save' aria-hidden='true'></i>&nbsp;&nbsp;{{SET.new || SET.copy ? string.save : string.update}}</button>
			<button type="button" class="btn float-right btn-warning" ng-disabled="form.$pristine" ng-click="reset()">Reset</button>
		</div>
		</form>
	</div><!-- /# container end -->
</div>