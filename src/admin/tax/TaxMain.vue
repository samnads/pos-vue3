<template>
  <div id="usermain">
    <TaxList v-if="this.$route.name == 'adminTaxList'" />
  </div>
  <TaxNewModal />
  <TaxInfoModal />
</template>
<script>
import { inject } from "vue";
import TaxList from "./TaxList.vue";
import TaxNewModal from "./TaxNewModal.vue";
import TaxInfoModal from "./TaxInfoModal.vue";
export default {
  components: {
    TaxList,
    TaxNewModal,
    TaxInfoModal,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    return {
      emitter,
    };
  },
};
</script>