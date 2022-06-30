<template>
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-cart-arrow-down"></i><span>New Adjustment</span>
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
    <form @submit="onSubmit" class="needs-validation">
      <div class="card mb-2">
        <h5 class="card-header bg-secondary text-light">Basic Details</h5>
        <div class="card-body">
          <div class="row">
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
              <label class="form-label">Date<i>*</i></label>
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
              <label class="form-label">Reference No.</label>
              <div class="input-group is-invalid">
                <input
                  type="text"
                  name="ref_no"
                  v-model="ref_no"
                  class="form-control"
                />
              </div>
              <div class="invalid-feedback">{{ errorRefNo }}</div>
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
      <div class="card">
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
                name="search"
                v-model="search"
                class="form-control"
                placeholder="Scan or type product name..."
              />
            </div>
            <ul class="auto-complete-result">
              <a
                @click="checkAndPush(item)"
                class="list-group-item list-group-item-action"
                v-for="item in autocompleteList"
                :key="item.id"
                :value="item.name"
                >{{ item.label }}</a
              >
            </ul>
          </div>
          <table
            class="
              table table-hover table-striped table-bordered
              align-middle
              mt-2
            "
          >
            <thead class="table-dark">
              <tr>
                <th scope="col" style="width: 1%">#</th>
                <th scope="col" style="width: 50%">Code | Name</th>
                <th scope="col" style="width: 1%" class="text-center">Type</th>
                <th scope="col" class="text-center">Quantity</th>
                <th scope="col">Note</th>
                <th scope="col" style="width: 1%">
                  <i class="fa-solid fa-trash-can"></i>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(product, index) in products" :key="product.id">
                <th scope="row">{{ index + 1 }}</th>
                <td>
                  <i>{{ product.code }}</i> ~ <b>{{ product.name }}</b>
                </td>
                <td class="text-center">
                  <span v-if="product.quantity > 0"
                    ><i class="fa-solid fa-square-plus text-success"></i></span
                  ><span v-else
                    ><i class="fa-solid fa-square-minus text-danger"></i
                  ></span>
                </td>
                <td>
                  <div class="input-group input-group-sm is-invalid">
                    <button
                      type="button"
                      class="btn btn-warning input-group-text"
                      @click="quantityButton(product, '-')"
                    >
                      <i class="fa-solid fa-minus"></i>
                    </button>
                    <input
                      @change="changeQuantity(product.id, product.quantity)"
                      type="number"
                      v-model="product.quantity"
                      class="form-control no-arrow text-center"
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
                  <div class="input-group input-group-sm is-invalid">
                    <textarea
                      type="text"
                      v-model="product.note"
                      class="form-control"
                      rows="1"
                    ></textarea>
                  </div>
                </td>
                <td
                  class="text-danger"
                  role="button"
                  @click="confirmDeleteShow(product)"
                >
                  <i class="fa-solid fa-trash-can"></i>
                </td>
              </tr>
              <tr class="text-center" v-if="products.length == 0">
                <td colspan="6" class="text-center text-muted">
                  Empty product list, use the search bar to add products...
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="d-flex pt-3">
        <div class="me-auto">
          <button
            type="submit"
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
    </form>
  </div>
