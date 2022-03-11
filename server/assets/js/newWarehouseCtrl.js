// JavaScript Document
app.controller('newWarehouseCtrl', ['$scope', '$q', '$http', '$log', '$window', '$sce', '$rootScope', '$filter', '$timeout', '$location', function ($scope, $q, $http, $log, $window, $sce, $rootScope, $filter, $timeout, $location) {
	//$('#newWarehouse').modal('show');
	$rootScope.$on("newWarehouse", function (event, data) {
		$scope.newWarehouse(data);
	});
	$scope.newWarehouse = function (data = {}) {
		if (data.edit) { // edit brand
			$scope.form = angular.copy(data.data); // copy from db
			$scope.form.db = angular.copy(data.data); // svae for future
			$scope.form.edit = data.edit; // is edit ?
		}
		$('#wareHouseInfo').modal('hide');
		$('#newWarehouse').modal('show');
	}
	/* -------------------------------------------------------------------------------------------- */ // reset form
	$scope.reset = function (all) {
		if (all || !$scope.form.edit) {
			$scope.initialise();
		}
		else { // reset to db data
			$scope.form.name = $scope.form.db.name;
			$scope.form.code = $scope.form.db.code;
			$scope.form.phone = $scope.form.db.phone;
			$scope.form.email = $scope.form.db.email;
			$scope.form.address = $scope.form.db.address;
			$scope.form.description = $scope.form.db.description;
		}
		$scope.newForm.error = $sce.trustAsHtml(null);
		$scope.newForm.$setPristine();
		$scope.newForm.$setUntouched();
	}
	$scope.hide = function () {
		$('#newWarehouse').modal('hide');
	}
	$('#newWarehouse').on('hidden.bs.modal', function (event) {
		$scope.reset(true);
		$timeout(function () { $scope.$digest(); });
	})
	/* -------------------------------------------------------------------------------------------- */ // initialise on load
	$scope.initialise = function () {
		$scope.form = {};
		$scope.form.name = null;
		$scope.form.code = null;
		$scope.form.phone = null;
		$scope.form.email = null;
		$scope.form.address = null;
		$scope.form.description = null;
	};
	/* -------------------------------------------------------------------------------------------- */ // watch all form fields
	$scope.fdChange = function (field) {
		$scope.newForm[field].$setValidity("error", true);
		$scope.newForm.error = $sce.trustAsHtml(null);
	}
	/* -------------------------------------------------------------------------------------------- */ // to call parent after add
	$scope.added = function (data) {
		$rootScope.$emit("warehouseAdded", data);
	};
	/* -------------------------------------------------------------------------------------------- */ // add or update
	$scope.submit = function (event) {
		$scope.form.submit = true;
		event.preventDefault();
		$scope.newForm.error = $sce.trustAsHtml(null);
		if ($scope.setTouched($scope.newForm) === false) {
			delete $scope.form.submit;
			//return;
		}
		$http({
			method: $scope.form.edit ? 'PUT' : 'POST',
			url: $scope.baseUrl + "admin/ajax/warehouse",
			dataType: 'json',
			data: {
				data: $scope.form
			},
			headers: { "Content-Type": "application/json" }
		}).then(function (response) {
			if (response.data.success == true) { // success
				$scope.added(response.data); // make any action from parent ctrl
				$scope.mkAlert(response.data); // show alert
				$scope.hide(); // hide modal
			} else { // validation error
				if (response.data.errors) { //form errors
					angular.forEach(response.data.errors, function (message, field) {
						$scope.newForm[field].$setTouched();
						$scope.newForm[field].$setValidity("error", false);
						$scope.newForm[field].$error.error = message;
					});
				} else { // other error
					$scope.newForm.error = $sce.trustAsHtml(response.data.error);
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
}]);