<template>
  <div
    class="modal"
    id="deleteModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h5 class="modal-title" id="exampleModalLabel">
            Confirm Delete Product ?
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">{{ product.name }} | {{ product.code }}</div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-danger me-auto"
            v-on:click="confirmDeleteProduct(product)"
          >
            <i class="fa-solid fa-trash"></i>YES
          </button>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            <i class="fa-solid fa-stop"></i>NO
          </button>
        </div>
      </div>
    </div>
  </div>

  <div v-for="item in items" :key="item.id">
    <div
      class="position-fixed top-50 start-50 translate-middle pb-5"
      style="z-index: 11"
    >
      <div
        id="liveToast"
        class="toast text-white fade"
        :class="item.type"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-delay="2000"
      >
        <div class="d-flex">
          <div class="toast-body">
            <span v-html="item.message"></span>
          </div>
          <button
            type="button"
            class="btn-close btn-close-white me-2 m-auto"
            data-bs-dismiss="toast"
            aria-label="Close"
          ></button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
/* eslint-disable */
import AdminMain from "@//admin/AdminMain.vue";
import adminMixin from "@/mixins/admin.js";
export default {
  components: {
    AdminMain,
  },
  data() {
    return {
      items: [{"type":"bg-danger","message":"test message","id":"t1"},{"type":"bg-success","message":"test message 2","id":"t2"}],
    };
  },
  mixins: [adminMixin],
  props: {
    productData: Object,
  },
  computed: {
    product: function () {
      return this.productData;
    },
  },
  mounted() {},
  methods: {
    confirmDeleteProduct(product) {
      var self = this;
      let data = JSON.parse(JSON.stringify(product));
      //window.PROD_DELETE_MODAL.toggle();
      let json = { data: data, action: "delete", bulk: false };
      this.axios
        .delete("http://localhost/CyberLikes-POS/admin/ajax/product", {
          data: json,
        })
        .then(function (response) {
          let data = response.data;
          if (data.success == true) {
            //
          } else {
            //alert(data.message);
            self.toastResponse(data);
            console.log(self.toastBgClass);
          }
          window.PROD_DELETE_MODAL.toggle();
        })
        .catch((error) => {
          this.errorMessage = error.message;
          alert("There was an error! " + error);
        });
    },
  },
};
</script>

