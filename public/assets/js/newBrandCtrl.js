// JavaScript Document
app.controller('newBrandCtrl', ['$scope', '$q', '$http', '$log', '$window', '$sce', '$rootScope', '$filter', '$timeout', '$location', function ($scope, $q, $http, $log, $window, $sce, $rootScope, $filter, $timeout, $location) {
	$scope.brand = {}; // form data
	$scope.initialise = function () {
	};
	$rootScope.$on("show_createBrandModal", function (event, data) {
		$scope.show_createBrandModal(data);
	});
	$scope.show_createBrandModal = function (data = {}) {
		if (data.edit) { // edit brand
			$scope.brand = angular.copy(data.data); // copy from db
			$scope.brand.db = angular.copy(data.data); // svae for future
			$scope.brand.edit = data.edit; // is edit ?
			$scope.setTouched($scope.brandForm);
		}
		else { // new brand
			$scope.brand = {};
		}
		$timeout(function () { $scope.$digest(); });
		$('#brandInfo').modal('hide');
		$('#newBrand').modal('show');
	}
	/* -------------------------------------------------------------------------------------------- */ // reset form
	$scope.reset = function (all) {
		if (all) {
			$scope.brand = {};
			$scope.brandForm['name'].$setValidity("error", true);
			$scope.brandForm['code'].$setValidity("error", true);
			$scope.brandForm['description'].$setValidity("error", true);
			$timeout(function () { $scope.$digest(); });
		}
		else {
			if ($scope.brand.edit) { // reset edit from
				$scope.brand.name = $scope.brand.db.name;
				$scope.brand.code = $scope.brand.db.code;
				$scope.brand.description = $scope.brand.db.description;
			}
			else { // reset new form
				$scope.brand = {};
			}
		}
		$scope.error = $sce.trustAsHtml(null);
		$scope.brandForm.$setPristine();
		$scope.brandForm.$setUntouched();
	}
	$scope.hide = function () {
		$('#newBrand').modal('hide');
	}
	$('#newBrand').on('hidden.bs.modal', function (event) {
		$scope.reset(true);
	})
	/* -------------------------------------------------------------------------------------------- */ // watch all form fields
	$scope.$watch('brand.name', function (newValue, oldValue) {
		$scope.brandForm['name'].$setValidity("error", true);
		$scope.error = $sce.trustAsHtml(null);
	});
	$scope.$watch('brand.code', function (newValue, oldValue) {
		$scope.brandForm['code'].$setValidity("error", true);
		$scope.error = $sce.trustAsHtml(null);
	});
	$scope.$watch('brand.description', function (newValue, oldValue) {
		$scope.brandForm['description'].$setValidity("error", true);
		$scope.error = $sce.trustAsHtml(null);
	});
	/* -------------------------------------------------------------------------------------------- */ // to call parent after add
	$scope.brandAdded = function (data) {
		$rootScope.$emit("brandAdded", data);
	};
	/* -------------------------------------------------------------------------------------------- */ // add or update
	$scope.submit = function (event) {
		event.preventDefault();
		$scope.brandForm.submit = true;
		$scope.error = $sce.trustAsHtml(null);
		if ($scope.setTouched($scope.brandForm) === false) {
			delete $scope.brandForm.submit;
			//return;
		}
		$http({
			method: $scope.brand.edit ? 'PUT' : 'POST',
			url: $scope.baseUrl + "admin/ajax/brand",
			dataType: 'json',
			data: {
				data: $scope.brand
			},
			headers: { "Content-Type": "application/json" }
		}).then(function (response) {
			if (response.data.success == true) { // success
				$scope.hide(); // hide modal
				$scope.brand.edit ? $scope.brandEdited(response.data) : $scope.brandAdded(response.data);
			} else { // validation error
				if (response.data.errors) { //form errors
					angular.forEach(response.data.errors, function (message, field) {
						$scope.brandForm[field].$setTouched();
						$scope.brandForm[field].$setValidity("error", false);
						$scope.brandForm[field].$error.error = message;
					});
				} else { // other error
					$scope.error = $sce.trustAsHtml(response.data.error);
				}
			}
			delete $scope.brandForm.submit;
		}, function (response) {
			if (response.status) {
				$window.alert("Network Error !");
			} else {
				$window.alert("Script Error !");
			}
			delete $scope.brandForm.submit;
		});
	}
}]);