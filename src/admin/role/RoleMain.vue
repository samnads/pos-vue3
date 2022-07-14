<template>
  <div id="usermain">
    <RoleList v-if="this.$route.name == 'adminRoleList'" />
    <RoleNew v-if="this.$route.name == 'adminRoleNew'" />
    <RoleEdit v-if="this.$route.name == 'adminRoleEdit'" />
  </div>
  <RoleInfoModal />
</template>
<script>
import { inject } from "vue";
import RoleList from "./RoleList.vue";
import RoleNew from "./RoleNew.vue";
import RoleEdit from "./RoleNew.vue";
import RoleInfoModal from "./RoleInfoModal.vue";
export default {
  components: {
    RoleList,
    RoleNew,
    RoleEdit,
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