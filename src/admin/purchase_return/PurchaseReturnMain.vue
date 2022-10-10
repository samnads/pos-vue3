<template>
  <div id="adminProductRoute">
    <AdminPurchaseReturnList
      v-if="this.$route.name == 'adminPurchaseReturnList'"
    />
    <AdminPurchaseReturnNew
      v-if="this.$route.name == 'adminPurchaseReturnNew'"
    />
    <AdminPurchaseReturnEdit
      v-if="this.$route.name == 'adminPurchaseReturnEdit'"
    />
  </div>
</template>
<style>
</style>
<script>
import AdminPurchaseReturnList from "./PurchaseReturnList.vue";
import AdminPurchaseReturnNew from "./PurchaseReturnNew.vue";
import AdminPurchaseReturnEdit from "./PurchaseReturnNew.vue";
export default {
  components: {
    AdminPurchaseReturnList,
    AdminPurchaseReturnNew,
    AdminPurchaseReturnEdit,
  },
  data() {
    return {};
  },
  mounted() {},
};
</script>