<template>
  <div class="modal" id="purchasePayInfoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title">Payment Details</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <AdminLoadingSpinnerDiv v-if="!Object.keys(details).length" />
          <div v-if="details.payments">
            <div class="col">
              <p class="h5">Payments</p>
              <hr class="border border-dark border-1 mt-0" />
              <div
                class="alert alert-info text-center"
                role="alert"
                v-if="details.payments.length == 0"
              >
                No Payments Found !
              </div>
              <table
                class="
                  table table-sm table-bordered
                  border-dark border-opacity-25
                "
                v-else
              >
                <thead class="table-info">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Reference</th>
                    <th scope="col" class="text-end">Amount</th>
                    <th scope="col" class="text-center">Mode</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in details.payments" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ item.date_time }}</td>
                    <td>{{ item.reference_no || "NIL" }}</td>
                    <td class="text-end">
                      {{ parseFloat(item.amount).toFixed(2) }}
                    </td>
                    <td class="text-center">{{ item.payment_mode_name }}</td>
                    <td>{{}}</td>
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
            v-on:click="deleteConfirm(purchase)"
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
            v-on:click="editPay()"
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
    const purchase = ref({});
    const details = ref({});
    const controller = ref(undefined);
    emitter.on("showPurchasePayDetails", (data) => {
      let row = data.data;
      purchase.value = row;
      details.value = {};
      if (controller.value) {
        controller.value.abort();
      }
      controller.value = new AbortController();
      window.PURCHASE_PAY_INFO_MODAL.show();
      axiosAsyncCallReturnData(
        "get",
        "purchase",
        {
          action: "payment_details",
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
          details.value = data.data;
        } else {
          if (data.success == false) {
            // not ok
            window.PURCHASE_INFO_MODAL.hide();
          } else {
            // other error
            if (data.message != "canceled") {
              window.PURCHASE_PAY_INFO_MODAL.hide();
              notifyCatchResponse({ title: data.message });
            }
          }
        }
      });
    });
    function deleteConfirm(data) {
      window.PURCHASE_PAY_INFO_MODAL.hide();
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
      purchase,
      details,
      emitter,
      notifyApiResponse,
      notifyDefault,
      axiosAsyncCallReturnData,
      deleteConfirm,
    };
  },
  methods: {
    editPay() {
      var self = this;
      let data = self.purchase;
      data.payments = self.details.payments
      window.PURCHASE_PAY_INFO_MODAL.hide();
      self.emitter.emit("purchasePayModal", {
        data: data,
      });
    },
  },
  mounted() {
    window.PURCHASE_PAY_INFO_MODAL = new Modal($("#purchasePayInfoModal"), {
      backdrop: true,
      show: true,
    });
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("showPurchasePayDetails");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>