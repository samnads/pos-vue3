<template>
  <div class="modal" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" :class="type">
          <h5 class="modal-title">
            {{ title || "Confirm Delete ?" }}
          </h5>
        </div>
        <div class="modal-body">
          <span v-html="body"></span>
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
    const title = ref("");
    const body = ref("");
    const type = ref("");
    const action = ref("");
    const data = ref("");
    const emitter = inject("emitter"); // Inject `emitter`
    emitter.on("deleteConfirmModal", (datas) => {
      // *Listen* for event
      data.value = datas;
      title.value = datas.title;
      body.value = datas.body;
      type.value = datas.type ? "bg-" + datas.type : "bg-danger"; // change bg-danger for default color in alert box//
      emitter.emit("playSound", { file: "warning.mp3" }); // PLAY SOUND
      // get action
      action.value = datas.action;
      // show modal
      window.DELETE_CONFIRM_DEFAULT_MODAL.show();
    });
    function confirmDelete() {
      window.DELETE_CONFIRM_DEFAULT_MODAL.hide();
      emitter.emit(action.value, {data:data.value}); // DELETE ACTION EMITTER
    }
    return {
      title,
      body,
      type,
      confirmDelete,
    };
  },
};
</script>

