<template>
  <div class="modal" id="purchaseInfoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title text-dark">Purchase Details</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <AdminLoadingSpinnerDiv v-if="!Object.keys(details).length" />
          <div v-if="details.purchase">
            <div class="row row-cols-1 row-cols-md-2 g-3">
              <div class="col">
                <div class="card border-dark border-opacity-25 h-100">
                  <div class="card-header">Supplier</div>
                  <div class="card-body text-dark">
                    <h5 class="card-title text-primary">
                      {{ details.purchase.supplier_name }}
                    </h5>
                    <p class="m-0">
                      {{ details.purchase.supplier_email }}
                    </p>
                    <p class="m-0">
                      {{ details.purchase.supplier_phone }}
                    </p>
                    <p class="m-0">
                      {{ details.purchase.supplier_place }}
                    </p>
                    <p class="m-0">
                      {{ details.purchase.supplier_city }}
                    </p>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card border-dark border-opacity-25 h-100">
                  <div class="card-header">Purchase</div>
                  <div class="card-body text-dark">
                    <h5 class="card-title text-primary">
                      {{ details.purchase.warehouse_name }}
                      <span class="fs-6 text-secondary">(Warehouse)</span>
                    </h5>
                    <p class="m-0">
                      Ref. No. : <b>{{ details.purchase.reference_id }}</b>
                    </p>
                    <p class="m-0">
                      Date : {{ details.purchase.date }} <i class="fa-regular fa-clock"></i>
                      {{ details.purchase.time }}
                    </p>
                    <p class="m-0" v-if="details.purchase.return_id">
                      Return ID : {{ details.purchase.return_id }}
                    </p>
                    <p class="m-0">
                      Order Status :
                      <span
                        class="
                          badge
                          rounded-pill
                          text-bg-success text-capitalize
                        "
                        v-bind:class="[details.purchase.status_css_class]"
                        >{{ details.purchase.status_name }}</span
                      >
                    </p>
                    <p class="m-0">
                      Created By : {{ details.purchase.created_by_name }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <p class="h5 mt-2">Products</p>
              <hr class="border border-dark border-1 mt-0" />
              <table
                class="
                  table table-sm table-bordered
                  border-dark border-opacity-25
                "
              >
                <thead class="table-info">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Code | Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Unit</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in details.products" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ item.code }} | {{ item.name }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>{{ item.unit_name }}</td>
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
            :disabled="!Object.keys(details).length"
            v-on:click="deleteConfirm(product)"
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
            v-if="details.purchase && details.purchase.total_return == 0"
            v-on:click="edit(product)"
          >
            <i class="fa-solid fa-pen-to-square"></i>Edit
          </button>
          <button
            type="button"
            class="btn btn-dark"
            :disabled="!Object.keys(details).length"
          >
            <i class="fa-solid fa-file-pdf"></i>PDF
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
    emitter.on("showPurchaseDetails", (data) => {
      let row = data.data;
      product.value = row;
      details.value = {};
      if (controller.value) {
        controller.value.abort();
      }
      controller.value = new AbortController();
      window.PURCHASE_INFO_MODAL.show();
      axiosAsyncCallReturnData(
        "get",
        "purchase",
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
            window.PURCHASE_INFO_MODAL.hide();
          } else {
            // other error
            if (data.message != "canceled") {
              window.PURCHASE_INFO_MODAL.hide();
              notifyCatchResponse({ title: data.message });
            }
          }
        }
      });
    });
    function deleteConfirm(data) {
      window.PURCHASE_INFO_MODAL.hide();
      emitter.emit("deleteConfirmModal", {
        title: null,
        body:
          "Delete purchase with Ref. No. <b>" + data.reference_id + "</b> ?",
        data: data,
        emit: "confirmDeletePurchase",
        hide: true,
        type: "danger",
      });
    }
    return {
      product,
      details,
      emitter,
      notifyApiResponse,
      notifyDefault,
      axiosAsyncCallReturnData,
      deleteConfirm,
    };
  },
  methods: {
    edit(data) {
      var self = this;
      window.PURCHASE_INFO_MODAL.hide();
      self.$router
        .push({
          name: "adminPurchaseEdit",
          params: { id: data.id, data: JSON.stringify(data) },
        })
        .catch(() => {});
    },
  },
  mounted() {
    window.PURCHASE_INFO_MODAL = new Modal($("#purchaseInfoModal"), {
      backdrop: true,
      show: true,
    });
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("showPurchaseDetails");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>