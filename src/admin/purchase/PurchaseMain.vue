<template>
  <div id="adminProductRoute">
    <AdminPurchaseList v-if="this.$route.name == 'adminPurchaseList'" />
    <AdminPurchaseNew v-if="this.$route.name == 'adminPurchaseNew'" />
    <AdminPurchaseEdit v-if="this.$route.name == 'adminPurchaseEdit'" />
  </div>
</template>
<style>
</style>
<script>
import AdminPurchaseList from "./PurchaseList.vue";
import AdminPurchaseNew from "./PurchaseNew.vue";
import AdminPurchaseEdit from "./PurchaseNew.vue";
export default {
  components: {
    AdminPurchaseList,
    AdminPurchaseNew,
    AdminPurchaseEdit,
  },
  data() {
    return {};
  },
  mounted() {},
};
</script>