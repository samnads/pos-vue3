<template>
  <div class="modal" id="productInfoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Product Details</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="bg-secondary text-light p-2 mb-2 rounded">
            {{ product.name }}
          </div>
          <AdminLoadingSpinnerDiv v-if="!Object.keys(details).length" />
          <div
            class="row justify-content-start"
            v-if="Object.keys(details).length"
          >
            <p class="h5">Basic Details</p>
            <hr class="border border-dark border-1 mt-0" />
            <div class="col">
              <table class="table table-bordered border-secondary table-info">
                <tbody>
                  <tr>
                    <th scope="row">Tax</th>
                    <td>{{ details.tax_name || "-" }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Tax Rate</th>
                    <td>{{ details.tax_rate || "-" }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Rack / Shelf</th>
                    <td>{{ details.rack || "-" }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col">
              <table
                class="table table-bordered border-secondary table-warning"
              >
                <tbody>
                  <tr>
                    <th scope="row">MRP</th>
                    <td>{{ details.mrp || "-" }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Cost</th>
                    <td>{{ details.cost || "-" }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Price</th>
                    <td>{{ details.price }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col">
              <table
                class="table table-bordered border-secondary table-secondary"
              >
                <tbody>
                  <tr>
                    <th scope="row">Brand</th>
                    <td>
                      {{ details.brand_name || "-" }}
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">Category</th>
                    <td>{{ details.category_name }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Subcategory</th>
                    <td>{{ details.sub_category_name || "-" }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div v-if="Object.keys(details).length">
            <p class="h5">Warehouse Stock</p>
            <hr class="border border-dark border-1 mt-0" />
            <table
              class="
                table table-sm table-bordered
                border-dark border-opacity-25
              "
            >
              <thead class="table-dark">
                <tr>
                  <th scope="col">Warehouse</th>
                  <th scope="col">Rack</th>
                  <th scope="col">Stock</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in details.stock" :key="index">
                  <td>{{ item.sap_warehouse_name }}</td>
                  <td>NIL</td>
                  <td
                    v-bind:class="[
                      item.total_sap_quantity <= 0
                        ? 'text-danger'
                        : 'text-success',
                    ]"
                  >
                    {{ parseFloat(item.total_sap_quantity).toFixed(2) }}
                  </td>
                </tr>
                <tr
                  class="fw-bold"
                  v-show="details.stock && details.stock.length"
                >
                  <td colspan="2" class="text-end fs-5">Total</td>
                  <td
                    class="fs-5"
                    v-bind:class="[
                      details.total_stock <= 0 ? 'text-danger' : 'text-success',
                    ]"
                  >
                    {{ parseFloat(details.total_stock).toFixed(2) }}
                  </td>
                </tr>
                <tr
                  class="text-info text-center"
                  v-show="details.stock && details.stock.length < 1"
                >
                  <td colspan="3">No stock data entry found !</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-danger me-auto"
            :disabled="!product"
          >
            <i class="fa-solid fa-trash"></i>DELETE
          </button>
          <button
            type="button"
            class="btn btn-primary"
            :disabled="!Object.keys(details).length"
          >
            <i class="fa-solid fa-print"></i>Print
          </button>
          <button
            type="button"
            class="btn btn-warning"
            :disabled="!Object.keys(details).length"
            v-on:click="edit(product)"
          >
            <i class="fa-solid fa-pen-to-square"></i>Edit
          </button>
          <button
            type="button"
            class="btn btn-dark"
            :disabled="!Object.keys(details).length"
          >
            <i class="fa-solid fa-copy"></i>Duplicate
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
import admin from "@/mixins/admin.js";
import { inject } from "vue";
import { Modal } from "bootstrap";
export default {
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    const {
      axiosAsyncCallReturnData,
      notifyDefault,
      notifyApiResponse,
      notifyCatchResponse,
    } = admin();
    const product = ref({});
    const details = ref({});
    const controller = ref(undefined);
    emitter.on("showProductDetails", (data) => {
      let row = data.data;
      product.value = row;
      details.value = {};
      if (controller.value) {
        controller.value.abort();
      }
      controller.value = new AbortController();
      window.PRODUCT_INFO_MODAL.show();
      axiosAsyncCallReturnData(
        "get",
        "product",
        {
          action: "details",
          id: row.id,
        },
        controller.value,
        {
          showSuccessNotification: false,
          showCatchNotification: false,
          showProgress: true,
        }
      ).then(function (data) {
        if (data.success == true) {
          // ok
          details.value = data.data || {}; // {} - because sometimes the product is already deleted so gets a null response data
        } else {
          if (data.success == false) {
            // not ok
            window.PRODUCT_INFO_MODAL.hide();
          } else {
            // other error
            if (data.message != "canceled") {
              window.PRODUCT_INFO_MODAL.hide();
              notifyCatchResponse({ title: data.message });
            }
          }
        }
      });
    });
    return {
      product,
      details,
      emitter,
      notifyApiResponse,
      notifyDefault,
      axiosAsyncCallReturnData,
    };
  },
  data() {
    return {};
  },
  methods: {
    edit(data) {
      var self = this;
      window.PRODUCT_INFO_MODAL.hide();
      self.$router
        .push({
          name: "adminProductEdit",
          params: { id: data.id, data: JSON.stringify(data) },
        })
        .catch(() => {});
    },
  },
  mounted() {
    window.PRODUCT_INFO_MODAL = new Modal($("#productInfoModal"), {
      backdrop: true,
      show: true,
    });
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("showProductDetails");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>