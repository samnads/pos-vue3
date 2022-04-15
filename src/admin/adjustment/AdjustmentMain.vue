<template>
  <div id="adjustmentmain">
    <AdjustmentList v-if="this.$route.name == 'adminProductAdjustmentList'" />
  </div>
</template>
<style>
</style>
<script>
import AdjustmentList from "../adjustment/AdjustmentList.vue";
export default {
  components: {
    AdjustmentList,
  },
  data() {
    return {};
  },
  mounted() {},
};
</script>