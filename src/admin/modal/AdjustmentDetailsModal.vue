<template>
  <div class="modal" id="prodAdjDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Adjustment Details</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="container border border-dark">
            <div class="row pt-2">
              <div class="col">
                <p class="mb-1">
                  <span class="fw-bold">Date : </span>{{ propAdjustRow.date }}
                </p>
                <p class="mb-1">
                  <span class="fw-bold">Warehouse : </span
                  >{{ propAdjustRow.warehouse_name }}
                </p>
                <p class="mb-1">
                  <span class="fw-bold">Reference No. : </span
                  >{{ propAdjustRow.reference_no }}
                </p>
                <p class="mb-1">
                  <span class="fw-bold">Note : </span>{{ propAdjustRow.note }}
                </p>
              </div>
              <div class="col">
                <table class="table">
                  <tbody>
                    <tr>
                      <td class="text-end">
                        <span class="fw-bold">Added By : </span
                        >{{ propAdjustRow.added_by }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-end">
                        <span class="fw-bold">No. of products : </span
                        >{{ propAdjustRow.total_products }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <table
            class="table table-bordered border-dark table-striped table-hover"
          >
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Code | Product</th>
                <th scope="col">Note</th>
                <th scope="col">Type ( + / - )</th>
                <th scope="col">Quantity</th>
              </tr>
            </thead>

            <tbody>
              <tr v-if="!propAdjustInfo">
                <td colspan="4"><LoadingSpinnerDiv /></td>
              </tr>
              <tr v-for="(product, index) in propAdjustInfo" :key="product.id">
                <th scope="row">{{ index + 1 }}</th>
                <td>{{ product.code + " | " + product.name }}</td>
                 <td>{{ product.note }}</td>
                <td
                  v-bind:class="[
                    product.quantity > 0 ? 'text-success' : 'text-danger',
                  ]"
                >
                  {{ product.quantity > 0 ? "+ Added" : "- Removed" }}
                </td>
                <td>{{ product.quantity }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-danger me-auto"
            v-on:click="deleteModal()"
            :disabled="!propAdjustInfo"
          >
            <i class="fa-solid fa-trash"></i>DELETE
          </button>
          <button
            type="button"
            class="btn btn-primary"
            v-on:click="print()"
            :disabled="!propAdjustInfo"
          >
            <i class="fa-solid fa-print"></i>Print
          </button>
          <button
            type="button"
            class="btn btn-warning"
            v-on:click="edit(propAdjustRow.id)"
            :disabled="!propAdjustInfo"
          >
            <i class="fa-solid fa-pen-to-square"></i>Edit
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
</style>
<script>
import LoadingSpinnerDiv from "./LoadingSpinnerDiv.vue";
export default {
  components: {
    LoadingSpinnerDiv,
  },
  props: {
    propAdjustRow: Object,
    propAdjustInfo: Object,
  },
  data: function () {
    return {};
  },
  computed: {},
  methods: {
    edit(id) {
      window.PROD_ADJ_DETAILS_MODAL.hide();
      this.$router
        .push({ path: "/admin/adjustment/edit/" + id })
        .catch(() => {});
    },
    print() {
      window.print();
    },
  },
  mounted() {},
};
</script>

