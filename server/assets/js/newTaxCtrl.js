// JavaScript Document
app.controller('newTaxCtrl', ['$scope', '$q', '$http', '$log', '$window', '$sce', '$rootScope', '$filter', '$timeout', function ($scope, $q, $http, $log, $window, $sce, $rootScope, $filter, $timeout) {
	$scope.tax = {}; // form data object
	$scope.SET.taxType = 'P'; // default tax type
	$scope.initNewTaxCtrl = function () {
	}
	$rootScope.$on("showTaxForm", function (event, data) {
		$scope.showTaxForm(data);
	});
	$scope.showTaxForm = function (data = {}) {
		if (data.edit) {
			$scope.tax = angular.copy(data.data);
			$scope.tax.rate = parseFloat(parseFloat(data.data.rate).toFixed(2));
			$scope.tax.db = angular.copy(data.data);
			$scope.tax.db.rate = parseFloat(parseFloat(data.data.rate).toFixed(2));
			$scope.tax.edit = data.edit;
			$scope.setTouched($scope.taxForm);
		}
		else {// new tax
			$scope.tax = {};
			$scope.tax.type = $scope.SET.taxType;
		}
		$timeout(function () { $scope.$digest(); });
		$('#newTaxModal').modal('show');
	}
	$scope.reset = function (all) {
		if (all) {
			$scope.tax = {};
			$scope.taxForm['name'].$setValidity("error", true);
			$scope.taxForm['code'].$setValidity("error", true);
			$scope.taxForm['rate'].$setValidity("error", true);
			$scope.taxForm['type'].$setValidity("error", true);
			$scope.taxForm['description'].$setValidity("error", true);
		}
		else {
			if ($scope.tax.edit) { // reset edit from
				$scope.tax.name = $scope.tax.db.name;
				$scope.tax.code = $scope.tax.db.code;
				$scope.tax.rate = parseFloat(parseFloat($scope.tax.db.rate).toFixed(2));
				$scope.tax.type = $scope.tax.db.type;
				$scope.tax.description = $scope.tax.db.description;
			}
			else { // reset new form
				$scope.tax = {};
				$scope.tax.type = $scope.SET.taxType;
			}
		}
		$scope.error = $sce.trustAsHtml(null);
		$scope.taxForm.$setPristine();
		$scope.taxForm.$setUntouched();
	}
	$('#newTaxModal').on('hidden.bs.modal', function (event) {
		$scope.reset(true);
	})
	$scope.hideForm = function () {
		$('#newTaxModal').modal('hide');
	}
	$scope.taxAdded = function (param) {
		$rootScope.$emit("taxAdded", param);
	};
	$scope.taxEdited = function (param) {
		$rootScope.$emit("taxEdited", param);
	};
	/* -------------------------------------------------------------------------------------------- */
	$scope.fdChange = function (field) {
		$scope.taxForm[field].$setValidity("error", true);
		$scope.error = $sce.trustAsHtml(null);
	}
	/* -------------------------------------------------------------------------------------------- */
	$scope.submit = function (event) {
		event.preventDefault();
		$scope.taxForm.submit = true;
		$scope.error = $sce.trustAsHtml(null);
		if ($scope.setTouched($scope.taxForm) === false) {
			delete $scope.taxForm.submit;
			return;
		}
		$http({
			method: $scope.tax.edit ? 'PUT' : 'POST',
			url: $scope.baseUrl + "admin/ajax/tax",
			dataType: 'json',
			data: {
				data: $scope.tax
			},
			headers: {
				"Content-Type": "application/json"
			}
		}).then(function (response) {
			if (response.data.success == true) { // success
				$scope.hideForm(); // hide modal
				$scope.tax.edit ? $scope.taxEdited(response.data) : $scope.taxAdded(response.data);
			} else { // validation error
				if (response.data.errors) { //form errors
					angular.forEach(response.data.errors, function (message, field) {
						$scope.taxForm[field].$setTouched();
						$scope.taxForm[field].$setValidity("error", false);
						$scope.taxForm[field].$error.error = message;
					});
				} else { // other error
					$scope.error = $sce.trustAsHtml(response.data.error);
				}
			}
			delete $scope.taxForm.submit;
		}, function (response) {
			if (response.status) {
				$window.alert("Network Error !");
			} else {
				$window.alert("Script Error !");
			}
			delete $scope.taxForm.submit;
		});
	}
}]);