<template>
  <div class="modal" id="customerInfoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <form @submit="onSubmit" class="needs-validation">
          <div class="modal-header">
            <h5 class="modal-title"><span><i class="fa-solid fa-circle-info"></i></span> Customer Information</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">Info Here !</div>
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
              @click="resetForm"
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
import { Modal } from "bootstrap";
import * as yup from "yup";
import {computed } from "vue";
import { inject } from "vue";
import admin from "@/mixins/admin.js";
export default {
  props: {
    propUpdateTaxRates: Function,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    // data retrieve
    const {
      notifyDefault,
      notifyFormError,
      notifyApiResponse,
      notifyCatchResponse,
      axiosAsyncCallReturnData,
    } = admin();
    /************************************************************************* */
    const formValues = {
      type: "P",
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
    /************************************************************************* */
    const isDirty = useIsFormDirty();
    const isValid = useIsFormValid();
    /************************************************************************* */
    function onInvalidSubmit({ values, errors, results }) {
      console.log(errors);
    }
    const onSubmit = handleSubmit((values, { resetForm }) => {
      return axiosAsyncCallReturnData("post", "tax", {
        data: values,
      }).then(function (data) {
        if (data.success == true) {
          props.propUpdateTaxRates(data.id);
          resetForm();
          window.PROD_NEW_TAXRATE_MODAL.hide();
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
    const { value: type, errorMessage: errorType } = useField("type");
    const { value: description, errorMessage: errorDescription } =
      useField("description");
    /*************************************** */
    emitter.on("showCustomerInfoModal", (data) => {
      window.CUSTOMER_INFO_MODAL.show();
    });
    return {
      emitter,
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
      isSubmitting,
      resetForm,
      close,
    };
  },
  data() {
    return {};
  },
  methods: {},
  created() {},
  mounted() {
    window.CUSTOMER_INFO_MODAL = new Modal($("#customerInfoModal"), {
      backdrop: true,
      show: true,
    });
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("showCustomerInfoModal");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>