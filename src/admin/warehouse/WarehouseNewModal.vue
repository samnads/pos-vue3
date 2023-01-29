<template>
  <div class="modal" id="warehouseNewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
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
                <label class="form-label">Date of Open<i>*</i></label>
                <input
                  type="date"
                  name="date_of_open"
                  v-model="date_of_open"
                  class="form-control"
                  v-bind:class="[
                    errorDoo
                      ? 'is-invalid'
                      : !errorDoo && date_of_open
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorDoo }}</div>
              </div>
              <div class="col">
                <label class="form-label">Status<i>*</i></label>
                <select
                  class="form-select text-capitalize"
                  name="status_id"
                  :disabled="!storedWarehouseStatuses"
                  v-model="status_id"
                  v-bind:class="[
                    errorStatus
                      ? 'is-invalid'
                      : errorStatus && status
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option
                    selected
                    :value="formValues.status"
                    v-if="!storedWarehouseStatuses"
                  >
                    Loading...
                  </option>
                  <option selected :value="null" v-if="storedWarehouseStatuses">
                    -- Select Status --
                  </option>
                  <option
                    v-for="s in storedWarehouseStatuses"
                    :key="s.id"
                    :value="s.id"
                  >
                    {{ s.name }}
                  </option>
                </select>
                <div class="invalid-feedback">{{ errorStatus }}</div>
              </div>
              <div class="col">
                <label class="form-label">Status Reason</label>
                <textarea
                  rows="1"
                  type="text"
                  name="status_reason"
                  v-model="status_reason"
                  class="form-control"
                  v-bind:class="[
                    errorStatusReason
                      ? 'is-invalid'
                      : !errorStatusReason && status_reason
                      ? 'is-valid'
                      : '',
                  ]"
                ></textarea>
                <div class="invalid-feedback">{{ errorStatusReason }}</div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="form-label">Email<i>*</i></label>
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
            </div>
            <div class="row">
              <div class="col">
                <label class="form-label">Country</label>
                <input
                  type="number"
                  name="country_id"
                  v-model="country_id"
                  class="form-control"
                  v-bind:class="[
                    errorCountry
                      ? 'is-invalid'
                      : !errorCountry && country_id
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorCountry }}</div>
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
                  name="pin_code"
                  v-model="pin_code"
                  class="form-control"
                  v-bind:class="[
                    errorPin
                      ? 'is-invalid'
                      : !errorPin && pin_code
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorPin }}</div>
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
import { useStore } from "vuex";
export default {
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    const store = useStore();
    let storedWarehouseStatuses = computed(function () {
      return store.state.COMMON_WAREHOUSE_STATUSES;
    });
    const DATA = ref({});
    const phoneRegExp =
      /^((\+[1-9]{1,4}[ -]?)|(\([0-9]{2,3}\)[ -]?)|([0-9]{2,4})[ -]?)*?[0-9]{3,4}[ -]?[0-9]{3,4}$/;
    const { axiosAsyncCallReturnData, axiosAsyncStoreReturnBool } = admin();
    /************************************************************************* */
    const formValues = ref({});
    /************************************************************************* */
    const schema = computed(() => {
      return yup.object({
        name: yup
          .string()
          .required()
          .max(50)
          .nullable(true)
          .label("Warehouse Name"),
        date_of_open: yup
          .date()
          .required()
          .nullable(true)
          .transform((curr, orig) => (orig === "" ? null : curr))
          .label("Date of Open"),
        status_id: yup.number().required().min(1).nullable(true).label("Status"),
        status_reason: yup
          .string()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("Status Reason"),
        email: yup
          .string()
          .email()
          .required()
          .min(5)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("Email"),
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
        country_id: yup
          .number()
          .min(1)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("Country"),
        city: yup
          .string()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("City"),
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
        pin_code: yup
          .string()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("PIN Code"),
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
    emitter.on("newWarehouseModal", (data) => {
      resetForm();
      DATA.value = data;
      if (DATA.value.data) {
        let fields = DATA.value.data;
        setFieldValue("name", fields.name);
        setFieldValue("date_of_open", fields.date_of_open);
        setFieldValue("status_id", fields.status_id);
        setFieldValue("status_reason", fields.status_reason);
        setFieldValue("phone", fields.phone);
        setFieldValue("country_id", fields.country_id);
        setFieldValue("city", fields.city);
        setFieldValue("place", fields.place);
        setFieldValue("pin_code", fields.pin_code);
        setFieldValue("email", fields.email);
        setFieldValue("address", fields.address);
        setFieldValue("description", fields.description);
      } else {
        setFieldValue("status_id", null); // can use a default value
      }
      window.WAREHOUSE_NEW_MODAL.show();
    });
    /************************************************************************* */
    // eslint-disable-next-line
    function onInvalidSubmit({ values, errors, results }) {}
    const onSubmit = handleSubmit((values, { resetForm }) => {
      values.db = DATA.value.data;
      let method = DATA.value.data ? "put" : "post";
      let action = DATA.value.data ? "update" : "create";
      let url = DATA.value.data ? "warehouse/"+values.db.id : "warehouse";
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
        url,
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
          window.window.WAREHOUSE_NEW_MODAL.hide();
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
        setFieldValue("date_of_open", fields.date_of_open);
        setFieldValue("status_id", fields.status_id);
        setFieldValue("status_reason", fields.status_reason);
        setFieldValue("phone", fields.phone);
        setFieldValue("country_id", fields.country_id);
        setFieldValue("city", fields.city);
        setFieldValue("place", fields.place);
        setFieldValue("pin_code", fields.pin_code);
        setFieldValue("email", fields.email);
        setFieldValue("address", fields.address);
        setFieldValue("description", fields.description);
      } else {
        // new
        resetForm();
        setFieldValue("status_id", null); // can use a default value
      }
    }
    /************************************************************************* */
    const { value: name, errorMessage: errorName } = useField("name");
    const { value: date_of_open, errorMessage: errorDoo } =
      useField("date_of_open");
    const { value: status_id, errorMessage: errorStatus } = useField("status_id");
    const { value: status_reason, errorMessage: errorStatusReason } =
      useField("status_reason");
    const { value: email, errorMessage: errorEmail } = useField("email");
    const { value: phone, errorMessage: errorPhone } = useField("phone");
    const { value: country_id, errorMessage: errorCountry } = useField("country_id");
    const { value: city, errorMessage: errorCity } = useField("city");
    const { value: place, errorMessage: errorPlace } = useField("place");
    const { value: pin_code, errorMessage: errorPin } = useField("pin_code");
    const { value: address, errorMessage: errorAddress } = useField("address");
    const { value: description, errorMessage: errorDescription } =
      useField("description");
    /*************************************** */
    return {
      /******* form fields   */
      name,
      errorName,
      date_of_open,
      errorDoo,
      status_id,
      errorStatus,
      status_reason,
      errorStatusReason,
      email,
      errorEmail,
      phone,
      errorPhone,
      country_id,
      errorCountry,
      city,
      errorCity,
      place,
      errorPlace,
      pin_code,
      errorPin,
      address,
      errorAddress,
      description,
      errorDescription,
      /*************** */
      axiosAsyncStoreReturnBool,
      storedWarehouseStatuses,
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
    window.WAREHOUSE_NEW_MODAL = new Modal($("#warehouseNewModal"), {
      backdrop: true,
      show: true,
    });
    if (!this.storedWarehouseStatuses) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeCommonWarehouseStatuses", "warehouse", {
        action: "create",
        dropdown: "status",
      });
    }
    //window.WAREHOUSE_NEW_MODAL.show();
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("newWarehouseModal");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>