<template>
  <div id="">
    <AdjustmentList v-if="this.$route.name == 'adminProductAdjustmentList'" />
    <AdjustmentDetailsModal />
  </div>
</template>
<style>
</style>
<script>
import AdjustmentList from "../adjustment/AdjustmentList.vue";
import AdjustmentDetailsModal from "../modal/AdjustmentDetailsModal.vue";
import { Modal } from "bootstrap";
export default {
  components: {
    AdjustmentList,
    AdjustmentDetailsModal
  },
  data() {
    return {
    };
  },
  mounted() {
    window.PROD_ADJ_DETAILS_MODAL = new Modal($("#prodAdjDetailsModal"), {
      backdrop: true,
      show: true,
    });
  },
};
</script>