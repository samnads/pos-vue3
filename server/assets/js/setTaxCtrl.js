app.controller("setTaxCtrl", ['$scope', '$http', '$log', '$window', '$document', '$timeout', '$rootScope', '$cookies', '$filter', '$localStorage', '$q', function ($scope, $http, $log, $window, $document, $timeout, $rootScope, $cookies, $filter, $localStorage, $q) {
	$scope.init = function () {
		$scope.SET.defLength = 5;
	};
	$scope.showTaxForm = function (data) { // newTaxCtrl.js
		$rootScope.$emit("showTaxForm", data);
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.taxInfoModal = function (tax) { // show cat info modal
		$scope.taxInfo = tax;
		$scope.$digest();
		$('#taxInfoModal').modal('show');
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$rootScope.$on("taxAdded", function (event, data = {}) { // new tax added
		$scope.mkAlert(data);
		$('#taxTable').DataTable().ajax.reload(null, false);
	});
	$rootScope.$on("taxEdited", function (event, data) { // new tax added
		$scope.mkAlert(data);
		$('#taxTable').DataTable().ajax.reload(null, false);
	});
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.bulkCheckTaxes = function () { // on click bulk checkbox
		var taxTable = $('#taxTable').DataTable();
		$scope.taxRows = taxTable.rows('.selected').data().toArray();
		if ($scope.taxRows.length == taxTable.data().count()) {
			taxTable.rows().deselect();
			$scope.checkall = false;
		} else {
			taxTable.rows().select();
			$scope.checkall = true;
			$scope.taxRows = taxTable.rows('.selected').data().toArray();
		}
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.confDel = function (data, is_subcat = false) { // show confirm box
		$scope.subcat = is_subcat;
		if (data.constructor === Array) {
			$scope.taxRows = data;
			$('#bulkDel').modal('show');
		} else {
			$scope.taxRow = data;
			$('#singDel').modal('show');
		}
		$scope.$digest();
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.confDelInfo = function () { // hide info & show confirm box
		$('#taxInfoModal').modal('hide') && $('#singDel').modal('show');
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.delete = function (bulk) { // do delete cats
		$http({ // delete from server
			method: "DELETE",
			url: $scope.baseUrl + "admin/ajax/tax",
			dataType: 'json',
			data: {
				data: bulk ? $scope.taxRows : $scope.taxRow
			},
			headers: {
				"Content-Type": "application/json"
			}
		}).then(function (response) {
			if (response.data.success == true) { // delete success
				$scope.checkalltaxes = false;
				$('#taxTable').DataTable().ajax.reload(null, false);
			} else {
			}
			bulk ? $('#bulkDel').modal('hide') : $('#singDel').modal('hide');
			$scope.mkAlertRes(response.data);
		}, function (response) { });
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$document.ready(function () {
		$.fn.dataTable.ext.errMode = function (settings, helpPage, message) { };
		var taxTable = $('#taxTable').DataTable({
			"ajax": {
				"method": "GET",
				"url": $scope.baseUrl + "admin/ajax/tax",
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
				$scope.db.tableCats = taxTable.rows().data().toArray(); // save current table rows
				$scope.$digest();
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
				"zeroRecords": "No matching tax rates found for your search",
				"info": "Showing _START_ to _END_ of _TOTAL_ Tax Rates",
				"emptyTable": "No taxes found",
				"infoFiltered": "(filtered from _MAX_ Tax Rates)",
				"lengthMenu": "Show _MENU_&nbsp;&nbsp;"
			},
			'select': {
				style: 'multi',
				selector: 'td:first-child'
			},
			'order': [
				[6, 'desc']
			],
			"paging": true,
			"pagingType": "simple_numbers",
			'buttons': [
				{
					text: '<i class="fa fa-sync-alt" aria-hidden="true"></i>',
					className: 'btn-light',
					action: function () {
						taxTable.ajax.reload();
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
					text: '<i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete',
					className: 'btn-light',
					enabled: false,
					action: function () {
						$scope.taxRows = taxTable.rows('.selected').data().toArray();
						$scope.confDel($scope.taxRows);
					},
					attr: {
						title: 'Delete Taxe',
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
					text: '<i class="fas fa-plus"></i>&nbsp;New',
					className: 'btn-light',
					enabled: true,
					action: function () {
						$scope.showTaxForm();
					},
					attr: {
						title: 'Add New Tax Rate',
						id: 'addtax'
					},
					key: {
						key: 'n',
						shiftKey: true
					},
					init: function (api, node, config) {
						$(node).removeClass('btn-secondary');
					}
				}
			],
			"columns": [{
				data: $scope.debug ? "id" : null,

			},
			{
				data: "name"
			},
			{
				data: "code"
			},
			{
				data: "rate"
			},
			{
				data: "type"
			},
			{
				data: "description",
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
				"defaultContent": '',
				"searchable": false,
				"orderable": false,
				"className": 'select-checkbox',
				"width": "2%"
			},
			{
				"targets": [3],
				"visible": true,
				"searchable": true,
				"className": "text-center",
			},
			{
				"targets": [4],
				"visible": true,
				"searchable": true,
				"className": "text-center",
				"render": function (data, type, row, meta) {
					if (data === 'P') {
						return '<span class="badge badge-secondary">%</span>';
					}
					return '<span class="badge badge-warning">Fixed Rate</span>';
				}
			},
			{
				"targets": [5],
				"visible": true,
				"searchable": true,
				"className": "text-center",
				'render': function (data, type, row, meta) {
					return (data === null) ? '<i class="text-muted small">NIL</i>' : data;
				},
			},
			{
				"targets": [6],
				"visible": false,
				"searchable": false
			},
			{
				"targets": -1,
				"orderable": false,
				"searchable": false,
				"width": "2%",
				"defaultContent": "<div class='btn-group dropleft'><button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action</button><div class='dropdown-menu'><a id='info' class='dropdown-item' href='#'><i class='fa fa-info fa-fw' aria-hidden='true'></i>Details</a> <a class='dropdown-item' id='edit' href='#'><i class='fa fa-edit fa-fw' aria-hidden='true'></i>Edit</a><div class='dropdown-divider'></div><a class='dropdown-item' id='delete' href='#'><i class='fa fa-trash fa-fw' aria-hidden='true'></i>Delete</a> </div></div>"
			}
			]
		});
		/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
		setInterval(function () { // auto refresh after 10 minutes
			taxTable.ajax.reload();
		}, 600000);
		/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
		taxTable.on('select deselect', function () {
			$scope.taxRows = taxTable.rows('.selected').data().toArray();
			taxTable.button(1).enable($scope.taxRows.length > 0);

			if ($scope.taxRows.length < taxTable.data().count()) {
				$scope.checkalltaxes = false;
			} else if ($scope.taxRows.length == taxTable.data().count()) {
				$scope.checkalltaxes = true;
			}
			$timeout(function () {
				$scope.$digest();
			});
		});
		/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
		$('#taxTable tbody').on('click', '#info', function () { // tax info from action menu
			$scope.taxRow = taxTable.row($(this).parents('tr')).data();
			$scope.taxInfoModal($scope.taxRow);
		});
		/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
		$('#taxTable tbody').on('click', '#edit', function () { // edit from action menu
			$scope.taxRow = taxTable.row($(this).parents('tr')).data();
			$scope.showTaxForm({ data: $scope.taxRow, edit: true });
		});
		/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
		$('#taxTable tbody').on('click', '#delete', function () { // delete from action menu
			$scope.taxRow = taxTable.row($(this).parents('tr')).data();
			$scope.confDel($scope.taxRow);
		});


		$('#length_change').change(function () { // custom length change menu
			taxTable.page.len($(this).val()).draw();
		});
		taxTable.buttons().container().appendTo('#buttons');
		$('#search').keyup(function () { // custom search box
			taxTable.search($(this).val()).draw();
		});
		document.getElementById("search").addEventListener("search", function (event) { // search clear button clicked
			taxTable.search('').draw();
		});
	});
}]);