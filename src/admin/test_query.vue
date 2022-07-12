<template>
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-user-lock"></i><span>QUERY TESTER</span>
        </h5>
      </div>
      <div class="p-2 bd-highlight">
        <select
          class="form-select form-select-md"
          id="length_change"
          name="length_change"
        >
          <option selected>5</option>
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="-1">All</option>
        </select>
      </div>
      <div class="p-2 bd-highlight"><span id="buttons"></span></div>
      <div class="p-2 bd-highlight">
        <input
          class="form-control"
          id="search"
          type="search"
          placeholder="Search..."
        />
      </div>
    </div>
  </div>
  <div class="wrap_content" id="wrap_content">
    <table class="table table-bordered table-striped">
      <caption>
        {{
          Object.keys(DATA).length
        }}
        : Results
      </caption>
      <thead class="table-dark">
        <tr>
          <th scope="col" v-for="(value, key) in DATA[0]" :key="key">
            {{ key }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(value, key) in DATA" :key="key">
          <td v-for="(value1, key1) in value" :key="key1">
            {{ value1 }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<style>
</style>
<script>
/* eslint-disable */
import { ref } from "vue";
import admin from "@/mixins/admin.js";
export default {
  components: {},
  /* eslint-disable */
  setup() {
    const DATA = ref([]);
    // notify
    const {
      notifyDefault,
      notifyApiResponse,
      notifyCatchResponse,
      axiosAsyncCallReturnData,
    } = admin();
    return {
      DATA,
      notifyDefault,
      notifyApiResponse,
      notifyCatchResponse,
      axiosAsyncCallReturnData,
    };
  },
  methods: {},
  mounted() {
    var self = this;
    this.axiosAsyncCallReturnData(
      "get",
      "common",
      {
        action: "test_query",
      },
      null,
      {
        showSuccessNotification: false,
        showCatchNotification: true,
        showProgress: true,
      }
    ).then(function (data) {
      if (data.success == true) {
        console.log(data);
        self.DATA = data.data;
      } else {
      }
    });
  },
  beforeUnmount() {},
  data: function () {
    return {};
  },
};
</script>