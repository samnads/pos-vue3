<?php defined('BASEPATH') or exit('No direct script access allowed');
if ($this->uri->segment(3) == 'edit') : ?>
	<script type="text/javascript">
		var edit = true;
		db = <?php echo json_encode($row); ?>;
		/*let rights = <?php echo json_encode($row); ?>;*/
		db.rights = <?php echo json_encode($rights); ?>;
	</script>
<?php endif; ?>
<div ng-controller="roleNewCtrl" id="roleNewCtrl" ng-init="init()">
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
				<span class="btn invisible">Invisible</span>
			</div>
		</div>
	</div>
	<div class="menubar_content">
		<?php echo form_open('', array('id' => 'form', 'name' => 'form', 'autocomplete' => 'off', 'ng-submit' => 'submit($event)', 'role' => 'form', 'novalidate' => '')); ?>
		<div class="form-row">
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
				<div class="form-group">
					<label>Role Name *</label>
					<input type="text" ng-model="field.name" ng-change="fdChange('name')" name="name" placeholder="Role name" class="form-control" ng-class="{'is-invalid' : form.name.$touched && form.name.$invalid,'is-valid' : form.name.$valid}" ng-required="true">
					<small class="form-text float-left">&nbsp;</small>
					<small class="form-text text-danger float-right" ng-messages="form.name.$error">
						<span ng-message="required" ng-show="form.name.$touched">Required !</span>
						<span ng-message="pattern">Invalid Format !</span>
						<span ng-message="error">{{form.name.$error.error}}</span>
					</small>
				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
				<div class="form-group">
					<label>Maximum Allowed Users *</label>
					<input type="number" ng-min="1" ng-change="fdChange('limit')" ng-model="field.limit" name="limit" placeholder="User limit" class="form-control" ng-class="{'is-invalid' : form.limit.$touched && form.limit.$invalid,'is-valid' : form.limit.$valid}" ng-required="true">
					<small class="form-text float-left">&nbsp;</small>
					<small class="form-text text-danger float-right" ng-messages="form.limit.$error">
						<span ng-message="required" ng-show="form.limit.$touched">Required !</span>
						<span ng-message="min">Allowed minimum user is 1 !</span>
						<span ng-message="error">{{form.limit.$error.error}}</span>
					</small>
				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
				<div class="form-group">
					<label>Description</label>
					<textarea ng-change="fdChange('description')" ng-model="field.description" name="description" placeholder="Description" class="form-control" ng-class="{'is-invalid' : form.description.$touched && form.description.$invalid,'is-valid' : form.description.$valid}" ng-required="true"></textarea>
					<small class="form-text float-left">&nbsp;</small>
					<small class="form-text text-danger float-right" ng-messages="form.description.$error">
						<span ng-message="required" ng-show="form.description.$touched">Required !</span>
						<span ng-message="error">{{form.description.$error.error}}</span>
					</small>
				</div>
			</div>
		</div>
		<div class="form-group mb-0">
			<label>Permissions *</label>
		</div>
		<div class="form-row">
			<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mt-2">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" aria-selected="true"><i class="fas fa-shopping-cart fa-fw"></i>&nbsp;Product</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active show p-2">
						<div class="row">
							<div class="col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="checkall.product" type="checkbox" class="custom-control-input" id="product" ng-change="selectAll('product')">
									<label class="custom-control-label" for="product">Select All</label>
								</div>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.product.GET" type="checkbox" class="custom-control-input" id="iksw" ng-change="select('product')">
									<label class="custom-control-label" for="iksw">View</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.product.POST" type="checkbox" class="custom-control-input" id="gbju" ng-change="select('product')">
									<label class="custom-control-label" for="gbju">Create</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.product.PUT" type="checkbox" class="custom-control-input" id="klos" ng-change="select('product')">
									<label class="custom-control-label" for="klos">Update</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.product.DELETE" type="checkbox" class="custom-control-input" id="klfg" ng-change="select('product')">
									<label class="custom-control-label" for="klfg">Delete</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mt-2">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" aria-selected="true"><i class="fas fa-layer-group fa-fw"></i>&nbsp;Category</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active show p-2">
						<div class="row">
							<div class="col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="checkall.category" type="checkbox" class="custom-control-input" id="category" ng-change="selectAll('category')">
									<label class="custom-control-label" for="category">Select All</label>
								</div>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.category.GET" type="checkbox" class="custom-control-input" id="rtrt" ng-change="select('category')">
									<label class="custom-control-label" for="rtrt">View</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.category.POST" type="checkbox" class="custom-control-input" id="sfsf" ng-change="select('category')">
									<label class="custom-control-label" for="sfsf">Create</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.category.PUT" type="checkbox" class="custom-control-input" id="ugsa" ng-change="select('category')">
									<label class="custom-control-label" for="ugsa">Update</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.category.DELETE" type="checkbox" class="custom-control-input" id="eftr" ng-change="select('category')">
									<label class="custom-control-label" for="eftr">Delete</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mt-2">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" aria-selected="true"><i class="fas fa-layer-group fa-fw"></i>&nbsp;Brand</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active show p-2">
						<div class="row">
							<div class="col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="checkall.brand" type="checkbox" class="custom-control-input" id="brand" ng-change="selectAll('brand')">
									<label class="custom-control-label" for="brand">Select All</label>
								</div>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.brand.GET" type="checkbox" class="custom-control-input" id="qerw" ng-change="select('brand')">
									<label class="custom-control-label" for="qerw">View</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.brand.POST" type="checkbox" class="custom-control-input" id="sukl" ng-change="select('brand')">
									<label class="custom-control-label" for="sukl">Create</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.brand.PUT" type="checkbox" class="custom-control-input" id="wyyx" ng-change="select('brand')">
									<label class="custom-control-label" for="wyyx">Update</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.brand.DELETE" type="checkbox" class="custom-control-input" id="srhs" ng-change="select('brand')">
									<label class="custom-control-label" for="srhs">Delete</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mt-2">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" aria-selected="true"><i class="fas fa-percent fa-fw"></i>&nbsp;Tax</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active show p-2">
						<div class="row">
							<div class="col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="checkall.tax" type="checkbox" class="custom-control-input" id="tax" ng-change="selectAll('tax')">
									<label class="custom-control-label" for="tax">Select All</label>
								</div>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.tax.GET" type="checkbox" class="custom-control-input" id="eerw" ng-change="select('tax')">
									<label class="custom-control-label" for="eerw">View</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.tax.POST" type="checkbox" class="custom-control-input" id="sdkl" ng-change="select('tax')">
									<label class="custom-control-label" for="sdkl">Create</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.tax.PUT" type="checkbox" class="custom-control-input" id="wdyx" ng-change="select('tax')">
									<label class="custom-control-label" for="wdyx">Update</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.tax.DELETE" type="checkbox" class="custom-control-input" id="srds" ng-change="select('tax')">
									<label class="custom-control-label" for="srds">Delete</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mt-2">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" aria-selected="true"><i class="fas fa-balance-scale-right fa-fw"></i>&nbsp;Unit</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active show p-2">
						<div class="row">
							<div class="col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="checkall.unit" type="checkbox" class="custom-control-input" id="unit" ng-change="selectAll('unit')">
									<label class="custom-control-label" for="unit">Select All</label>
								</div>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.unit.GET" type="checkbox" class="custom-control-input" id="tgrt" ng-change="select('unit')">
									<label class="custom-control-label" for="tgrt">View</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.unit.POST" type="checkbox" class="custom-control-input" id="srgt" ng-change="select('unit')">
									<label class="custom-control-label" for="srgt">Create</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.unit.PUT" type="checkbox" class="custom-control-input" id="afty" ng-change="select('unit')">
									<label class="custom-control-label" for="afty">Update</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.unit.DELETE" type="checkbox" class="custom-control-input" id="usky" ng-change="select('unit')">
									<label class="custom-control-label" for="usky">Delete</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mt-2">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" aria-selected="true"><i class="fas fa-truck fa-fw"></i>&nbsp;Supplier</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active show p-2">
						<div class="row">
							<div class="col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="checkall.supplier" type="checkbox" class="custom-control-input" id="supplier" ng-change="selectAll('supplier')">
									<label class="custom-control-label" for="supplier">Select All</label>
								</div>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.supplier.GET" type="checkbox" class="custom-control-input" id="rrte" ng-change="select('supplier')">
									<label class="custom-control-label" for="rrte">View</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.supplier.POST" type="checkbox" class="custom-control-input" id="fdgf" ng-change="select('supplier')">
									<label class="custom-control-label" for="fdgf">Create</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.supplier.PUT" type="checkbox" class="custom-control-input" id="asgs" ng-change="select('supplier')">
									<label class="custom-control-label" for="asgs">Update</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.supplier.DELETE" type="checkbox" class="custom-control-input" id="rtwz" ng-change="select('supplier')">
									<label class="custom-control-label" for="rtwz">Delete</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mt-2">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" aria-selected="true"><i class="fas fa-truck fa-fw"></i>&nbsp;Customer</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active show p-2">
						<div class="row">
							<div class="col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="checkall.customer" type="checkbox" class="custom-control-input" id="customer" ng-change="selectAll('customer')">
									<label class="custom-control-label" for="customer">Select All</label>
								</div>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.customer.GET" type="checkbox" class="custom-control-input" id="ofta" ng-change="select('customer')">
									<label class="custom-control-label" for="ofta">View</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.customer.POST" type="checkbox" class="custom-control-input" id="efvf" ng-change="select('customer')">
									<label class="custom-control-label" for="efvf">Create</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.customer.PUT" type="checkbox" class="custom-control-input" id="pydv" ng-change="select('customer')">
									<label class="custom-control-label" for="pydv">Update</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.customer.DELETE" type="checkbox" class="custom-control-input" id="erfz" ng-change="select('customer')">
									<label class="custom-control-label" for="erfz">Delete</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mt-2">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" aria-selected="true"><i class="fas fa-user fa-fw"></i>&nbsp;User</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active show p-2">
						<div class="row">
							<div class="col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="checkall.user" type="checkbox" class="custom-control-input" id="user" ng-change="selectAll('user')">
									<label class="custom-control-label" for="user">Select All</label>
								</div>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.user.GET" type="checkbox" class="custom-control-input" id="erts" ng-change="select('user')">
									<label class="custom-control-label" for="erts">View</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.user.POST" type="checkbox" class="custom-control-input" id="oidf" ng-change="select('user')">
									<label class="custom-control-label" for="oidf">Create</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.user.PUT" type="checkbox" class="custom-control-input" id="oipa" ng-change="select('user')">
									<label class="custom-control-label" for="oipa">Update</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.user.DELETE" type="checkbox" class="custom-control-input" id="juyt" ng-change="select('user')">
									<label class="custom-control-label" for="juyt">Delete</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mt-2">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" aria-selected="true"><i class="fas fa-warehouse fa-fw"></i>&nbsp;Warehouse</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active show p-2">
						<div class="row">
							<div class="col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="checkall.warehouse" type="checkbox" class="custom-control-input" id="warehouse" ng-change="selectAll('warehouse')">
									<label class="custom-control-label" for="warehouse">Select All</label>
								</div>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.warehouse.GET" type="checkbox" class="custom-control-input" id="rfgb" ng-change="select('warehouse')">
									<label class="custom-control-label" for="rfgb">View</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.warehouse.POST" type="checkbox" class="custom-control-input" id="jhgf" ng-change="select('warehouse')">
									<label class="custom-control-label" for="jhgf">Create</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.warehouse.PUT" type="checkbox" class="custom-control-input" id="tyui" ng-change="select('warehouse')">
									<label class="custom-control-label" for="tyui">Update</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.warehouse.DELETE" type="checkbox" class="custom-control-input" id="hjyu" ng-change="select('warehouse')">
									<label class="custom-control-label" for="hjyu">Delete</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mt-2">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" aria-selected="true"><i class="fas fa-user-check fa-fw"></i>&nbsp;Roles</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active show p-2">
						<div class="row">
							<div class="col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="checkall.role" type="checkbox" class="custom-control-input" id="role" ng-change="selectAll('role')">
									<label class="custom-control-label" for="role">Select All</label>
								</div>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.role.GET" type="checkbox" class="custom-control-input" id="frde" ng-change="select('role')">
									<label class="custom-control-label" for="frde">View</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.role.POST" type="checkbox" class="custom-control-input" id="ygtf" ng-change="select('role')">
									<label class="custom-control-label" for="ygtf">Create</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.role.PUT" type="checkbox" class="custom-control-input" id="okiu" ng-change="select('role')">
									<label class="custom-control-label" for="okiu">Update</label>
								</div>
							</div>
							<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="custom-control custom-checkbox">
									<input ng-model="rights.role.DELETE" type="checkbox" class="custom-control-input" id="uiop" ng-change="select('role')">
									<label class="custom-control-label" for="uiop">Delete</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="form-group">
					<button type="submit" ng-disabled="form.submit" ng-scope="sumbit" title="{{form.edit ? 'Save changes' : 'Add role'}}" class="btn" ng-class="{'btn-secondary' : form.$invalid,'btn-info' : form.$valid}">
						<span ng-show="form.submit"><i class="fas fa-spinner fa-spin"></i></span>
						<span ng-hide="form.submit"><i class='fa fa-save' aria-hidden='true'></i></span>
						{{form.edit ? string.update : string.save}}
					</button>
					<button type="button" class="btn btn-warning float-right" ng-disabled="form.$pristine" ng-click="reset()">Reset</button>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>