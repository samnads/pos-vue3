app.controller('printBarcodeCtrl', ['$scope', '$http', '$log', '$window', '$sce', '$filter', '$q', '$document', '$timeout', '$cookies', '$localStorage', function ($scope, $http, $log, $window, $sce, $filter, $q, $document, $timeout, $cookies, $localStorage) {
    $scope.SET.paper = 1; // paper size / style from settings
    $scope.labels = false;
    $scope.size = 0;
    $scope.products = []; // product data for printing
    $scope.reset = function () {
        $scope.initLabStyle();
        $scope.products = [];
        $scope.paper = 0;
        $scope.barForm.$setPristine();
        $scope.barForm.$setUntouched();
    };
    $scope.addProduct = function (ids) {
        $scope.tableLoading = true;
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/product",
            dataType: 'json',
            params: {
                action: 'suggest',
                type: 'auto',
                search: ids
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            console.log(response);
            if (response.data.success == true) {
                $scope.products = response.data['data'];
                $scope.playAudio();
                /*if (angular.isObject(response.data['data'])) { // if result found
                    $scope.result = response.data['data'];
                    $scope.tempProd = $filter('filter')($scope.products, {
                        'id': $scope.result['id']
                    }, true); // search and add to temp if exist
                    if ($scope.tempProd.length > 0) { // already exist in table
                        var index = $scope.products.indexOf($scope.tempProd[0]);
                        $scope.products[index].quantity++; // increase quantity
                    } else {
                        $scope.result.quantity = 1;
                        $scope.products.push($scope.result);
                    }
                    $scope.playAudio();
                }*/
            } else {
                $scope.mkAlertRes(response.data);
                $scope.scrollToTop('html, body');
            }
            $scope.tableLoading = false;
        }, function (response) {
            $scope.tableLoading = false;
        });
    };
    $scope.pChange = function (id) {
        if (id) {
            $scope.paper = $filter('filter')($scope.labels, {
                'id': id
            }, true)[0];
            $scope.size = id;
        } else {
            $scope.paper = undefined;
        }
    };
    $scope.initLabStyle = function (id = $scope.SET.paper) {
        $scope.labels = false;
        $scope.size = 0;
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/label",
            dataType: 'json',
            params: {
                action: 'all'
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            if (response.data.success == true) {
                $scope.labels = response.data['data'];
                $scope.pChange(id);
            } else {
                $scope.mkAlertRes(response.data);
                $scope.scrollToTop('html, body');
            }
        }, function (response) {
            $scope.initLabStyle();
        });
    };
    $scope.cQuantity = function (index, quantity) {
        var revIn = $scope.products.length - index - 1;
        if (quantity >= 1) {
            $scope.products[revIn].quantity = quantity;
        } else if (quantity == null) {
            //$scope.products[revIn].quantity = 1;
        }
    };
    $scope.printStart = function (event) {
        event ? event.preventDefault() : '';
        $window.print();
    };
    $scope.remove = function (index) {
        event.preventDefault()
        if ($scope.products.length > 0) {
            if (index == 'conf') {
                $('#confDelAll').modal('toggle');
            } else if (index == 'ok') {
                $scope.products = [];
                $('#confDelAll').modal('toggle');
            } else {
                var revIn = $scope.products.length - index - 1;
                $scope.products.splice(revIn, 1);
            }
        }
    };
    $("#pSearch").autocomplete({ // search input trigger functions
        minLength: 1,
        delay: 1, // this is in milliseconds
        source: function (request, response) {
            /*$.ajax({
                type: "POST",
                url: $scope.baseUrl + "admin/ajax/product",
                data: JSON.stringify({
                    action: 'suggest',
                    type: 'getall',
                    search: request.term
                }),
                dataType: 'json',
                success: function (data) {
                    if (data.success == true) {
                        $scope.results = data;
                        response($scope.results['data']);
                    } else {
                        $scope.mkAlertRes(data);
                        $scope.scrollToTop('html, body');
                    }
                    return
                },
                error: function (data) {
                    $window.alert("Network Error !");
                    $scope.pSearch = null;
                    $scope.search = false;
                    $timeout(function () {
                        $scope.$digest();
                    });
                },
            });*/
            var $this = $(this);
            var $element = $(this.element);
            var previous_request = $element.data("jqXHR");
            if (previous_request) {
                // a previous request has been made.
                // though we don't know if it's concluded
                // we can try and kill it in case it hasn't
                previous_request.abort();
            }
            // Store new AJAX request
            $element.data("jqXHR", $.ajax({
                type: "GET",
                url: $scope.baseUrl + "admin/ajax/product",
                dataType: "json",
                data: {
                    action: 'suggest',
                    type: 'getall',
                    search: request.term
                },
                success: function (data) {
                    if (data.success == true) {
                        $scope.results = data;
                        response($scope.results['data']);
                    } else {
                        $scope.search = false;
                        $scope.pSearch = null;
                        $scope.mkAlertRes(data);
                        $scope.scrollToTop('html, body');
                    }
                    $timeout(function () {
                        $scope.$digest();
                    });
                    return
                },
                error: function (data) {
                    if (data.statusText === "abort") {

                    } else {
                        if (data.statusText === "error") {
                            $window.alert("Network Error !");
                        }
                        else {
                            $window.alert("Something Wrong !");
                        }
                        $scope.search = false;
                        $scope.pSearch = null;
                    }
                    $timeout(function () {
                        $scope.$digest();
                    });
                },
            }));
        },
        search: function (event, ui) { // search start
            //$log.log('search');
            $scope.search = true;
            $timeout(function () {
                $scope.$digest();
            });
        },
        response: function (event, ui) { // search end
            //$log.log('response');
            $scope.search = false;
            if (ui.content.length == 1) { // only one result
                $scope.tempProd = $filter('filter')($scope.products, {
                    'id': ui.content[0].id
                }, true); // search and add to temp if exist
                if ($scope.tempProd.length == 1) { // prod already exist
                    var index = $scope.products.indexOf($scope.tempProd[0]); // find index
                    $scope.products[index].quantity++; // increase quantity
                } else { // new
                    ui.content[0].quantity = 1;
                    $scope.products.push(ui.content[0]); // add
                }
                $scope.playAudio();
                $(this).autocomplete("close");
                $scope.pSearch = null;
            } else if (ui.content.length == 0) { // no result
                $window.alert("No Products Found !");
                $scope.pSearch = null;
            } else { // many results
            }
            $timeout(function () {
                $scope.$digest();
            });
        },
        select: function (event, ui) { // item clicked
            //$log.log('select');
            $scope.tempProd = $filter('filter')($scope.products, {
                'id': ui.item.id
            }, true); // search and add to temp if exist
            if ($scope.tempProd.length > 0) { // already exist in table
                var index = $scope.products.indexOf($scope.tempProd[0]);
                $scope.products[index].quantity++; // increase quantity
            } else {
                ui.item.quantity = 1;
                $scope.products.push(ui.item);
            }
            $scope.playAudio();
            $timeout(function () {
                $scope.$digest();
            });
        },
        close: function (event, ui) { // list closed
            //$log.log('close');
            $scope.pSearch = null;
            $timeout(function () {
                $scope.$digest();
            });
        },
        change: function (event, ui) {
            //$log.log('change');
            $scope.pSearch = null;
            $timeout(function () {
                $scope.$digest();
            });
        },
        create: function (event, ui) {
            //$log.log('created');
        }
    });
    $document.ready(function () {
        $scope.initLabStyle();
        var tempLabelPrint = $cookies.get('tempLabelPrint'); // product code
        var tempLabelsPrint = $cookies.get('tempLabelsPrint'); // product array
        if ($localStorage.tempLabelsPrint) { // adding multiple product
            $log.log('Adding Product List');
            $scope.addProduct($localStorage.tempLabelsPrint);
        }
    });
    //$scope.printStart(event);
}]);
