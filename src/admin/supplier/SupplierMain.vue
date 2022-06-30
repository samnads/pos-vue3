<template>
  <div id="suppliermain">
    <SupplierList v-if="this.$route.name == 'adminSupplierList'" />
    <SupplierNew v-if="this.$route.name == 'adminSupplierNew'" />
    <SupplierEdit v-if="this.$route.name == 'adminSupplierEdit'" />
  </div>
  <SupplierNewModal />
  <SupplierInfoModal />
</template>
<style>
</style>
<script>
import { inject } from "vue";
//
import SupplierList from "../supplier/SupplierList.vue";
import SupplierNew from "../supplier/SupplierNew.vue";
import SupplierEdit from "../supplier/SupplierNew.vue";
//
import SupplierNewModal from "./SupplierNewModal.vue";
import SupplierInfoModal from "./SupplierInfoModal.vue";
export default {
  components: {
    SupplierList,
    SupplierNew,
    SupplierEdit,
    SupplierNewModal,
    SupplierInfoModal,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    return {
      emitter,
    };
  },
  mounted() {
  },
};
</script>