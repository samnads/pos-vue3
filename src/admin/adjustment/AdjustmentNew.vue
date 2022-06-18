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
                  type="date"
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
                name="search"
                v-model="search"
                class="form-control"
                placeholder="Scan or type product name..."
              />
            </div>
            <ul class="auto-complete-result">
              <a
                @click="clickList(item)"
                class="list-group-item list-group-item-action"
                v-for="item in autocompleteList"
                :key="item.id"
                :value="item.name"
                >{{ item.label }}</a
              >
            </ul>
          </div>
          <table class="table table-striped table-bordered align-middle mt-2">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Code | Name</th>
                <th scope="col">Type</th>
                <th scope="col" class="text-center">Quantity</th>
                <th scope="col">Note</th>
                <th scope="col" style="width: 1%">
                  <i class="fa-solid fa-trash-can"></i>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="product in products"
                :key="product.id"
              >
                <th scope="row">1</th>
                <td>{{product.code}} | {{product.name}}</td>
                <td>{{product.query > 0 ? 'Add' : 'Remove'}}</td>
                <td>
                  <div class="input-group is-invalid">
                    <button
                      type="button"
                      class="btn btn-secondary input-group-text"
                    >
                      <i class="fa-solid fa-plus solo"></i>
                    </button>
                    <input type="number" class="form-control text-center" :value="product.quantity || 1" />
                    <button
                      type="button"
                      class="btn btn-secondary input-group-text"
                    >
                      <i class="fa-solid fa-minus solo"></i>
                    </button>
                  </div>
                </td>
                <td><textarea type="text" class="form-control" rows="1"></textarea></td>
                <td class="text-danger" role="button">
                  <i class="fa-solid fa-trash-can"></i>
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
            <i class="fa-solid fa-rotate-left solo"></i>
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
/* eslint-disable */
import { useStore } from "vuex";
import { ref, computed } from "vue";
import {
  useForm,
  useField,
  useIsFormDirty,
  useIsFormValid,
} from "vee-validate";
import * as yup from "yup";
import admin from "@/mixins/admin.js";
import adminProduct from "@/mixins/adminProduct.js";
import { useRouter, useRoute } from "vue-router";
export default {
  setup() {
    const store = useStore();
    const route = useRoute();
    const {
      notifyDefault,
      axiosAsyncStoreReturnBool,
      axiosAsyncCallReturnData,
    } = admin();
    let warehouses = computed(function () {
      return store.state.WARE_HOUSES;
    });
    /************************************************************************* */
    var formValues = {}; // pre form values
    if (route.name == "adminProductAdjustmentEdit") {
    } else {
      formValues = {
        warehouse: null,
      };
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
    const { value: warehouse, errorMessage: errorWareHouse } =
      useField("warehouse");
    const { value: search, errorMessage: errorSearch } = useField("search");
    const { value: ref_no, errorMessage: errorRefNo } = useField("ref_no");
    const { value: note, errorMessage: errorNote } = useField("note");
    const { value: date, errorMessage: errorDate } = useField("date");
    const isDirty = useIsFormDirty();
    const isValid = useIsFormValid();
    /************************************************************************* */
    function onInvalidSubmit({ values }) {
      console.log("Form field errors found !");
      console.log(values);
    }
    const onSubmit = handleSubmit((values) => {
      values.db = route.name == "adminProductEdit" ? dbData.value : undefined; // for edit product
      return axiosAsyncCallReturnData(
        route.name == "adminProductEdit" ? "PUT" : "POST",
        "stock_adjustment",
        {
          data: values,
        }
      ).then(function (data) {
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
    function clickList(product) {
      this.products.push(product);
      //
      this.autocompleteList = [];
      this.search = null;
    }
    /*var autocompleteList = [
      { id: 1, name: "aaa", label: "aaa" },
      { id: 2, name: "bbb", label: "bbb" },
      { id: 3, name: "ccc", label: "ccc" },
      { id: 4, name: "ddd", label: "ddd" },
      { id: 5, name: "eee", label: "eee" },
      { id: 6, name: "fff", label: "fff" },
    ];*/
    var autocompleteList = ref([]);
    var products = ref([]);
    function resetCustom() {
      resetForm();
    }
    return {
      autocompleteList,
      products,
      warehouses,
      warehouse,
      errorWareHouse,
      search,
      errorSearch,
      ref_no,
      errorRefNo,
      date,
      errorDate,
      note,
      onSubmit,
      isDirty,
      isSubmitting,
      resetForm,
      resetCustom,
      errorNote,
      axiosAsyncStoreReturnBool,
      axiosAsyncCallReturnData,
      clickList,
    };
  },
  data() {
    return {};
  },
  watch: {},
  methods: {},
  watch: {
    search(query) {
      var self = this;
      if (query) {
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
            if (data.data.length > 0) {
            } else {
              alert("No product found for your search query " + query + " !");
              self.search = null;
            }
            self.autocompleteList = data.data;
          } else {
            console.log(data);
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
    /*$("#search").autocomplete({
      source: this.autocompleteList,
    });*/
  },
};
</script>