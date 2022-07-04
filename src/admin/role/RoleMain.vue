<template>
  <div id="usermain">
    <RoleList v-if="this.$route.name == 'adminRoleList'" />
  </div>
  <RoleNewModal />
  <RoleInfoModal />
</template>
<script>
import { inject } from "vue";
import RoleList from "./RoleList.vue";
import RoleNewModal from "./RoleNewModal.vue";
import RoleInfoModal from "./RoleInfoModal.vue";
export default {
  components: {
    RoleList,
    RoleNewModal,
    RoleInfoModal,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    return {
      emitter,
    };
  },
};
</script>