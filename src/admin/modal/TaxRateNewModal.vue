<template>
  <div class="modal" id="prodNewTaxRateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <form @submit="onSubmit" class="needs-validation">
          <div class="modal-header">
            <h5 class="modal-title">New Tax Rate</h5>
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
                <label for="" class="form-label">Tax Name<i>*</i></label>
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
                <label class="form-label">Tax Rate<i>*</i></label>
                <div class="input-group is-invalid">
                  <input
                    type="number"
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
                      name="type"
                       v-model="type"
                      value="P"
                    />&nbsp;<strong>%</strong>
                  </div>
                  <div class="input-group-text">
                    <input
                      class="form-check-input mt-0"
                      type="radio"
                      name="type"
                      v-model="type"
                      value="F"
                    />&nbsp;<strong>₹</strong>
                  </div>
                </div>
                <div class="invalid-feedback">{{ errorType }}</div>
                <div class="invalid-feedback">{{ errorRate }}</div>
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
              v-show="isDirty"
              @click="resetForm"
            >
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
  props: {
    propUpdateTaxRates: Function,
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
    const formValues = {
      type:"P"
    };
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
          .min(2)
          .nullable(true)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("Code"),
        rate: yup
          .number()
          .required()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : undefined))
          .label("Tax Rate"),
        description: yup
          .string()
          .nullable(true)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("Description"),
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
      axiosCall("post", "tax", {
        data: values,
      }).then(function (data) {
        if (data.success == true) {
          props.propUpdateTaxRates(data.id);
          resetForm();
          window.PROD_NEW_TAXRATE_MODAL.hide();
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
    function close() {
      resetForm();
      window.PROD_NEW_TAXRATE_MODAL.hide();
    }
    /************************************************************************* */
    const { value: name, errorMessage: errorName } = useField("name");
    const { value: code, errorMessage: errorCode } = useField("code");
    const { value: rate, errorMessage: errorRate } = useField("rate");
    const { value: type, errorMessage: errorType} = useField("type");
    const { value: description, errorMessage: errorDescription } =
      useField("description");
    /*************************************** */
    return {
      /******* fields   */
      name,
      errorName,
      code,
      errorCode,
      rate,
      errorRate,
      description,
      errorDescription,
      type,
      errorType,
      /*************** */
      isDirty,
      isValid,
      onSubmit,
      resetForm,
      close,
    };
  },
  data() {
    return {};
  },
  methods: {},
  created() {},
  mounted() {},
};
</script>