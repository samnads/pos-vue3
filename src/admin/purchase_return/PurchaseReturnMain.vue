<template>
  <div id="adminProductRoute">
    <AdminPurchaseReturnList v-if="this.$route.name == 'adminPurchaseReturnList'" />
    <AdminPurchaseReturnNew v-if="this.$route.name == 'adminPurchaseReturnNew'" />
  </div>
</template>
<style>
</style>
<script>
import AdminPurchaseReturnList from "./PurchaseReturnList.vue";
import AdminPurchaseReturnNew from "./PurchaseReturnNew.vue";
export default {
  components: {
    AdminPurchaseReturnList,
    AdminPurchaseReturnNew
  },
  data() {
    return {};
  },
  mounted() {},
};
</script>