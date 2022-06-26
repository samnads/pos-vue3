app.controller("setSuppCtrl", ['$scope', '$http', '$log', '$window', '$document', '$timeout', '$rootScope', '$cookies', '$filter', '$localStorage', '$q', function ($scope, $http, $log, $window, $document, $timeout, $rootScope, $cookies, $filter, $localStorage, $q) {
	$scope.init = function () {
		$scope.SET.defLength = 5;
	};
	$scope.showSuppForm = function (data) { // newTaxCtrl.js
		$rootScope.$emit("showSuppForm", data);
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.supInfoModal = function (data = {}) { // show cat info modal
		$scope.supplierInfo = data.data;
		$scope.$digest();
		$('#supInfoModal').modal('show');
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$rootScope.$on("supAdded", function (event, data = {}) { // new tax added
		$scope.showAlert(data);
		$('#supTable').DataTable().ajax.reload(null, false);
	});
	$rootScope.$on("supEdited", function (event, data) { // new tax added
		$scope.showAlert(data);
		$('#supTable').DataTable().ajax.reload(null, false);
	});
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.checkAll = function () { // on click bulk checkbox
		var supTable = $('#supTable').DataTable();
		let rows = supTable.rows('.selected').data().toArray();
		if (rows.length == supTable.data().count()) {
			supTable.rows().deselect();
			$scope.checkall = false;
		} else {
			supTable.rows().select();
			$scope.checkall = true;
		}
		$scope.selRows = supTable.rows('.selected').data().toArray();
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.confDel = function (param) { // show confirm box
		$scope.delRows = param.data;
		$('#delModal').modal('show');
		$scope.$digest();
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.confDelInfo = function () { // hide info & show confirm box
		$('#supInfoModal').modal('hide') && $('#delModal').modal('show');
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.delete = function (bulk) { // do delete cats
		$http({ // delete from server
			method: "DELETE",
			url: $scope.baseUrl + "admin/ajax/supplier",
			dataType: 'json',
			data: {
				data: $scope.delRows
			},
			headers: {
				"Content-Type": "application/json"
			}
		}).then(function (response) {
			if (response.data.success == true) { // delete success
				$scope.checkall = false;
				$('#supTable').DataTable().ajax.reload(null, false);
			} else {
			}
			$('#delModal').modal('hide');
			$scope.showAlert(response.data);
		}, function (response) { });
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$document.ready(function () {
		$.fn.dataTable.ext.errMode = function (settings, helpPage, message) { };
		var supTable = $('#supTable').DataTable({
			"ajax": {
				"method": "GET",
				"url": $scope.baseUrl + "admin/ajax/supplier",
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
			"drawCallback": function (settings) {
				//$scope.db.tableSups = supTable.rows().data().toArray(); // save current table rows
				//$scope.$digest();
			},
			"initComplete": function (settings) { // after loading
			},
			'dom': 'lBtipr',
			"searching": true, // remove default search box
			"bLengthChange": false, // remove default length change menu
			"pageLength": $scope.SET.defLength,
			'deferRender': true,
			'rowId': 'id',
			"searchDelay": 750,
			"processing": true,
			"serverSide": true,
			"language": {
				"processing": '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>',
				"emptyTable": "No data available in table",
				"zeroRecords": "No matching suppliers found for your search",
				"info": "Showing _START_ to _END_ of _TOTAL_ Suppliers",
				"emptyTable": "No suppliers found",
				"infoFiltered": "(filtered from _MAX_ Suppliers)"
			},
			'order': [
				[7, 'desc']
			],
			"lengthMenu": [
				[5, 3, 5, 10, 50, -1],
				[5, 3, 5, 10, 50, "All"]
			],
			'select': {
				style: 'multi',
				selector: 'td:first-child'
			},
			"paging": true,
			"pagingType": "simple_numbers",
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
					className: 'btn btn-light',
					action: function () {
						supTable.ajax.reload();
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
						$(node).removeClass('dt-button');
					}
				},
				{
					text: '<i class="fa fa-trash" aria-hidden="true"></i>',
					className: 'btn btn-light',
					enabled: false,
					action: function () {
						$scope.confDel({ data: $scope.selRows });
					},
					attr: {
						title: 'Delete Supplier',
						id: 'delete'
					},
					key: {
						key: 'd',
						shiftKey: true
					},
					init: function (api, node, config) {
						$(node).removeClass('dt-button')
					}
				},
				{
					text: '<i class="fa fa-plus"></i>',
					className: 'btn btn-light',
					enabled: true,
					action: function () {
						$scope.showSuppForm();
					},
					attr: {
						title: 'New Supplier',
						id: 'create'
					},
					key: {
						key: 'n',
						shiftKey: true
					},
					init: function (api, node, config) {
						$(node).removeClass('dt-button')
					}
				}
			],
			"columns": [
				{
					data: null,
				},
				{
					data: "code"
				},
				{
					data: "name"
				},
				{
					data: "place"
				},
				{
					data: "phone"
				},
				{
					data: "email",
				},
				{
					data: "city",
				},
				{
					data: "updated_at",
				},
				{
					data: null
				}
			],
			"columnDefs": [{
				"targets": [0],
				"orderable": false,
				"searchable": false,
				"className": 'select-checkbox',
				"width": "2%",
				"defaultContent": ''
			},
			{
				targets: [1],
				render: function (data, type, row, meta) {
					if (row['editable'] === 0 || row['deletable'] === 0) {
						return data + '<a href="#" class="float-right text-secondary" data-toggle="tooltip" data-placement="right" title="Read-Only"><i class="fas fa-lock"></i></a>';
					}
					return data;
				}
			},
			{
				"targets": [5],
				'render': function (data, type, row, meta) {
					return (data === null) ? '<i class="text-muted small">NIL</i>' : data;
				},
			},
			{
				"targets": [6],
				'render': function (data, type, row, meta) {
					return (data === null) ? '<i class="text-muted small">NIL</i>' : data;
				},
			},
			{
				"targets": [-2],
				"visible": false
			},
			{
				"targets": [-1],
				"orderable": false,
				"searchable": false,
				"width": "2%",
				"defaultContent": "<div class='btn-group dropleft'><button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action</button><div class='dropdown-menu'><a id='info' class='dropdown-item' href='#'><i class='fa fa-info fa-fw' aria-hidden='true'></i>Details</a> <a class='dropdown-item' id='edit' href='#'><i class='fa fa-edit fa-fw' aria-hidden='true'></i>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item' id='delete' href='#'><i class='fa fa-trash fa-fw' aria-hidden='true'></i>Delete</a> </div></div>",
				render: function (data, type, row, meta) {
					let infoBtn = '<button type="button" id="info" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Info"><i class="fas fa-info-circle"></i></button>';
					let editBtn = '<button type="button" id="edit" class="btn btn-' + (row['editable'] !== 0 ? 'primary' : 'secondary') + '"' + (row['editable'] !== 0 ? 'data-toggle="tooltip" data-placement="left" title="Edit"' : '') + (row['editable'] === 0 ? 'disabled' : '') + '><i class="fas fa-pencil-alt"></i></button> ';
					let delBtn = '<button type="button" id="delete" class="btn btn-' + (row['deletable'] !== 0 ? 'danger' : 'secondary') + '"' + (row['deletable'] !== 0 ? 'data-toggle="tooltip" data-placement="left" title="Delete"' : '') + (row['deletable'] === 0 ? 'disabled' : '') + '><i class="fas fa-trash"></i></button>';
					return '<div class="btn-group btn-group-sm" role="group">' + editBtn + infoBtn + delBtn + '</div>';
				}
			}
			]
		});
		/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
		supTable.on('select deselect', function () {
			let rows = supTable.rows('.selected').data().toArray();
			supTable.button(4).enable(rows.length > 0);
			if (rows.length < supTable.data().count()) {
				$scope.checkall = false;
			} else if (rows.length == supTable.data().count()) {
				$scope.checkall = true;
			}
			$scope.selRows = supTable.rows('.selected').data().toArray();
			$timeout(function () {
				$scope.$digest();
			});
		});
		$('#supTable tbody').on('click', '#info', function () { // info from action menu
			$scope.supInfoModal({ data: supTable.row($(this).parents('tr')).data() });
		});
		$('#supTable tbody').on('click', '#delete', function () { // delete from action menu
			$scope.confDel({ data: supTable.row($(this).parents('tr')).data() });
		});
		$('#supTable tbody').on('click', '#edit', function () { // edit from action menu
			$scope.showSuppForm({ data: supTable.row($(this).parents('tr')).data(), edit: true });
		});
		$('#length_change').change(function () { // custom length change menu
			supTable.page.len($(this).val()).draw();
		});
		supTable.buttons().container().appendTo('#buttons');
		$('#search').keyup(function () { // custom search box
			supTable.search($(this).val()).draw();
		});
		document.getElementById("search").addEventListener("search", function (event) { // search clear button clicked
			supTable.search('').draw();
		});
	});
}]);