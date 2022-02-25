<template>
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
              <a class="nav-link active" aria-current="page" href="#">Test</a>
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
                  <router-link
                    class="dropdown-item"
                    to="/admin/product/adjustments"
                    >Adjustments</router-link
                  >
                </li>
                <li>
                  <router-link
                    class="dropdown-item"
                    to="/admin/product/adjustments/new"
                    >Add Adjustment</router-link
                  >
                </li>
                <li>
                  <router-link class="dropdown-item" to="/admin/product/import"
                    >Import via CSV</router-link
                  >
                </li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <router-link class="dropdown-item" to="/admin/product/label"
                    >Import via CSV</router-link
                  >
                </li>
              </ul>
            </li>
            <li>
              <router-link class="nav-link" to="/admin/login"
                >Login</router-link
              >
            </li>
            <li class="nav-item">
              <a class="nav-link disabled">Contacts</a>
            </li>
          </ul>
          <form class="d-flex">
            <input
              class="form-control me-2"
              type="search"
              placeholder="Search"
              aria-label="Search"
            />
            <button class="btn btn-outline-success" type="submit">
              Search
            </button>
          </form>
        </div>
      </div>
    </nav>
  </div>
  <div id="content" class="pt-2">
    <div class="container-fluid">
      <router-view></router-view>
    </div>
  </div>
  <footer class="footer mt-auto py-3 bg-light">
    <div class="container text-center">
      <span class="text-muted">&copy; CyberLikes</span>
    </div>
  </footer>
</template>
<style>
#content {
  margin-top: 56px;
  min-height: calc(100vh - 112px) !important;
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
.menubar .title i:after {
  margin-left: 10px;
  content: " | ";
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
}
/* action menu styles */
#datatable_wrapper table tbody > tr .dropdown .dropdown-item > svg {
  margin-right: 10px;;
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
.btn > svg {
  margin-right: 10px;
}
</style>
<script>
import "datatables.net-bs5/js/dataTables.bootstrap5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import "datatables.net-buttons-bs5/js/buttons.bootstrap5";
import "datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css";
import "datatables.net-buttons/js/buttons.colVis";
import "datatables.net-buttons/js/buttons.flash";
import "datatables.net-buttons/js/buttons.html5";
import "datatables.net-buttons/js/buttons.print";
import "datatables.net-buttons/js/dataTables.buttons";
import "datatables.net-select-bs5/css/select.bootstrap5.css";
import "datatables.net-select-bs5/js/select.bootstrap5";

export default {
  props: ["mytest"],
   emits: ["enlargeText"],
  components: {},
  data: function () {
    return {
      user: "",
    };
  },
  methods: {
    initLoad() {},
  },
  created() {
    this.initLoad();
  },
  mounted() {

  },
};
</script>

