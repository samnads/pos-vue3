<template>
  <div id="posmain">
    <div class="wrap_content p-2 rounded">
      <div class="row">
        <div class="col-9 left">
          <div class="row">
            <div class="col-9">
              <div class="input-group mb-2">
                <span
                  class="input-group-text"
                  data-bs-toggle="tooltip"
                  data-bs-placement="right"
                  title="Scan & Add Product"
                  ><i class="fa-solid fa-barcode"></i
                ></span>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Scan code or type product name..."
                  ref="searchBox"
                  v-model="search_product"
                  @input="searchProduct(search_product)"
                  v-on:blur="lostProductFocus()"
                />
                <ul
                  class="mdb-autocomplete-wrap list-group"
                  style="max-height: 225px"
                >
                  <li
                    @click="checkAndPush(item)"
                    class="list-group-item list-group-item-action"
                    v-for="item in autocompleteList"
                    :key="item.id"
                    :value="item.name"
                  >
                    {{ item.label }}
                  </li>
                </ul>
                <span
                  class="input-group-text bg-info"
                  role="button"
                  data-bs-toggle="tooltip"
                  data-bs-placement="left"
                  title="New Product"
                  ><i class="fa-solid fa-plus"></i
                ></span>
              </div>
            </div>
            <div class="col-3">
              <div class="input-group mb-2">
                <span
                  class="input-group-text"
                  data-bs-toggle="tooltip"
                  data-bs-placement="right"
                  title="Scan & Remove Product"
                  ><i class="fa-solid fa-trash"></i
                ></span>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Scan & remove product from cart"
                />
              </div>
            </div>
          </div>
          <div class="product-table-wrapper tableFixHead">
            <table class="table table-striped table-bordered align-middle">
              <thead class="table-dark">
                <tr class="border border-light">
                  <th scope="col" class="fit">No.</th>
                  <th scope="col" class="fit">Code</th>
                  <th scope="col">Product Name</th>
                  <th scope="col" class="fit">HSN</th>
                  <th scope="col" width="13%" class="text-center">Quantity</th>
                  <th scope="col" width="10%" class="text-end">Price/Item</th>
                  <th scope="col" width="8%" class="text-end">Discount</th>
                  <th scope="col" width="10%" class="text-end">
                    Taxable Value
                  </th>
                  <th scope="col" width="12%">Tax</th>
                  <th scope="col">Total</th>
                  <th scope="col" class="text-center fit">
                    <span role="button" class="btn-sm btn-outline-danger"
                      ><i class="fa-solid fa-trash"></i
                    ></span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <div class="col" v-show="products.length == 0">Empty Cart</div>
                <tr
                  class="border border-light"
                  v-for="(product, index) in products"
                  :key="product.id"
                >
                  <th scope="row">{{ index + 1 }}</th>
                  <td>{{ product.code }}</td>
                  <td>{{ product.name }}</td>
                  <td>{{ product.hsn }}</td>
                  <td>
                    <div class="input-group input-group-sm is-invalid">
                      <button
                        type="button"
                        class="btn btn-warning input-group-text"
                      >
                        <i class="fa-solid fa-minus"></i>
                      </button>
                      <input
                        type="number"
                        class="form-control no-arrow text-center"
                        :value="product.quantity"
                      />
                      <button
                        type="button"
                        class="btn btn-info input-group-text"
                      >
                        <i class="fa-solid fa-plus"></i>
                      </button>
                    </div>
                  </td>
                  <td class="text-right">
                    <input
                      type="number"
                      class="form-control form-control-sm no-arrow text-end"
                      :value="product.price"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      class="form-control form-control-sm no-arrow text-end"
                      :value="product.discount"
                      readonly
                    />
                  </td>
                  <td class="text-end">~</td>
                  <td class="text-end">~</td>
                  <td class="text-end fw-bold">~</td>
                  <td>
                    <span
                      role="button"
                      class="btn btn-sm btn-outline-danger"
                      @click="confirmDeleteShow(product)"
                      ><i class="fa-solid fa-trash"></i
                    ></span>
                  </td>
                </tr>
                <!--<tr class="border border-light">
                  <th scope="row">1</th>
                  <td>6515641564</td>
                  <td>OnePlues 10 Mobile</td>
                  <td>11665</td>
                  <td>
                    <div class="input-group input-group-sm is-invalid">
                      <button
                        type="button"
                        class="btn btn-warning input-group-text"
                      >
                        <i class="fa-solid fa-minus"></i>
                      </button>
                      <input
                        type="number"
                        class="form-control no-arrow text-center"
                        value="1"
                      />
                      <button
                        type="button"
                        class="btn btn-info input-group-text"
                      >
                        <i class="fa-solid fa-plus"></i>
                      </button>
                    </div>
                  </td>
                  <td class="text-right">
                    <input
                      type="number"
                      class="form-control form-control-sm no-arrow text-end"
                      value="64000"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      class="form-control form-control-sm no-arrow text-end"
                      value="2500"
                      readonly
                    />
                  </td>
                  <td class="text-end">61,500</td>
                  <td class="text-end">[GST 18%] - 5,525</td>
                  <td class="text-end fw-bold">75,000</td>
                  <td>
                    <span
                      role="button"
                      class="btn btn-sm btn-outline-danger"
                      @click="confirmDeleteShow()"
                      ><i class="fa-solid fa-trash"></i
                    ></span>
                  </td>
                </tr>-->
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-3 right">
          <div class="form-row border border-danger right-top">
            <div class="col">
              <div class="input-group mb-2">
                <span
                  class="input-group-text"
                  data-bs-toggle="tooltip"
                  data-bs-placement="right"
                  title="Customer"
                  ><i class="fa-solid fa-user-tag"></i
                ></span>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Walk-in Customer"
                />
                <span
                  class="input-group-text"
                  role="button"
                  data-bs-toggle="tooltip"
                  data-bs-placement="left"
                  title="Unlock"
                  ><i class="fa-solid fa-lock"></i
                ></span>
                <span
                  class="input-group-text bg-secondary text-light"
                  role="button"
                  data-bs-toggle="tooltip"
                  data-bs-placement="left"
                  title="Customer Details"
                  ><i class="fa-solid fa-binoculars"></i
                ></span>
                <span
                  class="input-group-text"
                  role="button"
                  data-bs-toggle="tooltip"
                  data-bs-placement="left"
                  title="New Customer"
                  ><i class="fa-solid fa-plus"></i
                ></span>
              </div>
            </div>
          </div>
          <div class="form-row right-bottom text-light">
            <table class="table table-sm text-light align-middle">
              <tbody>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary" width="25%">Items</td>
                  <td class="bg-primary text-end" width="25%">
                    {{ products.length }}
                  </td>
                  <td class="bg-secondary" width="25%">Sub Total</td>
                  <td class="bg-info text-end" width="25%">0</td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary">Total Quantity</td>
                  <td class="bg-primary text-end">0</td>
                  <td class="bg-secondary">Product Discount</td>
                  <td class="bg-warning text-end text-dark">0</td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary">Tax</td>
                  <td class="bg-primary text-end">0</td>
                  <td class="bg-secondary">Cart Discount</td>
                  <td
                    class="bg-warning bg-gradient text-dark text-end"
                    role="button"
                  >
                    <div class="d-flex justify-content-between">
                      <div class="text-muted">
                        <i class="fa-solid fa-tag"></i>
                      </div>
                      <div>0.00</div>
                    </div>
                  </td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary">Shipping</td>
                  <td class="bg-primary bg-gradient" role="button">
                    <div class="d-flex justify-content-between">
                      <div class="text-black-50">
                        <i class="fa-solid fa-truck"></i>
                      </div>
                      <div>0.00</div>
                    </div>
                  </td>
                  <td class="bg-secondary">Total Discount</td>
                  <td class="bg-warning text-end text-dark">0</td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary"></td>
                  <td class="bg-primary"></td>
                  <td class="bg-secondary">Taxable Value</td>
                  <td class="bg-primary text-end">0</td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary">Tax</td>
                  <td class="bg-primary text-end">0</td>
                  <td class="bg-secondary">Total</td>
                  <td class="bg-info text-end">0</td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td colspan="2" class="bg-dark bg-gradient fs-5">
                    Total Payable
                  </td>
                  <td
                    colspan="2"
                    class="bg-light bg-gradient text-dark fw-bold fs-4 text-end"
                  >
                    <div class="d-flex justify-content-between">
                      <div class="text-muted">₹</div>
                      <div>0.00</div>
                    </div>
                  </td>
                </tr>
                <tr class="">
                  <td class="bg-danger text-center fs-5" role="button">
                    Cancel
                  </td>
                  <td
                    class="bg-warning text-center text-dark text-end fs-5"
                    role="button"
                  >
                    Draft
                  </td>
                  <td
                    rowspan="2"
                    colspan="2"
                    class="bg-success text-center"
                    role="button"
                  >
                    <span class="fs-4"
                      ><i class="fa-solid fa-credit-card"></i></span
                    >&nbsp;&nbsp;&nbsp;&nbsp;<span class="fs-3">Checkout</span>
                  </td>
                </tr>
                <tr>
                  <td
                    colspan="2"
                    class="bg-info text-dark text-center fs-5"
                    role="button"
                  >
                    Print
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.mdb-autocomplete-wrap {
  position: absolute;
  margin-top: 38px;
  right: 0;
  left: 0;
  z-index: 100;
  padding-left: 0;
  overflow-y: auto;
  list-style-type: none;
  background: #fff;
  -webkit-box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%),
    0 2px 10px 0 rgb(0 0 0 / 12%);
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
}
#posmain {
  background-color: rgb(238, 236, 236);
}
.wrap_content {
  min-height: calc(100vh - 120px) !important;
}
.right .right-top {
  min-height: calc(100vh - 500px) !important;
}
.right .right-bottom {
  background-color: blanchedalmond;
}
.table td.fit,
.table th.fit {
  white-space: nowrap;
  width: 1%;
}
input:read-only,
input:disabled {
  cursor: not-allowed;
  pointer-events: all !important;
}
.input-group .btn {
  position: relative;
  z-index: 0;
}
.tableFixHead {
  overflow: auto;
}
.tableFixHead thead th {
  position: sticky;
  top: 0;
  z-index: 1;
}
</style>
<script>
/* eslint-disable */
import { ref } from "vue";
import { inject } from "vue";
import admin from "@/mixins/admin.js";
export default {
  components: {},
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    const autocompleteList = ref([]);
    const searchBox = ref(null);
    const products = ref([]);
    const { axiosAsyncStoreReturnBool, axiosAsyncCallReturnData } = admin();
    var search_product = null;
    function confirmDeleteShow(data) {
      emitter.emit("deleteConfirmModal", {
        title: null,
        body: "Confirm delete <b>" + data.name + "</b> from cart ?",
        data: data,
        hide: true,
        emit: "confirmDeleteProduct",
        type: "danger",
      });
      window.DELETE_CONFIRM_DEFAULT_MODAL.show();
    }
    function searchProduct(query) {
      var self = this;
      if (query) {
        self.autocompleteList = [];
        if (self.controller) {
          self.controller.abort();
        }
        self.controller = new AbortController();
        this.axiosAsyncCallReturnData(
          "get",
          "pos",
          {
            action: "create",
            search: "product",
            query: query,
          },
          self.controller,
          {
            showSuccessNotification: false,
            showCatchNotification: true,
            showProgress: true,
          }
        ).then(function (data) {
          if (data.success == true) {
            let items = data.data;
            if (items.length > 1) {
              // many product found
              self.autocompleteList = items;
            } else if (items.length == 1) {
              // One product found
              self.checkAndPush(items[0]);
            } else {
              // no product found
              self.autocompleteList = [];
              self.search_product = null;
              self.emitter.emit("showAlert", {
                title: "No search result found !",
                body:
                  "No product found for your search query <b>" +
                  query +
                  "</b> !",
                type: "danger",
                play: "danger.mp3",
              });
            }
          } else {
            // network error or cancelled duplicate call
          }
        });
      } else {
        self.autocompleteList = [];
      }
    }
    function checkAndPush(product) {
      if (!this.products.some((data) => data.id === product.id)) {
        // new
        product.quantity = 1;
        this.products.push(product);
      } else {
        // update
        let index = this.products.findIndex((item) => item.id === product.id);
        this.products[index].quantity++;
      }
      this.autocompleteList = [];
      this.search_product = null;
      this.searchBox.focus();
      this.emitter.emit("playSound", { file: "add.mp3" });
    }
    function lostProductFocus() {
    }
    emitter.on("confirmDeleteProduct", (data) => {
      var self = this;
      // delete selected product stuff here
      let index = products.value.findIndex((item) => item.id === data.id);
      products.value.splice(index, 1);
      emitter.emit("playSound", { file: "add.mp3" });
    });
    return {
      emitter,
      searchProduct,
      search_product,
      confirmDeleteShow,
      autocompleteList,
      axiosAsyncCallReturnData,
      checkAndPush,
      products,
      searchBox,
      lostProductFocus,
    };
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("confirmDeleteProduct");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>