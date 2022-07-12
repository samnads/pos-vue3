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
                <label class="form-label">Maximum Allowed Users<i>*</i></label>
                <input
                  type="number"
                  name="limit"
                  v-model="limit"
                  class="form-control"
                  v-bind:class="[
                    errorLimit
                      ? 'is-invalid'
                      : !errorLimit && limit
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <div class="invalid-feedback">{{ errorLimit }}</div>
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
            <div class="row">
              <div class="col">
                <table
                  class="table table-bordered"
                  :class="DATA.data ? 'border-primary' : 'border-success'"
                >
                  <thead class="table-dark">
                    <tr>
                      <th scope="col">Module</th>
                      <th scope="col" class="text-center">Permissions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(row, key) in MODULE_PERMISSIONS" :key="key">
                      <td class="text-capitalize">
                        <h4>{{ key }}</h4>
                        <p>{{ row[0]["module_description"] }}</p>
                      </td>
                      <td class="align-middle">
                        <ul
                          v-for="(permObj, permKey) in row"
                          :key="permKey"
                          class="text-capitalize mt-3"
                        >
                          <span>
                            <input
                              class="form-check-input"
                              type="checkbox"
                              v-model="
                                rights[permObj['module_name']][
                                  permObj['permission']
                                ]
                              "
                            />&nbsp;&nbsp;&nbsp;
                            {{ permObj["permission_name"] }}
                          </span>
                        </ul>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <!--<table
                  class="table table-bordered"
                  :class="DATA.data ? 'border-primary' : 'border-success'"
                >
                  <thead>
                    <tr>
                      <th scope="col">Module</th>
                      <th scope="col" class="text-center">CREATE</th>
                      <th scope="col" class="text-center">VIEW</th>
                      <th scope="col" class="text-center">UPDATE</th>
                      <th scope="col" class="text-center">DELETE</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="MODULE in MODULES" :key="MODULE.name">
                      <td class="text-capitalize">{{ MODULE.name }}</td>
                      <td class="text-center">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          v-model="rights[MODULE.name].POST"
                        />
                      </td>
                      <td class="text-center">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          v-model="rights[MODULE.name].GET"
                        />
                      </td>
                      <td class="text-center">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          v-model="rights[MODULE.name].PUT"
                        />
                      </td>
                      <td class="text-center">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          v-model="rights[MODULE.name].DELETE"
                        />
                      </td>
                    </tr>
                  </tbody>
                </table>-->
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
/* eslint-disable */
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
    const MODULE_PERMISSIONS = ref({});
    const DEF_MODULE_PERMISSIONS = ref({});
    const formValues = ref({
      rights: {},
    });
    /************************************************************************* */
    const schema = computed(() => {
      return yup.object({
        name: yup
          .string()
          .required()
          .max(50)
          .nullable(true)
          .transform((_, val) =>
            val != null && val.length > 0 ? val : undefined
          )
          .label("Role Name"),
        limit: yup
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
        rights: yup.object().label("Rights"),
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
      //resetForm();
      DATA.value = data;
      if (DATA.value.data) {
        let fields = DATA.value.data;
        setFieldValue("name", fields.name);
        setFieldValue("limit", fields.limit);
        setFieldValue("description", fields.description || "");
        setFieldValue("rights", DEF_MODULE_PERMISSIONS);
      } else {
        setFieldValue("name", null);
        setFieldValue("limit", null);
        setFieldValue("description", "");
        setFieldValue("rights", DEF_MODULE_PERMISSIONS);
      }
      window.ROLE_NEW_MODAL.show();
    });
    /************************************************************************* */
    // eslint-disable-next-line
    function onInvalidSubmit({ values, errors, results }) {
      console.log(values);
    }
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
        "role",
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
          //resetForm();
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
      setFieldValue("name", null);
      setFieldValue("limit", null);
      setFieldValue("description", null);
      setFieldValue("rights", DEF_MODULE_PERMISSIONS);
    }
    function customReset() {
      if (DATA.value.data) {
        // edit form
        let fields = DATA.value.data;
        setFieldValue("name", fields.name);
        setFieldValue("limit", fields.limit);
        setFieldValue("description", fields.description || "");
        setFieldValue("rights", DEF_MODULE_PERMISSIONS);
      } else {
        // new
        setFieldValue("name", null);
        setFieldValue("limit", null);
        setFieldValue("description", null);
        setFieldValue("rights", DEF_MODULE_PERMISSIONS);
      }
    }
    /************************************************************************* */
    const { value: name, errorMessage: errorName } = useField("name");
    const { value: limit, errorMessage: errorLimit } = useField("limit");
    const { value: description, errorMessage: errorDescription } =
      useField("description");
    const { value: rights } = useField("rights");
    //const { value: role } = useField("permissions.role");
    //const { value: brand } = useField("permissions.brand");
    /*************************************** */
    return {
      /******* form fields   */
      name,
      errorName,
      limit,
      errorLimit,
      description,
      errorDescription,
      /*************** */
      axiosAsyncStoreReturnBool,
      axiosAsyncCallReturnData,
      formValues,
      isDirty,
      isValid,
      onSubmit,
      isSubmitting,
      customReset,
      close,
      DATA,
      emitter,
      //
      MODULE_PERMISSIONS,
      DEF_MODULE_PERMISSIONS,
      rights,
      setFieldValue,
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
    window.ROLE_NEW_MODAL.show();
    var self = this;
    this.axiosAsyncCallReturnData(
      "get",
      "common",
      {
        action: "test_query",
      },
      null,
      {
        showSuccessNotification: false,
        showCatchNotification: true,
        showProgress: true,
      }
    ).then(function (data) {
      if (data.success == true) {
        self.MODULE_PERMISSIONS = data.data;
        var module_perms = data.data;
        self.DEF_MODULE_PERMISSIONS = data.data;
        for (var key in module_perms) {
          if (module_perms.hasOwnProperty(key)) {
            self.rights[key] = {};
            for (var obj in module_perms[key]) {
              if (module_perms[key].hasOwnProperty(obj)) {
                let permission = module_perms[key][obj]["permission"];
                self.rights[key][permission] = false;
              }
            }
          }
        }
        self.setFieldValue("rights", self.rights);
      } else {
        //
      }
    });
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("newRoleModal");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>