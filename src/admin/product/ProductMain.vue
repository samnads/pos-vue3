<template>
  <div id="adminProductRoute">
    <router-view></router-view>
    <AdminProductDetails  />
    <AdminProductDeleteConfirmModal />
  </div>
</template>
<style>
#adminProductRoute .modal-header {
  background-color: rgb(41, 41, 41);
  color:#fff;
}
#adminProductRoute .modal-header .btn-close {
  background-color: #4d4d4d;
}
</style>
<script>
import AdminProductDetails from "./ProductDetails.vue";
import AdminProductDeleteConfirmModal from "./ProductDelete.vue";
import { Modal } from "bootstrap";
export default {
  components: {
     AdminProductDetails,
     AdminProductDeleteConfirmModal,
  },
  mounted() {
    window.PROD_DETAILS_MODAL = new Modal($("#detailsModal"), {backdrop:true,show:true});
    window.PROD_DELETE_MODAL = new Modal($("#deleteModal"), {backdrop:true,show:true});
  },
};
</script>