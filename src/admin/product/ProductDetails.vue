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
          <h5 class="modal-title" id="exampleModalLabel">
            Prooduct Details <font-awesome-icon icon="user-secret" />
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <table class="table table-sm">
            <caption>
              {{
                product.name
              }}
              |
              {{
                product.code
              }}
            </caption>
          </table>
          <div class="row justify-content-start">
            <div class="col-4">
              <table class="table table-bordered border-secondary table-info">
                <tbody>
                  <tr>
                    <th scope="row">Name</th>
                    <td>Mark</td>
                  </tr>
                  <tr>
                    <th scope="row">Code</th>
                    <td>Jacob</td>
                  </tr>
                  <tr>
                    <th scope="row">Rack</th>
                    <td>Larry</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-4">
              <table class="table table-bordered border-secondary table-warning">
                <tbody>
                  <tr>
                    <th scope="row">MRP</th>
                    <td>Mark</td>
                  </tr>
                  <tr>
                    <th scope="row">Cost</th>
                    <td>Jacob</td>
                  </tr>
                  <tr>
                    <th scope="row">Price</th>
                    <td>Larry</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-4">
              <table class="table table-bordered border-secondary table-secondary">
                <tbody>
                  <tr>
                    <th scope="row">Brand</th>
                    <td>Mark</td>
                  </tr>
                  <tr>
                    <th scope="row">Category</th>
                    <td>Jacob</td>
                  </tr>
                  <tr>
                    <th scope="row">Subcategory</th>
                    <td>Larry</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger me-auto">DELETE</button>
          <button type="button" class="btn btn-primary">Print</button>
          <button type="button" class="btn btn-warning">Edit</button>
          <button type="button" class="btn btn-dark">Copy</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    product: Object,
  },
};
</script>