</template>
<style>
.auto-complete-result {
  list-style: none;
  margin: 0;
  max-height: 207px;
  overflow-y: auto;
  padding: 0;
}
.auto-complete-result a:hover {
  background-color: grey;
  color: white;
}
</style>
<script>
import { useStore } from "vuex";
import { ref, computed } from "vue";
import { useForm, useField, useIsFormDirty } from "vee-validate";
import * as yup from "yup";
import admin from "@/mixins/admin.js";
import { useRouter, useRoute } from "vue-router";
import { inject } from "vue";
export default {
  components: {},
  setup() {
    const router = useRouter();
    const store = useStore();
    const route = useRoute();
    const searchBox = ref(null);
    const products = ref([]);
    var deleteModalProducts = ref([]);
    var deleteModalId = ref();
    var deleteModalTitle = ref("");
    var deleteModalBody = ref("");
    const emitter = inject("emitter"); // Inject `emitter`
    const { axiosAsyncStoreReturnBool, axiosAsyncCallReturnData } = admin();
    let warehouses = computed(function () {
      return store.state.WARE_HOUSES;
    });
    /************************************************************************* */
    var formValues = {}; // pre form values
    var dbData = ref({}); // pre form data for edit product
    if (route.name == "adminProductAdjustmentEdit" && route.params.data) {
      dbData.value = JSON.parse(route.params.data); // required
      //console.log(dbData.value)
      formValues = {
        warehouse: dbData.value.warehouse,
        date: dbData.value.date,
        ref_no: dbData.value.reference_no,
        note: dbData.value.note,
      };
      products.value = dbData.value.products;
    } else if (route.name == "adminProductAdjustmentNew") {
      formValues = {
        warehouse: null,
      };
    } else {
      router.push({ name: "adminProductAdjustmentList" }).catch(() => {});
    }
    const schema = computed(() => {
      return yup.object({
        warehouse: yup
          .number()
          .required()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Warehouse"),
        search: yup.string().nullable(true).label("Search"),
        note: yup.string().nullable(true).label("Note"),
        ref_no: yup.string().nullable(true).label("Ref. No."),
        date: yup
          .date()
          .required()
          .nullable(true)
          .transform((curr, orig) => (orig === "" ? null : curr))
          .label("Date"),
      });
    });
    const { handleSubmit, setFieldError, isSubmitting, resetForm } = useForm({
      validationSchema: schema,
      initialValues: formValues,
      initialErrors: {},
    });
    const { value: warehouse, errorMessage: errorWareHouse } =
      useField("warehouse");
    const { value: search, errorMessage: errorSearch } = useField("search");
    const { value: ref_no, errorMessage: errorRefNo } = useField("ref_no");
    const { value: note, errorMessage: errorNote } = useField("note");
    const { value: date, errorMessage: errorDate } = useField("date");
    const isDirty = useIsFormDirty();
    /************************************************************************* */
    function onInvalidSubmit({ values }) {
      console.log("Form field errors found !");
      console.log(values);
    }
    const onSubmit = handleSubmit((values) => {
      values.search = undefined;
      values.products = products.value;
      console.log(values.date);
      var method = "POST";
      if (route.name == "adminProductAdjustmentEdit") {
        values.id = dbData.value.id;
        method = "PUT";
      }
      return axiosAsyncCallReturnData(method, "stock_adjustment", {
        data: values,
      }).then(function (data) {
        if (data.success == true) {
          console.log("Adjustment added !");
        } else if (data.success == false) {
          console.log("Adjustment not added !");
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
        this.products.push(product);
      } else {
        // update
        let index = this.products.findIndex((item) => item.id === product.id);
        this.products[index].quantity++;
      }
      this.autocompleteList = [];
      this.search = null;
      this.searchBox.focus();
      this.emitter.emit("playSound", { file: "add.mp3" });
    }
    function changeQuantity(id, quantity) {
      let index = this.products.findIndex((item) => item.id === id);
      if (quantity) {
        this.products[index].quantity = quantity;
      } else {
        this.products[index].quantity = 1;
      }
      this.emitter.emit("playSound", { file: "add.mp3" });
    }
    function quantityButton(product, operator) {
      let index = this.products.findIndex((item) => item.id === product.id);
      this.products[index].quantity = Number(this.products[index].quantity);
      if (operator == "+") {
        this.products[index].quantity =
          this.products[index].quantity + 1 == 0
            ? 1
            : this.products[index].quantity + 1;
      } else {
        this.products[index].quantity =
          this.products[index].quantity - 1 == 0
            ? -1
            : this.products[index].quantity - 1;
      }
      this.emitter.emit("playSound", { file: "add.mp3" });
      this.searchBox.focus();
    }
    function confirmDeleteShow(data) {
      emitter.emit("deleteConfirmModal", {
        title: null,
        body: "Confirm delete <b>" + data.name + "</b> from list ?",
        data: data,
        hide:true,
        emit: "confirmDeleteProduct",
        type: "danger",
      });
      window.DELETE_CONFIRM_DEFAULT_MODAL.show();
    }
    emitter.on("confirmDeleteProduct", (data) => {
      console.log(data)
      // delete selected adjustment stuff here
      let index = products.value.findIndex((item) => item.id === data.id);
      products.value.splice(index, 1);
      emitter.emit("playSound", { file: "add.mp3" });
    });
    var autocompleteList = ref([]);
    /*autocompleteList = [
      {
        id: 5,
        code: "38644788",
        name: "Couple Photo Frame",
        value: "Couple Photo Frame",
        price: "200.0000",
        unit_price: null,
        mrp: "300.0000",
        thumbnail:
          "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7iyBDZf-tfvjCrGwONFuvg3Wj33FJ8xrsBg&usqp=CAU",
        unit_discount: null,
        discount: null,
        tax_method: "E",
        quantity: 1,
        mfg_date: null,
        exp_date: null,
        type: "Standard Product",
        symbology: "CODE128",
        category_id: 1,
        category_name: "School Items",
        sub_category_id: null,
        sub_category_name: null,
        brand_id: 1,
        brand_name: "Lexi",
        brand_code: "L",
        unit_id: 1,
        unit_name: "Piece",
        unit_code: "PC",
        tax_id: 2,
        tax_code: "IGST2",
        tax_name: "IGST",
        tax_rate: "2.1300",
        label: "Couple Photo Frame | 38644788 | Rs. 200.00",
      },
      {
        id: 186,
        code: "96213555",
        name: "have data field 1 - 2",
        value: "have data field 1 - 2",
        price: "150.0000",
        unit_price: "140.0000",
        mrp: "500.0000",
        thumbnail: null,
        unit_discount: "10.0000",
        discount: "10.0000",
        tax_method: "I",
        quantity: 1,
        mfg_date: "30/May/2022",
        exp_date: "06/Jun/2022",
        type: "Standard Product",
        symbology: "CODE39",
        category_id: 2,
        category_name: "Office Items",
        sub_category_id: null,
        sub_category_name: null,
        brand_id: 1,
        brand_name: "Lexi",
        brand_code: "L",
        unit_id: 1,
        unit_name: "Piece",
        unit_code: "PC",
        tax_id: null,
        tax_code: null,
        tax_name: null,
        tax_rate: null,
        label: "have data field 1 - 2 | 96213555 | Rs. 150.00",
      },
      {
        id: 10,
        code: "39741136",
        name: "Keyboard Mouse Combo",
        value: "Keyboard Mouse Combo",
        price: "1000.0000",
        unit_price: "750.0000",
        mrp: "4500.0000",
        thumbnail:
          "https://images-na.ssl-images-amazon.com/images/I/619gY3%2BheVL._SL1000_.jpg",
        unit_discount: "250.0000",
        discount: "250.0000",
        tax_method: "I",
        quantity: 1,
        mfg_date: null,
        exp_date: null,
        type: "Standard Product",
        symbology: "CODE128",
        category_id: 4,
        category_name: "Electronics",
        sub_category_id: null,
        sub_category_name: null,
        brand_id: 1,
        brand_name: "Lexi",
        brand_code: "L",
        unit_id: 1,
        unit_name: "Piece",
        unit_code: "PC",
        tax_id: 2,
        tax_code: "IGST2",
        tax_name: "IGST",
        tax_rate: "2.1300",
        label: "Keyboard Mouse Combo | 39741136 | Rs. 1000.00",
      },
      {
        id: 180,
        code: "54805482",
        name: "Name 1",
        value: "Name 1",
        price: "50.0000",
        unit_price: null,
        mrp: "500.0000",
        thumbnail: null,
        unit_discount: null,
        discount: null,
        tax_method: "I",
        quantity: 1,
        mfg_date: null,
        exp_date: null,
        type: "Standard Product",
        symbology: "CODE128",
        category_id: 1,
        category_name: "School Items",
        sub_category_id: null,
        sub_category_name: null,
        brand_id: 1,
        brand_name: "Lexi",
        brand_code: "L",
        unit_id: 1,
        unit_name: "Piece",
        unit_code: "PC",
        tax_id: 1,
        tax_code: "GST10",
        tax_name: "GST",
        tax_rate: "10.0000",
        label: "Name 1 | 54805482 | Rs. 50.00",
      },
      {
        id: 6,
        code: "94426911",
        name: "Wall Clock",
        value: "Wall Clock",
        price: "570.0000",
        unit_price: null,
        mrp: null,
        thumbnail:
          "https://images-na.ssl-images-amazon.com/images/I/51VjOomhxoL._SY355_.jpg",
        unit_discount: null,
        discount: null,
        tax_method: "E",
        quantity: 1,
        mfg_date: null,
        exp_date: null,
        type: "Standard Product",
        symbology: "CODE128",
        category_id: 1,
        category_name: "School Items",
        sub_category_id: null,
        sub_category_name: null,
        brand_id: 1,
        brand_name: "Lexi",
        brand_code: "L",
        unit_id: 1,
        unit_name: "Piece",
        unit_code: "PC",
        tax_id: 2,
        tax_code: "IGST2",
        tax_name: "IGST",
        tax_rate: "2.1300",
        label: "Wall Clock | 94426911 | Rs. 570.00",
      },
    ];*/
    function resetCustom() {
      this.products = [];
      resetForm();
    }
    return {
      autocompleteList,
      products,
      warehouses,
      warehouse,
      errorWareHouse,
      search,
      searchBox,
      errorSearch,
      ref_no,
      errorRefNo,
      date,
      errorDate,
      note,
      errorNote,
      onSubmit,
      isDirty,
      isSubmitting,
      resetForm,
      resetCustom,
      axiosAsyncStoreReturnBool,
      axiosAsyncCallReturnData,
      changeQuantity,
      quantityButton,
      confirmDeleteShow,
      checkAndPush,
      deleteModalId,
      deleteModalProducts,
      deleteModalTitle,
      deleteModalBody,
      emitter,
    };
  },
  data() {
    return {};
  },
  methods: {
  },
  watch: {
    search(query) {
      var self = this;
      if (query) {
        self.autocompleteList = [];
        if (self.controller) {
          self.controller.abort();
        }
        self.controller = new AbortController();
        this.axiosAsyncCallReturnData(
          "get",
          "product",
          {
            action: "autocomplete",
            type: "adjustment",
            search: query,
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
              self.search = null;
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
    },
  },
  created() {},
  mounted() {
    if (!this.warehouses) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeWareHouses", "warehouse", {
        action: "dropdown",
      }); // get ware houses
    }
  },
};
</script>