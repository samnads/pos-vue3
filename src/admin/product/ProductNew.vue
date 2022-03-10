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
    <form id="newProduct" @submit="onSubmit" class="needs-validation">
      <div class="row">
        <!-- main row -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
          <!-- column section 1 -->
          <div class="row mb-1">
            <div class="col">
              <label for="producttype" class="form-label">
                Product Type<i>*</i></label
              >
              <select
                class="form-select"
                name="type"
                :disabled="!productTypes"
                v-model="type"
                id="producttype"
                v-bind:class="[
                  errorType
                    ? 'is-invalid'
                    : !errorType && type
                    ? 'is-valid'
                    : '',
                ]"
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
                >Product Code<i>*</i></label
              >
              <div class="input-group has-validation">
                <input
                  type="text"
                  name="code"
                  v-model="code"
                  class="form-control"
                  id="productcode"
                  v-bind:class="[
                    errorCode
                      ? 'is-invalid'
                      : !errorCode && code
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <span class="input-group-text text-info" role="button"
                  ><i class="fa-solid fa-shuffle"></i
                ></span>
                <div class="invalid-feedback">{{ errorCode }}</div>
              </div>
            </div>
            <div class="col">
              <label for="exampleInputPassword1" class="form-label"
                >Symbology<i>*</i></label
              >
              <select
                class="form-select"
                name="symbology"
                :disabled="!symbologies"
                v-model="symbology"
                id="productsymbology"
                v-bind:class="[
                  errorSymbology
                    ? 'is-invalid'
                    : !errorSymbology && symbology
                    ? 'is-valid'
                    : '',
                ]"
              >
                <option selected :value="1" v-if="!symbologies">
                  Loading...
                </option>
                <option selected :value="null" v-if="symbologies">
                  -- Select symbology --
                </option>
                <option v-for="s in symbologies" :key="s.id" :value="s.id">
                  {{ s.code }}
                </option>
              </select>
              <div class="invalid-feedback">{{ errorSymbology }}</div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="" class="form-label">Product Name<i>*</i></label>
              <input
                type="text"
                name="name"
                v-model="name"
                class="form-control"
                id="productname"
                v-bind:class="[
                  errorName
                    ? 'is-invalid'
                    : !errorName && name
                    ? 'is-valid'
                    : '',
                ]"
              />
              <div class="invalid-feedback">{{ errorName }}</div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="" class="form-label">URL Slug<i>*</i></label>
              <input
                type="text"
                name="slug"
                v-model="slug"
                class="form-control"
                v-bind:class="[
                  errorSlug
                    ? 'is-invalid'
                    : !errorSlug && slug
                    ? 'is-valid'
                    : '',
                ]"
              />
              <div class="invalid-feedback">{{ errorSlug }}</div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="" class="form-label">Weight</label>
              <input
                type="text"
                name="weight"
                v-model="weight"
                class="form-control"
                v-bind:class="[
                  errorWeight
                    ? 'is-invalid'
                    : !errorWeight && weight
                    ? 'is-valid'
                    : '',
                ]"
              />
              <div class="invalid-feedback">{{ errorWeight }}</div>
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
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4">Col 3</div>
      </div>
      <div class="d-flex pt-3">
        <div class="me-auto">
          <button type="submit" class="btn btn-success" :disable="!isValid">
            Save
          </button>
        </div>
        <div class="">
          <button type="reset" class="btn btn-info" :disable="!isDirty">
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
import axios from "axios";
import {
  useForm,
  useField,
  useIsFormDirty,
  useIsFormValid,
  configure,
} from "vee-validate";
import * as yup from "yup";
import {  computed } from "vue";
import { useStore } from "vuex";
//import adminMixin from "@/mixins/admin.js";
import useCounter from "@/mixins/useCounter.js";
export default {
  components: {},
  props: {},
  setup() {
    // data retrieve
    const { addProductTypes, addSymbologies } = useCounter();
    // notify
    const { notifyDefault, notifyApiResponse, notifyCatchResponse } = useCounter();
    // from store
    const store = useStore();
    let productTypes = computed(function () {
      return store.state.productTypes;
    });
    let symbologies = computed(function () {
      return store.state.symbologies;
    });
    /**************************************** */
    configure({
      validateOnBlur: true, // controls if `blur` events should trigger validation with `handleChange` handler
      validateOnChange: true, // controls if `change` events should trigger validation with `handleChange` handler
      validateOnInput: false, // controls if `input` events should trigger validation with `handleChange` handler
      validateOnModelUpdate: true, // controls if `update:modelValue` events should trigger validation with `handleChange` handler
    });
    // Initial values
    const formValues = {
      type: null,
      symbology: 1,
    };
    const { handleSubmit } = useForm({
      initialValues: formValues,
    });
    const isDirty = useIsFormDirty();
    const isValid = useIsFormValid();
    function onInvalidSubmit({ values, errors, results }) {
      notifyDefault({ message: "Form have error !" ,type:"danger"});
    }
    const onSubmit = handleSubmit((values) => {
      console.log(values);
      axios
        .post("http://localhost/CyberLikes-POS/admin/ajax/product", {
          data: values,
        })
        .then(function (response) {
          let data = response.data;
          console.log(data);
          if (data.success == false) {
            if (data.location) {
            } else if (data.errors) {
            }
          }
        })
        .catch((error) => {});
    }, onInvalidSubmit);
    const { value: type, errorMessage: errorType } = useField(
      "type",
      yup.number().required().min(1).nullable(true)
    );
    const { value: code, errorMessage: errorCode } = useField(
      "code",
      yup.string().required().min(3).nullable(true)
    );
    const { value: symbology, errorMessage: errorSymbology } = useField(
      "symbology",
      yup.number().required().min(1).nullable(true)
    );
    const { value: name, errorMessage: errorName } = useField(
      "name",
      yup.string().required().min(3).max(10).nullable(true)
    );
    const { value: slug, errorMessage: errorSlug } = useField(
      "slug",
      yup.string().required().min(3).max(10).nullable(true)
    );
    const { value: weight, errorMessage: errorWeight } = useField(
      "weight",
      yup.number().typeError("Invalid input!").min(0).max(10).nullable(true)
    );
    /*************************************** */
    return {
      /************** db */
      productTypes,
      symbologies,
      /******* fields   */
      type,
      errorType,
      code,
      errorCode,
      symbology,
      errorSymbology,
      name,
      errorName,
      slug,
      errorSlug,
      weight,
      errorWeight,
      /*************** */
      isDirty,
      isValid,
      onSubmit,
      /******************/
      addProductTypes,
      addSymbologies,
    };
  },
  mixins: [],
  data() {
    return {
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
  },
  created() {},
  mounted() {
    this.addProductTypes(); // get product types
    this.addSymbologies(); // get symbologies
  },
};
</script>