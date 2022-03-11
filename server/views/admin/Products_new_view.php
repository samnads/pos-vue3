<?php
defined('BASEPATH') or exit('No direct script access allowed');
if ($this->uri->segment(4) && ($this->uri->segment(3) == 'edit' || $this->uri->segment(3) == 'copy')) { // database values
	$is_copy = $this->uri->segment(3) == 'copy' ? 1 : 0;
?>
	<script type="text/javascript">
		var is_new = false;
		var is_copy = <?php echo $is_copy == 1 ? 'true' : 'false'; ?>;
		var id = <?php echo $row->id; ?>;
		var type = <?php echo $row->type; ?>;
		var code = "<?php echo $row->code; ?>";
		var symbology = <?php echo $row->symbology; ?>;
		var name = "<?php echo $row->name; ?>";
		var slug = "<?php echo $row->slug; ?>";
		var weight = <?php echo $row->weight ?: 'null'; ?>;
		var category = <?php echo $row->category; ?>;
		var sub_category = <?php echo $row->sub_category ?: 0; ?>;
		var brand = <?php echo $row->brand ?: 0; ?>;
		var mrp = <?php echo $row->mrp ?: 'null'; ?>;
		var unit = <?php echo $row->unit; ?>;
		var p_unit = <?php echo $row->p_unit ?: 0; ?>;
		var s_unit = <?php echo $row->s_unit ?: 0; ?>;
		var is_auto_cost = <?php echo $row->is_auto_cost == 1 ? 'true' : 'false'; ?>;
		var cost = <?php echo $row->cost ?: 'null'; ?>;
		var price = <?php echo $row->price; ?>;
		var auto_discount = <?php echo $row->auto_discount; ?>;
		var tax_method = '<?php echo $row->tax_method; ?>';
		var tax_rate = <?php echo $row->tax_rate ?: 0; ?>;
		var mfg_date = <?php echo $row->mfg_date ? '"' . $row->mfg_date . '"' : 'null'; ?>;
		var exp_date = <?php echo $row->exp_date ? '"' . $row->exp_date . '"' : 'null'; ?>;
		var alerT = <?php echo $row->alert == 1 ? 'true' : 'false'; ?>;
		var alert_quantity = <?php echo $row->alert_quantity ?: 'null'; ?>;
		var def_alert_quantity = 3; // default setting
		var db = <?php echo json_encode($row); ?>;
	</script>
<?php
} else { // default values - new product
?>
	<script type="text/javascript">
		var is_new = true;
		var is_copy = false;
		var type = 1; // default set
		//var code = null;
		var symbology = 1; // default set
		//var name = '';
		//var slug = '';
		var category = 1; // default set
		var sub_category = 0; // default set
		var brand = 1; // default set
		var unit = 1; // default set
		var p_unit = 0;
		var s_unit = 0;
		var is_auto_cost = false; // default set
		var cost = 50; // default set
		var tax_method = 'E'; // default set
		var tax_rate = 1; // default set
		var alerT = true; // default set
		var def_alert_quantity = 3; // default set


		var profit_margin = 50;
		var auto_discount = 0;
	</script>
<?php
}
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
		<div class="col-auto">
			<span class="btn invisible">Invisible</span>
		</div>
	</div>
