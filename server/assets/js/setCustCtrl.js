app.controller("setCustCtrl", ['$scope', '$http', '$log', '$window', '$document', '$timeout', '$rootScope', '$cookies', '$filter', '$localStorage', '$q', function ($scope, $http, $log, $window, $document, $timeout, $rootScope, $cookies, $filter, $localStorage, $q) {
	$scope.init = function () {
		$scope.SET.defLength = 10;
		$scope.initCustGroups();
	};
	$scope.showNewCustForm = function (data) { // newCustCtrl.js
		$('#supInfoModal').modal('hide');
		$rootScope.$emit("showNewCustForm", data);
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.supInfoModal = function (data = {}) { // show cat info modal
		$scope.custInfo = data.data;
		$scope.$digest();
		$('#supInfoModal').modal('show');
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$rootScope.$on("custAdded", function (event, data = {}) { // new tax added
		$scope.showAlert(data);
		$('#supTable').DataTable().ajax.reload(null, false);
	});
	$rootScope.$on("custEdited", function (event, data) { // new tax added
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
		$('#supInfoModal').modal('hide') && $('#delModal').modal('show');
		$scope.$digest();
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.delete = function (bulk) { // do delete cats
		$http({ // delete from server
			method: "DELETE",
			url: $scope.baseUrl + "admin/ajax/customer",
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
			ajax: {
				method: "GET",
				url: $scope.baseUrl + "admin/ajax/customer",
				contentType: "application/json",
				data: function (d) {
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
				let rows = supTable.rows('.selected').data().toArray();
				$scope.selRows = rows;
				supTable.button(4).enable(rows.length > 0);
			},
			rowCallback: function (row, data) {
				$scope.debug ? $log.log("DataTable rowCallback : ") + $log.log(data['id']) : undefined;
			},
			initComplete: function (settings) {
				$scope.debug ? $log.log("DataTable initComplete !") : undefined;
			},
			dom: 'lBtipr',
			searching: true, // remove default search box
			bLengthChange: false, // remove default length change menu
			pageLength: $scope.SET.defLength,
			deferRender: true,
			searchDelay: 750,
			processing: true,
			serverSide: true,
			language: {
				processing: '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>',
				emptyTable: "No data available in table",
				zeroRecords: "No matching customers found for your search",
				info: "Showing _START_ to _END_ of _TOTAL_ Customers",
				emptyTable: "No customers found",
				infoFiltered: "(filtered from _MAX_ Customers)"
			},
			order: [
				[8, 'desc']
			],
			select: {
				style: "multi",
				selector: 'td:first-child'
			},
			responsive: {
				details: {
					type: 'column',
					target: 1
				}
			},
			colReorder: {
				fixedColumnsLeft: 1,
				fixedColumnsRight: 1
			},
			buttons: [
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
					attr: {
						'data-toggle': 'tooltip',
						title: "Refresh"
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
						$scope.confDel({ data: $scope.selRows });
					},
					attr: {
						title: 'Delete Customer',
						id: 'delete'
					},
					key: {
						key: 'd',
						shiftKey: true
					},
					attr: {
						'data-toggle': 'tooltip',
						title: "Delete"
					},
					init: function (api, node, config) {
						$(node).removeClass('btn-secondary');
					}
				},
				{
					text: '<i class="fa fa-plus"></i>',
					className: 'btn-light',
					enabled: true,
					action: function () {
						$scope.showNewCustForm();
					},
					attr: {
						title: 'New Customer',
						id: 'create'
					},
					key: {
						key: 'n',
						shiftKey: true
					},
					attr: {
						'data-toggle': 'tooltip',
						title: "New"
					},
					init: function (api, node, config) {
						$(node).removeClass('btn-secondary');
					}
				}
			],
			columns: [
				{
					data: null,
				},
				{
					data: null,
				},
				{
					data: "name"
				},
				{
					data: "group_name"
				},
				{
					data: "place"
				},
				{
					data: "email"
				},
				{
					data: "phone",
				},
				{
					data: "address",
				},
				{
					data: "updated_at",
				},
				{
					data: null
				}
			],
			columnDefs: [
				{
					targets: [0],
					defaultContent: '',
					searchable: false,
					orderable: false,
					className: "select-checkbox",
				},
				{
					targets: [1],
					defaultContent: '',
					className: 'control',
					orderable: false,
				},
				{
					targets: [2],
					responsivePriority: 1,
					render: function (data, type, row, meta) {
						if (row['editable'] === 0 || row['deletable'] === 0) {
							return data + '<a href="#" class="float-right text-secondary" data-toggle="tooltip" data-placement="right" title="Read-Only"><i class="fas fa-lock"></i></a>';
						}
						return data;
					}
				},
				{
					targets: [3],
					responsivePriority: 1
				},
				{
					targets: [4],
					responsivePriority: 1
				},
				{
					targets: [5],
					render: function (data, type, row, meta) {
						return (data === null) ? '<i class="text-muted small">NIL</i>' : data;
					}
				},
				{
					targets: [6],
					render: function (data, type, row, meta) {
						return (data === null) ? '<i class="text-muted small">NIL</i>' : data;
					}
				},
				{
					targets: [7],
					render: function (data, type, row, meta) {
						return (data === null) ? '<i class="text-muted small">NIL</i>' : data;
					}
				},
				{
					targets: [-2],
					visible: false
				},
				{
					targets: [-1],
					orderable: false,
					searchable: false,
					width: "2%",
					responsivePriority: 1,
					defaultContent: '',
					render: function (data, type, row, meta) {
						let infoBtn = '<button type="button" id="info" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="View"><i class="fas fa-eye"></i></button>';
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
			$scope.selRows = rows;
			supTable.button(4).enable(rows.length > 0);
			if (rows.length < supTable.data().count()) {
				$scope.checkall = false;
			} else if (rows.length == supTable.data().count()) {
				$scope.checkall = true;
			}
			$timeout(function () {
				$scope.$digest();
			});
		});
		$('#supTable tbody').on('click', '#info', function () { // info from action menu
			$scope.supInfoModal({ data: supTable.row($(this).parents('tr')).data() });
		});
		$('#info').on('click', function () { // info from action menu
			$scope.supInfoModal({ data: supTable.row($(this).parents('tr')).data() });
		});
		$('#supTable tbody').on('click', '#delete', function () { // delete from action menu
			$scope.confDel({ data: supTable.row($(this).parents('tr')).data() });
		});
		$('#supTable tbody').on('click', '#edit', function () { // edit from action menu
			$scope.showNewCustForm({ data: supTable.row($(this).parents('tr')).data(), edit: true });
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