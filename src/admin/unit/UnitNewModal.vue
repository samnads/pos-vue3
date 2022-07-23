<template>
  <div class="modal" id="unitNewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <form @submit="onSubmit" class="needs-validation">
          <div
            class="modal-header"
            :class="DATA.type ? 'bg-' + DATA.type : 'bg-primary'"
          >
            <h5 class="modal-title" v-if="DATA.data && DATA.data.db">
              <!-- edit -->
              <span><i class="fa-solid fa-pencil"></i></span>{{ DATA.title }}
              <span class="badge bg-light text-dark">{{ DATA.data }}</span>
            </h5>
            <h5 class="modal-title" v-else>
              <!-- new -->
              <span><i class="fa-solid fa-plus"></i></span>{{ DATA.title }}
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
            <div class="row" v-if="DATA.data || (DATA.db && DATA.db.base_name)">
              <div class="col-6">
                <label class="form-label">Base Unit<i>*</i></label>
                <input
                  type="text"
                  name="name"
                  :value="
                    DATA.data
                      ? DATA.data.name
                      : DATA.db.base_name + ' (' + DATA.db.base_code + ')'
                  "
                  class="form-control"
                  disabled
                />
                <div class="invalid-feedback">{{ errorName }}</div>
              </div>
              <div class="col">
                <label class="form-label">Operator<i>*</i></label>
                <select
                  class="form-select"
                  name="operator"
                  v-model="operator"
                  v-bind:class="[
                    errorOperator
                      ? 'is-invalid'
                      : !errorOperator && operator
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option value="*">*</option>
                  <option value="/">/</option>
                  <option value="+">+</option>
                  <option value="+">-</option>
                </select>
                <div class="invalid-feedback">{{ errorOperator }}</div>
              </div>
              <div class="col">
                <label class="form-label">Step<i>*</i></label>
                <input
                  type="number"
                  step="any"
                  name="step"
                  v-model="step"
                  class="form-control"
                  v-bind:class="[
                    errorStep
                      ? 'is-invalid'
                      : !errorStep && step
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorStep }}</div>
              </div>
              <hr class="mt-4" />
            </div>
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
              <div class="col">
                <label class="form-label">Allow Decimal</label>
                <div class="input-group">
                  <div class="input-group-text form-control">
                    <div class="form-check form-switch">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        name="allow_decimal"
                        v-model="allow_decimal"
                      />
                    </div>
                  </div>
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
    const formValues = ref({ allow_decimal: true });
    const subForm = ref(true);
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
        allow_decimal: yup.boolean().required().label("Allow Decimal"),
        operator: yup
          .string()
          .nullable(true)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("Operator"),
        step: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .when("test1", {
            is: (value = subForm.value) => value == true,
            then: yup
              .number()
              .nullable(true)
              .transform((_, val) => (val === Number(val) ? val : null))
              .required(),
          })
          .label("Step"),
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
    emitter.on("newUnitModal", (data) => {
      resetForm();
      DATA.value = data;
      if (DATA.value.db) {
        // edit form
        let fields = DATA.value.db;
        setFieldValue("name", fields.name);
        setFieldValue("code", fields.code);
        setFieldValue(
          "allow_decimal",
          fields.allow_decimal == 1 ? true : false
        );
        setFieldValue("operator", fields.operator || "");
        setFieldValue("step", fields.step);
        setFieldValue("description", fields.description || "");
        subForm.value = DATA.value.db.base ? true : false;
      } else {
        // new form
        setFieldValue("operator", "*");
        subForm.value =
          DATA.value.data && DATA.value.data.base === null ? true : false; // for dynamic required or not schema
      }
      window.UNIT_NEW_MODAL.show();
    });
    /************************************************************************* */
    // eslint-disable-next-line
    function onInvalidSubmit({ values, errors, results }) {
      console.log(errors);
    }
    const onSubmit = handleSubmit((values, { resetForm }) => {
      let method = DATA.value.db ? "put" : "post";
      let action = DATA.value.db ? "update" : "create";
      if (action == "create") {
        values.unit = DATA.value.data ? DATA.value.data.id : undefined; // for sub unit
      } else {
        values.id = DATA.value.db.id;
        values.unit = DATA.value.db.base ? DATA.value.db.base : undefined; // for sub unit
      }
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
        "unit",
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
          window.UNIT_NEW_MODAL.hide();
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
      if (DATA.value.db) {
        // edit form
        let fields = DATA.value.db;
        setFieldValue("name", fields.name);
        setFieldValue("code", fields.code);
        setFieldValue("operator", fields.operator || "*");
        setFieldValue("step", fields.step);
        setFieldValue(
          "allow_decimal",
          fields.allow_decimal == 1 ? true : false
        );
        setFieldValue("description", fields.description || "");
      } else {
        // new
        resetForm();
        setFieldValue("operator", "*");
      }
    }
    /************************************************************************* */
    const { value: name, errorMessage: errorName } = useField("name");
    const { value: code, errorMessage: errorCode } = useField("code");
    const { value: operator, errorMessage: errorOperator } =
      useField("operator");
    const { value: step, errorMessage: errorStep } = useField("step");
    const { value: allow_decimal } = useField("allow_decimal");
    const { value: description, errorMessage: errorDescription } =
      useField("description");
    /*************************************** */
    return {
      /******* form fields   */
      name,
      errorName,
      code,
      errorCode,
      allow_decimal,
      operator,
      errorOperator,
      step,
      errorStep,
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
      subForm,
    };
  },
  data() {
    return {};
  },
  mounted() {
    window.UNIT_NEW_MODAL = new Modal($("#unitNewModal"), {
      backdrop: true,
      show: true,
    });
    //window.UNIT_NEW_MODAL.show();
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("newUnitModal");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>