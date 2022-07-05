<template>
  <div id="usermain">
    <WarehouseList v-if="this.$route.name == 'adminWarehouseList'" />
  </div>
  <WarehouseNewModal />
  <WarehouseInfoModal />
</template>
<script>
import { inject } from "vue";
import WarehouseList from "./WarehouseList.vue";
import WarehouseNewModal from "./WarehouseNewModal.vue";
import WarehouseInfoModal from "./WarehouseInfoModal.vue";
export default {
  components: {
    WarehouseList,
    WarehouseNewModal,
    WarehouseInfoModal,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    return {
      emitter,
    };
  },
};
</script>