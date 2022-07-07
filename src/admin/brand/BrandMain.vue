<template>
  <div id="usermain">
    <BrandList v-if="this.$route.name == 'adminBrandList'" />
  </div>
  <BrandNewModal />
  <BrandInfoModal />
</template>
<script>
import { inject } from "vue";
import BrandList from "./BrandList.vue";
import BrandNewModal from "./BrandNewModal.vue";
import BrandInfoModal from "./BrandInfoModal.vue";
export default {
  components: {
    BrandList,
    BrandNewModal,
    BrandInfoModal,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    return {
      emitter,
    };
  },
};
</script>