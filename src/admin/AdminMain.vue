<template>
  <vue-progress-bar></vue-progress-bar>
  <AlertBoxDefault />
  <DeleteConfirmModalDefault />
  <PlaySound />
  <div class="header">
    <nav
      class="navbar navbar-expand-md navbar-dark fixed-top bg-dark"
      v-if="this.$route.name !== 'adminLogin'"
    >
      <div class="container-fluid">
        <a class="navbar-brand" href="#">POS</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarCollapse"
          aria-controls="navbarCollapse"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link disabled">Dashboard</a>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Products
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                  <router-link class="dropdown-item" to="/admin/product/list"
                    >List All</router-link
                  >
                </li>
                <li>
                  <router-link class="dropdown-item" to="/admin/product/new"
                    >Add New</router-link
                  >
                </li>
                <li>
                  <router-link class="dropdown-item" to="/admin/adjustment/list"
                    >Adjustments</router-link
                  >
                </li>
                <li>
                  <router-link class="dropdown-item" to="/admin/adjustment/new"
                    >Add Adjustment</router-link
                  >
                </li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <router-link class="dropdown-item" to="/admin/product/label"
                    >Print Labels</router-link
                  >
                </li>
              </ul>
            </li>
            <li>
              <router-link class="nav-link" to="/admin/category/list"
                >Categories</router-link
              >
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Contacts
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                  <router-link class="dropdown-item" to="/admin/supplier/list"
                    >Suppliers</router-link
                  >
                </li>
                <li>
                  <router-link class="dropdown-item" to="/admin/customer/list"
                    >Customers</router-link
                  >
                </li>
              </ul>
            </li>
            <li>
              <router-link class="nav-link" to="/admin/user/list"
                >Users</router-link
              >
            </li>
            <li>
              <router-link class="nav-link" to="/admin/role/list"
                >Roles</router-link
              >
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Settings
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                  <router-link class="dropdown-item" to="/admin/warehouse/list"
                    >Warehouses</router-link
                  >
                </li>
                <li>
                  <router-link class="dropdown-item" to="/admin/brand/list"
                    >Brands</router-link
                  >
                </li>
                <li>
                  <router-link class="dropdown-item" to="/admin/unit/list"
                    >Units</router-link
                  >
                </li>
                <li>
                  <router-link class="dropdown-item" to="/admin/tax/list"
                    >Tax</router-link
                  >
                </li>
              </ul>
            </li>
          </ul>
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0 dropdown">
              <a
                href="#"
                class="d-block link-dark text-decoration-none dropdown-toggle"
                id="dropdownUser2"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <img
                  src="https://avatars.githubusercontent.com/u/10187201?v=4"
                  width="32"
                  height="32"
                  class="rounded-circle"
                />
              </a>
              <ul
                class="dropdown-menu dropdown-menu-end text-small shadow"
                aria-labelledby="dropdownUser2"
              >
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li v-on:click="logout()">
                  <a class="dropdown-item" href="#">Sign out</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
  <div id="content" class="pt-2">
    <div class="container-fluid">
      <router-view></router-view>
    </div>
  </div>
  <notifications
    group="general"
    position="bottom center"
    animation-type="css"
    :max="general.max"
    :closeOnClick="general.closeOnClick"
  />
  <footer class="footer mt-auto py-3 bg-light fixed-bottom">
    <div class="container text-center">
      <span class="text-muted">&copy; CyberLikes 2022</span>
    </div>
  </footer>
