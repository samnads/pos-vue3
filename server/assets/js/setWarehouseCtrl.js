app.controller("setWarehouseCtrl", ['$scope', '$http', '$log', '$window', '$document', '$timeout', '$rootScope', '$cookies', '$filter', '$localStorage', '$q', function ($scope, $http, $log, $window, $document, $timeout, $rootScope, $cookies, $filter, $localStorage, $q) {
	$scope.tableWarehouses = function (data = {}) {
		$scope.db.warehouses = undefined;
		$http({
			method: "GET",
			url: $scope.baseUrl + "admin/ajax/warehouse",
			dataType: 'json',
			params: {
				action: 'datatable',
				query: data.search
			},
			headers: {
				"Content-Type": "application/json"
			}
		}).then(function (response) {
			response = response.data
			if (response.success == true) {
				$scope.db.warehouses = response.data;
			} else {
				$scope.showAlert(response);
			}
		}, function (response) { });
	};
	$scope.newWarehouse = function (data) {
		$rootScope.$emit("newWarehouse", data);
	};
	$rootScope.$on("warehouseAdded", function (event, data) { // new tax added
		$scope.tableWarehouses();
	});
	$scope.initialise = function () {
		$scope.tableWarehouses();
	}
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.info = function (index, id) { // show cat info modal
		$scope.temp = $filter('filter')($scope.brands, { id: id }, true);
		$scope.brand = $scope.temp[0];
		$scope.brand.$index = index;
		$('#brandInfo').modal('show');
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.confDel = function (index, data) { // show confirm box
		$scope.temp = $filter('filter')($scope.db.warehouses, { id: data.id }, true);
		$scope.delete.warehouse = $scope.temp[0];
		$('#singDel').modal('show');
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.confDelInfo = function () { // hide info & show confirm box
		$('#brandInfo').modal('hide') && $('#singDel').modal('show');
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.delete = function () { // do delete cats
		$http({ // delete from server
			method: "DELETE",
			url: $scope.baseUrl + "admin/ajax/warehouse",
			dataType: 'json',
			data: {
				action: 'delete',
				data: $scope.delete.warehouse
			},
			headers: {
				"Content-Type": "application/json"
			}
		}).then(function (response) {
			if (response.data.success == true) { // delete success
			} else {
			}
			$scope.tableWarehouses();
			$scope.mkAlert(response.data);
			$('#singDel').modal('hide');
		}, function (response) { });
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$document.ready(function () {
	});
}]);