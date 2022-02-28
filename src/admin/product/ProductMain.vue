<template>
  <div id="adminProductRoute">
    <AdminProductList v-if="this.$route.name == 'adminProductList'" />
    <AdminProductNew v-if="this.$route.name == 'adminProductNew'" />
    <AdminProductDetailsModal :productData="product" />
    <AdminProductDeleteConfirmModal :productData="product" />
  </div>
</template>
<style>
#adminProductRoute .modal-header {
  background-color: rgb(41, 41, 41);
  color: #fff;
}
#adminProductRoute .modal-header .btn-close {
  background-color: #4d4d4d;
}
</style>
<script>
import AdminProductList from "./ProductList.vue";
import AdminProductNew from "./ProductNew.vue";
import AdminProductDetailsModal from "./ProductDetails.vue";
import AdminProductDeleteConfirmModal from "./ProductDelete.vue";
import { Modal } from "bootstrap";
export default {
  components: {
    AdminProductList,
    AdminProductNew,
    AdminProductDetailsModal,
    AdminProductDeleteConfirmModal,
  },
  data() {
    return {
      product: {},
    };
  },
  mounted() {
    window.PROD_DETAILS_MODAL = new Modal($("#detailsModal"), {
      backdrop: true,
      show: true,
    });
    window.PROD_DELETE_MODAL = new Modal($("#deleteModal"), {
      backdrop: true,
      show: true,
    });
    
  },
};
</script>