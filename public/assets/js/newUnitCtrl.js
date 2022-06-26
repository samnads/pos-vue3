// JavaScript Document
app.controller('newUnitCtrl', ['$scope', '$q', '$http', '$log', '$window', '$sce', '$rootScope', '$filter', '$timeout', function ($scope, $q, $http, $log, $window, $sce, $rootScope, $filter, $timeout) {
	$scope.initialise = function () {
		$scope.newUnit = {};
	};
	$rootScope.$on("showUnitForm", function (event, data) {
		$scope.showUnitForm(data);
	});
	$scope.showUnitForm = function (data = {}) {
		if (data.edit) { // edit
			$scope.newUnit = angular.copy(data.data); // copy to form
			$scope.newUnit.db = angular.copy(data.data); // save for future
			$scope.newUnit.edit = true;
			if (data.sub) { // sub unit
				$scope.newUnit.sub = true;
			}
		}
		else { // new
			if (data.sub) { // sub unit
				$scope.newUnit.unit = angular.copy(data.data); // parent data
				$scope.newUnit.sub = true;
			}
		}
		$timeout(function () { $scope.$apply(); });
		$('#newUnitModal').modal('show');
	}
	$scope.hide = function () {
		$('#newUnitModal').modal('hide');
	}
	/* -------------------------------------------------------------------------------------------- */
	$scope.reset = function (all) {
		if (all) {
			$scope.newUnit = {};
		}
		else {
			if ($scope.newUnit.edit) { // edit
				if ($scope.newUnit.sub) { // sub unit
					$scope.newUnit.value = $scope.newUnit.db.value;
				}
				$scope.newUnit.name = $scope.newUnit.db.name;
				$scope.newUnit.code = $scope.newUnit.db.code;
				$scope.newUnit.description = $scope.newUnit.db.description;
			}
			else { // new
				$scope.newUnit.value = $scope.newUnit.name = $scope.newUnit.code = $scope.newUnit.description = null;
			}
		}
		$scope.unitForm.error = $sce.trustAsHtml(null);
		$scope.unitForm.$setPristine();
		$scope.unitForm.$setUntouched();
		$timeout(function () { $scope.$apply(); });
	}
	/* -------------------------------------------------------------------------------------------- */
	$('#newUnitModal').on('hide.bs.modal', function (event) { // before
		$scope.reset(true);
	})
	$('#newUnitModal').on('hidden.bs.modal', function (event) { // after
	})
	$('#newUnitModal').on('show.bs.modal', function (event) { // before
	})
	$('#newUnitModal').on('shown.bs.modal', function (event) { // after
	})
	/* -------------------------------------------------------------------------------------------- */
	$scope.unitAdded = function (data) {
		$rootScope.$emit("unitAdded", data);
	};
	$scope.unitEdited = function (data) {
		$rootScope.$emit("unitEdited", data);
	};
	$scope.subUnitAdded = function (data) {
		$rootScope.$emit("subUnitAdded", data);
	};
	$scope.subUnitEdited = function (data) {
		$rootScope.$emit("subUnitEdited", data);
	};
	/* -------------------------------------------------------------------------------------------- */ // remove server validate error
	$scope.$watch('newUnit.name', function (newValue, oldValue) {
		$scope.unitForm['name'].$setValidity("error", true);
		$scope.unitForm.error = $sce.trustAsHtml(null);
	});
	$scope.$watch('newUnit.code', function (newValue, oldValue) {
		$scope.unitForm['code'].$setValidity("error", true);
		$scope.unitForm.error = $sce.trustAsHtml(null);
	});
	$scope.$watch('newUnit.description', function (newValue, oldValue) {
		$scope.unitForm['description'].$setValidity("error", true);
		$scope.unitForm.error = $sce.trustAsHtml(null);
	});
	$scope.$watch('newUnit.value', function (newValue, oldValue) {
		$scope.unitForm['value'].$setValidity("error", true);
		$scope.unitForm.error = $sce.trustAsHtml(null);
	});
	/* -------------------------------------------------------------------------------------------- */ // add or update
	$scope.submit = function (event) {
		$scope.newUnit.submit = true;
		event.preventDefault();
		$scope.unitForm.error = $sce.trustAsHtml(null);
		if ($scope.setTouched($scope.unitForm) === false) {
			delete $scope.newUnit.submit;
			//return;
		}
		$http({
			method: $scope.newUnit.edit ? 'PUT' : 'POST',
			url: $scope.baseUrl + "admin/ajax/unit",
			dataType: 'json',
			data: { data: $scope.newUnit },
			headers: { "Content-Type": "application/json" }
		}).then(function (response) {
			if (response.data.success == true) { // success
				if ($scope.newUnit.edit) {
					if ($scope.newUnit.sub) {
						$scope.subUnitEdited(response.data);
						$scope.debug ? $log.log('Edited sub unit') : undefined;
					}
					else {
						$scope.unitEdited(response.data);
						$scope.debug ? $log.log('Edited unit') : undefined;
					}
				} else {
					if ($scope.newUnit.sub) {
						$scope.subUnitAdded(response.data);
						$scope.debug ? $log.log('Added sub unit') : undefined;
					}
					else {
						$scope.unitAdded(response.data);
						$scope.debug ? $log.log('Added unit') : undefined;
					}
				}
				$scope.hide(); // hide modal
			} else { // validation error
				if (response.data.errors) { //form errors
					angular.forEach(response.data.errors, function (message, field) {
						$scope.unitForm[field].$setTouched();
						$scope.unitForm[field].$setValidity("error", false);
						$scope.unitForm[field].$error.error = message;
					});
				} else { // other error
					$scope.unitForm.error = $sce.trustAsHtml(response.data.error);
				}
			}
			delete $scope.newUnit.submit;
		}, function (response) {
			if (response.status) {
				$window.alert("Network Error !");
			} else {
				$window.alert("Script Error !");
			}
			delete $scope.newUnit.submit;
		});
	}
}]);