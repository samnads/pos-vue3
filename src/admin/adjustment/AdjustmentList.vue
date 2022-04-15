<template>
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-cart-shopping"></i><span>Adjustments</span>
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
          <th scope="col"><i class="fa-solid fa-image"></i></th>
          <th scope="col">ID</th>
          <th scope="col">Code</th>
          <th scope="col">Name</th>
          <th scope="col">Brand</th>
          <th scope="col">Category</th>
          <th scope="col">MRP</th>
          <th scope="col">Stock</th>
          <th scope="col">Unit</th>
          <th scope="col">Cost</th>
          <th scope="col">Price</th>
          <th scope="col"><i class="fa-solid fa-bars"></i></th>
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
import admin from "@/mixins/admin.js";
export default {
  components: {},
  /* eslint-disable */
  mixins: [],
  setup() {
    // notify
    const { notifyDefault, notifyApiResponse, notifyCatchResponse } = admin();
    return {
      notifyDefault,
      notifyApiResponse,
      notifyCatchResponse,
    };
  },
  methods: {},
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
        order: [[2, "desc"]],
        ajax: {
          method: "GET",
          url: "http://localhost/CyberLikes-POS/admin/ajax/product",
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
          zeroRecords: "No matching products found",
          info: "Showing _START_ to _END_ of _TOTAL_ Products",
          infoEmpty: "No product info found",
          emptyTable: "No products found",
          infoFiltered: "(filtered from _MAX_ Products)",
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
            data: "thumbnail",
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
            data: "brand_name",
          },
          {
            data: "category_name",
          },
          {
            data: "mrp",
          },
          {
            data: "quantity",
          },
          {
            data: "unit_code",
          },
          {
            data: "cost",
          },
          {
            data: "price",
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
            orderable: false,
            searchable: false,
            className: "text-center",
            render: function (data, type, full, meta) {
              return (
                '<img src="' +
                (data || "http://localhost/CyberLikes-POS/gd/50/50") +
                '" class="rounded thumbnail" width="20px"/>'
              );
            },
          },
          {
            targets: [2],
            visible: false,
            searchable: false,
          },
          {
            targets: [7],
            render: function (data, type, row, meta) {
              return data == null
                ? '<i class="text-muted small">-</i>'
                : parseFloat(data).toFixed(2);
            },
          },
          {
            targets: [8],
            className: "text-center",
            render: function (data, type, row, meta) {
              return data == 0
                ? '<i class="text-secondary small">' +
                    parseFloat(data).toFixed(2) +
                    "</i>"
                : parseFloat(data).toFixed(2);
            },
          },
          {
            targets: [9],
          },
          {
            targets: [10],
            render: function (data, type, row, meta) {
              return data == null
                ? '<i class="text-muted small">-</i>'
                : parseFloat(data).toFixed(2);
            },
          },
          {
            targets: [11],
            render: function (data, type, row, meta) {
              return parseFloat(data).toFixed(2);
            },
          },
          {
            targets: -1,
            orderable: false,
            className: "text-center",
            searchable: false,
            width: "2%",
            defaultContent:
              '<div class="dropdown dropstart">  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">    Action  </button>  <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">    <li id="details"><button class="dropdown-item" type="button"><i class="fa-solid fa-circle-info"></i>Details</button></li>    <li id="edit"><button class="dropdown-item" type="button"><i class="fa-solid fa-pen-to-square"></i>Edit</button></li>    <li id="copy"><button class="dropdown-item" type="button"><i class="fa-solid fa-copy"></i>Duplicate</button></li>  </ul></div>',
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
              self.$router.push({ name: "adminProductNew" }).catch((e) => {});
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
          // show single product info
          self.row = self.table.row($(this).parents("tr")).data();
          self.$parent.product = self.row;
          window.PROD_DETAILS_MODAL.show();
        }
      );
      $("#datatable tbody").on("click", "#edit", function () {
        // edit from action menu
        self.row = self.table.row($(this).parents("tr")).data();
        self.$router
          .push({ path: "/admin/product/edit/" + self.row.id })
          .catch(() => {});
      });
      $("#datatable tbody").on("click", "#copy", function () {
        // copy from action menu
        self.row = self.table.row($(this).parents("tr")).data();
        self.$router
          .push({ path: "/admin/product/copy/" + self.row.id })
          .catch(() => {});
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
  },
  data: function () {
    return {
      products: [],
      product: {
        details: {},
      },
    };
  },
};
</script>