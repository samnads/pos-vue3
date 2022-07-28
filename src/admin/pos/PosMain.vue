<template>
  <div id="posmain">
    <div class="wrap_content p-2 rounded">
      <div class="row">
        <div class="col-9 left">
          <div class="row">
            <div class="col-9">
              <div class="input-group mb-2">
                <span
                  class="input-group-text"
                  data-bs-toggle="tooltip"
                  data-bs-placement="right"
                  title="Scan & Add Product"
                  ><i class="fa-solid fa-barcode"></i
                ></span>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Scan code or type product name..."
                />
                <span
                  class="input-group-text bg-info"
                  role="button"
                  data-bs-toggle="tooltip"
                  data-bs-placement="left"
                  title="New Product"
                  ><i class="fa-solid fa-plus"></i
                ></span>
              </div>
            </div>
            <div class="col-3">
              <div class="input-group mb-2">
                <span
                  class="input-group-text"
                  data-bs-toggle="tooltip"
                  data-bs-placement="right"
                  title="Scan & Remove Product"
                  ><i class="fa-solid fa-trash"></i
                ></span>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Scan & remove product from cart"
                />
              </div>
            </div>
          </div>
          <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col" class="fit">No.</th>
                <th scope="col" class="fit">Code</th>
                <th scope="col">Product Name</th>
                <th scope="col" class="fit">HSN</th>
                <th scope="col" width="10%" class="text-center">Quantity</th>
                <th scope="col" width="10%" class="text-end">Price/Item</th>
                <th scope="col" width="8%" class="text-end">Discount</th>
                <th scope="col" width="10%" class="text-end">Taxable Value</th>
                <th scope="col" width="12%">Tax</th>
                <th scope="col">Total</th>
                <th scope="col" class="text-center fit">
                  <span role="button" class="btn-sm btn-outline-danger"
                    ><i class="fa-solid fa-trash"></i
                  ></span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>6515641564</td>
                <td>OnePlues 10 Mobile</td>
                <td>11665</td>
                <td>
                  <div class="input-group input-group-sm is-invalid">
                    <button
                      type="button"
                      class="btn btn-warning input-group-text"
                    >
                      <i class="fa-solid fa-minus"></i>
                    </button>
                    <input
                      type="number"
                      class="form-control no-arrow text-center"
                      value="1"
                    />
                    <button type="button" class="btn btn-info input-group-text">
                      <i class="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </td>
                <td class="text-right">
                  <input
                    type="number"
                    class="form-control form-control-sm no-arrow text-end"
                    value="64000"
                  />
                </td>
                <td>
                  <input
                    type="number"
                    class="form-control form-control-sm no-arrow text-end"
                    value="2500"
                    readonly
                  />
                </td>
                <td class="text-end">61,500</td>
                <td class="text-end">[GST 18%] - 5,525</td>
                <td class="text-end fw-bold">75,000</td>
                <td>
                  <span
                    role="button"
                    class="btn btn-sm btn-outline-danger"
                    @click="confirmDeleteShow()"
                    ><i class="fa-solid fa-trash"></i
                  ></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-3 right">
          <div class="form-row border border-dnger right-top">
            <div class="col">
              <div class="input-group mb-2">
                <span
                  class="input-group-text"
                  data-bs-toggle="tooltip"
                  data-bs-placement="right"
                  title="Customer"
                  ><i class="fa-solid fa-user-tag"></i
                ></span>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Walk-in Customer"
                />
                <span
                  class="input-group-text"
                  role="button"
                  data-bs-toggle="tooltip"
                  data-bs-placement="left"
                  title="Unlock"
                  ><i class="fa-solid fa-lock"></i
                ></span>
                <span
                  class="input-group-text bg-secondary text-light"
                  role="button"
                  data-bs-toggle="tooltip"
                  data-bs-placement="left"
                  title="Customer Details"
                  ><i class="fa-solid fa-binoculars"></i
                ></span>
                <span
                  class="input-group-text"
                  role="button"
                  data-bs-toggle="tooltip"
                  data-bs-placement="left"
                  title="New Customer"
                  ><i class="fa-solid fa-plus"></i
                ></span>
              </div>
            </div>
          </div>
          <div class="form-row right-bottom text-light">
            <div class="form-row">
              <div class="col">
                <div class="row m-0 border border-dark border border-bottom-0">
                  <div class="col bg-secondary">Items</div>
                  <div class="col bg-primary text-end">0</div>
                  <div class="col bg-secondary">Sub Total</div>
                  <div class="col bg-info text-end">0</div>
                </div>
                <div class="row m-0 border border-dark border-bottom-0">
                  <div class="col bg-secondary">Pieces</div>
                  <div class="col bg-primary text-end">0</div>
                  <div class="col bg-secondary">Product Discount</div>
                  <div class="col bg-warning text-dark text-end">0</div>
                </div>
                <div class="row m-0 border border-dark border-bottom-0">
                  <div class="col bg-secondary">Tax</div>
                  <div class="col bg-primary text-end">0</div>
                  <div class="col bg-secondary">Cart Discount</div>
                  <div class="col bg-warning text-dark text-end">0</div>
                </div>
                <div class="row m-0 border border-dark border-bottom-0">
                  <div class="col bg-secondary"></div>
                  <div class="col bg-primary text-end"></div>
                  <div class="col bg-secondary">Total Discount</div>
                  <div class="col bg-warning text-dark text-end">0</div>
                </div>
                <div class="row m-0 border border-dark border-bottom-0">
                  <div class="col bg-secondary"></div>
                  <div class="col bg-primary text-end"></div>
                  <div class="col bg-secondary">Taxable Value</div>
                  <div class="col bg-warning text-dark text-end">0</div>
                </div>
                <div class="row m-0 border border-dark border-bottom-0">
                  <div class="col bg-secondary">Shipping</div>
                  <div class="col bg-primary text-end">0</div>
                  <div class="col bg-secondary">Total</div>
                  <div class="col bg-info text-end">0</div>
                </div>
                <div class="row m-0 border border-dark border-bottom-0">
                  <div class="col bg-secondary"></div>
                  <div class="col bg-primary"></div>
                  <div class="col bg-secondary">Total Discount</div>
                  <div class="col bg-danger text-end">0</div>
                </div>
                <div class="row m-0 border border-dark">
                  <div class="col bg-secondary fs-5">Total Payable</div>
                  <div class="col bg-light text-dark fw-bold fs-4 text-end">
                    <div class="d-flex justify-content-between">
                      <div>₹</div>
                      <div>0.00</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
