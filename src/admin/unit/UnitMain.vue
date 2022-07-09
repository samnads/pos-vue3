<template>
  <div id="usermain">
    <UnitList v-if="this.$route.name == 'adminUnitList'" />
  </div>
  <UnitNewModal />
  <UnitInfoModal />
</template>
<script>
import { inject } from "vue";
import UnitList from "./UnitList.vue";
import UnitNewModal from "./UnitNewModal.vue";
import UnitInfoModal from "./UnitInfoModal.vue";
export default {
  components: {
    UnitList,
    UnitNewModal,
    UnitInfoModal,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    return {
      emitter,
    };
  },
};
</script>