<template>
  <div id="adminProductRoute">
    <AdminPurchaseList v-if="this.$route.name == 'adminPurchaseList'" />
    <AdminPurchaseNew v-if="this.$route.name == 'adminPurchaseNew'" />
    <AdminPurchaseEdit v-if="this.$route.name == 'adminPurchaseEdit'" />

    <AdminPurchaseReturnList v-if="this.$route.name == 'adminPurchaseReturnList'" />
    <AdminPurchaseReturnNew v-if="this.$route.name == 'adminPurchaseReturnNew'" />
  </div>
</template>
<style>
</style>
<script>
import AdminPurchaseList from "./PurchaseList.vue";
import AdminPurchaseNew from "./PurchaseNew.vue";
import AdminPurchaseEdit from "./PurchaseNew.vue";
import AdminPurchaseReturnList from "./PurchaseList.vue";
import AdminPurchaseReturnNew from "./PurchaseNew.vue";
export default {
  components: {
    AdminPurchaseList,
    AdminPurchaseNew,
    AdminPurchaseEdit,
    AdminPurchaseReturnList,
    AdminPurchaseReturnNew
  },
  data() {
    return {};
  },
  mounted() {},
};
</script>