#posmain {
  background-color: rgb(238, 236, 236);
}
.wrap_content {
  min-height: calc(100vh - 120px) !important;
}
.right .right-top {
  min-height: calc(100vh - 425px) !important;
}
.right .right-bottom {
  background-color: blanchedalmond;
}
.table td.fit,
.table th.fit {
  white-space: nowrap;
  width: 1%;
}
input:read-only,
input:disabled {
  cursor: not-allowed;
  pointer-events: all !important;
}
</style>
<script>
/* eslint-disable */
import { inject } from "vue";
export default {
  components: {},
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    function confirmDeleteShow(data) {
      emitter.emit("deleteConfirmModal", {
        title: null,
        body: "Confirm delete <b>" + "data.name" + "</b> from cart ?",
        data: data,
        hide: true,
        emit: "confirmDeleteProduct",
        type: "danger",
      });
      window.DELETE_CONFIRM_DEFAULT_MODAL.show();
    }
    emitter.on("confirmDeleteProduct", (data) => {
      // delete selected product stuff here
      //let index = products.value.findIndex((item) => item.id === data.id);
      //products.value.splice(index, 1);
      emitter.emit("playSound", { file: "add.mp3" });
    });
    return {
      emitter,
      confirmDeleteShow,
    };
  },
};
</script>