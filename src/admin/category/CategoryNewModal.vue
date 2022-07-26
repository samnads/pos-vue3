<template>
  <div class="modal" id="categoryNewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <form @submit="onSubmit" class="needs-validation">
          <div
            class="modal-header"
            :class="DATA.type ? 'bg-' + DATA.type : 'bg-primary'"
          >
            <!-- NEW -->
            <h5 class="modal-title" v-if="!DATA.db">
              <span><i class="fa-solid fa-plus"></i></span>{{ DATA.title
              }}<span v-if="DATA.data">
                of
                <span class="badge bg-light text-dark">{{
                  DATA.data.name
                }}</span></span
              >
            </h5>
            <!-- EDIT -->
            <h5 class="modal-title" v-else>
              <span><i class="fa-solid fa-pencil"></i></span>
              {{ DATA.title }}&nbsp;<span>
                <span class="badge bg-light text-dark">
                  {{ DATA.db.name }}</span
                ></span
              ><span v-if="DATA.db.parent_name">
                of
                <span class="badge bg-light text-dark">{{
                  DATA.db.parent_name
                }}</span></span
              >
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row" v-if="DATA.data">
              <div class="col">
                <label class="form-label">Parent Category<i>*</i></label>
                <input
                  type="text"
                  :value="DATA.data.name"
                  class="form-control"
                  disabled
                />
                <div class="invalid-feedback">{{ errorName }}</div>
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
            <div class="row">
              <div class="col">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    name="allow_sub"
                    v-model="allow_sub"
                    id="allow_sub"
                  />
                  <label class="form-check-label" for="allow_sub">
                    Allow Sub Categories
                  </label>
                </div>
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
              :disabled="isSubmitting"
            >
              <i class="fa-solid fa-stop"></i>Cancel
            </button>
            <button
              type="button"
              class="btn btn-secondary icon"
              @click="customReset"
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
              {{ isSubmitting ? "Saving..." : "Save" }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import {
  useForm,
  useField,
  useIsFormDirty,
  useIsFormValid,
} from "vee-validate";
import { Modal } from "bootstrap";
import { inject } from "vue";
import * as yup from "yup";
import { ref, computed } from "vue";
import admin from "@/mixins/admin.js";
export default {
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    const DATA = ref({});
    const { axiosAsyncCallReturnData } = admin();
    const formValues = ref({ allow_sub: true });
    const schema = computed(() => {
      return yup.object({
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
          .min(3)
          .max(10)
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
        allow_sub: yup
          .boolean()
          .required()
          .label("Allow Sub Category Creation"),
        image: yup.number().min(0).max(10).nullable(true).label("Image"),
        description: yup.string().nullable(true).label("Description"),
      });
    });
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
    });
    const isDirty = useIsFormDirty();
    const isValid = useIsFormValid();
    const editController = ref(null);
    const newController = ref(null);
    /************************************************************************* */
    // eslint-disable-next-line
    function onInvalidSubmit({ values, errors, results }) {}
    const onSubmit = handleSubmit((values, { resetForm }) => {
      values.db = DATA.value.db;
      let method = DATA.value.db ? "PUT" : "POST";
      let action = DATA.value.db ? "update" : "create";
      if (DATA.value.data) values.category = DATA.value.data.id; // for new sub category only
      let controller;
      if (action == "create") {
        // new
        if (newController.value) {
          newController.value.abort();
        }
        controller = newController.value = new AbortController();
      } else {
        // edit
        if (editController.value) {
          editController.value.abort();
        }
        controller = editController.value = new AbortController();
      }
      return axiosAsyncCallReturnData(
        method,
        "category",
        {
          data: values,
          action: action,
        },
        controller,
        {
          showSuccessNotification: true,
          showCatchNotification: true,
          showProgress: true,
        }
      ).then(function (data) {
        if (data.success == true) {
          // added
          resetForm();
          window.window.CATEGORY_NEW_MODAL.hide();
          if (DATA.value.emit) {
            emitter.emit(DATA.value.emit, {}); // do something (emit)
          }
        } else {
          // not added
          if (data.errors) {
            // validation errors
            for (var key in data.errors) {
              setFieldError(key, data.errors[key]);
            }
          } else if (data.message == "canceled") {
            // duplicate aborted
          } else {
            // may be network error
          }
        }
      });
    }, onInvalidSubmit);
    /************************************************************************* */
    function close() {
      resetForm();
    }
    function customReset() {
      if (DATA.value.db) {
        // edit
        let fields = DATA.value.db;
        setFieldValue("name", fields.name);
        setFieldValue("code", fields.code || "");
        setFieldValue("slug", fields.slug || "");
        setFieldValue("allow_sub", fields.allow_sub === 0 ? false : true);
        setFieldValue("description", fields.description || "");
      } else {
        // new
        resetForm();
      }
    }
    /************************************************************************* */
    const { value: name, errorMessage: errorName } = useField("name");
    const { value: code, errorMessage: errorCode } = useField("code");
    const { value: slug, errorMessage: errorSlug } = useField("slug");
    const { value: allow_sub } = useField("allow_sub");
    const { value: image, errorMessage: errorImage } = useField("image");
    const { value: description, errorMessage: errorDescription } =
      useField("description");
    /************************************************************************* NEW or EDIT Supplier */
    emitter.on("newCategoryModal", (data) => {
      resetForm();
      DATA.value = data;
      if (DATA.value.db) {
        // edit
        let fields = DATA.value.db;
        setFieldValue("name", fields.name);
        setFieldValue("code", fields.code || "");
        setFieldValue("slug", fields.slug || "");
        setFieldValue("allow_sub", fields.allow_sub === 0 ? false : true);
        setFieldValue("description", fields.description || "");
      } else {
        //new
      }
      window.CATEGORY_NEW_MODAL.show();
    });
    /*************************************** */
    return {
      /******* form fields   */
      name,
      errorName,
      code,
      errorCode,
      slug,
      errorSlug,
      allow_sub,
      image,
      errorImage,
      description,
      errorDescription,
      /*************** */
      isDirty,
      isValid,
      onSubmit,
      isSubmitting,
      customReset,
      close,
      DATA,
      emitter,
    };
  },
  data() {
    return {};
  },
  mounted() {
    window.CATEGORY_NEW_MODAL = new Modal($("#categoryNewModal"), {
      backdrop: true,
      show: true,
    });
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("newCategoryModal");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>