<template>
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-cart-arrow-down"></i><span>New Purchase</span>
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
    <div class="card mb-2">
      <h5 class="card-header bg-secondary text-light">Basic Details</h5>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-3">
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
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-3">
            <label class="form-label">Supplier<i>*</i></label>
            <div class="input-group is-invalid">
              <select
                class="form-select"
                name="warehouse"
                :disabled="!suppliers"
                v-model="supplier"
                v-bind:class="[
                  errorSupplier
                    ? 'is-invalid'
                    : suppliers && supplier
                    ? 'is-valid'
                    : '',
                ]"
              >
                <option :value="null" selected>
                  {{ suppliers ? "-- Select --" : "Loading..." }}
                </option>
                <option v-for="s in suppliers" :key="s.id" :value="s.id">
                  {{ s.name }}
                </option>
              </select>
            </div>
            <div class="invalid-feedback">{{ errorSupplier }}</div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-3">
            <label class="form-label">Warehouse<i>*</i></label>
            <div class="input-group is-invalid">
              <select
                class="form-select"
                name="warehouse"
                :disabled="!warehouses"
                v-model="warehouse"
                v-bind:class="[
                  errorWareHouse
                    ? 'is-invalid'
                    : warehouses && warehouse
                    ? 'is-valid'
                    : '',
                ]"
              >
                <option :value="null" selected>
                  {{ warehouses ? "-- Select --" : "Loading..." }}
                </option>
                <option v-for="wh in warehouses" :key="wh.id" :value="wh.id">
                  {{ wh.name }}
                </option>
              </select>
            </div>
            <div class="invalid-feedback">{{ errorWareHouse }}</div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-3">
            <label class="form-label">Purchase Status<i>*</i></label>
            <div class="input-group is-invalid">
              <select
                class="form-select text-capitalize"
                name="warehouse"
                :disabled="!statuses"
                v-model="purchase_status"
                v-bind:class="[
                  errorPurchaseStatus
                    ? 'is-invalid'
                    : statuses && purchase_status
                    ? 'is-valid'
                    : '',
                ]"
              >
                <option :value="null" selected>
                  {{ statuses ? "-- Select --" : "Loading..." }}
                </option>
                <option
                  v-for="s in statuses &&
                  statuses.filter((obj) => obj.purchase_status == 1)"
                  :key="s.id"
                  :value="s.id"
                >
                  {{ s.name }}
                </option>
              </select>
            </div>
            <div class="invalid-feedback">{{ errorPurchaseStatus }}</div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-3">
            <label class="form-label">Note</label>
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
      </div>
    </div>
    <div class="card mb-2">
      <h5 class="card-header bg-secondary text-light">Products</h5>
      <div class="card-body">
        <div class="col-12">
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
                {{ item.label }}
              </li>
            </ul>
          </div>
        </div>
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
              <th scope="col" style="width: 25%">Code | Name</th>
              <th scope="col" style="width: 5%">HSN</th>
              <th scope="col" class="text-center" width="10%">Quantity</th>
              <th scope="col" width="6%">Unit</th>
              <th scope="col" class="text-center" width="10%">Cost</th>
              <th scope="col" class="text-center" width="5%">Discount</th>
              <th scope="col" class="text-center" width="6%">Net Unit Cost</th>
              <th scope="col" class="text-center" width="5%">Tax</th>
              <th scope="col" width="6%">Total</th>
              <th scope="col" style="width: 1%">
                <i class="fa-solid fa-trash-can"></i>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(product, index) in products" :key="product.id">
              <th scope="row">{{ index + 1 }}</th>
              <td>
                <div class="d-flex justify-content-between">
                  {{ product.code }} ~ {{ product.name }}
                  <div>
                    <i class="fa-solid fa-pencil" role="button"></i>
                  </div>
                </div>
              </td>
              <td class="fst-italic">000</td>
              <td>
                <div class="input-group input-group-sm is-invalid">
                  <button
                    type="button"
                    class="btn input-group-text"
                    v-bind:class="[
                      product.quantity == 1 ? 'btn-secondary' : 'btn-warning',
                    ]"
                    @click="quantityButton(product, '-')"
                    :disabled="product.quantity == 1"
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
                  />
                  <button
                    type="button"
                    class="btn btn-info input-group-text"
                    @click="quantityButton(product, '+')"
                  >
                    <i class="fa-solid fa-plus"></i>
                  </button>
                </div>
              </td>
              <td>
                <select
                  class="form-select text-capitalize"
                  :disabled="!units"
                  v-model="product.unit"
                  @change="unitChange(product, product.unit)"
                >
                  <option :value="product.unit_id" selected>
                    {{ product.unit_name }} - [ {{ product.unit_code }} ]
                  </option>
                  <option
                    v-for="u in units &&
                    units.filter((obj) => obj.base == product.unit_id)"
                    :key="u.id"
                    :value="u.id"
                  >
                    {{ u.name }} - [ {{ u.code }} ]
                  </option>
                </select>
              </td>
              <td>
                <input
                  type="number"
                  step="any"
                  v-model="product.cost"
                  class="form-control form-control-sm no-arrow text-center"
                  @focus="$event.target.select()"
                />
              </td>
              <td>
                <input
                  type="number"
                  step="any"
                  v-model="product.discount"
                  class="form-control form-control-sm no-arrow text-center"
                  @focus="$event.target.select()"
                />
              </td>
              <td>{{ product.net_unit_cost_() }}</td>
              <td>{{ product.total_tax_() }}</td>
              <td class="text-end fw-bold">{{ product.total_() }}</td>
              <td
                class="text-danger"
                role="button"
                @click="confirmDeleteShow(product)"
              >
                <i class="fa-solid fa-trash-can"></i>
              </td>
            </tr>
            <tr class="text-center" v-if="products.length == 0">
              <td colspan="11" class="text-center text-muted">
                Empty product list, use the search bar to add products...
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card mb-2">
      <h5 class="card-header bg-secondary text-light">More Details</h5>
      <div class="card-body"></div>
    </div>
    <div class="d-flex pt-3">
      <div class="me-auto">
        <button
          @click="onSubmit"
          class="btn btn-success"
          :disabled="isSubmitting"
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
import { useForm, useField, useIsFormDirty } from "vee-validate";
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
    } = admin();
    /************************************************************************* */
    let warehouses = computed(function () {
      return store.state.WARE_HOUSES;
    });
    let suppliers = computed(function () {
      return store.state.SUPPLIERS;
    });
    let statuses = computed(function () {
      return store.state.STATUSES;
    });
    let units = computed(function () {
      return store.state.UNITS;
    });
    /************************************************************************* */
    var formValues = {}; // pre form values
    var dbData = ref({}); // pre form data for edit product
    const schema = computed(() => {
      return yup.object({
        warehouse: yup.number().required().nullable(true).label("Warehouse"),
        supplier: yup.number().required().nullable(true).label("Supplier"),
        purchase_status: yup
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
          .array()
          .required()
          .min(1, "Please add some products !")
          .label("Products"),
      });
    });
    if (route.name == "adminPurchaseEdit" && route.params.data) {
      dbData.value = JSON.parse(route.params.data); // required
      //console.log(dbData.value)
      formValues = {
        warehouse: dbData.value.warehouse,
        date: dbData.value.date,
        note: dbData.value.note,
      };
    } else if (route.name == "adminPurchaseNew") {
      formValues = {
        products: [],
        supplier: null,
        warehouse: null,
        purchase_status: null,
      };
    } else {
      router.push({ name: "adminPurchaseList" }).catch(() => {});
    }
    const { handleSubmit, setFieldError, isSubmitting, resetForm } = useForm({
      validationSchema: schema,
      initialValues: formValues,
      initialErrors: {},
    });
    const { value: supplier, errorMessage: errorSupplier } =
      useField("supplier");
    const { value: warehouse, errorMessage: errorWareHouse } =
      useField("warehouse");
    const { value: purchase_status, errorMessage: errorPurchaseStatus } =
      useField("purchase_status");
    const { value: note, errorMessage: errorNote } = useField("note");
    const { value: date, errorMessage: errorDate } = useField("date");
    const { value: products } = useField("products");
    const isDirty = useIsFormDirty();
    /************************************************************************* */
    function onInvalidSubmit({ values, errors }) {
      console.log("Form field errors found !");
      console.log(errors);
      for (var key in errors) {
        notifyDefault({ message: errors[key] });
      }
    }
    const onSubmit = handleSubmit((values) => {
      console.log(values.date);
      var method = "POST";
      var action = "create";
      if (route.name == "adminPurchaseEdit") {
        values.id = dbData.value.id;
        method = "PUT";
        action = "update";
      }
      return axiosAsyncCallReturnData(method, "purchase", {
        data: values,
        action: action,
      }).then(function (data) {
        if (data.success == true) {
          console.log("Purchase added !");
        } else if (data.success == false) {
          console.log("Purchase not added !");
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
        product.quantity = 1;
        product.cost = Number(parseFloat(product.cost).toFixed(2));
        product.discount =
          product.discount == null
            ? 0
            : Number(parseFloat(product.discount).toFixed(2));
        product.net_unit_cost_ = function () {
          return Number((product.cost - product.discount).toFixed(2));
        };
        product.total_cost_ = function () {
          return Number(parseFloat(product.quantity * product.cost).toFixed(2));
        };
        product.total_discount_ = function () {
          return Number(
            parseFloat(product.quantity * product.discount).toFixed(2)
          );
        };
        product.total_taxable_ = function () {
          return Number(
            (product.total_cost_() - product.total_discount_()).toFixed(2)
          );
        };
        product.total_tax_ = function () {
          return Number(
            parseFloat(
              x_percentage_of_y(
                product.tax_rate,
                product.total_taxable_()
              ).toFixed(2)
            )
          );
        };
        product.total_ = function () {
          return Number(
            (
              product.total_cost_() -
              product.total_discount_() +
              product.total_tax_()
            ).toFixed(2)
          );
        };
        /************************************** */
        this.products.push(product);
      } else {
        // update
        let index = this.products.findIndex((item) => item.id === product.id);
        this.products[index].quantity++;
      }
      this.autocompleteList = [];
      this.search_product = null;
      this.searchBox.focus();
    }
    function changeQuantity(id, quantity) {
      let index = this.products.findIndex((item) => item.id === id);
      if (quantity >= 1) {
        this.products[index].quantity = quantity;
      } else {
        this.products[index].quantity = 1;
      }
    }
    function quantityButton(product, operator) {
      let index = this.products.findIndex((item) => item.id === product.id);
      this.products[index].quantity = Number(this.products[index].quantity);
      if (operator == "+") {
        this.products[index].quantity = this.products[index].quantity + 1;
      } else {
        this.products[index].quantity =
          this.products[index].quantity - 1 == 0
            ? 1
            : this.products[index].quantity - 1;
      }
      this.searchBox.focus();
    }
    function confirmDeleteShow(data) {
      emitter.emit("deleteConfirmModal", {
        title: null,
        body: "Confirm delete <b>" + data.name + "</b> from purchase list ?",
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
    function unitChange(product, unit) {
      let index = this.products.findIndex((item) => item.id === product.id);
      let step = this.units.find((obj) => {
        return obj.id === unit;
      })["step"];
      this.products[index].cost = step * this.products[index].cost;
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
          "purchase",
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
    watch(
      [products],
      () => {
        //customer_readonly.value = customer.value ? true : false;
        emitter.emit("playSound", { file: "add.mp3" });
      },
      { deep: true }
    );
    return {
      autocompleteList,
      products,
      warehouses,
      suppliers,
      supplier,
      errorSupplier,
      warehouse,
      errorWareHouse,
      purchase_status,
      errorPurchaseStatus,
      search_product,
      searchProduct,
      searchBox,
      date,
      errorDate,
      note,
      errorNote,
      onSubmit,
      isDirty,
      isSubmitting,
      resetForm,
      resetCustom,
      notifyDefault,
      axiosAsyncStoreReturnBool,
      axiosAsyncCallReturnData,
      x_percentage_of_y,
      changeQuantity,
      quantityButton,
      confirmDeleteShow,
      checkAndPush,
      emitter,
      statuses,
      units,
      unitChange,
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
    if (!this.warehouses) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeWareHouses", "purchase", {
        action: "create",
        dropdown: "warehouses",
      }); // get ware houses
    }
    if (!this.suppliers) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeSuppliers", "purchase", {
        action: "create",
        dropdown: "suppliers",
      }); // get suppliers
    }
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
    document.onclick = function () {
      // hide dropdowns and reset search
      self.autocompleteList = [];
      self.search_product = null;
    };
  },
};
</script>