</template>
<style>
#content {
  margin-top: 56px;
  margin-bottom: 56px;
  min-height: calc(100vh - 112px) !important;
}
/********************************* HIDE SCROLL  */
body {
    -ms-overflow-style: none;  /* Internet Explorer 10+ */
    scrollbar-width: none;  /* Firefox */
}
body::-webkit-scrollbar { 
    display: none;  /* Safari and Chrome */
}
/*********************************/
a {
  text-decoration: none !important;
}
/* MENU BAR STYLEES */
.menubar {
  border-top-left-radius: 0.25rem !important;
  border-top-right-radius: 0.25rem !important;
  background-color: #5f9ea0;
  color: #fff;
}
.menubar .dt-buttons.btn-group .btn {
  border: 1px solid #ced4da !important;
}
.menubar .bi {
  margin-right: 10px;
}
.menubar .title span:before {
  margin-left: 10px;
  margin-right: 10px;
  content: "|";
  font-style: normal;
}
/* MENU CONTENT STYLES */
#wrap_content {
  padding: 10px;
  background-color: #e9e9e9;
  border-bottom-left-radius: 0.25rem !important;
  border-bottom-right-radius: 0.25rem !important;
  min-height: calc(100vh - 175px) !important;
}
/* DATA TABLE STYLES */
/* hide because the default button location is shown while loading */
#datatable_wrapper tbody {
  background-color: white;
}
#datatable_wrapper > .dt-buttons {
  display: none;
}
/* change table header row color */
#datatable_wrapper table.dataTable > thead {
  background-color: #072f49 !important;
  color: ivory;
}
#datatable_wrapper table.dataTable {
  margin-top: 0px !important;
}
#datatable_wrapper tbody tr:hover {
  background-color: rgba(0, 0, 0, 0.13);
}
/* selected row color */
#datatable_wrapper table tbody > tr.selected {
  background-color: #8197a6 !important;
  color: #fff !important;
}
/* action menu styles */
#datatable_wrapper table tbody > tr .dropdown .dropdown-item > svg {
  margin-right: 10px;
}
#datatable_wrapper table.dataTable > tbody > tr > td[class*="sorting_"] {
  background-color: rgb(0 0 0 / 10%);
}
/* pagination */
.page-item.active .page-link {
  background-color: #5f9ea0 !important;
  border-color: #5f9ea0 !important;
}
.page-link {
  color: darkslategray !important;
}
.page-item.active .page-link {
  color: #fff !important;
}
/* for all modal footer buttons */
.modal-footer .btn:not(.icon) svg {
  /* icon is for icon only button */
  padding-right: 5px;
}
.modal-title svg {
  /* icon is for icon only button */
  padding-right: 15px;
}
/* from control styles */
label {
  font-weight: bold;
}
label > i {
  font-style: normal;
  color: red;
}
label > i:before {
  content: " ";
}
.form-label {
  margin-bottom: 0.1rem !important;
}
form .row {
  margin-bottom: 0.4rem !important;
}
/* notification contaier */
.vue-notification-group {
  margin-bottom: 100px;
}
.vue-notification .notification-content {
  font-size: 18px;
}
.vue-notification {
  margin: 0 5px 5px;
  padding: 10px;
  font-size: 15px;
  background: #44a4fc;
  border-left: 5px solid #187fe7;
}
.vue-notification.primary {
  background: #cfe2ff;
  color: #084298;
  border-left-color: #b6d4fe;
}
.vue-notification.secondary {
  color: #41464b;
  background-color: #e2e3e5;
  border-left-color: #d3d6d8;
}
.vue-notification.success {
  color: #0f5132;
  background-color: #d1e7dd;
  border-left-color: #badbcc;
}
.vue-notification.danger {
  color: #842029;
  background-color: #f8d7da;
  border-left-color: #f5c2c7;
}
.vue-notification.warning {
  color: #664d03;
  background-color: #fff3cd;
  border-left-color: #ffecb5;
}
.vue-notification.info {
  color: #055160;
  background-color: #cff4fc;
  border-left-color: #b6effb;
}
.vue-notification.light {
  color: #636464;
  background-color: #fefefe;
  border-left-color: #fdfdfe;
}
.vue-notification.dark {
  color: #141619;
  background-color: #d3d3d4;
  border-left-color: #bcbebf;
}
.modal-header {
  background-color: #000000;
  color: #dee2e6;
}
/***************************************************************  input field custom */
/***************************  dont show up-down button on number inputs */
/* Chrome, Safari, Edge, Opera */
input[type="number"].no-arrow::-webkit-outer-spin-button,
input[type="number"].no-arrow::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
/* Firefox */
input[type="number"].no-arrow {
  -moz-appearance: textfield;
}
/***************************************************************  disabled things */
</style>
<script>
import "datatables.net-bs5/js/dataTables.bootstrap5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import "datatables.net-buttons-bs5/js/buttons.bootstrap5";
import "datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css";
import "datatables.net-buttons/js/buttons.colVis";
import "datatables.net-buttons/js/dataTables.buttons";
import "datatables.net-buttons/js/buttons.flash";
import "datatables.net-buttons/js/buttons.print";
import "datatables.net-buttons/js/buttons.html5";
import "datatables.net-select-bs5/css/select.bootstrap5.css";
import "datatables.net-select-bs5/js/select.bootstrap5";
// for pdf download from datatable
import pdfMake from "pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
pdfMake.vfs = pdfFonts.pdfMake.vfs;
// because datatable not showing excel button
import jsZip from "jszip";
window.JSZip = jsZip;
//
import { Modal } from "bootstrap";
import AlertBoxDefault from "./modal/AlertBoxDefault.vue";
import DeleteConfirmModalDefault from "./modal/DeleteConfirmModalDefault.vue";
import PlaySound from "../admin/PlaySound.vue";
import admin from "@/mixins/admin.js";
import { ref } from "vue";
export default {
  components: {
    AlertBoxDefault,
    DeleteConfirmModalDefault,
    PlaySound,
  },
  setup() {
    const alertModalTitle = ref("");
    const alertModalBody = ref("");
    const { axiosAsyncCallReturnData, notifyCatchResponse } = admin();
    return {
      axiosAsyncCallReturnData,
      notifyCatchResponse,
      alertModalTitle,
      alertModalBody,
    };
  },
  data: function () {
    return {
      // for notify
      general: { closeOnClick: false, max: 3 },
    };
  },
  methods: {
    logout() {
      var self = this;
      self
        .axiosAsyncCallReturnData(
          "post",
          "auth",
          {
            action: "logout",
          },
          null,
          {
            showSuccessNotification: false,
            showCatchNotification: false,
            showProgress: true,
          }
        )
        .then(function (data) {
          if (data.success == true) {
            console.log(data);
            // ok
          } else {
            if (data.success == false) {
              // not ok
            } else {
              // other error
              if (data.message != "canceled") {
                self.notifyCatchResponse({ title: data.message });
              }
            }
          }
        });
    },
  },
  mounted() {
    //  [App.vue specific] When App.vue is finish loading finish the progress bar
    this.$Progress.finish();
    // alert box default
    window.ALERT_DEFAULT_MODAL = new Modal($("#alertDefModal"), {
      backdrop: true,
      show: true,
    });
    // delete confirm modal default
    window.DELETE_CONFIRM_DEFAULT_MODAL = new Modal($("#deleteConfirmModal"), {
      backdrop: true,
      show: true,
    });
  },
  created() {
    /* eslint-disable */
    //  [App.vue specific] When App.vue is first loaded start the progress bar
    this.$Progress.start();
    //  hook the progress bar to start before we move router-view
    this.$router.beforeEach((to, from, next) => {
      //  does the page we want to go to have a meta.progress object
      if (to.meta.progress !== undefined) {
        let meta = to.meta.progress;
        // parse meta tags
        this.$Progress.parseMeta(meta);
      }
      //  start the progress bar
      this.$Progress.start();
      //  continue to next page
      next();
    });
    //  hook the progress bar to finish after we've finished moving router-view
    this.$router.afterEach((to, from) => {
      //  finish the progress bar
      this.$Progress.finish();
    });
  },
};
</script>

