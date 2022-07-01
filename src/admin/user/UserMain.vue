<template>
  <div id="usermain">
    <UserList v-if="this.$route.name == 'adminUserList'" />
  </div>
  <UserNewModal />
  <UserInfoModal />
</template>
<script>
import { inject } from "vue";
import UserList from "./UserList.vue";
import UserNewModal from "./UserNewModal.vue";
import UserInfoModal from "./UserInfoModal.vue";
export default {
  components: {
    UserList,
    UserNewModal,
    UserInfoModal,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    return {
      emitter,
    };
  },
};
</script>