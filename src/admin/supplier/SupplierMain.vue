<template>
  <div id="suppliermain">
    <SupplierList v-if="this.$route.name == 'adminSupplierList'" />
  </div>
  <SupplierNewModal />
  <SupplierInfoModal />
</template>
<script>
import { inject } from "vue";
import SupplierList from "./SupplierList.vue";
import SupplierNewModal from "./SupplierNewModal.vue";
import SupplierInfoModal from "./SupplierInfoModal.vue";
export default {
  components: {
    SupplierList,
    SupplierNewModal,
    SupplierInfoModal,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    return {
      emitter,
    };
  },
};
</script>