<template>
  <div id="adjustmentmain">
    <AdjustmentList v-if="this.$route.name == 'adminProductAdjustmentList'" />
    <AdjustmentNew v-if="this.$route.name == 'adminProductAdjustmentNew'" />
    <AdjustmentEdit v-if="this.$route.name == 'adminProductAdjustmentEdit'" />
  </div>
</template>
<style>
</style>
<script>
import AdjustmentList from "../adjustment/AdjustmentList.vue";
import AdjustmentNew from "../adjustment/AdjustmentNew.vue";
import AdjustmentEdit from "../adjustment/AdjustmentNew.vue";
export default {
  components: {
    AdjustmentList,
    AdjustmentNew,
    AdjustmentEdit,
  },
  data() {
    return {};
  },
  mounted() {},
};
</script>