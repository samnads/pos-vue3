<template>
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-layer-group"></i><span>Categories</span>
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
      class="table table-sm table-bordered table-striped w-auto"
      id="datatable"
      v-once
    >
      <thead>
        <tr>
          <th scope="col">
            <input
              class="form-check-input"
              type="checkbox"
              value=""
              id="checkall"
            />
          </th>
          <th scope="col" class="d-none">ID</th>
          <th scope="col">Code</th>
          <th scope="col">Name</th>
          <th scope="col">Parent</th>
          <th scope="col">URL Slug (SEO)</th>
          <th scope="col">Description</th>
          <th scope="col">Products</th>
          <th scope="col">Brands</th>
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
        pageLength: 15,
        searchDelay: 750,
        processing: true,
        serverSide: true,
        dom: "lBtipr",
        deferRender: true,
        select: {
          style: "multi",
          selector: "td:first-child",
        },
        responsive: true,
        colReorder: {
          fixedColumnsLeft: 1,
          fixedColumnsRight: 1,
        },
        order: [[1, "desc"]],
        ajax: {
          method: "GET",
          url: config.VUE_APP_API_ROOT + "admin/ajax/category",
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
          zeroRecords: "No matching category found",
          info: "Showing _START_ to _END_ of _TOTAL_ categories",
          infoEmpty: "No category info found",
          emptyTable: "No category found",
          infoFiltered: "(filtered from _MAX_ categories)",
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
            data: "parent_name",
          },
          {
            data: "slug",
          },
          {
            data: "description",
          },
          {
            data: "p_count",
          },
          {
            data: "b_count",
          },
          {
            data: null,
          },
        ],
        columnDefs: [
          {
            targets: [0],
            orderable: false,
            className: "select-checkbox",
            width: "2%",
            searchable: false,
            defaultContent: "",
          },
          {
            targets: [1],
            className: "d-none",
            searchable: false,
          },
          {
            targets: [2],
            className: "align-middle fw-bold",
            render: function (data, type, row, meta) {
              return row["allow_sub"] == 0
                ? '<div class="d-flex justify-content-between"><div><span class="">' +
                    data +
                    '</span></div><span class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="left" title="Level Locked"><i class="fa-solid fa-lock"></i></span></div></div>'
                : "<span>" + data + "</span>";
            },
          },
          {
            targets: [3],
            className: "align-middle fw-bold",
          },
          {
            targets: [4],
            className: "align-middle fw-semibold",
            render: function (data, type, row, meta) {
              let is_parent =
                data == null
                  ? '<span class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" title="Top Level"><i class="fa-solid fa-minimize"></i></span>'
                  : "";
              return data == null
                ? is_parent
                : data + " [ " + row["parent_code"] + " ]";
            },
          },
          {
            targets: [5],
             className: "align-middle",
            render: function (data, type, row, meta) {
              return data == null
                ? '<i class="text-muted small">NIL</i>'
                : data;
            },
          },
          {
            targets: [6],
            className: "align-middle",
            render: function (data, type, row, meta) {
              return data == null
                ? '<i class="text-muted small">NIL</i>'
                : data;
            },
          },
          {
            targets: [7],
            className: "align-middle",
            width: "1%",
            render: function (data, type, row, meta) {
              return (
                '<span class="badge bg-secondary w-100 fs-6">' +
                data +
                "</span>"
              );
            },
          },
          {
            targets: [8],
            className: "align-middle",
            width: "1%",
            render: function (data, type, row, meta) {
              return (
                '<span class="badge bg-secondary w-100 fs-6">' +
                data +
                "</span>"
              );
            },
          },
          {
            targets: [9],
            className: "align-middle text-center",
            orderable: false,
            searchable: false,
            width: "1%",
            defaultContent: "",
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
              let addBtn =
                '<button type="button" class="btn btn-' +
                (row["allow_sub"] !== 0 ? "info" : "secondary") +
                '"' +
                (row["allow_sub"] !== 0
                  ? 'data-bs-toggle="tooltip" data-bs-placement="left" title="New Sub Category"  id="addsubcat" '
                  : 'data-bs-toggle="tooltip" data-bs-placement="left" title="Level Locked"') +
                (row["allow_sub"] === 0
                  ? " disabled><i class='fa-solid fa-lock'></i>"
                  : "><i class='fa-solid fa-plus'></i>") +
                "</button> ";
              return (
                '<div class="btn-group btn-group-sm" role="group">' +
                editBtn +
                addBtn +
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
              columns: [1, 2, 3, 4, 5, 6, 7, 8],
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
              columns: [1, 2, 3, 4, 5, 6, 7, 8],
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
              columns: [1, 2, 3, 4, 5, 6, 7, 8],
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
              columns: [1, 2, 3, 4, 5, 6, 7, 8],
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
              "data-bs-toggle": "tooltip",
              title: "Refresh",
              id: "refresh",
            },
            key: {
              key: "r",
              shiftKey: true,
            },
          },
          {
            text: '<i class="fa fa-trash"></i>',
            className: "btn-light",
            enabled: false,
            action: function () {
              let rows = self.table.rows(".selected").data().toArray();
              self.emitter.emit("deleteConfirmModal", {
                title: null,
                body:
                  "Delete selected supplier" +
                  (rows.length > 1 ? "s " : "") +
                  (rows.length > 1
                    ? "(" + rows.length + ")"
                    : " <b>" + rows[0].name + "</b> (" + rows[0].name + ")") +
                  " ?",
                data: self.table.rows(".selected").data().toArray(),
                emit: "confirmDeleteCategory",
                hide: true,
                type: "danger",
              });
            },
            attr: {
              title: "Delete",
              id: "delete",
            },
            key: {
              key: "d",
              shiftKey: true,
            },
          },
          {
            extend: "copy",
            text: '<i class="fas fa-copy"></i>',
            className: "btn-light",
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8],
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
              self.emitter.emit("newCategoryModal", {
                title: "New Top Level Category",
                type: "success",
                emit: "refreshCategoryDataTable",
              });
            },
            attr: {
              "data-bs-toggle": "tooltip",
              title: "Add New Top Level ",
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
        drawCallback: function (settings) {
          let rows = self.table.rows(".selected").data().toArray();
          self.table.button(5).enable(rows.length >= 1);
          $("#checkall").prop("indeterminate", false);
          $("#checkall").prop("checked", false);
        },
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
          self.adjustRow = self.table.row($(this).parents("tr")).data(); // row data
          window.SUPPLIER_INFO_MODAL.show();
        }
      );
      $("#datatable tbody").on("click", "#edit", function () {
        // edit from action menu
        let row = self.table.row($(this).parents("tr")).data();
        self.emitter.emit("newCategoryModal", {
          title:
            "Edit " +
            (row.parent == null ? "Top Level Category" : "Sub Category"),
          db: row,
          emit: "refreshCategoryDataTable",
          type: "primary",
        });
      });
      $("#datatable tbody").on("click", "#info", function () {
        // info from action menu
        self.row = self.table.row($(this).parents("tr")).data();
        window.SUPPLIER_INFO_MODAL.show();
      });
      $("#datatable tbody").on("click", "#addsubcat", function () {
        // info from action menu
        let row = self.table.row($(this).parents("tr")).data();
        self.emitter.emit("newCategoryModal", {
          title: "New Sub Category",
          type: "info",
          data: row,
          emit: "refreshCategoryDataTable",
        });
      });
      $("#datatable tbody").on("click", "#delete", function () {
        // delete from action menu
        let row = self.table.row($(this).parents("tr")).data();
        self.emitter.emit("deleteConfirmModal", {
          title: null,
          body: "Delete category with name <b>" + row.name + " ?",
          data: row,
          emit: "confirmDeleteCategory",
          hide: true,
          type: "danger",
        });
      });
      self.table.on("select deselect", function () {
        self.rows = self.table.rows(".selected").data().toArray();
        self.table.button(5).enable(self.rows.length >= 1);
        if (self.rows.length == 0) {
          $("#checkall").prop("indeterminate", false);
          $("#checkall").prop("checked", false);
        } else if (self.rows.length < self.table.data().count()) {
          $("#checkall").prop("checked", false);
          $("#checkall").prop("indeterminate", true);
        } else if (self.rows.length == self.table.data().count()) {
          $("#checkall").prop("indeterminate", false);
          $("#checkall").prop("checked", true);
        }
      });
      $("#checkall").on("click", function (e) {
        if ($(this).is(":checked")) {
          self.table.rows().select();
        } else {
          self.table.rows().deselect();
        }
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
    self.emitter.on("confirmDeleteCategory", (data) => {
      // delete selected supplier stuff here
      if (self.controller_delete.value) {
        self.controller_delete.value.abort();
      }
      self.controller_delete.value = new AbortController();
      self
        .axiosAsyncCallReturnData(
          "delete",
          "supplier",
          {
            data: data,
            action: "delete",
            bulk: data.length ? true : false,
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
    self.emitter.on("refreshCategoryDataTable", (data) => {
      self.table.ajax.reload();
    });
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("confirmDeleteCategory");
    self.emitter.off("refreshCategoryDataTable");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
  data: function () {
    return {};
  },
};
</script>