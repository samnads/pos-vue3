<?php defined('BASEPATH') or exit('No direct script access allowed');
if ($this->uri->segment(3) == 'edit') : ?>
	<script type="text/javascript">
		var edit = true;
		var db = <?php echo json_encode($row); ?>;
		var first_name = '<?php echo $row->first_name; ?>';
		var last_name = '<?php echo $row->last_name; ?>';
		var gender = '<?php echo $row->gender; ?>';
		var email = '<?php echo $row->email; ?>';
		var date_of_birth = '<?php echo $row->date_of_birth; ?>';
		var phone = '<?php echo $row->phone; ?>';
		var place = '<?php echo $row->place; ?>';
		var address = '<?php echo $row->address; ?>';
		var company_name = '<?php echo $row->company_name; ?>';
		var username = '<?php echo $row->username; ?>';
		var role = <?php echo $row->role; ?>;
		var status = "<?php echo $row->status; ?>";
	</script>
<?php endif; ?>
<div ng-controller="newUserCtrl" id="newUserCtrl" ng-init="init()">
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
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<div class="form-row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>First Name *</label>
							<input type="text" ng-model="field.first_name" name="first_name" autocomplete="off" placeholder="First name" class="form-control" ng-class="{'is-invalid' : form.first_name.$touched && form.first_name.$invalid,'is-valid' : form.first_name.$valid}" ng-pattern="pattern.people_name" ng-required="true">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.first_name.$error">
								<span ng-message="required" ng-show="form.first_name.$touched">Required !</span>
								<span ng-message="pattern">Invalid Format !</span>
								<span ng-message="error">{{form.first_name.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" ng-model="field.last_name" name="last_name" autocomplete="off" placeholder="Last name" class="form-control" ng-class="{'is-invalid' : form.last_name.$touched && form.last_name.$invalid,'is-valid' : field.last_name && form.last_name.$valid}" ng-pattern="pattern.people_name" ng-required="false">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.last_name.$error">
								<span ng-message="required" ng-show="form.last_name.$touched">Required !</span>
								<span ng-message="pattern">Invalid Format !</span>
								<span ng-message="error">{{form.last_name.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Gender *</label>
							<div class="input-group">
								<select class="custom-select" ng-model="field.gender" name="gender" ng-class="{'is-invalid' : form.gender.$touched && form.gender.$invalid,'is-valid' : form.gender.$valid}" ng-required="true">
									<option value="">-- Select --</option>
									<option value="M">Male</option>
									<option value="F">Female</option>
									<option value="O">Other</option>
									<option value="N">Not specify</option>
								</select>
							</div>
							<small class="form-text text-danger float-right" ng-messages="form.gender.$error">
								<span ng-message="required" ng-show="form.gender.$touched">Required !</span>
								<span ng-message="error">{{form.gender.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Email *</label>
							<input type="text" ng-model="field.email" name="email" autocomplete="off" placeholder="Email address" class="form-control" ng-class="{'is-invalid' : form.email.$touched && form.email.$invalid,'is-valid' : field.email && form.email.$valid}" ng-pattern="pattern.email" ng-required="true">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.email.$error">
								<span ng-message="required" ng-show="form.email.$touched">Required !</span>
								<span ng-message="pattern">Invalid Format !</span>
								<span ng-message="error">{{form.email.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<label>Date of Birth</label>
						<div class="input-group">
							<input type="text" onkeydown="return false" ng-model="field.date_of_birth" name="date_of_birth" placeholder="Date of birth" class="form-control" ng-class="{'is-invalid' : form.date_of_birth.$touched && form.date_of_birth.$invalid,'is-valid' : field.date_of_birth && form.date_of_birth.$valid}" readonly ng-required="false">
							<div class="input-group-append">
								<span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
							</div>
						</div>
						<small class="form-text float-left">&nbsp;</small>
						<small class="form-text text-danger float-right" ng-messages="form.date_of_birth.$error">
							<span ng-message="pattern">Invalid Format !</span>
							<span ng-message="error">{{form.date_of_birth.$error.error}}</span>
						</small>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Phone *</label>
							<input type="text" ng-model="field.phone" name="phone" autocomplete="off" placeholder="Phone number" class="form-control" ng-class="{'is-invalid' : form.phone.$touched && form.phone.$invalid,'is-valid' : field.phone && form.phone.$valid}" ng-pattern="pattern.phone" ng-required="true">
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
							<textarea type="text" class="form-control" name="address" placeholder="Address" ng-model="field.address" ng-class="{'is-invalid' : !form.address.$error.minlength && form.address.$invalid,'is-valid' : field.address && form.address.$valid}"></textarea>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.address.$error">
								<span ng-message="error">{{form.address.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="form-group">
							<label>Company Name</label>
							<input type="text" ng-model="field.company_name" name="company_name" autocomplete="off" placeholder="Company name" class="form-control" ng-class="{'is-invalid' : form.company_name.$touched && form.company_name.$invalid,'is-valid' : field.company_name && form.company_name.$valid}" ng-required="false">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.company_name.$error">
								<span ng-message="pattern">Invalid Format !</span>
								<span ng-message="error">{{form.company_name.$error.error}}</span>
							</small>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<div class="form-row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Username *</label>
							<input type="text" autocomplete="off" ng-model="field.username" name="username" placeholder="Username" class="form-control" ng-class="{'is-invalid' : form.username.$touched && form.username.$invalid,'is-valid' : form.username.$valid}" ng-pattern="pattern.people_name" ng-required="true">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-danger float-right" ng-messages="form.username.$error">
								<span ng-message="required" ng-show="form.username.$touched">Required !</span>
								<span ng-message="pattern">Invalid Format !</span>
								<span ng-message="error">{{form.username.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Role *</label>
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
					<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<label>Status *</label>
							<div class="input-group">
								<select class="custom-select" ng-model="field.status" name="status" ng-class="{'is-invalid' : form.status.$touched && form.status.$invalid,'is-valid' : form.status.$valid}" ng-required="true">
									<option value="">-- Select --</option>
									<option value="ACTIVE">ACTIVE</option>
									<option value="INACTIVE">INACTIVE</option>
									<option value="PENDING">PENDING</option>
								</select>
							</div>
							<small class="form-text text-danger float-right" ng-messages="form.status.$error">
								<span ng-message="required" ng-show="form.status.$touched">Required !</span>
								<span ng-message="error">{{form.status.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group">
							<b>{{form.edit ? 'New ' : ''}}</b><label>Password *</label>
							<input style="text-security:disc; -webkit-text-security:disc;" ng-model="field.password" name="password" autocomplete="off" placeholder="Password" class="form-control" ng-class="{'is-invalid' : form.password.$touched && form.password.$invalid,'is-valid' : field.password && form.password.$valid}" ng-required="!form.edit">
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
							<input style="text-security:disc; -webkit-text-security:disc;" ng-model="field.r_password" name="r_password" autocomplete="off" ng-blur="passMatch()" placeholder="Password" class="form-control" ng-class="{'is-invalid' : form.r_password.$touched && form.r_password.$invalid,'is-valid' : field.r_password && (field.r_password == field.password)}" ng-required="!form.edit">
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-danger text-danger float-right" ng-messages="form.r_password.$error">
								<span ng-message="required" ng-show="form.r_password.$touched">Required !</span>
								<span ng-message="pattern">Invalid Format !</span>
								<span ng-message="match">Passwords does not match!</span>
								<span ng-message="error">{{form.r_password.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
							</div>
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
								<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12">
				<button type="submit" class="btn" ng-class="{'btn-info' : form.$valid,'btn-secondary' : form.$invalid}" ng-disabled="form.submit">
					<span ng-show="form.submit"><i class="fas fa-spinner fa-spin"></i></span>
					<span ng-hide="form.submit"><i class='fa fa-save' aria-hidden='true'></i></span>
					{{form.edit ? 'Update' : 'Save'}}
				</button>
				<button type="button" class="btn btn-warning float-right" ng-click="reset()" ng-disabled="form.$pristine || form.submit"><i class="fas fa-undo"></i></button>
			</div>
		</div>
	</div>
</div>