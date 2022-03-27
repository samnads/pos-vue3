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
import admin from "@/mixins/admin.js";
export default {
  setup() {
    // data retrieve
    const {
      notifyDefault,
      notifyFormError,
      notifyApiResponse,
      notifyCatchResponse,
      axiosCall,
    } = admin();
    /**************************************** */
    // Defaule values
    const { setFieldValue, setValues, handleSubmit, resetForm } = useForm();
    // Initial values
    setValues({
      code: "MC-",
    });
    const isDirty = useIsFormDirty();
    const isValid = useIsFormValid();
    function onInvalidSubmit({ values, errors, results }) {
      console.log(errors);
      //setFieldValue("name", "test");
    }
    const onSubmit = handleSubmit((values) => {
      console.log(values);
      axiosCall("post", "category", {
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

    const { value: name, errorMessage: errorName } = useField(
      "name",
      yup.string().required().min(3).max(100).nullable(true)
    );
    const { value: code, errorMessage: errorCode } = useField(
      "code",
      yup.string().required().min(2).nullable(true).label("Code")
    );
    const { value: slug, errorMessage: errorSlug } = useField(
      "slug",
      yup.string().required().min(3).max(100).nullable(true)
    );
    const { value: image, errorMessage: errorImage } = useField(
      "image",
      yup.number().min(0).max(10).nullable(true)
    );
    const { value: description, errorMessage: errorDescription } = useField(
      "description",
      yup.string().nullable(true)
    );
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