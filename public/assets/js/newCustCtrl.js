// JavaScript Document
app.controller('newCustCtrl', ['$scope', '$http', '$log', '$window', '$sce', '$rootScope', '$timeout', function ($scope, $http, $log, $window, $sce, $rootScope, $timeout) {
	$scope.SET.DefPriceGroup = 1;
	$scope.initNewCustCtrl = function () {
		$scope.field = {};
	}
	$scope.reset = function (all) {
		$scope.setErrorValid($scope.form);
		if (all) {
			$scope.field = {};
			delete $scope.form.edit;
			delete $scope.form.db;
			$scope.form.$setUntouched();
		}
		else {
			if ($scope.form.edit) { // reset edit form
				$scope.field = angular.copy($scope.form.db);
				$scope.field.db = angular.copy($scope.form.db);
			}
			else { // reset new form
				$scope.field = {};
				$scope.field.phone = $scope.field.email = null;
				$scope.form.$setUntouched();
			}
		}
		$scope.form.$setPristine();
		$scope.form.error = $sce.trustAsHtml(null);
	}
	$('#newCustModal').on('hidden.bs.modal', function (event) {
		$scope.reset(true);
		$timeout(function () { $scope.$digest(); });
	})
	$rootScope.$on("showNewCustForm", function (event, data) {
		$scope.showNewCustForm(data);
	});
	$scope.showNewCustForm = function (data = {}) {
		if (data.edit) {
			$scope.form.edit = data.edit;
			$scope.form.db = angular.copy(data.data);
			$log.log($scope.form);
			//
			$scope.field = angular.copy(data.data); // copy to form fields
			$scope.field.db = angular.copy($scope.form.db);
			$scope.setTouched($scope.form);
		}
		$timeout(function () { $scope.$digest(); });
		$('#newCustModal').modal('show');
	}


	$scope.hideForm = function () { // hide modal
		$('#newCustModal').modal('hide');
	}
	$scope.custAdded = function (param) {
		$rootScope.$emit("custAdded", param);
	};
	$scope.custEdited = function (param) {
		$rootScope.$emit("custEdited", param);
	};
	/* -------------------------------------------------------------------------------------------- */
	$scope.nChange = function () {
		$scope.form['name'].$setValidity("error", true);
	}
	$scope.plChange = function () {
		$scope.form['place'].$setValidity("error", true);
		$scope.form['name'].$setValidity("error", true);
	}
	$scope.eChange = function () {
		$scope.form['email'].$setValidity("error", true);
	}
	$scope.pChange = function () {
		$scope.form['phone'].$setValidity("error", true);
	}
	$scope.aChange = function () {
		$scope.form['address'].$setValidity("error", true);
	}
	/* -------------------------------------------------------------------------------------------- */
	$scope.submit = function ($event) {
		$event.preventDefault();
		$scope.form.submit = true;
		$scope.form.error = $sce.trustAsHtml(null);
		if ($scope.setTouched($scope.form) === false) {
			delete $scope.form.submit;
			return;
		}
		$http({
			method: $scope.form.edit ? 'PUT' : 'POST',
			url: $scope.baseUrl + "admin/ajax/customer",
			dataType: 'json',
			data: {
				data: $scope.field
			},
			headers: {
				"Content-Type": "application/json"
			}
		}).then(function (response) {
			if (response.data.success == true) { // success
				$scope.hideForm();
				$scope.form.edit ? $scope.custEdited(response.data) : $scope.custAdded(response.data);
			} else { // validation error
				if (response.data.errors) { //form errors
					angular.forEach(response.data.errors, function (message, field) {
						$scope.form[field].$setTouched();
						$scope.form[field].$setValidity("error", false);
						$scope.form[field].$error.error = message;
					});
				} else { // other error
					$scope.form.error = $sce.trustAsHtml(response.data.error);
				}
			}
			delete $scope.form.submit;
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
	//$scope.showNewCustForm();
}]);