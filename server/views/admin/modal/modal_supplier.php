<div class="modal" id="newSuppModal" tabindex="-1" aria-hidden="true" data-backdrop="static" ng-controller="newSuppCtrl" ng-init="initNewSuppCtrl()">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content"> <?php echo form_open('', array('id' => 'form', 'name' => 'form', 'ng-submit' => 'submit($event)', 'role' => 'form', 'novalidate' => '')); ?>
			<div class="modal-header">
				<h5 class="modal-title">{{form.edit ? 'Edit' : 'New'}} Supplier&nbsp;<span class="badge badge-light" ng-if="form.edit">{{form.db.name}}</span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="hideForm()"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="alert alert-danger rounded-0" role="alert" ng-show="form.error">
				<span ng-bind-html="form.error"></span>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Supplier Name *</label>
							<div class="input-group">
								<input type="text" class="form-control" ng-change="fdChange('name')" name="name" placeholder="Name" ng-model="field.name" ng-class="(form.name.$touched && form.name.$invalid) ? 'is-invalid' : (form.name.$touched && form.name.$valid ? 'is-valid' : '')" ng-maxlength="200" ng-required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.name.$error">
								<span ng-message="required" class="text-danger" ng-show="form.name.$touched && form.name.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 200 !</span>
								<span ng-message="error" class="text-danger">{{form.name.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Place *</label>
							<div class="input-group">
								<input type="text" class="form-control" ng-change="fdChange('place')" name="place" placeholder="Place" ng-model="field.place" ng-class="(form.place.$touched && form.place.$invalid) ? 'is-invalid' : (form.place.$touched && form.place.$valid) ? 'is-valid' : ''" ng-maxlength="200" ng-required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.place.$error">
								<span ng-message="required" class="text-danger" ng-show="form.place.$touched && form.place.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 200 !</span>
								<span ng-message="error" class="text-danger">{{form.place.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-5 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Phone *</label>
							<div class="input-group">
								<input type="text" class="form-control" ng-change="fdChange('phone')" name="phone" placeholder="Phone" ng-model="field.phone" ng-pattern="pattern.phone" ng-class="(form.phone.$touched && form.phone.$invalid) ? 'is-invalid' : (form.phone.$touched && form.phone.$valid ? 'is-valid' : '')" ng-required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.phone.$error">
								<span ng-message="required" class="text-danger" ng-show="form.phone.$touched && form.phone.$invalid">Required!</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{form.phone.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-5 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>City</label>
							<div class="input-group">
								<input type="text" class="form-control" ng-change="fdChange('city')" name="city" placeholder="City" ng-model="field.city" ng-class="(form.city.$touched && form.city.$invalid) ? 'is-invalid' : (form.city.$valid && field.city ? 'is-valid' : '')" ng-maxlength="200" ng-required="false">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.city.$error">
								<span ng-message="required" class="text-danger" ng-show="form.city.$touched && form.city.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 200 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{form.city.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>PIN Code</label>
							<div class="input-group">
								<input type="number" class="form-control" ng-change="fdChange('pin_code')" name="pin_code" placeholder="PIN" ng-model="field.pin_code" ng-class="(form.pin_code.$touched && form.pin_code.$invalid) ? 'is-invalid' : (form.pin_code.$valid && field.pin_code ? 'is-valid' : '')" ng-maxlength="15" ng-required="false">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.pin_code.$error">
								<span ng-message="required" class="text-danger" ng-show="form.pin_code.$touched && form.pin_code.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 15 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{form.pin_code.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Email</label>
							<div class="input-group">
								<input type="text" ng-pattern="pattern.email" class="form-control" ng-change="fdChange('email')" name="email" placeholder="Email" ng-model="field.email" ng-class="(form.email.$touched && form.email.$invalid) ? 'is-invalid' : (form.email.$valid && field.email ? 'is-valid' : '')" ng-maxlength="200" ng-required="false">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.email.$error">
								<span ng-message="required" ng-show="form.email.$touched && form.email.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 200 !</span>
								<span ng-message="email">Invalid email !</span>
								<span ng-message="pattern">Invalid format !</span>
								<span ng-message="error">{{form.email.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>GST No.</label>
							<div class="input-group">
								<input type="text" class="form-control" ng-change="fdChange('gst_no')" name="gst_no" placeholder="GST No." ng-model="field.gst_no" ng-class="(form.gst_no.$touched && form.gst_no.$invalid) ? 'is-invalid' : (form.gst_no.$valid && field.gst_no ? 'is-valid' : '')" ng-maxlength="100" ng-required="false">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.gst_no.$error">
								<span ng-message="required" class="text-danger" ng-show="form.gst_no.$touched && form.gst_no.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 100 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{form.gst_no.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Tax No.</label>
							<div class="input-group">
								<input type="text" class="form-control" ng-change="fdChange('tax_no')" name="tax_no" placeholder="TAX No." ng-model="field.tax_no" ng-class="(form.tax_no.$touched && form.tax_no.$invalid) ? 'is-invalid' : (form.tax_no.$valid && field.tax_no) ? 'is-valid' : ''" ng-maxlength="100" ng-required="false">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.tax_no.$error">
								<span ng-message="required" class="text-danger" ng-show="form.tax_no.$touched && form.tax_no.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 100 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{form.tax_no.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Address</label>
							<div class="input-group">
								<textarea type="text" class="form-control" ng-change="fdChange('address')" name="address" placeholder="Address" ng-model="field.address" ng-class="(form.address.$touched && form.address.$invalid) ? 'is-invalid' : (form.address.$valid && field.address) ? 'is-valid' : ''" ng-maxlength="250"></textarea>
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.address.$error">
								<span ng-message="required" class="text-danger" ng-show="form.address.$touched && form.address.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 250 !</span>
								<span ng-message="error" class="text-danger">{{form.address.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Description</label>
							<div class="input-group">
								<textarea type="text" class="form-control" ng-change="fdChange('description')" name="description" placeholder="Description" ng-model="field.description" ng-class="(form.description.$touched && form.description.$invalid) ? 'is-invalid' : (form.description.$valid && field.description) ? 'is-valid' : ''" ng-maxlength="250"></textarea>
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.description.$error">
								<span ng-message="required" class="text-danger" ng-show="form.description.$touched && form.description.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 250 !</span>
								<span ng-message="error" class="text-danger">{{form.description.$error.error}}</span>
							</small>
						</div>
					</div>
				</div>
				<p class="text-muted small"><span class="text-danger">*</span>&nbsp;Marked fields are mandatory.</p>
			</div>
			<pre class="d-none">{{field | json}}</pre>
			<div class="modal-footer">
				<span class="mr-auto">
					<button type="button" class="btn btn-outline-danger" data-dismiss="modal" ng-disabled="form.submit"><i class='fa fa-stop align-left' aria-hidden='true'></i>&nbsp;&nbsp;Cancel</button>
					<button type="button" class="btn btn-warning" ng-disabled="form.$pristine || form.submit" ng-click="reset()" title="Reset"><i class=" fas fa-undo"></i></button>
				</span>
				<button type="submit" class="btn" title="{{form.edit ? 'Save changes' : 'Add supplier'}}" ng-class="{'btn-secondary' : form.$invalid,'btn-info' : form.$valid}" ng-disabled="form.submit">
					<span ng-show="form.submit"><i class="fas fa-spinner fa-spin"></i></span>
					<span ng-hide="form.submit"><i class='fa fa-save' aria-hidden='true'></i></span>
					&nbsp;&nbsp;{{form.edit ? string.update : string.save}}
				</button>
			</div>
			</form>
		</div>
	</div>
</div>