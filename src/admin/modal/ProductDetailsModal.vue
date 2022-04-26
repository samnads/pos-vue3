<template>
  <div
    class="modal"
    id="detailsModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="container mb-3">
            <div class="row pt-2">
              <div class="col">
                <p class="mb-1">
                  <span class="fw-bold">Product Name : </span
                  >{{ propProductRow.name }}
                </p>
                <p class="mb-1">
                  <span class="fw-bold">Product Code : </span
                  >{{ propProductRow.code }}
                </p>
                <p class="mb-1">
                  <span class="fw-bold">Brand Name : </span
                  >{{ propProductRow.brand_name || "-" }}
                </p>
              </div>
              <div class="col">
                <table class="table">
                  <tbody>
                    <tr>
                      <td class="text-end">
                        <span class="fw-bold">Stock Count : </span
                        >{{ propProductRow.stock || "0" }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-end">
                        <span class="fw-bold">Model : </span
                        >{{ propProductRow.model_name || "General" }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <LoadingSpinnerDiv v-if="!propProductInfo" />
          <div class="row justify-content-start" v-if="propProductInfo">
            <div class="col-4">
              <table class="table table-bordered border-secondary table-info">
                <tbody>
                  <tr>
                    <th scope="row">Tax</th>
                    <td>{{ propProductInfo.tax_name || "-" }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Tax Rate</th>
                    <td>{{ propProductInfo.tax_rate }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Rack / Shelf</th>
                    <td>{{ propProductInfo.rack || "-" }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-4">
              <table
                class="table table-bordered border-secondary table-warning"
              >
                <tbody>
                  <tr>
                    <th scope="row">MRP</th>
                    <td>{{ propProductInfo.mrp || "-" }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Cost</th>
                    <td>{{ propProductInfo.cost || "-" }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Price</th>
                    <td>{{ propProductInfo.price }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-4">
              <table
                class="table table-bordered border-secondary table-secondary"
              >
                <tbody>
                  <tr>
                    <th scope="row">Brand</th>
                    <td>
                      {{ propProductInfo.brand_name || "-" }}
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">Category</th>
                    <td>{{ propProductInfo.category_name }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Subcategory</th>
                    <td>{{ propProductInfo.sub_category_name || "-" }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-danger me-auto"
            v-on:click="deleteModal()"
            :disabled="!propProductInfo"
          >
            <i class="fa-solid fa-trash"></i>DELETE
          </button>
          <button
            type="button"
            class="btn btn-primary"
            :disabled="!propProductInfo"
          >
            <i class="fa-solid fa-print"></i>Print
          </button>
          <button
            type="button"
            class="btn btn-warning"
            v-on:click="edit(propProductRow)"
            :disabled="!propProductInfo"
          >
            <i class="fa-solid fa-pen-to-square"></i>Edit
          </button>
          <button
            type="button"
            class="btn btn-dark"
            v-on:click="copy(propProductRow)"
            :disabled="!propProductInfo"
          >
            <i class="fa-solid fa-copy"></i>Duplicate
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import LoadingSpinnerDiv from "./LoadingSpinnerDiv.vue";
export default {
  components: {
    LoadingSpinnerDiv,
  },
  props: {
    propProductRow: Object,
    propProductInfo: Object,
    propConfirmDeleteModal: Function,
  },
  data: function () {
    return {};
  },
  computed: {
    product: function () {
      return this.productData;
    },
  },
  methods: {
    edit(data) {
      window.PROD_DETAILS_MODAL.toggle();
      this.$router
        .push({
          name: "adminProductEdit",
          params: { id: data.id, data: JSON.stringify(data) },
        })
        .catch(() => {});
    },
    copy(data) {
      window.PROD_DETAILS_MODAL.toggle();
       this.$router
        .push({
          name: "adminProductCopy",
          params: { id: data.id, data: JSON.stringify(data) },
        })
        .catch(() => {});
    },
    deleteModal() {
      window.PROD_DETAILS_MODAL.toggle();
      this.propConfirmDeleteModal(this.propProductRow);
    },
  },
  mounted() {},
};
</script>

