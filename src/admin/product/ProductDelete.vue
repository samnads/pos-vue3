<template>
  <div
    class="modal"
    id="deleteModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h5 class="modal-title" id="exampleModalLabel">
            Confirm Delete Product ?
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">{{ product.name }} | {{ product.code }}</div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-danger me-auto"
            v-on:click="confirmDeleteProduct()"
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
export default {
  props: {
    productData: Object,
  },
  computed: {
    product: function () {
      return  this.productData;
    },
  },
  mounted() {},
  methods: {
    confirmDeleteProduct() {
      window.PROD_DELETE_MODAL.toggle();
    },
  },
};
</script>

