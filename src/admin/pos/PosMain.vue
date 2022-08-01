<template>
  <CustomerNewModal />
  <div id="posmain">
    <div class="wrap_content p-2 rounded">
      <div class="row">
        <div class="col-9 left">
          <div class="row">
            <div class="col-10">
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
            <div class="col-2">
              <div class="input-group mb-2" v-show="cart.products.length > 0">
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
                  v-model="search_remove"
                  @input="searchProductCart(search_remove)"
                />
                <ul
                  class="mdb-autocomplete-wrap list-group"
                  style="max-height: 225px"
                >
                  <li
                    @click="checkAndRemove(item)"
                    class="list-group-item list-group-item-action"
                    v-for="item in autocompleteCart"
                    :key="item.id"
                    :value="item.name"
                  >
                    {{ item.label }}
                  </li>
                </ul>
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
                  <th scope="col" width="10%" class="text-end">Unit Price</th>
                  <th scope="col" width="8%" class="text-end">Auto Discount</th>
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
                <tr
                  class="border border-light"
                  v-for="(product, index) in cart.products"
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
                        class="btn input-group-text"
                        v-bind:class="[
                          product.quantity == product.min_sale_qty
                            ? 'btn-secondary'
                            : 'btn-warning',
                        ]"
                        @click="quantityButton(product, '-')"
                        :disabled="product.quantity == product.min_sale_qty"
                      >
                        <i class="fa-solid fa-minus"></i>
                      </button>
                      <input
                        @change="changeQuantity(product, product.quantity)"
                        type="number"
                        class="form-control no-arrow text-center"
                        v-model="product.quantity"
                      />
                      <button
                        type="button"
                        class="btn input-group-text"
                        v-bind:class="[
                          product.quantity == product.max_sale_qty
                            ? 'btn-secondary'
                            : 'btn-info',
                        ]"
                        @click="quantityButton(product, '+')"
                        :disabled="product.quantity == product.max_sale_qty"
                      >
                        <i class="fa-solid fa-plus"></i>
                      </button>
                    </div>
                  </td>
                  <td class="text-right">
                    <input
                      type="number"
                      class="form-control form-control-sm no-arrow text-end"
                      @change="changePrice(product, product.price)"
                      v-model="product.price"
                    />
                  </td>
                  <td class="text-danger text-end">
                    {{
                      (product.auto_discount * product.quantity).toFixed(2) || 0
                    }}
                  </td>
                  <td>
                    <input
                      type="number"
                      class="
                        form-control form-control-sm
                        no-arrow
                        text-danger text-end
                      "
                      v-model="product.discount"
                      @change="changeDiscount(product, product.discount)"
                      :disabled="!product.allow_custom_discount"
                    />
                  </td>
                  <td class="text-end">{{ product.taxable_value() }}</td>
                  <td class="text-end">{{ product.tax }}</td>
                  <td class="text-end fw-bold">
                    {{ product.total() }}
                  </td>
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
            {{ cart }}
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
                  @click="newCustomer"
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
                    {{ cart.total_items() }}
                  </td>
                  <td class="bg-secondary" width="25%">Price Total</td>
                  <td class="bg-info text-end" width="25%">
                    {{ cart.total_price().toFixed(2) }}
                  </td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary">Quantity</td>
                  <td class="bg-primary text-end">
                    {{ cart.total_quantity().toFixed(2) }}
                  </td>
                  <td class="bg-secondary">Auto Discount</td>
                  <td class="bg-warning text-end text-dark">
                    {{ cart.total_auto_discount().toFixed(2) }}
                  </td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary">Custom Disc.</td>
                  <td class="bg-warning text-dark text-end">
                    {{ cart.total_custom_discount().toFixed(2) }}
                  </td>
                  <td class="bg-secondary">Cart Disc.</td>
                  <td
                    class="bg-warning bg-gradient text-dark text-end"
                    role="button"
                  >
                    <div class="d-flex justify-content-between">
                      <div class="text-muted">
                        <i class="fa-solid fa-tag"></i>
                      </div>
                      <div>{{ cart.discount.toFixed(2) }}</div>
                    </div>
                  </td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary">Shipping</td>
                  <td class="bg-primary bg-gradient p-0">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text rounded-0"
                        ><i class="fa-solid fa-truck"></i
                      ></span>
                      <input
                        type="number"
                        step="any"
                        class="form-control text-end rounded-0 no-arrow"
                        v-model="cart.shipping_charge"
                        @focus="$event.target.select()"
                        @change="changeShippingCharge(cart.shipping_charge)"
                      />
                    </div>
                    <!--<div class="d-flex justify-content-between">
                      <div class="text-black-50">
                        <i class="fa-solid fa-truck"></i>
                      </div>
                      <div>0.00</div>
                    </div>-->
                  </td>
                  <td class="bg-secondary">Total Discount</td>
                  <td class="bg-warning text-end text-dark">
                    {{ cart.total_discount().toFixed(2) }}
                  </td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary">Taxable Value</td>
                  <td class="bg-primary text-end">-</td>
                  <td class="bg-secondary">Taxable Value</td>
                  <td class="bg-primary text-end">
                    {{ cart.total_taxable().toFixed(2) }}
                  </td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary">Packing</td>
                  <td class="bg-primary text-end">-</td>

                  <td class="bg-secondary">Tax</td>
                  <td class="bg-info text-end">
                    {{ cart.total_taxable().toFixed(2) }}
                  </td>
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
                      <div>{{ cart.total_payable().toFixed(2) }}</div>
                    </div>
                  </td>
                </tr>
                <tr class="">
                  <td class="text-center fs-5 p-0">
                    <button
                      class="btn btn-danger w-100 rounded-0"
                      type="button"
                      :disabled="cart.products.length == 0"
                    >
                      Cancel
                    </button>
                  </td>
                  <td class="text-center fs-5 p-0">
                    <button
                      class="btn btn-warning w-100 rounded-0"
                      type="button"
                      :disabled="cart.products.length == 0"
                    >
                      Draft
                    </button>
                  </td>
                  <td rowspan="2" colspan="2" class="p-0 m-0">
                    <button
                      class="btn btn-success w-100 rounded-0"
                      style="min-height: 78px"
                      type="button"
                      :disabled="cart.products.length == 0"
                    >
                      <span class="fs-5"
                        ><i class="fa-solid fa-credit-card"></i></span
                      >&nbsp;&nbsp;&nbsp;&nbsp;<span class="fs-4"
                        >Checkout</span
                      >
                    </button>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="fs-5 p-0">
                    <button
                      class="btn btn-info w-100 rounded-0"
                      type="button"
                      :disabled="cart.products.length == 0"
                    >
                      Print
                    </button>
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
.btn.my-btn {
  right: 0;
  top: 0;
  height: 100%;
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
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
input:disabled,
button:disabled {
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
import CustomerNewModal from "../customer/CustomerNewModal.vue";
export default {
  components: {
    CustomerNewModal,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    const autocompleteList = ref([]);
    const autocompleteCart = ref([]);
    const searchBox = ref(null);
    const products = ref([]);
    const cart = ref({
      products: [],
      shipping_charge: 0,
      total_items: function () {
        return this.products.length;
      },
      total_quantity: function () {
        var total_quantity = 0;
        this.products.forEach((element, index, array) => {
          total_quantity = total_quantity + element.quantity;
        });
        return total_quantity;
      },
      tax: function () {
        var tax = 0;
        this.products.forEach((element, index, array) => {
          tax = tax + element.tax;
        });
        return tax;
      },
      total_price: function () {
        var total_price = 0;
        this.products.forEach((element, index, array) => {
          total_price = total_price + element.price * element.quantity;
        });
        return total_price;
      },
      total_auto_discount: function () {
        var total_auto_discount = 0;
        this.products.forEach((element, index, array) => {
          total_auto_discount =
            total_auto_discount + element.auto_discount * element.quantity;
        });
        return total_auto_discount;
      },
      total_custom_discount: function () {
        var total_custom_discount = 0;
        this.products.forEach((element, index, array) => {
          total_custom_discount = total_custom_discount + element.discount;
        });
        return total_custom_discount;
      },
      discount: 0,
      total_discount: function () {
        return (
          this.total_auto_discount() +
          this.total_custom_discount() +
          this.discount
        );
      },
      total_taxable: function () {
        var total_taxable = 0;
        this.products.forEach((element, index, array) => {
          total_taxable = total_taxable + element.taxable_value();
        });
        return total_taxable - this.discount;
      },
      total_payable: function () {
        var total_payable = 0;
        this.products.forEach((element, index, array) => {
          total_payable += Number(
            parseFloat(total_payable + element.total()).toFixed(2)
          );
        });
        return total_payable + this.shipping_charge;
      },
    });
    const { axiosAsyncStoreReturnBool, axiosAsyncCallReturnData } = admin();
    var search_product = null;
    var search_remove = null;
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
    function searchProductCart(query) {
      query = query.toLowerCase();
      if (query) {
        let items = cart.value.products.filter(
          (obj) =>
            obj.name.toLowerCase().includes(query) ||
            obj.code.toLowerCase().includes(query)
        ); // match check for name and code
        if (items.length > 1) {
          // many product found
          this.autocompleteCart = items;
        } else if (items.length == 1) {
          // One product found
          this.checkAndRemove(items[0]);
        } else {
          // no product found
          this.autocompleteCart = [];
          this.search_remove = null;
          this.emitter.emit("showAlert", {
            title: "No matching product !",
            body:
              "No matching product found in cart for query <b>" +
              query +
              "</b> !",
            type: "danger",
            play: "danger.mp3",
          });
        }
      } else {
        this.autocompleteCart = [];
      }
    }
    function checkAndRemove(product) {
      this.autocompleteCart = [];
      this.search_remove = null;
      emitter.emit("deleteConfirmModal", {
        title: null,
        body: "Confirm delete <b>" + product.name + "</b> from cart ?",
        data: product,
        hide: true,
        emit: "confirmDeleteProduct",
        type: "danger",
      });
    }
    function checkAndPush(product) {
      if (!this.cart.products.some((data) => data.id === product.id)) {
        // new
        /************************************** */
        product.min_sale_qty =
          product.min_sale_qty == null
            ? 1
            : Number(parseFloat(product.min_sale_qty).toFixed(2));
        product.max_sale_qty =
          product.max_sale_qty == null
            ? null
            : Number(parseFloat(product.max_sale_qty).toFixed(2));
        product.quantity = Number(parseFloat(product.quantity).toFixed(2));
        product.price = Number(parseFloat(product.price).toFixed(2));
        product.auto_discount =
          product.auto_discount == null
            ? 0
            : Number(
                parseFloat(product.auto_discount * product.quantity).toFixed(2)
              );
        product.discount = 0; // custom discout per item (not quantity)
        product.taxable_value = function () {
          return Number(
            (
              product.price * product.quantity -
              product.quantity * product.auto_discount
            ).toFixed(2)
          );
        };
        product.tax = 10;
        product.total = function () {
          return Number(
            (
              product.price * product.quantity -
              product.quantity * product.auto_discount -
              product.discount +
              product.tax
            ).toFixed(2)
          );
        };
        /************************************** */
        this.cart.products.push(product);
      } else {
        // update
        let index = this.cart.products.findIndex(
          (item) => item.id === product.id
        );
        let productElement = this.cart.products[index];
        /************************************** */
        if (
          !this.cart.products[index].max_sale_qty ||
          (this.cart.products[index].max_sale_qty &&
            this.cart.products[index].quantity <
              this.cart.products[index].max_sale_qty)
        ) {
          this.cart.products[index].quantity++;
        } else {
          emitter.emit("showAlert", {
            title: "Quantity limit exceeded !",
            body:
              "Default maximum quantity " +
              productElement.max_sale_qty +
              " applied for the product <b>" +
              productElement.name +
              "</b>",
            type: "danger",
            play: "danger.mp3",
          });
        }
        /************************************** */
      }
      this.autocompleteList = [];
      this.search_product = null;
      this.searchBox.focus();
    }
    function changeQuantity(product, quantity) {
      let index = cart.value.products.findIndex(
        (item) => item.id === product.id
      );
      quantity = Number(parseFloat(quantity).toFixed(2));
      if (quantity) {
        if (quantity < product.min_sale_qty) {
          cart.value.products[index].quantity = product.min_sale_qty;
          emitter.emit("showAlert", {
            title: "Minimum quantity required !",
            body:
              "Default minimum quantity " +
              product.min_sale_qty +
              " applied for the product <b>" +
              product.name +
              "</b>",
            type: "danger",
            play: "danger.mp3",
          });
        } else if (product.max_sale_qty && quantity > product.max_sale_qty) {
          cart.value.products[index].quantity = product.max_sale_qty;
          emitter.emit("showAlert", {
            title: "Quantity limit exceeded !",
            body:
              "Default maximum quantity " +
              product.max_sale_qty +
              " applied for the product <b>" +
              product.name +
              "</b>",
            type: "danger",
            play: "danger.mp3",
          });
        } else {
          cart.value.products[index].quantity = quantity;
          this.searchBox.focus();
        }
      } else {
        cart.value.products[index].quantity = product.min_sale_qty;
        emitter.emit("showAlert", {
          title: "Invalid quantity !",
          body:
            "Default minimum quantity " +
            product.min_sale_qty +
            " applied for the product <b>" +
            product.name +
            "</b>",
          type: "danger",
          play: "danger.mp3",
        });
      }
    }
    function changeDiscount(product, discount) {
      let index = cart.value.products.findIndex(
        (item) => item.id === product.id
      );
      if (discount >= 0) {
        cart.value.products[index].discount = discount == 0 ? 0 : discount;
      } else {
        cart.value.products[index].discount = 0;
        emitter.emit("showAlert", {
          title: "Invalid discount !",
          body:
            "Discount " +
            0 +
            " applied for the product <b>" +
            product.name +
            "</b>",
          type: "danger",
          play: "danger.mp3",
        });
      }
    }
    function changePrice(product, price) {
      let index = cart.value.products.findIndex(
        (item) => item.id === product.id
      );
      if (price > 0) {
        cart.value.products[index].price = price;
      } else {
        cart.value.products[index].price = product.price;
        emitter.emit("showAlert", {
          title: "Invalid price !",
          body:
            "Previous Price " +
            product.price +
            " applied for the product <b>" +
            product.name +
            "</b>",
          type: "danger",
          play: "danger.mp3",
        });
      }
    }
    function changeShippingCharge(price) {
      if (price > 0) {
        price = parseFloat(price.toFixed(2));
        cart.value.shipping_charge = price;
      } else {
        cart.value.shipping_charge = 0;
      }
    }
    function quantityButton(product, operator) {
      let index = cart.value.products.findIndex(
        (item) => item.id === product.id
      );
      cart.value.products[index].quantity = Number(
        cart.value.products[index].quantity
      ); // get current quantity
      if (operator == "+") {
        cart.value.products[index].quantity =
          product.max_sale_qty && product.quantity + 1 > product.max_sale_qty
            ? product.max_sale_qty
            : product.quantity + 1;
      } else {
        cart.value.products[index].quantity =
          product.quantity - 1 < product.min_sale_qty
            ? product.min_sale_qty
            : product.quantity - 1;
      }
      this.searchBox.focus();
    }
    function lostProductFocus() {}
    emitter.on("confirmDeleteProduct", (data) => {
      // delete selected product stuff here
      let index = cart.value.products.findIndex((item) => item.id === data.id);
      cart.value.products.splice(index, 1);
    });
    function newCustomer() {
      emitter.emit("newCustomerModal", {
        title: "New Customer",
        type: "success",
        emit: "changeCutomer",
      });
    }
    return {
      emitter,
      newCustomer,
      searchProduct,
      searchProductCart,
      search_product,
      search_remove,
      confirmDeleteShow,
      autocompleteList,
      autocompleteCart,
      axiosAsyncCallReturnData,
      checkAndPush,
      checkAndRemove,
      products,
      searchBox,
      lostProductFocus,
      cart,
      changeQuantity,
      quantityButton,
      changeDiscount,
      changePrice,
      changeShippingCharge,
    };
  },
  methods: {},
  watch: {
    cart: {
      handler() {
        this.emitter.emit("playSound", { file: "add.mp3" });
      },
      deep: true,
    },
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("confirmDeleteProduct");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>