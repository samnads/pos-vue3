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
                      <label class="form-label">Ref. No.</label> :
                      {{ DATA.reference_id }}
                    </div>
                    <div class="col-6 text-end">
                      <label class="form-label"> Date</label> : {{ DATA.date }}
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <label class="form-label">Supplier</label> :
                      {{ DATA.supplier_name }}
                    </div>
                    <div class="col-6 text-end">
                      <label class="form-label">Warehouse</label> :
                      {{ DATA.warehouse_name }}
                    </div>
                  </div>
                </div>
              </div>
              <ul class="list-group">
                <li class="list-group-item bg-secondary text-light fs-5">
                  Payment Details ({{ payments.length }})
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
                    <div class="col-5">
                      <label class="form-label">Amount<i>*</i></label>
                      <input
                        type="number"
                        step="any"
                        class="form-control"
                        v-model="p.amount"
                        @focus="$event.target.select()"
                      />
                    </div>
                    <div class="col-3">
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
                    <div class="col-4">
                      <label class="form-label">Date & Time<i>*</i></label>
                      <input
                        type="datetime-local"
                        v-model="p.date_time"
                        class="form-control"
                      />
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
                      <div class="col-12 fs-4">Due Amount</div>
                      <div class="col-12 fs-4">
                        <span class="badge bg-light text-dark">{{
                          (
                            parseFloat(DATA.total_payable) -
                            parseFloat(DATA.total_paid)
                          ).toFixed(2)
                        }}</span>
                      </div>
                      <hr class="m-1" />
                      <div class="col-12 fs-4">Paying Amount</div>
                      <div class="col-12 fs-4">
                        <span class="badge bg-light text-dark">{{
                          parseFloat(calc.payingTotal()).toFixed(2)
                        }}</span>
                      </div>
                      <hr class="m-1" />
                      <div class="col-12 fs-4">
                        Balance {{ calc.balance() >= 0 ? "Due" : "Returned" }}
                      </div>
                      <div class="col-12 fs-4">
                        <span class="badge bg-light text-dark">{{
                          parseFloat(calc.balance()).toFixed(2)
                        }}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-body">
                    <div class="col">
                      <label class="form-label">Payment Note</label>
                      <textarea
                        type="text"
                        v-model="payment_note"
                        class="form-control"
                      ></textarea>
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
import { watch, ref, computed } from "vue";
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
    const DATA = ref({});
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
              date_time: yup.string().required().label("Date & Time"),
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
        payment_note: yup.string().nullable().label("Payment Note"),
      });
    });
    var formValues = {
      payments: [],
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
    const { value: payment_note } = useField("payment_note");
    const calc = {
      payingTotal: function () {
        var payingTotal = 0;
        payments.value.forEach((element, index, array) => {
          payingTotal += parseFloat(element.amount);
        });
        return payingTotal;
      },
      balance: function () {
        return (
          Number(DATA.value.total_payable) -
          Number(DATA.value.total_paid) -
          this.payingTotal()
        );
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
    function addNewPayment(mode, launch = false) {
      // launch is for first time show modal
      let total = 0;
      payments.value.forEach((element) => {
        total += element.amount;
      });
      let total_payable = Number(
        parseFloat(DATA.value.total_payable).toFixed(2)
      );
      let balance_payable = total_payable - total - DATA.value.total_paid;
      if (balance_payable <= 0 && launch == true) {
        // first time load and all amount is paid
        notifyDefault({ message: "Payment already completed !", type: "info" });
      } else {
        // create date
        let now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        let date_time = now.toISOString().slice(0, 16);
        //
        let payMethod = {
          id: Date.now(),
          date_time: date_time,
          amount: balance_payable > 0 ? balance_payable : 0,
          mode: mode,
          transaction_id: null,
          reference_no: null,
          note: null,
        };
        payments.value.push(payMethod);
        window.PURCHASE_PAY_MODAL.show();
      }
    }
    function removePayment(payment) {
      let index = payments.value.findIndex((item) => item.id === payment.id);
      payments.value.splice(index, 1);
    }
    emitter.on("purchasePayModal", (data) => {
      var data = data.data;
      console.log(data);
      payments.value = [];
      if (data.payments) {
        alert("edit pay");
        // edit payment
        payments.value = data.payments;
        var total_paid = 0;
        data.payments.forEach((element, index, array) => {
          total_paid += parseFloat(element.amount);
        });
        alert(total_paid);
      } else {
        // add payment
        payments.value = [];
        data.total_payable = Number(parseFloat(data.total_payable).toFixed(2));
      }
      payment_note.value = data.payment_note; // show from db
      data.total_paid = Number(parseFloat(data.total_paid).toFixed(2));
      data.due = Number(parseFloat(data.due).toFixed(2));
      DATA.value = data;
      addNewPayment(1, true);
    });
    function onInvalidSubmit({ values, errors }) {
      console.log("Form field errors found !");
      for (var key in errors) {
        notifyDefault({ message: errors[key] });
      }
    }
    const onSubmit = handleSubmit((values) => {
      values.purchase = DATA.value;
      return axiosAsyncCallReturnData("POST", "purchase", {
        action: "payment",
        data: values,
      }).then(function (data) {
        if (data.success == true) {
          window.PURCHASE_PAY_MODAL.hide();
          resetForm();
          emitter.emit("refreshPurchaseTable", data);
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
    watch(
      [payments],
      () => {
        //customer_readonly.value = customer.value ? true : false;
        emitter.emit("playSound", { file: "add.mp3" });
      },
      { deep: true }
    );
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
      payment_note,
      calc,
      paymentModes,
      addNewPayment,
      removePayment,
      onSubmit,
      isSubmitting,
      DATA,
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
    self.emitter.off("purchasePayModal");
    // turn off for duplicate calling
    // because its called multiple times when page loaded multiple times
  },
};
</script>