<template>
  <div id="adminProductRoute">
    <AdminProductList v-if="this.$route.name == 'adminProductList'" />
    <AdminProductNew v-if="this.$route.name == 'adminProductNew'" />
    <AdminProductDetailsModal :productData="product" />
    <AdminProductNewCategoryModal />
    <AdminProductDeleteConfirmModal :productData="product" />
  </div>
</template>
<style>
</style>
<script>
import AdminProductList from "./ProductList.vue";
import AdminProductNew from "./ProductNew.vue";
import AdminProductDetailsModal from "./ProductDetailsModal.vue";
import AdminProductNewCategoryModal from "./CategoryNewModal.vue";
import AdminProductDeleteConfirmModal from "./ProductDelete.vue";
import { Modal } from "bootstrap";
export default {
  components: {
    AdminProductList,
    AdminProductNew,
    AdminProductDetailsModal,
    AdminProductDeleteConfirmModal,
    AdminProductNewCategoryModal,
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
    window.PROD_NEW_CATEGORY_MODAL = new Modal($("#prodNewCategoryModal"), {
      backdrop: true,
      show: true,
    });
  },
};
</script>