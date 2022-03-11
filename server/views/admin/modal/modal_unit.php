<div class="modal" id="newUnitModal" tabindex="-1" aria-hidden="true" data-backdrop="static" ng-controller="newUnitCtrl" ng-init="initialise()">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content"> <?php echo form_open('', array('id' => 'unitForm', 'name' => 'unitForm', 'ng-submit' => 'submit($event)', 'role' => 'form', 'novalidate' => '')); ?>
			<div class="modal-header">
				<h5 class="modal-title">{{newUnit.edit ? 'Edit' : 'New'}} {{newUnit.sub ? 'Sub' : ''}} Unit <span class="badge badge-light" ng-if="newUnit.edit">{{newUnit.db.name}}</span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="hideForm()"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="alert alert-danger" role="alert" ng-show="unitForm.error">
				<span ng-bind-html="unitForm.error"></span>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-lg-6" ng-show="newUnit.sub">
						<div class="form-group">
							<label>Base Unit *</label>
							<div class="input-group">
								<input type="text" class="form-control" ng-value="(newUnit.unit.name || newUnit.db.unit_name)+' ( '+(newUnit.unit.code || newUnit.db.unit_code)+' )'" ng-disabled="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
						</div>
					</div>
					<div class="col-lg-6" ng-show="newUnit.sub">
						<div class="form-group">
							<label>Quantity *</label>
							<div class="input-group">
								<input type="number" class="form-control" placeholder="Quantity" name="value" ng-model="newUnit.value" ng-class="(unitForm.value.$touched && unitForm.value.$invalid) ? 'is-invalid' : ((unitForm.value.$touched && unitForm.value.$valid) ? 'is-valid' : '')" ng-chang="fdChange('value')" ng-required="newUnit.sub">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="unitForm.value.$error">
								<span ng-message="required" class="text-danger" ng-show="unitForm.value.$touched && unitForm.value.$invalid">Required!</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{unitForm.value.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Name *</label>
							<div class="input-group">
								<input type="text" class="form-control" name="name" placeholder="Unit name" ng-model="newUnit.name" ng-pattern="pattern8" ng-class="(unitForm.name.$touched && unitForm.name.$invalid) ? 'is-invalid' : ((unitForm.name.$touched && unitForm.name.$valid) ? 'is-valid' : '')" ng-chang="fdChange('name')" ng-maxlength="50" ng-required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="unitForm.name.$error">
								<span ng-message="required" class="text-danger" ng-show="unitForm.name.$touched && unitForm.name.$invalid">Required!</span>
								<span ng-message="minlength">Required minimum length 3 !</span>
								<span ng-message="maxlength">Allowed maximum length 50 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{unitForm.name.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Code *</label>
							<div class="input-group">
								<input type="text" class="form-control" name="code" placeholder="Unit code" ng-model="newUnit.code" ng-pattern="pattern4" ng-class="(unitForm.code.$touched && unitForm.code.$invalid) ? 'is-invalid' : (unitForm.code.$touched && unitForm.code.$valid) ? 'is-valid' : ''" ng-chang="fdChange('code')" ng-maxlength="10" ng-required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="unitForm.code.$error">
								<span ng-message="required" class="text-danger" ng-show="unitForm.code.$touched && unitForm.code.$invalid">Required!</span>
								<span ng-message="minlength">Required minimum length 1 !</span>
								<span ng-message="maxlength">Allowed maximum length 10 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{unitForm.code.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label>Description</label>
							<div class="input-group">
								<textarea type="text" class="form-control" name="description" placeholder="Description" ng-model="newUnit.description" ng-class="(unitForm.description.$touched && unitForm.description.$invalid) ? 'is-invalid' : (unitForm.description.$touched && unitForm.description.$valid && newUnit.description) ? 'is-valid' : ''" ng-chang="fdChange('description')" ng-maxlength="100" ng-required="false"></textarea>
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="unitForm.description.$error">
								<span ng-message="required" class="text-danger" ng-show="unitForm.description.$touched && unitForm.description.$invalid">Required!</span>
								<span ng-message="minlength">Required minimum length 5 !</span>
								<span ng-message="maxlength">Allowed maximum length 100 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{unitForm.description.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-12" ng-show="newUnit.sub">
						<div class="form-group">
							<div class="input-group">
								<input type="text" class="form-control" ng-value="newUnit.value && newUnit.name ? (newUnit.name +' = '+newUnit.value+' x '+newUnit.unit.name) : 'Equation will show here...'" ng-disabled="true">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<span class="mr-auto">
					<button type="button" class="btn btn-outline-danger" data-dismiss="modal" ng-disabled="newUnit.submit"><i class='fa fa-stop align-left' aria-hidden='true'></i>&nbsp;&nbsp;Cancel</button>
					<button type="button" class="btn btn-warning" ng-disabled="unitForm.$pristine || newUnit.submit" ng-click="reset()"><i class="fas fa-undo"></i></button>
				</span>
				<button type="submit" class="btn float-right" ng-class="{'btn-secondary' : unitForm.$invalid,'btn-info' : unitForm.$valid}" ng-disabled="newUnit.submit">
					<span ng-show="newUnit.submit"><i class="fas fa-spinner fa-spin"></i></span>
					<span ng-hide="newUnit.submit"><i class='fa fa-save' aria-hidden='true'></i></span>
					&nbsp;&nbsp;{{newUnit.edit ? string.update : string.save}}
				</button>
			</div>
			</form>
		</div>
	</div>
</div>