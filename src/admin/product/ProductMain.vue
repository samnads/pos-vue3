<template>
  <div id="adminProductRoute">
    <AdminProductList v-if="this.$route.name == 'adminProductList'" />
    <AdminProductNew v-if="this.$route.name == 'adminProductNew'" />
    <AdminProductEdit v-if="this.$route.name == 'adminProductEdit'" />
    <AdminProductCopy v-if="this.$route.name == 'adminProductCopy'" />
    <ProductInfoModal />
  </div>
</template>
<style>
</style>
<script>
import AdminProductList from "./ProductList.vue";
import AdminProductNew from "./ProductNew.vue";
import AdminProductEdit from "./ProductNew.vue";
import AdminProductCopy from "./ProductNew.vue";
import ProductInfoModal from "./ProductInfoModal.vue";
export default {
  components: {
    AdminProductList,
    AdminProductNew,
    AdminProductEdit,
    AdminProductCopy,
    ProductInfoModal
  },
  data() {
    return {
    };
  },
  mounted() {},
};
</script>