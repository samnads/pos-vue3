<template>
  <div id="adminProductRoute">
    <AdminProductList v-if="this.$route.name == 'adminProductList'" />
    <AdminProductNew v-if="this.$route.name == 'adminProductNew'" />
    <AdminProductDeleteConfirmModal :productData="product" />
  </div>
</template>
<style>
</style>
<script>
import AdminProductList from "./ProductList.vue";
import AdminProductNew from "./ProductNew.vue";
import AdminProductDeleteConfirmModal from "../modal/ProductDeleteModal.vue";
export default {
  components: {
    AdminProductList,
    AdminProductNew,
    AdminProductDeleteConfirmModal,
  },
  data() {
    return {
      product: {},
      hello: " - Some Dynamic Data",
    };
  },
  mounted() {},
};
</script>