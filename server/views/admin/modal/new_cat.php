<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal" id="newCatModal" tabindex="-1" aria-hidden="true" data-backdro="static" ng-controller="newCatCtrl">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content"> <?php echo form_open('', array('id' => 'form', 'name' => 'form', 'ng-submit' => 'submit($event)', 'role' => 'form', 'novalidate' => '')); ?>
			<div class="modal-header">
				<h5 class="modal-title">{{form.edit ? 'Edit ' : 'New '}}{{form.category ? ' Subcategory' : 'Category'}}&nbsp;<span class="badge badge-light" ng-show="form.edit">{{form.db.name}}</span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="hideCatFormModal()"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="alert alert-danger rounded-0" role="alert" ng-show="form.error">
				<span ng-bind-html="form.error"></span>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="col-lg-12" ng-show="form.category">
						<div class="form-group">
							<label>Parent Category</label>
							<div class="input-group">
								<input type="text" class="form-control" ng-value="form.db.category_name || form.cat_name" ng-disabled="true">
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Name</label>
							<div class="input-group">
								<input type="text" ng-change="fdChange('name')" class="form-control" name="name" placeholder="Category name" ng-model="field.name" ng-pattern="pattern3" ng-class="(form.name.$touched && form.name.$invalid) ? 'is-invalid' : (form.name.$touched && form.name.$valid) ? 'is-valid' : ''" ng-minlength="3" ng-maxlength="50" ng-required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.name.$error">
								<span ng-message="required" class="text-danger" ng-show="form.name.$touched && form.name.$invalid">Required!</span>
								<span ng-message="minlength">Required minimum length 3 !</span>
								<span ng-message="maxlength">Allowed maximum length 50 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{form.name.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Code</label>
							<div class="input-group">
								<input type="text" ng-change="fdChange('code')" class="form-control" name="code" placeholder="Category code" ng-model="field.code" ng-class="(form.code.$touched && form.code.$invalid) ? 'is-invalid' : (form.code.$touched && form.code.$valid) ? 'is-valid' : ''" ng-minlength="1" ng-maxlength="10" ng-required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.code.$error">
								<span ng-message="required" class="text-danger" ng-show="form.code.$touched && form.code.$invalid">Required!</span>
								<span ng-message="minlength">Required minimum length 1 !</span>
								<span ng-message="maxlength">Allowed maximum length 10 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{form.code.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>URL Slug</label>
							<div class="input-group">
								<input type="text" ng-change="fdChange('slug')" class="form-control" name="slug" placeholder="Category slug" ng-model="field.slug" ng-class="(form.slug.$touched && form.slug.$invalid) ? 'is-invalid' : (form.slug.$touched && form.slug.$valid) ? 'is-valid' : ''" ng-minlength="3" ng-maxlength="50" ng-required="true">
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.slug.$error">
								<span ng-message="required" class="text-danger" ng-show="form.slug.$touched && form.slug.$invalid">Required!</span>
								<span ng-message="minlength">Required minimum length 3 !</span>
								<span ng-message="maxlength">Allowed maximum length 50 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{form.slug.$error.error}}</span>
							</small>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label>Image</label>
							<div class="input-group">
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="image" ng-model="field.image">
									<div class="custom-file-label">Choose file</div>
								</div>
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<div class="invalid-feedback d-block" ng-show="errorEEE" ng-bind-html="errorEEE"></div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label>Description</label>
							<div class="input-group">
								<textarea type="text" ng-change="fdChange('description')" class="form-control" name="description" placeholder="Description" ng-model="field.description" ng-class="(form.description.$touched && form.description.$invalid) ? 'is-invalid' : ( field.description) ? 'is-valid' : ''" ng-maxlength="100" ng-required="false"></textarea>
							</div>
							<small class="form-text float-left">&nbsp;</small>
							<small class="form-text text-info float-right" ng-messages="form.description.$error">
								<span ng-message="required" class="text-danger" ng-show="form.description.$touched && form.description.$invalid">Required!</span>
								<span ng-message="maxlength">Allowed maximum length 100 !</span>
								<span ng-message="pattern" class="text-danger">Invalid format !</span>
								<span ng-message="error" class="text-danger">{{form.description.$error.error}}</span>
							</small>
						</div>
					</div>
				</div>
				<p class="text-muted small"><span class="text-danger">*</span>&nbsp;Marked fields are mandatory.</p>
			</div>
			<div class="modal-footer">
				<span class="mr-auto">
					<button type="button" class="btn btn-outline-danger" data-dismiss="modal" ng-disabled="form.submit"><i class='fa fa-stop align-left' aria-hidden='true'></i>&nbsp;&nbsp;Cancel</button>
					<button type="button" class="btn btn-warning" ng-disabled="form.$pristine || form.submit" ng-click="reset()"><i class="fas fa-undo"></i></button>
				</span>
				<button class="btn float-right" ng-class="{'btn-secondary' : form.$invalid,'btn-info' : form.$valid}" type="submit" ng-disabled="form.submit">
					<span ng-show="form.submit"><i class="fas fa-spinner fa-spin"></i></span>
					<span ng-hide="form.submit"><i class='fa fa-save' aria-hidden='true'></i></span>
					{{form.edit ? string.update : string.save}}
				</button>
			</div>
			</form>
		</div>
	</div>
</div>