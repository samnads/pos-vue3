<template>
  <CustomerNewModal />
  <CustomerInfoModal />
  <!-- Checkout Modal -->
  <div class="modal" id="checkoutFinalModal" tabindex="-1" aria-hidden="true">
    <div
      class="
        modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable
      "
    >
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title">
            <i class="fa-solid fa-cart-shopping"></i>Checkout Sale
          </h5>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-9">
              <div class="card border-info mb-2">
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <label class="form-label">Customer</label> : Walk-in
                      Customer
                    </div>
                    <div class="col-6 text-end">
                      <label class="form-label"> Customer ID</label> : CUS7116
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <label class="form-label">Bonus Points</label> : N/A
                    </div>
                    <div class="col-6 text-end">
                      <label class="form-label">Group</label> : CUS7116
                    </div>
                  </div>
                </div>
              </div>
              <ul class="list-group">
                <li class="list-group-item bg-secondary text-light fs-5">
                  Payment Details
                </li>
                <li
                  class="list-group-item bg-danger text-light"
                  v-if="!payments.length"
                >
                  This pos sale payment will be treated as Due, because of No
                  payment method added !
                </li>
                <li
                  class="list-group-item border-secondary"
                  v-for="p in payments"
                  :key="p.id"
                  style="background: lightblue"
                >
                  <button
                    type="button"
                    class="
                      border
                      bg-light
                      btn btn-sm btn-close
                      position-sticky
                      start-100
                      m-0
                    "
                    v-if="payments.length > 0"
                    @click="removePayment(p)"
                  ></button>
                  <div class="row">
                    <div class="col-6">
                      <label class="form-label">Amount<i>*</i></label>
                      <input
                        type="number"
                        step="any"
                        class="form-control"
                        v-model="p.amount"
                        @focus="$event.target.select()"
                      />
                    </div>
                    <div class="col-6">
                      <label class="form-label">Payment Method<i>*</i></label>
                      <select
                        class="form-select"
                        v-model="p.mode"
                        :disabled="!paymentModes"
                      >
                        <option selected :value="null" v-if="!paymentModes">
                          Loading...
                        </option>
                        <option
                          v-for="m in paymentModes"
                          :key="m.id"
                          :value="m.id"
                        >
                          {{ m.name }}
                        </option>
                      </select>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Transaction ID</label>
                      <input
                        type="text"
                        v-model="p.transaction_id"
                        class="form-control"
                      />
                    </div>
                    <div class="col-6">
                      <label class="form-label">Reference No.</label>
                      <input
                        type="text"
                        v-model="p.reference_no"
                        class="form-control"
                      />
                    </div>
                    <div class="col-12">
                      <label class="form-label">Note</label>
                      <textarea
                        type="text"
                        rows="1"
                        v-model="p.note"
                        class="form-control"
                      ></textarea>
                    </div>
                  </div>
                </li>
                <li class="list-group-item border-secondary">
                  <div class="row">
                    <div class="col-10 p-0">
                      <span class="ms-2 text-muted"
                        >You can pay using multiple modes by clicking the +
                        button.</span
                      >
                    </div>
                    <div class="col-2 text-end p-0">
                      <div class="btn-group dropstart">
                        <button
                          class="btn btn-sm btn-secondary rounded"
                          type="button"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                          :disabled="!paymentModes"
                        >
                          <i class="fa-solid fa-plus"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item disabled">Select Method</a>
                          </li>
                          <li><hr class="dropdown-divider" /></li>
                          <li
                            v-for="m in paymentModes"
                            :key="m.id"
                            :value="m.id"
                            @click="addNewPayment(m.id)"
                          >
                            <a class="dropdown-item" href="#"
                              ><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;{{
                                m.name
                              }}</a
                            >
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="col-3">
              <div class="sticky-top">
                <div
                  class="
                    card
                    rounded-0 rounded-top
                    text-light
                    order
                    border-primary
                  "
                  v-bind:class="[
                    calc.balance() > 0
                      ? 'bg-danger'
                      : calc.balance() == 0
                      ? 'bg-success'
                      : 'bg-info',
                  ]"
                >
                  <div class="card-body">
                    <div class="row text-end">
                      <div class="col-12 fs-4">Previous Due</div>
                      <div class="col-12 fs-4">
                        <span class="badge bg-light text-dark">{{
                          calc.total_payable_round().toFixed(2)
                        }}</span>
                      </div>
                      <hr class="m-1" />
                      <div class="col-12 fs-4">Current Payable</div>
                      <div class="col-12 fs-4">
                        <span class="badge bg-light text-dark">{{
                          calc.total_payable_round().toFixed(2)
                        }}</span>
                      </div>
                      <hr class="m-1" />
                      <div class="col-12 fs-4">
                        Balance {{ calc.balance() >= 0 ? "" : "Return" }}
                      </div>
                      <div class="col-12 fs-4">
                        <span class="badge bg-light text-dark">{{
                          calc.balance().toFixed(2)
                        }}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="card rounded-0 rounded-bottom border border-primary"
                >
                  <div class="card-body">
                    <div class="col">
                      <label class="form-label">Payment Note</label>
                      <input
                        type="text"
                        v-model="payment_note"
                        class="form-control"
                      />
                    </div>
                    <div class="col">
                      <label class="form-label">Sale Note</label>
                      <input
                        type="text"
                        v-model="sale_note"
                        class="form-control"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
            :disabled="isSubmitting"
          >
            <i class="fa-solid fa-angle-left"></i>Back
          </button>
          <button
            type="button"
            class="btn btn-success"
            @click="onSubmit"
            :disabled="isSubmitting"
          >
            Confirm&nbsp;<i class="fa-solid fa-check"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
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
                  id="search-product-list"
                  class="autocomplete-wrap list-group"
                  style="max-height: 225px"
                >
                  <li
                    @click="checkAndPush(item)"
                    role="button"
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
            <!--<div class="col-10">
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
                  class="autocomplete-wrap list-group"
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
            </div>-->
            <div class="col-2">
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
                  v-model="search_remove"
                  @input="searchProductCart(search_remove)"
                  :disabled="products.length == 0"
                />
                <ul
                  class="autocomplete-wrap list-group"
                  style="max-height: 225px"
                >
                  <li
                    @click="checkAndRemove(item)"
                    class="list-group-item list-group-item-action"
                    v-for="item in autocompleteCart"
                    :key="item.id"
                    :value="item.name"
                    role="button"
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
                  <th scope="col" class="text-end fit">Auto Discount</th>
                  <th scope="col" width="8%" class="text-end">Discount</th>
                  <th scope="col" class="text-end fit">Taxable Value</th>
                  <th scope="col" class="text-end fit">Rate %</th>
                  <th scope="col" class="fit">Tax</th>
                  <th scope="col" class="fit">Total</th>
                  <th scope="col" class="text-center fit">
                    <span class="btn-sm btn-outline-danger"
                      ><i class="fa-solid fa-trash"></i
                    ></span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="border border-light"
                  v-for="(product, index) in products"
                  :key="product.id"
                >
                  <th scope="row">{{ index + 1 }}</th>
                  <td>{{ product.code }}</td>
                  <td>
                    <div class="d-flex justify-content-between">
                      {{ product.name }}
                      <div>
                        <i class="fa-solid fa-pencil" role="button"></i>
                      </div>
                    </div>
                  </td>
                  <td>{{ product.hsn || "-" }}</td>
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
                        @change="changeQuantity(product, $event.target.value)"
                        type="number"
                        class="form-control no-arrow text-center"
                        @focus="$event.target.select()"
                        :value="product.quantity"
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
                      @change="changePrice(product, $event.target.value)"
                      :value="product.price"
                    />
                  </td>
                  <td class="text-danger text-end">
                    {{ product.total_auto_discount_().toFixed(2) }}
                  </td>
                  <td>
                    <input
                      type="number"
                      class="
                        form-control form-control-sm
                        no-arrow
                        text-danger text-end
                      "
                      @focus="$event.target.select()"
                      :value="product.discount"
                      @change="changeDiscount(product, $event.target.value)"
                      :disabled="!product.allow_custom_discount"
                    />
                  </td>
                  <td class="text-end">
                    {{ product.total_taxable_value_().toFixed(2) }}
                  </td>
                  <td class="text-end">
                    {{ product.tax_rate.toFixed(2) }}
                  </td>
                  <td class="text-end">
                    {{ product.total_tax_().toFixed(2) }}
                  </td>
                  <td class="text-end fw-bold">
                    {{ product.total_().toFixed(2) }}
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
            <!--<p>Products : {{ products }}</p>
            <p>Payments : {{ payments }}</p>
            <p>Customer : {{ customer }}</p>
            <p>Packing : {{ packing }}</p>
            <p>Shipping : {{ shipping }}</p>
            <p>Discount : {{ discount }}</p>-->
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
                  :placeholder="customer ? customer.name : 'Customer name...'"
                  ref="searchCustomerBox"
                  v-model="search_customer"
                  @input="searchCustomer($event.target.value)"
                  :disabled="customer_readonly"
                />
                <ul
                  id="search-product-list"
                  class="autocomplete-wrap list-group"
                  style="max-height: 225px"
                >
                  <li
                    @click="changeCustomer(c)"
                    role="button"
                    class="list-group-item list-group-item-action"
                    v-for="c in autocompleteCustomerList"
                    :key="c.id"
                    :value="c.name"
                  >
                    {{ c.name }}
                  </li>
                </ul>
                <span
                  class="input-group-text"
                  role="button"
                  v-show="customer_readonly"
                  data-bs-toggle="tooltip"
                  data-bs-placement="left"
                  @click="toggleCustomer"
                  ><span v-if="customer_readonly"
                    ><i class="fa-solid fa-lock"></i></span
                ></span>
                <button
                  class="input-group-text bg-secondary text-light"
                  data-bs-toggle="tooltip"
                  data-bs-placement="left"
                  title="Customer Details"
                  v-show="customer"
                  @click="showCustomerInfo"
                >
                  <i class="fa-solid fa-binoculars"></i>
                </button>
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
                    {{ calc.total_items() }}
                  </td>
                  <td class="bg-secondary" width="25%">Price Total</td>
                  <td class="bg-info text-end" width="25%">
                    {{ calc.total_price().toFixed(2) }}
                  </td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary">Quantity</td>
                  <td class="bg-primary text-end">
                    {{ calc.total_quantity().toFixed(2) }}
                  </td>
                  <td class="bg-secondary">Auto Discount</td>
                  <td class="bg-warning text-end text-dark">
                    {{ calc.total_auto_discount().toFixed(2) }}
                  </td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary">Custom Disc.</td>
                  <td class="bg-warning text-dark text-end">
                    {{ calc.total_custom_discount().toFixed(2) }}
                  </td>
                  <td class="bg-secondary">Cart Disc.</td>
                  <td class="bg-warning bg-gradient text-dark text-end p-0">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text rounded-0"
                        ><i class="fa-solid fa-tag"></i
                      ></span>
                      <input
                        type="number"
                        step="any"
                        class="form-control text-end rounded-0 no-arrow"
                        v-model="discount"
                        @focus="$event.target.select()"
                        @change="changeCartDiscount(discount)"
                      />
                    </div>
                    <!--<div class="d-flex justify-content-between">
                      <div class="text-muted">
                        <i class="fa-solid fa-tag"></i>
                      </div>
                      <div>{{ discount.toFixed(2) }}</div>
                    </div>-->
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
                        v-model="shipping"
                        @focus="$event.target.select()"
                        @change="changeShippingCharge(shipping)"
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
                    {{ calc.total_discount() }}
                  </td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary">Packing</td>
                  <td class="bg-primary text-end p-0">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text rounded-0"
                        ><i class="fa-solid fa-gift"></i
                      ></span>
                      <input
                        type="number"
                        step="any"
                        class="form-control text-end rounded-0 no-arrow"
                        v-model="packing"
                        @focus="$event.target.select()"
                        @change="changePackingCharge(packing)"
                      />
                    </div>
                  </td>
                  <td class="bg-secondary">Taxable Value</td>
                  <td class="bg-primary text-end">
                    {{ calc.total_taxable().toFixed(2) }}
                  </td>
                </tr>
                <tr class="border-bottom border-dark">
                  <td class="bg-secondary">Round off</td>
                  <td class="bg-primary text-end">{{ calc.round_off() }}</td>

                  <td class="bg-secondary">Tax</td>
                  <td class="bg-info text-end">
                    {{ calc.tax().toFixed(2) }}
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
                      <div>{{ calc.total_payable_round().toFixed(2) }}</div>
                    </div>
                  </td>
                </tr>
                <tr class="">
                  <td class="text-center fs-5 p-0">
                    <button
                      class="btn btn-danger w-100 rounded-0"
                      type="button"
                      @click="cancelPos"
                      :disabled="!isDirty"
                    >
                      Cancel
                    </button>
                  </td>
                  <td class="text-center fs-5 p-0">
                    <button
                      class="btn btn-warning w-100 rounded-0"
                      type="button"
                      @click="draftPos"
                      :disabled="!isValid"
                    >
                      Draft
                    </button>
                  </td>
                  <td rowspan="2" colspan="2" class="p-0 m-0">
                    <button
                      class="btn btn-success w-100 rounded-0"
                      style="min-height: 78px"
                      type="button"
                      @click="checkoutPos"
                      :disable="!isValid"
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
                      @click="printPos"
                      :disabled="!isValid"
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
import { watch, ref, computed } from "vue";
import { inject } from "vue";
import admin from "@/mixins/admin.js";
import { Modal } from "bootstrap";
import { useStore } from "vuex";
import {
  useForm,
  useField,
  useIsFormDirty,
  useIsFormValid,
} from "vee-validate";
import * as yup from "yup";
import CustomerNewModal from "../customer/CustomerNewModal.vue";
import CustomerInfoModal from "../customer/CustomerInfoModal.vue";
export default {
  components: {
    CustomerNewModal,
    CustomerInfoModal,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    const autocompleteList = ref([]);
    const autocompleteCart = ref([]);
    const autocompleteCustomerList = ref([]);
    var search_product = null;
    var search_remove = null;
    var search_customer = null;
    const customer_readonly = ref(false);
    const searchBox = ref(null);
    const searchCustomerBox = ref(null);
    const store = useStore();
    let paymentModes = computed(function () {
      return store.state.PAYMENT_MODES;
    });
    const schema = computed(() => {
      return yup.object({
        customer: yup
          .object()
          .required("Please add customer details !")
          .label("Customer"),
        products: yup
          .array()
          .required()
          .min(1, "Please add some products !")
          .label("Products"),
        payments: yup
          .array(
            yup.object().shape({
              id: yup.number().required().label("Payment ID"),
              amount: yup
                .number()
                .typeError("Amount must be a number")
                .required()
                .moreThan(0)
                .label("Amount"),
              mode: yup.number().required().label("Mode"),
              transaction_id: yup.string().nullable().label("Trans. ID"),
              reference_no: yup.string().nullable().label("Ref. No."),
              note: yup.string().nullable().label("Note"),
            })
          )
          .required()
          .label("Payments"),
        packing: yup.number().required().min(0).label("Packing"),
        shipping: yup.number().required().min(0).label("Shipping"),
        discount: yup.number().required().min(0).label("Discount"),
        roundoff: yup.number().required().label("Round off"),
        payment_note: yup.string().nullable().label("Payment Note"),
        sale_note: yup.string().nullable().label("Sale Note"),
      });
    });
    var formValues = {
      products: [],
      payments: [
        {
          id: Date.now(),
          amount: 0,
          mode: 2,
          transaction_id: null,
          reference_no: null,
          note: null,
        },
      ],
      packing: 0,
      shipping: 0,
      discount: 0,
      roundoff: 0,
    }; // pre form values
    const {
      setFieldValue,
      handleSubmit,
      setFieldError,
      isSubmitting,
      resetForm,
    } = useForm({
      validationSchema: schema,
      initialValues: formValues,
      initialErrors: {},
    });
    const { value: customer } = useField("customer");
    const { value: products } = useField("products");
    const { value: payments } = useField("payments");
    const { value: packing } = useField("packing");
    const { value: shipping } = useField("shipping");
    const { value: discount } = useField("discount");
    const { value: roundoff } = useField("roundoff");
    const { value: payment_note } = useField("payment_note");
    const { value: sale_note } = useField("sale_note");
    const isDirty = useIsFormDirty();
    const isValid = useIsFormValid();
    const calc = {
      total_items: function () {
        return products.value.length;
      },
      total_quantity: function () {
        var total_quantity = 0;
        products.value.forEach((element, index, array) => {
          total_quantity += element.quantity;
        });
        return total_quantity;
      },
      tax: function () {
        var tax = 0;
        products.value.forEach((element, index, array) => {
          tax += element.total_tax_();
        });
        return tax;
      },
      total_price: function () {
        var total_price = 0;
        products.value.forEach((element, index, array) => {
          total_price += element.total_quantity_price_();
        });
        return total_price;
      },
      total_auto_discount: function () {
        var total_auto_discount = 0;
        products.value.forEach((element, index, array) => {
          total_auto_discount += element.total_auto_discount_();
        });
        return total_auto_discount;
      },
      total_custom_discount: function () {
        var total_custom_discount = 0;
        products.value.forEach((element, index, array) => {
          total_custom_discount += element.discount;
        });
        return total_custom_discount;
      },
      total_discount: function () {
        return (
          this.total_auto_discount() +
          this.total_custom_discount() +
          discount.value
        );
      },
      total_taxable: function () {
        var total_taxable = 0;
        products.value.forEach((element, index, array) => {
          total_taxable += element.total_taxable_value_();
        });
        return total_taxable;
      },
      total_payable: function () {
        var total_payable = 0;
        products.value.forEach((element, index, array) => {
          total_payable += Number(parseFloat(element.total_()).toFixed(2));
        });
        total_payable =
          total_payable - discount.value + shipping.value + packing.value;
        return total_payable;
      },
      total_payable_round: function () {
        var total_payable = 0;
        products.value.forEach((element, index, array) => {
          total_payable += Number(parseFloat(element.total_()).toFixed(2));
        });
        total_payable =
          total_payable - discount.value + shipping.value + packing.value;
        var round_off = total_payable - Math.floor(total_payable);
        return total_payable - round_off;
      },
      round_off: function () {
        return Number(
          parseFloat(this.total_payable_round() - this.total_payable()).toFixed(
            2
          )
        );
      },
      balance: function () {
        var totalPaying = 0;
        payments.value.forEach((element, index, array) => {
          totalPaying += element.amount;
        });
        return this.total_payable_round() - totalPaying;
      },
    };
    function onInvalidSubmit({ values, errors }) {
      console.log("Form field errors found !");
      console.log(errors);
      for (var key in errors) {
        notifyDefault({ message: errors[key] });
      }
    }
    const onSubmit = handleSubmit((values) => {
      values.roundoff = calc.round_off();
      return axiosAsyncCallReturnData("POST", "pos", {
        action: "create",
        data: values,
      }).then(function (data) {
        if (data.success == true) {
          console.log("POS added !");
          resetForm();
          window.CHECKOUT_FINAL_MODAL.hide();
        } else if (data.success == false) {
          console.log("POS not added !");
          // valid error
          if (data.errors) {
            for (var key in data.errors) {
              notifyDefault({ message: data.errors[key] });
            }
          }
        } else {
          // other error
        }
      });
    }, onInvalidSubmit);
    const {
      notifyDefault,
      axiosAsyncStoreReturnBool,
      axiosAsyncCallReturnData,
      x_percentage_of_y,
    } = admin();
    function confirmDeleteShow(data) {
      emitter.emit("deleteConfirmModal", {
        title: null,
        body: "Confirm delete <b>" + data.name + "</b> from cart ?",
        data: data,
        hide: true,
        emit: "confirmDeleteProduct",
        type: "danger",
      });
    }
    function searchProduct(query) {
      var self = this;
      self.autocompleteList = [];
      if (query) {
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
          }
        });
      }
    }
    function searchCustomer(query) {
      var self = this;
      this.autocompleteCustomerList = [];
      if (query) {
        if (self.controller) {
          self.controller.abort();
        }
        self.controller = new AbortController();
        this.axiosAsyncCallReturnData(
          "get",
          "pos",
          {
            action: "create",
            search: "customer",
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
              // many cus found
              self.autocompleteCustomerList = items;
            } else if (items.length == 1) {
              // One cus found
              self.search_customer = null;
              changeCustomer(items[0]);
            } else {
              // no cus found
              self.search_customer = null;
              self.emitter.emit("showAlert", {
                title: "No search result found !",
                body:
                  "No customer found for your search query <b>" +
                  query +
                  "</b> !",
                type: "danger",
                play: "danger.mp3",
              });
            }
          }
        });
      }
    }
    function searchProductCart(query) {
      query = query.toLowerCase();
      this.autocompleteCart = [];
      if (query) {
        let items = products.value.filter(
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
    function changeCustomer(data) {
      setFieldValue("customer", data);
    }
    function toggleCustomer() {
      customer_readonly.value = customer_readonly.value == true ? false : true;
      this.searchCustomerBox.focus();
    }
    function checkAndPush(product) {
      this.search_product = null;
      if (!products.value.some((data) => data.id === product.id)) {
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
            : Number(parseFloat(product.auto_discount).toFixed(2));
        product.discount = 0; // custom discout per item (not per quantity)
        product.taxable_value = Number(
          (
            product.price * product.quantity -
            product.quantity * product.auto_discount
          ).toFixed(2)
        );
        product.tax = 20;
        product.tax_rate = Number(parseFloat(product.tax_rate || 0).toFixed(2));
        product.total_quantity_price_ = function () {
          return Number(
            parseFloat(product.price * product.quantity).toFixed(2)
          );
        };
        product.total_auto_discount_ = function () {
          return Number(
            parseFloat(product.auto_discount * product.quantity).toFixed(2)
          );
        };
        product.total_taxable_value_ = function () {
          return Number(
            (
              product.total_quantity_price_() -
              product.total_auto_discount_() -
              product.discount
            ).toFixed(2)
          );
        };
        product.total_tax_ = function () {
          return x_percentage_of_y(
            product.tax_rate,
            product.total_taxable_value_()
          );
        };
        product.total_ = function () {
          return Number(
            (
              product.total_quantity_price_() -
              product.total_auto_discount_() -
              product.discount +
              product.total_tax_()
            ).toFixed(2)
          );
        };
        /************************************** */
        products.value.push(product);
      } else {
        // update
        let index = products.value.findIndex((item) => item.id === product.id);
        let productElement = products.value[index];
        /************************************** */
        if (
          !products.value[index].max_sale_qty ||
          (products.value[index].max_sale_qty &&
            products.value[index].quantity < products.value[index].max_sale_qty)
        ) {
          products.value[index].quantity++;
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
      this.searchBox.focus();
    }
    function changeQuantity(product, quantity) {
      let index = products.value.findIndex((item) => item.id === product.id);
      quantity = Number(parseFloat(quantity).toFixed(2));
      if (quantity) {
        if (product.unit_allow_decimal == 0 && quantity % 1 != 0) {
          // check if unit allow decimal number
          products.value[index].quantity = product.min_sale_qty;
          emitter.emit("showAlert", {
            title: "Decimal Not Allowed !",
            body:
              "Default minimum quantity " +
              product.min_sale_qty +
              " applied for the product <b>" +
              product.name +
              "</b>",
            type: "danger",
            play: "danger.mp3",
          });
        } else if (quantity < product.min_sale_qty) {
          // check if quantity less than min quanitity
          products.value[index].quantity = product.min_sale_qty;
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
          // check if quantity greater than max quanitity
          products.value[index].quantity = product.max_sale_qty;
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
          // no error found - then change quantity
          products.value[index].quantity = quantity;
          this.searchBox.focus();
        }
      } else {
        // invalid quantity number
        products.value[index].quantity = product.min_sale_qty; // set minimum quantity
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
    function changeDiscount(product, disc) {
      let index = products.value.findIndex((item) => item.id === product.id);
      disc = Number(parseFloat(disc).toFixed(2));
      if (product.allow_custom_discount == 1) {
        if (disc >= 0) {
          products.value[index].discount = disc;
        } else {
          products.value[index].discount = 0;
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
      } else {
        products.value[index].discount = 0;
        emitter.emit("showAlert", {
          title: "Discount Denied !",
          body:
            "Custom discount not allowed for the product <b>" +
            products.value[index].name+"</b> !",
          type: "danger",
          play: "danger.mp3",
        });
      }
    }
    function changePrice(product, price) {
      let index = products.value.findIndex((item) => item.id === product.id);
      price = Number(parseFloat(price).toFixed(2));
      if (price > 0) {
        products.value[index].price = price;
      } else {
        products.value[index].price = product.price;
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
      setFieldValue("shipping", price > 0 ? parseFloat(price.toFixed(2)) : 0);
    }
    function changePackingCharge(price) {
      setFieldValue("packing", price > 0 ? parseFloat(price.toFixed(2)) : 0);
    }
    function changeCartDiscount(price) {
      setFieldValue("discount", price > 0 ? parseFloat(price.toFixed(2)) : 0);
    }
    function quantityButton(product, operator) {
      let index = products.value.findIndex((item) => item.id === product.id);
      products.value[index].quantity = Number(products.value[index].quantity); // get current quantity
      if (operator == "+") {
        products.value[index].quantity =
          product.max_sale_qty && product.quantity + 1 > product.max_sale_qty
            ? product.max_sale_qty
            : product.quantity + 1;
      } else {
        products.value[index].quantity =
          product.quantity - 1 < product.min_sale_qty
            ? product.min_sale_qty
            : product.quantity - 1;
      }
      this.searchBox.focus();
    }
    function lostProductFocus() {}
    emitter.on("confirmDeleteProduct", (data) => {
      // delete selected product stuff here
      let index = products.value.findIndex((item) => item.id === data.id);
      products.value.splice(index, 1);
    });
    function cancelPos() {
      emitter.emit("deleteConfirmModal", {
        title: "Cancel Sale ?",
        body: "Cancel current sale ?",
        hide: true,
        emit: "confirmCancelSale",
        type: "danger",
        play: "pos cancel sale.mp3",
      });
    }
    emitter.on("confirmCancelSale", (data) => {
      //products.value = [];
      //packing.value = shipping.value = discount.value = roundoff.value = 0;
      //payments.value = [{ id: Date.now(), amount: 0, mod: 1 }];
      resetForm();
    });
    function draftPos() {
      alert("draftPos");
    }
    function printPos() {
      alert("printPos");
    }
    function checkoutPos() {
      /*emitter.emit("playSound", {
        file: "pos checkout.mp3",
      });*/
      window.CHECKOUT_FINAL_MODAL.show();
    }
    function newCustomer() {
      emitter.emit("newCustomerModal", {
        title: "New Customer",
        type: "success",
        emit: "changeCutomer",
      });
    }
    function showCustomerInfo() {
      emitter.emit("showCustomerInfoModal", {
        title: "",
        type: "",
        emit: "",
      });
    }
    function addNewPayment(mode) {
      let payMethod = {
        id: Date.now(),
        amount: 0,
        mode: mode,
        transaction_id: null,
        reference_no: null,
        note: null,
      };
      payments.value.push(payMethod);
    }
    function removePayment(payment) {
      let index = payments.value.findIndex((item) => item.id === payment.id);
      payments.value.splice(index, 1);
    }
    function submitForm() {}
    watch(
      [customer, products, discount, packing, shipping, payments],
      () => {
        customer_readonly.value = customer.value ? true : false;
        emitter.emit("playSound", { file: "add.mp3" });
      },
      { deep: true }
    );
    return {
      customer,
      payments,
      packing,
      shipping,
      discount,
      roundoff,
      payment_note,
      sale_note,
      calc,
      onSubmit,
      emitter,
      newCustomer,
      searchProduct,
      search_customer,
      customer_readonly,
      toggleCustomer,
      searchProductCart,
      searchCustomer,
      showCustomerInfo,
      search_product,
      search_remove,
      confirmDeleteShow,
      autocompleteList,
      autocompleteCart,
      autocompleteCustomerList,
      notifyDefault,
      axiosAsyncStoreReturnBool,
      axiosAsyncCallReturnData,
      x_percentage_of_y,
      checkAndPush,
      checkAndRemove,
      changeCustomer,
      products,
      searchBox,
      searchCustomerBox,
      lostProductFocus,
      changeQuantity,
      quantityButton,
      changeDiscount,
      changePrice,
      changeShippingCharge,
      changePackingCharge,
      changeCartDiscount,
      cancelPos,
      draftPos,
      printPos,
      checkoutPos,
      paymentModes,
      addNewPayment,
      removePayment,
      submitForm,
      isDirty,
      isValid,
      setFieldValue,
      isSubmitting,
    };
  },
  methods: {},
  mounted() {
    var self = this;
    window.CHECKOUT_FINAL_MODAL = new Modal($("#checkoutFinalModal"), {
      backdrop: "static",
      show: true,
    });
    if (!this.paymentModes) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storePaymentModes", "pos", {
        action: "create",
        dropdown: "payment_modes",
      });
      // get product types
    }
    document.onclick = function () {
      // hide dropdowns and reset search
      self.autocompleteList = [];
      self.autocompleteCart = [];
      self.autocompleteCustomerList = [];
      self.search_product = null;
      self.search_remove = null;
      self.search_customer = null;
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