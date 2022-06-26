<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container" ng-controller="adminLoginCtrl">
	<div class="row">
		<div class="col-sm-12 col-lg-4 col col-md-3"></div>
		<div class="col-sm-12 col-lg-4 col-md-6 bg-secondary rounded pt-3 pb-3 text-center">
			<img src="<?php echo base_url('gd/250/75'); ?>" class="img-fluid">
			<div class="container bg-light mt-3 p-3 rounded">
				<?php echo form_open('', array('id' => 'adminLogin', 'name' => 'loginForm', 'ng-submit' => 'doLogin($event)', 'role' => 'form', 'novalidate' => 'novalidate', 'class' => 'form-group')); ?>
				<div class="text-center mb-2 pt-3">
					<h1 class="h3 font-weight-normal">Login Panel</h1>
					<p>Login to access the dream site...</p>
				</div>
				<div class="input-group mb-3">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fas fa-user"></i>
							</span>
						</div>
						<input type="text" class="form-control is-vali" placeholder="Username" autocomplete="off" ng-readonl="ui.loginLoad" ng-model="loginData.username">
					</div>
				</div>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">
							<i class="fas fa-key"></i>
						</span>
					</div>
					<input type="{{ui.passInpType}}" name="password" class="form-control is-invali" placeholder="Password" autocomplete="off" ng-readonl="ui.loginLoad" ng-model="loginData.password">
					<div class="input-group-append" id="showpass" ng-click="showPass()">
						<span class="input-group-text text-danger" ng-hide="ui.passInpType">
							<i class="fas fa-eye"></i>
						</span>

						<span class="input-group-text" ng-show="ui.passInpType">
							<i class="fas fa-eye-slash"></i>
						</span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="input-group mb-3">
							<div class="input-group-prepend" ng-click="rememberMe()" id="rememberme">
								<div class="input-group-text">
									<input type="checkbox" ng-model="loginData.remember">
								</div>

							</div>
							<div class="input-group-append">
								<span class="input-group-text">Remember Me</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 text-right">
						<button class="btn btn-outline-success" ng-class="{'btn-warning' : ui.loginLoad,'btn-outline-success' : !ui.loginLoad}" ng-disabled="ui.loginLoad">Sign in
							<span ng-hide="ui.loginLoad"><i class="fas fa-sign-in-alt"></i></span>
							<span ng-show="ui.loginLoad">
								<div class="spinner-grow spinner-grow-sm" role="status">
									<span class="sr-only">Loading...</span>
								</div>
							</span>
						</button>
					</div>
				</div>
				</form>
				</container>
				<div uib-alert ng-repeat="alert in alerts" ng-class="'alert alert-dismissible alert-' + (alert.type || 'warning')" close="closeAlert($index)" dismiss-on-timeout="{{alert.timeout}}">
					<span ng-bind-html="alert.message"></span>
				</div>
			</div>
			<div class="col-sm-12 col-lg-4 col-md-3"></div>
		</div>
	</div>
</div>
<style type="text/css">
	.container {
		margin-top: 10%;
	}

	#showpass,
	#rememberme {
		cursor: pointer;
	}

	button .spinner-grow {
		margin-bottom: 2px;
	}
</style>