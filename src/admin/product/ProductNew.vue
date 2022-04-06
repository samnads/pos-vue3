<template>
  <AdminProductNewCategoryModal />
  <AdminProductNewCategoryL1Modal
    v-bind:propHandleChangeCat="handleChangeCat"
    v-bind:subCatsUpdated="subCatsUpdated"
    :propCategory="
      categories && category
        ? categories.find((obj) => {
            return obj.id === category;
          })
        : []
    "
  />
  <AdminProductNewBrandModal v-bind:propUpdateBrands="loadBrands" />
  <AdminProductNewUnitModal v-bind:propUpdateUnits="loadUnits" />
  <AdminProductNewUnitBulkModal
    v-bind:propUpdateUnitsBulk="loadUnitsBulk"
    :propTest="unit"
    :propUnit="
      units && unit
        ? units.find((obj) => {
            return obj.id === unit;
          })
        : []
    "
  />

  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-cart-arrow-down"></i
          ><span>New Product{{ greetingMessage }}</span>
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
                <option selected :value="formValues.type" v-if="!productTypes">
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
                <span class="input-group-text"
                  ><i class="fa-solid fa-barcode"></i
                ></span>
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
                  class="input-group-text text-primary"
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
                <option
                  selected
                  :value="formValues.symbology"
                  v-if="!symbologies"
                >
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
                @input="handleChangeSlug"
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
                type="number"
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
              <label for="" class="form-label">Category<i>*</i></label>
              <div class="input-group is-invalid">
                <select
                  class="form-select"
                  name="category"
                  :disabled="!categories"
                  v-model="category"
                  v-bind:class="[
                    errorCategory
                      ? 'is-invalid'
                      : !errorCategory && category
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option
                    selected
                    :value="formValues.category"
                    v-if="!categories"
                  >
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
                  class="input-group-text text-primary"
                  role="button"
                  @click="newCategory"
                  ><i class="fa-solid fa-plus"></i
                ></span>
              </div>
              <div class="invalid-feedback">{{ errorCategory }}</div>
            </div>
            <div class="col">
              <label class="form-label">Sub Category - Level 1</label>
              <div class="input-group">
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
                <button
                  type="button"
                  v-if="category"
                  class="input-group-text text-primary"
                  @click="newCategoryL1"
                  :disabled="!category"
                >
                  <i class="fa-solid fa-plus"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- column section 2 -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-4">
          <div class="row mb-1">
            <div class="col">
              <label for="" class="form-label">Brand Name</label>
              <div class="input-group is-invalid">
                <select
                  class="form-select"
                  name="brand"
                  :disabled="!brands"
                  v-model="brand"
                  v-bind:class="[
                    errorBrand
                      ? 'is-invalid'
                      : !errorBrand && brand
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option selected :value="formValues.brand" v-if="!brands">
                    Loading...
                  </option>
                  <option selected :value="null" v-if="brands">
                    -- Select ({{ brands.length }}) --
                  </option>
                  <option v-for="b in brands" :key="b.id" :value="b.id">
                    {{ b.name }}
                  </option>
                </select>
                <span
                  class="input-group-text text-info"
                  role="button"
                  @click="newBrand"
                  ><i class="fa-solid fa-plus"></i
                ></span>
              </div>
              <div class="invalid-feedback">{{ errorBrand }}</div>
            </div>
            <div class="col">
              <label class="form-label">MRP</label>
              <div class="input-group is-invalid">
                <span class="input-group-text">₹</span>
                <input
                  type="number"
                  name="mrp"
                  placeholder="Maximum retail price"
                  v-model="mrp"
                  class="form-control"
                  id="productcode"
                  v-bind:class="[
                    errorMrp
                      ? 'is-invalid'
                      : !errorMrp && mrp
                      ? 'is-valid'
                      : '',
                  ]"
                />
              </div>
              <div class="invalid-feedback">{{ errorMrp }}</div>
            </div>
          </div>
          <div class="row mb-1">
            <div class="col">
              <label for="" class="form-label">Product Unit<i>*</i></label>
              <div class="input-group is-invalid">
                <select
                  class="form-select"
                  name="unit"
                  :disabled="!units"
                  v-model="unit"
                  v-bind:class="[
                    errorUnit
                      ? 'is-invalid'
                      : !errorUnit && unit
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option selected :value="formValues.unit" v-if="!units">
                    Loading...
                  </option>
                  <option selected :value="null" v-if="units">
                    -- Select ({{ units.length }}) --
                  </option>
                  <option v-for="u in units" :key="u.id" :value="u.id">
                    {{ u.name }}
                  </option>
                </select>
                <span
                  class="input-group-text text-info"
                  role="button"
                  @click="newUnit"
                  ><i class="fa-solid fa-plus"></i
                ></span>
              </div>
              <div class="invalid-feedback">{{ errorUnit }}</div>
            </div>
            <div class="col">
              <label for="" class="form-label">Purchase Unit</label>
              <div class="input-group is-invalid">
                <select
                  class="form-select"
                  name="p_unit"
                  :disabled="!unitsBulk || !unit"
                  v-model="p_unit"
                  v-bind:class="[
                    errorPUnit
                      ? 'is-invalid'
                      : !errorPUnit && p_unit
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option selected :value="formValues.p_unit" v-if="!unitsBulk">
                    Loading...
                  </option>
                  <option selected :value="null" v-if="unitsBulk">
                    {{
                      unit
                        ? units.find((obj) => {
                            return obj.id === unit;
                          })["name"]
                        : "Select base unit first"
                    }}
                  </option>
                  <option v-for="u in unitsBulk" :key="u.id" :value="u.id">
                    {{ u.name }}
                  </option>
                </select>
                <button
                  class="input-group-text text-info"
                  type="button"
                  @click="newUnitBulk"
                  v-if="unitsBulk && unit"
                >
                  <i class="fa-solid fa-plus"></i>
                </button>
              </div>
              <div class="invalid-feedback">{{ errorPUnit }}</div>
            </div>
            <div class="col">
              <label for="" class="form-label">Sale Unit</label>
              <div class="input-group is-invalid">
                <select
                  class="form-select"
                  name="s_unit"
                  :disabled="!unitsBulk || !unit"
                  v-model="s_unit"
                  v-bind:class="[
                    errorSUnit
                      ? 'is-invalid'
                      : !errorSUnit && s_unit
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option selected :value="formValues.s_unit" v-if="!unitsBulk">
                    Loading...
                  </option>
                  <option selected :value="null" v-if="unitsBulk">
                    {{
                      unit
                        ? units.find((obj) => {
                            return obj.id === unit;
                          })["name"]
                        : "Select base unit first"
                    }}
                  </option>
                  <option v-for="u in unitsBulk" :key="u.id" :value="u.id">
                    {{ u.name }}
                  </option>
                </select>
                <button
                  class="input-group-text text-info"
                  type="button"
                  @click="newUnitBulk"
                  v-if="unitsBulk && unit"
                >
                  <i class="fa-solid fa-plus"></i>
                </button>
              </div>
              <div class="invalid-feedback">{{ errorSUnit }}</div>
            </div>
          </div>
          <div class="row mb-1">
            <div class="col">
              <label class="form-label">Stock Alert Quantity<i>*</i></label>
              <div class="input-group is-invalid">
                <div
                  class="input-group-text"
                  role="button"
                  @click="toggleAlert"
                >
                  <input
                    class="form-check-input mt-0"
                    type="checkbox"
                    name="isalert"
                    v-model="isalert"
                  />
                </div>
                <span class="form-control" v-if="!isalert">{{
                  isalert ? "Enabled ✅" : "Disabled ❌"
                }}</span>
                <input
                  type="number"
                  name="alert_quantity"
                  v-model="alert_quantity"
                  class="form-control"
                  v-bind:class="[
                    errorAlertQuantity
                      ? 'is-invalid'
                      : !errorAlertQuantity && alert_quantity
                      ? 'is-valid'
                      : '',
                  ]"
                  v-if="isalert"
                />
              </div>
              <div class="invalid-feedback">{{ errorIsalert }}</div>
              <div class="invalid-feedback">{{ errorAlertQuantity }}</div>
            </div>
            <div class="col">
              <label class="form-label">Product Image</label>
              <div class="input-group">
                <input
                  type="file"
                  class="form-control"
                  id="inputGroupFile04"
                  aria-describedby="inputGroupFileAddon04"
                  aria-label="Upload"
                />
              </div>
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
            class="btn btn-secondary"
            v-if="isDirty"
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
</style>
<script>
import AdminProductNewCategoryModal from "./CategoryNewModal.vue";
import AdminProductNewCategoryL1Modal from "./CategoryLevel1NewModal.vue";
import AdminProductNewBrandModal from "./BrandNewModal.vue";
import AdminProductNewUnitModal from "./UnitNewModal.vue";
import AdminProductNewUnitBulkModal from "./UnitBulkNewModal.vue";
import { Modal } from "bootstrap";
/* eslint-disable */
import {
  useForm,
  useField,
  useIsFormDirty,
  useIsFormValid,
} from "vee-validate";
import * as yup from "yup";
import { ref, toRef, computed } from "vue";
import { useStore } from "vuex";
//import adminMixin from "@/mixins/admin.js";
import admin from "@/mixins/admin.js";
import adminProduct from "@/mixins/adminProduct.js";
export default {
  props: {
    greetingMessage: String,
  },
  components: {
    AdminProductNewCategoryModal,
    AdminProductNewCategoryL1Modal,
    AdminProductNewBrandModal,
    AdminProductNewUnitModal,
    AdminProductNewUnitBulkModal,
  },
  setup(props) {
    const { randCode } = adminProduct();
    const {
      addProductTypes,
      addSymbologies,
      addCategories,
      addBrands,
      addUnits,
      addUnitsBulk,
      notifyDefault,
      notifyFormError,
      notifyApiResponse,
      notifyCatchResponse,
      axiosCall,
      adminTest,
    } = admin();

    /**************************************** */ // from store
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
    let brands = computed(function () {
      return store.state.brands;
    });
    let units = computed(function () {
      return store.state.units;
    });
    let unitsBulk = computed(function () {
      return store.state.units_bulk;
    });
    /**************************************** */ // Default values
    var subCats = ref(0);
    /************************************************************************* */
    const formValues = {
      type: 1,
      symbology: 1,
      category: 1,
      sub_category: null,
      brand: null,
      unit: 1,
      p_unit: null,
      s_unit: null,
      isalert: true,
      alert_quantity: 10,
    };
    /************************************************************************* */
    const schema = computed(() => {
      return yup.object({
        type: yup
          .number()
          .required()
          .min(1)
          .nullable(true)
          .label("Product Type"),
        code: yup
          .string()
          .required()
          .min(3)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("Product Code"),
        symbology: yup
          .number()
          .required()
          .min(1)
          .nullable(true)
          .label("Barcode Symbology"),
        name: yup
          .string()
          .required()
          .min(3)
          .max(100)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("Product Name"),
        slug: yup
          .string()
          .required()
          .min(3)
          .max(100)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("URL Slug"),
        weight: yup
          .number()
          .min(0)
          .max(10)
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Product Weight"),
        category: yup
          .number()
          .required()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Category"),
        sub_category: yup.number().nullable(true).label("Subcategory"),
        brand: yup.number().nullable(true).label("Brand Name"),
        mrp: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("MRP"),
        unit: yup
          .number()
          .required()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Unit"),
        p_unit: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Purchase Unit"),
        s_unit: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Sale Unit"),
        alert_quantity: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .when("isalert", {
            is: true,
            then: yup
              .number()
              .nullable(true)
              .transform((_, val) => (val === Number(val) ? val : null))
              .required(),
          })
          .label("Alert Quantity"),
      });
    });
    /************************************************************************* */
    const { setFieldValue, handleSubmit, resetForm } = useForm({
      validationSchema: schema,
      initialValues: formValues,
      initialErrors: {},
    });
    /************************************************************************* */
    const { value: type, errorMessage: errorType } = useField("type");
    const { value: code, errorMessage: errorCode } = useField("code");
    const { value: symbology, errorMessage: errorSymbology } =
      useField("symbology");
    const {
      errorMessage: errorName,
      value: name,
      meta: metaName,
    } = useField("name");
    const { value: slug, errorMessage: errorSlug } = useField("slug");
    const { value: weight, errorMessage: errorWeight } = useField("weight");
    const {
      value: category,
      errorMessage: errorCategory,
      resetField,
    } = useField("category");
    const { value: sub_category, errorMessage: errorSubCategory } =
      useField("sub_category");
    const { value: brand, errorMessage: errorBrand } = useField("brand");
    const { value: mrp, errorMessage: errorMrp } = useField("mrp");
    const { value: unit, errorMessage: errorUnit } = useField("unit");
    const { value: p_unit, errorMessage: errorPUnit } = useField("p_unit");
    const { value: s_unit, errorMessage: errorSUnit } = useField("s_unit");
    const { value: isalert, errorMessage: errorIsalert } = useField("isalert");
    const { value: alert_quantity, errorMessage: errorAlertQuantity } =
      useField("alert_quantity");
    /************************************************************************* */
    const isDirty = useIsFormDirty();
    const isValid = useIsFormValid();
    /************************************************************************* */
    function onInvalidSubmit({ values, errors, results }) {
      console.log("Frontend Errors Found !");
      console.log(values);
    }
    const onSubmit = handleSubmit((values) => {
      axiosCall("post", "product", {
        data: values,
      }).then(function (data) {
        if (data.success == true) {
          console.log("Everything OK !");
        } else {
          console.log("Error Found from CI !");
          console.log(data.errors);
        }
      });
    }, onInvalidSubmit);
    /************************************************************************* */
    function genRandCode() {
      setFieldValue("code", randCode());
    }
    function newCategory() {
      window.PROD_NEW_CATEGORY_MODAL.show();
    }
    function newCategoryL1() {
      window.PROD_NEW_CATEGORY_L1_MODAL.show();
    }
    function newBrand() {
      window.PROD_NEW_BRAND_MODAL.show();
    }
    function newUnit() {
      window.PROD_NEW_UNIT_MODAL.show();
    }
    function newUnitBulk() {
      window.PROD_NEW_UNIT_BULK_MODAL.show();
    }
    function toggleAlert() {
      if (!isalert.value) {
        alert_quantity.value = 10;
        isalert.value = true;
      } else {
        alert_quantity.value = null;
        isalert.value = false;
      }
    }
    function handleChangeName() {
      if (name.value) {
        setFieldValue(
          "slug",
          name.value.trim().replace(/\s+/g, "-").toLowerCase()
        );
      }
    }
    function handleChangeSlug() {
      if (slug.value) {
        setFieldValue(
          "slug",
          slug.value.trim().replace(/\s+/g, "-").toLowerCase()
        );
      }
    }
    function handleChangeCat() {
      var id = category.value;
      if (id) {
        subCats.value = undefined;
        sub_category.value = null;
        axiosCall("get", "category", {
          action: "subcats",
          id: id,
        }).then(function (response) {
          subCats.value = response.data;
        });
      } else {
        subCats.value = undefined;
        sub_category.value = null;
      }
    }
    function resetCustom() {
      resetForm();
    }
    return {
      /**************** default form sel values */
      formValues,
      /**************** event handler */
      genRandCode,
      // modals
      newCategory,
      newCategoryL1,
      newBrand,
      newUnit,
      newUnitBulk,
      toggleAlert,
      //
      handleChangeName,
      handleChangeSlug,
      handleChangeCat,
      /************** db */
      productTypes,
      symbologies,
      categories,
      brands,
      units,
      unitsBulk,
      /******* fields   */
      type,
      errorType,
      code,
      errorCode,
      symbology,
      errorSymbology,
      name,
      metaName,
      errorName,
      slug,
      errorSlug,
      weight,
      errorWeight,
      category,
      errorCategory,
      sub_category,
      errorSubCategory,
      brand,
      errorBrand,
      mrp,
      errorMrp,
      unit,
      errorUnit,
      p_unit,
      errorPUnit,
      s_unit,
      errorSUnit,
      isalert,
      errorIsalert,
      alert_quantity,
      errorAlertQuantity,
      /*************** */
      isDirty,
      isValid,
      onSubmit,
      resetForm,
      resetCustom,
      subCats,
      isalert,
      /******************/
      addProductTypes,
      addSymbologies,
      addCategories,
      addBrands,
      addUnits,
      addUnitsBulk,
    };
  },
  mixins: [],
  data() {
    return {};
  },
  watch: {
    category(value, oldValue) {
      this.handleChangeCat();
    },
    unit(value, oldValue) {
      this.p_unit = this.s_unit = null;
      if (value) this.addUnitsBulk(value);
    },
  },
  methods: {
    subCatsUpdated: function (id) {
      this.sub_category = id;
    },
    loadBrands: function (id) {
      this.addBrands();
      this.brand = id;
    },
    loadUnits: function (id) {
      this.addUnits();
      this.unit = id;
    },
    loadUnitsBulk: function (id) {
      //
    },
  },
  created() {},
  mounted() {
    if (!this.productTypes) {
      // if not found on store
      this.addProductTypes(); // get product types
    }
    if (!this.symbologies) {
      // if not found on store
      this.addSymbologies(); // get symbologies
    }
    if (!this.categories) {
      // if not found on store
      this.addCategories(); // get categories
    }
    if (!this.brands) {
      // if not found on store
      this.addBrands(); // get brands
    }
    if (!this.units) {
      // if not found on store
      this.addUnits(); // get units
    }
    this.addUnitsBulk(1);
    this.handleChangeCat();
    //
    window.PROD_NEW_CATEGORY_MODAL = new Modal($("#prodNewCategoryModal"), {
      backdrop: true,
      show: true,
    });
    window.PROD_NEW_CATEGORY_L1_MODAL = new Modal(
      $("#prodNewCategoryLevel1Modal"),
      {
        backdrop: true,
        show: true,
      }
    );
    window.PROD_NEW_BRAND_MODAL = new Modal($("#prodNewBrandModal"), {
      backdrop: true,
      show: true,
    });
    window.PROD_NEW_UNIT_MODAL = new Modal($("#prodNewUnitModal"), {
      backdrop: true,
      show: true,
    });
    window.PROD_NEW_UNIT_BULK_MODAL = new Modal($("#prodNewUnitBulkModal"), {
      backdrop: true,
      show: true,
    });
  },
};
</script>