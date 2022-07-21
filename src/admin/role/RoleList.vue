<template>
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-user-lock"></i><span>Roles</span>
        </h5>
      </div>
      <div class="p-2 bd-highlight">
        <select
          class="form-select form-select-md"
          id="length_change"
          name="length_change"
        >
          <option :selected="page_length == 5">5</option>
          <option value="10" :selected="page_length == 10">10</option>
          <option value="20" :selected="page_length == 20">20</option>
          <option value="25" :selected="page_length == 25">25</option>
          <option value="50" :selected="page_length == 50">50</option>
          <option value="100" :selected="page_length == 100">100</option>
          <option value="-1">All</option>
        </select>
      </div>
      <div class="p-2 bd-highlight"><span id="buttons"></span></div>
      <div class="p-2 bd-highlight">
        <input
          class="form-control"
          id="search"
          type="search"
          placeholder="Search..."
        />
      </div>
    </div>
  </div>
  <div class="wrap_content" id="wrap_content">
    <table
      class="table table-bordered table-striped w-auto"
      id="datatable"
      v-once
    >
      <thead>
        <tr>
          <th scope="col">
            <i class="fa-solid fa-id-card-clip"></i>
          </th>
          <th scope="col" class="d-none">ID</th>
          <th scope="col">Role</th>
          <th scope="col">Description</th>
          <th scope="col">Active</th>
          <th scope="col">Inactive</th>
          <th scope="col">Pending</th>
          <th scope="col">Blocked</th>
          <th scope="col">Total</th>
          <th scope="col"><i class="fa-solid fa-bars"></i></th>
        </tr>
      </thead>
      <tbody>
        <!--<tr v-for="item in products" :key="item.id"></tr>-->
      </tbody>
    </table>
  </div>
