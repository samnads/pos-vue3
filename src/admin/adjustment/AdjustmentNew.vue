<template>
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-cart-arrow-down"></i><span>New Adjustment</span>
        </h5>
      </div>
      <div class="p-2 bd-highlight"></div>
      <div class="p-2 bd-highlight"></div>
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
    <form @submit="onSubmit" class="needs-validation">
      <div class="card mb-2">
        <h5 class="card-header bg-secondary text-light">Basic Details</h5>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-3">
              <label for="date" class="form-label"> Warehouse<i>*</i></label>
              <select
                class="form-select"
                name="warehouse"
                id="warehouse"
              ></select>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-3">
              <label class="form-label">Mfg. Date</label>
              <div class="input-group is-invalid">
                <span class="input-group-text"
                  ><i class="fa-solid fa-calendar"></i
                ></span>
                <input
                  type="date"
                  name="mfg_date"
                  v-model="mfg_date"
                  class="form-control"
                />
              </div>
              <div class="invalid-feedback">{{ errorMfgDate }}</div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-3">
              <label class="form-label">Reference No.</label>
              <div class="input-group is-invalid">
                <input
                  type="text"
                  name="ref_no"
                  v-model="ref_no"
                  class="form-control"
                />
              </div>
              <div class="invalid-feedback">{{}}</div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-3">
              <label class="form-label">Note</label>
              <div class="input-group is-invalid">
                <textarea
                  type="text"
                  name="note"
                  v-model="note"
                  class="form-control"
                >
                </textarea>
              </div>
              <div class="invalid-feedback">{{}}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <h5 class="card-header bg-secondary text-light">Products</h5>
        <div class="card-body">
          <div class="col-12 mb-2">
            <div class="input-group is-invalid">
              <span class="input-group-text"
                ><i class="fa-solid fa-magnifying-glass"></i
              ></span>
              <input
                type="text"
                name="search"
                v-model="search"
                class="form-control"
                placeholder="Scan or type product name..."
              />
            </div>
          </div>
          <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Code | Name</th>
                <th scope="col">Type</th>
                <th scope="col">Quantity</th>
                <th scope="col">Note</th>
                <th scope="col" style="width: 1%">
                  <i class="fa-solid fa-trash-can"></i>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>111</td>
                <td>Addition</td>
                <td>
                  <div class="input-group is-invalid">
                    <button
                      type="button"
                      class="btn btn-secondary input-group-text"
                    >
                      <i class="fa-solid fa-plus solo"></i>
                    </button>
                    <input type="number" class="form-control" />
                    <button
                      type="button"
                      class="btn btn-secondary input-group-text"
                    >
                      <i class="fa-solid fa-minus solo"></i>
                    </button>
                  </div>
                </td>
                <td><input type="text" class="form-control" /></td>
                <td class="text-danger" role="button">
                  <i class="fa-solid fa-trash-can"></i>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </form>
  </div>
</template>
<style>
</style>
<script>
export default {
  props: {},
  components: {},
  setup() {
    var tags = [
      "ActionScript",
      "AppleScript",
      "Asp",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme",
    ];
    return { tags };
  },
  data() {
    return {};
  },
  watch: {},
  methods: {},
  created() {},
  mounted() {
    $("#search").autocomplete({
      source: tags,
    });
  },
};
</script>