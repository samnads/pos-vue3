<template>
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-warehouse"></i><span>Warehouses</span>
        </h5>
      </div>
      <div class="p-2 bd-highlight">
        <select
          class="form-select form-select-md"
          id="length_change"
          name="length_change"
        >
          <option selected>5</option>
          <option value="10">10</option>
          <option value="20">20</option>
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
          <th scope="col">Code</th>
          <th scope="col">Name</th>
          <th scope="col">Place</th>
          <th scope="col">Address</th>
          <th scope="col">Email</th>
          <th scope="col">Phone</th>
          <th scope="col" class="text-center">Status</th>
          <th scope="col">Status Reason</th>
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
    };
  },
  methods: {
    getAdjustInfo() {},
  },
  mounted() {
    var self = this;
    $(function () {
      $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
        console.log(message);
      };
      self.table = $("#datatable").DataTable({
        searching: true, // remove default search box
        bLengthChange: false, // remove default length change menu
        pageLength: 5,
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
        order: [[1, "asc"]],
        ajax: {
          method: "GET",
          url: process.env.VUE_APP_API_ROOT + "admin/ajax/warehouse",
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
          zeroRecords: "No matching warehouse found",
          info: "Showing _START_ to _END_ of _TOTAL_ warehouses",
          infoEmpty: "No warehouse info found",
          emptyTable: "No warehouse found",
          infoFiltered: "(filtered from _MAX_ warehouses)",
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
            data: "code",
          },
          {
            data: "name",
          },
          {
            data: "place",
          },
          {
            data: "address",
          },
          {
            data: "email",
          },
          {
            data: "phone",
          },
          {
            data: "status_name",
          },
          {
            data: "status_reason",
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
            width: "1%",
            className: "align-middle",
          },
          {
            targets: [3],
            className: "align-middle",
          },
          {
            targets: [4],
            className: "align-middle",
          },
          {
            targets: [5],
            className: "align-middle",
          },
          {
            targets: [6],
            className: "align-middle",
          },
          {
            targets: [7],
            className: "align-middle",
            render: function (data, type, row, meta) {
              return data == null
                ? '<i class="text-muted small">NIL</i>'
                : "<i>" + data + "</i>";
            },
          },
          {
            targets: [8],
            width: "1%",
            className: "align-middle text-capitalize",
            render: function (data, type, row, meta) {
              return (
                '<span class="badge ' +
                (row["css_class"] || "bg-secondary") +
                ' w-100">' +
                data +
                "</span>"
              );
            },
          },
          {
            targets: [9],
            className: "align-middle",
            width: "10%",
          },
          {
            targets: [10],
            className: "text-center align-middle",
            orderable: false,
            searchable: false,
            width: "1%",
            render: function (data, type, row, meta) {
              let infoBtn =
                '<button type="button" id="info" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Info"><i class="fas fa-info-circle"></i></button>';
              let editBtn =
                '<button type="button" id="edit" class="btn btn-' +
                (row["editable"] !== 0 ? "primary" : "secondary") +
                '"' +
                (row["editable"] !== 0
                  ? 'data-toggle="tooltip" data-placement="left" title="Edit"'
                  : "") +
                (row["editable"] === 0 ? "disabled" : "") +
                '><i class="fas fa-pencil-alt"></i></button> ';
              let delBtn =
                '<button type="button" id="delete" class="btn btn-' +
                (row["deletable"] !== 0 ? "danger" : "secondary") +
                '"' +
                (row["deletable"] !== 0
                  ? 'data-toggle="tooltip" data-placement="left" title="Delete"'
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
              columns: [2, 3, 4, 5, 6, 7, 8, 9],
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
              columns: [2, 3, 4, 5, 6, 7, 8, 9],
            },
            attr: {
              "data-toggle": "tooltip",
              title: "Download PDF",
            },
          },

          {
            extend: "excel",
            text: '<i class="fas fa-file-excel"></i>',
            className: "btn-light",
            exportOptions: {
              columns: [2, 3, 4, 5, 6, 7, 8, 9],
            },
            attr: {
              "data-toggle": "tooltip",
              title: "Download Excel",
            },
          },
          {
            extend: "csv",
            text: '<i class="fas fa-file-csv"></i>',
            className: "btn-light",
            exportOptions: {
              columns: [2, 3, 4, 5, 6, 7, 8, 9],
            },
            attr: {
              "data-toggle": "tooltip",
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
              "data-toggle": "tooltip",
              title: "Copy to clipboard",
            },
          },
          {
            text: '<i class="fa-solid fa-plus"></i>',
            className: "btn-light",
            action: function () {
              self.emitter.emit("newWarehouseModal", {
                title: "New Warehouse",
                type: "success",
                emit: "refreshWarehouseDataTable",
              });
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
        self.emitter.emit("newWarehouseModal", {
          title: "Edit Warehouse",
          data: row,
          emit: "refreshWarehouseDataTable",
          type: "primary",
        });
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
          body:
            "Delete warehouse with name <b>" +
            row.name +
            "</b>" +
            (row.place ? " | " + row.place : "") +
            " ?",
          data: row,
          emit: "confirmDeleteWarehouse",
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
    self.emitter.on("confirmDeleteWarehouse", (data) => {
      // delete selected supplier stuff here
      if (self.controller_delete.value) {
        self.controller_delete.value.abort();
      }
      self.controller_delete.value = new AbortController();
      self
        .axiosAsyncCallReturnData(
          "delete",
          "warehouse",
          {
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
    self.emitter.on("refreshWarehouseDataTable", (data) => {
      self.table.ajax.reload();
    });
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("confirmDeleteWarehouse");
    self.emitter.off("refreshWarehouseDataTable");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
  data: function () {
    return {};
  },
};
</script>