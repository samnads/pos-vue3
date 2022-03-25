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
                <option selected :value="defType" v-if="!productTypes">
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
                <span
                  class="input-group-text text-info"
                  role="button"
                  @click="genRandCode"
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
                <option selected :value="defSymbology" v-if="!symbologies">
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
                @input="handleChangeName"
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
                @change="handleChangeSlug"
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
              <label for="exampleInputPassword1" class="form-label"
                >Category<i>*</i></label
              >
              <div class="input-group">
                <select
                  class="form-select"
                  name="category"
                  :disabled="!categories"
                  v-model="category"
                  @input="handleChangeCat"
                  v-bind:class="[
                    errorCategory
                      ? 'is-invalid'
                      : !errorCategory && category
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option selected :value="defCategory" v-if="!categories">
                    Loading...
                  </option>
                  <option selected :value="null" v-if="categories">
                    -- Select ({{ categories.length }}) --
                  </option>
                  <option v-for="c in categories" :key="c.id" :value="c.id">
                    {{ c.name }}
                  </option>
                </select>
                <span
                  class="input-group-text text-info"
                  role="button"
                  @click="newCategory"
                  ><i class="fa-solid fa-plus"></i
                ></span>
              </div>
              <div class="invalid-feedback">{{ errorCategory }}</div>
            </div>
            <div class="col">
              <label for="exampleInputPassword1" class="form-label"
                >Sub Category</label
              >
              <select
                class="form-select"
                name="sub_category"
                :disabled="
                  !categories || !category || !subCats || subCats.length == 0
                "
                v-model="sub_category"
              >
                <option selected :value="null">
                  {{
                    !categories
                      ? "Loading..."
                      : !category
                      ? "Select category first"
                      : !subCats
                      ? "Loading..."
                      : subCats.length == 0
                      ? "No sub category found"
                      : "-- Select (" + subCats.length + ") --"
                  }}
                </option>
                <option v-for="sc in subCats" :key="sc.id" :value="sc.id">
                  {{ sc.name }}
                </option>
              </select>
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
          <button
            type="button"
            class="btn btn-info"
            :disabled="!isDirty"
            @click="resetForm()"
          >
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
import {
  useForm,
  useField,
  useIsFormDirty,
  useIsFormValid,
  configure,
} from "vee-validate";
import * as yup from "yup";
import { ref, computed } from "vue";
import { useStore } from "vuex";
//import adminMixin from "@/mixins/admin.js";
import admin from "@/mixins/admin.js";
import adminProduct from "@/mixins/adminProduct.js";
export default {
  components: {},
  props: {},
  setup() {
    const { randCode } = adminProduct();
    const {
      addProductTypes,
      addSymbologies,
      addCategories,
      notifyDefault,
      notifyFormError,
      notifyApiResponse,
      notifyCatchResponse,
      axiosCall,
      adminTest,
    } = admin();
    // from store
    const store = useStore();
    let productTypes = computed(function () {
      return store.state.productTypes;
    });
    let symbologies = computed(function () {
      return store.state.symbologies;
    });
    let categories = computed(function () {
      return store.state.categories;
    });
    /**************************************** */
    // Defaule values
    var defType = null;
    var defSymbology = 1;
    var defCategory = 1;
    var subCats = ref(0);
    const { setFieldValue, setValues, handleSubmit, resetForm } = useForm();
    // Initial values
    setValues({
      type: defType,
      symbology: defSymbology,
      category: defCategory,
      sub_category: null,
    });
    const isDirty = useIsFormDirty();
    const isValid = useIsFormValid();
    function onInvalidSubmit({ values, errors, results }) {
      console.log(errors);
      //setFieldValue("name", "test");
    }
    function genRandCode() {
      setFieldValue("code", randCode());
    }
    function newCategory() {
      window.PROD_NEW_CATEGORY_MODAL.show();
    }
    const onSubmit = handleSubmit((values) => {
      axiosCall("post", "product", {
        data: values,
      }).then(function (data) {
        console.log(data.errors);
      });
    }, onInvalidSubmit);

    const { handleChangeName } = useField("name", function (value) {
      if (value) {
        setFieldValue("slug", value.trim().replace(/\s+/g, "-").toLowerCase());
        return true;
      } else {
        return "Required !";
      }
    });
    const { handleChangeSlug } = useField("slug", function (value) {
      if (value) {
        setFieldValue("slug", value.trim().replace(/\s+/g, "-").toLowerCase());
        return true;
      } else {
        return "Required !";
      }
    });

    const { handleChangeCat } = useField("category", function (value) {
      if (value) {
        subCats.value = undefined;
        sub_category.value = null;
        axiosCall("get", "category", {
          action: "subcats",
          id: value,
        }).then(function (response) {
          subCats.value = response.data;
        });
        return true;
      } else {
        subCats.value = undefined;
        sub_category.value = null;
        return "Required !";
      }
    });

    const { value: type, errorMessage: errorType } = useField(
      "type",
      yup.number().required().min(1).nullable(false)
    );
    const { value: code, errorMessage: errorCode } = useField(
      "code",
      yup.string().required().min(3).nullable(false)
    );
    const { value: symbology, errorMessage: errorSymbology } = useField(
      "symbology",
      yup.number().required().min(1).nullable(false)
    );
    const { value: name, errorMessage: errorName } = useField(
      "name",
      yup.string().required().min(3).max(100).nullable(false)
    );
    const { value: slug, errorMessage: errorSlug } = useField(
      "slug",
      yup.string().required().min(3).max(100).nullable(false)
    );
    const { value: weight, errorMessage: errorWeight } = useField(
      "weight",
      yup.number().min(0).max(10).nullable(false)
    );
    const { value: category, errorMessage: errorCategory } = useField(
      "category",
      yup.number().required().nullable(false)
    );
    const { value: sub_category, errorMessage: errorSubCategory } = useField(
      "sub_category",
      yup.number().nullable(false)
    );
    /*************************************** */
    return {
      /**************** default form sel values */
      defCategory,
      defSymbology,
      defType,
      /**************** event handler */
      genRandCode,
      newCategory,
      handleChangeName,
      handleChangeSlug,
      handleChangeCat,
      /************** db */
      productTypes,
      symbologies,
      categories,
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
      category,
      errorCategory,
      sub_category,
      errorSubCategory,
      /*************** */
      isDirty,
      isValid,
      onSubmit,
      resetForm,
      subCats,
      /******************/
      addProductTypes,
      addSymbologies,
      addCategories,
    };
  },
  mixins: [],
  data() {
    return {
      brand: null,
      mrp: null,
      unit: null,
      p_unit: null,
      s_unit: null,
      errors: {},
    };
  },
  methods: {
    test() {
      alert();
    },
  },
  created() {},
  mounted() {
    this.addProductTypes(); // get product types
    this.addSymbologies(); // get symbologies
    this.addCategories(); // get categories
  },
};
</script>