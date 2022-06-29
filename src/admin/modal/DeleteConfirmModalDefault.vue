<template>
  <div class="modal" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div
          class="modal-header"
          :class="params.type ? 'bg-' + params.type : 'bg-danger'"
        >
          <h5 class="modal-title">
            {{ params.title || "Confirm Delete ?" }}
          </h5>
        </div>
        <div class="modal-body">
          <span v-html="params.body"></span>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-danger me-auto"
            v-on:click="confirmDelete()"
          >
            <i class="fa-solid fa-trash"></i>YES
          </button>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            <i class="fa-solid fa-stop"></i>NO
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
import { inject } from "vue";
export default {
  props: {},
  setup() {
    const data = ref({}); // may be some db data
    const params = ref({}); // extra params
    const emitter = inject("emitter"); // Inject `emitter`
    emitter.on("deleteConfirmModal", (DATA) => {
      // *Listen* for event
      data.value = DATA.data;
      delete DATA.data;
      params.value = DATA;
      emitter.emit("playSound", { file: "warning.mp3" }); // PLAY SOUND
      // show modal
      window.DELETE_CONFIRM_DEFAULT_MODAL.show();
    });
    function confirmDelete() {
      if (params.value.hide) {
        window.DELETE_CONFIRM_DEFAULT_MODAL.hide();
      }
      emitter.emit(params.value.action, data.value); // DELETE ACTION EMITTER
    }
    return {
      confirmDelete,
      params,
    };
  },
};
</script>

