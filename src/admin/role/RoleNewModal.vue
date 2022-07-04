<template>
  <div class="modal" id="roleNewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
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
                <label class="form-label">Role Name<i>*</i></label>
                <input
                  type="text"
                  name="role_name"
                  v-model="role_name"
                  class="form-control"
                  v-bind:class="[
                    errorRoleName
                      ? 'is-invalid'
                      : !errorRoleName && role_name
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorRoleName }}</div>
              </div>
              <div class="col">
                <label class="form-label">Maximum Allowed Users<i>*</i></label>
                <input
                  type="text"
                  name="max_users"
                  v-model="max_users"
                  class="form-control"
                  v-bind:class="[
                    errorMaxUsers
                      ? 'is-invalid'
                      : !errorMaxUsers && max_users
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorMaxUsers }}</div>
              </div>
              <div class="col">
                <label class="form-label">Description<i>*</i></label>
                <textarea
                  rows="1"
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
    const formValues = ref({});
    /************************************************************************* */
    const schema = computed(() => {
      return yup.object({
        role_name: yup
          .string()
          .required()
          .max(50)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("Role Name"),
        max_users: yup
          .number()
          .required()
          .min(1)
          .max(50)
          .nullable(true)
          .label("Max. Users"),
        description: yup
          .string()
          .required()
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
    emitter.on("newRoleModal", (data) => {
      resetForm();
      DATA.value = data;
      if (DATA.value.data) {
        let fields = DATA.value.data;
        setFieldValue("role_name", fields.name);
        setFieldValue("max_users", fields.limit);
        setFieldValue("description", fields.description);
      } else {
        //
      }
      window.ROLE_NEW_MODAL.show();
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
          window.window.ROLE_NEW_MODAL.hide();
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
        setFieldValue("role_name", fields.name);
        setFieldValue("max_users", fields.limit);
        setFieldValue("description", fields.description);
      } else {
        // new
        resetForm();
      }
    }
    /************************************************************************* */
    const { value: role_name, errorMessage: errorRoleName } =
      useField("role_name");
    const { value: max_users, errorMessage: errorMaxUsers } =
      useField("max_users");
    const { value: description, errorMessage: errorDescription } =
      useField("description");
    /*************************************** */
    return {
      /******* form fields   */
      role_name,
      errorRoleName,
      max_users,
      errorMaxUsers,
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
    window.ROLE_NEW_MODAL = new Modal($("#roleNewModal"), {
      backdrop: true,
      show: true,
    });
    //window.ROLE_NEW_MODAL.show();
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("newRoleModal");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>