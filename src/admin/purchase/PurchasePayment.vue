<template>
  <!-- Checkout Modal -->
  <div class="modal" id="purchasePayModal" tabindex="-1" aria-hidden="true">
    <div
      class="
        modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable
      "
    >
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title">
            <i class="fa-solid fa-money-bill"></i>Purchase Payment
          </h5>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-9">
              <div class="card border-info mb-2">
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <label class="form-label">Ref. No.</label> : Walk-in
                      Customer
                    </div>
                    <div class="col-6 text-end">
                      <label class="form-label"> Date</label> : CUS7116
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <label class="form-label">Supplier</label> : N/A
                    </div>
                    <div class="col-6 text-end">
                      <label class="form-label">Warehouse</label> : CUS7116
                    </div>
                  </div>
                </div>
              </div>
              <ul class="list-group">
                <li class="list-group-item bg-secondary text-light fs-5">
                  Payment Details
                </li>
                <li
                  class="list-group-item border-secondary"
                  v-for="p in payments"
                  :key="p.id"
                  style="background: lightblue"
                >
                  <button
                    type="button"
                    class="
                      border
                      bg-light
                      btn btn-sm btn-close
                      position-sticky
                      start-100
                      m-0
                    "
                    v-if="payments.length > 1"
                    @click="removePayment(p)"
                  ></button>
                  <div class="row">
                    <div class="col-6">
                      <label class="form-label">Amount<i>*</i></label>
                      <input
                        type="number"
                        step="any"
                        class="form-control"
                        v-model="p.amount"
                        @focus="$event.target.select()"
                      />
                    </div>
                    <div class="col-6">
                      <label class="form-label">Payment Method<i>*</i></label>
                      <select
                        class="form-select"
                        v-model="p.mode"
                        :disabled="!paymentModes"
                      >
                        <option selected :value="null" v-if="!paymentModes">
                          Loading...
                        </option>
                        <option
                          v-for="m in paymentModes"
                          :key="m.id"
                          :value="m.id"
                        >
                          {{ m.name }}
                        </option>
                      </select>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Transaction ID</label>
                      <input
                        type="text"
                        v-model="p.transaction_id"
                        class="form-control"
                      />
                    </div>
                    <div class="col-6">
                      <label class="form-label">Reference No.</label>
                      <input
                        type="text"
                        v-model="p.reference_no"
                        class="form-control"
                      />
                    </div>
                    <div class="col-12">
                      <label class="form-label">Note</label>
                      <textarea
                        type="text"
                        rows="1"
                        v-model="p.note"
                        class="form-control"
                      ></textarea>
                    </div>
                  </div>
                </li>
                <li class="list-group-item border-secondary">
                  <div class="row">
                    <div class="col-10 p-0">
                      <span class="ms-2 text-muted"
                        >You can pay using multiple modes by clicking the +
                        button.</span
                      >
                    </div>
                    <div class="col-2 text-end p-0">
                      <div class="btn-group dropstart">
                        <button
                          class="btn btn-sm btn-secondary rounded"
                          type="button"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                          :disabled="!paymentModes"
                        >
                          <i class="fa-solid fa-plus"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item disabled">Select Method</a>
                          </li>
                          <li><hr class="dropdown-divider" /></li>
                          <li
                            v-for="m in paymentModes"
                            :key="m.id"
                            :value="m.id"
                            @click="addNewPayment(m.id)"
                          >
                            <a class="dropdown-item" href="#"
                              ><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;{{
                                m.name
                              }}</a
                            >
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="col-3">
              <div class="sticky-top">
                <div
                  class="card rounded text-light border"
                  v-bind:class="[
                    calc.balance() > 0
                      ? 'bg-danger'
                      : calc.balance() == 0
                      ? 'bg-success'
                      : 'bg-info',
                  ]"
                >
                  <div class="card-body">
                    <div class="row text-end">
                      <div class="col-12 fs-4">Previous Due</div>
                      <div class="col-12 fs-4">
                        <span class="badge bg-light text-dark">{{}}</span>
                      </div>
                      <hr class="m-1" />
                      <div class="col-12 fs-4">Current Payable</div>
                      <div class="col-12 fs-4">
                        <span class="badge bg-light text-dark">{{}}</span>
                      </div>
                      <hr class="m-1" />
                      <div class="col-12 fs-4">
                        Balance {{ calc.balance() >= 0 ? "" : "Return" }}
                      </div>
                      <div class="col-12 fs-4">
                        <span class="badge bg-light text-dark">{{
                          calc.balance().toFixed(2)
                        }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
            :disabled="isSubmitting"
          >
            <i class="fa-solid fa-angle-left"></i>Back
          </button>
          <button
            type="button"
            class="btn btn-success"
            @click="onSubmit"
            :disabled="isSubmitting"
          >
            Confirm&nbsp;<i class="fa-solid fa-check"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
  <!------------- Payment Modal ---------->
</template>
<style>
</style>
<script>
import { ref, computed } from "vue";
import admin from "@/mixins/admin.js";
import { Modal } from "bootstrap";
import { inject } from "vue";
import * as yup from "yup";
import { useStore } from "vuex";
import {
  useForm,
  useField,
  useIsFormDirty,
  useIsFormValid,
} from "vee-validate";
export default {
  components: {},
  /* eslint-disable */
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    const controller_delete = ref({});
    const store = useStore();
    let paymentModes = computed(function () {
      return store.state.PAYMENT_MODES;
    });
    const schema = computed(() => {
      return yup.object({
        payments: yup
          .array(
            yup.object().shape({
              id: yup.number().required().label("Payment ID"),
              amount: yup
                .number()
                .typeError("Amount must be a number")
                .required()
                .moreThan(0)
                .label("Amount"),
              mode: yup.number().required().label("Mode"),
              transaction_id: yup.string().nullable().label("Trans. ID"),
              reference_no: yup.string().nullable().label("Ref. No."),
              note: yup.string().nullable().label("Note"),
            })
          )
          .required()
          .label("Payments"),
      });
    });
    var formValues = {
      payments: [
        {
          id: Date.now(),
          amount: 0,
          mode: 2,
          transaction_id: null,
          reference_no: null,
          note: null,
        },
      ],
    }; // pre form values
    const {
      setFieldValue,
      handleSubmit,
      setFieldError,
      isSubmitting,
      resetForm,
    } = useForm({
      validationSchema: schema,
      initialValues: formValues,
      initialErrors: {},
    });
    const { value: payments } = useField("payments");
    const calc = {
      balance: function () {
        var totalPaying = 0;
        payments.value.forEach((element, index, array) => {
          totalPaying += element.amount;
        });
        return totalPaying;
      },
    };
    // notify
    const {
      axiosAsyncCallReturnData,
      notifyDefault,
      axiosAsyncStoreReturnBool,
      notifyApiResponse,
      notifyCatchResponse,
    } = admin();
    function addNewPayment(mode) {
      let payMethod = {
        id: Date.now(),
        amount: 0,
        mode: mode,
        transaction_id: null,
        reference_no: null,
        note: null,
      };
      payments.value.push(payMethod);
    }
    function removePayment(payment) {
      let index = payments.value.findIndex((item) => item.id === payment.id);
      payments.value.splice(index, 1);
    }
    function onInvalidSubmit({ values, errors }) {
      console.log("Form field errors found !");
      for (var key in errors) {
        notifyDefault({ message: errors[key] });
      }
    }
    const onSubmit = handleSubmit((values) => {
      return axiosAsyncCallReturnData("POST", "purchase", {
        action: "create",
        job: "payment",
        data: values,
      }).then(function (data) {
        if (data.success == true) {
          window.PURCHASE_PAY_MODAL.hide();
          resetForm();
        } else if (data.success == false) {
          // valid error
          if (data.errors) {
            for (var key in data.errors) {
              notifyDefault({ message: data.errors[key] });
            }
          }
        } else {
          // other error
        }
      });
    }, onInvalidSubmit);
    return {
      emitter,
      controller_delete,
      axiosAsyncCallReturnData,
      notifyDefault,
      axiosAsyncStoreReturnBool,
      notifyApiResponse,
      notifyCatchResponse,
      useIsFormDirty,
      useIsFormValid,
      payments,
      calc,
      paymentModes,
      addNewPayment,
      removePayment,
      onSubmit,
    };
  },
  methods: {},
  created() {},
  mounted() {
    window.PURCHASE_PAY_MODAL = new Modal($("#purchasePayModal"), {
      backdrop: "static",
      show: true,
    });
    if (!this.paymentModes) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storePaymentModes", "pos", {
        action: "create",
        dropdown: "payment_modes",
      });
      // get product types
    }
  },
  beforeUnmount() {
    var self = this;
    self.emitter.off("confirmDeletePurchase");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>