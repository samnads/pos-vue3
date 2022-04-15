<template>
  <div
    class="modal"
    id="prodNewCategoryLevel1Modal"
    tabindex="-1"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <form id="newCategory" @submit="onSubmit" class="needs-validation">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              New Subcategory (Level 1)
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col">
                <label for="" class="form-label"
                  >Parent Category Level 0<i>*</i></label
                >
                <input
                  type="text"
                  class="form-control"
                  :value="propCategory.name"
                  v-bind:class="[
                    errorCategory
                      ? 'is-invalid'
                      : !errorCategory && category
                      ? 'is-valid'
                      : '',
                  ]"
                  disabled
                />
                <input
                  type="number"
                  name="category"
                  class="form-control d-none"
                  v-model="category"
                />
                <div class="invalid-feedback">{{ errorCategory }}</div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="" class="form-label">Name<i>*</i></label>
                <input
                  type="text"
                  name="name"
                  v-model="name"
                  class="form-control"
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
              <div class="col">
                <label for="" class="form-label">Code<i>*</i></label>
                <input
                  type="text"
                  name="code"
                  v-model="code"
                  class="form-control"
                  @input="handleChangeCode"
                  v-bind:class="[
                    errorCode
                      ? 'is-invalid'
                      : !errorCode && code
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorCode }}</div>
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
              <div class="col">
                <label for="" class="form-label">Image</label>
                <input
                  type="text"
                  name="image"
                  v-model="image"
                  class="form-control"
                  v-bind:class="[
                    errorImage
                      ? 'is-invalid'
                      : !errorImage && image
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorImage }}</div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="" class="form-label">Description</label>
                <textarea
                  rows="3"
                  type="text"
                  name="description"
                  v-model="description"
                  class="form-control"
                  v-bind:class="[
                    errorDescription
                      ? 'is-invalid'
                      : !errorDescription && description
                      ? 'is-valid'
                      : '',
                  ]"
                ></textarea>
                <div class="invalid-feedback">{{ errorDescription }}</div>
              </div>
            </div>
          </div>
          <div class="m-1 row">
            <p class="text-muted small">
              <span class="text-danger">*</span>&nbsp;Marked fields are
              mandatory.
            </p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-outline-danger me-auto"
              data-bs-dismiss="modal"
              @click="close"
            >
              <i class="fa-solid fa-stop"></i>Cancel
            </button>
            <button
              type="button"
              class="btn btn-secondary"
              @click="resetCustom"
              :disabled="isSubmitting || !isDirty"
            >
              <i class="fa-solid fa-rotate-left"></i>
            </button>
            <button
              type="submit"
              class="btn"
              :disabled="isSubmitting"
              v-bind:class="[isValid ? 'btn-success' : 'btn-secondary']"
            >
              <span v-if="!isSubmitting"><i class="fa-solid fa-save"></i></span>
              <span
                class="spinner-border spinner-border-sm"
                role="status"
                aria-hidden="true"
                v-if="isSubmitting"
              ></span>
              Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
/* eslint-disable */
import {
  useForm,
  useField,
  useIsFormDirty,
  useIsFormValid,
} from "vee-validate";
import * as yup from "yup";
import { ref, toRef, computed } from "vue";
import admin from "@/mixins/admin.js";
export default {
  props: {
    propCategory: Object,
    propHandleChangeCat: Function,
    subCatsUpdated: Function,
  },
  setup(props) {
    // data retrieve
    const {
      addCategories,
      notifyDefault,
      notifyFormError,
      notifyApiResponse,
      notifyCatchResponse,
      axiosCall,
    } = admin();
    /************************************************************************* */
    const schema = computed(() => {
      return yup.object({
        category: yup
          .number()
          .required()
          .min(1)
          .nullable(true)
          .label("Parent Category"),
        name: yup
          .string()
          .required()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("Name"),
        code: yup
          .string()
          .required()
          .min(2)
          .nullable(true)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("Code"),
        slug: yup
          .string()
          .required()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("Slug"),
        image: yup.number().min(0).max(10).nullable(true).label("Image"),
        description: yup.string().nullable(true).label("Description"),
      });
    });
    /************************************************************************* */
    const formValues = {};
    /************************************************************************* */
    const {
      setFieldValue,
      setFieldError,
      isSubmitting,
      handleSubmit,
      resetForm,
    } = useForm({
      validationSchema: schema,
      initialValues: formValues,
      initialErrors: {},
    });
    /************************************************************************* */
    const isDirty = useIsFormDirty();
    const isValid = useIsFormValid();
    /************************************************************************* */
    function onInvalidSubmit({ values, errors, results }) {
      console.log(values);
    }
    const onSubmit = handleSubmit((values, { resetForm }) => {
      return axiosCall("post", "category", {
        data: values,
      })
        .then(function (data) {
          if (data.success == true) {
            props.propHandleChangeCat();
            props.subCatsUpdated(data.id);
            resetCustom();
            window.PROD_NEW_CATEGORY_L1_MODAL.hide();
            notifyApiResponse(data);
          } else {
            if (data.errors) {
              for (var key in data.errors) {
                setFieldError(key, data.errors[key]);
              }
            }
          }
        })
        .catch(() => {});
    }, onInvalidSubmit);
    /************************************************************************* */
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
    function resetCustom() {
      // preserve
      resetForm({
        values: {
          category: category.value,
        },
      });
    }
    function close() {
      resetCustom();
      window.PROD_NEW_CATEGORY_MODAL.hide();
    }
    /************************************************************************* */
    const { value: category, errorMessage: errorCategory } =
      useField("category");
    const { value: name, errorMessage: errorName } = useField("name");
    const { value: code, errorMessage: errorCode } = useField("code");
    const { value: slug, errorMessage: errorSlug } = useField("slug");
    const { value: image, errorMessage: errorImage } = useField("image");
    const { value: description, errorMessage: errorDescription } =
      useField("description");
    /*************************************** */
    return {
      /**************** event handler */
      handleChangeName,
      handleChangeSlug,
      /******* fields   */
      category,
      errorCategory,
      name,
      errorName,
      code,
      errorCode,
      slug,
      errorSlug,
      image,
      errorImage,
      description,
      errorDescription,
      /*************** */
      isDirty,
      isValid,
      onSubmit,
      isSubmitting,
      resetForm,
      resetCustom,
      close,
      /******************/
      addCategories,
    };
  },
  data() {
    return {};
  },
  watch: {
    propCategory(value, oldValue) {
      value.id ? (this.category = value.id) : undefined;
    },
  },
  methods: {},
  created() {},
  mounted() {},
};
</script>