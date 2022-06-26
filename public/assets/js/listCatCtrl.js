app.controller("listCatCtrl", ['$scope', '$http', '$log', '$window', '$document', '$timeout', '$rootScope', '$cookies', '$filter', '$localStorage', '$q', function ($scope, $http, $log, $window, $document, $timeout, $rootScope, $cookies, $filter, $localStorage, $q) {
    $scope.SET.defLength = 10;
    $scope.showCatForm = function (data) { // newCatCtrl.js
        $rootScope.$emit("showCatForm", data);
    };
    /*************************************************************************/
    $rootScope.$on("catAdded", function (event, data) {
        $scope.showAlert(data);
        $('#catTable').DataTable().ajax.reload(null, true)
    });
    $rootScope.$on("catUpdated", function (event, data) {
        $scope.showAlert(data);
        $('#catTable').DataTable().ajax.reload(null, true);
    });
    $rootScope.$on("subCatAdded", function (event, data) {
        $scope.showAlert(data);
        $('#subCatTable').DataTable().ajax.reload(null, true);
    });
    $rootScope.$on("subCatUpdated", function (event, data) {
        $scope.showAlert(data);
        $('#subCatTable').DataTable().ajax.reload(null, true);
    });
    /*************************************************************************/
    $scope.showCat = function (product) { // show cat info modal
        $scope.catInfo = product;
        $scope.$digest();
        $('#catInfo').modal('show');
    };
    /*************************************************************************/
    var getCatCan = $q.defer();
    $scope.getCat = function (row) { // get category info when click on row
        $scope.$apply(function () {
            $scope.product = null;
            $scope.infoSpinner = true;
        });
        getCatCan.resolve();
        getCatCan = $q.defer();
        $http({
            method: "GET",
            url: $scope.baseUrl + "admin/ajax/category",
            dataType: 'json',
            params: {
                action: 'getInfo',
                id: row['c_id']
            },
            headers: {
                "Content-Type": "application/json"
            },
            timeout: getCatCan.promise
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
            $('#catInfo').modal('hide');
        });
    };
    /*************************************************************************/
    $scope.confDel = function (data = {}) { // show confirm box
        $scope.delData = data.data;
        $('#singDel').modal('show');
        $scope.$digest();
    };
    /*************************************************************************/
    $scope.confDelInfo = function () { // hide info & show confirm box
        $('#catInfo').modal('hide') && $('#singDel').modal('show');
    };
    /*************************************************************************/// do delete
    $scope.delete = function () {
        $http({
            method: "DELETE",
            url: $scope.baseUrl + "admin/ajax/category",
            dataType: 'json',
            data: {
                data: $scope.delData
            },
            headers: {
                "Content-Type": "application/json"
            }
        }).then(function (response) {
            if (response.data.success == true) { // delete success
                if ($scope.delData.category) {
                    $('#subCatTable').DataTable().ajax.reload(null, true);
                }
                else {
                    $('#catTable').DataTable().ajax.reload(null, true);
                }
            } else {

            }
            $('#singDel').modal('hide');
            $scope.mkAlert(response.data);
        }, function (response) { });
    };
    /*************************************************************************/
    $scope.loadSubCat = function (id) {
        $scope.subCatTable = false;
        $("#subCatTable").dataTable().fnDestroy();
        subTable = $('#subCatTable').DataTable({
            "ajax": {
                "method": "GET",
                "url": $scope.baseUrl + "admin/ajax/category",
                "contentType": "application/json",
                "data": function (d) {
                    d['action'] = "subdatatable"
                    d['id'] = id;
                    return d;
                },
            },
            "initComplete": function (settings) {
                $scope.subCatTable = true;
                subTable = $('#subCatTable').DataTable();
                subTable.buttons().container().appendTo('#sub_buttons');
                $scope.$digest();
                $scope.playAudio();
            },
            "searching": true, // remove default search box
            "bLengthChange": false, // remove default length change menu
            'dom': 'lBtipr',
            'deferRender': true,
            'rowId': 'sc_id',
            'select': true,
            "searchDelay": 750,
            "processing": true,
            "serverSide": true,
            "language": {
                "processing": '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>',
                "emptyTable": "No data available in table",
                "zeroRecords": "No matching sub categories found for your search",
                "info": "Showing _START_ to _END_ of _TOTAL_ Sub Categories",
                "emptyTable": "No sub categories found",
                "infoFiltered": "(filtered from _MAX_ Sub Categories)",
                "lengthMenu": "Show _MENU_&nbsp;&nbsp;"
            },
            'order': [
                [2, 'desc']
            ],
            "paging": true,
            "pagingType": "simple_numbers",
            "columns": [
                {
                    data: "image"
                },
                {
                    data: "name"
                },
                {
                    data: "code"
                },
                {
                    data: "slug"
                },
                {
                    data: "count_product",
                    className: 'text-center',
                },
                {
                    data: "count_brand",
                    className: 'text-center',
                },
                {
                    data: null
                }
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                    "searchable": false,
                    "className": "text-center",
                    "width": "2%",
                    'render': function (data, type, full, meta) {
                        return '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAH0lEQVR42mNk+P+/noGKgHHUwFEDRw0cNXDUwJFqIAAczzHZPJWe1QAAAABJRU5ErkJggg==" class="rounded thumbnail"/>';
                    }
                }, {
                    "targets": -1,
                    "orderable": false,
                    "searchable": false,
                    "className": "text-center",
                    "width": "2%",
                    "defaultContent": "<div class='btn-group dropleft'><button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action</button><div class='dropdown-menu'><a id='info' class='dropdown-item' href='#'><i class='fa fa-info' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Details</a> <a class='dropdown-item' id='edit' href='#'><i class='fa fa-edit' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;&nbsp;Edit</a><a class='dropdown-item' id='copy' href='#'><i class='fa fa-copy' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;&nbsp;Duplicate</a> <div class='dropdown-divider'></div><a class='dropdown-item' id='delete' href='#'><i class='fa fa-trash' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;&nbsp;Delete</a> </div></div>"
                }
            ],
            'buttons': [
                {
                    text: '<i class="fas fa-plus-square"></i>',
                    className: 'btn btn-light',
                    enabled: true,
                    action: function () {
                        $scope.subcat = true;
                        $scope.showCatForm({ data: $scope.catRow, sub: true });
                    },
                    attr: {
                        title: 'Add Subcategory',
                        id: 'addsubcat'
                    },
                    key: {
                        key: 'd',
                        shiftKey: true
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('dt-button')
                    }
                }
            ]
        });
    };
    /*************************************************************************/
    $document.ready(function () {
        subTable = $('#subCatTable').DataTable();
        //
        var catTable = $('#catTable').DataTable({
            "ajax": {
                "method": "GET",
                "url": $scope.baseUrl + "admin/ajax/category",
                "contentType": "application/json",
                "data": function (d) {
                    d['action'] = "datatable";
                    return d;
                },
            },
            "drawCallback": function (settings) {
                $scope.subCatTable = false; // hide sub cat table when redraw
                $scope.db.tableCats = catTable.rows().data().toArray(); // save current table rows
                //$scope.debug ? $log.log("Loaded Table Data : ") : undefined;
                //$scope.debug ? $log.log($scope.db.tableCats) : undefined;
                $scope.$digest();
            },
            "initComplete": function (settings) { // after loading
            },
            "searching": true, // remove default search box
            "bLengthChange": false, // remove default length change menu
            'dom': 'lBtipr',
            'deferRender': true,
            'rowId': 'id',
            pageLength: $scope.SET.defLength,
            'select': true,
            "searchDelay": 750,
            "processing": true,
            "serverSide": true,
            "language": {
                "processing": '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>',
                "emptyTable": "No data available in table",
                "zeroRecords": "No matching categories found for your search",
                "info": "Showing _START_ to _END_ of _TOTAL_ Categories",
                "emptyTable": "No categories found",
                "infoFiltered": "(filtered from _MAX_ Categories)",
                "lengthMenu": "Show _MENU_&nbsp;&nbsp;"
            },
            'order': [
                [0, 'desc']
            ],
            "paging": true,
            "pagingType": "simple_numbers",
            'buttons': [{
                text: '<i class="fa fa-sync-alt" aria-hidden="true"></i>',
                className: 'btn btn-light',
                action: function () {
                    catTable.ajax.reload();
                },
                attr: {
                    title: 'Refresh',
                    id: 'refresh'
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
                text: '<i class="fas fa-plus"></i>',
                className: 'btn btn-light',
                enabled: true,
                action: function () {
                    $scope.showCatForm();
                },
                attr: {
                    title: 'Add Category',
                    id: 'addcat'
                },
                key: {
                    key: 'd',
                    shiftKey: true
                },
                init: function (api, node, config) {
                    $(node).removeClass('dt-button')
                }
            }
            ],
            "columns": [
                {
                    data: "image"
                },
                {
                    data: "name"
                },
                {
                    data: "code"
                },
                {
                    data: "slug"
                },
                {
                    data: "sc_count",
                    className: 'text-center',
                },
                {
                    data: "p_count",
                    className: 'text-center',
                },
                {
                    data: "b_count",
                    className: 'text-center',
                },
                {
                    data: null
                },
                {
                    data: null
                }
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                    "searchable": false,
                    "className": "text-center",
                    "width": "2%",
                    'render': function (data, type, full, meta) {
                        return '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAH0lEQVR42mNk+P+/noGKgHHUwFEDRw0cNXDUwJFqIAAczzHZPJWe1QAAAABJRU5ErkJggg==" class="rounded thumbnail"/>';
                    }
                },
                {
                    "targets": [1],
                },
                {
                    "targets": [5],
                    "visible": true,
                    "searchable": true,
                    'render': function (data, type, full, meta) {
                        return '<button type="button" class="btn btn-info btn-sm">Show <span class="badge badge-light">' + data + '</span></button>';
                    }
                },
                {
                    "targets": -2,
                    "orderable": false,
                    "searchable": false,
                    "width": "2%",
                    "className": "text-center",
                    "defaultContent": "<button type='button' class='btn btn-success btn-sm' id='addsubcat' title='Add Sub Category'><i class='fas fa-plus'></i></button>"
                },
                {
                    "targets": -1,
                    "orderable": false,
                    "searchable": false,
                    "width": "2%",
                    "defaultContent": "<div class='btn-group dropleft'><button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action</button><div class='dropdown-menu'><a id='info' class='dropdown-item' href='#'><i class='fa fa-info' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Details</a> <a class='dropdown-item' id='edit' href='#'><i class='fa fa-edit' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;&nbsp;Edit</a><a class='dropdown-item' id='copy' href='#'><i class='fa fa-copy' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;&nbsp;Duplicate</a> <div class='dropdown-divider'></div><a class='dropdown-item' id='delete' href='#'><i class='fa fa-trash' aria-hidden='true'></i>&nbsp;&nbsp;&nbsp;&nbsp;Delete</a> </div></div>"
                }
            ]
        });
        /*************************************************************************/
        setInterval(function () { // auto refresh after 10 minutes
            catTable.ajax.reload();
        }, 600000);
        /*************************************************************************/
        catTable.on('select deselect', function () {
            $timeout(function () {
                $scope.$digest();
            });
        });
        /*************************************************************************/
        subTable.on('select deselect', function () {
            $scope.subCatRows = subTable.rows('.selected').data().toArray();
            $timeout(function () {
                $scope.$digest();
            });
        });
        /* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
        $('#catInfo #delete').on('click', function () { // delete from product info menu
            $scope.catRow = catTable.row($(this).parents('tr')).data();
            $scope.confDel({ data: catTable.row($(this).parents('tr')).data() });
        });
        /* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
        $('#catTable tbody').on('click', '#delete', function () { // delete from action menu
            $scope.catRow = catTable.row($(this).parents('tr')).data();
            $scope.confDel({ data: catTable.row($(this).parents('tr')).data() });
        });
        /* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
        $('#catTable tbody').on('click', '#edit', function () { // edit from action menu
            $scope.showCatForm({ data: catTable.row($(this).parents('tr')).data(), edit: true });
        });
        /* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
        $('#catTable tbody').on('click', '#copy', function () { // copy from action menu
            $scope.showCatForm(catTable.row($(this).parents('tr')).data(), false, true);
        });
        /* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
        $('#catTable tbody').on('click', '#info', function () { // product info from action menu
            $scope.showCat(catTable.row($(this).parents('tr')).data());
        });
        /* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
        $('#catTable tbody').on('click', 'td:not(:first-child):not(:nth-child(9)):not(:last-child)', function () { // show sub cat table
            $scope.catRow = catTable.row(this).data();
            $scope.db.selTableCat = catTable.row(this).data();
            $scope.debug ? $log.log("Cat Row Clicked : ") + $log.log($scope.db.selTableCat) : undefined;
            $scope.subCatTable = true;
            $scope.$digest();
            $scope.loadSubCat($scope.catRow.id);
        });
        /* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
        $('#catTable').on('page.dt', function () { // on page is updated

        });
        /* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
        $('#catTable tbody').on('click', '#addsubcat', function () { // new subcat from row button
            $scope.showCatForm({ data: catTable.row($(this).parents('tr')).data(), sub: true });
        });
        /* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
        $('#catTable tbody').on('click', 'tr', function () {
            $("#catTable tbody tr").removeClass('bg-info'); // remove all tr class

            $(this).addClass('bg-info');
            //$log.log(this);
        });
        /* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
        $('#subCatTable tbody').on('click', '#delete', function () { // sub cat delete from action menu
            $scope.catRow = subTable.row($(this).parents('tr')).data();
            $scope.confDel({ data: subTable.row($(this).parents('tr')).data(), sub: true });
        });
        /* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
        $('#subCatTable tbody').on('click', '#edit', function () { // sub cat edit from action menu
            $scope.db.selTableCat = $filter('filter')($scope.db.tableCats, { id: $scope.catRow.id }, true); // get selected tax row
            $scope.db.selTableCat = $scope.db.selTableCat[0];
            $log.log($scope.db.selTableCat);
            $scope.showCatForm({ data: subTable.row($(this).parents('tr')).data(), edit: true, sub: true });
        });
        /* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
        $('#length_change').change(function () { // custom length change menu
            catTable.page.len($(this).val()).draw();
        });
        catTable.buttons().container().appendTo('#buttons');
        $('#search').keyup(function () { // custom search box
            catTable.search($(this).val()).draw();
        });
        document.getElementById("search").addEventListener("search", function (event) { // search clear button clicked
            catTable.search('').draw();
        });
        /* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
        $('#sub_length_change').change(function () { // custom length change menu
            subTable.page.len($(this).val()).draw();
        });

        $('#sub_search').keyup(function () { // custom search box
            subTable.search($(this).val()).draw();
        });
        document.getElementById("sub_search").addEventListener("search", function (event) { // search clear button clicked
            subTable.search('').draw();
        });
    });
}]);