<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--- New Customer Modal -->
<div class="modal" id="newUserModal" tabindex="-1" aria-hidden="true" data-backdrop="static" ng-controller="newUserCtrl" ng-init="init()">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<?php echo form_open('', array('id' => 'form', 'name' => 'form', 'autocomplete' => 'off', 'ng-submit' => 'submit($event)', 'role' => 'form', 'novalidate' => '')); ?>
			<div class="modal-header">
				<h5 class="modal-title">{{form.edit ? 'Edit' : 'New'}} User&nbsp;<span class="badge badge-light" ng-if="form.edit">{{form.db.name}}</span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="alert alert-danger" role="alert" ng-show="form.error">
				<span ng-bind-html="form.error"></span>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>First Name *</label>
							<input type="text" ng-model="field.first_name" name="first_name" placeholder="First name" class="form-control" ng-class="{'is-invalid' : form.first_name.$touched && form.first_name.$invalid,'is-valid' : form.first_name.$valid}" ng-pattern="pattern.people_name" ng-required="true">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.first_name.$error">
								<span ng-message="required" ng-show="form.first_name.$touched">Required !</span>
								<span ng-message="pattern">Invalid Format !</span>
								<span ng-message="error">{{form.first_name.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" ng-model="field.last_name" name="last_name" placeholder="Last name" class="form-control" ng-class="{'is-invalid' : form.last_name.$touched && form.last_name.$invalid,'is-valid' : field.last_name && form.last_name.$valid}" ng-pattern="pattern.people_name" ng-required="false">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.last_name.$error">
								<span ng-message="required" ng-show="form.last_name.$touched">Required !</span>
								<span ng-message="pattern">Invalid Format !</span>
								<span ng-message="error">{{form.last_name.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="form-group">
							<label>Company Name</label>
							<input type="text" ng-model="field.company_name" name="company_name" placeholder="Company name" class="form-control" ng-class="{'is-invalid' : form.company_name.$touched && form.company_name.$invalid,'is-valid' : field.company_name && form.company_name.$valid}" ng-required="false">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.company_name.$error">
								<span ng-message="pattern">Invalid Format !</span>
								<span ng-message="error">{{form.company_name.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="form-row">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<label>Username *</label>
								<input type="text" ng-model="field.username" name="username" placeholder="Username" class="form-control" ng-class="{'is-invalid' : form.username.$touched && form.username.$invalid,'is-valid' : form.username.$valid}" ng-pattern="pattern.people_name" ng-required="true">
								<small class="form-text float-left">&nbsp;</small>
								<small class="form-text text-danger float-right" ng-messages="form.username.$error">
									<span ng-message="required" ng-show="form.username.$touched">Required !</span>
									<span ng-message="pattern">Invalid Format !</span>
									<span ng-message="error">{{form.username.$error.error}}</span>
								</small>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<label>Role *</label><span ng-click="initRoles()"><i class="fas fa-sync"></i></span>
								<select class="custom-select" name="role" ng-model="field.role" ng-class="{'is-invalid' : form.role.$touched && form.role.$invalid,'is-valid' : form.role.$valid}" ng-required="true">
									<option ng-if="!db.roles" ng-value>{{string.inLoad}}</option>
									<option ng-if="db.roles" ng-value="undefined">-- Select Role --</option>
									<option ng-repeat="role in db.roles" ng-value="{{role.id}}">{{role.name}}</option>
								</select>
								<small class="form-text float-left">&nbsp;</small>
								<small class="form-text text-info float-right" ng-messages="form.role.$error">
									<span ng-message="required" class="text-danger" ng-show="form.role.$touched">Required !</span>
									<span ng-message="error" class="text-danger">{{form.role.$error.error}}</span>
								</small>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<label>Password *</label>
								<input type="text" ng-model="field.password" name="password" placeholder="Password" class="form-control" ng-class="{'is-invalid' : form.password.$touched && form.password.$invalid,'is-valid' : field.password && form.password.$valid}" ng-required="!form.edit">
								<small class="form-text float-left">&nbsp;</small>
								<small class="form-danger text-danger float-right" ng-messages="form.password.$error">
									<span ng-message="required" ng-show="form.password.$touched">Required !</span>
									<span ng-message="pattern">Invalid Format !</span>
									<span ng-message="error">{{form.password.$error.error}}</span>
								</small>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group">
								<label>Confirm Password *</label>
								<input type="text" ng-model="field.r_password" name="r_password" placeholder="Password" class="form-control" ng-class="{'is-invalid' : form.r_password.$touched && form.r_password.$invalid,'is-valid' : field.r_password && form.r_password.$valid}" ng-required="!form.edit">
								<small class="form-text float-left">&nbsp;</small>
								<small class="form-danger text-danger float-right" ng-messages="form.r_password.$error">
									<span ng-message="required" ng-show="form.r_password.$touched">Required !</span>
									<span ng-message="pattern">Invalid Format !</span>
									<span ng-message="error">{{form.r_password.$error.error}}</span>
								</small>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Email *</label>
							<input type="text" ng-model="field.email" name="email" placeholder="Email address" class="form-control" ng-class="{'is-invalid' : form.email.$touched && form.email.$invalid,'is-valid' : field.email && form.email.$valid}" ng-pattern="pattern.email" ng-required="true">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.email.$error">
								<span ng-message="required" ng-show="form.email.$touched">Required !</span>
								<span ng-message="pattern">Invalid Format !</span>
								<span ng-message="error">{{form.email.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Phone *</label>
							<input type="text" ng-model="field.phone" name="phone" placeholder="Phone number" class="form-control" ng-class="{'is-invalid' : form.phone.$touched && form.phone.$invalid,'is-valid' : field.phone && form.phone.$valid}" ng-pattern="pattern.phone" ng-required="true">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.phone.$error">
								<span ng-message="required" ng-show="form.phone.$touched">Required !</span>
								<span ng-message="pattern">Invalid Format !</span>
								<span ng-message="error">{{form.phone.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Place</label>
							<input type="text" ng-model="field.place" name="place" placeholder="Place" class="form-control" ng-class="{'is-invalid' : form.place.$touched && form.place.$invalid,'is-valid' : field.place && form.place.$valid}" ng-pattern="pattern.place_name" ng-required="false">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.place.$error">
								<span ng-message="pattern">Invalid Format !</span>
								<span ng-message="error">{{form.place.$error.error}}</span>
							</small>
						</div>
					</div>


					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Address</label>
							<textarea type="text" ng-change="aChange()" class="form-control" name="address" placeholder="Address" ng-model="field.address" ng-class="{'is-invalid' : !form.address.$error.minlength && form.address.$invalid,'is-valid' : field.address && form.address.$valid}"></textarea>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.address.$error">
								<span ng-message="error">{{form.address.$error.error}}</span>
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