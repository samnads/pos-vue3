app.controller("setUserCtrl", ['$scope', '$http', '$log', '$window', '$document', '$timeout', '$rootScope', '$cookies', '$filter', '$localStorage', '$q', function ($scope, $http, $log, $window, $document, $timeout, $rootScope, $cookies, $filter, $localStorage, $q) {
	$scope.init = function () {
		$scope.SET.defLength = 10;
		$scope.initRoles();
	};
	$scope.showNewUserForm = function (data) { // newCustCtrl.js
		$('#supInfoModal').modal('hide');
		$rootScope.$emit("showNewUserForm", data);
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
	$scope.confDel = function (param) { // show confirm box
		$scope.delRow = param.data;
		$('#supInfoModal').modal('hide') && $('#delModal').modal('show');
		$scope.$digest();
	};
	/* -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+ */
	$scope.delete = function (bulk) { // do delete cats
		$http({ // delete from server
			method: "DELETE",
			url: $scope.baseUrl + "admin/ajax/user",
			dataType: 'json',
			data: {
				data: $scope.delRow
			},
			headers: {
				"Content-Type": "application/json"
			}
		}).then(function (response) {
			if (response.data.success == true) { // delete success
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
		var dataTable = $('#supTable').DataTable({
			ajax: {
				method: "GET",
				url: $scope.baseUrl + "admin/ajax/user",
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
			language: {
				processing: '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>',
				emptyTable: "No data available in table",
				zeroRecords: "No matching users found for your search",
				info: "Showing _START_ to _END_ of _TOTAL_ Users",
				emptyTable: "No users found",
				infoFiltered: "(filtered from _MAX_ Users)"
			},
			order: [
				[9, 'desc']
			],
			orderClasses: true,
			orderMulti: false,
			responsive: {
				details: {
					type: 'column',
					target: 0
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
					extend: 'csvHtml5',
					text: '<i class="fas fa-file-csv"></i>',
					className: 'btn-light',
					exportOptions: {
						columns: [2, 3, 4, 5, 6, 7]
					},
					attr: {
						'data-toggle': 'tooltip',
						title: "Download CSV"
					},
					init: function (api, node, config) {
						$(node).removeClass('btn-secondary');
					}
				},
				{
					extend: 'pdfHtml5',
					text: '<i class="fas fa-file-pdf"></i>',
					className: 'btn-light',
					exportOptions: {
						columns: [2, 3, 4, 5, 6, 7]
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
						columns: [1, 2, 3, 4, 5, 6, 7, 8]
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
					key: {
						key: 'r',
						shiftKey: true
					},
					attr: {
						'data-toggle': 'tooltip',
						title: "Refresh",
						id: "refresh"
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
						$window.location = $scope.baseUrl + "admin/user/new";
					},
					attr: {
						'data-toggle': 'tooltip',
						title: "Add New User",
						id: "create"
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
					data: "avatar"
				},
				{
					data: "username"
				},
				{
					data: "role_name"
				},
				{
					data: "first_name"
				},
				{
					data: "email"
				},
				{
					data: "phone",
				},
				{
					data: "place",
				},
				{
					data: "status",
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
					className: 'control',
					orderable: false,
				},
				{
					targets: [1],
					orderable: false,
					searchable: false,
					className: "text-center",
					width: "2%",
					render: function (data, type, full, meta) {
						return '<img src="' + (data || "../gd/30/30") + '" class="rounded thumbnail"/>';
					}
				},
				{
					targets: [2],
					className: "align-middle",
					render: function (data, type, row, meta) {
						if (row['id'] == $window.user.id) {
							return '<mark>' + data + '</mark><a href="#" class="float-right text-success" data-toggle="tooltip" data-placement="right" title="Current User"><i class="fas fa-check-circle"></i></a>';
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
					render: function (data, type, row, meta) {
						return data + (row['last_name'] ? ' ' + row['last_name'] : '');
					}
				},
				{
					targets: [5],
				},
				{
					targets: [6],
				},
				{
					targets: [7],
					orderable: false,
					render: function (data, type, row, meta) {
						return (data === null) ? '<i class="text-muted small">NIL</i>' : data;
					}
				},
				{
					targets: [8],
					className: "text-center",
					width: "2%",
					responsivePriority: 3,
					render: function (data, type, row, meta) {
						if (data == 'ACTIVE') {
							return '<span class="badge badge-success w-100">Active</span>';
						} else if (data == 'INACTIVE') {
							return '<span class="badge badge-danger w-100">Inactive</span>';
						} else if (data == 'PENDING') {
							return '<span class="badge badge-warning w-100">Pending</span>';
						}
						return '<span class="badge badge-dark w-100">Unknown</span>';
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
					responsivePriority: 2,
					render: function (data, type, row, meta) {
						let infoBtn = '<button type="button" id="info" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Info"><i class="fas fa-info-circle"></i></button>';
						let editBtn = '<button type="button" id="edit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fas fa-pencil-alt"></i></button> ';
						let delBtn = '<button type="button" id="delete" class="btn btn-' + (row['deletable'] ? 'danger' : 'secondary') + '"' + (row['deletable'] ? 'data-toggle="tooltip" data-placement="left" title="Delete"' : '') + (!row['deletable'] ? 'disabled' : '') + '><i class="fas fa-trash"></i></button>';
						return '<div class="btn-group btn-group-sm" role="group">' + editBtn + infoBtn + delBtn + '</div>';
					}
				}
			]
		});
		$('#supTable tbody').on('click', '#info', function () { // info from action menu
			$scope.supInfoModal({ data: dataTable.row($(this).parents('tr')).data() });
		});
		$('#supTable tbody').on('click', '#delete', function () { // delete from action menu
			$scope.confDel({ data: dataTable.row($(this).parents('tr')).data() });
		});
		$('#supTable tbody').on('click', '#edit', function () { // edit from action menu
			let data = dataTable.row($(this).parents('tr')).data();
			$log.log(data);
			$window.location = $scope.baseUrl + "admin/user/edit/" + data['id'];
		});
		$('#length_change').change(function () { // custom length change menu
			dataTable.page.len($(this).val()).draw();
		});
		dataTable.buttons().container().appendTo('#buttons');
		$('#searchUser').keyup(function () { // custom search box
			dataTable.search($(this).val()).draw();
		});
		document.getElementById("searchUser").addEventListener("search", function (event) { // search clear button clicked
			dataTable.search('').draw();
		});
	});
	//$('#newUserModal').modal('show');
}]);