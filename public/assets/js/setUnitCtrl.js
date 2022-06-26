app.controller("setUnitCtrl", ['$scope', '$http', '$log', '$window', '$document', '$timeout', '$cookies', '$localStorage', '$q', '$rootScope', function ($scope, $http, $log, $window, $document, $timeout, $cookies, $localStorage, $q, $rootScope) {
    $scope.init = function () {
        $scope.SET.defLength = 5;
        $scope.SET.defLength_s = 3;
    };
    $scope.newUnit = function (data) {
        $rootScope.$emit("showUnitForm", data);
    };
    $rootScope.$on("unitAdded", function (event, data) {
        $scope.playAudio();
        $('#table').DataTable().ajax.reload(null, false);
    });
    $rootScope.$on("unitEdited", function (event, data) {
        $scope.playAudio();
        $('#table').DataTable().ajax.reload(null, false);
    });
    $rootScope.$on("subUnitAdded", function (event, data) {
        $scope.playAudio();
        $('#sub_table').DataTable().ajax.reload(null, false);
    });
    $rootScope.$on("subUnitEdited", function (event, data) {
        $scope.playAudio();
        $('#sub_table').DataTable().ajax.reload(null, false);
    });
    /************************************************************************************* */
    $scope.confDel = function (data = {}) { // show confirm delete box
        $scope.newUnit.delete = data.data;
        $scope.newUnit.delete.sub = data.sub;
        $timeout(function () { $scope.$digest(); });
        $('#singDel').modal('show');
    };
    $scope.delete = function () {
        $http({
            method: "DELETE",
            url: $scope.baseUrl + "admin/ajax/unit",
            dataType: 'json',
            data: {
                data: $scope.newUnit.delete
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            $scope.mkAlertRes(response.data);
            if (response.data.success == true) { // delete success
                if ($scope.newUnit.delete.sub) {
                    $('#sub_table').DataTable().ajax.reload();
                } else {
                    $('#table').DataTable().ajax.reload();
                }
            } else {

            }
            $('#singDel').modal('hide');
        }, function (response) { });
    };
    /************************************************************************************* */
    $document.ready(function () {
        $.fn.dataTable.ext.errMode = function (settings, helpPage, message) { };
        var table = $('#table').DataTable({
            "ajax": {
                "method": "GET",
                "url": $scope.baseUrl + "admin/ajax/unit",
                "contentType": "application/json",
                "data": function (d) {
                    d['action'] = "datatable";
                    return d;
                },
                "dataSrc": function (json) {
                    if (json.data) {
                        return json.data;
                    } else {
                        $scope.showAlert(json);
                        return [];
                    }
                }
            },
            "searching": true, // remove default search box
            "bLengthChange": false, // remove default length change menu
            "pageLength": $scope.SET.defLength,
            "searchDelay": 750,
            "processing": true,
            "serverSide": true,
            "language": {
                "processing": '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>',
                "emptyTable": "No data available in table",
                "zeroRecords": "No matching taxes found",
                "info": "Showing _START_ to _END_ of _TOTAL_ Units",
                "infoEmpty": "No unit info found",
                "emptyTable": "No units found",
                "infoFiltered": "(filtered from _MAX_ Tax Units)",
            },
            'dom': 'Btipr',
            'deferRender': true,
            'rowId': 'id',
            'buttons': [{ // reload button
                text: '<i class="fa fa-sync-alt aria-hidden="true"></i>',
                className: 'btn-light',
                action: function () {
                    table.ajax.reload();
                },
                attr: {
                    title: 'Refresh',
                    id: 'refresh'
                },
                key: {
                    key: 'r',
                    shiftKey: true
                },
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                }
            },
            {
                text: '<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;New',
                className: 'btn-light',
                action: function () {
                    $scope.newUnit();
                },
                attr: {
                    title: 'New Unit',
                    id: 'new'
                },
                key: {
                    key: 'd',
                    shiftKey: true
                },
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                }
            }
            ],
            "columns": [
                {
                    data: "id",

                },
                {
                    data: "name"
                },
                {
                    data: "code"
                },
                {
                    data: "description"
                },
                {
                    data: "menu"
                },
                {
                    data: null
                }
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                },
                {
                    "targets": [1],
                    'render': function (data, type, row, meta) {
                        return '<strong>' + data + '</strong>';
                    },
                },
                {
                    "targets": [2],
                },
                {
                    "targets": [3],
                    'render': function (data, type, row, meta) {
                        if (data === null) {
                            return '<i class="text-info">NIL</i>';
                        }
                        return data;
                    },
                },
                {
                    "targets": [4],
                    "orderable": false,
                    "searchable": false,
                    'render': function (data, type, row, meta) {
                        data = '<button type="button" class="btn btn-outline-secondary" id="newsub"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;New Sub Unit</button>';
                        return data;
                    },
                },
                {
                    "targets": -1,
                    "orderable": false,
                    "searchable": false,
                    "width": "2%",
                    "defaultContent": "<div class='btn-group dropleft'><button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action</button><div class='dropdown-menu'><a id='info' class='dropdown-item' href='#'><a class='dropdown-item' id='edit' href='#'><i class='fa fa-edit fa-fw' aria-hidden='true'></i>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item' id='delete' href='#'><i class='fa fa-trash fa-fw' aria-hidden='true'></i>Delete</a> </div></div>"
                }
            ],
            'select': false,
            'order': [
                [0, 'desc']
            ],
            "paging": true,
            "pagingType": "simple_numbers",
            "rowCallback": function (row, data) {
                if (data.unit == null) {
                    //$('td', row).addClass('bg-light text-primary');
                }
                else {
                    //$('td', row).addClass('bg-white-dangertext-secondary');
                }
            }
        });
        var sub_table = $('#sub_table').DataTable({
            "ajax": {
                "method": "GET",
                "url": $scope.baseUrl + "admin/ajax/unit",
                "contentType": "application/json",
                "data": function (d) {
                    d['action'] = "datatable_sub";
                    return d;
                },
                "dataSrc": function (json) {
                    if (json.data) {
                        return json.data;
                    } else {
                        $scope.showAlert(json);
                        return [];
                    }
                }
            },
            "searching": true, // remove default search box
            "bLengthChange": false, // remove default length change menu
            "pageLength": $scope.SET.defLength_s,
            "searchDelay": 750,
            "processing": true,
            "serverSide": true,
            "language": {
                "processing": '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>',
                "emptyTable": "No data available in table",
                "zeroRecords": "No matching sub units found",
                "info": "Showing _START_ to _END_ of _TOTAL_ Sub units",
                "infoEmpty": "No unit info found",
                "emptyTable": "No sub units found",
                "infoFiltered": "(filtered from _MAX_ Sub units)",
            },
            'dom': 'Btipr',
            'deferRender': true,
            'rowId': 'id',
            'select': false,
            'buttons': [{ // reload button
                text: '<i class="fa fa-sync-alt" aria-hidden="true"></i>',
                className: 'btn-light',
                action: function () {
                    sub_table.ajax.reload();
                },
                attr: {
                    title: 'Refresh',
                    id: 'refresh'
                },
                key: {
                    key: 'r',
                    shiftKey: true
                },
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                }
            }
            ],
            "columns": [
                {
                    data: "id",

                },
                {
                    data: "name"
                },
                {
                    data: "code"
                },
                {
                    data: "unit_name"
                },
                {
                    data: "description"
                },
                {
                    data: null
                }
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                },
                {
                    "targets": [1],
                    'render': function (data, type, row, meta) {
                        return '<strong>' + data + '</strong>';
                    }
                },
                {
                    "targets": [2],
                },
                {
                    "targets": [3],
                    'render': function (data, type, row, meta) {
                        return '<strong>' + data + '</strong>';
                    }
                },
                {
                    "targets": [4],
                    'render': function (data, type, row, meta) {
                        if (data === null) {
                            return '<i class="text-muted small">NIL</i>';
                        }
                        return data;
                    },
                },
                {
                    "targets": -1,
                    "orderable": false,
                    "searchable": false,
                    "width": "2%",
                    "defaultContent": "<div class='btn-group dropleft'><button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action</button><div class='dropdown-menu'><a class='dropdown-item' id='edit' href='#'><i class='fa fa-edit fa-fw' aria-hidden='true'></i>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item' id='delete' href='#'><i class='fa fa-trash fa-fw' aria-hidden='true'></i>Delete</a> </div></div>"
                }
            ],
            'order': [
                [0, 'desc']
            ],
            "paging": true,
            "pagingType": "simple_numbers",
            "rowCallback": function (row, data) {
                if (data.description == null) {
                    //$('td', row).addClass('bg-light text-primary');
                }
                else {
                    //$('td', row).addClass('bg-white-dangertext-secondary');
                }
            }
        });
        /************************************************************************************* */ // cats
        $('#length_change').change(function () { // custom length change menu
            table.page.len($(this).val()).draw();
        });
        table.buttons().container().appendTo('#buttons');
        $('#search').keyup(function () { // custom search box
            table.search($(this).val()).draw();
        });
        document.getElementById("search").addEventListener("search", function (event) { // search clear button clicked
            table.search('').draw();
        });
        $('#table tbody').on('click', '#newsub', function () { // add sub unit from row
            let row = table.row($(this).parents('tr')).data();
            $scope.newUnit({ sub: true, data: row });
        });
        $('#table tbody').on('click', '#edit', function () { // edit from action menu
            let row = table.row($(this).parents('tr')).data();
            $scope.newUnit({ edit: true, data: row });
        });
        $('#table tbody').on('click', '#delete', function () { // delete from action menu
            let row = table.row($(this).parents('tr')).data();
            $scope.confDel({ data: row });
        });
        $('#table').on('error.dt', function (e, settings, techNote, message) {
            //$scope.showAlert({ success: false, type: 'danger', error: message });
        })
        /************************************************************************************* */ // sub cats
        $('#sub_length_change').change(function () { // custom length change menu
            sub_table.page.len($(this).val()).draw();
        });
        sub_table.buttons().container().appendTo('#sub_buttons');
        $('#sub_search').keyup(function () { // custom search box
            sub_table.search($(this).val()).draw();
        });
        document.getElementById("sub_search").addEventListener("search", function (event) { // search clear button clicked
            sub_table.search('').draw();
        });
        $('#sub_table tbody').on('click', '#edit', function () { // edit from action menu
            let row = sub_table.row($(this).parents('tr')).data();
            $scope.newUnit({ edit: true, sub: true, data: row });
        });
        $('#sub_table tbody').on('click', '#delete', function () { // delete from action menu
            let row = sub_table.row($(this).parents('tr')).data();
            $scope.confDel({ data: row, sub: true });
        });
        $('#sub_table').on('error.dt', function (e, settings, techNote, message) {
            //$scope.showAlert({ success: false, type: 'danger', error: message });
        })
        /************************************************************************************* */
        setInterval(function () { // auto refresh after 10 minutes
            table.page.len(-1).ajax.reload();
            sub_table.ajax.reload();
        }, 600000);
    });
}]);