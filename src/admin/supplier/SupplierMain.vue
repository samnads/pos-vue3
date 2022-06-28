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
import { Modal } from "bootstrap";
//
import SupplierList from "../supplier/SupplierList.vue";
import SupplierNew from "../supplier/SupplierNew.vue";
import SupplierEdit from "../supplier/SupplierNew.vue";
//
import SupplierNewModal from "../modal/SupplierNewModal.vue";
import SupplierInfoModal from "../modal/SupplierInfoModal.vue";
export default {
  components: {
    SupplierList,
    SupplierNew,
    SupplierEdit,
    SupplierNewModal,
    SupplierInfoModal,
  },
  mounted() {
    window.SUPPLIER_NEW_MODAL = new Modal($("#supplierNewModal"), {
      backdrop: true,
      show: true,
    });
    window.SUPPLIER_INFO_MODAL = new Modal($("#supplierInfoModal"), {
      backdrop: true,
      show: true,
    });
  },
};
</script>