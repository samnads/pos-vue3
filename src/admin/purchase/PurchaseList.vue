<template>
  <PurchasePayment />
  <PurchaseInfoModal />
  <PurchasePayInfoModal />
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-truck-fast"></i><span>Purchase List</span>
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
      class="table table-sm table-bordered table-striped align-middle w-auto"
      id="datatable"
      v-once
    >
      <thead>
        <tr>
          <th scope="col" class="d-none">ID</th>
          <th scope="col">Date</th>
          <th scope="col">Ref. No.</th>
          <th scope="col">Supplier</th>
          <th scope="col">Warehouse</th>
          <th scope="col">Purchase Status</th>
          <th scope="col">Products</th>
          <th scope="col">Payable</th>
          <th scope="col">Paid</th>
          <th scope="col">Return</th>
          <th scope="col">Due</th>
          <th scope="col">Payment Status</th>
          <th scope="col" class="text-center">
            <i class="fa-solid fa-bars"></i>
          </th>
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
import { ref } from "vue";
import admin from "@/mixins/admin.js";
import { inject } from "vue";
import PurchasePayment from "../purchase/PurchasePayment.vue";
import PurchaseInfoModal from "../purchase/PurchaseInfoModal.vue";
import PurchasePayInfoModal from "../purchase/PurchasePayInfoModal.vue";
export default {
  components: { PurchasePayment, PurchaseInfoModal, PurchasePayInfoModal },
  /* eslint-disable */
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    const controller_delete = ref({});
    // notify
    const {
      axiosAsyncCallReturnData,
      notifyDefault,
      axiosAsyncStoreReturnBool,
      notifyApiResponse,
      notifyCatchResponse,
    } = admin();
    return {
      emitter,
      controller_delete,
      axiosAsyncCallReturnData,
      notifyDefault,
      axiosAsyncStoreReturnBool,
      notifyApiResponse,
      notifyCatchResponse,
    };
  },
  methods: {},
  created() {},
  mounted() {
    var self = this;
    self.emitter.on("refreshPurchaseTable", (data) => {
      self.table.ajax.reload();
    });
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
        responsive: true,
        colReorder: {
          fixedColumnsLeft: 1,
          fixedColumnsRight: 1,
        },
        order: [[0, "desc"]],
        ajax: {
          method: "GET",
          url: process.env.VUE_APP_API_ROOT + "admin/ajax/purchase",
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
          paginate: {
            first: "First",
            last: "Last",
            next: '<i class="fas fa-caret-right"></i>',
            previous: '<i class="fas fa-caret-left"></i>',
          },
        },
        columns: [
          {
            data: "created_at",
          },
          {
            data: "date",
          },
          {
            data: "reference_id",
          },
          {
            data: "supplier_name",
          },
          {
            data: "warehouse_name",
          },
          {
            data: "status_name",
          },
          {
            data: "product_count",
          },
          {
            data: "total_payable",
          },
          {
            data: "total_paid",
          },
          {
            data: "balance_return",
          },
          {
            data: "due",
          },
          {
            data: "",
          },
          {
            data: "",
          },
        ],
        columnDefs: [
          {
            targets: [0],
            className: "d-none",
            searchable: false,
          },
          {
            targets: [1],
          },
          {
            targets: [2],
          },
          {
            targets: [3],
          },
          {
            targets: [4],
          },
          {
            targets: [5],
            className: "text-capitalize text-center",
            render: function (data, type, row, meta) {
              return (
                '<span class="badge ' +
                row["css_class"] +
                '">' +
                data +
                "</span>"
              );
            },
          },
          {
            targets: [6],
          },
          {
            targets: [7],
            render: function (data, type, row, meta) {
              return (
                '<span class="text-primary fw-bold">' +
                parseFloat(data || 0).toFixed(2) +
                "</span>"
              );
            },
          },
          {
            targets: [8],
            render: function (data, type, row, meta) {
              if (data > 0) {
                return (
                  '<span class="text-success fw-bold">' +
                  parseFloat(data).toFixed(2) +
                  "</span>"
                );
              }
              return '<span class="text-muted small">-</span>';
            },
          },
          {
            targets: [9],
            render: function (data, type, row, meta) {
              if (parseFloat(data).toFixed(2) < 0) {
                return (
                  '<span class="text-info fw-bold">' +
                  parseFloat(data).toFixed(2) +
                  "</span>"
                );
              }
              return '<span class="text-muted small">-</span>';
            },
          },
          {
            targets: [10],
            render: function (data, type, row, meta) {
              if (parseFloat(data).toFixed(2) > 0) {
                return (
                  '<span class="text-danger fw-bold">' +
                  parseFloat(data).toFixed(2) +
                  "</span>"
                );
              }
              return '<span class="text-muted small">-</span>';
            },
          },
          {
            targets: [11],
            className: "text-capitalize text-center",
            render: function (data, type, row, meta) {
              if (Number(row["total_paid"]) == Number(row["total_payable"])) {
                return '<span class="badge bg-success fw-bold w-100">Completed</span>';
              } else if (
                Number(row["total_paid"]) > Number(row["total_payable"])
              ) {
                return '<span class="badge bg-success fw-bold w-100">Completed</span>';
              } else if (Number(row["total_paid"]) == 0) {
                return '<span class="badge bg-danger fw-bold w-100">Due</span>';
              }
              return '<span class="badge bg-warning text-black-50 fw-bold w-100">Due</span>';
            },
          },
          {
            targets: [12],
            orderable: false,
            className: "text-center",
            searchable: false,
            width: "1%",
            render: function (data, type, row, meta) {
              let infoBtn =
                '<button type="button" id="details" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="left" title="Info"><i class="fas fa-info-circle"></i></button>';
              let editBtn =
                '<button type="button" id="edit" class="btn btn-' +
                (row["editable"] !== 0 ? "primary" : "secondary") +
                '"' +
                (row["editable"] !== 0
                  ? 'data-bs-toggle="tooltip" data-bs-placement="left" title="Edit"'
                  : "") +
                (row["editable"] === 0 ? "disabled" : "") +
                '><i class="fas fa-pencil-alt"></i></button> ';
              /*let delBtn =
                '<button type="button" id="delete" class="btn btn-' +
                (row["deletable"] !== 0 ? "danger" : "secondary") +
                '"' +
                (row["deletable"] !== 0
                  ? 'data-bs-toggle="tooltip" data-bs-placement="left" title="Delete"'
                  : "") +
                (row["deletable"] === 0 ? "disabled" : "") +
                '><i class="fas fa-trash"></i></button>';*/
              let addPay =
                '<li><a class="dropdown-item" href="#" id="addpay"><i class="fa-brands fa-paypal fa-fw"></i>Add Payment</a></li>';
              return (
                '<div class="row-btn-group btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">' +
                editBtn +
                infoBtn +
                '<div class="btn-group btn-group-sm" role="group">' +
                '<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' +
                "</button>" +
                '<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">' +
                '<li><a class="dropdown-item" href="#" id="payinfo"><i class="fa-solid fa-eye fa-fw"></i>Show Payments</a></li>' +
                addPay +
                '<li><a class="dropdown-item" href="#" id="delete"><i class="fas fa-trash fa-fw"></i>Delete Purchase</a></li>' +
                "</ul>" +
                "</div>" +
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
              columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
              columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
              columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
              columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
              self.$router.push({ name: "adminPurchaseNew" }).catch((e) => {});
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
        "td:not(:last-child),#details",
        function () {
          let data = JSON.parse(JSON.stringify(self.table.row($(this).parents("tr")).data()));
          // show single product info
          self.emitter.emit("showPurchaseDetails", {
            title: null,
            body: null,
            data: data,
            type: "danger",
          });
        }
      );
      $("#datatable tbody").on("click", "#payinfo", function () {
        // from action menu
        let data = JSON.parse(JSON.stringify(self.table.row($(this).parents("tr")).data()));
        self.emitter.emit("showPurchasePayDetails",data);
      });
      $("#datatable tbody").on("click", "#edit", function () {
        // edit from action menu
        let data = JSON.parse(JSON.stringify(self.table.row($(this).parents("tr")).data()));
        self.$router
          .push({
            name: "adminPurchaseEdit",
            params: { id: data.id, data: data },
          })
          .catch(() => {});
      });
      $("#datatable tbody").on("click", "#copy", function () {
        // copy from action menu
         let data = JSON.parse(JSON.stringify(self.table.row($(this).parents("tr")).data()));
        self.$router
          .push({
            name: "adminProductCopy",
            params: { id: data.id, data: data },
          })
          .catch(() => {});
      });
      $("#datatable tbody").on("click", "#delete", function () {
        // delete from action menu
         let data = JSON.parse(JSON.stringify(self.table.row($(this).parents("tr")).data()));
        self.emitter.emit("deleteConfirmModal", {
          title: null,
          body:
            "Delete purchase with Ref. No. <b>" + data.reference_id + "</b> ?",
          data: data,
          emit: "confirmDeletePurchase",
          hide: true,
          type: "danger",
        });
      });
      $("#datatable tbody").on("click", "#addpay", function () {
         let data = JSON.parse(JSON.stringify(self.table.row($(this).parents("tr")).data()));
        self.emitter.emit("purchasePayModal", data);
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
    self.emitter.on("confirmDeletePurchase", (data) => {
      // delete selected supplier stuff here
      if (self.controller_delete.value) {
        self.controller_delete.value.abort();
      }
      self.controller_delete.value = new AbortController();
      self
        .axiosAsyncCallReturnData(
          "delete",
          "purchase",
          {
            data: data,
            action: "delete",
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
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("confirmDeletePurchase");
    self.emitter.off("refreshPurchaseTable");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>