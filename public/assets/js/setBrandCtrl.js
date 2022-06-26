app.controller("setBrandCtrl", ['$scope', '$http', '$log', '$window', '$document', '$timeout', '$rootScope', '$cookies', '$filter', '$localStorage', '$q', function ($scope, $http, $log, $window, $document, $timeout, $rootScope, $cookies, $filter, $localStorage, $q) {
	$scope.newBrand = function (data) {
		$rootScope.$emit("show_createBrandModal", data);
	};
	$rootScope.$on("brandAdded", function (event, data) { // new tax added
		$scope.showAlert(data);
		$scope.tableBrands();
	});
	$rootScope.$on("brandEdited", function (event, data) { // new tax added
		$scope.showAlert(data);
		$scope.tableBrands();
	});
	$scope.initialise = function () {
		$scope.SET.defLength = 5;
		$scope.tableBrands();
	}
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.info = function (index, id) { // show cat info modal
		$scope.temp = $filter('filter')($scope.db.brands, { id: id }, true);
		$scope.brand = $scope.temp[0];
		$scope.brand.$index = index;
		$('#brandInfo').modal('show');
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.confDel = function (index, id) { // show confirm box
		$scope.temp = $filter('filter')($scope.db.brands, { id: id }, true);
		$scope.brand = $scope.temp[0];
		$log.log($scope.brand);
		$scope.brand.$index = index;
		$('#singDel').modal('show');
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.confDelInfo = function () { // hide info & show confirm box
		$('#brandInfo').modal('hide') && $('#singDel').modal('show');
	};
	$scope.tableBrands = function (data = {}) {
		$scope.db.brands = undefined;
		$http({
			method: "GET",
			url: $scope.baseUrl + "admin/ajax/brand",
			params: { action: 'datatable', query: data.search },
			headers: {
				"Content-Type": "application/json"
			}
		}).then(function (response) {
			if (response.data.success == true) {
				$scope.db.brands = response.data.data;
			} else {
				$scope.showAlert(response.data);
			}
		}, function (response) { });
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.delete = function () { // do delete cats
		$http({ // delete from server
			method: "DELETE",
			url: $scope.baseUrl + "admin/ajax/brand",
			dataType: 'json',
			data: {
				data: $scope.brand
			},
			headers: {
				"Content-Type": "application/json"
			}
		}).then(function (response) {
			if (response.data.success == true) { // delete success
				$scope.db.brands.splice($scope.brand.$index, 1);
			} else {
			}
			$scope.showAlert(response.data);
			$('#singDel').modal('hide');
		}, function (response) { });
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$document.ready(function () {
	});
}]);