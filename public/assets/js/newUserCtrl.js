// JavaScript Document
app.controller('newUserCtrl', ['$scope', '$http', '$log', '$window', '$sce', '$rootScope', '$timeout', '$document', function ($scope, $http, $log, $window, $sce, $rootScope, $timeout, $document) {
	$scope.init = function () {
		$scope.initRoles();
		$scope.field = {}; // form fields
		$scope.initFormData();
	}
	$scope.initFormData = function () {
		if ($window.edit) { // update user ?
			$scope.field.first_name = $window.first_name;
			$scope.field.last_name = $window.last_name;
			$scope.field.gender = $window.gender;
			$scope.field.email = $window.email;
			$scope.field.date_of_birth = $window.date_of_birth;
			$scope.field.phone = $window.phone;
			$scope.field.place = $window.place;
			$scope.field.address = $window.address;
			$scope.field.company_name = $window.company_name;
			$scope.field.username = $window.username;
			$scope.field.role = $window.role;
			$scope.field.status = $window.status;
		} else { // new user ?
			$scope.field.role = 1; // TEST FOR DEFAULT VALUES
			$scope.field.status = "PENDING"; // TEST FOR DEFAULT VALUES
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
		if ($window.edit) {
			$scope.field.password = $scope.field.r_password = null;
			$scope.form['r_password'].$setValidity("match", true);
		}
		else {
			$scope.field = {};
			$scope.field.phone = $scope.field.email = null;
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
	$scope.$watch('field.first_name', function (value) {
		if (value) {
			$scope.form['first_name'].$setValidity("error", true);
		}
	});
	$scope.$watch('field.gender', function (value) {
		if (value) {
			$scope.form['gender'].$setValidity("error", true);
		}
	});
	$scope.$watch('field.email', function (value) {
		if (value) {
			$scope.form['email'].$setValidity("error", true);
		}
	});
	$scope.$watch('field.date_of_birth', function (value) {
		if (value) {
			$scope.form['date_of_birth'].$setValidity("error", true);
		}
	});
	$scope.$watch('field.phone', function (value) {
		if (value) {
			$scope.form['phone'].$setValidity("error", true);
		}
	});
	$scope.$watch('field.username', function (value) {
		if (value) {
			$scope.form['username'].$setValidity("error", true);
		}
	});
	$scope.$watch('field.role', function (value) {
		if (value) {
			$scope.form['role'].$setValidity("error", true);
		}
	});
	$scope.$watch('field.status', function (value) {
		if (value) {
			$scope.form['status'].$setValidity("error", true);
		}
	});
	/* -------------------------------------------------------------------------------------------- */
	$scope.$watch('field.password', function (value) {
		$scope.form['password'].$setValidity("error", true);
		if (value) {
			if (value == $scope.field.r_password) {
				$scope.form['r_password'].$setValidity("match", true);
			}
		}
	});
	$scope.$watch('field.r_password', function (value) {
		$scope.form['password'].$setValidity("error", true);
		if (value) {
			$scope.form['r_password'].$setValidity("match", true);
		}
	});
	$scope.passMatch = function () {
		if ($scope.field.r_password) {
			if ($scope.field.password == $scope.field.r_password) {
				$scope.form['password'].$setValidity("error", true);
				$scope.form['r_password'].$setValidity("match", true);
			} else {
				$scope.form['r_password'].$setValidity("match", false);
			}
		}
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
			$scope.field.db = $window.db;
		}
		$http({
			method: $window.edit ? 'PUT' : 'POST',
			url: $scope.baseUrl + "admin/ajax/user",
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
	/* -------------------------------------------------------------------------------------------- */
	$("[name='date_of_birth']").datepicker({
		format: "dd/mm/yyyy",
		clearBtn: true,
		autoclose: true,
		todayHighlight: true,
		forceParse: false,
	}).change(dateChanged);
	function dateChanged(ev) {
		if ($("[name='date_of_birth']").val()) {
			$scope.field.date_of_birth = $("[name='date_of_birth']").val();
			$scope.form.$setDirty("date_of_birth", true);
			$scope.$digest();
		}
	}
}]);

