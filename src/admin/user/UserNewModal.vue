<template>
  <div class="modal" id="userNewModal" tabindex="-1" aria-hidden="true">
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
                DATA.data.username
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
                <label class="form-label">First Name<i>*</i></label>
                <input
                  type="text"
                  name="first_name"
                  v-model="first_name"
                  class="form-control"
                  v-bind:class="[
                    errorFirstName
                      ? 'is-invalid'
                      : !errorFirstName && first_name
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorFirstName }}</div>
              </div>
              <div class="col">
                <label class="form-label">Last Name</label>
                <input
                  type="text"
                  name="last_name"
                  v-model="last_name"
                  class="form-control"
                  v-bind:class="[
                    errorLastName
                      ? 'is-invalid'
                      : !errorLastName && last_name
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorLastName }}</div>
              </div>
              <div class="col">
                <label class="form-label">Gender<i>*</i></label>
                <select
                  class="form-select"
                  name="gender"
                  :disabled="!storedGenders"
                  v-model="gender"
                  v-bind:class="[
                    errorGender
                      ? 'is-invalid'
                      : errorGender && gender
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option
                    selected
                    :value="formValues.gender"
                    v-if="!storedGenders"
                  >
                    Loading...
                  </option>
                  <option selected :value="null" v-if="storedGenders">
                    -- Select Gender --
                  </option>
                  <option v-for="g in storedGenders" :key="g.id" :value="g.id">
                    {{ g.name }}
                  </option>
                </select>
                <div class="invalid-feedback">{{ errorGender }}</div>
              </div>
              <div class="col">
                <label class="form-label">Date of Birth<i>*</i></label>
                <input
                  type="date"
                  name="dob"
                  v-model="dob"
                  class="form-control"
                  v-bind:class="[
                    errorDob
                      ? 'is-invalid'
                      : !errorDob && dob
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorDob }}</div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="form-label">Username<i>*</i></label>
                <input
                  type="text"
                  name="username"
                  v-model="username"
                  autocomplete="fgfg"
                  class="form-control"
                  v-bind:class="[
                    errorUsername
                      ? 'is-invalid'
                      : !errorUsername && username
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorUsername }}</div>
              </div>
              <div class="col">
                <label class="form-label">Role<i>*</i></label>
                <select
                  class="form-select"
                  name="role"
                  :disabled="!storedRoles"
                  v-model="role"
                  v-bind:class="[
                    errorRole
                      ? 'is-invalid'
                      : errorRole && role
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option selected :value="formValues.role" v-if="!storedRoles">
                    Loading...
                  </option>
                  <option selected :value="null" v-if="storedRoles">
                    -- Select Role --
                  </option>
                  <option v-for="r in storedRoles" :key="r.id" :value="r.id">
                    {{ r.name }}
                  </option>
                </select>
                <div class="invalid-feedback">{{ errorRole }}</div>
              </div>
              <div class="col">
                <label class="form-label">Status<i>*</i></label>
                <select
                  class="form-select text-capitalize"
                  name="status"
                  :disabled="!storedRoleStatuses"
                  v-model="status"
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
                    v-if="!storedRoleStatuses"
                  >
                    Loading...
                  </option>
                  <option selected :value="null" v-if="storedRoleStatuses">
                    -- Select Status --
                  </option>
                  <option
                    v-for="s in storedRoleStatuses"
                    :key="s.id"
                    :value="s.id"
                  >
                    {{ s.name }}
                  </option>
                </select>
                <div class="invalid-feedback">{{ errorStatus }}</div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="form-label"
                  ><span v-if="DATA.data">New </span>Password<i v-if="!DATA.data">*</i></label
                >
                <input
                  type="password"
                  name="password"
                  autocomplete="new-password"
                  v-model="password"
                  class="form-control"
                  v-bind:class="[
                    errorPassword
                      ? 'is-invalid'
                      : !errorPassword && password
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorPassword }}</div>
              </div>
              <div class="col">
                <label class="form-label"
                  >Confirm <span v-if="DATA.data">New </span>Password<i v-if="!DATA.data">*</i></label
                >
                <input
                  type="password"
                  name="r_password"
                  autocomplete="ghfghfgh"
                  v-model="r_password"
                  class="form-control"
                  v-bind:class="[
                    errorRpassword
                      ? 'is-invalid'
                      : !errorRpassword && r_password
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorRpassword }}</div>
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
              <div class="col">
                <label class="form-label">Company Name</label>
                <input
                  type="text"
                  name="company_name"
                  v-model="company_name"
                  class="form-control"
                  v-bind:class="[
                    errorCompanyname
                      ? 'is-invalid'
                      : !errorCompanyname && company_name
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorCompanyname }}</div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="form-label">Country</label>
                <input
                  type="text"
                  name="country"
                  v-model="country"
                  class="form-control"
                  v-bind:class="[
                    errorCountry
                      ? 'is-invalid'
                      : !errorCountry && country
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
                <label class="form-label">Place</label>
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
    let storedGenders = computed(function () {
      return store.state.COMMON_GENDERS;
    });
    let storedRoles = computed(function () {
      return store.state.COMMON_ROLES;
    });
    let storedRoleStatuses = computed(function () {
      return store.state.COMMON_ROLE_STATUSES;
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
        first_name: yup
          .string()
          .required()
          .max(50)
          .nullable(true)
          .label("First Name"),
        last_name: yup.string().max(50).nullable(true).label("Last Name"),
        gender: yup.number().required().nullable(true).label("Gender"),
        dob: yup
          .date()
          .nullable(true)
          .transform((curr, orig) => (orig === "" ? null : curr))
          .label("DOB"),
        username: yup
          .string()
          .required()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("User Name"),
        role: yup.number().required().min(1).nullable(true).label("Role"),
        status: yup.number().required().min(1).nullable(true).label("Status"),
        password: yup
          .string()
          .matches("^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[@$!%*?&])[A-Za-z\\d@$!%*?&]{8,}$","Password must contain at least one uppercase, one lowercase, one number and one special character.")
          .min(8)
          .max(50)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .test(
            "required-test1",
            "Password is a required field", // error message
            function test() {
              if (DATA.value.data) {
                // edit
                return true;
              } else if (!DATA.value.data && password.value) {
                //new
                return true;
              }
              return false;
            }
          )
          .label("Password"),
        r_password: yup
          .string()
          .oneOf(
            [yup.ref("password"), null],
            "Confirm Password must match with Password"
          )
          .min(8)
          .max(50)
          .nullable(true)
          .test(
            "required-test2",
            "Confirm Password is a required field", // error message
            function test() {
              if (DATA.value.data) {
                // edit
                if (password.value == r_password.value) {
                  return true;
                }
                return false;
              } else {
                //new
                if (r_password.value) {
                  return true;
                }
                return false;
              }
            }
          )
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("Confirm Password"),
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
        company_name: yup
          .string()
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("Company Name"),
        country: yup
          .string()
          .min(3)
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
          .min(3)
          .max(100)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("Place"),
        pin: yup
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
    emitter.on("newUserModal", (data) => {
      resetForm();
      DATA.value = data;
      if (DATA.value.data) {
        let fields = DATA.value.data;
        setFieldValue("first_name", fields.first_name);
        setFieldValue("last_name", fields.last_name);
        setFieldValue("gender", fields.gender);
        setFieldValue("dob", fields.date_of_birth);
        setFieldValue("username", fields.username);
        setFieldValue("role", fields.role);
        setFieldValue("status", fields.status);
        setFieldValue("phone", fields.phone);
        setFieldValue("company_name", fields.company_name);
        setFieldValue("country", fields.country);
        setFieldValue("city", fields.city);
        setFieldValue("place", fields.place);
        setFieldValue("pin", fields.pin_code);
        setFieldValue("email", fields.email);
        setFieldValue("address", fields.address);
        setFieldValue("description", fields.description);
      } else {
        setFieldValue("gender", null); // can use a default value
        setFieldValue("role", null); // can use a default value
        setFieldValue("status", null); // can use a default value
      }
      window.USER_NEW_MODAL.show();
    });
    /************************************************************************* */
    // eslint-disable-next-line
    function onInvalidSubmit({ values, errors, results }) {}
    const onSubmit = handleSubmit((values, { resetForm }) => {
      values.db = DATA.value.data;
      let method = DATA.value.data ? "put" : "post";
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
        "user",
        {
          data: values,
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
          window.window.USER_NEW_MODAL.hide();
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
        setFieldValue("first_name", fields.first_name);
        setFieldValue("last_name", fields.last_name);
        setFieldValue("gender", fields.gender);
        setFieldValue("dob", fields.date_of_birth);
        setFieldValue("username", fields.username);
        setFieldValue("role", fields.role);
        setFieldValue("status", fields.status);
        setFieldValue("phone", fields.phone);
        setFieldValue("company_name", fields.company_name);
        setFieldValue("country", fields.country);
        setFieldValue("city", fields.city);
        setFieldValue("place", fields.place);
        setFieldValue("pin", fields.pin_code);
        setFieldValue("email", fields.email);
        setFieldValue("address", fields.address);
        setFieldValue("description", fields.description);
        setFieldValue("password", fields.password);
        setFieldValue("r_password", fields.r_password);
      } else {
        // new
        resetForm();
        setFieldValue("gender", null); // can use a default value
        setFieldValue("role", null); // can use a default value
        setFieldValue("status", null); // can use a default value
      }
    }
    /************************************************************************* */
    const { value: first_name, errorMessage: errorFirstName } =
      useField("first_name");
    const { value: last_name, errorMessage: errorLastName } =
      useField("last_name");
    const { value: gender, errorMessage: errorGender } = useField("gender");
    const { value: dob, errorMessage: errorDob } = useField("dob");
    const { value: username, errorMessage: errorUsername } =
      useField("username");
    const { value: role, errorMessage: errorRole } = useField("role");
    const { value: status, errorMessage: errorStatus } = useField("status");
    const { value: password, errorMessage: errorPassword } =
      useField("password");
    const { value: r_password, errorMessage: errorRpassword } =
      useField("r_password");
    const { value: email, errorMessage: errorEmail } = useField("email");
    const { value: phone, errorMessage: errorPhone } = useField("phone");
    const { value: company_name, errorMessage: errorCompanyname } =
      useField("company_name");
    const { value: country, errorMessage: errorCountry } = useField("country");
    const { value: city, errorMessage: errorCity } = useField("city");
    const { value: place, errorMessage: errorPlace } = useField("place");
    const { value: pin, errorMessage: errorPin } = useField("pin");
    const { value: address, errorMessage: errorAddress } = useField("address");
    const { value: description, errorMessage: errorDescription } =
      useField("description");
    /*************************************** */
    return {
      /******* form fields   */
      first_name,
      errorFirstName,
      last_name,
      errorLastName,
      gender,
      errorGender,
      dob,
      errorDob,
      username,
      errorUsername,
      role,
      errorRole,
      status,
      errorStatus,
      password,
      errorPassword,
      r_password,
      errorRpassword,
      email,
      errorEmail,
      phone,
      company_name,
      errorCompanyname,
      errorPhone,
      country,
      errorCountry,
      city,
      errorCity,
      place,
      errorPlace,
      pin,
      errorPin,
      address,
      errorAddress,
      description,
      errorDescription,
      /*************** */
      axiosAsyncStoreReturnBool,
      storedGenders,
      storedRoles,
      storedRoleStatuses,
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
    window.USER_NEW_MODAL = new Modal($("#userNewModal"), {
      backdrop: true,
      show: true,
    });
    if (!this.storedGenders) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeCommonGenders", "common", {
        action: "gender",
      });
    }
    if (!this.storedRoles) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeCommonRoles", "common", {
        action: "role",
      });
    }
    if (!this.storedRoleStatuses) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeCommonRoleStatuses", "common", {
        action: "status",
        type: "user_status",
      });
    }
    //window.USER_NEW_MODAL.show();
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("newUserModal");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>