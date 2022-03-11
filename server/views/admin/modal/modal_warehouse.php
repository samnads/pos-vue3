<div class="modal" id="newWarehouse" tabindex="-1" aria-hidden="true" data-backdrop="static" ng-controller="newWarehouseCtrl" ng-init="initialise()">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content"> <?php echo form_open('', array('id' => 'newForm', 'name' => 'newForm', 'ng-submit' => 'submit($event)', 'role' => 'form', 'novalidate' => '')); ?>
			<div class="modal-header">
				<h5 class="modal-title">{{form.edit ? 'Edit' : 'New'}} Warehouse{{form.edit ? ' ~ '+form.db.name : ''}} </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="hideForm()"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-lg-6">
						<div class="form-group">
							<label>Name *</label>
							<div class="input-group">
								<input type="text" ng-change="fdChange('name')" class="form-control" name="name" placeholder="Warehouse name" ng-model="form.name" ng-class="(newForm.name.$touched && newForm.name.$invalid) ? 'is-invalid' : ((newForm.name.$touched && newForm.name.$valid) ? 'is-valid' : '')" ng-maxlength="255" ng-required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="newForm.name.$error">
								<span ng-message="required" class="text-danger" ng-show="newForm.name.$touched && newForm.name.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 255 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{newForm.name.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Code *</label>
							<div class="input-group">
								<input type="text" ng-change="fdChange('code')" class="form-control" name="code" placeholder="Warehouse code" ng-model="form.code" ng-class="(newForm.code.$touched && newForm.code.$invalid) ? 'is-invalid' : (newForm.code.$touched && newForm.code.$valid) ? 'is-valid' : ''" ng-maxlength="10" required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="newForm.code.$error">
								<span ng-message="required" class="text-danger" ng-show="newForm.code.$touched && newForm.code.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 10 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{newForm.code.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Phone *</label>
							<div class="input-group">
								<input type="text" ng-change="fdChange('phone')" class="form-control" name="phone" placeholder="Warehouse phone" ng-model="form.phone" ng-pattern="pattern.phone" ng-class="(newForm.phone.$touched && newForm.phone.$invalid) ? 'is-invalid' : ((newForm.phone.$touched && newForm.phone.$valid) ? 'is-valid' : '')" ng-maxlength="50" ng-required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="newForm.phone.$error">
								<span ng-message="required" class="text-danger" ng-show="newForm.phone.$touched && newForm.phone.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 50 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{newForm.phone.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Email *</label>
							<div class="input-group">
								<input type="text" ng-change="fdChange('email')" class="form-control" name="email" placeholder="Warehouse email" ng-model="form.email" ng-pattern="pattern.email" ng-class="(newForm.email.$touched && newForm.email.$invalid) ? 'is-invalid' : (newForm.email.$touched && newForm.email.$valid) ? 'is-valid' : ''" ng-maxlength="255" required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="newForm.email.$error">
								<span ng-message="required" class="text-danger" ng-show="newForm.email.$touched && newForm.email.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 255 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{newForm.email.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label>Address *</label>
							<div class="input-group">
								<textarea type="text" ng-change="fdChange('address')" class="form-control" name="address" placeholder="Warehouse address" ng-model="form.address" ng-class="(newForm.address.$touched && newForm.address.$invalid) ? 'is-invalid' : (newForm.address.$touched && newForm.address.$valid) ? 'is-valid' : ''" ng-maxlength="100" ng-required="true"></textarea>
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="newForm.address.$error">
								<span ng-message="required" class="text-danger" ng-show="newForm.address.$touched && newForm.address.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 100 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{newForm.address.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label>Description</label>
							<div class="input-group">
								<textarea type="text" ng-change="fdChange('description')" class="form-control" name="description" placeholder="Warehouse description" ng-model="form.description" ng-class="(newForm.description.$touched && newForm.description.$invalid) ? 'is-invalid' : (newForm.description.$touched && newForm.description.$valid && brand.description) ? 'is-valid' : ''" ng-maxlength="100"></textarea>
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="newForm.description.$error">
								<span ng-message="required" class="text-danger" ng-show="newForm.description.$touched && newForm.description.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 100 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{newForm.description.$error.error}}</span>
							</small>
						</div>
					</div>
				</div>
				<!--<pre>{{ unitForm.$error | json }}</pre>-->
				<div class="alert alert-danger alert-dismissible fade show" role="alert" ng-show="newForm.error">
					<span ng-bind-html="newForm.error"></span>
				</div>
			</div>
			<div class="modal-footer">
				<span class="mr-auto">
					<button type="button" class="btn btn-outline-danger" data-dismiss="modal" ng-disabled="form.submit"><i class='fa fa-stop align-left' aria-hidden='true'></i>&nbsp;&nbsp;Cancel</button>
					<button type="button" class="btn btn-warning" ng-disabled="newForm.$pristine || form.submit" ng-click="reset()" title="Reset"><i class="fas fa-undo"></i></button>
				</span>
				<button type="submit" class="btn float-right" ng-class="{'btn-secondary' : newForm.$invalid,'btn-info' : newForm.$valid}" ng-disabled="form.submit">
					<span ng-show="form.submit"><i class="fas fa-spinner fa-spin"></i></span>
					<span ng-hide="form.submit"><i class='fa fa-save' aria-hidden='true'></i></span>
					&nbsp;&nbsp;{{form.edit ? string.update : string.save}}
				</button>
			</div>
			</form>
		</div>
	</div>
</div>