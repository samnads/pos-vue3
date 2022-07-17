<template>
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-user-plus"></i><span>New Role</span>
        </h5>
      </div>
      <div class="p-2 bd-highlight"><span id="buttons"></span></div>
      <div class="p-2 bd-highlight">
        <input
          class="form-control"
          id="search"
          type="search"
          placeholder="Search..."
        />
      </div>
    </div>
  </div>
  <div class="wrap_content" id="wrap_content">
    <form @submit="onSubmit" class="needs-validation">
      <div class="row">
        <div class="col">
          <label class="form-label">Role Name<i>*</i></label>
          <input
            type="text"
            name="name"
            v-model="name"
            class="form-control"
            v-bind:class="[
              errorName ? 'is-invalid' : !errorName && name ? 'is-valid' : '',
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
      <AdminLoadingSpinnerDiv v-if="!Object.keys(MODULE_PERMISSIONS).length" />
      <div class="row">
        <div
          class="col-xxl-3 col-xl-4 col-sm-6 mb-2"
          v-for="(row, key) in MODULE_PERMISSIONS"
          :key="key"
        >
          <div class="col">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link active text-light"
                  data-bs-toggle="tab"
                  data-bs-target="#home"
                  role="tab"
                  aria-controls="home"
                  aria-selected="true"
                >
                  <span class="text-capitalize">{{
                    row[0]["module_name"].replace(/_/g, " ")
                  }}</span>
                </a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div
                class="tab-pane fade show active boder-dark"
                id="home"
                role="tabpanel"
              >
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    :id="row[0]['module_name']"
                    v-model="toggle_module[row[0]['module']]"
                    @change="
                      select_all_perm(
                        row[0]['module'],
                        toggle_module[row[0]['module']]
                      )
                    "
                  />
                  <label class="form-check-label" :for="row[0]['module_name']">
                    Select All
                  </label>
                </div>
                <hr />
                <div class="row">
                  <div
                    v-for="(permObj, permKey) in row"
                    :key="permKey"
                    class="col-md-6 text-capitalize mt-3"
                  >
                    <div class="form-check form-switch">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        v-model="
                          rights[permObj['module']][permObj['permission']]
                        "
                        @change="
                          select_single_perm(
                            permObj['module'],
                            permObj['permission'],
                            rights[permObj['module']][permObj['permission']]
                          )
                        "
                        :id="
                          row[0]['module_name'] +
                          '_' +
                          permObj['permission_name']
                        "
                        :disabled="permObj['disabled']"
                      />
                      <label
                        class="form-check-label"
                        :for="
                          row[0]['module_name'] +
                          '_' +
                          permObj['permission_name']
                        "
                        >{{ permObj["usage"] }}</label
                      >
                    </div>
                  </div>
                </div>
                <hr v-if="row[0]['module_descriptionX']" />
                <div
                  class="tab-pane fade show active"
                  id="home"
                  role="tabpanel"
                >
                  {{ row[0]["module_descriptionX"] }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="m-1 row">
        <p class="text-muted small">
          <span class="text-danger">*</span>&nbsp;Marked fields are mandatory.
        </p>
      </div>
      <div class="d-flex">
        <div class="me-auto">
          <button
            type="submit"
            class="btn"
            :disabled="isSubmitting || !isDirty || !MODULE_PERMISSIONS"
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
        <div class="">
          <button
            type="button"
            class="btn btn-secondary icon"
            :disabled="isSubmitting || !isDirty"
            @click="customReset"
          >
            <i class="fa-solid fa-rotate-left"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
</template>
<style>
.tab-content {
  padding: 0.5rem;
  background-color: #ececec;
  border: 1px solid #448b8d;
  border-bottom-left-radius: 0.25rem;
  border-bottom-right-radius: 0.25rem;
  border-top-right-radius: 0.25rem;
}
.tab-content hr {
  margin-top: 0.5rem !important;
  margin-bottom: 0.5rem !important;
  border-top: 1px solid rgb(68 139 141 / 20%);
}
.nav-tabs {
  border-bottom: none !important;
}
.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
  color: #ffffff;
  background-color: #5f9ea0 !important;
  border-color: #448b8d #448b8d #448b8d !important;
  border-bottom: 0px;
}
</style>
<script>
/* eslint-disable */
import {
  useForm,
  useField,
  useIsFormDirty,
  useIsFormValid,
} from "vee-validate";
import * as yup from "yup";
import { ref, computed } from "vue";
import admin from "@/mixins/admin.js";
import { useRouter, useRoute } from "vue-router";
export default {
  setup() {
    const route = useRoute();
    const router = useRouter();
    const DATA = ref({});
    const { axiosAsyncCallReturnData, axiosAsyncStoreReturnBool } = admin();
    /************************************************************************* */
    const toggle_module = ref([]); // toggle select all check box array
    const MODULE_PERMISSIONS = ref({}); // available module permissions
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
        rights: yup.object().required().label("Rights"),
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
    /************************************************************************* */
    // eslint-disable-next-line
    function onInvalidSubmit({ values, errors, results }) {
      console.log(values);
    }
    const onSubmit = handleSubmit((values, { resetForm }) => {
      values.db = DATA.value;
      let method = route.name == "adminRoleNew" ? "post" : "put";
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
          action: "create",
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
          //
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
    const { value: name, errorMessage: errorName } = useField("name");
    const { value: limit, errorMessage: errorLimit } = useField("limit");
    const { value: description, errorMessage: errorDescription } =
      useField("description");
    const { value: rights } = useField("rights");
    /*************************************** */
    const select_all_perm = function (module, ischecked) {
      MODULE_PERMISSIONS.value[module].forEach((element) => {
        // do check all respective perms
        rights.value[module][element["permission"]] = ischecked;
      });
    };
    const select_single_perm = function (modulee, permission, ischecked) {
      var checked = true;
      MODULE_PERMISSIONS.value[modulee].forEach((element) => {
        if ((rights.value[modulee][element["permission"]] == true) & checked) {
        } else {
          checked = false;
        }
      });
      if (checked) {
        toggle_module.value[modulee] = true;
      } else {
        toggle_module.value[modulee] = false;
      }
    };
    function customReset() {
      resetForm();
      for (var key in MODULE_PERMISSIONS.value) {
        toggle_module.value[key] = false;
        if (MODULE_PERMISSIONS.value.hasOwnProperty(key)) {
          rights.value[key] = {};
          for (var obj in MODULE_PERMISSIONS.value[key]) {
            if (MODULE_PERMISSIONS.value[key].hasOwnProperty(obj)) {
              let permission = MODULE_PERMISSIONS.value[key][obj]["permission"];
              rights.value[key][permission] = false;
              if (route.name == "adminRoleNew") {
                rights.value[key][permission] = MODULE_PERMISSIONS.value[key][
                  obj
                ]["checked"]
                  ? true
                  : false; // default check or uncheck
              } else if (route.name == "adminRoleEdit") {
                rights.value[key][permission] = MODULE_PERMISSIONS.value[key][
                  obj
                ]["allow"]
                  ? true
                  : false; // db check or uncheck;
              }
            }
          }
        }
      }
      if (route.name == "adminRoleNew") {
      } else if (route.name == "adminRoleEdit") {
        setFieldValue("name", DATA.value.name);
        setFieldValue("limit", DATA.value.limit);
        setFieldValue("description", DATA.value.description || undefined);
      }
    }
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
      DATA,
      //
      MODULE_PERMISSIONS,
      rights,
      setFieldValue,
      select_all_perm,
      select_single_perm,
      toggle_module,
      resetForm,
      customReset,
      route,
      router,
    };
  },
  data() {
    return {};
  },
  mounted() {
    var self = this;
    this.axiosAsyncCallReturnData(
      self.route.name == "adminRoleNew" ? "POST" : "PUT",
      "role",
      {
        action: "create",
        job:
          self.route.name == "adminRoleNew"
            ? "module_permission"
            : "module_permission_role_permission",
        id:
          self.route.name == "adminRoleNew" ? undefined : self.route.params.id,
      },
      null,
      {
        showSuccessNotification: false,
        showCatchNotification: true,
        showProgress: true,
      }
    ).then(function (response) {
      if (response.success == true) {
        var data = response.data;
        self.MODULE_PERMISSIONS = data.rights;
        var module_perms = data.rights;
        self.MODULE_PERMISSIONS = data.rights;
        for (var key in module_perms) {
          if (module_perms.hasOwnProperty(key)) {
            self.rights[key] = {};
            for (var obj in module_perms[key]) {
              if (module_perms[key].hasOwnProperty(obj)) {
                let permission = module_perms[key][obj]["permission"];
                if (self.route.name == "adminRoleNew") {
                  self.rights[key][permission] = module_perms[key][obj][
                    "checked"
                  ]
                    ? true
                    : false; // default check or uncheck
                } else if (self.route.name == "adminRoleEdit") {
                  self.rights[key][permission] = module_perms[key][obj]["allow"]
                    ? true
                    : false; // db check or uncheck;
                  self.DATA = data;
                }
              }
            }
          }
        }
        self.setFieldValue("name", data.name);
        self.setFieldValue("limit", data.limit);
        self.setFieldValue("description", data.description || undefined);
      }
    });
  },
  beforeUnmount() {},
};
</script>