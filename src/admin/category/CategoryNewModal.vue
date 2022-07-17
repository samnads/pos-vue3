<template>
  <div class="modal" id="supplierNewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <form @submit="onSubmit" class="needs-validation">
          <div
            class="modal-header"
            :class="DATA.type ? 'bg-' + DATA.type : 'bg-primary'"
          >
            <h5 class="modal-title">
              <span v-if="DATA.data"><i class="fa-solid fa-pencil"></i></span>
              <span v-else><i class="fa-solid fa-plus"></i></span>{{ DATA.title
              }}<span class="badge bg-light text-dark" v-if="DATA.data">{{
                DATA.data.code
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
                <label class="form-label">Supplier Name<i>*</i></label>
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
                <label class="form-label">Place<i>*</i></label>
                <input
                  type="text"
                  name="place"
                  v-model="place"
                  class="form-control"
                  v-bind:class="[
                    errorPlace
                      ? 'is-invalid'
                      : !errorPlace && place
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorPlace }}</div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="form-label">Phone<i>*</i></label>
                <input
                  type="text"
                  name="phone"
                  v-model="phone"
                  class="form-control"
                  v-bind:class="[
                    errorPhone
                      ? 'is-invalid'
                      : !errorPhone && phone
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorPhone }}</div>
              </div>
              <div class="col">
                <label class="form-label">City</label>
                <input
                  type="text"
                  name="city"
                  v-model="city"
                  class="form-control"
                  v-bind:class="[
                    errorCity
                      ? 'is-invalid'
                      : !errorCity && city
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorCity }}</div>
              </div>
              <div class="col">
                <label class="form-label">PIN Code</label>
                <input
                  type="text"
                  name="pin"
                  v-model="pin"
                  class="form-control"
                  v-bind:class="[
                    errorPin
                      ? 'is-invalid'
                      : !errorPin && pin
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorPin }}</div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="form-label">Email</label>
                <input
                  type="email"
                  name="email"
                  v-model="email"
                  class="form-control"
                  v-bind:class="[
                    errorEmail
                      ? 'is-invalid'
                      : !errorEmail && email
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorEmail }}</div>
              </div>
              <div class="col">
                <label class="form-label">GST No.</label>
                <input
                  type="text"
                  name="gst"
                  v-model="gst"
                  class="form-control"
                  v-bind:class="[
                    errorGst
                      ? 'is-invalid'
                      : !errorGst && gst
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorGst }}</div>
              </div>
              <div class="col">
                <label class="form-label">Tax No.</label>
                <input
                  type="text"
                  name="tax"
                  v-model="tax"
                  class="form-control"
                  v-bind:class="[
                    errorTax
                      ? 'is-invalid'
                      : !errorTax && tax
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorTax }}</div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="form-label">Address</label>
                <textarea
                  rows="3"
                  type="text"
                  name="address"
                  v-model="address"
                  class="form-control"
                  v-bind:class="[
                    errorAddress
                      ? 'is-invalid'
                      : !errorAddress && address
                      ? 'is-valid'
                      : '',
                  ]"
                ></textarea>
                <div class="invalid-feedback">{{ errorAddress }}</div>
              </div>
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
  props: {
    propUpdateTaxRates: Function,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    const DATA = ref({});
    const phoneRegExp =
      /^((\+[1-9]{1,4}[ -]?)|(\([0-9]{2,3}\)[ -]?)|([0-9]{2,4})[ -]?)*?[0-9]{3,4}[ -]?[0-9]{3,4}$/;
    const { axiosAsyncCallReturnData } = admin();
    /************************************************************************* */
    const formValues = ref({});
    /************************************************************************* */
    const schema = computed(() => {
      return yup.object({
        name: yup
          .string()
          .required()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("Name"),
        place: yup
          .string()
          .required()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("Place"),
        phone: yup
          .string()
          .required()
          .matches(phoneRegExp, "Phone Number is not valid")
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("Phone Number"),
        city: yup
          .string()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("City"),
        pin: yup
          .string()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("PIN"),
        email: yup
          .string()
          .email()
          .min(5)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("Email"),
        gst: yup
          .string()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("GST No."),
        tax: yup
          .string()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("TAX No."),
        address: yup
          .string()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("Address"),
        description: yup
          .string()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
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
    /************************************************************************* NEW or EDIT Supplier */
    emitter.on("newSupplierModal", (data) => {
      resetForm();
      DATA.value = data;
      if (DATA.value.data) {
        let fields = DATA.value.data;
        setFieldValue("name", fields.name);
        setFieldValue("place", fields.place);
        setFieldValue("phone", fields.phone);
        setFieldValue("city", fields.city);
        setFieldValue("pin", fields.pin_code);
        setFieldValue("email", fields.email);
        setFieldValue("gst", fields.gst_no);
        setFieldValue("tax", fields.tax_no);
        setFieldValue("address", fields.address);
        setFieldValue("description", fields.description);
      } else {
        formValues.value = {};
      }
      window.SUPPLIER_NEW_MODAL.show();
    });
    /************************************************************************* */
    // eslint-disable-next-line
    function onInvalidSubmit({ values, errors, results }) {}
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
        "supplier",
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
          window.window.SUPPLIER_NEW_MODAL.hide();
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
      if (DATA.value.data) {
        // edit form
        let fields = DATA.value.data;
        setFieldValue("name", fields.name);
        setFieldValue("place", fields.place);
        setFieldValue("phone", fields.phone);
        setFieldValue("city", fields.city);
        setFieldValue("pin", fields.pin_code);
        setFieldValue("email", fields.email);
        setFieldValue("gst", fields.gst_no);
        setFieldValue("tax", fields.tax_no);
        setFieldValue("address", fields.address);
        setFieldValue("description", fields.description);
      } else {
        // new
        resetForm();
      }
    }
    /************************************************************************* */
    const { value: name, errorMessage: errorName } = useField("name");
    const { value: place, errorMessage: errorPlace } = useField("place");
    const { value: phone, errorMessage: errorPhone } = useField("phone");
    const { value: city, errorMessage: errorCity } = useField("city");
    const { value: pin, errorMessage: errorPin } = useField("pin");
    const { value: email, errorMessage: errorEmail } = useField("email");
    const { value: gst, errorMessage: errorGst } = useField("gst");
    const { value: tax, errorMessage: errorTax } = useField("tax");
    const { value: address, errorMessage: errorAddress } = useField("address");
    const { value: description, errorMessage: errorDescription } =
      useField("description");
    /*************************************** */
    return {
      /******* form fields   */
      name,
      errorName,
      place,
      errorPlace,
      phone,
      errorPhone,
      city,
      errorCity,
      pin,
      errorPin,
      email,
      errorEmail,
      gst,
      errorGst,
      tax,
      errorTax,
      address,
      errorAddress,
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
    window.SUPPLIER_NEW_MODAL = new Modal($("#supplierNewModal"), {
      backdrop: true,
      show: true,
    });
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("newSupplierModal");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>