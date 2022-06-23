<template>
  <AdjustmentDetailsModal
    :propAdjustRow="adjustRow"
    :propAdjustInfo="adjustInfo"
  />
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-cart-shopping"></i
          ><span>Stock Adjustments</span>
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
    <table class="table table-bordered table-striped w-auto" id="datatable">
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
          <th scope="col">ID</th>
          <th scope="col">Date</th>
          <th scope="col">Reference No.</th>
          <th scope="col">Warehouse</th>
          <th scope="col">Products Adjusted</th>
          <th scope="col">Added by</th>
          <th scope="col">Note</th>
          <th scope="col">File</th>
          <th scope="col">Updated at</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in products" :key="item.id"></tr>
      </tbody>
    </table>
  </div>
</template>
<style>
</style>
<script>
import { ref } from "vue";
import admin from "@/mixins/admin.js";
import AdjustmentDetailsModal from "../modal/AdjustmentDetailsModal.vue";
import { Modal } from "bootstrap";
export default {
  components: {
    AdjustmentDetailsModal,
  },
  /* eslint-disable */
  setup() {
    var adjustRow = ref({});
    var adjustInfo = ref({});
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
      adjustRow,
      adjustInfo,
    };
  },
  methods: {
    getAdjustInfo() {
      this.adjustInfo = undefined; // reset previous data
      var self = this;
      if (self.controller) {
        self.controller.abort();
      }
      self.controller = new AbortController();
      window.PROD_ADJ_DETAILS_MODAL.show();
      self
        .axiosAsyncCallReturnData(
          "get",
          "stock_adjustment",
          {
            action: "getInfo",
            id: self.adjustRow.id,
          },
          self.controller,
          { showCatchNotification: false, showProgress: true }
        )
        .then(function (data) {
          if (data.success == true) {
            // ok
            self.adjustInfo = data.data;
          } else {
            if (data.success == false) {
              // not ok
              window.PROD_ADJ_DETAILS_MODAL.hide();
            } else {
              // other error
              if (data.message == "canceled") {
                //
              } else {
                window.PROD_ADJ_DETAILS_MODAL.hide();
                self.notifyCatchResponse({ title: data.message });
              }
            }
          }
        });
    },
  },
  created() {},
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
          url: "http://localhost/pos-vue3/server/admin/ajax/stock_adjustment",
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
          zeroRecords: "No matching adjustments found",
          info: "Showing _START_ to _END_ of _TOTAL_ adjustments",
          infoEmpty: "No adjustment info found",
          emptyTable: "No adjustments found",
          infoFiltered: "(filtered from _MAX_ adjustments)",
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
            data: "date",
          },
          {
            data: "reference_no",
          },
          {
            data: "warehouse_name",
          },
          {
            data: "total_products",
          },
          {
            data: "added_by",
          },
          {
            data: "note",
          },
          {
            data: null,
          },
          {
            data: "updated_at",
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
            visible: false,
            orderable: false,
            searchable: false,
            render: function (data, type, full, meta) {
              return data;
            },
          },
          {
            targets: [2],
            visible: true,
            searchable: true,
          },
          {
            targets: [3],
            render: function (data, type, row, meta) {
              return data == null
                ? '<i class="text-muted small">NIL</i>'
                : data;
            },
          },
          {
            targets: [4],
            render: function (data, type, row, meta) {
              return data;
            },
          },
          {
            targets: [5],
            className: "text-center",
            render: function (data, type, row, meta) {
              return data;
            },
          },
          {
            targets: [6],
            render: function (data, type, row, meta) {
              return data == null
                ? '<i class="text-muted small">NIL</i>'
                : data;
            },
          },
          {
            targets: [7],
            render: function (data, type, row, meta) {
              return data == null
                ? '<i class="text-muted small">NIL</i>'
                : data;
            },
          },
          {
            targets: [8],
            className: "text-center",
            defaultContent: '<i class="fas fa-paperclip"></i>',
            orderable: false,
            searchable: false,
            width: "2%",
          },
          {
            targets: [9],
            visible: false,
          },
        ],
        buttons: [
          {
            extend: "csv",
            text: '<i class="fas fa-file-csv"></i>',
            className: "btn-light",
            exportOptions: {
              columns: [2, 3, 4, 5, 6, 7],
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
            text: '<i class="fa fa-trash"></i>',
            className: "btn-light",
            enabled: false,
            action: function () {
              self.rows = self.table.rows(".selected").data().toArray();
              //$scope.confDel($scope.rows);
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
            text: '<i class="fa-solid fa-plus"></i>',
            className: "btn-light",
            action: function () {
              self.$router
                .push({ name: "adminProductAdjustmentNew" })
                .catch((e) => {});
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
        drawCallback: function (settings) {
          let rows = self.table.rows(".selected").data().toArray();
          self.table.button(2).enable(rows.length >= 1);
          $("#checkall").prop("indeterminate", false);
          $("#checkall").prop("checked", false);
        },
      });
      $("#datatable tbody").on(
        "click",
        "td:not(:first-child):not(:last-child),#details",
        function () {
          self.adjustRow = self.table.row($(this).parents("tr")).data(); // row data
          self.getAdjustInfo();
        }
      );
      $("#datatable tbody").on("click", "#edit", function () {
        // edit from action menu
        self.row = self.table.row($(this).parents("tr")).data();
        console.log(self.row)
        self.$router
          .push({
            name: "adminProductAdjustmentEdit",
            params: { id: self.row.id, data: JSON.stringify(self.row) },
          })
          .catch(() => {});
      });
      $("#datatable tbody").on("click", "#delete", function () {
        // delete from action menu
        self.row = self.table.row($(this).parents("tr")).data();
        alert("delete");
      });
      self.table.on("select deselect", function () {
        self.rows = self.table.rows(".selected").data().toArray();
        self.table.button(2).enable(self.rows.length >= 1);
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
    window.PROD_ADJ_DETAILS_MODAL = new Modal($("#prodAdjDetailsModal"), {
      backdrop: true,
      show: true,
    });
  },
  data: function () {
    return {
      products: [],
    };
  },
};
</script>