// JavaScript Document
app.controller('roleNewCtrl', ['$scope', '$http', '$log', '$window', '$sce', '$rootScope', '$timeout', '$document', function ($scope, $http, $log, $window, $sce, $rootScope, $timeout, $document) {
	$scope.init = function () {
		$scope.field = {};
		$scope.rights = {}
		$scope.checkall = {};
		$scope.initFormData();
	}
	$scope.initFormData = function () {
		// rights default
		$scope.rights.product = { GET: false, POST: false, PUT: false, DELETE: false };
		$scope.rights.category = { GET: false, POST: false, PUT: false, DELETE: false };
		$scope.rights.brand = { GET: false, POST: false, PUT: false, DELETE: false };
		$scope.rights.tax = { GET: false, POST: false, PUT: false, DELETE: false };
		$scope.rights.unit = { GET: false, POST: false, PUT: false, DELETE: false };
		$scope.rights.supplier = { GET: false, POST: false, PUT: false, DELETE: false };
		$scope.rights.customer = { GET: false, POST: false, PUT: false, DELETE: false };
		$scope.rights.user = { GET: false, POST: false, PUT: false, DELETE: false };
		$scope.rights.warehouse = { GET: false, POST: false, PUT: false, DELETE: false };
		$scope.rights.role = { GET: false, POST: false, PUT: false, DELETE: false };
		//
		if ($window.edit) { // update role ?
			$scope.field.name = db.name;
			$scope.field.limit = db.limit;
			$scope.field.description = db.description;
			let rights = db.rights;
			angular.forEach(rights, function (action, module) { // loop through modules
				let tc = 0;
				angular.forEach(action, function (value, field) {// loop through actions
					$scope.rights[module][field] = value;
					if (value == true) {
						tc++;
					} else {
					}
				});
				if (Object.keys($scope.rights[module]).length == tc) {
					$('#' + module).prop('indeterminate', false);
					$scope.checkall[module] = true;
				} else if (tc > 0) {
					$('#' + module).prop('indeterminate', true);
				}
				// debug
				if (Object.keys($scope.rights[module]).length != Object.keys(rights[module]).length) {
					$log.log(module + " : Number of rights does NOT matching !")
				}
			});
		} else { // new role ?
			//$scope.field.name = "Test"; // TEST FOR DEFAULT VALUES
			//$scope.field.limit = 10; // TEST FOR DEFAULT VALUES
		}
	}
	$document.ready(function () {
		if ($window.edit) {
			$scope.form.edit = true; // edit form ?
			$scope.$digest();
		}
	});
	$scope.reset = function (all) {
		$scope.setErrorValid($scope.form); // reset server val errors
		$scope.form['limit'].$setValidity("min", true);
		if ($window.edit) {
		}
		else {
			$scope.init();
			angular.forEach($scope.rights, function (action, module) { // clear select box on each module
				$('#' + module).prop('indeterminate', false);
			});
			$scope.form.$setUntouched();
		}
		$scope.initFormData();
		$scope.form.$setPristine();
		$scope.form.error = $sce.trustAsHtml(null);
	}
	$scope.userAdded = function (param) {
	};
	$scope.userEdited = function (param) {
	};
	/* -------------------------------------------------------------------------------------------- */
	$scope.selectAll = function (module) {
		if ($scope.checkall[module] == false) {
			angular.forEach($scope.rights[module], function (value, field) {
				$scope.rights[module][field] = false; // uncheck
			});
		} else {
			angular.forEach($scope.rights[module], function (value, field) {
				$scope.rights[module][field] = true; // check

			});
		}
		$log.log($scope.rights)
	};
	/* -------------------------------------------------------------------------------------------- */
	$scope.select = function (module) { // bulk check / uncheck ui helper
		let count = 0;
		angular.forEach($scope.rights[module], function (value, field) { // loop each rights
			if (value == false) { // not checked
				$scope.checkall[module] = false;
			}
			else { // field checked
				count++; // count checked boxes
			}
		});
		if (count == Object.keys($scope.rights[module]).length) { // all checked
			$('#' + module).prop('indeterminate', false); // partial check
			$scope.checkall[module] = true;
		}
		else if (count > 0) { // some checked
			$('#' + module).prop('indeterminate', true);
		}
		else { // none checked
			$('#' + module).prop('indeterminate', false);
		}
		$log.log($scope.rights);
	};
	$scope.fdChange = function (field) {
		$scope.form[field].$setValidity("error", true);
	}
	/* -------------------------------------------------------------------------------------------- */
	$scope.submit = function ($event) {
		$event.preventDefault();
		$scope.form.submit = true;
		$scope.form.error = $sce.trustAsHtml(null);
		if ($scope.setTouched($scope.form) === false) {
			delete $scope.form.submit;
			//return;
		}
		if ($window.edit) {
			$scope.field.db = db;
		}
		$scope.field.rights = $scope.rights;
		$http({
			method: $window.edit ? 'PUT' : 'POST',
			url: $scope.baseUrl + "admin/ajax/role",
			dataType: 'json',
			data: {
				data: $scope.field
			},
			headers: {
				"Content-Type": "application/json"
			}
		}).then(function (response) {
			if (response.data.success == true) { // success
				$window.location.href = $scope.baseUrl + response.data.location;
			} else { // validation error
				if (response.data.errors) { //form errors
					angular.forEach(response.data.errors, function (message, field) {
						$scope.form[field].$setTouched();
						$scope.form[field].$setValidity("error", false);
						$scope.form[field].$error.error = message;
					});
				} else { // other error
					$scope.showAlert(response.data);
				}
				delete $scope.form.submit;
			}
		}, function (response) {
			if (response.status) {
				$window.alert("Network Error !");
			} else {
				$window.alert("Script Error !");
			}
			delete $scope.form.submit;
		});
	}
}]);

