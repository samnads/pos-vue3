<template>
  <router-view></router-view>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>
  <AdminProductDetails />
</template>
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
import AdminProductDetails from "./ProductDetails.vue";
export default {
  components: {
    AdminProductDetails,
  }
}
</script>

