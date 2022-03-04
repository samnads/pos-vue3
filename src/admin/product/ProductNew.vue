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
    <Form id="newProduct" @submit="onSubmit">
      <div class="row">
        <!-- main row -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
          <!-- column section 1 -->
          <div class="row">
            <div class="col">
              <label for="producttype" class="form-label">
                Product Type <i>*</i></label
              >
              <Field class="form-select" as="select" name="type" :disabled="!productTypes" v-model="product.type" id="producttype">
                <option value="" v-if="!productTypes">Loading...</option>
                <option  value="" selected v-if="productTypes">Select...</option>
                <option v-for="type in productTypes" :key="type.id" :value="type.id">
                  {{ type.name }}
                </option>
              </Field>
              <div class="invalid-feedback" v-if="errors.type">
                {{ errors.type }}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Product Code <i>*</i></label
              >
              <input
                type="text"
                v-model="product.code"
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
                v-model="product.name"
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
                v-model="product.slug"
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
                v-model="product.weight"
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
                v-model="product.category"
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
                v-model="product.sub_category"
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
                v-model="product.brand"
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
                v-model="product.mrp"
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
                v-model="product.unit"
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
                v-model="product.p_unit"
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
                v-model="product.s_unit"
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
    </Form>
  </div>
</template>
<style>
</style>
<script>
import { Field, Form } from "vee-validate";
import { computed } from "vue";
import { useStore } from "vuex";
import adminMixin from "@/mixins/admin.js";
export default {
  components: {
    Field,
    Form,
  },
  setup() {
    const store = useStore();

    let productTypes = computed(function () {
      return store.state.productTypes;
    });

    let products = computed(function () {
      return store.state.products;
    });

    let cart = computed(function () {
      return store.state.cart;
    });

    return {
      productTypes,
      products,
      cart,
    };
  },
  mixins: [adminMixin],
  data() {
    return {
      product: {},
      errors: {},
    };
  },
  methods: {
    onSubmit(values) {
      console.log(values);
    },
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