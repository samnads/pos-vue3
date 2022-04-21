<template>
  <div class="modal" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h5 class="modal-title">
            Confirm Delete Product{{ products.length > 1 ? "s" : "" }} ?
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div v-if="!products.length">
            <p>{{ products.name }} | {{ products.code }}</p>
          </div>
          <div v-if="products.length > 1">
            <li v-for="product in products" :key="product.id">
              {{ product.name }} | {{ product.code }}
            </li>
          </div>
          <div v-if="products.length == 1">
            <p v-for="product in products" :key="product.id">
              {{ product.name }} | {{ product.code }}
            </p>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-danger me-auto"
            v-on:click="propConfirmDeleteProduct(products)"
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
    propProductData: Object,
    propConfirmDeleteProduct: Function,
    propDeleting: Boolean,
  },
  computed: {
    products: function () {
      return this.propProductData;
    },
  },
};
</script>

