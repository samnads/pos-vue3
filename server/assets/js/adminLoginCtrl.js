app.controller('adminLoginCtrl', ['$scope', '$http', '$log', '$window', '$sce', '$filter', '$q', '$document', '$timeout', '$cookies', '$localStorage', function ($scope, $http, $log, $window, $sce, $filter, $q, $document, $timeout, $cookies, $localStorage) {
    $scope.ui.loginLoad = false;
    $scope.ui.passInpType = "password";
    $scope.loginData.remember = false
    var loginCan = $q.defer();
    $scope.doLogin = function (event) {
        event.preventDefault();
        $scope.clearAlertResp();
        $scope.ui.loginLoad = true;
        loginCan.resolve();
        loginCan = $q.defer();
        $http({
            method: "POST",
            url: $scope.baseUrl + "admin/ajax/login",
            dataType: 'json',
            data: {
                action: 'login',
                data: $scope.loginData
            },
            headers: {
                "Content-Type": "application/json"
            },
            timeout: loginCan.promise
        }).then(function (response) {
            $scope.mkAlertRes(response.data, true);
            if (response.data.success == true) { // success
                $window.location.href = response.data.location;
            } else { // invalid
                $scope.ui.loginLoad = false;
            }
        }, function (response) {
            $scope.debug ? $log.log(response) : undefined;
            if (response.xhrStatus == 'error') { // no network
                $window.alert("Network Error !");
            }
            else if (response.xhrStatus == 'abort') { // dup ? abort req
                $scope.debug ? $log.log("Prev. Request Aborted !") : undefined;
            }
            else { // script error
                $window.alert("Script Error !");
            }
            $scope.ui.loginLoad = false;
        });
    }
    $scope.showPass = function () {
        if ($scope.ui.passInpType == "password") {
            $scope.ui.passInpType = undefined;
        }
        else {
            $scope.ui.passInpType = "password"
        }
    }
    $scope.rememberMe = function () {
        if ($scope.loginData.remember) {
            $scope.loginData.remember = false;
        }
        else {
            $scope.loginData.remember = true;
        }
    }
}]);
