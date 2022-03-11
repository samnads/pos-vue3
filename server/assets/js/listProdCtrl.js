app.controller("listProdCtrl", ['$scope', '$http', '$log', '$window', '$document', '$timeout', '$cookies', '$localStorage', '$q', function ($scope, $http, $log, $window, $document, $timeout, $cookies, $localStorage, $q) {
    $scope.init = function () {
        $scope.SET.defLength = 5;
    };
    $scope.editProd = function (product) {
        $window.location.href = $scope.baseUrl + "admin/product/edit/" + product['id'];
    };
    $scope.copyProd = function (product) {
        $window.location.href = $scope.baseUrl + "admin/product/copy/" + product['id'];
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
            $scope.product = null;
            $scope.infoSpinner = true;
        });
        getProdCan.resolve();
        getProdCan = $q.defer();
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/product",
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
                $scope.product = response.data['data'];
            } else {
                $scope.product = null;
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
            url: $scope.baseUrl + "admin/ajax/product",
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
                "url": $scope.baseUrl + "admin/ajax/product",
                "contentType": "application/json",
                "data": function (d) {
                    d['action'] = "datatable";
                    return d;
                },
            },
            drawCallback: function (settings) {
                $scope.debug ? $log.log("DataTable drawCallback !") : undefined;
                let rows = table.rows('.selected').data().toArray();
                table.button(4).enable(rows.length >= 1);
                table.button(5).enable(rows.length >= 1);
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
                zeroRecords: "No matching products found",
                info: "Showing _START_ to _END_ of _TOTAL_ Products",
                infoEmpty: "No product info found",
                emptyTable: "No products found",
                infoFiltered: "(filtered from _MAX_ Products)",
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
                [2, 'desc']
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
                    text: '<i class="fa fa-trash" aria-hidden="true"></i>',
                    className: 'btn-light',
                    enabled: false,
                    action: function () {
                        $scope.rows = table.rows('.selected').data().toArray();
                        $scope.confDel($scope.rows);
                    },
                    attr: {
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
                    text: '<i class="fa fa-barcode" aria-hidden="true"></i>',
                    className: 'btn-light',
                    enabled: false,
                    action: function () {
                        $scope.codes = [];
                        $scope.rows = table.rows('.selected').data().toArray();
                        angular.forEach($scope.rows, function (value, key) {
                            $scope.codes.push(value.code);
                        });
                        //$cookies.put('tempLabelPrint', JSON.stringify($scope.codes), {path: "/"});
                        $localStorage.tempLabelsPrint = $scope.codes; // save
                        $window.location = $scope.baseUrl + "admin/product/print"; // redirect
                    },
                    attr: {
                        title: 'Print',
                        id: 'print'
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
                        $window.location = $scope.baseUrl + "admin/product/new"; // redirect
                    },
                    attr: {
                        title: 'Add New',
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
                data: "thumbnail"
            },
            {
                data: "id"
            },
            {
                data: "code"
            },
            {
                data: "name"
            },
            {
                data: "brand_name"
            },
            {
                data: "category_name"
            },
            {
                data: "mrp"
            },
            {
                data: "quantity"
            },
            {
                data: "unit_code"
            },
            {
                data: "cost"
            },
            {
                data: "price"
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
                "orderable": false,
                "searchable": false,
                "className": "text-center",
                'render': function (data, type, full, meta) {
                    return '<img src="' + (data || "../gd/50/50") + '" class="rounded thumbnail"/>';
                }
            },
            {
                "targets": [2],
                "visible": false,
                "searchable": false,
            },
            {
                "targets": [7],
                "render": function (data, type, row, meta) {
                    return data == null ? '<i class="text-muted small">-</i>' : parseFloat(data).toFixed(2);;
                }
            },
            {
                "targets": [8],
                "className": "text-center",
                "render": function (data, type, row, meta) {
                    return data == 0 ? '<i class="text-secondary small">' + parseFloat(data).toFixed(2) + '</i>' : parseFloat(data).toFixed(2);
                }
            },
            {
                "targets": [9]
            },
            {
                "targets": [10],
                "render": function (data, type, row, meta) {
                    return data == null ? '<i class="text-muted small">-</i>' : parseFloat(data).toFixed(2);
                }
            },
            {
                "targets": [11],
                "render": function (data, type, row, meta) {
                    return parseFloat(data).toFixed(2);
                }
            },
            {
                "targets": -1,
                "orderable": false,
                "searchable": false,
                "width": "2%",
                "defaultContent": "<div class='btn-group dropleft'><button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action</button><div class='dropdown-menu'><a id='info' class='dropdown-item' href='#'><i class='fa fa-info fa-fw' aria-hidden='true'></i>Details</a> <a class='dropdown-item' id='edit' href='#'><i class='fa fa-edit fa-fw' aria-hidden='true'></i>Edit</a><a class='dropdown-item' id='copy' href='#'><i class='fa fa-copy fa-fw' aria-hidden='true'></i>Duplicate</a> <a class='dropdown-item' href='#'><i class='fa fa-shopping-cart fa-fw' aria-hidden='true'></i>Add to POS</a><div class='dropdown-divider'></div><a class='dropdown-item' id='delete' href='#'><i class='fa fa-trash fa-fw' aria-hidden='true'></i>Delete</a> </div></div>"
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
            table.button(5).enable($scope.rows.length >= 1);
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