app.controller("listStockAdjCtrl", ['$scope', '$http', '$log', '$window', '$document', '$timeout', '$cookies', '$localStorage', '$q', function ($scope, $http, $log, $window, $document, $timeout, $cookies, $localStorage, $q) {
    $scope.init = function () {
        $scope.SET.defLength = 10;
    };
    $scope.editProd = function (product) {
        $window.location.href = $scope.baseUrl + "admin/stock_adjustment/edit/" + product['id'];
    };
    $scope.copyProd = function (product) {
        $window.location.href = $scope.baseUrl + "admin/stock_adjustment/copy/" + product['id'];
    };
    $scope.showProd = function (product) {
        $scope.row = product;
        $scope.getProd($scope.row);
        $scope.$digest();
        $('#prodInfo').modal('show');
    };
    $scope.add_label = function (id) {
        //$cookies.put('tempLabelPrint', id, {path: "/"});
        $localStorage.tempLabelsPrint = id;
        $window.location = $scope.baseUrl + "admin/product/print";
    };
    var getProdCan = $q.defer();
    $scope.getProd = function (row) { // get product info when click on row
        $scope.$apply(function () {
            $scope.products = null;
            $scope.infoSpinner = true;
        });
        getProdCan.resolve();
        getProdCan = $q.defer();
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/stock_adjustment",
            dataType: 'json',
            params: {
                action: 'getInfo',
                id: row['id']
            },
            headers: {
                "Content-Type": "application/json"
            },
            timeout: getProdCan.promise
        }).then(function (response) {
            $scope.infoSpinner = false;
            if (response.data.success == true) {
                $scope.products = response.data['data'];
            } else {
                $scope.products = null;
            }
        }, function (response) {
            $log.log(response);
            if (response.xhrStatus == 'error') {
                $window.alert("Network Error !");
            } else {

            }
            $('#prodInfo').modal('hide');
        });
    }
    $scope.confDel = function (product) { // show confirm box
        if (product.constructor === Array) {
            $scope.rows = product;
            $('#bulkDel').modal('show');
        } else {
            $scope.row = product;
            $('#singDel').modal('show');
        }
        $scope.$digest();
    };
    $scope.confDelInfo = function () { // hide info & show confirm box
        $('#prodInfo').modal('hide') && $('#singDel').modal('show');
    };
    $scope.bulkCheck = function () { // on click bulk checkbox
        var table = $('#productsTable').DataTable();
        $scope.rows = table.rows('.selected').data().toArray();
        if ($scope.rows.length == table.data().count()) {
            table.rows().deselect();
            $scope.checkall = false;
        } else {
            table.rows().select();
            $scope.checkall = true;
            $scope.rows = table.rows('.selected').data().toArray();
        }
    };
    $scope.delete = function (bulk) { // do delete products
        $http({ // delete from server
            method: "DELETE",
            url: $scope.baseUrl + "admin/ajax/stock_adjustment",
            dataType: 'json',
            data: {
                action: 'delete',
                bulk: bulk,
                data: bulk ? $scope.rows : $scope.row
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            if (response.data.location) {
                $window.location.href = $scope.baseUrl + response.data.location;
            }
            else {
                if (response.data.success == true) { // delete success
                    $scope.checkall = false;
                    $('#productsTable').DataTable().ajax.reload();
                } else {

                }
                bulk ? $('#bulkDel').modal('hide') : $('#singDel').modal('hide');
                $scope.mkAlertRes(response.data);
            }
        }, function (response) { });
    };
    $document.ready(function () {
        $.fn.dataTable.ext.errMode = function (settings, helpPage, message) { };
        var table = $('#productsTable').DataTable({
            ajax: {
                "method": "GET",
                "url": $scope.baseUrl + "admin/ajax/stock_adjustment",
                "contentType": "application/json",
                "data": function (d) {
                    d['action'] = "datatable";
                    return d;
                },
                dataSrc: function (json) {
                    if (json.data) {
                        return json.data;
                    } else {
                        $scope.showAlert(json);
                        return [];
                    }
                }
            },
            drawCallback: function (settings) {
                $scope.debug ? $log.log("DataTable drawCallback !") : undefined;
                let rows = table.rows('.selected').data().toArray();
                table.button(4).enable(rows.length >= 1);
            },
            rowCallback: function (row, data) {
                $scope.debug ? $log.log("DataTable rowCallback : ") + $log.log(data['id']) : undefined;
            },
            initComplete: function (settings) {
                $scope.debug ? $log.log("DataTable initComplete !") : undefined;
            },
            searching: true, // remove default search box
            bLengthChange: false, // remove default length change menu
            pageLength: $scope.SET.defLength,
            searchDelay: 750,
            processing: true,
            serverSide: true,
            language: {
                processing: '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>',
                emptyTable: "No data available in table",
                zeroRecords: "No matching adjustments found",
                info: "Showing _START_ to _END_ of _TOTAL_ Adjustments",
                infoEmpty: "No adjustment info found",
                emptyTable: "No adjustments found",
                infoFiltered: "(filtered from _MAX_ Adjustments)",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": '<i class="fas fa-caret-right"></i>',
                    "previous": '<i class="fas fa-caret-left"></i>'
                },
            },
            'dom': 'lBtipr',
            'deferRender': true,
            'select': {
                'style': 'multi',
                'selector': 'td:first-child'
            },
            'responsive': true,
            'colReorder': {
                'fixedColumnsLeft': 1,
                'fixedColumnsRight': 1
            },
            'order': [
                [9, 'desc']
            ],
            'buttons': [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i>',
                    className: 'btn-light',
                    exportOptions: {
                        columns: [2, 3, 4, 5, 6, 7]
                    },
                    attr: {
                        'data-toggle': 'tooltip',
                        title: "Download Excel"
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i>',
                    className: 'btn-light',
                    attr: {
                        'data-toggle': 'tooltip',
                        title: "Download PDF"
                    },
                    exportOptions: {
                        columns: [2, 3, 4, 5, 6, 7]
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i>',
                    className: 'btn-light',
                    exportOptions: {
                        columns: [2, 3, 4, 5, 6, 7]
                    },
                    attr: {
                        'data-toggle': 'tooltip',
                        title: "Print"
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                },
                {
                    text: '<i class="fa fa-sync-alt" aria-hidden="true"></i>',
                    className: 'btn-light',
                    action: function () {
                        table.ajax.reload();
                    },
                    attr: {
                        'data-toggle': 'tooltip',
                        title: "Refresh",
                        id: "refresh"
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
                    text: '<i class="fa fa-trash" aria-hidden="true"></i>',
                    className: 'btn-light',
                    enabled: false,
                    action: function () {
                        $scope.rows = table.rows('.selected').data().toArray();
                        $scope.confDel($scope.rows);
                    },
                    attr: {
                        'data-toggle': 'tooltip',
                        title: 'Delete',
                        id: 'delete'
                    },
                    key: {
                        key: 'd',
                        shiftKey: true
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                },
                {
                    text: '<i class="fa fa-plus" aria-hidden="true"></i>',
                    className: 'btn-light',
                    action: function () {
                        $window.location = $scope.baseUrl + "admin/stock_adjustment/new"; // redirect
                    },
                    attr: {
                        'data-toggle': 'tooltip',
                        title: 'New',
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
            "columns": [{
                data: null,
            },
            {
                data: "id"
            },
            {
                data: "date"
            },
            {
                data: "reference_no"
            },
            {
                data: "warehouse_name"
            },
            {
                data: "total_products"
            },
            {
                data: "added_by"
            },
            {
                data: "note"
            },
            {
                data: null
            },
            {
                data: "updated_at"
            },
            {
                data: null
            }
            ],
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "className": 'select-checkbox',
                "width": "2%",
                "searchable": false,
                "defaultContent": '',
            }, {
                "targets": [1],
                "visible": false,
                "orderable": false,
                "searchable": false,
                'render': function (data, type, full, meta) {
                    return data;
                }
            },
            {
                "targets": [2],
                "visible": true,
                "searchable": true,
            },
            {
                "targets": [3],
                "render": function (data, type, row, meta) {
                    return data == null ? '<i class="text-muted small">NIL</i>' : data;
                }
            },
            {
                "targets": [4],
                "render": function (data, type, row, meta) {
                    return data;
                }
            },
            {
                "targets": [5],
                "className": "text-center",
                "render": function (data, type, row, meta) {
                    return '<span class="badge badge-dark">' + data + '</span>';
                }
            },
            {
                "targets": [6],
                "render": function (data, type, row, meta) {
                    return data == null ? '<i class="text-muted small">NIL</i>' : data;
                }
            },
            {
                "targets": [7],
                "render": function (data, type, row, meta) {
                    return data == null ? '<i class="text-muted small">NIL</i>' : data;
                }
            },
            {
                "targets": [8],
                "className": "text-center",
                "defaultContent": '<i class="fas fa-paperclip"></i>'
            },
            {
                "targets": [9],
                "visible": false,
            },
            {
                "targets": -1,
                "orderable": false,
                "searchable": false,
                "width": "2%",
                "defaultContent": "<div class='btn-group dropleft'><button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action</button><div class='dropdown-menu'> <a class='dropdown-item' id='edit' href='#'><i class='fa fa-edit fa-fw' aria-hidden='true'></i>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item' id='delete' href='#'><i class='fa fa-trash fa-fw' aria-hidden='true'></i>Delete</a> </div></div>"
            }
            ]
        });
        $('#prodInfo #delete').on('click', function () { // delete from product info menu
            $scope.row = table.row($(this).parents('tr')).data();
            $scope.confDel($scope.row);
        });
        $('#productsTable tbody').on('click', '#delete', function () { // delete from action menu
            $scope.row = table.row($(this).parents('tr')).data();
            $scope.confDel($scope.row);
        });
        $('#productsTable tbody').on('click', '#edit', function () { // edit from action menu
            $scope.row = table.row($(this).parents('tr')).data();
            $scope.editProd($scope.row);
        });
        $('#productsTable tbody').on('click', '#copy', function () { // duplicate from action menu
            $scope.row = table.row($(this).parents('tr')).data();
            $scope.copyProd($scope.row);
        });
        $('#productsTable tbody').on('click', 'td:not(:first-child):not(:last-child)', function () { // show single product info
            $scope.row = table.row(this).data();
            $scope.showProd($scope.row);
        });
        $('#productsTable tbody').on('click', '#info', function () { // product info from action menu
            $scope.row = table.row($(this).parents('tr')).data();
            $scope.showProd($scope.row);
        });
        $('#productsTable').on('length.dt', function (e, settings, len) { // length change
            /*$scope.rows = undefined;
            table.button(1).disable();
            table.button(2).disable();
            $scope.checkall = false;
            $timeout(function () {
                $scope.$digest();
            });*/
        });
        $('#productsTable').on('page.dt', function () { // page change
            /*$scope.rows = undefined;
            table.button(1).disable();
            table.button(2).disable();
            $scope.checkall = false;
            $timeout(function () {
                $scope.$digest();
            });*/
        });
        table.on('select deselect', function () {
            $scope.rows = table.rows('.selected').data().toArray();
            table.button(4).enable($scope.rows.length >= 1);
            if ($scope.rows.length < table.data().count()) {
                $scope.checkall = false;
            } else if ($scope.rows.length == table.data().count()) {
                $scope.checkall = true;
            }
            $timeout(function () {
                $scope.$digest();
            });
        });
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
    });
}]);