</template>
<style>
</style>
<script>
/* eslint-disable */
import { ref } from "vue";
import admin from "@/mixins/admin.js";
import { inject } from "vue";
export default {
  components: {},
  /* eslint-disable */
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    const controller_delete = ref({});
    var page_length = 25;
    // notify
    const {
      notifyDefault,
      notifyApiResponse,
      notifyCatchResponse,
      axiosAsyncCallReturnData,
    } = admin();
    return {
      notifyDefault,
      notifyApiResponse,
      notifyCatchResponse,
      axiosAsyncCallReturnData,
      emitter,
      controller_delete,
      page_length,
    };
  },
  methods: {
    getAdjustInfo() {},
  },
  mounted() {
    var self = this;
    $(function () {
      $.fn.dataTable.ext.errMode = function (settings, techNote, message) {
        //
      };
      self.table = $("#datatable").DataTable({
        searching: true, // remove default search box
        bLengthChange: false, // remove default length change menu
        pageLength: self.page_length,
        searchDelay: 750,
        processing: true,
        serverSide: true,
        dom: "lBtipr",
        deferRender: true,
        responsive: true,
        colReorder: {
          fixedColumnsLeft: 1,
          fixedColumnsRight: 1,
        },
        order: [[1, "desc"]],
        ajax: {
          method: "GET",
          url: process.env.VUE_APP_API_ROOT + "admin/ajax/role",
          contentType: "application/json",
          xhrFields: { withCredentials: true },
          error: function (xhr, error, code) {
            self.$Progress.fail();
            self.notifyCatchResponse({ title: "Network Error !", message: "" });
          },
          data: function (d) {
            self.$Progress.start();
            d["action"] = "datatable";
            return d;
          },
          dataSrc: function (response) {
            if (response.success == false && response.location) {
              self.$Progress.fail();
              self.notifyCatchResponse(response);
              self.$router
                .push({ path: "/" + response.location })
                .catch((e) => {});
            } else if (response.success == false) {
              self.$Progress.fail();
              self.notifyApiResponse(response);
            } else {
              self.$Progress.finish();
              return response.data;
            }
          },
        },
        language: {
          processing:
            '<div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status"> <span class="visually-hidden">Loading...</span></div>',
          emptyTable: "No data available in table",
          zeroRecords: "No matching role found",
          info: "Showing _START_ to _END_ of _TOTAL_ roles",
          infoEmpty: "No role info found",
          emptyTable: "No role found",
          infoFiltered: "(filtered from _MAX_ roles)",
          paginate: {
            first: "First",
            last: "Last",
            next: '<i class="fas fa-caret-right"></i>',
            previous: '<i class="fas fa-caret-left"></i>',
          },
        },
        columns: [
          {
            data: null,
          },
          {
            data: "id",
          },
          {
            data: "name",
          },
          {
            data: "description",
          },
          {
            data: "count_active",
          },
          {
            data: "count_inactive",
          },
          {
            data: "count_pending",
          },
          {
            data: "count_blocked",
          },
          {
            data: "count_user",
          },
          {
            data: null,
          },
        ],
        columnDefs: [
          {
            targets: [0],
            orderable: false,
            width: "2%",
            searchable: false,
            defaultContent: '<i class="fa-solid fa-id-card-clip"></i>',
          },
          {
            targets: [1],
            className: "d-none",
            searchable: false,
          },
          {
            targets: [2],
            className: "align-middle",
            render: function (data, type, row, meta) {
              if (row["id"] == row["self_role"]) {
                return (
                  "<b>" +
                  data +
                  '</b><span class="float-end text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Current Role"><i class="fas fa-check-circle"></i></span>'
                );
              }
              return "<b>" + data + "</b>";
            },
          },
          {
            targets: [3],
            className: "align-middle",
            render: function (data, type, row, meta) {
              return data == null
                ? '<i class="text-muted small">NIL</i>'
                : data;
            },
          },
          {
            targets: [4],
            className: "align-middle text-center",
            width: "5%",
            render: function (data, type, row, meta) {
              return (
                '<span class="badge bg-success w-100 fs-6">' + data + "</span>"
              );
            },
          },
          {
            targets: [5],
            className: "align-middle text-center",
            width: "5%",
            render: function (data, type, row, meta) {
              return (
                '<span class="badge bg-secondary w-100 fs-6">' +
                data +
                "</span>"
              );
            },
          },
          {
            targets: [6],
            className: "align-middle text-center",
            width: "5%",
            render: function (data, type, row, meta) {
              return (
                '<span class="badge bg-warning text-dark w-100 fs-6">' +
                data +
                "</span>"
              );
            },
          },
          {
            targets: [7],
            className: "align-middle text-center",
            width: "5%",
            render: function (data, type, row, meta) {
              return (
                '<span class="badge bg-danger  w-100 fs-6">' + data + "</span>"
              );
            },
          },
          {
            targets: [8],
            width: "1%",
            className: "align-middle text-center",
            width: "5%",
            render: function (data, type, row, meta) {
              return (
                '<span class="badge bg-primary  w-100 fs-6">' + data + "</span>"
              );
            },
          },
          {
            targets: [9],
            className: "text-center align-middle",
            orderable: false,
            searchable: false,
            width: "1%",
            render: function (data, type, row, meta) {
              let infoBtn =
                '<button type="button" id="info" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="left" title="Info"><i class="fas fa-info-circle"></i></button>';
              let editBtn =
                '<button type="button" id="edit" class="btn btn-' +
                (row["editable"] !== 0 ? "primary" : "secondary") +
                '"' +
                (row["editable"] !== 0
                  ? 'data-bs-toggle="tooltip" data-bs-placement="left" title="Edit"'
                  : "") +
                (row["editable"] === 0 ? "disabled" : "") +
                '><i class="fas fa-pencil-alt"></i></button> ';
              let delBtn =
                '<button type="button" id="delete" class="btn btn-' +
                (row["deletable"] !== 0 ? "danger" : "secondary") +
                '"' +
                (row["deletable"] !== 0
                  ? 'data-bs-toggle="tooltip" data-bs-placement="left" title="Delete"'
                  : "") +
                (row["deletable"] === 0 ? "disabled" : "") +
                '><i class="fas fa-trash"></i></button>';
              return (
                '<div class="btn-group btn-group-sm" role="group">' +
                editBtn +
                infoBtn +
                delBtn +
                "</div>"
              );
            },
          },
        ],
        buttons: [
          {
            extend: "print",
            text: '<i class="fa-solid fa-print"></i>',
            className: "btn-light",
            exportOptions: {
              columns: [2, 3, 4, 5, 6, 7],
            },
            attr: {
              "data-bs-toggle": "tooltip",
              title: "Print",
            },
          },
          {
            extend: "pdfHtml5",
            text: '<i class="fas fa-download"></i>',
            className: "btn-light",
            exportOptions: {
              columns: [2, 3, 4, 5, 6, 7],
            },
            attr: {
              "data-bs-toggle": "tooltip",
              title: "Download PDF",
            },
          },

          {
            extend: "excel",
            text: '<i class="fas fa-file-excel"></i>',
            className: "btn-light",
            exportOptions: {
              columns: [2, 3, 4, 5, 6, 7],
            },
            attr: {
              "data-bs-toggle": "tooltip",
              title: "Download Excel",
            },
          },
          {
            extend: "csv",
            text: '<i class="fas fa-file-csv"></i>',
            className: "btn-light",
            exportOptions: {
              columns: [2, 3, 4, 5, 6, 7],
            },
            attr: {
              "data-bs-toggle": "tooltip",
              title: "Download CSV",
            },
          },
          {
            text: '<i class="fa fa-sync-alt"></i>',
            className: "btn-light",
            action: function () {
              self.table.ajax.reload();
            },
            attr: {
              title: "Refresh",
              id: "refresh",
            },
            key: {
              key: "r",
              shiftKey: true,
            },
          },
          {
            extend: "copy",
            text: '<i class="fas fa-copy"></i>',
            className: "btn-light",
            exportOptions: {
              columns: [2, 3, 4, 5, 6, 7, 8],
            },
            attr: {
              "data-bs-toggle": "tooltip",
              title: "Copy to clipboard",
            },
          },
          {
            text: '<i class="fa-solid fa-plus"></i>',
            className: "btn-light",
            action: function () {
              self.$router.push({ name: "adminRoleNew" }).catch((e) => {});
            },
            attr: {
              "data-bs-toggle": "tooltip",
              title: "Add New",
              id: "new",
            },
            key: {
              key: "d",
              shiftKey: true,
            },
            init: function (api, node, config) {},
          },
        ],
        initComplete: function (settings) {
          $("#buttons").html(self.table.buttons().container());
        },
        drawCallback: function (settings) {},
        createdRow: function (row, data, dataIndex) {
          if (data["deleted_at"]) {
            $(row).addClass("bg-danger");
          }
        },
      });
      $("#datatable tbody").on(
        "click",
        "td:not(:first-child):not(:last-child),#details",
        function () {
          //let row = self.table.row($(this).parents("tr")).data(); // row data
          window.USER_INFO_MODAL.show();
        }
      );
      $("#datatable tbody").on("click", "#edit", function () {
        // edit from action menu
        let row = self.table.row($(this).parents("tr")).data();
        self.$router
          .push({
            name: "adminRoleEdit",
            params: { id: row.id, data: JSON.stringify(row) },
          })
          .catch((e) => {});
      });
      $("#datatable tbody").on("click", "#info", function () {
        // info from action menu
        //let row = self.table.row($(this).parents("tr")).data();
        window.USER_INFO_MODAL.show();
      });
      $("#datatable tbody").on("click", "#delete", function () {
        // delete from action menu
        let row = self.table.row($(this).parents("tr")).data();
        self.emitter.emit("deleteConfirmModal", {
          title: null,
          body: "Delete role with name <b>" + row.name + " ?",
          data: row,
          emit: "confirmDeleteRole",
          hide: true,
          type: "danger",
        });
      });
      $("#search").keyup(function () {
        // custom search box
        self.table.search($(this).val()).draw();
      });
      $("#length_change").change(function () {
        // custom length change menu
        self.table.page.len($(this).val()).draw();
      });
      document
        .getElementById("search")
        .addEventListener("search", function (event) {
          // search clear button clicked
          self.table.search("").draw();
        });
    });
    self.emitter.on("confirmDeleteRole", (data) => {
      // delete selected supplier stuff here
      if (self.controller_delete.value) {
        self.controller_delete.value.abort();
      }
      self.controller_delete.value = new AbortController();
      self
        .axiosAsyncCallReturnData(
          "delete",
          "role",
          {
            action: "delete",
            data: data,
          },
          self.controller_delete.value,
          {
            showSuccessNotification: true,
            showCatchNotification: true,
            showProgress: true,
          }
        )
        .then(function (data) {
          if (data.success == true) {
            // success
            self.table.ajax.reload();
          } else {
            if (data.success == false) {
              // not ok
            } else {
              // other error
              if (data.message != "canceled") {
                //
              }
            }
          }
        });
    });
    self.emitter.on("refreshRoleDataTable", (data) => {
      self.table.ajax.reload();
    });
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("confirmDeleteRole");
    self.emitter.off("refreshRoleDataTable");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
  data: function () {
    return {};
  },
};
</script>