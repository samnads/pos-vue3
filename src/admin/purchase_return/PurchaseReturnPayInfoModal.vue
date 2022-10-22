<template>
  <div class="modal" id="purchasePayInfoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title">Purchase Return Payment Details</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <AdminLoadingSpinnerDiv v-if="!Object.keys(detailsPurchase).length" />
          <div v-if="detailsPurchase.payments">
            <div class="col">
              <p class="h5">Payments</p>
              <hr class="border border-dark border-1 mt-0" />
              <div
                class="alert alert-info text-center"
                role="alert"
                v-if="detailsPurchase.payments.length == 0"
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
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(item, index) in detailsPurchase.payments"
                    :key="index"
                  >
                    <td>{{ index + 1 }}</td>
                    <td>{{ item.date_time }}</td>
                    <td>{{ item.reference_no || "NIL" }}</td>
                    <td class="text-end">
                      {{ parseFloat(item.amount).toFixed(2) }}
                    </td>
                    <td class="text-center">{{ item.payment_mode_name }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-success"
            v-if="
              Object.keys(detailsPurchase).length &&
              purchaseData.due > 0
            "
            v-on:click="addPay()"
          >
            <i class="fa-solid fa-plus"></i>Add
          </button>
          <button
            type="button"
            class="btn btn-warning"
            v-if="
              Object.keys(detailsPurchase).length &&
              detailsPurchase.payments.length > 0
            "
            v-on:click="editPay(purchaseData)"
          >
            <i class="fa-solid fa-pen-to-square"></i>Edit
          </button>
          <button
            type="button"
            class="btn btn-primary"
            :disabled="!Object.keys(detailsPurchase).length"
          >
            <i class="fa-solid fa-print"></i>Print
          </button>
          <button
            type="button"
            class="btn btn-dark"
            :disabled="!Object.keys(detailsPurchase).length"
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
    const purchaseData = ref({}); // purchase data
    const detailsPurchase = ref({}); // payment details
    const controller = ref(undefined);
    emitter.on("showPurchasePayDetails", (row) => {
      //console.log(row)
      purchaseData.value = row;
      detailsPurchase.value = {}; // rest details for purchase
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
          id: purchaseData.value.id,
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
          detailsPurchase.value = data.data;
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
    function editPay(data) {
      data.payments = detailsPurchase.value.payments; // add payment data
      window.PURCHASE_PAY_INFO_MODAL.hide();
      emitter.emit("purchasePayModal", JSON.parse(JSON.stringify(data)));
    }
    function addPay() {
      window.PURCHASE_PAY_INFO_MODAL.hide();
      emitter.emit("purchasePayModal", purchaseData.value);
    }
    return {
      purchaseData,
      detailsPurchase,
      emitter,
      notifyApiResponse,
      notifyDefault,
      axiosAsyncCallReturnData,
      deleteConfirm,
      editPay,
      addPay,
    };
  },
  methods: {},
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