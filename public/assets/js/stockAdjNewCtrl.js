app.controller("listStockAdjCtrl", ['$scope', '$http', '$log', '$window', '$document', '$timeout', '$cookies', '$localStorage', '$filter', '$q', function ($scope, $http, $log, $window, $document, $timeout, $cookies, $localStorage, $filter, $q) {
    $scope.init = function () {
        $scope.SET.defLength = 10;
        $q.all([
            $scope.initWarehouses()
        ]).then(function (response) {
            $scope.initFormData(); // add data to form
        }).catch(function (response) {
            alert("Error : " + response.error);
        });
    };
    $scope.initFormData = function () { // Intialize functions
        $scope.SET.new = true; // new or edit
        $scope.products = []; // product data of adjusts
        $scope.data.warehouse = 20;
    }
    $scope.fdChange = function (field) {
        $scope.form[field].$setValidity("error", true);
    }
    $scope.revIndex = function (index) {
        if (index !== undefined) {
            return $scope.products.length - index - 1; // rev index
        } else {
            return undefined;
        }
    }
    $scope.pdtQtyUpdate = function (index, quantity) {
        var product = $scope.products[index];
        product.quantity = quantity;
        $scope.products[index] = product; // update
        $scope.playAudio();
        $scope.focusById('pSearch');
        $scope.fdChange('quantity' + $scope.revIndex(index));
    }
    $scope.qChange = function (index, input, event) { // update after manual + - qty change
        var ogIndex = index;
        index = $scope.revIndex(index); // rev index
        var quantity;
        input = event.target.value || input; // bug fix - showing undefined after blur on first click on input
        if (input === undefined) { // no input
            $scope.debug ? $log.log("Quantity Invalid : " + input) : undefined;
            alert("Invalid Quantity");
            quantity = 1;
            $('#quantity' + ogIndex).val(quantity).trigger('input'); // bug fix - inp not changing to 1 if already 1
            $scope.form['quantity' + ogIndex].$setValidity("required", true);
        } else if (input == 0) {
            $scope.debug ? $log.log("Quantity == 0 : " + input) : undefined;
            alert("Invalid quantity");
            quantity = 1;
            $('#quantity' + ogIndex).val(quantity).trigger('input'); // bug fix - inp not changing on ui
            $scope.form['quantity' + ogIndex].$setValidity("min", true);
        } else {
            $scope.debug ? $log.log("Quantity Valid : " + input) : undefined;
            quantity = parseFloat(input);
        }
        $scope.pdtQtyUpdate(index, quantity);
    };
    $scope.nChange = function (index, note) { // update anote
        $scope.products[$scope.revIndex(index)].note = note;
        $scope.form['note' + index].$setValidity("error", true);
    };
    $scope.qChangeMinus = function (index, curQty) { // update after manual -
        var ogIndex = index;
        index = $scope.revIndex(index); // rev index
        var quantity = curQty - 1;
        if (quantity == 0 || quantity == undefined) {
            quantity = -1;
        }
        $scope.pdtQtyUpdate(index, quantity);
    };
    $scope.qChangePlus = function (index, curQty) { // update after manual + 
        var ogIndex = index;
        index = $scope.revIndex(index); // rev index    
        var quantity = curQty + 1;
        if (quantity == 0 || quantity == undefined) {
            quantity = 1;
        }
        $scope.pdtQtyUpdate(index, quantity);
    };
    $scope.pushToCart = function (product, index) { // adding product to list  and calc things
        if ($scope.products[index]) {
            product.quantity = $scope.products[index].quantity + 1;
        } else {
            product.quantity = 1;
        }
        product.note = null;
        index === undefined ? $scope.products.push(product) : $scope.products[index] = product;
        $scope.playAudio();
    };
    $scope.finished = function (index) {
        $timeout(function () {
            $scope.form['quantity' + index].$setValidity("required", true);
        });
    }
    $scope.reset = function (all) {
        if (all) {

        }
        else {
            if ($scope.form.edit) { // reset edit from

            }
            else { // reset new form
                $scope.data = {};
                $scope.data.warehouse = null;
                $scope.products = [];
            }
        }
        $scope.form.$setPristine();
        $scope.form.$setUntouched();
    }
    $scope.checkAndPush = function (product) {

        let temp = $filter('filter')($scope.products, { 'id': product.id }, true); // search and add to temp if exist
        if (temp.length > 0) { // already added
            $scope.debug ? $log.log("Product Already Exist : ") + $log.log(product) : undefined;
            let index = $scope.products.indexOf(temp[0]);
            $scope.pushToCart(product, index);
        } else { // add as new
            $scope.debug ? $log.log("New Product : ") + $log.log(product) : undefined;
            $scope.pushToCart(product);
        }
        $scope.focusById('pSearch');
    }
    $('#delProdModal').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var index = button.data('index') // Extract info from data-* attributes
        index = $scope.revIndex(index); // rev index    
        console.log();
        var modal = $(this);
        $scope.ui.sinDelIndex = index;
        modal.find('.modal-body').text($scope.products[index].code + ' | ' + $scope.products[index].name);
    })
    $scope.delProd = function () {
        var index = $scope.ui.sinDelIndex;
        $scope.products.splice(index, 1);
        $('#delProdModal').modal('hide');
        $scope.focusById('pSearch');
    };
    $("#pSearch").autocomplete({ // search input trigger functions
        minLength: 1,
        delay: 1, // this is in milliseconds
        source: function (request, response) {
            var $this = $(this);
            var $element = $(this.element);
            var previous_request = $element.data("jqXHR");
            window.search_term = request.term;
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
                    action: 'autocomplete',
                    type: 'adjustment',
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
                    $scope.debug ? $log.log("Error : ") + $log.log(data) : undefined;
                    if (data.statusText === "abort") {

                    } else {
                        if (data.statusText === "error") {
                            $window.alert("Network Error !");
                        } else {
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
            $timeout(function () {
                $scope.search = true;
            });
        },
        response: function (event, ui) { // search end
            //$log.log('response');
            $scope.search = false;
            if (ui.content.length == 1) { // only one result
                $scope.debug ? $log.log("One Result Found") + $log.log(ui.content[0]) : undefined;
                $scope.checkAndPush(ui.content[0]);
                $(this).autocomplete("close");
                $scope.pSearch = null;
            } else if (ui.content.length == 0) { // no result
                $scope.debug ? $log.log("No Result Found") + $log.log(ui.content) : undefined;
                $window.alert("No product found for your search query \"" + window.search_term + "\" !");
                $scope.pSearch = null;
            } else { // many results
                $scope.debug ? $log.log("Multiple Result Found") + $log.log(ui.content) : undefined;
            }
        },
        select: function (event, ui) { // item clicked
            //$log.log('select');
            $scope.checkAndPush(ui.item);
        },
        close: function (event, ui) { // list closed
            //$log.log('close');
            $timeout(function () {
                $scope.pSearch = null;
            });
        },
        change: function (event, ui) {
            //$log.log('change');
            $scope.pSearch = null;
        },
        create: function (event, ui) {
            //$log.log('created');
        }
    });
    // submit
    $scope.submit = function (event) {
        event.preventDefault();
        if ($scope.setTouched($scope.form) === false) {
            return;
        }
        if ($scope.SET.edit) {
            $scope.data.db = db;
        }
        else {
            $scope.data.products = $scope.products
        }
        $http({
            method: $scope.SET.new || $scope.SET.copy ? "POST" : "PUT",
            url: $scope.baseUrl + "admin/ajax/stock_adjustment",
            dataType: 'json',
            data: {
                data: $scope.data
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            if (response.data.success == true) { // success
                response.data.location ? ($window.location.href = $scope.baseUrl + response.data.location) : $scope.mkAlert(response.data);
            } else { // validation error
                if (response.data.errors) { //form errors
                    angular.forEach(response.data.errors, function (message, field) {
                        $scope.form[field].$setTouched();
                        $scope.form[field].$setValidity("error", false); // manual error
                        $scope.form[field].$error.error = message; // manual error message
                    });
                } else { // other error
                    $scope.mkAlert(response.data);
                }
            }
        }, function (response) { });
    }
    $document.ready(function () {
        $("[name='date']").datepicker({
            format: "dd-mm-yyyy",
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
            toggleActive: true,
            todayBtn: "linked",
        }).on('changeDate', function (e) {
            $scope.data.date = e.format();
            $scope.form.$setDirty("date", true);
            $scope.form['date'].$setValidity("error", true);
            $timeout(function () { $scope.$digest(); });
        });
    });
}]);