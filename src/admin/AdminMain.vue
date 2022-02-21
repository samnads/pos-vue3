<template>
  <div class="header">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" v-show="this.$route.name !== 'adminLogin'">
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
                <li><router-link class="dropdown-item" to="/admin/products">List All</router-link></li>
                <li><router-link class="dropdown-item" to="/admin/products/new">Add New</router-link></li>
                <li><router-link class="dropdown-item" to="/admin/products/adjustments">Adjustments</router-link></li>
                <li><router-link class="dropdown-item" to="/admin/products/adjustments/new">Add Adjustment</router-link></li>
                <li><router-link class="dropdown-item" to="/admin/products/import">Import via CSV</router-link></li>
                <li><hr class="dropdown-divider" /></li>
                <li><router-link class="dropdown-item" to="/admin/products/label">Import via CSV</router-link></li>
              </ul>
            </li>
           <li><router-link class="nav-link" to="/admin/login">Login</router-link></li>
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
  <div id="content">
    <router-view></router-view>
  </div>
  <footer class="footer mt-auto py-3 bg-light">
    <div class="container">
      <span class="text-muted">&copy; CyberLikes</span>
    </div>
  </footer>
</template>
<style>
#content {
  margin-top: 56px;
  min-height: calc(100vh - 112px) !important;
}
</style>
<script>

</script>

