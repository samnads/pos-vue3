<template>
  <div class="modal" id="deleteDefModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h5 class="modal-title">
            {{ title }}
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          {{ body }}
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-danger me-auto"
            v-on:click="propConfirmDelete(id)"
            :disabled="propDeleting"
          >
            <span v-if="!propDeleting">
              <i class="fa-solid fa-trash"></i>
            </span>
            <span
              class="spinner-border spinner-border-sm"
              role="status"
              aria-hidden="true"
              v-if="propDeleting"
            ></span>
            YES
          </button>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
            :disabled="propDeleting"
          >
            <i class="fa-solid fa-stop"></i>NO
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    propId: Number,
    propProducts: Array,
    propTitle: String,
    propBody: String,
    propConfirmDelete: Function,
    propDeleting: Boolean,
  },
  computed: {
    title: function () {
      return this.propTitle;
    },
    body: function () {
      return this.propBody;
    },
    id: function () {
      return this.propId;
    },
  },
};
</script>

