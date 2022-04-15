<template>
  <div class="modal" id="prodNewUnitBulkModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <form @submit="onSubmit" class="needs-validation">
          <div class="modal-header">
            <h5 class="modal-title">New Sub Unit</h5>
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
                <label class="form-label">Base Unit<i>*</i></label>
                <input
                  type="text"
                  class="form-control"
                  :value="propUnit.name"
                  v-bind:class="[
                    errorUnit
                      ? 'is-invalid'
                      : !errorUnit && unit
                      ? 'is-valid'
                      : '',
                  ]"
                  disabled
                />
                <input
                  type="number"
                  class="form-control d-none"
                  v-model="unit"
                />
                <div class="invalid-feedback">{{ errorUnit }}</div>
              </div>
              <div class="col">
                <label for="" class="form-label">Quantity<i>*</i></label>
                <input
                  type="number"
                  name="quantity"
                  v-model="quantity"
                  class="form-control"
                  v-bind:class="[
                    errorQuantity
                      ? 'is-invalid'
                      : !errorQuantity && quantity
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorQuantity }}</div>
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
import { number } from "yup/lib/locale";
export default {
  props: {
    propUpdatePunitSUnit: Function,
    propUnit: Object,
  },
  setup(props) {
    // data retrieve
    const {
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
        unit: yup.object().required().nullable(true).label("Base Unit"),
        quantity: yup
          .number()
          .required()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : undefined))
          .label("Quantity"),
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
        description: yup
          .string()
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
      return axiosCall("post", "unit", {
        data: values,
      })
        .then(function (data) {
          if (data.success == true) {
            props.propUpdatePunitSUnit(data.id);
            resetCustom();
            window.PROD_NEW_UNIT_BULK_MODAL.hide();
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
    function resetCustom() {
      // preserve
      resetForm({
        values: {
          unit: unit.value,
        },
      });
    }
    function close() {
      resetCustom();
      window.PROD_NEW_UNIT_BULK_MODAL.hide();
    }
    /************************************************************************* */
    const { value: unit, errorMessage: errorUnit } = useField("unit");
    const { value: quantity, errorMessage: errorQuantity } =
      useField("quantity");
    const { value: name, errorMessage: errorName } = useField("name");
    const { value: code, errorMessage: errorCode } = useField("code");
    const { value: description, errorMessage: errorDescription } =
      useField("description");
    /*************************************** */
    return {
      /**************** event handler */
      /******* fields   */
      unit,
      errorUnit,
      quantity,
      errorQuantity,
      name,
      errorName,
      code,
      errorCode,
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
    };
  },
  data() {
    return {};
  },
  watch: {
    propUnit(value, oldValue) {
      value.id ? (this.unit = value) : undefined;
    },
  },
  methods: {},
  created() {},
  mounted() {},
};
</script>