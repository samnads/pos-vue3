// JavaScript Document
app.controller('newSuppCtrl', ['$scope', '$q', '$http', '$log', '$window', '$sce', '$rootScope', '$filter', '$timeout', function ($scope, $q, $http, $log, $window, $sce, $rootScope, $filter, $timeout) {
	$scope.initNewSuppCtrl = function () {
		$scope.field = {};
	}
	$rootScope.$on("showSuppForm", function (event, data) {
		$scope.showSuppForm(data);
	});
	$scope.showSuppForm = function (data = {}) {
		if (data.edit) {
			$scope.form.edit = data.edit;
			$scope.form.db = angular.copy(data.data);
			$log.log(data.data);
			//
			$scope.field = angular.copy(data.data); // copy to form fields
			$scope.field.db = angular.copy($scope.form.db);
			$scope.setTouched($scope.form);
		}
		$timeout(function () { $scope.$digest(); });
		$('#newSuppModal').modal('show');
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
	$('#newSuppModal').on('hidden.bs.modal', function (event) {
		$scope.reset(true);
		$timeout(function () { $scope.$digest(); });
	})
	$scope.hideForm = function () {
		$('#newSuppModal').modal('hide');
	}
	$scope.supAdded = function (param) {
		$rootScope.$emit("supAdded", param);
	};
	$scope.supEdited = function (param) {
		$rootScope.$emit("supEdited", param);
	};
	/* -------------------------------------------------------------------------------------------- */
	$scope.fdChange = function (field) {
		$scope.form[field].$setValidity("error", true);
		$scope.form.error = $sce.trustAsHtml(null);
	}
	/* -------------------------------------------------------------------------------------------- */
	$scope.submit = function (event) {
		event.preventDefault();
		$scope.form.submit = true;
		$scope.form.error = $sce.trustAsHtml(null);
		if ($scope.setTouched($scope.form) === false) {
			delete $scope.form.submit;
			return;
		}
		$http({
			method: $scope.form.edit ? 'PUT' : 'POST',
			url: $scope.baseUrl + "admin/ajax/supplier",
			dataType: 'json',
			data: {
				data: $scope.field
			},
			headers: {
				"Content-Type": "application/json"
			}
		}).then(function (response) {
			if (response.data.success == true) { // success
				$scope.hideForm(); // hide modal
				$scope.form.edit ? $scope.supEdited(response.data) : $scope.supAdded(response.data);
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
	//$scope.showSuppForm();
}]);