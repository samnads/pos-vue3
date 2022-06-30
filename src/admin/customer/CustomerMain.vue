<template>
  <div id="customermain">
    <CustomerList v-if="this.$route.name == 'adminCustomerList'" />
  </div>
  <CustomerNewModal />
  <CustomerInfoModal />
</template>
<script>
import { inject } from "vue";
import CustomerList from "./CustomerList.vue";
import CustomerNewModal from "./CustomerNewModal.vue";
import CustomerInfoModal from "./CustomerInfoModal.vue";
export default {
  components: {
    CustomerList,
    CustomerNewModal,
    CustomerInfoModal,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    return {
      emitter,
    };
  },
};
</script>