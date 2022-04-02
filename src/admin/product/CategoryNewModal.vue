<template>
  <div class="modal" id="prodNewCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <form id="newCategory" @submit="onSubmit" class="needs-validation">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New Category</h5>
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
            >
              <i class="fa-solid fa-stop"></i>Cancel
            </button>
            <button type="button" class="btn btn-light" v-show="isDirty" @click="resetForm">
             <i class="fa-solid fa-rotate-left"></i>
            </button>
            <button type="submit" class="btn btn-secondary" :disable="!isValid">
              <i class="fa-solid fa-save"></i>Save
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
  setup() {
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
    const formValues = {};
    /************************************************************************* */
    const schema = computed(() => {
      return yup.object({
        name: yup
          .string()
          .required()
          .min(3)
          .max(100)
          .nullable(true)
          .label("Name"),
        code: yup.string().required().min(2).nullable(true).label("Code"),
        slug: yup
          .string()
          .required()
          .min(3)
          .max(100)
          .nullable(true)
          .label("Slug"),
        image: yup.number().min(0).max(10).nullable(true).label("Image"),
        description: yup.string().nullable(true).label("Description"),
      });
    });
    /************************************************************************* */
    const { setFieldValue, setFieldError, handleSubmit, resetForm } = useForm({
      validationSchema: schema,
      initialValues: formValues,
      initialErrors: {},
    });
    /************************************************************************* */
    const isDirty = useIsFormDirty();
    const isValid = useIsFormValid();
    /************************************************************************* */
    function onInvalidSubmit({ values, errors, results }) {
      console.log(errors);
    }
    const onSubmit = handleSubmit((values, { resetForm }) => {
      console.log(values);
      axiosCall("post", "category", {
        data: values,
      }).then(function (data) {
        if (data.success == true) {
          addCategories();
          resetForm();
           window.PROD_NEW_CATEGORY_MODAL.hide();
          notifyApiResponse(data);
        } else {
          if (data.errors) {
            for (var key in data.errors) {
              setFieldError(key, data.errors[key]);
            }
          }
        }
      });
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
    /************************************************************************* */
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
      resetForm,
      /******************/
      addCategories,
    };
  },
  data() {
    return {};
  },
  methods: {
    test() {
      alert();
    },
  },
  created() {},
  mounted() {},
};
</script>