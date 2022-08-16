<template>
  <div id="adminProductRoute">
    <AdminSalePosList v-if="this.$route.name == 'adminSalePosList'" />
  </div>
</template>
<style>
</style>
<script>
import AdminSalePosList from "./SalePosList.vue";
export default {
  components: {
    AdminSalePosList,
  },
  data() {
    return {
    };
  },
  mounted() {},
};
</script>