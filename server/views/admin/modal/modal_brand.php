<div class="modal" id="newBrand" tabindex="-1" aria-hidden="true" data-backdrop="static" ng-controller="newBrandCtrl" ng-init="initialise()">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content"> <?php echo form_open('', array('id' => 'brandForm', 'name' => 'brandForm', 'ng-submit' => 'submit($event)', 'role' => 'form', 'novalidate' => '')); ?>
			<div class="modal-header">
				<h5 class="modal-title">{{brand.edit ? 'Edit' : 'New'}} Brand&nbsp;<span class="badge badge-light" ng-if="brand.edit">{{brand.db.name}}</span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="hideForm()"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-lg-6">
						<div class="form-group">
							<label>Name *</label>
							<div class="input-group">
								<input type="text" class="form-control" name="name" placeholder="Brand name" ng-model="brand.name" ng-pattern="pattern8" ng-class="(brandForm.name.$touched && brandForm.name.$invalid) ? 'is-invalid' : ((brandForm.name.$touched && brandForm.name.$valid) ? 'is-valid' : '')" ng-maxlength="50" ng-required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="brandForm.name.$error">
								<span ng-message="required" class="text-danger" ng-show="brandForm.name.$touched && brandForm.name.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 50 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{brandForm.name.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Code *</label>
							<div class="input-group">
								<input type="text" class="form-control" name="code" placeholder="Brand code" ng-model="brand.code" ng-pattern="pattern4" ng-class="(brandForm.code.$touched && brandForm.code.$invalid) ? 'is-invalid' : (brandForm.code.$touched && brandForm.code.$valid) ? 'is-valid' : ''" ng-maxlength="10" required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="brandForm.code.$error">
								<span ng-message="required" class="text-danger" ng-show="brandForm.code.$touched && brandForm.code.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 10 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{brandForm.code.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label>Description</label>
							<div class="input-group">
								<textarea type="text" class="form-control" name="description" placeholder="Description" ng-model="brand.description" ng-class="(brandForm.description.$touched && brandForm.description.$invalid) ? 'is-invalid' : (brandForm.description.$touched && brandForm.description.$valid && brand.description) ? 'is-valid' : ''" ng-maxlength="100"></textarea>
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="brandForm.description.$error">
								<span ng-message="required" class="text-danger" ng-show="brandForm.description.$touched && brandForm.description.$invalid">Required!</span>
								<span ng-message="minlength">Required minimum length 5 !</span>
								<span ng-message="maxlength">Allowed maximum length 100 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{brandForm.description.$error.error}}</span>
							</small>
						</div>
					</div>
				</div>
				<!--<pre>{{ unitForm.$error | json }}</pre>-->
				<div class="alert alert-danger alert-dismissible fade show" role="alert" ng-show="error">
					<span ng-bind-html="error"></span>
				</div>
			</div>
			<div class="modal-footer">
				<span class="mr-auto">
					<button type="button" class="btn btn-outline-danger" data-dismiss="modal" ng-disabled="brandForm.submit"><i class='fa fa-stop align-left' aria-hidden='true'></i>&nbsp;&nbsp;Cancel</button>
					<button type="button" class="btn btn-warning" ng-disabled="brandForm.$pristine || brandForm.submit" ng-click="reset()" title="Reset"><i class="fas fa-undo"></i></button>
				</span>
				<button type="submit" class="btn float-right" ng-class="{'btn-secondary' : brandForm.$invalid,'btn-info' : brandForm.$valid}" ng-disabled="brandForm.submit">
					<span ng-show="brandForm.submit"><i class="fas fa-spinner fa-spin"></i></span>
					<span ng-hide="brandForm.submit"><i class='fa fa-save' aria-hidden='true'></i></span>
					&nbsp;&nbsp;{{brand.edit ? string.update : string.save}}
				</button>
			</div>
			</form>
		</div>
	</div>
</div>