'use strict';
app.controller('newProdCtrl', ['$scope', '$http', '$log', '$window', '$sce', '$rootScope', '$filter', '$q', '$document', '$timeout', function ($scope, $http, $log, $window, $sce, $rootScope, $filter, $q, $document, $timeout) {
    $scope.init = function () {
        $scope.data = {};
        $q.all([
            $scope.initTypes(),
            $scope.initSymbols(),
            $scope.initCategories(),
            $scope.initSubCats({ id: $window.category }),
            $scope.initBrands(),
            $scope.initUnits(),
            $scope.initSubUnits({ id: $window.unit }),
            $scope.initTaxRates(),
            $scope.initWarehouses()
        ]).then(function (response) {
            $scope.initFormData(); // add data to form
        }).catch(function (response) {
            alert("Error : " + response.error);
            //$window.location.reload();
        });
    }
    /****************************************/
    $scope.initFormData = function () { // Intialize functions
        $scope.SET.new = $window.is_new; // new or edit product
        $scope.SET.copy = $window.is_copy; // copy product?
        // form datas
        $scope.data.id = $window.id; // prod id
        $scope.data.type = $window.type; // default type
        $scope.data.code = $window.code;
        $scope.data.symbology = $window.symbology; // default symbology
        $scope.data.name = $window.name;
        $scope.data.slug = $window.slug;
        $scope.data.weight = $window.weight || null;
        $scope.data.category = $window.category; // default category
        $scope.data.sub_category = $window.sub_category;
        $scope.data.brand = $window.brand; // default brand
        $scope.data.mrp = $window.mrp || null;
        $scope.data.unit = $window.unit; // default unit
        $scope.data.p_unit = $window.p_unit;
        $scope.data.s_unit = $window.s_unit;
        $scope.data.is_auto_cost = $window.is_auto_cost; // default autocost?
        $scope.data.cost_bef_tax = $window.cost || null;
        $scope.data.price = $window.price || null;
        $scope.data.auto_discount = $window.auto_discount || null;
        $scope.data.tax_method = $window.tax_method; // default tax method
        $scope.data.tax_rate = $window.tax_rate || null; // default tax rate
        $scope.data.profit_margin = $window.profit_margin; // default alert?
        $("[name='mfg_date']").datepicker('setDate', $window.mfg_date);
        $("[name='exp_date']").datepicker('setDate', $window.exp_date);
        $scope.data.alert = $window.alerT; // default alert?
        $scope.data.alert_quantity = $scope.data.alert ? ($window.alert_quantity || $window.def_alert_quantity) : null;

        $scope.data.auto_discount = $window.auto_discount;
        $timeout(function () { $scope.form.$setPristine(); $scope.$digest(); });
    }
    $scope.dataCheckToggle = function (variable) {
        $scope.data[variable] === true ? $scope.data[variable] = false : $scope.data[variable] = true;
    };
    /* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */ // access another controller function
    $scope.showCatForm = function (param) { // newCatCtrl.js
        $rootScope.$emit("showCatForm", param);
    };
    $scope.showUnitForm = function (data) { // newUnitCtrl.js
        $rootScope.$emit("showUnitForm", data);
    };
    $scope.show_createBrandModal = function (data, edit, copy) {
        $rootScope.$emit("show_createBrandModal", data, edit, copy);
    };
    $scope.showTaxForm = function () {
        $rootScope.$emit("showTaxForm");
    };
    /* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    $rootScope.$on("unitAdded", function (event, data) {
        $scope.showAlert(data);
        $q.all([
            $scope.initUnits()
        ]).then(function (response) {
            $scope.data.unit = data.id;
            $scope.db.bulks = [];
            $scope.data.p_unit = $scope.data.s_unit = null;
        }).catch(function (response) {
        });
        $scope.playAudio();
    });
    $rootScope.$on("subUnitAdded", function (event, data) {
        $scope.showAlert(data);
        $q.all([
            $scope.initSubUnits({ id: $scope.data.unit })
        ]).then(function (response) {
            $scope.data.p_unit = $scope.data.s_unit = data.id;
        }).catch(function (response) {
        });
        $scope.playAudio();
    });
    $rootScope.$on("catAdded", function (event, data) {
        $scope.showAlert(data);
        $q.all([
            $scope.initCategories()
        ]).then(function (response) {
            $scope.data.category = data.id;
            $scope.db.subcats = [];
        }).catch(function (response) {
        });
        $scope.playAudio();
    });
    $rootScope.$on("subCatAdded", function (event, data) {
        $scope.showAlert(data);
        $q.all([
            $scope.initSubCats({ id: $scope.data.category })
        ]).then(function (response) {
            $scope.data.sub_category = data.id;
        }).catch(function (response) {
        });
        $scope.playAudio();
    });
    $rootScope.$on("brandAdded", function (event, data) {
        $scope.mkAlert(data);
        $q.all([
            $scope.initBrands()
        ]).then(function (response) {
            $scope.data.brand = data.id;
        }).catch(function (response) {
        });
        $scope.playAudio();
    });
    $rootScope.$on("taxAdded", function (event, data = {}) {
        $scope.mkAlert(data);
        $q.all([
            $scope.initTaxRates()
        ]).then(function (response) {
            $scope.data.tax_rate = data.id;
            $scope.__cost_bef_tax();
        }).catch(function (response) {
        });
        $scope.playAudio();
    });
    /* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    $scope.changeCat = function (data = {}) {
        $scope.data.sub_category = data.id;
    };
    $scope.$watch('db.units', function () { // first load
        if ($scope.db.units) {
            $scope.selUnit = $filter('filter')($scope.db.units, { id: $scope.data.unit }, true)[0];
        }
    });
    $scope.$watch('data.unit', function () { // on unit change
        if ($scope.db.units && $scope.data.unit) {
            $scope.selUnit = $filter('filter')($scope.db.units, { id: $scope.data.unit }, true)[0];
        }
    });
    /****************************************/
    $scope.tickAutoCost = function () {
        $scope.form.$setDirty("is_auto_cost", true);
        if ($scope.data.is_auto_cost) { // if checked uncheck
            $scope.data.cost = $scope.data.oldcost;
            $scope.data.is_auto_cost = false;
        } else { // check
            $scope.data.oldcost = $scope.data.cost;
            $scope.data.cost = null;
            $scope.data.is_auto_cost = true;
        }
    };
    $scope.costC = function () {
        if ($scope.data.cost == null && $scope.data.is_auto_cost == true) { // do check
            $scope.data.oldcost = $scope.data.cost;
            $scope.data.cost = null;
            $scope.data.is_auto_cost = true;
        } else { // do uncheck
            $scope.data.is_auto_cost = false;
        }
    };
    /****************************************/
    $scope.tickAlert = function () {
        if ($scope.data.alert === false || $scope.data.alert === undefined) {
            $scope.data.alert = true;
            $scope.data.alert_quantity = $window.alert_quantity || $window.def_alert_quantity;
        } else {
            $scope.data.alert = false;
            $scope.data.alert_quantity = null;
        }
        $scope.form.$setDirty("alert", true);
    }
    $scope.cAlert = function () {
        if ($scope.data.alert_quantity != null) { // do check // enable alert
            $scope.data.alert = true;
        } else { // do uncheck
            $scope.data.alert = false;
        }
    }
    /****************************************/
    $scope.priceC = function (taxm = $scope.data.taxm, taxid = $scope.data.taxid, mrp = $scope.data.mrp, price = $scope.data.price) {
        $scope.taxC(taxm, taxid, mrp, price);
    }
    $scope.taxC = function (taxm, taxid, mrp, price) {
        if (taxm == 'E' && taxid) {
            $scope.array.tax = $filter('filter')($scope.taxes, {
                id: taxid
            }, true); // get selected tax row
            if ($scope.array.tax.length == 1) { // calculate final price including tax
                $scope.array.tax = $scope.array.tax[0];
                $log.log("Selected tax : " + $scope.array.tax['rate']);
                $scope.data.priceTax = (($scope.array.tax['rate'] / 100) * price) + price; // price with tax
            }
        } else {
            $scope.data.priceTax = price;
        }
        if (price != null) {
            if ((mrp != null) && (mrp < price || mrp < $scope.data.priceTax)) {
                $scope.form['price'].$setValidity("greater", false); // error
            } else {
                $scope.form['price'].$setValidity("greater", true); // valid
            }
        }
    }
    // gen random prod code
    $scope.randCode = function () {
        $scope.data.code = Math.floor(Math.random() * (10000000 - 99999999 + 1)) + 99999999;
        $scope.form.code.$setDirty(); // field changed
        $scope.form['code'].$setValidity("error", true);
    }
    /****************************************/
    var getCan = $q.defer();
    $scope.getProd = function () {
        getCan.resolve();
        getCan = $q.defer();
        $http({
            method: "POST",
            url: $scope.baseUrl + "admin/ajax/product",
            dataType: 'json',
            data: {
                action: 'get',
                id: $window.id
            },
            headers: {
                "Content-Type": "application/json"
            },
            timeout: getCan.promise
        }).then(function (response) {
            if (response.data.success == true) {
                $scope.product = response.data.data; // product data
                $scope.data.type = $window.type = $scope.product.type;
                $scope.data.code = $window.code = $scope.product.code;
                $scope.data.symbol = $window.symbol = $scope.product.symbology;
                $scope.data.name = $window.name = $scope.product.name;
                $scope.data.slug = $window.slug = $scope.product.slug;
                $scope.data.weight = $window.weight = $scope.product.weight;
                $scope.data.cat = $window.cat = $scope.product.category;
                $scope.data.subcat = $window.subcat = $scope.product.sub_category == null ? 0 : $scope.product.sub_category;
                $scope.data.brand = $window.brand = $scope.product.brand;
                $scope.data.mrp = $window.mrp = $scope.product.mrp;
                $scope.data.unit = $window.unit = $scope.product.unit;
                $scope.data.punit = $window.punit = $scope.product.p_unit == null ? 0 : $scope.product.p_unit;
                $scope.data.sunit = $window.sunit = $scope.product.s_unit == null ? 0 : $scope.product.s_unit;
                $scope.data.cost = $window.cost = $scope.product.cost;
                $scope.data.autocost = $window.autocost = $scope.product.is_auto_cost == 1 ? true : false;
                $scope.data.price = $window.price = $scope.product.price;
                $scope.data.taxm = $window.taxm = $scope.product.tax_method;
                $scope.data.taxr = $window.taxr = $scope.product.tax_rate;
                $scope.data.mfg = $window.mfg = $scope.product.mfg_date;
                $scope.data.exp = $window.exp = $scope.product.exp_date;
                $scope.data.alert = $window.alerT = $scope.product.alert == 1 ? true : false;
                $scope.data.alertq = $window.alertq = $scope.product.alert_quantity;
                //$("[name='mfg']").datepicker('setDate', $scope.data.mfg);
                //$("[name='exp']").datepicker('setDate', $window.exp);
            } else { }
        }, function (response) { });
    }
    // code availability
    var codeCan = $q.defer();
    $scope.$watch('data.code', function (code) {
        if (code && (!$scope.SET.new && !$scope.SET.copy && code != $window.code)) {
            $scope.form['code'].$setTouched();
            $scope.form['code'].$setValidity("error", true);
            $scope.form['code'].$setValidity("check", false); // show
            codeCan.resolve();
            codeCan = $q.defer();
            $http({
                method: "GET",
                url: $scope.baseUrl + "admin/ajax/product",
                params: {
                    action: 'validate',
                    data: {
                        field: 'code',
                        value: code
                    }
                },
                headers: {
                    "Content-Type": "application/json"
                },
                timeout: codeCan.promise
            }).then(function (response) {
                if (response.data.success == true) {
                    $scope.form['code'].$setValidity("error", true);
                } else {
                    $scope.form['code'].$setValidity("error", false);
                    $scope.form['code'].$error.error = response.data.error;
                }
                $scope.form['code'].$setValidity("check", true); // hide
            }, function (response) {
                $scope.debug ? $log.log(response) : undefined;
            });
        } else { }
    });
    // name availability
    var nameCan = $q.defer();
    $scope.$watch('data.name', function (name) {
        if (name && (!$scope.SET.new && !$scope.SET.copy && name != $window.name)) {
            $scope.form['name'].$setTouched();
            $scope.form['name'].$setValidity("error", true);
            $scope.form['name'].$setValidity("check", false); // show
            $scope.data.slug = name.replace(/[\W_]+/g, "-").toLowerCase();
            nameCan.resolve();
            nameCan = $q.defer();
            $http({
                method: "GET",
                url: $scope.baseUrl + "admin/ajax/product",
                params: {
                    action: 'validate',
                    data: {
                        field: 'name',
                        value: name
                    }
                },
                headers: {
                    "Content-Type": "application/json"
                },
                timeout: nameCan.promise
            }).then(function (response) {
                if (response.data.success == true) {
                    $scope.form['name'].$setValidity("error", true);
                } else {
                    $scope.form['name'].$setValidity("error", false);
                    $scope.form['name'].$error.error = response.data.error;
                }
                $scope.form['name'].$setValidity("check", true); // checking
            }, function (response) {
                $scope.debug ? $log.log(response) : undefined;
            });
        } else { }
    });
    // slug availability
    var slugCan = $q.defer();
    $scope.$watch('data.slug', function (slug, old) {
        if (slug && (!$scope.SET.new && !$scope.SET.copy && slug != $window.slug)) {
            slug = $scope.data.slug = slug.replace(/[\W_]+/g, "-").toLowerCase();
            $scope.form['slug'].$setTouched();
            $scope.form['slug'].$setValidity("error", true);
            $scope.form['slug'].$setValidity("check", false); // checking
            slugCan.resolve();
            slugCan = $q.defer();
            $http({
                method: "GET",
                url: $scope.baseUrl + "admin/ajax/product",
                params: {
                    action: 'validate',
                    data: {
                        field: 'slug',
                        value: slug
                    }
                },
                headers: {
                    "Content-Type": "application/json"
                },
                timeout: slugCan.promise
            }).then(function (response) {
                if (response.data.success == true) {
                    $scope.form['slug'].$setValidity("error", true);
                } else {
                    $scope.form['slug'].$setValidity("error", false);
                    $scope.form['slug'].$error.error = response.data.error;
                }
                $scope.form['slug'].$setValidity("check", true); // checking
            }, function (response) {
                $scope.debug ? $log.log(response) : undefined;
            });
        } else {

        }
    });
    // reset form
    $scope.reset = function () {
        $scope.form.$setPristine();
        $scope.init();
    }
    // reset error
    $scope.cChange = function () {
        $scope.form['code'].$setValidity("error", true);
    }
    $scope.nChange = function () {
        $scope.form['code'].$setValidity("error", true);
    }
    $scope.sacChange = function () {
        $scope.form['stock_adj_count'].$setValidity("error", true);
    }
    // submit product
    $scope.submit = function (event) {
        event.preventDefault();
        if ($scope.setTouched($scope.form) === false) {
            return;
        }
        if ($scope.SET.edit) {
            $scope.data.db = db;
        }
        $http({
            method: $scope.SET.new || $scope.SET.copy ? "POST" : "PUT",
            url: $scope.baseUrl + "admin/ajax/product",
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
    // ready function
    $document.ready(function () {
        $("[name='mfg_date']").datepicker({
            format: "dd-mm-yyyy",
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
            toggleActive: true
        }).on('changeDate', function (e) {
            $scope.data.mfg_date = e.format();
            $("[name='exp_date']").datepicker('setStartDate', $scope.data.mfg_date); // show only valid based on exp_date
            $scope.form.$setDirty("mfg_date", true);
            $timeout(function () { $scope.$digest(); });
        });
        $("[name='exp_date']").datepicker({
            format: "dd-mm-yyyy",
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
            toggleActive: true
        }).on('changeDate', function (e) {
            $scope.data.exp_date = e.format();
            $("[name='mfg_date']").datepicker('setEndDate', $scope.data.exp_date); // show only valid based on mfg_date
            $scope.form.$setDirty("exp_date", true);
            $timeout(function () { $scope.$digest(); });
        });

        $("[name='stock_adj_date']").datepicker({
            format: "dd-mm-yyyy",
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
            toggleActive: true,
            todayBtn: "linked",
        }).on('changeDate', function (e) {
            $scope.data.stock_adj_date = e.format();
            $scope.form.$setDirty("stock_adj_date", true);
            $timeout(function () { $scope.$digest(); });
        });
    });
    $scope.changeCost = function () {
        if ($scope.data.cost == null && $scope.data.is_auto_cost == true) { // do check
            $scope.data.oldcost = $scope.data.cost;
            $scope.data.cost = null;
            $scope.data.is_auto_cost = true;
        } else { // do uncheck
            $scope.data.is_auto_cost = false;
        }
    }
    // cost changed
    $scope.$watch('data.cost', function (newValue, oldValue) {
        /*if (newValue !== oldValue) {
             if (typeof ($scope.data.cost) == "number") {// change field values
                 if ($scope.data.profit_margin) { // based on margin rate
                     $scope.data.price = $scope.marginPrice($scope.data.cost, $scope.data.profit_margin);
                     $scope.form['price'].$setDirty();
                 }
             }
         }*/
    });



    $scope.__cost_bef_tax = function () {
        if (typeof ($scope.data.cost_bef_tax) == "number") {
            if ($scope.data.tax_rate) {
                let tax = $filter('filter')($scope.db.tax_rates, {
                    id: $scope.data.tax_rate
                }, true)[0]; // get selected tax row
                if ($scope.data.tax_method == 'I') {
                    $scope.data.cost_aft_tax = $scope.data.cost_bef_tax;
                }
                else {
                    $scope.data.cost_aft_tax = parseFloat(($scope.data.cost_bef_tax + parseFloat($scope.taxValue(tax['rate'], tax['type'], $scope.data.cost_bef_tax).toFixed(2))).toFixed(2));
                }
            }
            else {
                $scope.data.cost_aft_tax = $scope.data.cost_bef_tax;
            }
        }
        else {
            $scope.data.cost_aft_tax = null;
        }
        $scope.__profit_margin();
    };
    $scope.__cost_aft_tax = function () {
        if (typeof ($scope.data.cost_aft_tax) == "number") {// change field values
            if ($scope.data.tax_rate && $scope.data.tax_method == 'E') {
                let tax = $filter('filter')($scope.db.tax_rates, {
                    id: $scope.data.tax_rate
                }, true)[0]; // get selected tax row
                $scope.data.cost_bef_tax = parseFloat(($scope.data.cost_aft_tax - parseFloat($scope.taxFromTotal(tax['rate'], tax['type'], $scope.data.cost_aft_tax).toFixed(2))).toFixed(2));
            }
            else {
                $scope.data.cost_bef_tax = $scope.data.cost_aft_tax;
            }
        }
        else {
            $scope.data.cost_bef_tax = null;
        }
        //$scope.form['cost_bef_tax'].$setTouched() && $scope.form['cost_bef_tax'].$setDirty();
        $scope.__profit_margin();
    };
    $scope.__profit_margin = function () { // calculate selling price using margin rate
        if (typeof ($scope.data.profit_margin) == "number" && $scope.data.cost_bef_tax) {
            $scope.data.price = parseFloat($scope.marginPrice($scope.data.cost_bef_tax, $scope.data.profit_margin).toFixed(2));
            $scope.data.price_aft_disc = $scope.data.price - $scope.data.auto_discount;
            //$scope.form['price'].$setDirty();
        }
        else {
            $scope.data.price = null;
            $scope.data.price_aft_disc = null;
        }
        $scope._calc_price_tax();
    };
    $scope._calc_price_tax = function () {
        if ($scope.data.tax_rate) {
            let tax = $filter('filter')($scope.db.tax_rates, {
                id: $scope.data.tax_rate
            }, true)[0]; // get selected tax row
            $scope.data.price_tax = parseFloat($scope.taxValue(tax['rate'], tax['type'], $scope.data.price_aft_disc).toFixed(2));
        }
        else {
            $scope.data.price_tax = 0;
        }
        $scope._calc_final_price();
    };
    $scope.__auto_discount = function () {
        $scope._calc_price_tax();
        $scope.data.price_aft_disc = $scope.data.price - ($scope.data.auto_discount || 0);
        $scope.form['price'].$setDirty();
    };
    $scope.__price_aft_disc = function () {
        $scope._calc_price_tax();
        if (typeof ($scope.data.price_aft_disc) == "number") {
            $scope.data.auto_discount = parseFloat(($scope.data.price - $scope.data.price_aft_disc).toFixed(2));
        }
    };

    $scope.__price = function () {
        $scope._calc_price_tax();
        $scope.data.profit_margin = $scope.marginPercent($scope.data.price, $scope.data.cost_bef_tax);
        $scope.__auto_discount();
    };

    $scope._calc_final_price = function () {
        if ($scope.data.tax_method == 'I') {
            $scope.data.final_price = $scope.data.price_aft_disc;
        }
        else {
            $log.log($scope.data.price_aft_disc + $scope.data.price_tax);
            $scope.data.final_price = parseFloat(($scope.data.price_aft_disc + $scope.data.price_tax).toFixed(2));
        }
    };
    $scope.__final_price = function () {

    };




    $scope.taxValue = function (rate, type, total) { // calculate tax value using tax type (P or F)
        $scope.debug ? $log.log("Calculating tax value...[" + rate + "," + type + "," + total + "]") : undefined;
        return (type == 'P') ? (rate / 100) * total : parseFloat(rate);
    }
    $scope.taxFromTotal = function (rate, type, total) {
        $scope.debug ? $log.log("Calculating tax from total...[" + rate + "," + type + "," + total + "]") : undefined;
        return (type == 'P') ? (total / (1 + rate)) * rate : parseFloat(rate);
    }
    // profit_margin changed
    $scope.$watch('data.profit_margin', function () {

    });
    // price changed
    $scope.$watch('data.price', function (newValue, oldValue) {

    });
    // auto_discount changed
    $scope.$watch('data.auto_discount', function () {

    });
    // price_aft_disc changed
    $scope.$watch('data.price_aft_disc', function (newValue, oldValue) {
        if (newValue !== oldValue) {
            if (typeof ($scope.data.price_aft_disc) == "number") {
                //$scope.data.auto_discount = parseFloatof($scope.data.price - $scope.data.prt_margin);
                //$scope.form['auto_discount'].$setDirty();
            } else {
                //alert($scope.data.auto_discount);
                //$scope.data.auto_discount = 0;
            }
        }
    });
    // tax rate changed
    $scope.$watch('data.tax_rate', function (newValue, oldValue) {
        if (newValue !== oldValue) {
            if ($scope.data.tax_rate) {
                $scope.array.tax = $filter('filter')($scope.db.tax_rates, {
                    id: $scope.data.tax_rate
                }, true); // get selected tax row
                if ($scope.array.tax.length == 1) { // calculate tax value
                    $scope.array.tax = $scope.array.tax[0];
                }
                else {
                    alert("Error !");
                }
            }
            else {
                $scope.ui.tax_value = 0; // no tax selected
            }
            $scope.__cost_bef_tax();
        }
    });
    // tax method changed
    $scope.$watch('data.tax_method', function () {
        $scope.__cost_bef_tax();
    });

    $scope.marginPrice = function (cost, margin) { // calculate margin price
        return parseFloat((parseFloat(cost) + ((parseFloat(margin) * parseFloat(cost)) / 100)).toFixed(2));
    }
    $scope.marginPercent = function (price, cost) { // calculate margin %
        var profit = price - cost;
        var p = (profit / cost) * 100;
        return parseFloat(p.toFixed(2));
    }
}]);
