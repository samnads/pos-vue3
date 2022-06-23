<template>
  <div class="modal" id="alertDefModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div
          class="modal-header"
          :class="type"
        >
          <h5 class="modal-title">
            {{ title }}
          </h5>
        </div>
        <div class="modal-body">
          <span v-html="body"></span>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            OK
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
    const emitter = inject("emitter"); // Inject `emitter`
    emitter.on("showAlert", (data) => {
      // *Listen* for event
      title.value = data.title;
      body.value = data.body;
      type.value= data.type ? "bg-" + data.type : "bg-danger"; // change bg-danger for default color in alert box//
      emitter.emit("playSound", { file: "danger" });
      //
      window.ALERT_DEFAULT_MODAL.show();
    });
    return {
      title,
      body,
      type,
    };
  },
};
</script>

