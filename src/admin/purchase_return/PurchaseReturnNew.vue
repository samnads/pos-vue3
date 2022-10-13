<template>
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-rotate-left"></i><span>Purchase Return</span>
        </h5>
      </div>
      <div class="p-2 bd-highlight"></div>
      <div class="p-2 bd-highlight"></div>
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
    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-2">
        <label class="form-label">Date & Time<i>*</i></label>
        <div class="input-group is-invalid">
          <span class="input-group-text"
            ><i class="fa-solid fa-calendar"></i
          ></span>
          <input
            type="datetime-local"
            step="1"
            name="date"
            v-model="date"
            class="form-control"
          />
        </div>
        <div class="invalid-feedback">{{ errorDate }}</div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-2">
        <label class="form-label">Return Status<i>*</i></label>
        <div class="input-group is-invalid">
          <select
            class="form-select text-capitalize"
            :disabled="!statuses"
            v-model="return_status"
            v-bind:class="[
              errorReturnStatus
                ? 'is-invalid'
                : statuses && return_status
                ? 'is-valid'
                : '',
            ]"
          >
            <option :value="null" selected>
              {{ statuses ? "-- Select --" : "Loading..." }}
            </option>
            <option
              v-for="s in statuses &&
              statuses.filter((obj) => obj.purchase_return_status == 1)"
              :key="s.id"
              :value="s.id"
            >
              {{ s.name }}
            </option>
          </select>
        </div>
        <div class="invalid-feedback">{{ errorReturnStatus }}</div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4">
        <label class="form-label">Purchase Ref. No.</label>
        <div class="input-group is-invalid">
          <input
            v-if="DATA"
            type="text"
            class="form-control"
            v-model="DATA.reference_id"
            disabled
          />
        </div>
        <div class="invalid-feedback">{{ errorNote }}</div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4" v-if="route.name == 'adminPurchaseReturnEdit'">
        <label class="form-label">Return Ref. No.</label>
        <div class="input-group is-invalid">
          <input
            v-if="DATA"
            type="text"
            class="form-control"
            v-model="DATA.return_reference_id"
            disabled
          />
        </div>
        <div class="invalid-feedback">{{ errorNote }}</div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4">
        <label class="form-label">Return Note</label>
        <div class="input-group is-invalid">
          <textarea
            type="text"
            name="note"
            v-model="note"
            class="form-control"
            rows="1"
          >
          </textarea>
        </div>
        <div class="invalid-feedback">{{ errorNote }}</div>
      </div>
    </div>
    <hr />
    <div class="col">
      <label class="form-label">Search Product ( from purchase only )</label>
      <div class="input-group is-invalid">
        <span class="input-group-text"
          ><i class="fa-solid fa-magnifying-glass"></i
        ></span>
        <input
          type="text"
          ref="searchBox"
          v-model="search_product"
          @input="searchProduct(search_product)"
          class="form-control"
          placeholder="Scan or type product name..."
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
            <span v-html="item.label"></span>
          </li>
        </ul>
      </div>
    </div>
    <hr />
    <table
      class="
        table table-sm table-hover table-striped table-bordered
        align-middle
        mt-2
      "
    >
      <thead class="table-dark">
        <tr>
          <th scope="col" style="width: 1%">#</th>
          <th scope="col" style="width: 15%">Code | Name</th>
          <th scope="col" style="width: 5%">HSN</th>
          <th scope="col" class="text-center" width="10%">Purchase Qty.</th>
          <th scope="col" class="text-center" width="10%">Returned Qty.</th>
          <th scope="col" class="text-center" width="10%">Available Qty.</th>
          <th scope="col" class="text-center" width="10%">Quantity</th>
          <th scope="col" width="8%">Unit</th>
          <th scope="col" class="text-center" width="10%">Cost</th>
          <th scope="col" class="text-center" width="5%">Discount</th>
          <th scope="col" class="text-end" width="6%">Net Unit Cost</th>
          <th scope="col" class="text-end" width="5%">Tax</th>
          <th scope="col" width="6%" class="text-end">Sub Total</th>
          <th scope="col" style="width: 3%" class="text-center">
            <i class="fa-solid fa-trash-can"></i>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(product, index) in products"
          :key="product.id"
          v-bind:class="[
            product.to_be_return_quantity == 0 ? 'bg-warning opaciy-50' : '',
          ]"
        >
          <th scope="row">{{ index + 1 }}</th>
          <td>
            <div class="d-flex justify-content-between">
              {{ product.code }} ~ {{ product.name }}
              <div>
                <i class="fa-solid fa-pencil" role="button"></i>
              </div>
            </div>
          </td>
          <td class="fst-italic">{{ product.hsn }}</td>
          <td class="text-center">
            {{ parseFloat(product.purchase_quantity).toFixed(2) }}
          </td>
          <td class="text-center">
            {{ parseFloat(product.returned_quantity).toFixed(2) }}
          </td>
          <td class="text-center">
            {{ parseFloat(product.to_be_return_quantity).toFixed(2) }}
          </td>
          <td class="text-center">
            <div class="input-group input-group-sm is-invalid">
              <button
                type="button"
                class="btn input-group-text"
                v-bind:class="[
                  product.quantity <= 0 ? 'btn-secondary' : 'btn-warning',
                ]"
                @click="quantityButton(product, '-')"
                :disabled="product.quantity <= 0"
              >
                <i class="fa-solid fa-minus"></i>
              </button>
              <input
                @input="changeQuantity(product.id, product.quantity)"
                type="number"
                step="any"
                v-model="product.quantity"
                class="form-control no-arrow text-center"
                @focus="$event.target.select()"
                :disabled="product.to_be_return_quantity == 0"
              />
              <button
                type="button"
                class="btn input-group-text"
                v-bind:class="[
                  product.quantity == product.to_be_return_quantity
                    ? 'btn-secondary'
                    : 'btn-info',
                ]"
                @click="quantityButton(product, '+')"
                :disabled="product.quantity == product.to_be_return_quantity"
              >
                <i class="fa-solid fa-plus"></i>
              </button>
            </div>
            <small
              class="text-center opacity-75 text-danger"
              v-show="product.to_be_return_quantity > 0"
              >{{ errors["products[" + index + "].quantity"] }}</small
            >
          </td>
          <td>
            <div class="input-group is-invalid">
              <select
                class="form-select form-select-sm text-capitalize"
                :disabled="true"
                v-model="product.p_unit"
                @change="unitChange(product)"
              >
                <option
                  v-for="u in units &&
                  units.filter(
                    (unit) =>
                      unit.base == product.unit || unit.id == product.unit
                  )"
                  :key="u.id"
                  :value="u.id"
                >
                  <!-- product all sub units unit -->
                  {{ u.name }} - [ {{ u.code }} ]
                </option>
              </select>
            </div>
          </td>
          <td>
            <input
              type="number"
              step="any"
              :value="product.cost.toFixed(2)"
              @change="costChange(product, $event.target.value)"
              class="form-control form-control-sm no-arrow text-center"
              @focus="$event.target.select()"
              disabled
            />
          </td>
          <td>
            <input
              type="number"
              step="any"
              :value="product.discount.toFixed(2)"
              @change="discountChange(product, $event.target.value)"
              class="form-control form-control-sm no-arrow text-center"
              @focus="$event.target.select()"
              disabled
            />
          </td>
          <td class="text-end">
            {{ product.cost_after_discount_().toFixed(2) }}
          </td>
          <td class="text-end">{{ product.total_tax_().toFixed(2) }}</td>
          <td class="text-end">{{ product.total_().toFixed(2) }}</td>
          <td
            class="text-danger text-center"
            role="button"
            @click="confirmDeleteShow(product)"
          >
            <i class="fa-solid fa-trash-can"></i>
          </td>
        </tr>
        <tr class="text-center">
          <td
            colspan="11"
            class="text-center text-muted"
            v-if="
              (products.length == 0 &&
                route.name == 'adminPurchaseReturnNew') ||
              (products.length == 0 &&
                route.name == 'adminPurchaseReturnEdit' &&
                DATA)
            "
          >
            Use the search bar to add return products...
            <div class="text-danger">{{ errorProducts }}</div>
          </td>
        </tr>

        <tr v-if="route.name == 'adminPurchaseEdit' && !DATA">
          <td colspan="11" class="text-center text-muted">
            <AdminLoadingSpinnerDiv />
          </td>
        </tr>
        <tr>
          <td colspan="6" class="text-end fw-bold">Total</td>
          <td class="text-center fw-bold">
            {{ calc.total_quantity().toFixed(2) }} ({{ calc.total_items() }})
          </td>
          <td class="text-end fw-bold"></td>
          <td class="text-center fw-bold">
            {{ calc.total_product_cost_before_discount().toFixed(2) }}
          </td>
          <td class="text-center fw-bold">
            {{ calc.total_product_discount().toFixed(2) }}
          </td>
          <td class="text-end fw-bold">
            {{ calc.total_product_cost_after_discount().toFixed(2) }}
          </td>
          <td class="text-end fw-bold">
            {{ calc.total_product_tax().toFixed(2) }}
          </td>
          <td class="text-end fw-bold">
            {{ calc.total_product_sub_total().toFixed(2) }}
          </td>
          <td></td>
        </tr>
      </tbody>
    </table>
    <hr />
    <div class="row">
      <div class="col-auto me-auto"></div>
      <div class="col-xxl-3 col-xl-3 col-lg-5 col-md-6">
        <table class="table table-sm text-light align-middle">
          <tbody>
            <tr>
              <td class="bg-dark bg-opacity-75" width="25%">Discount</td>
              <td class="text-end bg-secondary" width="25%">
                <div class="input-group input-group-sm">
                  <span class="input-group-text rounded-0"
                    ><i class="fa-solid fa-tag"></i
                  ></span>
                  <input
                    type="number"
                    step="any"
                    v-model="discount"
                    @focus="$event.target.select()"
                    @change="changeCartDiscount(discount)"
                    class="
                      form-control form-control-sm
                      text-end
                      rounded-0
                      no-arrow
                    "
                  />
                </div>
              </td>
              <td class="bg-dark bg-opacity-75">After Dsc.</td>
              <td class="bg-secondary text-end">
                {{ calc.total_product_sub_total_after_cart_discount() }}
              </td>
            </tr>
            <tr>
              <td class="bg-dark bg-opacity-75" width="25%">Order Tax Rate</td>
              <td class="text-end bg-secondary" width="25%">
                <select
                  class="form-select form-select-sm rounded-0"
                  :disabled="!taxes"
                  v-model="tax_rate"
                >
                  <option :value="null" selected>
                    {{ taxes ? "-- Select --" : "Loading..." }}
                  </option>
                  <option v-for="tr in taxes" :key="tr.id" :value="tr.id">
                    {{
                      tr.name +
                      " ~ " +
                      parseFloat(tr.rate).toFixed(2) +
                      (tr.type == "P" ? " %" : " (Fixed Rate)")
                    }}
                  </option>
                </select>
              </td>
              <td class="bg-dark bg-opacity-75" width="25%">Tax</td>
              <td class="text-end bg-secondary" width="25%">
                {{ calc.total_order_tax() }}
              </td>
            </tr>
            <tr>
              <td class="bg-dark bg-opacity-75">Shipping & Tax</td>
              <td class="text-end bg-secondary">
                <div class="input-group input-group-sm">
                  <span class="input-group-text rounded-0"
                    ><i class="fa-solid fa-truck"></i
                  ></span>
                  <input
                    type="number"
                    step="any"
                    v-model="shipping"
                    @focus="$event.target.select()"
                    @change="changeShippingCharge(shipping)"
                    class="
                      form-control form-control-sm
                      text-end
                      rounded-0
                      no-arrow
                    "
                  />
                </div>
              </td>
              <td class="bg-dark bg-opacity-75">
                <select
                  class="form-select form-select-sm rounded-0"
                  name="shipping_tax"
                  :disabled="!taxes"
                  v-model="shipping_tax"
                >
                  <option :value="null" selected>
                    {{ taxes ? "-- Select --" : "Loading..." }}
                  </option>
                  <option v-for="tr in taxes" :key="tr.id" :value="tr.id">
                    {{
                      tr.name +
                      " ~ " +
                      parseFloat(tr.rate).toFixed(2) +
                      (tr.type == "P" ? " %" : " (Fixed Rate)")
                    }}
                  </option>
                </select>
              </td>
              <td class="text-end bg-secondary">
                {{ calc.shipping_plus_tax_value() }}
              </td>
            </tr>
            <tr>
              <td class="bg-dark bg-opacity-75">Packing & Tax</td>
              <td class="text-end bg-secondary">
                <div class="input-group input-group-sm">
                  <span class="input-group-text rounded-0"
                    ><i class="fa-solid fa-gift"></i
                  ></span>
                  <input
                    type="number"
                    step="any"
                    v-model="packing"
                    @focus="$event.target.select()"
                    @change="changePackingCharge(packing)"
                    class="
                      form-control form-control-sm
                      text-end
                      rounded-0
                      no-arrow
                    "
                  />
                </div>
              </td>
              <td class="bg-dark bg-opacity-75">
                <select
                  class="form-select form-select-sm rounded-0"
                  name="packing_tax"
                  :disabled="!taxes"
                  v-model="packing_tax"
                >
                  <option :value="null" selected>
                    {{ taxes ? "-- Select --" : "Loading..." }}
                  </option>
                  <option v-for="tr in taxes" :key="tr.id" :value="tr.id">
                    {{
                      tr.name +
                      " ~ " +
                      parseFloat(tr.rate).toFixed(2) +
                      (tr.type == "P" ? " %" : " (Fixed Rate)")
                    }}
                  </option>
                </select>
              </td>
              <td class="bg-secondary text-end">
                {{ calc.packing_plus_tax_value() }}
              </td>
            </tr>
            <tr>
              <td class="bg-dark bg-opacity-75"></td>
              <td class="bg-dark bg-opacity-75"></td>
              <td class="bg-dark bg-opacity-75">Round Off</td>
              <td class="bg-secondary text-end">
                {{ "- " + calc.round_off() }}
              </td>
            </tr>
            <tr>
              <td colspan="2" class="bg-dark bg-gradient fs-5">
                Total Payable
              </td>
              <td
                colspan="2"
                class="bg-light bg-gradient text-dark fw-bold fs-4 text-end"
              >
                <div class="d-flex justify-content-between">
                  <div class="text-muted">₹</div>
                  <div>{{ calc.total_payable_round() }}</div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="d-flex pt-3">
      <div class="me-auto">
        <button
          @click="onSubmit"
          class="btn btn-success"
          :disable="isSubmitting || !isValid"
        >
          {{ isSubmitting ? "Saving..." : "Save" }}
          <span
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true"
            v-if="isSubmitting"
          ></span>
        </button>
      </div>
      <div class="">
        <button
          type="button"
          class="btn btn-secondary"
          v-if="isDirty && !isSubmitting"
          @click="resetCustom"
        >
          <i class="fa-solid fa-rotate-left"></i>
        </button>
      </div>
    </div>
  </div>
