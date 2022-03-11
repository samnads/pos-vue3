<div class="modal" id="newTaxModal" tabindex="-1" aria-hidden="true" data-backdrop="static" ng-controller="newTaxCtrl" ng-init="initNewTaxCtrl()">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content"> <?php echo form_open('', array('id' => 'taxForm', 'name' => 'taxForm', 'ng-submit' => 'submit($event)', 'role' => 'form', 'novalidate' => '')); ?>
			<div class="modal-header">
				<h5 class="modal-title">{{tax.edit ? 'Edit' : 'New'}} Tax&nbsp;<span class="badge badge-light" ng-if="tax.edit">{{tax.db.name}}</span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="hideForm()"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-lg-7">
						<div class="form-group">
							<label>Tax Name *</label>
							<div class="input-group">
								<input type="text" class="form-control" ng-change="fdChange('name')" name="name" placeholder="Tax name" ng-model="tax.name" ng-pattern="pattern9" ng-class="(taxForm.name.$touched && taxForm.name.$invalid) ? 'is-invalid' : ((taxForm.name.$touched && taxForm.name.$valid) ? 'is-valid' : '')" ng-minlength="1" ng-maxlength="50" ng-required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="taxForm.name.$error">
								<span ng-message="required" class="text-danger" ng-show="taxForm.name.$touched && taxForm.name.$invalid">Required!</span>
								<span ng-message="minlength">Required minimum length 1 !</span>
								<span ng-message="maxlength">Allowed maximum length 50 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{taxForm.name.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-5">
						<div class="form-group">
							<label>Code *</label>
							<div class="input-group">
								<input type="text" class="form-control" ng-change="fdChange('code')" name="code" placeholder="Tax code" ng-model="tax.code" ng-pattern="pattern4" ng-class="(taxForm.code.$touched && taxForm.code.$invalid) ? 'is-invalid' : (taxForm.code.$touched && taxForm.code.$valid) ? 'is-valid' : ''" ng-minlength="1" ng-maxlength="10" required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="taxForm.code.$error">
								<span ng-message="required" class="text-danger" ng-show="taxForm.code.$touched && taxForm.code.$invalid">Required!</span>
								<span ng-message="minlength">Required minimum length 1 !</span>
								<span ng-message="maxlength">Allowed maximum length 10 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{taxForm.code.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label>Tax Rate *</label>
							<div class="input-group">
								<input type="number" ng-min="0" class="form-control" ng-change="fdChange('rate')" name="rate" placeholder="Tax Rate" ng-model="tax.rate" ng-class="(taxForm.rate.$touched && taxForm.rate.$invalid) ? 'is-invalid' : ((taxForm.rate.$touched && taxForm.rate.$valid) ? 'is-valid' : '')" ng-required="true" />
								<div class="input-group-append">
									<div class="input-group-text">
										<input type="radio" name="type" ng-model="tax.type" ng-change="fdChange('type')" value="P">&nbsp;%
									</div>
								</div>
								<div class="input-group-append">
									<div class="input-group-text">
										<input type="radio" name="type" ng-model="tax.type" ng-change="fdChange('type')" value="F">&nbsp;₹
									</div>
								</div>
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="taxForm.rate.$error">
								<span ng-message="required" class="text-danger" ng-show="taxForm.rate.$touched && taxForm.rate.$invalid">Required!</span>
								<span ng-message="minlength">Required minimum length 1 !</span>
								<span ng-message="maxlength">Allowed maximum length 50 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{taxForm.rate.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label>Description</label>
							<div class="input-group">
								<textarea type="text" class="form-control" ng-change="fdChange('description')" name="description" placeholder="Description" ng-model="tax.description" ng-class="(taxForm.description.$touched && taxForm.description.$invalid) ? 'is-invalid' : (taxForm.description.$touched && taxForm.description.$valid && tax.description) ? 'is-valid' : ''" ng-minlengt="5" ng-maxlength="100"></textarea>
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="taxForm.description.$error">
								<span ng-message="required" class="text-danger" ng-show="taxForm.description.$touched && taxForm.description.$invalid">Required!</span>
								<span ng-message="minlength">Required minimum length 5 !</span>
								<span ng-message="maxlength">Allowed maximum length 100 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{taxForm.description.$error.error}}</span>
							</small>
						</div>
					</div>
				</div>
				<div class="alert alert-danger alert-dismissible fade show" role="alert" ng-show="error">
					<span ng-bind-html="error"></span>
				</div>
			</div>
			<div class="modal-footer">
				<span class="mr-auto">
					<button type="button" class="btn btn-outline-danger" data-dismiss="modal" ng-disabled="taxForm.submit"><i class='fa fa-stop align-left' aria-hidden='true'></i>&nbsp;&nbsp;Cancel</button>
					<button type="button" class="btn btn-warning" ng-disabled="taxForm.$pristine || taxForm.submit" ng-click="reset()"><i class="fas fa-undo"></i></button>
				</span>
				<button type="submit" class="btn float-right" ng-class="{'btn-secondary' : taxForm.$invalid,'btn-info' : taxForm.$valid}" ng-disabled=" taxForm.submit">
					<span ng-show="taxForm.submit"><i class="fas fa-spinner fa-spin"></i></span>
					<span ng-hide="taxForm.submit"><i class='fa fa-save' aria-hidden='true'></i></span>
					&nbsp;&nbsp;{{tax.edit ? string.update : string.save}}
				</button>
			</div>
			</form>
		</div>
	</div>
</div>