</div>
<div class="menubar_content" ng-controller="newProdCtrl" ng-init="init()">
	<?php echo form_open('', array('id' => 'form', 'name' => 'form', 'ng-submit' => 'submit($event)', 'role' => 'form', 'novalidate' => 'novalidate')); ?>
	<div class="form-row">
		<div class="col-lg-4">
			<div class="form-row">
				<div class="col-lg-12">
					<div class="form-group">
						<label for="type">Product Type <strong>*</strong></label>
						<div class="input-group">
							<select class="custom-select" ng-model="data.type" name="type" ng-class="{ 'is-invalid' : form.type.$dirty && form.type.$invalid}" ng-disabled="!db.types" ng-required="true">
								<option ng-if="!db.types" ng-value="undefined">{{string.inLoad}}</option>
								<option ng-if="db.types" ng-value="null">-- Select product type --</option>
								<option ng-repeat="type in db.types" ng-value="{{type.id}}">{{type.name}}</option>
							</select>
							<!-- <select class="custom-select" name="type" ng-model="data.type" ng-options="option.name for option in db.types track by option.id" ng-class="{ 'is-invalid' : form.type.$touched && form.type.$invalid}" ng-required="true">
								<option value="">-- Select Product Type --</option>
							</select> -->
						</div>
						<small class="form-text float-left">&nbsp;</small>
						<small class="form-text text-info float-right" ng-messages="form.type.$error">
							<span ng-message="required" class="text-danger" ng-show="form.type.$dirty && form.type.$invalid">Required!</span>
							<span ng-message="error" class="text-danger">{{form.type.$error.error}}</span>
						</small>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-lg-8">
					<div class="form-group">
						<label for="code">Product Code <strong>*</strong></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-barcode" aria-hidden="true"></i>
								</span>
							</div>
							<input ng-model="data.code" ng-change="cChange()" name="code" placeholder="Product code" ng-minlength="3" ng-maxlength="200" class="form-control" ng-class="{'is-invalid' : (form.code.$touched || form.code.$dirty) && form.code.$invalid}" ng-pattern="pattern1" ng-required="true">
							<div class="input-group-append" ng-if="!SET.edit">
								<div class="btn btn-outline-info" data-toggle="tooltip" title="Generate Random Code" ng-click="randCode()"><i class="fa fa-random" aria-hidden="true"></i> </div>
							</div>
						</div>
						<small class="form-text text-muted d-block float-left">&nbsp;</small>
						<small class="form-text text-info float-right" ng-messages="form.code.$error">
							<span ng-message="required" class="text-danger" ng-show="(form.code.$touched || form.code.$dirty) && form.code.$invalid">Required!</span>
							<span ng-message="minlength">Required minimum length 3 !</span>
							<span ng-message="maxlength">Allowed maximum length 200 !</span>
							<span ng-message="pattern" class="text-danger">Invalid format !</span>
							<span ng-message="check" class="text-info">Checking availability...</span>
							<span ng-message="error" class="text-danger">{{form.code.$error.error}}</span>
						</small>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="form-group">
						<label for="code">Symbology <strong>*</strong></label>
						<div class="input-group">
							<select class="custom-select" name="symbology" ng-model="data.symbology" ng-class="{ 'is-invalid' : form.symbology.$dirty && form.symbology.$invalid}" ng-disabled="!db.symbols" ng-required="true">
								<option ng-if="!db.symbols" ng-value="undefined">{{string.inLoad}}</option>
								<option ng-if="db.symbols" ng-value="null">-- Select symbology --</option>
								<option ng-value="{{symbol.id}}" ng-repeat="symbol in db.symbols">{{symbol.code}}</option>
							</select>
							<!-- <select class="custom-select" name="symbology" ng-model="data.symbology" ng-options="option.code for option in db.symbols track by option.id" ng-class="{ 'is-invalid' : form.symbology.$touched && form.symbology.$invalid}" ng-required="true">
								<option value="">-- Select symbology --</option>
							</select> -->
						</div>
						<small class="form-text text-info float-right" ng-messages="form.symbology.$error">
							<span ng-message="required" class="text-danger" ng-show="form.symbology.$dirty && form.symbology.$invalid">Required!</span>
							<span ng-message="error" class="text-danger">{{form.symbology.$error.error}}</span>
						</small>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Product Name <strong>*</strong></label>
						<div class="input-group">
							<input type="text" class="form-control" name="name" placeholder="Product Name" ng-model="data.name" ng-minlength="3" ng-maxlength="200" ng-pattern="pattern1" ng-change="nameC(data.name)" ng-class="{ 'is-invalid' : form.name.$touched && form.name.$invalid}" ng-required="true">
						</div>
						<small class="form-text float-left">&nbsp;</small>
						<small class="form-text text-info float-right" ng-messages="form.name.$error">
							<span ng-message="required" class="text-danger" ng-show="form.name.$touched && form.name.$invalid">Required!</span>
							<span ng-message="minlength">Required minimum length 3 !</span> <span ng-message="maxlength">Allowed maximum length 200 !</span>
							<span ng-message="pattern" class="text-danger">Invalid format !</span> <span ng-message="exist" class="text-danger">Name already exist !</span>
							<span ng-message="check" class="text-info">Checking availability...</span>
							<span ng-message="error" class="text-danger">{{form.name.$error.error}}</span>
						</small>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>URL Slug <strong>*</strong></label>
						<div class="input-group">
							<input type="text" class="form-control" name="slug" placeholder="Url slug string" ng-model="data.slug" ng-class="{ 'is-invalid' : form.slug.$touched && form.slug.$invalid}" ng-pattern="pattern7" ng-minlength="3" ng-maxlength="200" ng-required="true">
						</div>
						<small class="form-text float-left">&nbsp;</small><small class="form-text text-info float-right" ng-messages="form.slug.$error">
							<span ng-message="required" class="text-danger" ng-show="form.slug.$touched && form.slug.$invalid">Required!</span>
							<span ng-message="minlength">Required minimum length 3 !</span>
							<span ng-message="maxlength">Allowed maximum length 200 !</span>
							<span ng-message="pattern" class="text-danger">Invalid format !</span>
							<span ng-message="exist" class="text-danger">Slug already exist !</span>
							<span ng-message="check" class="text-info">Checking availability...</span>
							<span ng-message="error" class="text-danger">{{form.slug.$error.error}}</span>
						</small>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Product Weight</label>
						<div class="input-group">
							<input type="number" name="weight" class="form-control" placeholder="Weight in gram(s)" ng-class="{ 'is-invalid' : form.weight.$touched && form.weight.$invalid}" ng-model="data.weight" ng-required="false">
							<div class="input-group-append"> <span class="input-group-text"><i class="fa fa-balance-scale" aria-hidden="true"></i></span> </div>
						</div>
						<small class="form-text text-info float-right" ng-messages="form.weight.$error">
							<span ng-message="error" class="text-danger">{{form.weight.$error.error}}</span>
						</small>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Category <strong>*</strong></label>
						<div class="input-group">
							<select class="custom-select" ng-class="{ 'is-invalid' : form.category.$dirty && form.category.$invalid}" name="category" ng-model="data.category" ng-disabled="!db.categories" ng-change="initSubCats({id:data.category})" ng-required="true">
								<option ng-if="!db.categories" ng-value="undefined">{{string.inLoad}}</option>
								<option ng-if="db.categories" ng-value="null">-- Select category --</option>
								<option ng-value="{{category.id}}" ng-repeat="category in db.categories">{{category.name}}</option>
							</select>
							<div class="input-group-append">
								<button class="btn btn-outline-info" data-toggle="tooltip" title="New Category" ng-disabled="!db.categories" type="button" ng-click="showCatForm()"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
							</div>
						</div>
						<small class="form-text text-muted d-block float-left">&nbsp;</small>
						<small class="form-text text-info float-right" ng-messages="form.category.$error">
							<span ng-message="required" class="text-danger" ng-show="form.category.$dirty && form.category.$invalid">Required!</span>
							<span ng-message="error" class="text-danger">{{form.category.$error.error}}</span>
						</small>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Sub Category</label>
						<div class="input-group">
							<select class="custom-select" name="sub_category" ng-model="data.sub_category" ng-disabled="!db.categories || !data.category || !db.subcats || db.subcats.length == 0">
								<option ng-if="!db.categories || !db.subcats" ng-value="undefined">{{string.inLoad}}</option>
								<option ng-if="db.categories && data.category == null" ng-value="null">-- Select category first --</option>
								<option ng-if="data.category && db.subcats && db.subcats.length == 0" ng-value="null">-- No sub category found --</option>
								<option ng-if="data.category && db.subcats && db.subcats.length > 0" ng-value="null">-- Select sub category --</option>
								<option ng-if="data.category && db.subcats" ng-value="{{subcat.id}}" ng-repeat="subcat in db.subcats">{{subcat.name}}</option> -->
							</select>
							<div class="input-group-append">
								<button class="btn btn-outline-info" ng-disabled="!db.categories || !data.category || !db.subcats" data-toggle="tooltip" title="New Sub Category" type="button" ng-click="showCatForm({data: (db.categories | filter:{id:data.category}:true)[0],sub:true})"><i class="fa fa-plus" aria-hidden="true"></i> </button>
							</div>
						</div>
						<small class="form-text text-muted d-block float-left">&nbsp;</small>
						<small class="form-text text-info float-right" ng-messages="form.sub_category.$error">
							<span ng-message="error" class="text-danger">{{form.sub_category.$error.error}}</span>
						</small>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Brand Name</label>
						<div class="input-group">
							<select class="custom-select" name="brand" ng-model="data.brand" ng-disabled="!db.brands">
								<option ng-if="!db.brands" ng-value="undefined">{{string.inLoad}}</option>
								<option ng-if="db.brands && db.brands.length > 0" ng-value="null">-- Select brand --</option>
								<option ng-if="db.brands && db.brands.length ==0" ng-value="null">-- No brand found --</option>
								<option ng-value="{{brand.id}}" ng-repeat="brand in db.brands">{{brand.name}}</option>
							</select>
							<!-- <select class="custom-select" name="brand" ng-model="data.brand" ng-options="option.name for option in db.brands track by option.id" ng-required="false">
								<option value="">-- Select Brand --</option>
							</select> -->
							<div class="input-group-append">
								<button class="btn btn-outline-info" type="button" data-toggle="tooltip" title="New Brand" ng-disabled="!db.brands" ng-click="show_createBrandModal()"><i class="fa fa-plus" aria-hidden="true"></i> </button>
							</div>
						</div>
						<small class="form-text float-left">&nbsp;</small>
						<small class="form-text text-info float-right" ng-messages="form.brand.$error">
							<span ng-message="error" class="text-danger">{{form.brand.$error.error}}</span>
						</small>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>MRP</label>
						<div class="input-group">
							<div class="input-group-prepend"> <span class="input-group-text">₹</span> </div>
							<input type="number" placeholder="Maximum retail price" class="form-control" ng-class="{ 'is-invalid' : form.mrp.$touched && form.mrp.$invalid}" name="mrp" ng-pattern="pattern2" ng-model="data.mrp">
						</div>
						<small class="form-text float-left">&nbsp;</small>
						<small class="form-text text-info float-right" ng-messages="form.mrp.$error">
							<span ng-message="greater" class="text-danger">Invalid Price or MRP !</span>
							<span ng-message="error" class="text-danger">{{form.mrp.$error.error}}</span>
						</small>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-lg-4">
					<div class="form-group">
						<label>Product Unit <strong>*</strong></label>
						<div class="input-group">
							<select class="custom-select" id="unit" ng-model="data.unit" name="unit" ng-class="{ 'is-invalid' : form.unit.$dirty && form.unit.$invalid}" ng-disabled="!db.units" ng-change="initSubUnits({ id: data.unit })" ng-required="true">
								<option ng-if="!db.units" ng-value="undefined">{{string.inLoad}}</option>
								<option ng-if="db.units" ng-value="null">-- Select unit --</option>
								<option ng-value="{{unit.id}}" ng-repeat="unit in db.units track by $index">{{unit.name}}</option>
							</select>
							<div class="input-group-append">
								<button class="btn btn-outline-info" data-toggle="tooltip" title="New Base Unit" ng-disabled="!db.units" type="button" ng-click="showUnitForm()"><i class="fa fa-plus" aria-hidden="true"></i> </button>
							</div>
						</div>
						<small class="form-text float-left">&nbsp;</small>
						<small class="form-text text-info float-right" ng-messages="form.unit.$error">
							<span ng-message="required" class="text-danger" ng-show="form.unit.$dirty && form.unit.$invalid">Required!</span>
							<span ng-message="error" class="text-danger">{{form.unit.$error.error}}</span>
						</small>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="form-group">
						<label>Purchase Unit</label>
						<div class="input-group">
							<select class="custom-select" id="p_unit" name="p_unit" ng-model="data.p_unit" ng-required="false" ng-disabled="!db.units || db.units && !data.unit || (db.units && data.unit && !db.bulks)">
								<option ng-if="!db.units || (db.units && data.unit && !db.bulks)" ng-value="undefined">{{string.inLoad}}</option>
								<option ng-if="db.units && !data.unit" ng-value="null">- Select unit first -</option>
								<option ng-if="data.unit && db.bulks" ng-value="null">{{selUnit.name}}</option>
								<option ng-value="{{bulk.id}}" ng-repeat="bulk in db.bulks">{{bulk.name}} ~ [ {{bulk.value}} x {{selUnit.code}} ]</option>
							</select>
							<div class="input-group-append">
								<button class="btn btn-outline-info" data-toggle="tooltip" title="New Sub Unit" ng-disabled="!db.units || db.units && !data.unit || (db.units && data.unit && !db.bulks)" ng-click="showUnitForm({sub: true,data:(db.units | filter:{id:data.unit}:true)[0]})" type="button"><i class="fa fa-plus" aria-hidden="true"></i> </button>
							</div>
						</div>
						<small class="form-text float-left">&nbsp;</small>
						<small class="form-text text-info float-right" ng-messages="form.p_unit.$error">
							<span ng-message="required" class="text-danger" ng-show="form.p_unit.$touched && form.p_unit.$invalid">Required!</span>
							<span ng-message="error" class="text-danger">{{form.p_unit.$error.error}}</span>
						</small>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="form-group">
						<label>Sale Unit</label>
						<div class="input-group">
							<select class="custom-select" class="custom-select" id="s_unit" name="s_unit" ng-model="data.s_unit" ng-required="false" ng-disabled="!db.units || db.units && !data.unit || (db.units && data.unit && !db.bulks)">
								<option ng-if="!db.units || (db.units && data.unit && !db.bulks)" ng-value="undefined">{{string.inLoad}}</option>
								<option ng-if="db.units && !data.unit" ng-value="null">- Select unit first -</option>
								<option ng-if="data.unit && db.bulks" ng-value="null">{{selUnit.name}}</option>
								<option ng-value="{{bulk.id}}" ng-repeat="bulk in db.bulks">{{bulk.name}} ~ [ {{bulk.value}} x {{selUnit.code}} ]</option>
							</select>
							<div class="input-group-append">
								<button class="btn btn-outline-info" data-toggle="tooltip" title="New Sub Unit" ng-click="showUnitForm({sub: true,data:(db.units | filter:{id:data.unit}:true)[0]})" type="button" ng-disabled="!db.units || db.units && !data.unit || (db.units && data.unit && !db.bulks)"><i class="fa fa-plus" aria-hidden="true"></i> </button>
							</div>
						</div>
						<small class="form-text float-left">&nbsp;</small>
						<small class="form-text text-info float-right" ng-messages="form.s_unit.$error">
							<span ng-message="required" class="text-danger" ng-show="form.s_unit.$touched && form.s_unit.$invalid">Required!</span>
							<span ng-message="error" class="text-danger">{{form.s_unit.$error.error}}</span>
						</small>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Mfg. Date</label>
						<div class="input-group">
							<input type="text" class="form-control" name="mfg_date" placeholder="Manufacture date" ng-model="data.mfg_date" ng-patter="pattern6" readonly>
						</div>
						<small class="form-text float-left">&nbsp;</small>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Exp. Date</label>
						<div class="input-group">
							<input type="text" class="form-control" name="exp_date" placeholder="Expiry date" ng-model="data.exp_date" readonly>
						</div>
						<small class="form-text float-left">&nbsp;</small>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Stock Alert Quantity <strong class="text-danger">{{data.alert ? '*' : ''}}</strong></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="btn border" title="Click for enable / disable alert" ng-click="tickAlert()">
									<input type="checkbox" name="alert" ng-model="data.alert" ng-change="tickAlert()">
								</div>
							</div>
							<input type="number" placeholder="Alert quantity" class="form-control" name="alert_quantity" ng-model="data.alert_quantity" ng-pattern="pattern5" ng-change="cAlert()">
						</div>
						<small class="form-text text-muted float-left">Alert {{!data.alert ? 'Disabled' : 'Enabled'}} <span ng-show="data.alert"><i class="far fa-check-circle"></i></span><span ng-hide="data.alert"><i class="far fa-times-circle"></i></span></small>
						<small class="form-text text-info float-right" ng-messages="form.alert_quantity.$error">
							<span ng-message="error" class="text-danger">{{form.alert_quantity.$error.error}}</span>
						</small>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Product Image</label>
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="form-control" id="inputGroupFile01">
								<label class="custom-file-label font-weight-normal" for="inputGroupFile01">-- Select file --</label>
							</div>
						</div>
						<small class="form-text text-muted float-left">(Max. file size - 2mb & Aspect ratio - 1 : 1)</small>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Product Brochure</label>
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="inputGroupFile01">
								<label class="custom-file-label font-weight-normal" for="inputGroupFile01">-- Select file --</label>
							</div>
						</div>
						<small class="form-text text-muted float-left">(Max. file size - 2mb & Allowed types - pdf or doc)</small>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 mb-2">
			<div class="form-row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title text-primary">Default Purchase Information</h5>
							<hr>
							<div class="form-row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Tax Method <strong>*</strong></label>
										<div class="input-group">
											<select class="custom-select" name="tax_method" ng-model="data.tax_method" ng-class="{'is-invalid' : form.tax_method.$touched && form.tax_method.$invalid}" ng-required="true">
												<option value='I'>Inclusive</option>
												<option value='E'>Exclusive</option>
											</select>
										</div>
										<small class="form-text float-left">&nbsp;</small>
										<small class="form-text text-info float-right" ng-messages="form.tax_method.$error">
											<span ng-message="required" class="text-danger" ng-show="form.tax_method.$touched && form.tax_method.$invalid">Required!</span>
											<span ng-message="error" class="text-danger">{{form.tax_method.$error.error}}</span>
										</small>

									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group mb-0">
										<label>Tax Rate</label>
										<div class="input-group">
											<select class="custom-select" name="tax_rate" ng-model="data.tax_rate" ng-disabled="!db.tax_rates" ng-change="__tax_rate()">
												<option ng-if="!db.tax_rates" ng-value="undefined">{{string.inLoad}}</option>
												<option ng-if="db.tax_rates" ng-value="null">-- No Tax --</option>
												<option ng-value="{{tax.id}}" ng-repeat="tax in db.tax_rates">{{tax.name}} ~ {{tax.rate | number:2}} {{tax.type == 'P' ? '%' : '(Fixed Rate)'}}</option>
											</select>
											<div class="input-group-append">
												<button class="btn btn-outline-info" data-toggle="tooltip" title="New Tax Rate" ng-disabled="!db.tax_rates" type="button" ng-click="showTaxForm()"><i class="fa fa-plus" aria-hidden="true"></i> </button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Cost Before Tax</label>
										<div class="input-group">
											<div class="input-group-prepend"> <span class="input-group-text">₹</span> </div>
											<input type="number" ng-min="0" placeholder="Purchase price without tax" class="form-control" ng-class="{ 'is-invalid' : form.cost_bef_tax.$touched && form.cost_bef_tax.$invalid}" name="cost_bef_tax" ng-change="__cost_bef_tax()" ng-model="data.cost_bef_tax">
										</div>
										<small class="form-text float-left">&nbsp;</small>
										<small class="form-text text-info float-right" ng-messages="form.mrp.$error">
											<span ng-message="error" class="text-danger">{{form.mrp.$error.error}}</span>
										</small>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Cost After Tax</label>
										<div class="input-group">
											<div class="input-group-prepend"> <span class="input-group-text">₹</span> </div>
											<input type="number" ng-min="0" placeholder="Purchase price with tax" class="form-control" ng-class="{ 'is-invalid' : form.cost_aft_tax.$touched && form.cost_aft_tax.$invalid}" name="cost_aft_tax" ng-change="__cost_aft_tax()" ng-model="data.cost_aft_tax">
										</div>
										<small class="form-text float-left">&nbsp;</small>
										<small class="form-text text-info float-right" ng-messages="form.mrp.$error">
											<span ng-message="error" class="text-danger">{{form.mrp.$error.error}}</span>
										</small>
									</div>
								</div>
							</div>
							<h5 class="card-title text-primary">Default Selling Information</h5>
							<hr>
							<div class="form-row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Margin % <strong>*</strong>&nbsp;<a href="#"><i class="far fa-question-circle" data-toggle="popover" data-content="Helps to calculate selling price using margin value %."></i></a></label>
										<div class="input-group">
											<input type="number" placeholder="Profit margin %" class="form-control" ng-class="{ 'is-invalid' : form.profit_margin.$touched && form.profit_margin.$invalid}" name="profit_margin" ng-model="data.profit_margin" ng-change="__profit_margin()" ng-disabled="!data.cost_bef_tax" select-on-click>
										</div>
										<small class="form-text float-left">&nbsp;</small>
										<small class="form-text text-info float-right" ng-messages="form.profit_margin.$error">
											<span ng-message="error" class="text-danger">{{form.profit_margin.$error.error}}</span>
										</small>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Selling Price&nbsp;<strong>*</strong>&nbsp;<a href="#"><i class="far fa-question-circle" data-toggle="popover" data-content="Product selling price before auto discount."></i></a></label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">₹</span>
											</div>
											<input type="number" class="form-control" ng-min="0" placeholder="Selling price" name="price" ng-model="data.price" ng-change="__price()" ng-class="{'is-invalid' : (form.price.$touched || form.price.$dirty) && form.price.$invalid,'is-vali' : ((form.price.$touched || form.price.$dirty) && form.price.$valid)}" ng-required="true" ng-readonly="false">
										</div>
										<small class="form-text text-muted float-left">Before auto discount.</small>
										<small class="form-text text-info float-right" ng-messages="form.price.$error">
											<span ng-message="required" class="text-danger" ng-show="form.price.$touched && form.price.$invalid">Required!</span>
											<span ng-message="greater" class="text-danger">Invalid Price or MRP !</span>
											<span ng-message="min" class="text-danger">Price is too low !</span>
											<span ng-message="error" class="text-danger">{{form.price.$error.error}}</span>
										</small>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-lg-4">
									<div class="form-group">
										<label>Auto Discount&nbsp;<a href="#"><i class="far fa-question-circle" data-toggle="popover" data-content="This discount will applied to the product automatically. You can also change this value while selling."></i></a></label>
										<div class="input-group">
											<div class="input-group-prepend"> <span class="input-group-text">₹</span> </div>
											<input type="number" class="form-control" ng-disabled="!data.price" placeholder="Auto discount price" name="auto_discount" ng-model="data.auto_discount" ng-change="__auto_discount()" ng-min="0" ng-class="{'is-invalid' : (form.auto_discount.$touched || form.auto_discount.$dirty) && form.auto_discount.$invalid}">
										</div>
										<small class="form-text float-left">&nbsp;</small>
										<small class="form-text text-info float-right" ng-messages="form.auto_discount.$error">
											<span ng-message="error" class="text-danger">{{form.auto_discount.$error.error}}</span>
										</small>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label>Selling Price&nbsp;<strong>*</strong>&nbsp;<a href="#"><i class="far fa-question-circle" data-toggle="popover" data-content="Product selling price after auto discount."></i></a></label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">₹</span>
											</div>
											<input type="number" class="form-control" ng-min="0" placeholder="-" ng-disabled="!data.price" name="price_aft_disc" ng-model="data.price_aft_disc" ng-change="__price_aft_disc()" ng-class="{'is-invalid' : (form.price_aft_disc.$touched || form.price_aft_disc.$dirty) && form.price_aft_disc.$invalid,'is-vali' : ((form.price_aft_disc.$touched || form.price_aft_disc.$dirty) && form.price_aft_disc.$valid)}" ng-required="true">
										</div>
										<small class="form-text text-muted float-left">After auto discount.</small>
										<small class="form-text text-info float-right" ng-messages="form.price_aft_disc.$error">
											<span ng-message="required" class="text-danger" ng-show="form.price_aft_disc.$touched && form.price_aft_disc.$invalid">Required!</span>
											<span ng-message="greater" class="text-danger">Invalid Price or MRP !</span>
											<span ng-message="min" class="text-danger">Price is too low !</span>
											<span ng-message="error" class="text-danger">{{form.price_aft_disc.$error.error}}</span>
										</small>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label>Tax</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">₹</span>
											</div>
											<input type="number" class="form-control" name="price_tax" ng-model="data.price_tax" ng-readonly="true">
										</div>
										<small class="form-text float-left">&nbsp;</small>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="text-danger">Final Price ({{data.tax_method == 'I' ? 'Inc.' : 'Exc.'}} Tax) <strong>*</strong>&nbsp;<a href="#"><i class="far fa-question-circle" data-toggle="popover" data-content="Final selling price of the product after all calculations."></i></a></label>
										<div class="input-group">
											<div class="input-group-prepend"> <span class="input-group-text">₹</span> </div>
											<input type="number" class="form-control" placeholder="Final selling price" name="final_price" ng-model="data.final_price" ng-min="0" ng-clas="{'is-invalid' : (form.pricet.$touched || form.pricet.$dirty) && form.pricet.$invalid,'is-valid' : ((form.pricet.$touched || form.pricet.$dirty) && form.pricet.$valid)}" ng-required="true" ng-readonly="false">
										</div>
										<small class="form-text float-left">&nbsp;</small>
										<small class="form-text text-info float-right" ng-messages="form.pricet.$error">
											<span ng-message="required" class="text-danger" ng-show="form.pricet.$touched && form.pricet.$invalid">Required!</span>
											<span ng-message="greater" class="text-danger">Invalid Price or MRP !</span>
											<span ng-message="error" class="text-danger">{{form.price.$error.error}}</span>
										</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 mb-2" ng-if="SET.new">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title text-primary">Stock Adjustment</h5>
							<h6 class="card-subtitle text-muted">You can add an opening stock or adjust the current stock.</h6>
							<hr>
							<div class="form-row">
								<div class="col-lg-2">
									<div class="form-group">
										<label>Warehouse</label>
										<div class="input-group">
											<select class="custom-select" ng-model="data.warehouse" name="warehouse" ng-class="{ 'is-invalid' : form.warehouse.$touched && form.warehouse.$invalid}" ng-disabled="!db.warehouses" ng-required="data.ref_no || data.stock_adj_note || data.stock_adj_count">
												<option ng-if=" !db.warehouses" ng-value="undefined">{{string.inLoad}}</option>
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
								<div class="col-lg-2">
									<div class="form-group">
										<label>Opening Stock</label>
										<div class="input-group">
											<input type="number" class='form-control' ng-init="data.stock=0" value="0" ng-model="data.stock" disabled>
										</div>
										<small class="form-text text-muted">This is your current product stock count</small>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>Adjustment Quantity&nbsp;<a href="#"><i class="far fa-question-circle" data-toggle="popover" data-content='Add "-" symbol before the count to deduct stock (Eg: -15.50)'></i></a></label>
										<div class="input-group">
											<input type="number" ng-change="sacChange()" class="form-control" name="stock_adj_count" ng-model="data.stock_adj_count" placeholder="+/-" ng-class="{ 'is-invalid' : form.stock_adj_count.$dirty && form.stock_adj_count.$invalid}" ng-required="data.ref_no || data.stock_adj_note">
										</div>
										<small class="form-text float-left">&nbsp;</small>
										<small class="form-text text-info float-right" ng-messages="form.stock_adj_count.$error">
											<span ng-message="required" class="text-danger" ng-show="form.stock_adj_count.$touched && form.stock_adj_count.$invalid">Required!</span>
											<span ng-message="number" class="text-danger">Invalid input.</span>
											<span ng-message="min" class="text-danger">Inadequate quantity.</span>
											<span ng-message="error" class="text-danger">{{form.stock_adj_count.$error.error}}</span>
										</small>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>Reference No.</label>
										<div class="input-group">
											<input type="text" class='form-control' name="ref_no" ng-model="data.ref_no">

										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>Adustment Note</label>
										<textarea type="text" class="form-control" name="stock_adj_note" placeholder="Type adjustment reason..." ng-model="data.stock_adj_note"></textarea>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>Final Stock</label>
										<div class="input-group">
											<input type="number" name="final_stock" class='form-control' ng-value="data.stock+data.stock_adj_count" disabled>
										</div>
										<small class="form-text text-muted">Stock count after adjustment</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title text-primary">Product POS Settings</h5>
							<h6 class="card-subtitle text-muted">This options are only for product level pos settings.</h6>
							<hr>
							<div class="form-row">
								<div class="col-lg-2">
									<div class="form-group">
										<label>POS Sale</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="btn border" ng-click="dataCheckToggle('sale_enabled')">
													<input type="checkbox" ng-init="data.sale_enabled=true" name="pos_sale" ng-model="data.sale_enabled">
												</div>
											</div>
											<input type="text" placeholder="{{ !data.sale_enabled ? 'Disabled &nbsp;❌' : 'Enabled &nbsp;✅'}}" class='form-control' disabled>
										</div>
										<small class="form-text text-muted">Check box for disable selling this product.</small>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>Minimum Sale Qty.</label>
										<div class="input-group">
											<input type="number" class="form-control" name="pos_min_sale_qty" ng-Model="data.pos_min_sale_qty" ng-min=".0001" ng-class="{ 'is-invalid' : form.pos_min_sale_qty.$dirty && form.pos_min_sale_qty.$invalid}">
										</div>
										<small class="form-text text-muted">Minimum qty. required for the pos cart to sell.</small>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>Maximum Sale Qty.</label>
										<div class="input-group">
											<input type="number" class="form-control" name="pos_max_sale_qty" ng-model="data.pos_max_sale_qty" ng-min="data.pos_min_sale_qty || .0001" ng-class="{ 'is-invalid' : form.pos_max_sale_qty.$dirty && form.pos_max_sale_qty.$invalid}">
										</div>
										<small class="form-text text-muted">Maximum allowed qty. to sell for a single pos sale.</small>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>Product Sale Note</label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<div class="btn border" ng-click="dataCheckToggle('pos_sale_note')">
													<input type="checkbox" ng-init="data.pos_sale_note=false" name="pos_sale_note" ng-model="data.pos_sale_note">
												</div>
											</div>
											<input type="text" placeholder="{{ !data.pos_sale_note ? 'Disabled &nbsp;❌' : 'Enabled &nbsp;✅'}}" class='form-control' disabled>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>Custom Discount</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="btn border" ng-click="dataCheckToggle('pos_sale_custom_discount')">
													<input type="checkbox" ng-init="data.pos_sale_custom_discount=true" name="pos_sale_custom_discount" ng-model="data.pos_sale_custom_discount">
												</div>
											</div>
											<input type="text" placeholder="{{ !data.pos_sale_custom_discount ? 'Disabled &nbsp;❌' : 'Enabled &nbsp;✅'}}" class='form-control' disabled>
										</div>
										<small class="form-text text-muted">Enable for add custom discount in pos.</small>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>Custom Tax</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="btn border" ng-click="dataCheckToggle('pos_sale_custom_tax')">
													<input type="checkbox" ng-init="data.pos_sale_custom_tax=true" name="pos_sale_custom_tax" ng-model="data.pos_sale_custom_tax">
												</div>
											</div>
											<input type="text" placeholder="{{ !data.pos_sale_custom_tax ? 'Disabled &nbsp;❌' : 'Enabled &nbsp;✅'}}" class='form-control' disabled>
										</div>
										<small class="form-text text-muted">Enable for change tax in pos.</small>
									</div>
								</div>
							</div>
							<h6 class="card-subtitle text-muted">Custom Product Data Fields ( for example Serial No. or IMEI etc.)</h6>
							<hr>
							<div class="form-row">
								<div class="col-lg-2">
									<div class="form-group">
										<label>POS Data Field - 1</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Field Name 1" name="pos_data_field_1" ng-model="data.pos_data_field_1">
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>POS Data Field - 2</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Field Name 2" name="pos_data_field_2" ng-model="data.pos_data_field_2">
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>POS Data Field - 3</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Field Name 3" name="pos_data_field_3" ng-model="data.pos_data_field_3">
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>POS Data Field - 4</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Field Name 4" name="pos_data_field_4" ng-model="data.pos_data_field_4">
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>POS Data Field - 5</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Field Name 5" name="pos_data_field_5" ng-model="data.pos_data_field_5">
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>POS Data Field - 6</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Field Name 6" name="pos_data_field_6" ng-model="data.pos_data_field_6">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix pt-3">
		<button type="submit" class="btn float-left" ng-class="{'btn-secondary' : form.$invalid,'btn-info' : form.$valid}"><i class='fa fa-save' aria-hidden='true'></i>&nbsp;&nbsp;{{SET.new || SET.copy ? string.save : string.update}}</button>
		<button type="button" class="btn float-right btn-warning" ng-disabled="form.$pristine" ng-click="reset()">Reset</button>
	</div>
	</form>
</div>