</template>
<style>
</style>
<script>
/* eslint-disable */
import { useStore } from "vuex";
import { watch, ref, computed } from "vue";
import {
  useForm,
  useField,
  useIsFormDirty,
  useIsFormValid,
} from "vee-validate";
import * as yup from "yup";
import admin from "@/mixins/admin.js";
import { useRouter, useRoute } from "vue-router";
import { inject } from "vue";
export default {
  components: {},
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const DATA = ref(undefined);
    /************************************************************************* */
    const searchBox = ref(null);
    var search_product = null;
    var autocompleteList = ref([]);
    /************************************************************************* */
    const {
      notifyDefault,
      axiosAsyncStoreReturnBool,
      axiosAsyncCallReturnData,
      x_percentage_of_y,
      tax_value_calc,
    } = admin();
    /************************************************************************* */
    let statuses = computed(function () {
      return store.state.STATUSES;
    });
    let units = computed(function () {
      return store.state.UNITS;
    });
    let taxes = computed(function () {
      return store.state.TAXES;
    });
    /************************************************************************* */
    var formValues = {}; // pre form values
    const schema = computed(() => {
      return yup.object({
        return_status: yup
          .number()
          .required()
          .nullable(true)
          .label("Purchase Status"),
        note: yup.string().nullable(true).label("Note"),
        date: yup
          .date()
          .required()
          .nullable(true)
          .transform((curr, orig) => (orig === "" ? null : curr))
          .label("Date"),
        products: yup
          .array(
            yup.object().shape({
              name: yup.string(),
              quantity: yup
                .number()
                .required("Required")
                .transform((_, val) => (val === Number(val) ? val : null))
                .moreThan(0, "Should be greater than 0."),
            })
          )
          .required()
          .min(1, "Atleast one return product required !")
          .label("Products"),

        packing: yup.number().required().min(0).label("Packing"),
        shipping: yup.number().required().min(0).label("Shipping"),
        shipping_tax: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Shipping Tax"),
        packing_tax: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Packing Tax"),
        discount: yup.number().required().min(0).label("Discount"),
        roundoff: yup.number().required().label("Round off"),
        tax_rate: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Tax Rate"),
      });
    });
    if (route.name == "adminPurchaseReturnNew") {
      formValues = {
        products: [],
        return_status: null,
        packing: 0,
        shipping: 0,
        shipping_tax: null,
        packing_tax: null,
        discount: 0,
        roundoff: 0,
        tax_rate: null,
      };
    } else if (route.name == "adminPurchaseReturnEdit") {
      formValues = {
        products: [],
        return_status: null,
        packing: 0,
        shipping: 0,
        shipping_tax: null,
        packing_tax: null,
        discount: 0,
        roundoff: 0,
        tax_rate: null,
      };
    } else {
      router.push({ name: "adminPurchaseReturnList" }).catch(() => {});
    }
    const {
      setFieldValue,
      handleSubmit,
      setFieldError,
      isSubmitting,
      resetForm,
      errors,
    } = useForm({
      validationSchema: schema,
      initialValues: formValues,
      initialErrors: {},
    });
    const { value: return_status, errorMessage: errorReturnStatus } =
      useField("return_status");
    const { value: note, errorMessage: errorNote } = useField("note");
    const { value: date, errorMessage: errorDate } = useField("date");
    const { value: products, errorMessage: errorProducts } =
      useField("products");
    const { value: packing } = useField("packing");
    const { value: shipping } = useField("shipping");
    const { value: shipping_tax } = useField("shipping_tax");
    const { value: packing_tax } = useField("packing_tax");
    const { value: discount } = useField("discount");
    const { value: roundoff } = useField("roundoff");
    const { value: tax_rate } = useField("tax_rate");
    const isDirty = useIsFormDirty();
    const isValid = useIsFormValid();
    /************************************************************************* */
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
      total_product_cost_before_discount: function () {
        var total_product_cost_before_discount = 0;
        products.value.forEach((element, index, array) => {
          total_product_cost_before_discount +=
            element.total_cost_before_discount_();
        });
        return total_product_cost_before_discount;
      },
      total_product_cost_after_discount: function () {
        var total_product_cost_after_discount = 0;
        products.value.forEach((element, index, array) => {
          total_product_cost_after_discount +=
            element.total_cost_after_discount_();
        });
        return total_product_cost_after_discount;
      },
      total_product_discount: function () {
        var total_product_discount = 0;
        products.value.forEach((element, index, array) => {
          total_product_discount += element.total_discount_();
        });
        return total_product_discount;
      },
      total_product_tax: function () {
        var total_product_tax = 0;
        products.value.forEach((element, index, array) => {
          total_product_tax += element.total_tax_();
        });
        return total_product_tax;
      },
      total_product_sub_total: function () {
        var total_product_sub_total = 0;
        products.value.forEach((element, index, array) => {
          total_product_sub_total += element.total_();
        });
        return total_product_sub_total;
      },
      total_product_sub_total_after_cart_discount: function () {
        return this.total_product_sub_total() - discount.value;
      },
      total_order_tax: function () {
        if (tax_rate.value > 0 && taxes.value && taxes.value.length) {
          return Number(
            tax_value_calc(
              taxes.value.find((obj) => {
                return obj.id == tax_rate.value;
              }),
              this.total_product_sub_total_after_cart_discount()
            )
          );
        }
        return 0;
      },
      total_payable: function () {
        var total_payable = 0;
        total_payable =
          this.total_product_sub_total_after_cart_discount() +
          this.total_order_tax() +
          this.shipping_plus_tax_value() +
          this.packing_plus_tax_value();
        return parseFloat(total_payable);
      },
      shipping_plus_tax_value: function () {
        if (
          shipping_tax.value > 0 &&
          shipping.value &&
          taxes.value &&
          taxes.value.length
        ) {
          return (
            shipping.value +
            Number(
              tax_value_calc(
                taxes.value.find((obj) => {
                  return obj.id == shipping_tax.value;
                }),
                shipping.value
              )
            )
          );
        }
        return shipping.value;
      },
      packing_plus_tax_value: function () {
        if (
          packing_tax.value > 0 &&
          packing.value &&
          taxes.value &&
          taxes.value.length
        ) {
          return (
            packing.value +
            Number(
              tax_value_calc(
                taxes.value.find((obj) => {
                  return obj.id == packing_tax.value;
                }),
                packing.value
              )
            )
          );
        }
        return packing.value;
      },
      round_off: function () {
        var round_off = this.total_payable() - Math.floor(this.total_payable());
        return round_off;
      },
      total_payable_round: function () {
        return this.total_payable() - this.round_off();
      },
    };
    /************************************************************************* */
    function onInvalidSubmit({ values, errors }) {
      console.log("Form field errors found !");
      console.log(errors);
      for (var key in errors) {
        //notifyDefault({ message: errors[key] });
      }
    }
    const onSubmit = handleSubmit((values) => {
      console.log(values.date);
      var method = "POST";
      var action = "create";
      values.purchase = Number(route.params.id);
      if (route.name == "adminPurchaseReturnEdit") {
        values.id = DATA.value.id;
        method = "PUT";
        action = "update";
      }
      values.roundoff = calc.round_off();
      return axiosAsyncCallReturnData(method, "purchase_return", {
        data: values,
        action: action,
      }).then(function (data) {
        if (data.success == true) {
        } else if (data.success == false) {
          // valid error
          if (data.errors) {
            for (var key in data.errors) {
              setFieldError(key, data.errors[key]);
            }
          }
        } else {
          // other error
        }
      });
    }, onInvalidSubmit);
    /************************************************************************* */
    function checkAndPush(product) {
      if (!this.products.some((data) => data.id === product.id)) {
        // new
        if (product.to_be_return_quantity > 0) {
          // return qty available
          product.quantity = 1;
        } else {
          // qty not available
          product.quantity = 0;
        }
        product.discount = 0; // always 0 for new
        /******************************* */
        product.db_cost = parseFloat(product.cost);
        product.db_unit = parseFloat(product.unit);
        product.unit = product.db_unit;
        /******************************* purchase unit cost calculation */
        let p_unit_index = this.units.findIndex(
          (item) => item.id == product.p_unit
        );
        let step = this.units[p_unit_index].step;
        product.cost = product.db_cost * step;
        /******************************* */
        product.cost_after_discount_ = function () {
          // net unit cost after discount
          return Number(product.cost - product.discount);
        };
        product.total_cost_before_discount_ = function () {
          // total quantity cost aft
          return Number(parseFloat(product.quantity * product.cost));
        };
        product.total_cost_after_discount_ = function () {
          // total quantity cost aft
          return Number(
            parseFloat(product.quantity * product.cost_after_discount_())
          );
        };
        product.total_discount_ = function () {
          return Number(
            parseFloat(
              product.total_cost_before_discount_() -
                product.total_cost_after_discount_()
            )
          );
        };
        product.total_tax_ = function () {
          return Number(
            parseFloat(
              x_percentage_of_y(
                product.tax_rate,
                product.total_cost_after_discount_()
              )
            )
          );
        };
        product.total_ = function () {
          return Number(
            product.total_cost_after_discount_() + product.total_tax_()
          );
        };
        /************************************** */
        this.products.push(product);
      } else {
        // update
        let index = this.products.findIndex((item) => item.id === product.id);
        if (
          product.to_be_return_quantity >=
          this.products[index].quantity + 1
        ) {
          // return qty available
          this.products[index].quantity++;
        } else {
          // qty not available
          emitter.emit("showAlert", {
            title: "Return quantity exceeded !",
            body:
              "Their is no more <b>" +
              product.name +
              "</b> available to return !",
            type: "danger",
            play: "danger.mp3",
          });
        }
      }
      this.autocompleteList = [];
      this.search_product = null;
      this.searchBox.focus();
    }
    function changeQuantity(id, quantity) {
      let index = this.products.findIndex((item) => item.id === id);
      if (
        quantity >= 1 &&
        quantity <= this.products[index].to_be_return_quantity
      ) {
        this.products[index].quantity = quantity;
      } else {
        this.products[index].quantity = 0;
      }
    }
    function quantityButton(product, operator) {
      let index = this.products.findIndex((item) => item.id === product.id);
      this.products[index].quantity = Number(this.products[index].quantity);
      if (operator == "+") {
        if (
          this.products[index].quantity + 1 >
          this.products[index].to_be_return_quantity
        ) {
          //
        } else {
          this.products[index].quantity = this.products[index].quantity + 1;
        }
      } else {
        this.products[index].quantity =
          this.products[index].quantity - 1 < 0
            ? 1
            : this.products[index].quantity - 1;
      }
      this.searchBox.focus();
    }
    function confirmDeleteShow(data) {
      emitter.emit("deleteConfirmModal", {
        title: null,
        body:
          "Confirm delete <b>" + data.name + "</b> from purchase return list ?",
        data: data,
        hide: true,
        emit: "confirmDeleteProduct",
        type: "danger",
      });
      window.DELETE_CONFIRM_DEFAULT_MODAL.show();
    }
    emitter.on("confirmDeleteProduct", (data) => {
      // delete selected adjustment stuff here
      let index = products.value.findIndex((item) => item.id === data.id);
      products.value.splice(index, 1);
    });
    function resetCustom() {
      resetForm();
    }
    function changeShippingCharge(price) {
      setFieldValue("shipping", price > 0 ? parseFloat(price) : 0);
    }
    function changePackingCharge(price) {
      setFieldValue("packing", price > 0 ? parseFloat(price) : 0);
    }
    function changeCartDiscount(price) {
      setFieldValue("discount", price > 0 ? parseFloat(price) : 0);
    }
    function unitChange(product) {
      let index = this.products.findIndex((item) => item.id === product.id);
      //
      let p_unit_index = this.units.findIndex(
        (item) => item.id === product.p_unit
      );
      let step = this.units[p_unit_index].step;
      //
      this.products[index].cost = this.products[index].db_cost * step;
    }
    function costChange(product, cost) {
      cost = Number(parseFloat(cost));
      if (cost > 0) {
        let index = this.products.findIndex((item) => item.id === product.id);
        //
        let p_unit_index = this.units.findIndex(
          (item) => item.id === product.p_unit
        );
        let step = this.units[p_unit_index].step;
        // change on cart data
        this.products[index].db_cost = cost / step;
        this.products[index].cost = cost;
      } else {
        emitter.emit("showAlert", {
          title: "Invalid cost !",
          body:
            "Previous cost " +
            product.db_cost +
            " applied for the product <b>" +
            product.name +
            "</b>",
          type: "danger",
          play: "danger.mp3",
        });
      }
    }
    function discountChange(product, discount) {
      discount = Number(discount);
      if (discount >= 0 && discount <= product.cost) {
        let index = this.products.findIndex((item) => item.id === product.id);
        // change on cart data
        this.products[index].discount = discount;
      } else {
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
          "purchase_return",
          {
            action: "create",
            search: "product",
            query: query,
            purchase: DATA.value.id,
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
                  "No product found in purchase list for your search query <b>" +
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
    watch(
      [
        /*date,
        note,*/
        products,
        shipping,
        shipping_tax,
        packing,
        packing_tax,
        discount,
        tax_rate,
      ],
      () => {
        //customer_readonly.value = customer.value ? true : false;
        emitter.emit("playSound", { file: "add.mp3" });
      },
      { deep: true }
    );
    return {
      autocompleteList,
      products,
      errorProducts,
      return_status,
      errorReturnStatus,
      search_product,
      searchProduct,
      searchBox,
      date,
      errorDate,
      note,
      errorNote,
      onSubmit,
      isDirty,
      isValid,
      isSubmitting,
      resetForm,
      resetCustom,
      notifyDefault,
      axiosAsyncStoreReturnBool,
      axiosAsyncCallReturnData,
      x_percentage_of_y,
      tax_value_calc,
      changeQuantity,
      quantityButton,
      confirmDeleteShow,
      setFieldValue,
      checkAndPush,
      emitter,
      statuses,
      units,
      unitChange,
      costChange,
      calc,
      packing,
      shipping,
      shipping_tax,
      packing_tax,
      discount,
      roundoff,
      changeShippingCharge,
      changePackingCharge,
      changeCartDiscount,
      discountChange,
      taxes,
      tax_rate,
      route,
      DATA,
      errors,
    };
  },
  data() {
    return {};
  },
  methods: {},
  watch: {},
  created() {},
  mounted() {
    var self = this;
    /************************************************************** GET DB DATA for editing */
    this.axiosAsyncCallReturnData(
      "GET",
      "purchase_return",
      {
        action:
          self.route.name == "adminPurchaseReturnNew" ? "create" : "update",
        job:
          self.route.name == "adminPurchaseReturnNew"
            ? "purchase_with_return_data_for_add"
            : "purchase_with_return_data_for_edit",
        id: Number(self.route.params.id),
      },
      null,
      {
        showSuccessNotification: false,
        showCatchNotification: true,
        showProgress: true,
      }
    ).then(function (response) {
      if (response.success == true) {
        var data = response.data;
        self.DATA = data; // store db data
        var products = data.products;
        var units = data.units;
        products.forEach((element, index) => {
          products[index].hsn = "000";
          products[index].quantity = Number(element.quantity); //item quantity
          products[index].discount = Number(element.unit_discount); // unit (per p_unit) discount
          products[index].db_cost = Number(element.db_cost); // base unit cost
          products[index].db_unit = Number(element.p_unit); // base unit
          products[index].unit = Number(element.unit); // purchase unit
          products[index].p_unit = Number(element.p_unit); // purchase unit
          products[index].to_be_return_quantity = Number(
            element.to_be_return_quantity
          ); // quantity available to return;
          /******************************* purchase unit cost calculation */
          let p_unit_index = units.findIndex(
            (item) => item.id == products[index].p_unit
          );
          let step = units[p_unit_index].step;
          products[index].cost = products[index].db_cost * step; // calc p_unit cost
          /******************************* */
          products[index].tax_rate = Number(element.tax_rate);
          products[index].cost_after_discount_ = function () {
            // net unit cost after discount
            return Number(products[index].cost - products[index].discount);
          };
          products[index].total_cost_before_discount_ = function () {
            // total quantity cost aft
            return Number(
              parseFloat(products[index].quantity * products[index].cost)
            );
          };
          products[index].total_cost_after_discount_ = function () {
            // total quantity cost aft
            return Number(
              parseFloat(
                products[index].quantity *
                  products[index].cost_after_discount_()
              )
            );
          };
          products[index].total_discount_ = function () {
            return Number(
              parseFloat(
                products[index].total_cost_before_discount_() -
                  products[index].total_cost_after_discount_()
              )
            );
          };
          products[index].total_tax_ = function () {
            return Number(
              parseFloat(
                self.x_percentage_of_y(
                  products[index].tax_rate,
                  products[index].total_cost_after_discount_()
                )
              )
            );
          };
          products[index].total_ = function () {
            return Number(
              products[index].total_cost_after_discount_() +
                products[index].total_tax_()
            );
          };
          self.products.push(products[index]);
        });
        if (self.route.name == "adminPurchaseReturnNew") { // for new create show current time
          var date_ = new Date(
            Date.now() + new Date().getTimezoneOffset() * -60 * 1000
          );
          // slice(0, 19) includes seconds
          self.setFieldValue("date", date_.toISOString().slice(0, 19));
          self.setFieldValue("return_status", 5);
        } else { // for edit show db time
          self.setFieldValue("date", data.date + "T" + data.time);
          self.setFieldValue("return_status", data.status);
        }
        self.setFieldValue("discount", data.discount);
        self.setFieldValue("tax_rate", data.purchase_tax);
        self.setFieldValue("shipping", Number(data.shipping_charge));
        self.setFieldValue("shipping_tax", data.shipping_tax);
        self.setFieldValue("packing", Number(data.packing_charge));
        self.setFieldValue("packing_tax", data.packing_tax);
        self.setFieldValue("roundoff", data.round_off);
      }
    });

    /************************************************************** */
    if (!this.statuses) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeStatuses", "purchase", {
        action: "create",
        dropdown: "statuses",
      }); // get statuses
    }
    if (!this.units) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeUnitsAll", "purchase", {
        action: "create",
        dropdown: "units",
      }); // get units
    }
    if (!this.taxes) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeTaxes", "purchase", {
        action: "create",
        dropdown: "tax_rates",
      }); // get tax rates
    }
    document.onclick = function () {
      // hide dropdowns and reset search
      self.autocompleteList = [];
      self.search_product = null;
    };
  },
};
</script>