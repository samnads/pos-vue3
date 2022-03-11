app.controller('posCtrl', ['$scope', '$http', '$log', '$window', '$sce', '$filter', '$q', '$document', '$timeout', '$cookies', '$localStorage', '$rootScope', function ($scope, $http, $log, $window, $sce, $filter, $q, $document, $timeout, $cookies, $localStorage, $rootScope) {
    $scope.cartInit = function () {
        $scope.cart = []; // cart things
        $scope.cart.tQuantity = $scope.cart.subTotal = $scope.cart.tax = $scope.cart.pDiscount = $scope.cart.total = $scope.cart.discount = $scope.cart.cDiscount = $scope.cart.discType = $scope.cart.subTotalWOPD = 0;
        $scope.cart.shipping = 0;
        $scope.cart.keepData = true;
        $scope.ui = {}; // ui things
        $scope.ui.isCustLock = false;
        $scope.ui.discount = $scope.ui.discType = 0;
        $scope.products = []; // product data of cart
        $scope.debug = true;
        $scope.prodUpdData = {};
        $scope.initCategories({ cat: 1 }); // get categories
        $scope.initBrands();
        $scope.initCustGroups();
        $scope.initTaxRates(); // get tax rates
        //$scope.prodInfoModal(0);
    };
    /****************************************/ // access another controller function
    $scope.showNewCustForm = function (param) { // newCustCtrl.js
        $rootScope.$emit("showNewCustForm", param);
    };
    /****************************************/
    $rootScope.$on("custAdded", function (event, data) { // new customer added
        $scope.playAudio();
        var newOption = new Option(data.data.name + ' ~ ' + data.data.place, data.data.id, false, false);
        $('#select2-customer').append(newOption).val(data.data.id).trigger('change'); // set option on UI
    });
    /****************************************/
    $scope.$watch('products', function (newVal, oldVal) {
        $scope.debug ? $log.log("Products Changed : ") + $log.log($scope.products) : undefined;
        $scope.cart.tQuantity = $scope.cart.subTotal = $scope.cart.subTotalWOPD = $scope.cart.pDiscount = $scope.cart.total = $scope.cart.tax = 0;
        $scope.cart.quantity = $scope.products.length; // total quantity
        angular.forEach($scope.products, function (value, key) { // calculate
            $scope.cart.tQuantity += $scope.products[key].quantity; // total items quantity
            $scope.cart.subTotalWOPD += $scope.products[key].sub_total; // sub total without prod didc
            $scope.cart.subTotal += $scope.products[key].total; // sub total
            $scope.cart.pDiscount += $scope.products[key].discount; // per product total discount
            $scope.cart.tax += $scope.products[key].tax; // total tax
            $scope.cart.total += $scope.products[key].total; // payable amount
        });
        if ($scope.cart.discType == 0) { // calc discount

        } else {
            $scope.cart.cDiscount = ($scope.cart.subTotal * $scope.ui.discountPerc) / 100;
        }
        $scope.calcPayable();
    }, true);
    $scope.test = function () {
        alert('test ok');
    };
    $scope.brandChange = function (id) {
        if (id) {
            alert(id);
        }

    };
    $scope.lockCustInp = function (lock) { // lock customer
        if (lock) {
            $scope.ui.isCustLock = true;
        } else {
            $scope.ui.isCustLock = $scope.ui.isCustLock ? false : true;
        }
    };
    $scope.canBillModal = function () { // show modal
        $('#canBillModal').modal('show');
    };
    $scope.canBill = function () { // show modal
        $scope.cartInit();
        $('#canBillModal').modal('hide');
        $scope.focusById('pSearch');
        $scope.posForm.$setPristine();
        $scope.posForm.$setUntouched();
        $scope.discForm.$setPristine();
        $scope.discForm.$setUntouched();
    };
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
    $scope.viewCust = function () { // show modal

        $('#viewCust').modal('show');
    };
    /**************************************************************************************************/
    $scope.showShipBox = function () { // show modal
        if (!$scope.cart.shipping) {
            $scope.ui.shipping = 0;
        } else {
            $scope.ui.shipping = $scope.cart.shipping;
        }
        $('#shipModal').modal('show');
        $timeout(function () {
            $scope.focusById('shipping', true);
        });
    };
    $scope.updShip = function (event) { // do shipping charge  update
        event.preventDefault();
        $scope.cart.shipping = $scope.ui.shipping;
        $scope.calcPayable();
        $('#shipModal').modal('hide');
    };
    /**************************************************************************************************/
    $scope.showDiscBox = function () { // show modal
        if ($scope.cart.discType == 0) { // fixed
            $scope.ui.discType = '0'; // select fixed button
            $scope.ui.discount = $scope.cart.cDiscount;
        } else { // percentage
            $scope.ui.discType = '1'; // select % button
            $scope.ui.discount = $scope.ui.discountPerc;
        }
        $('#discModal').modal('show');
        $timeout(function () {
            $scope.focusById('discount', true); // bug fix - not selecting input box value
        });
    };
    $scope.updDisc = function (event) { // do discount update
        event.preventDefault();
        if ($scope.ui.discType == 0) { // fixed
            $scope.cart.discType = 0;
            $scope.cart.cDiscount = $scope.ui.discount;
        } else { // percentage
            $scope.cart.discType = 1;
            $scope.ui.discountPerc = $scope.ui.discount;
            $scope.cart.cDiscount = ($scope.cart.subTotal * $scope.ui.discount) / 100; // find % value
        }
        $scope.calcPayable();
        $('#discModal').modal('hide');
        $scope.focusById('pSearch');
    };
    /**************************************************************************************************/
    $scope.calcPayable = function () {
        $scope.cart.discount = $scope.cart.pDiscount + $scope.cart.cDiscount; // total discount
        $scope.cart.total = $scope.cart.subTotalWOPD - $scope.cart.discount; // total pyable
        $scope.cart.total += $scope.cart.shipping;
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
        $scope.lockCustInp(true); // lock after changing cart
        $scope.focusById('pSearch');
    }
    $scope.pushToCart = function (product, index) { // adding product to cart cat and clac things
        $scope.cart.keepData = true;
        if ($scope.cart.keepData && $scope.products[index]) { // if want to keep old prod data
            product.quantity = $scope.products[index].quantity + 1;
            product.price = parseFloat($scope.products[index].price);
            product.unit_discount = parseFloat($scope.products[index].unit_discount || 0);
            product.unit_price = parseFloat($scope.products[index].price - $scope.products[index].unit_discount);
            product.mrp = parseFloat($scope.products[index].mrp);
            // tax data
            product.tax_rate = parseFloat($scope.products[index].tax_rate || 0);
            product.unit_tax = parseFloat((($scope.products[index].unit_price * $scope.products[index].tax_rate) / 100).toFixed(2));
            product.tax = parseFloat(($scope.products[index].unit_tax * product.quantity).toFixed(2))
        } else { // new or update if db changed (don't keep existing data)
            product.quantity = 1;
            product.price = parseFloat(product.price);
            product.unit_discount = parseFloat(product.unit_discount || 0);
            product.unit_price = parseFloat((product.price - product.unit_discount));
            product.mrp = parseFloat(product.mrp);
            // tax data
            product.tax_rate = parseFloat(product.tax_rate || 0);
            product.unit_tax = parseFloat(((product.unit_price * product.tax_rate) / 100).toFixed(2));
            product.tax = parseFloat((product.unit_tax * product.quantity).toFixed(2))
        }
        if (product.tax_method === 'I') {
            product.net_unit_price = product.unit_price;
            product.sub_total = parseFloat((product.unit_price * product.quantity).toFixed(2));
            product.discount = parseFloat(product.unit_discount * product.quantity);
            product.total = parseFloat((product.sub_total).toFixed(2));
        } else if (product.tax_method === 'E') {
            product.net_unit_price = product.unit_price;
            product.sub_total = parseFloat((product.unit_price * product.quantity).toFixed(2));
            product.discount = parseFloat(product.unit_discount * product.quantity);
            product.total = parseFloat((product.sub_total + product.tax).toFixed(2));
        }
        index === undefined ? $scope.products.push(product) : $scope.products[index] = product;
        $scope.playAudio();
    };
    /**************************************************************************************************/ // update product qty
    $scope.qChangeMinus = function (index, curQty) { // update after manual -
        var ogIndex = index;
        index = $scope.revIndex(index); // rev index
        var quantity = curQty - 1;
        if (quantity <= 0 || quantity == undefined) {
            quantity = 1;
        }
        $scope.posForm['quantity' + ogIndex].$setValidity("required", true);
        $scope.pdtQtyUpdate(index, quantity);
    };
    $scope.qChangePlus = function (index, curQty) { // update after manual + 
        var ogIndex = index;
        index = $scope.revIndex(index); // rev index    
        var quantity = curQty + 1;
        $scope.posForm['quantity' + ogIndex].$setValidity("required", true);
        $scope.pdtQtyUpdate(index, quantity);
    };
    $scope.qChange = function (index, input, event) { // update after manual + - qty change
        var ogIndex = index;
        index = $scope.revIndex(index); // rev index
        var quantity;
        input = event.target.value || input; // bug fix - showing undefined after blur on first click on input
        if (input === undefined) { // no input
            $scope.debug ? $log.log("Quantity Invalid : " + input) : undefined;
            alert("Invalid Quantity");
            quantity = 1;
            $('#quantity' + ogIndex).val(quantity).trigger('input'); // bug fix -not changing to 1 if already 1
            $scope.posForm['quantity' + ogIndex].$setValidity("required", true);
        } else if (input <= 0) {
            $scope.debug ? $log.log("Quantity <= 0 : " + input) : undefined;
            alert("Invalid Quantity");
            quantity = 1;
            $('#quantity' + ogIndex).val(quantity).trigger('input'); // bug fix -not changing on ui
            $scope.posForm['quantity' + ogIndex].$setValidity("min", true);
        } else {
            $scope.debug ? $log.log("Quantity Valid : " + input) : undefined;
            quantity = parseFloat(input);
        }
        $scope.pdtQtyUpdate(index, quantity);
    };
    $scope.pdtQtyUpdate = function (index, quantity) {
        var product = $scope.products[index];
        product.quantity = quantity;
        product.sub_total = parseFloat(product.price * quantity);
        product.discount = parseFloat(product.unit_discount * quantity);
        product.total = parseFloat(product.sub_total - product.discount);
        $scope.products[index] = product; // update
        $scope.playAudio();
        $scope.focusById('pSearch');
    }
    /**************************************************************************************************/
    $scope.prodInfoModal = function (index) { // show modal
        index = $scope.revIndex(index); // rev index  
        $scope.product = $scope.products[index];
        $scope.prodUpdData.index = index;
        $scope.prodUpdData.price = $scope.product['price'];
        $scope.prodUpdData.unit_price = $scope.product['unit_price'];
        $scope.prodUpdData.unit_discount = $scope.product['unit_discount'];
        $scope.prodUpdData.discount = $scope.product['discount'];
        $scope.prodUpdData.net_unit_price = $scope.product['net_unit_price'];
        $scope.prodUpdData.quantity = $scope.product['quantity'];
        $scope.prodUpdData.bulk_unit = 0;
        $scope.prodUpdData.sub_total = $scope.product['sub_total'];
        $scope.prodUpdData.tax_method = $scope.product['tax_method'];
        $scope.prodUpdData.tax_id = $scope.product['tax_id'];
        $scope.prodUpdData.tax_rate = $scope.product['tax_rate'];
        $scope.prodUpdData.total = $scope.product['total'];
        $scope.prodUpdData.unit_tax = $scope.product['unit_tax'];
        $scope.prodUpdData.tax = $scope.product['tax'];
        $scope.prodUpdData.bulk_unit = 0;
        $('#prodInfoModal').modal('show');
    };
    $('#prodInfoModal').on('hidden.bs.modal', function () {
        $timeout(function () {
            $scope.prodUpdData = {};
        });
    })
    $scope.prodUpdate = function (event, data) {
        event.preventDefault();
        var product = $scope.products[data.index];
        product.price = data.price;
        product.unit_price = data.unit_price;
        product.unit_discount = data.unit_discount;
        product.discount = data.discount;
        product.quantity = data.quantity;
        product.sub_total = data.sub_total;
        product.tax_method = data.tax_method;
        product.tax_id = data.tax_id;
        product.tax_rate = data.tax_rate;
        product.unit_tax = data.unit_tax;
        product.net_unit_price = data.net_unit_price;
        product.tax = data.tax;
        product.total = data.total;
        $scope.products[data.index] = product;
        $scope.prodUpdData.adjTotal = null;
        $('#prodInfoModal').modal('hide');
    }
    $scope.prodInfoUpdateUpUI = function () {
        $scope.prodUpdData.unit_discount = parseFloat(($scope.prodUpdData.price - $scope.prodUpdData.unit_price).toFixed(2));
        $scope.prodInfoUpdateUI();
    };
    $scope.prodInfoAdjTotal = function () {
        $scope.prodUpdData.total = parseFloat($scope.prodUpdData.adjTotal.toFixed(2));
        if ($scope.prodUpdData.tax_method === 'N') {
            $scope.prodUpdData.unit_price = $scope.prodUpdData.net_unit_price = parseFloat(($scope.prodUpdData.total / $scope.prodUpdData.quantity).toFixed(2));
            $scope.prodUpdData.unit_tax = $scope.prodUpdData.tax = null;
            $scope.prodUpdData.sub_total = parseFloat(($scope.prodUpdData.total).toFixed(2));
            $scope.prodUpdData.unit_discount = parseFloat(($scope.prodUpdData.price - $scope.prodUpdData.unit_price).toFixed(2));
            return;
        }
        if ($scope.prodUpdData.tax_method === 'I') {
            $scope.prodUpdData.unit_price = parseFloat(($scope.prodUpdData.total / $scope.prodUpdData.quantity).toFixed(2));
            $scope.prodUpdData.unit_tax = parseFloat((($scope.prodUpdData.unit_price * $scope.prodUpdData.tax_rate || 0) / 100).toFixed(2));
            $scope.prodUpdData.tax = parseFloat(($scope.prodUpdData.unit_tax * $scope.prodUpdData.quantity).toFixed(2)); // total tax
            $scope.prodUpdData.sub_total = parseFloat(($scope.prodUpdData.total));
            $scope.prodUpdData.net_unit_price = parseFloat(($scope.prodUpdData.unit_price).toFixed(2));
            $scope.prodUpdData.unit_discount = parseFloat(($scope.prodUpdData.price - $scope.prodUpdData.unit_price).toFixed(2));
        } else if ($scope.prodUpdData.tax_method === 'E') {
            let total_unit_price = parseFloat(($scope.prodUpdData.total / $scope.prodUpdData.quantity).toFixed(2)); // including tax
            $scope.prodUpdData.unit_tax = parseFloat(((total_unit_price * $scope.prodUpdData.tax_rate || 0) / 100).toFixed(2));
            $scope.prodUpdData.unit_price = $scope.prodUpdData.net_unit_price = parseFloat((total_unit_price - $scope.prodUpdData.unit_tax).toFixed(2));
            $scope.prodUpdData.tax = parseFloat(($scope.prodUpdData.unit_tax * $scope.prodUpdData.quantity).toFixed(2)); // total tax
            $scope.prodUpdData.unit_discount = parseFloat(($scope.prodUpdData.price - $scope.prodUpdData.net_unit_price).toFixed(2));
            $scope.prodUpdData.sub_total = parseFloat(($scope.prodUpdData.total - $scope.prodUpdData.tax).toFixed(2));
        }
        return;
    };
    $scope.prodInfoUpdateUI = function () {
        $scope.prodUpdData.quantity = parseFloat($scope.prodUpdData.quantity.toFixed(2));
        $scope.prodUpdData.unit_price = parseFloat(($scope.prodUpdData.price - $scope.prodUpdData.unit_discount).toFixed(2));
        $scope.prodUpdData.sub_total = parseFloat(($scope.prodUpdData.price * $scope.prodUpdData.quantity).toFixed(2));
        $scope.prodUpdData.discount = parseFloat(($scope.prodUpdData.quantity * $scope.prodUpdData.unit_discount).toFixed(2));
        $scope.prodUpdData.total = parseFloat(($scope.prodUpdData.sub_total - $scope.prodUpdData.discount).toFixed(2));
        //$scope.updProdTax(); // update tax details for product
        $scope.prodUpdData.adjTotal = null;
    };
    $scope.updProdTax = function () {
        $scope.tempTax = $filter('filter')($scope.taxes, {
            'id': $scope.prodUpdData.tax_id
        }, true); // search and find
        if ($scope.tempTax.length == 1) {
            $scope.tempTax = $scope.tempTax[0];
            $scope.prodUpdData.unit_tax = parseFloat((($scope.prodUpdData.unit_price * parseFloat($scope.tempTax['rate'])) / 100).toFixed(2)); // unit tax
            $scope.prodUpdData.tax = parseFloat(($scope.prodUpdData.unit_tax * $scope.prodUpdData.quantity).toFixed(2)); // total tax
        } else {
            $scope.prodUpdData.unit_tax = $scope.prodUpdData.tax = 0;
        }
    };
    $scope.PI_PriceChange = function () {
        // $scope.prodUpdData.unit_price = parseFloat(($scope.prodUpdData.price - $scope.prodUpdData.unit_discount).toFixed(2));
        // $scope.PI_TaxRateChange();
    };
    $scope.PI_UnitDiscChange = function () {
        //$scope.prodUpdData.unit_price = parseFloat(($scope.prodUpdData.price - $scope.prodUpdData.unit_discount).toFixed(2));
        //$scope.PI_TaxRateChange();
    };
    $scope.PI_UnitPricChange = function () {
        var unit_price = $scope.prodUpdData.unit_price;
        $scope.prodUpdData.unit_discount = parseFloat(($scope.prodUpdData.price - unit_price).toFixed(2));
        if ($scope.prodUpdData.tax_method === 'N') {
            $scope.prodUpdData.unit_tax = $scope.prodUpdData.tax = null; // unit tax
            $scope.prodUpdData.net_unit_price = parseFloat((unit_price - $scope.prodUpdData.unit_discount).toFixed(2));
            $scope.prodUpdData.discount = parseFloat(($scope.prodUpdData.unit_discount * $scope.prodUpdData.quantity).toFixed(2));
            $scope.prodUpdData.sub_total = $scope.prodUpdData.total = parseFloat((unit_price * $scope.prodUpdData.quantity).toFixed(2));
            return;
        }
        if ($scope.prodUpdData.tax_method === 'I') {
            $scope.prodUpdData.unit_tax = parseFloat(((unit_price * $scope.prodUpdData.tax_rate) / 100).toFixed(2)); // unit tax
            $scope.prodUpdData.net_unit_price = parseFloat((unit_price - $scope.prodUpdData.unit_tax - $scope.prodUpdData.unit_tax).toFixed(2));
            $scope.prodUpdData.tax = parseFloat(($scope.prodUpdData.unit_tax * $scope.prodUpdData.quantity).toFixed(2)); // total tax
            $scope.prodUpdData.total = parseFloat((unit_price * $scope.prodUpdData.quantity).toFixed(2));
        } else if ($scope.prodUpdData.tax_method === 'E') {
            $scope.prodUpdData.unit_tax = parseFloat(((unit_price * $scope.prodUpdData.tax_rate) / 100).toFixed(2)); // unit tax
            $scope.prodUpdData.net_unit_price = unit_price;
            $scope.prodUpdData.tax = parseFloat(($scope.prodUpdData.unit_tax * $scope.prodUpdData.quantity).toFixed(2)); // total tax
            $scope.prodUpdData.total = parseFloat(((unit_price * $scope.prodUpdData.quantity) + $scope.prodUpdData.tax).toFixed(2));
        }
        $scope.prodUpdData.sub_total = parseFloat((($scope.prodUpdData.net_unit_price * $scope.prodUpdData.quantity)).toFixed(2));
        $scope.prodUpdData.adjTotal = null;
    };
    $scope.pInfoQtyPlus = function (curQty = 0) {
        $scope.prodUpdData.quantity = curQty + 1;
        $scope.changePdtData('quantity');
    };
    $scope.pInfoQtyMinus = function (curQty = 0) {
        curQty >= 1 ? ($scope.prodUpdData.quantity = curQty - 1) : ($scope.prodUpdData.quantity = 0);
        $scope.changePdtData('quantity');
    };
    $scope.PI_TaxRateChange = function () {
        let unit_price = $scope.prodUpdData.unit_price;
        if ($scope.prodUpdData.tax_method === 'N' || $scope.prodUpdData.tax_id == null) {
            $scope.prodUpdData.tax_id = $scope.prodUpdData.tax_rate = $scope.prodUpdData.unit_tax = $scope.prodUpdData.tax = $scope.prodUpdData.adjTotal = null;
            $scope.prodUpdData.net_unit_price = parseFloat((unit_price).toFixed(2));
            $scope.prodUpdData.total = parseFloat((unit_price * $scope.prodUpdData.quantity).toFixed(2));
            return 0;
        }
        // calculate tax
        $scope.tempTax = $filter('filter')($scope.taxes, {
            'id': $scope.prodUpdData.tax_id
        }, true); // search and find
        $scope.prodUpdData.discount = $scope.prodUpdData.unit_discount * $scope.prodUpdData.quantity;
        $scope.prodUpdData.tax_rate = $scope.tempTax.length == 1 ? parseFloat(parseFloat($scope.tempTax[0]['rate']).toFixed(2)) : 0;
        if ($scope.tempTax.length == 1) {
            $scope.tempTax = $scope.tempTax[0];
            $scope.prodUpdData.unit_tax = parseFloat((($scope.prodUpdData.unit_price * $scope.prodUpdData.tax_rate) / 100).toFixed(2)); // unit tax
            $scope.prodUpdData.tax = parseFloat(($scope.prodUpdData.unit_tax * $scope.prodUpdData.quantity).toFixed(2)); // total tax
        } else {
            alert("Error !");
        }
        // tax based on tax method
        if ($scope.prodUpdData.tax_method === 'I') {
            $scope.prodUpdData.unit_tax = parseFloat(((unit_price * $scope.prodUpdData.tax_rate) / 100).toFixed(2)); // unit tax
            $scope.prodUpdData.net_unit_price = unit_price;
            $scope.prodUpdData.tax = parseFloat(($scope.prodUpdData.unit_tax * $scope.prodUpdData.quantity).toFixed(2)); // total tax
            $scope.prodUpdData.total = parseFloat((unit_price * $scope.prodUpdData.quantity).toFixed(2));
        } else if ($scope.prodUpdData.tax_method === 'E') {
            $scope.prodUpdData.unit_tax = parseFloat(((unit_price * $scope.prodUpdData.tax_rate) / 100).toFixed(2)); // unit tax
            $scope.prodUpdData.net_unit_price = unit_price;
            $scope.prodUpdData.tax = parseFloat(($scope.prodUpdData.unit_tax * $scope.prodUpdData.quantity).toFixed(2)); // total tax
            $scope.prodUpdData.total = parseFloat(((unit_price * $scope.prodUpdData.quantity) + $scope.prodUpdData.tax).toFixed(2));
        }
        $scope.prodUpdData.adjTotal = null;
        return 0;
    };
    /**************************************************************************************************/
    $scope.changePdtData = function (field, value) {
        switch (field) {
            case 'price':
                $scope.prodUpdData.unit_price = parseFloat(($scope.prodUpdData.price - $scope.prodUpdData.unit_discount).toFixed(2));
                break;
            case 'unit_price':
                $scope.prodUpdData.unit_discount = parseFloat(($scope.prodUpdData.price - $scope.prodUpdData.unit_price).toFixed(2));
                $scope.prodUpdData.discount = $scope.prodUpdData.unit_discount * $scope.prodUpdData.quantity;
                break;
            case 'unit_discount':
                $scope.prodUpdData.unit_price = parseFloat(($scope.prodUpdData.price - $scope.prodUpdData.unit_discount).toFixed(2));
                $scope.prodUpdData.discount = $scope.prodUpdData.unit_discount * $scope.prodUpdData.quantity;
                break;
            case 'quantity':
                $scope.prodUpdData.discount = $scope.prodUpdData.unit_discount * $scope.prodUpdData.quantity;
                break;
            default:
                alert("Invalid Action !");
        }
        let PI_TaxRateChange = $scope.PI_TaxRateChange();
        $scope.prodUpdData.sub_total = parseFloat((($scope.prodUpdData.unit_price * $scope.prodUpdData.quantity)).toFixed(2));
    }
    /**************************************************************************************************/
    $scope.revIndex = function (index) {
        if (index !== undefined) {
            return $scope.products.length - index - 1; // rev index
        } else {
            return undefined;
        }
    }
    $("#pSearch").autocomplete({ // search input trigger functions
        minLength: 1,
        delay: 1, // this is in milliseconds
        source: function (request, response) {
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
                type: "POST",
                url: $scope.baseUrl + "admin/ajax/pos",
                dataType: "json",
                data: JSON.stringify({
                    action: 'autocomplete',
                    type: 'product',
                    search: request.term
                }),
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
                $window.alert("No Products Found !");
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
    $("#pRemove").autocomplete({ // search input trigger functions
        minLength: 1,
        delay: 1, // this is in milliseconds
        source: function (request, response) {
            $scope.delResults = [];
            angular.forEach($scope.products, function (obj, objKey) {
                angular.forEach(obj, function (value, key) {
                    $log.log(value + ' ' + key);

                    $scope.tempProd = $filter('filter')($scope.products, {
                        key: request.term
                    });

                    if ($scope.tempProd.length > 0) { // exist in products
                        var index = $scope.products.indexOf($scope.tempProd[0]);

                        $scope.delResults.push($scope.products[index]);
                    }
                });
            });
            $timeout(function () {
                $scope.$digest();
            });
            $scope.test = [];
            response($scope.products);
        },
        classes: {
            "ui-autocomplete": "bg-danger text-light"
        },
        search: function (event, ui) { // search start
            //$log.log('search');
            $scope.search = true;
            $timeout(function () {
                $scope.$digest();
            });
        },
        response: function (event, ui) { // search end
            $scope.search = false;
            if (ui.content.length == 1) { // only one result -> delete
                var index = $scope.products.indexOf(ui.content[0]); // find index
                $scope.products.splice(index, 1); // delete
                $(this).autocomplete("close");
                $scope.pRemove = null;
            } else if (ui.content.length == 0) { // no result
                $window.alert("No Product Deleted !");
                $scope.pRemove = null;
            } else { // many results
            }
            $timeout(function () {
                $scope.$digest();
            });
        },
        select: function (event, ui) { // item clicked -> delete
            var index = $scope.products.indexOf(ui.item);
            $scope.products.splice(index, 1); // delete
            $timeout(function () {
                $scope.$digest();
            });
        },
        close: function (event, ui) { // list closed
            //$log.log('close');
            $scope.pRemove = null;
            $timeout(function () {
                $scope.$digest();
            });
        },
        change: function (event, ui) {
            //$log.log('change');
            $scope.pRemove = null;
            $timeout(function () {
                $scope.$digest();
            });
        },
        create: function (event, ui) {
            //$log.log('created');
        }
    });

    $document.ready(function () {
        $(".selectpicker").selectpicker();
        $scope.focusById('pSearch');
        $('#select2-customer').select2({
            placeholder: 'Select customer...',
            theme: 'bootstrap4',
            minimumInputLength: 1,
            dropdownCssClass: 'bg-secondary',
            ajax: {
                type: "GET",
                url: $scope.baseUrl + "admin/ajax/customer",
                data: function (params) {
                    var query = {
                        action: 'suggest',
                        search: params.term,
                        type: 'pos'
                    }
                    return query;
                },
                dataType: 'json',
                delay: 0,
                headers: {
                    "Content-Type": "application/json"
                },
                processResults: function (response) {
                    $.each(response.data, function (i, d) {
                        response.data[i]['text'] = d.name + ' - ( ' + d.place + ' )'; // for selected ui
                        response.data[i]['html'] = '<div class="text-light">' + d.name + '<br><i class="text-white-50"><i class="fas fa-map-marker-alt"></i>&nbsp;' + d.place + '</i></div>';
                    });
                    return {
                        results: response.data
                    };
                }
            },
            templateResult: template,
        });
        function template(data) {
            return $(data.html);
        }
        /******************************************************** */
        $('#select2-customer').on('select2:select', function (e) { // on selecting customer event
            $scope.debug ? $log.log("New Customer selected : ") : undefined;
            $scope.setCustomer(e.params.data);
        })
        $('#select2-customer').on('change', function (e) { // customer changed event
            $scope.debug ? $log.log("Customer changed") : undefined;
        })
        $scope.setCustomer = function (data) { // set cart customer data
            $scope.cart.customer = {};
            $scope.cart.customer.id = data.id;
            $scope.cart.customer.name = data.name;
            $scope.cart.customer.place = data.place;
        }
        // set default customer on load
        var data = {
            id: 1,
            name: 'Default Name',
            place: 'Default Place',
        };
        data.text = data.name + ' - ( ' + data.place + ' )';
        var newOption = new Option(data.text, data.id, false, false);
        $('#select2-customer').append(newOption).val(data.id).trigger('change'); // set default option on UI
        //
        $scope.setCustomer(data);
        if ($scope.getViewport() === 'xl') {
            // $("#wrapper").toggleClass("toggled");
        }
        else if ($scope.getViewport() === 'xs') {
            // $("#wrapper").removeClass("toggled");
        }
    });
    /******************************************************** */
    $scope.finishCats = function () {// for first and last time
        $scope.debug ? $log.log("Category ng-repeat completed !") : undefined;
        $timeout(function () {
            $('.selectpicker').selectpicker('refresh');
            $('select[name=category]').val(1); // select default category
            $('.selectpicker').selectpicker('refresh');
            $('#category').trigger('change');
        });
    };
    $scope.finishSubCats = function () {
        $scope.debug ? $log.log("Sub category ng-repeat completed !") : undefined;
        $timeout(function () {
            $('.selectpicker').selectpicker('refresh');
            $('#brand').selectpicker('deselectAll');
        });
    };
    $scope.finishBrands = function () {
        $scope.debug ? $log.log("Brands ng-repeat completed !") : undefined;
        $timeout(function () {
            $('.selectpicker').selectpicker('refresh');
        });
    };
    /******************************************************** */
    $scope.$watch('db.subcats', function (newVal, oldVal) {
        $timeout(function () {
            $('.selectpicker').selectpicker('refresh');
        });
    }, true);
    $scope.$watch('db.categories', function (newVal, oldVal) {
        $timeout(function () {
            $('.selectpicker').selectpicker('refresh');
        });
    }, true);
    $scope.$watch('db.brands', function (newVal, oldVal) {
        $timeout(function () {
            $('.selectpicker').selectpicker('refresh');
        });
    }, true);
    /******************************************************** */
    $('#category').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) { // category changed
        let cat_id = $('#category').val(); // current category
        $scope.initSubCats({ id: cat_id }); // get subcats
    });
    $('#subcategory').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) { // sub category changed
    });
    $('#brand').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) { // brand changed
    });
    $('#category,#subcategory,#brand').on('changed.bs.select', function (e) {
        let category = $('#category').val();
        let subcategories = $('#subcategory').val();
        let brands = $('#brand').val();
        $scope.getProdBy(category, subcategories, brands);
    });
    /******************************************************** */
    var getProdBy = $q.defer();
    $scope.getProdBy = function (category, subcategories, brands) {
        getProdBy.resolve();
        getProdBy = $q.defer();
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/pos",
            dataType: 'json',
            params: {
                action: 'filter',
                type: 'c_sc_b',
                data: { category: category, subcategories: subcategories, brands: brands }
            },
            headers: {
                "Content-Type": "application/json"
            },
            timeout: getProdBy.promise
        }).then(function (response) {
            $scope.data.products = response.data.data;
        }, function (response) { });
    };
    /******************************************************** */
}]);
