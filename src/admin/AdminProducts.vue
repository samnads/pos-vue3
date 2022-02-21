<template>
  <div class="form-inline menubar"><i class="bi bi-cart-fill"></i>Products</div>
  <table
    class="table table-bordered table-striped w-auto"
    id="datatable"
  >
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
    <tbody></tbody>
  </table>
</template>
<style>
.menubar {
  border-top-left-radius: 0.25rem !important;
  border-top-right-radius: 0.25rem !important;
  padding: 0.75rem !important;
  background-color: #5f9ea0;
  color: #fff;
  text-align: left;
}
.menubar > .bi {
  margin-right: 5px;
}
.menubar > .bi:after {
  content: " | ";
  font-style: normal;
}
</style>
<script>
import "jquery/dist/jquery.min.js";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";
export default {
  /* eslint-disable */
  mounted() {
    var self = this;
    $(document).ready(function () {
      $("#datatable").DataTable({
        searching: true, // remove default search box
        bLengthChange: false, // remove default length change menu
        pageLength: 10,
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
            '<div class="d-flex justify-content-center"> <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>',
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
              return '';
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
            searchable: false,
            width: "2%",
            defaultContent:
              "<div class='btn-group dropleft'><button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Action</button><div class='dropdown-menu'><a id='info' class='dropdown-item' href='#'><i class='fa fa-info fa-fw' aria-hidden='true'></i>Details</a> <a class='dropdown-item' id='edit' href='#'><i class='fa fa-edit fa-fw' aria-hidden='true'></i>Edit</a><a class='dropdown-item' id='copy' href='#'><i class='fa fa-copy fa-fw' aria-hidden='true'></i>Duplicate</a> <a class='dropdown-item' href='#'><i class='fa fa-shopping-cart fa-fw' aria-hidden='true'></i>Add to POS</a><div class='dropdown-divider'></div><a class='dropdown-item' id='delete' href='#'><i class='fa fa-trash fa-fw' aria-hidden='true'></i>Delete</a> </div></div>",
          },
        ],
      });
    });
  },
  data: function () {
    return {};
  },
};
</script>