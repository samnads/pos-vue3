"use strict";
var app = angular.module("cyberlikes", ['ngSanitize', 'ngMessages', 'ngCookies', 'ngStorage', 'ui.bootstrap']);
app.controller('mainCtrl', function ($scope, $log, $http, $filter, $window, $q, $document, $timeout) {
    $scope.debug = true; // enable debug
    $scope.loginData = {};
    $scope.ui = {};
    $scope.temp = {};
    $scope.db = {};
    $scope.SET = {};
    $scope.NEW = {};
    $scope.data = {};
    $scope.alerts = [];
    // arrays
    $scope.array = [];
    // strings
    $scope.string = [];
    $scope.string.save = 'Save';
    $scope.string.update = 'Update';
    $scope.string.checking = "Checking availability...";
    $scope.string.inLoad = "-- Loading... --";
    //
    //$scope.alerts.push({type:'info',message:'This is a sample alert !'});
    $scope.baseUrl = $window.baseUrl = "http://localhost/CyberLikes-POS/";


    $scope.lengths = [{ name: '3', id: 3 }, { name: '5', id: 5 }, { name: '10', id: 10 }, { name: '25', id: 25 }, { name: '50', id: 50 }, { name: '100', id: 100 }, { name: '250', id: 250 }, { name: '500', id: 500 }, { name: '1000', id: 1000 }, { name: 'All', id: -1 }];


    $scope.adminLO = function () {
        $http({
            method: "POST",
            url: $scope.baseUrl + "admin/ajax/logout",
            dataType: 'json',
            data: {
                action: 'logout'
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            if (response.data.success == true) {
                $window.location.href = response.data.location;
            } else {
                $window.alert("Logot Error !");
            }
        }, function (response) { });
    };

    $scope.closeAlert = function (index) {
        $scope.alerts.splice(index, 1);
    };
    /***********************************************************************************/
    $scope.mkAlert = function (data = {}) {
        data.message = data.message || data.error;
        $scope.alerts.push(data);
        $timeout(function () { $scope.$digest(); });
    }
    $scope.mkAlertRes = function (response, clear = false) {
        if (clear) {
            $scope.alerts = [];
        }
        $scope.mkAlert(response);
    }
    $scope.clearAlertResp = function () {
        $scope.alerts = [];
    }
    $scope.showAlert = function (data = {}) {
        if (data.clear) {
            $scope.alerts = [];
        }
        data.message = data.message || data.error || 'No Error Message Found !';
        $scope.alerts.push(data);
        $timeout(function () { $scope.$digest(); });
    }
    /***********************************************************************************/ // Patterns
    $scope.pattern = {};
    $scope.pattern.phone = '^[0-9\-\+\(\)]+$';
    $scope.pattern.email = '^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$';
    $scope.pattern.people_name = '^[a-zA-Z0-9 .-]+$';
    $scope.pattern.place_name = '^[a-zA-Z0-9 .-]+$';
    $scope.pattern1 = '^[a-zA-Z0-9._ -]+$'; // a-z A-Z 0-9 . _ SPACE -
    $scope.pattern2 = '^[0-9]+\.?[0-9]*$'; // 0-9.0-9
    $scope.pattern3 = '^[a-zA-Z0-9-& ]+$'; // a-z A-Z 0-9 SPACE -
    $scope.pattern4 = '^[a-zA-Z0-9]+$'; // a-z A-Z 0-9
    $scope.pattern5 = '^[0-9]+$'; // whole numbers
    $scope.pattern6 = '^[a-z-]+$';
    $scope.pattern7 = '^[a-zA-Z0-9- ]+$';
    $scope.pattern8 = '^[a-zA-Z 0-9-~|\\[\\]().]+$'; // a-z A-Z 0-9 SPACE - ~ | [ ] ( ) .
    $scope.pattern9 = '^[a-zA-Z 0-9%._-]+$'; // a-z A-Z SPACE 0-9 % . _ -
    $scope.pattern10 = '^[0-9]+(\.[0-9]{1,2})?$'; // whole numbers
    /***********************************************************************************/
    $scope.focusById = function (id, select) {
        document.getElementById(id).focus();
        select ? document.getElementById(id).select() : undefined;
    };
    /***********************************************************************************/



    $scope.initTypes = function () {
        var defer = $q.defer();
        delete $scope.db.types;
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/type",
            dataType: 'json',
            params: {
                action: 'all'
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            response = response.data
            $scope.db.types = response.data;
            defer.resolve(response);
        }, function (response) {
            response.error = "Failed to load product types !";
            defer.reject(response);
        });
        return defer.promise;
    };



    /***********************************************************************************/
    $scope.initSymbols = function () {
        var defer = $q.defer();
        $scope.db.symbols = undefined;
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/symbology",
            dataType: 'json',
            params: {
                action: 'dropdown'
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            $scope.db.symbols = response.data.data;
            defer.resolve(response);
        }, function (response) {
            response.error = "Failed to load symbologies !";
            defer.reject(response);
        });
        return defer.promise;
    };
    /***********************************************************************************/

    /***********************************************************************************/


    $scope.initCustGroups = function () {
        $scope.customerGroups = false;
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/pos",
            dataType: 'json',
            params: {
                action: 'customer_groups'
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            $scope.customerGroups = response.data;
        }, function (response) { });
    };
    $scope.initRoles = function () {
        $scope.db.roles = false;
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/role",
            dataType: 'json',
            params: {
                action: 'list'
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            $scope.db.roles = response.data.data;
        }, function (response) { });
    };
    /***********************************************************************************/
    $scope.initCategories = function () {
        var defer = $q.defer();
        $scope.db.categories = undefined;
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/category",
            dataType: 'json',
            params: {
                action: 'getall'
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) { // success
            $scope.db.categories = response.data.data;
            defer.resolve(response);
        }, function (response) { // error
            response.error = "Failed to load categories !";
            defer.reject(response);
        });
        return defer.promise;
    };
    /***********************************************************************************/
    $scope.initSubCats = function (data = {}) { // get sub cats
        if (data.id) {
            var defer = $q.defer();
            $scope.db.subcats = undefined;
            $http({
                method: "GET",
                url: $scope.baseUrl + "admin/ajax/category",
                dataType: 'json',
                params: {
                    action: 'subcats',
                    id: data.id
                },
                headers: {
                    "Content-Type": "application/json"
                }
            }).then(function (response) {
                $scope.db.subcats = response.data.data;
                defer.resolve(response);
            }, function (response) {
                response.error = "Failed to load sub categories !";
                defer.reject(response);
            });
            return defer.promise;
        }
        else {
            $scope.db.subcats = undefined;
        }
    };
    /***********************************************************************************/
    $scope.initBrands = function (data = {}) {
        var defer = $q.defer();
        $scope.db.brands = undefined;
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/brand",
            dataType: 'json',
            params: {
                action: 'dropdown',
                query: data.search
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            if (response.data.success == false) {
                $scope.mkAlert(response.data);
            } else {
                $scope.db.brands = response.data.data;
            }
            defer.resolve(response);
        }, function (response) {
            response.error = "Failed to load brands !";
            defer.reject(response);
        });
        return defer.promise;
    };
    /************************************************************************************/
    $scope.initWarehouses = function (data = {}) {
        $scope.db.warehouses = undefined;
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/warehouse",
            dataType: 'json',
            params: {
                action: 'dropdown',
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
    /***********************************************************************************/
    $scope.initUnits = function () {
        var defer = $q.defer();
        $scope.db.units = undefined;
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/unit",
            dataType: 'json',
            params: {
                action: 'list_base'
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            response = response.data
            if (response.success == true) {
                $scope.db.units = response.data;

            } else {
                $scope.showAlert(response);
            }
            defer.resolve(response);
        }, function (response) {
            response.error = "Failed to load units !";
            defer.reject(response);
        });
        return defer.promise;
    };
    $scope.initSubUnits = function (data) {
        if (data.id) {
            var defer = $q.defer();
            $scope.db.bulks = undefined;
            $http({
                method: "GET",
                url: $scope.baseUrl + "admin/ajax/unit",
                dataType: 'json',
                params: {
                    action: 'list_sub',
                    id: data.id
                },
                headers: {
                    "Content-Type": "application/json"
                }
            }).then(function (response) {
                response = response.data
                if (response.success == true) {
                    $scope.db.bulks = response.data;
                } else {
                    $scope.showAlert(response);
                }
                defer.resolve(response);
            }, function (response) {
                defer.reject(response);
            });
            return defer.promise;
        }
        else {
            $scope.db.bulks = undefined
        }
    };
    /***********************************************************************************/
    $scope.initTaxRates = function () {
        var defer = $q.defer();
        $scope.db.tax_rates = undefined;
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/tax",
            dataType: 'json',
            params: {
                action: 'dropdown'
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            response = response.data
            if (response.success == true) {
                $scope.db.tax_rates = response.data;
            } else {
                $scope.showAlert(response);
            }
            defer.resolve(response);
        }, function (response) {
            response.error = "Failed to load tax rates !";
            defer.reject(response);
        });
        return defer.promise;
    };
    /***********************************************************************************/
    $scope.scrollToTop = function (element) {
        // 'html, body' denotes the html element, to go to any other custom element, use '#elementID'
        $(element).animate({
            scrollTop: 0
        }, 'slow'); // 'fast' is for fast animation
    };
    /***********************************************************************************/


    $scope.printById = function (id) {
        var a = window.open('', '', 'height=500, width=500');
        a.print();
    };
    /***********************************************************************************/
    $scope.playAudio = function () {
        //var audio = new Audio($scope.baseUrl + 'assets/sounds/add.mp3');
        //audio.play();
    };
    /***********************************************************************************/
    $scope.getViewport = function () {
        const width = Math.max(
            document.documentElement.clientWidth,
            window.innerWidth || 0
        )
        if (width <= 576) return 'xs'
        if (width <= 768) return 'sm'
        if (width <= 992) return 'md'
        if (width <= 1200) return 'lg'
        return 'xl'
    }
    /***********************************************************************************/
    $scope.setTouched = function (form) { // touch all invalid form fields
        if (form.$invalid) {
            angular.forEach(form.$error, function (field) {
                angular.forEach(field, function (errorField) {
                    errorField.$setTouched();
                })
            });
            return false;
        }
        return true;
    }
    $scope.setErrorValid = function (form) { // set all custom 'error' fields to valid
        if (form.$invalid) {
            angular.forEach(form.$error, function (field) {
                angular.forEach(field, function (errorField) {
                    errorField.$setValidity("error", true);
                })
            });
        }
    }

    /***********************************************************************************/
    $document.ready(function () {
        bsCustomFileInput.init(); // initialise bs-custom-file-inputm plug-in
        // change required fields label color for *
        let labels = document.getElementsByTagName('label'); // get all form labels
        for (let i = 0; i < labels.length; i++) {
            if (labels[i].innerHTML.includes("<strong>")) { // have stong tag
                let strongs = labels[i].getElementsByTagName('strong');
                strongs[0].classList.add("text-danger"); // change style
            }
        }
        // end
    });
});
// end
app.config(['$cookiesProvider', function ($cookiesProvider) {
    // Set $cookies defaults
}]);
/* select on click directive for input fields */
app.directive('selectOnClick', ['$window', function ($window) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            element.on('click', function () {
                this.select();
            });
        }
    };
}]);
/* show tooltips -> data-toggle="tooltip */
$('body').tooltip({
    selector: '[data-toggle="tooltip"]'
});
$('body').popover({
    selector: '[data-toggle="popover"]',
    trigger: "hover"
});