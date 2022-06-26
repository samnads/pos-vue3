// JavaScript Document
app.controller('newCatCtrl', ['$scope', '$q', '$http', '$log', '$window', '$sce', '$rootScope', '$filter', '$timeout', function ($scope, $q, $http, $log, $window, $sce, $rootScope, $filter, $timeout) {
	$scope.field = {}; // for new or sub cat form data
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	$scope.catAdded = function (param) {
		$rootScope.$emit("catAdded", param);
	};
	$scope.subCatAdded = function (param) {
		$rootScope.$emit("subCatAdded", param);
	};
	$scope.catUpdated = function (param) {
		$rootScope.$emit("catUpdated", param);
	};
	$scope.subCatUpdated = function (param) {
		$rootScope.$emit("subCatUpdated", param);
	};
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	$scope.fdChange = function (field) {
		$scope.form[field].$setValidity("error", true);
		$scope.form.error = $sce.trustAsHtml(null);
	}
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	$('#newCatModal').on('hidden.bs.modal', function (event) {
		$scope.reset(true);
		$timeout(function () { $scope.$digest(); });
	})
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	$rootScope.$on("showCatForm", function (event, data = {}) {
		$log.log(data);
		if (data.edit) { // edit
			$scope.form.edit = true;
			$scope.form.db = angular.copy(data.data);
			//
			$scope.field = angular.copy(data.data); // copy to form fields
			$scope.field.db = angular.copy(data.data);
			//
			if (data.sub) {
				$scope.field.category = data.data.id;
				$scope.form.category = data.data.id;
				$scope.form.cat_name = data.data.name; // ui parent cat name
				$scope.debug ? $log.log("Edit Sub Category") : undefined;
			} else {
				$scope.debug ? $log.log("Edit Category") : undefined;
			}
			$scope.setTouched($scope.form);
		}
		else { //new
			if (data.sub) {
				$scope.field.category = data.data.id;
				$scope.form.category = data.data.id;
				$scope.form.cat_name = data.data.name; // ui parent cat name
				$scope.debug ? $log.log("New Sub Category") : undefined;
			}
			else {
				$scope.debug ? $log.log("New Category") : undefined;
			}
		}
		$timeout(function () {
			$scope.$digest();
		});
		$scope.showCatFormModal();
	});
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	$scope.showCatFormModal = function () {
		$('#newCatModal').modal('show');
	}
	$scope.hide = function () {
		$('#newCatModal').modal('hide');
	}
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	$scope.reset = function (all) {
		$scope.setErrorValid($scope.form);
		if (all) {
			$scope.field = {};
			delete $scope.form.edit;
			delete $scope.form.db;
			delete $scope.form.category;
			delete $scope.form.cat_name;
			$scope.form.$setUntouched();
		}
		else {
			if ($scope.form.edit) { // reset edit form
				$scope.field = angular.copy($scope.form.db);
				$scope.field.db = angular.copy($scope.form.db);
				if ($scope.form.category) { // reset sub
					$scope.field.category = $scope.form.category;
				}
				else {
				}
			}
			else { // reset new form
				$scope.field = {};
				$scope.form.$setUntouched();
			}
		}
		$scope.form.$setPristine();
		$scope.form.error = $sce.trustAsHtml(null);
	}
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
	$scope.submit = function (event) {
		event.preventDefault();
		$scope.form.submit = true;
		$scope.form.error = $sce.trustAsHtml(null);
		if ($scope.setTouched($scope.form) === false) {
			delete $scope.form.submit;
			//return;
		}
		$http({
			method: $scope.form.edit ? 'PUT' : 'POST',
			url: $scope.baseUrl + "admin/ajax/category",
			dataType: 'json',
			data: {
				data: $scope.field
			},
			headers: {
				"Content-Type": "application/json"
			}
		}).then(function (response) {
			if (response.data.success == true) { // category added
				if ($scope.form.edit) {
					if ($scope.form.category) {
						$scope.subCatUpdated(response.data);
					} else {
						$scope.catUpdated(response.data);
					}
				} else {
					if ($scope.form.category) {
						$scope.subCatAdded(response.data);
					} else {
						$scope.catAdded(response.data);
					}
				}
				$scope.hide();
			} else {
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
			delete $scope.form.submit;
		});
	};
	//$scope.showCatFormModal();
}]);