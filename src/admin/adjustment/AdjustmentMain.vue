<template>
  <div id="adjustmentmain">
    <AdjustmentList v-if="this.$route.name == 'adminProductAdjustmentList'" />
    <AdjustmentNew v-if="this.$route.name == 'adminProductAdjustmentNew'" />
  </div>
</template>
<style>
</style>
<script>
import AdjustmentList from "../adjustment/AdjustmentList.vue";
import AdjustmentNew from "../adjustment/AdjustmentNew.vue";
export default {
  components: {
    AdjustmentList,
    AdjustmentNew
  },
  data() {
    return {};
  },
  mounted() {},
};
</script>