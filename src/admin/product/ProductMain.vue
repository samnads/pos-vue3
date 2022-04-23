<template>
  <div id="adminProductRoute">
    <AdminProductList v-if="this.$route.name == 'adminProductList'" />
    <AdminProductNew v-if="this.$route.name == 'adminProductNew' || this.$route.name == 'adminProductEdit' || this.$route.name == 'adminProductCopy'" />
  </div>
</template>
<style>
</style>
<script>
import AdminProductList from "./ProductList.vue";
import AdminProductNew from "./ProductNew.vue";
export default {
  components: {
    AdminProductList,
    AdminProductNew,
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