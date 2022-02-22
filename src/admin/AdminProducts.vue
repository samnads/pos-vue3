<template>
  <div class="form-inline menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <span class=""><i class="bi bi-cart-fill"></i> Products</span>
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
  <table class="table table-bordered table-striped w-auto" id="datatable">
    <thead>
      <tr>
        <th scope="col">
          <input
            class="form-check-input"
            type="checkbox"
            value=""
            id="flexCheckDefault"
          />
        </th>
        <th scope="col"><i class="bi bi-card-image"></i></th>
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
        <th scope="col"><i class="bi bi-menu-down"></i></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in products" :key="item.id"></tr>
    </tbody>
  </table>
</template>
<style>
.menubar {
  border-top-left-radius: 0.25rem !important;
  border-top-right-radius: 0.25rem !important;
  background-color: #5f9ea0;
  color: #fff;
}
.menubar > .bi {
  margin-right: 5px;
}
.menubar > .title .bi:after {
  content: " | ";
  font-style: normal;
}
table.dataTable {
  margin-top: 0px !important;
}
</style>
<script>
import "jquery/dist/jquery.min.js";
import "datatables.net-bs5/js/dataTables.bootstrap5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import "datatables.net-buttons-bs5/js/buttons.bootstrap5";
import "datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css";
import "datatables.net-buttons/js/buttons.colVis";
import "datatables.net-buttons/js/buttons.flash";
import "datatables.net-buttons/js/buttons.html5";
import "datatables.net-buttons/js/buttons.print";
import "datatables.net-buttons/js/dataTables.buttons";

import "@fortawesome/fontawesome-free/css/all.css";
import $ from "jquery";
export default {
  /* eslint-disable */
  methods: {
    initLoad() {},
  },
  created() {
    this.initLoad();
  },
  mounted() {
    var self = this;
    $(document).ready(function () {
      $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {};
      var table = $("#datatable").DataTable({
        searching: true, // remove default search box
        bLengthChange: false, // remove default length change menu
        lengthMenu: [10, 25, 50, 75, 100],
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
          data: function (d) {
            d["action"] = "datatable";
            return d;
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
              return "";
              return (
                '<img src="' +
                (data || "../gd/50/50") +
                '" class="rounded thumbnail"/>'
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
              "<div class='btn-group dropleft'><button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action</button><div class='dropdown-menu'><a id='info' class='dropdown-item' href='#'><i class='fa fa-info fa-fw' aria-hidden='true'></i>Details</a> <a class='dropdown-item' id='edit' href='#'><i class='fa fa-edit fa-fw' aria-hidden='true'></i>Edit</a><a class='dropdown-item' id='copy' href='#'><i class='fa fa-copy fa-fw' aria-hidden='true'></i>Duplicate</a> <a class='dropdown-item' href='#'><i class='fa fa-shopping-cart fa-fw' aria-hidden='true'></i>Add to POS</a><div class='dropdown-divider'></div><a class='dropdown-item' id='delete' href='#'><i class='fa fa-trash fa-fw' aria-hidden='true'></i>Delete</a> </div></div>",
          },
        ],
        buttons: [
          {
            extend: "excelHtml5",
            text: '<i class="fas fa-file-excel"></i>',
            className: "btn-light",
            exportOptions: {
              columns: [2, 3, 4, 5, 6, 7],
            },
            attr: {
              "data-toggle": "tooltip",
              title: "Download Excel",
            },
          },
          {
            text: '<i class="fa fa-sync-alt" aria-hidden="true"></i>',
            className: "btn-light",
            action: function () {
              table.ajax.reload();
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
            text: '<i class="fa fa-trash" aria-hidden="true"></i>',
            className: "btn-light",
            enabled: false,
            action: function () {},
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
              "data-toggle": "tooltip",
              title: "Print",
            },
          },
        ],
        initComplete: function (settings) {},
      });
      table.buttons().container().appendTo("#buttons");
      $("#search").keyup(function () {
        // custom search box
        table.search($(this).val()).draw();
      });
      document
        .getElementById("search")
        .addEventListener("search", function (event) {
          // search clear button clicked
          table.search("").draw();
        });
    });
  },
  data: function () {
    return {
      products: [],
    };
  },
};
</script>