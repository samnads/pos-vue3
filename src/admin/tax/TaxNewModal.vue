<template>
  <div class="modal" id="taxNewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <form @submit="onSubmit" class="needs-validation">
          <div
            class="modal-header"
            :class="DATA.type ? 'bg-' + DATA.type : 'bg-primary'"
          >
            <h5 class="modal-title">
              <span v-if="DATA.data"><i class="fa-solid fa-pencil"></i></span>
              <span v-else><i class="fa-solid fa-plus"></i></span
              >{{ DATA.title }}
              <span class="badge bg-light text-dark" v-if="DATA.data">{{
                DATA.data.name
              }}</span>
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
            <div class="row">
              <div class="col">
                <label class="form-label">Name<i>*</i></label>
                <input
                  type="text"
                  name="name"
                  v-model="name"
                  class="form-control"
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
                <label class="form-label">Code<i>*</i></label>
                <input
                  type="text"
                  name="code"
                  v-model="code"
                  class="form-control"
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
                <label class="form-label">Tax Rate<i>*</i></label>
                <div class="input-group has-validation">
                  <input
                    type="number"
                    step="any"
                    name="rate"
                    v-model="rate"
                    class="form-control"
                    v-bind:class="[
                      errorRate
                        ? 'is-invalid'
                        : !errorRate && rate
                        ? 'is-valid'
                        : '',
                    ]"
                  />
                  <div class="input-group-text">
                    <input
                      class="form-check-input mt-0"
                      type="radio"
                      value="P"
                      name="type"
                      v-model="type"
                      v-bind:class="[
                        errorType
                          ? 'is-invalid'
                          : !errorType && type
                          ? 'is-valid'
                          : '',
                      ]"
                    />&nbsp;%
                  </div>
                  <div class="input-group-text">
                    <input
                      class="form-check-input mt-0"
                      type="radio"
                      value="F"
                      name="type"
                      v-model="type"
                      v-bind:class="[
                        errorType
                          ? 'is-invalid'
                          : !errorType && type
                          ? 'is-valid'
                          : '',
                      ]"
                    />&nbsp;Fixed
                    <div class="invalid-feedback">{{ errorType }}</div>
                  </div>
                  <div class="invalid-feedback">{{ errorRate }}</div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="form-label">Description</label>
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
    const { axiosAsyncCallReturnData, axiosAsyncStoreReturnBool } = admin();
    /************************************************************************* */
    const formValues = ref({ type: "P" });
    /************************************************************************* */
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
          .nullable(true)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("Code"),
        rate: yup.number().required().nullable(true).label("Rate"),
        type: yup
          .string()
          .required()
          .nullable(true)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("Type"),
        description: yup
          .string()
          .min(2)
          .nullable(true)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("Description"),
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
    /************************************************************************* NEW or EDIT Brand */
    emitter.on("newTaxModal", (data) => {
      resetForm();
      DATA.value = data;
      if (DATA.value.data) {
        let fields = DATA.value.data;
        setFieldValue("name", fields.name);
        setFieldValue("code", fields.code);
        setFieldValue("rate", fields.rate);
        setFieldValue("type", fields.type);
        setFieldValue("description", fields.description || "");
      } else {
        //
      }
      window.TAX_NEW_MODAL.show();
    });
    /************************************************************************* */
    // eslint-disable-next-line
    function onInvalidSubmit({ values, errors, results }) {
      console.log(errors);
    }
    const onSubmit = handleSubmit((values, { resetForm }) => {
      values.db = DATA.value.data;
      let method = DATA.value.data ? "put" : "post";
      let action = DATA.value.data ? "update" : "create";
      let controller;
      if (method == "post") {
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
        "tax",
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
          window.TAX_NEW_MODAL.hide();
          if (DATA.value.emit) {
            emitter.emit(DATA.value.emit, data); // do something (emit)
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
      if (DATA.value.data) {
        // edit form
        let fields = DATA.value.data;
        setFieldValue("name", fields.name);
        setFieldValue("code", fields.code);
        setFieldValue("rate", fields.rate);
        setFieldValue("type", fields.type);
        setFieldValue("description", fields.description || "");
      } else {
        // new
        resetForm();
      }
    }
    /************************************************************************* */
    const { value: name, errorMessage: errorName } = useField("name");
    const { value: code, errorMessage: errorCode } = useField("code");
    const { value: rate, errorMessage: errorRate } = useField("rate");
    const { value: type, errorMessage: errorType } = useField("type");
    const { value: description, errorMessage: errorDescription } =
      useField("description");
    /*************************************** */
    return {
      /******* form fields   */
      name,
      errorName,
      code,
      errorCode,
      rate,
      errorRate,
      type,
      errorType,
      description,
      errorDescription,
      /*************** */
      axiosAsyncStoreReturnBool,
      formValues,
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
    window.TAX_NEW_MODAL = new Modal($("#taxNewModal"), {
      backdrop: true,
      show: true,
    });
    //window.TAX_NEW_MODAL.show();
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("newTaxModal");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>