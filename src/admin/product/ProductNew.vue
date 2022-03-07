<template>
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-cart-arrow-down"></i><span>New Product</span>
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
    <form
      id="newProduct"
      method="post"
      @submit="onSubmit"
      class="needs-validation"
    >
      <div class="row">
        <!-- main row -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
          <!-- column section 1 -->
          <div class="row">
            <div class="col">
              <label for="producttype" class="form-label">
                Product Type <i>*</i></label
              >
              <select
                class="form-select is-invalid"
                name="type"
                :disabled="!productTypes"
                v-model="type"
                id="producttype"
              >
                <option selected :value="null" v-if="!productTypes">
                  Loading...
                </option>
                <option selected :value="null" v-if="productTypes">
                  Select product type...
                </option>
                <option v-for="t in productTypes" :key="t.id" :value="t.id">
                  {{ t.name }}
                </option>
              </select>
              <div class="invalid-feedback">{{ errorType }}</div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Product Code <i>*</i></label
              >
              <input
                type="text"
                name="code"
                v-model="code"
                class="form-control is-invalid"
                id="productcode"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
              <div class="invalid-feedback">{{ errorCode }}</div>
            </div>
            <div class="col">
              <label for="exampleInputPassword1" class="form-label"
                >Symbology</label
              >
              <input
                type="text"
                v-model="product.symbology"
                class="form-control"
                id="exampleInputPassword1"
              />
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Product Name <i>*</i></label
              >
              <input
                type="text"
                v-model="name"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >URL Slug<i>*</i></label
              >
              <input
                type="text"
                v-model="slug"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Product Weight <i>*</i></label
              >
              <input
                type="text"
                v-model="weight"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Category <i>*</i></label
              >
              <input
                type="text"
                v-model="category"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
            <div class="col">
              <label for="exampleInputPassword1" class="form-label"
                >Sub Category</label
              >
              <input
                type="text"
                v-model="sub_category"
                class="form-control"
                id="exampleInputPassword1"
              />
            </div>
          </div>
        </div>
        <!-- column section 2 -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Brand Name</label
              >
              <input
                type="text"
                v-model="brand"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
            <div class="col">
              <label for="exampleInputPassword1" class="form-label">MRP</label>
              <input
                type="text"
                v-model="mrp"
                class="form-control"
                id="exampleInputPassword1"
              />
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Product Unit <i>*</i></label
              >
              <input
                type="text"
                v-model="unit"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
            <div class="col">
              <label for="exampleInputPassword1" class="form-label"
                >Purchase Unit</label
              >
              <input
                type="text"
                v-model="p_unit"
                class="form-control"
                id="exampleInputPassword1"
              />
            </div>
            <div class="col">
              <label for="exampleInputPassword1" class="form-label"
                >Sale Unit</label
              >
              <input
                type="text"
                v-model="s_unit"
                class="form-control"
                id="exampleInputPassword1"
              />
            </div>
          </div>
        </div>
        <!-- column section 3 -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
          <div v-for="product in productTypes" :key="product.id">
            {{ product.name }}
          </div>
        </div>
      </div>
      <div class="d-flex pt-3">
        <div class="me-auto">
          <button type="submit" class="btn btn-success">Save</button>
        </div>
        <div class="">
          <button type="reset" class="btn btn-info" v-on:clic="reset">
            Reset
          </button>
        </div>
      </div>
    </form>
  </div>
</template>
<style>
</style>
<script>
/* eslint-disable */
import { useForm, useField } from "vee-validate";
import * as yup from "yup";
import { computed } from "vue";
import { useStore } from "vuex";
import adminMixin from "@/mixins/admin.js";
export default {
  components: {},
  setup() {
    const store = useStore();
    let productTypes = computed(function () {
      return store.state.productTypes;
    });
    /**************************************** */

    const { handleSubmit } = useForm();
    const onSubmit = handleSubmit((values) => {
      console.log(values);
      //alert(JSON.stringify(values, null, 2));
    });
    const { value: type,errorMessage: errorType  } = useField(
      "type",
      yup.number().required().min(1)
    );
    const {value: code ,errorMessage: errorCode} = useField(
      "code",
      yup.string().required().min(3)
    );
    /*************************************** */
    return {
      errorType,
      errorCode,
      productTypes,
      type,
      code,
      onSubmit,
    };
  },
  mixins: [adminMixin],
  data() {
    return {
      name: null,
      slug: null,
      weight: null,
      category: null,
      sub_category: null,
      brand: null,
      mrp: null,
      unit: null,
      p_unit: null,
      s_unit: null,
      product: { type: null },
      errors: {},
    };
  },
  methods: {
    isRequired(value) {
      return value ? true : "This field is required";
    },
    reset() {
      var self = this;
      self.product = {};
    },
    onubmit() {
      var self = this;
      //let data = JSON.parse(JSON.stringify(self.product));
      var formId = document.getElementById("newProduct");
      this.axios
        .post("http://localhost/CyberLikes-POS/admin/ajax/product", {
          data: self.product,
        })
        .then(function (response) {
          formId.classList.add("was-validated");
          let data = response.data;
          if (data.success == true) {
            //
          } else if (data.success == false) {
            let errors = data.errors;
            self.errors = errors;
            for (var field in errors) {
              if (Object.prototype.hasOwnProperty.call(errors, field)) {
                console.log(field + " -> " + errors[field]);
              }
            }
            var form = document.getElementById("newProduct");
            form.classList.add("was-validated");
            self.notifyApiResponse(data);
          }
        })
        .catch((error) => {
          self.notifyCatchResponse({ message: error.message });
        });
    },
  },
  created() {},
  mounted() {
    this.addProductTypes(); // get product types
  },
};
</script>