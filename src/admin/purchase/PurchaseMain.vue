<template>
  <div id="adminProductRoute">
    <AdminPurchaseList v-if="this.$route.name == 'adminPurchaseList'" />
    <AdminPurchaseNew v-if="this.$route.name == 'adminPurchaseNew' || this.$route.name == 'adminPurchaseEdit'" />
  </div>
</template>
<style>
</style>
<script>
import AdminPurchaseList from "./PurchaseList.vue";
import AdminPurchaseNew from "./PurchaseNew.vue";
export default {
  components: {
    AdminPurchaseList,
    AdminPurchaseNew,
  },
  data() {
    return {};
  },
  mounted() {},
};
</script>