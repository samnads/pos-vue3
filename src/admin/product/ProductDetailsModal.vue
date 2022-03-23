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
          <div class="row justify-content-start">
            <div class="col-12">
              <table
                class="table table-bordered border-secondary table-primary"
              >
                <tbody>
                  <tr>
                    <th scope="row">Name</th>
                    <td>
                      {{ product.name }}
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">Code</th>
                    <td>{{ product.code }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <table class="table table-sm"></table>
          <div class="row justify-content-start">
            <div class="col-4">
              <table class="table table-bordered border-secondary table-info">
                <tbody>
                  <tr>
                    <th scope="row">Name</th>
                    <td>Avariery product with different types of colors.</td>
                  </tr>
                  <tr>
                    <th scope="row">Code</th>
                    <td>561561051</td>
                  </tr>
                  <tr>
                    <th scope="row">Rack</th>
                    <td>RL1</td>
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
                    <th scope="row">50</th>
                    <td>Mark</td>
                  </tr>
                  <tr>
                    <th scope="row">Cost</th>
                    <td>20</td>
                  </tr>
                  <tr>
                    <th scope="row">Price</th>
                    <td>30</td>
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
                    <td>Dell</td>
                  </tr>
                  <tr>
                    <th scope="row">Category</th>
                    <td>Electronics</td>
                  </tr>
                  <tr>
                    <th scope="row">Subcategory</th>
                    <td>Laptops</td>
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
          >
            <i class="fa-solid fa-trash"></i>DELETE
          </button>
          <button type="button" class="btn btn-primary">
            <i class="fa-solid fa-print"></i>Print
          </button>
          <button type="button" class="btn btn-warning" v-on:click="edit()">
            <i class="fa-solid fa-pen-to-square"></i>Edit
          </button>
          <button type="button" class="btn btn-dark" v-on:click="copy()">
            <i class="fa-solid fa-copy"></i>Copy
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
  data: function () {
    return {
    };
  },
  computed: {
    product: function () {
      return  this.productData;
    },
  },
  methods: {
    edit() {
      window.PROD_DETAILS_MODAL.toggle();
      this.$router.push({ path: "/admin/edit/1" }).catch(() => {});
    },
    copy() {
      window.PROD_DETAILS_MODAL.toggle();
      this.$router.push({ path: "/admin/copy/1" }).catch(() => {});
    },
    deleteModal() {
      window.PROD_DETAILS_MODAL.toggle();
      window.PROD_DELETE_MODAL.show();
    },
  },
  mounted() {},
};
</script>

