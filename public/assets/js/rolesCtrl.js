app.controller("rolesCtrl", ['$scope', '$http', '$log', '$window', '$document', '$timeout', '$rootScope', '$cookies', '$filter', '$localStorage', '$q', function ($scope, $http, $log, $window, $document, $timeout, $rootScope, $cookies, $filter, $localStorage, $q) {
	$scope.init = function () {
		$scope.SET.defLength = 25;
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.supInfoModal = function (data = {}) { // show cat info modal
		$scope.roleInfo = data.data;
		$scope.$digest();
		$('#supInfoModal').modal('show');
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.confDel = function (param) { // show confirm box
		$scope.delRow = param.data;
		$('#supInfoModal').modal('hide') && $('#delModal').modal('show');
		$scope.$digest();
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.delete = function () { // do delete role
		$http({ // delete from server
			method: "DELETE",
			url: $scope.baseUrl + "admin/ajax/role",
			dataType: 'json',
			data: {
				action: 'delete',
				data: $scope.delRow
			},
			headers: {
				"Content-Type": "application/json"
			}
		}).then(function (response) {
			if (response.data.success == true) { // delete success
				$('#roleTable').DataTable().ajax.reload(null, false);
			} else {
			}
			$('#delModal').modal('hide');
			$scope.showAlert(response.data);
		}, function (response) { });
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$document.ready(function () {
		$.fn.dataTable.ext.errMode = function (settings, helpPage, message) { };
		var dataTable = $('#roleTable').DataTable({
			ajax: {
				method: "GET",
				url: $scope.baseUrl + "admin/ajax/role",
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
			},
			rowCallback: function (row, data) {
			},
			initComplete: function (settings) {
			},
			dom: 'lBtipr',
			searching: true, // remove default search box
			bLengthChange: false, // remove default length change menu
			pageLength: $scope.SET.defLength,
			deferRender: true,
			searchDelay: 750,
			processing: true,
			serverSide: true,
			orderClasses: true,
			orderMulti: false,
			language: {
				processing: '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>',
			},
			responsive: {
				details: {
					type: 'column',
					target: 0
				}
			},
			colReorder: {
				fixedColumnsLeft: 2,
				fixedColumnsRight: 1
			},
			buttons: [
				{
					extend: 'colvis',
					text: '<i class="fas fa-eye"></i>',
					className: 'btn-light',
					attr: {
						'data-toggle': 'tooltip',
						title: "Columns"
					},
				},
				{
					extend: 'excelHtml5',
					text: '<i class="fas fa-file-excel"></i>',
					className: 'btn-light',
					exportOptions: {
						columns: [2, 3, 4, 5, 6]
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
					exportOptions: {
						columns: [1, 2, 3, 4, 5]
					},
					attr: {
						'data-toggle': 'tooltip',
						title: "Download PDF"
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
						columns: [1, 2, 3, 4, 5]
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
						dataTable.ajax.reload(null, false);
					},
					attr: {
						'data-toggle': 'tooltip',
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
					text: '<i class="fa fa-plus"></i>',
					className: 'btn-light',
					enabled: true,
					action: function () {
						$window.location = $scope.baseUrl + "admin/role/new";
					},
					attr: {
						'data-toggle': 'tooltip',
						title: 'Create New Role',
						id: 'create'
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
			columns: [
				{
					data: null,
				},
				{
					data: "name"
				},
				{
					data: "description"
				},
				{
					data: "count_active"
				},
				{
					data: "count_inactive"
				},
				{
					data: "count_pending"
				},
				{
					data: "count_user"
				},
				{
					data: null
				}
			],
			columnDefs: [
				{
					targets: [0],
					defaultContent: 'f',
					className: 'control',
					orderable: false,
					searchable: false
				},
				{
					targets: [1],
					responsivePriority: 1,
					render: function (data, type, row, meta) {
						if (row['id'] == $window.user.role_id) {
							return '<mark>' + data + '</mark><a href="#" class="float-right text-success" data-toggle="tooltip" data-placement="right" title="Current Role"><i class="fas fa-check-circle"></i></a>';
						}
						return data;
					}
				},
				{
					targets: [2]
				},
				{
					targets: [3],
					className: "text-center",
					render: function (data, type, row, meta) {
						if (data == 0) {
							return '<span class="badge badge-secondary">' + data + '</span>';
						}
						return '<span class="badge badge-success">' + data + '</span>';
					}
				},
				{
					targets: [4],
					className: "text-center",
					render: function (data, type, row, meta) {
						if (data == 0) {
							return '<span class="badge badge-secondary">' + data + '</span>';
						}
						return '<span class="badge badge-danger">' + data + '</span>';
					}
				},
				{
					targets: [5],
					className: "text-center",
					render: function (data, type, row, meta) {
						if (data == 0) {
							return '<span class="badge badge-secondary">' + data + '</span>';
						}
						return '<span class="badge badge-warning">' + data + '</span>';
					}
				},
				{
					targets: [6],
					className: "text-center",
					render: function (data, type, row, meta) {
						return '<span class="badge badge-primary">' + data + '</span>';
					}
				},
				{
					targets: [-1],
					className: "text-center",
					width: "1%",
					orderable: false,
					searchable: false,
					responsivePriority: 2,
					defaultContent: '',
					render: function (data, type, row, meta) {
						let infoBtn = '<button type="button" id="info" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Info"><i class="fas fa-info-circle"></i></button>';
						let editBtn = '<button type="button" id="edit" class="btn btn-' + (row['editable'] ? 'primary' : 'secondary') + '"' + (row['editable'] ? 'data-toggle="tooltip" data-placement="left" title="Edit"' : '') + (!row['editable'] ? 'disabled' : '') + '><i class="fas fa-pencil-alt"></i></button> ';
						let delBtn = '<button type="button" id="delete" class="btn btn-' + (row['deletable'] ? 'danger' : 'secondary') + '"' + (row['deletable'] ? 'data-toggle="tooltip" data-placement="left" title="Delete"' : '') + (!row['deletable'] ? 'disabled' : '') + '><i class="fas fa-trash"></i></button>';
						return '<div class="btn-group btn-group-sm" role="group">' + editBtn + infoBtn + delBtn + '</div>';
					}
				}
			]
		});
		$('#roleTable tbody').on('click', '#info', function () { // info from action menu
			$scope.supInfoModal({ data: dataTable.row($(this).parents('tr')).data() });
		});
		$('#roleTable tbody').on('click', '#delete', function () { // delete from action menu
			$scope.confDel({ data: dataTable.row($(this).parents('tr')).data() });
		});
		$('#roleTable tbody').on('click', '#edit', function () { // edit from action menu
			let data = dataTable.row($(this).parents('tr')).data();
			$window.location = $scope.baseUrl + "admin/role/edit/" + data['id'];
		});
		$('#length_change').change(function () { // custom length change menu
			dataTable.page.len($(this).val()).draw();
		});
		dataTable.buttons().container().appendTo('#buttons');
		$('#searchRole').keyup(function () { // custom search box
			dataTable.search($(this).val()).draw();
		});
		document.getElementById("searchRole").addEventListener("search", function (event) { // search clear button clicked
			dataTable.search('').draw();
		});
	});
	//$('#newUserModal').modal('show');
}]);