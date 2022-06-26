<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--- New Customer Modal -->
<div class="modal" id="newCustModal" tabindex="-1" aria-hidden="true" data-backdrop="static" ng-controller="newCustCtrl" ng-init="initNewCustCtrl()">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<?php echo form_open('', array('id' => 'form', 'name' => 'form', 'autocomplete' => 'off', 'ng-submit' => 'submit($event)', 'role' => 'form', 'novalidate' => '')); ?>
			<div class="modal-header">
				<h5 class="modal-title">{{form.edit ? 'Edit' : 'New'}} Customer&nbsp;<span class="badge badge-light" ng-if="form.edit">{{form.db.name}}</span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="alert alert-danger" role="alert" ng-show="form.error">
				<span ng-bind-html="form.error"></span>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Name *</label>
							<input type="text" ng-change="nChange()" ng-model="field.name" name="name" placeholder="Customer Name" class="form-control" ng-class="{'is-invalid' : form.name.$touched && form.name.$invalid,'is-valid' : form.name.$valid}" ng-pattern="pattern.people_name" ng-required="true">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.name.$error">
								<span ng-message="required" class="text-danger" ng-show="form.name.$touched">Required !</span>
								<span ng-message="pattern" class="text-danger">Invalid Format !</span>
								<span ng-message="error" class="text-danger">{{form.name.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Group *</label>
							<select class="custom-select" ng-model="field.group" name="group" ng-class="{ 'is-invalid' : form.group.$touched && form.group.$invalid,'is-valid' : form.group.$valid}" ng-disabled="!customerGroups" ng-required="true">
								<option ng-if="!customerGroups" ng-value>{{string.inLoad}}</option>
								<option ng-if="customerGroups" ng-value="undefined">-- Customer Group --</option>
								<option ng-repeat="group in customerGroups" ng-value="{{group.id}}">{{group.name}} ~ [{{group.percentage | number : 2}} %]</option>
							</select>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.group.$error">
								<span ng-message="required" class="text-danger" ng-show="form.group.$touched">Required !</span>
								<span ng-message="error" class="text-danger">{{form.group.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Place *</label>
							<input type="text" ng-change="plChange()" ng-model="field.place" name="place" placeholder="Place" class="form-control" ng-class="{'is-invalid' : form.place.$touched && form.place.$invalid,'is-valid' : form.place.$valid}" ng-pattern="pattern.place_name" ng-required="true">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.place.$error">
								<span ng-message="required" class="text-danger" ng-show="form.place.$touched">Required !</span>
								<span ng-message="pattern" class="text-danger">Invalid Format !</span>
								<span ng-message="error" class="text-danger">{{form.place.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Email</label>
							<input type="text" ng-change="eChange()" ng-model="field.email" name="email" placeholder="Email Address" class="form-control" ng-class="{'is-invalid' : form.email.$touched && form.email.$invalid,'is-valid' : field.email && form.email.$valid}" ng-pattern="pattern.email">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.email.$error">
								<span ng-message="pattern" class="text-danger">Invalid Format !</span>
								<span ng-message="error" class="text-danger">{{form.email.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Phone</label>
							<input type="text" ng-change="pChange()" ng-model="field.phone" name="phone" placeholder="Phone number" class="form-control" ng-class="{'is-invalid' : form.phone.$touched && form.phone.$invalid,'is-valid' : field.phone && form.phone.$valid}" ng-pattern="pattern.phone">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.phone.$error">
								<span ng-message="pattern" class="text-danger">Invalid Format !</span>
								<span ng-message="error" class="text-danger">{{form.phone.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Address</label>
							<textarea type="text" ng-change="aChange()" class="form-control" name="address" placeholder="Address" ng-model="field.address" ng-class="{'is-invalid' : !form.address.$error.minlength && form.address.$invalid,'is-valid' : field.address && form.address.$valid}"></textarea>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.address.$error">
								<span ng-message="error" class="text-danger">{{form.address.$error.error}}</span>
							</small>
						</div>
					</div>
				</div>
				<p class="text-muted small"><span class="text-danger">*</span>&nbsp;Marked fields are mandatory.</p>
			</div>
			<div class="modal-footer">
				<span class="mr-auto">
					<button type="button" class="btn btn-outline-danger" data-dismiss="modal" ng-disabled="form.submit"><i class='fa fa-stop align-left' aria-hidden='true'></i>&nbsp;&nbsp;Cancel</button>
					<button type="button" class="btn btn-warning" ng-click="reset()" ng-disabled="form.$pristine || form.submit"><i class="fas fa-undo"></i></button>
				</span>
				<button type="submit" class="btn" title="{{form.edit ? 'Save changes' : 'Add supplier'}}" ng-class="{'btn-info' : form.$valid,'btn-secondary' : form.$invalid}" ng-disabled="form.submit">
					<span ng-show="form.submit"><i class="fas fa-spinner fa-spin"></i></span>
					<span ng-hide="form.submit"><i class='fa fa-save' aria-hidden='true'></i></span>
					{{form.edit ? string.update : string.save}}
				</button>
			</div>
			</form>
		</div>
	</div>
</div>