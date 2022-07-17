<template>
  <div id="categorymain">
    <CategoryList v-if="this.$route.name == 'adminCategoryList'" />
  </div>
  <CategoryNewModal />
  <CategoryInfoModal />
</template>
<script>
import { inject } from "vue";
import CategoryList from "./CategoryList.vue";
import CategoryNewModal from "./CategoryNewModal.vue";
import CategoryInfoModal from "./CategoryInfoModal.vue";
export default {
  components: {
    CategoryList,
    CategoryNewModal,
    CategoryInfoModal,
  },
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    return {
      emitter,
    };
  },
};
</script>