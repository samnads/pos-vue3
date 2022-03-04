<template>
  <div class="form-inline menubar" id="menubar">
    <div class="d-flex bd-highlight align-items-baseline">
      <div class="p-2 flex-grow-1 bd-highlight">
        <h5 class="title">
          <i class="fa-solid fa-cart-arrow-down"></i><span>New Product</span>
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
    <form id="newProduct">
      <div class="row">
        <!-- main row -->
        <div class="col">
          <!-- column section 1 -->
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Product Type <i>*</i></label
              >
              <input
                type="text"
                v-model="product.type"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Product Code <i>*</i></label
              >
              <input
                type="text"
                v-model="product.code"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
            <div class="col">
              <label for="exampleInputPassword1" class="form-label"
                >Symbology</label
              >
              <input
                type="text"
                v-model="product.symbology"
                class="form-control"
                id="exampleInputPassword1"
              />
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Product Name <i>*</i></label
              >
              <input
                type="text"
                v-model="product.name"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >URL Slug<i>*</i></label
              >
              <input
                type="text"
                v-model="product.slug"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Product Weight <i>*</i></label
              >
              <input
                type="text"
                v-model="product.weight"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Category <i>*</i></label
              >
              <input
                type="text"
                v-model="product.category"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
            <div class="col">
              <label for="exampleInputPassword1" class="form-label"
                >Sub Category</label
              >
              <input
                type="text"
                v-model="product.sub_category"
                class="form-control"
                id="exampleInputPassword1"
              />
            </div>
          </div>
        </div>
        <!-- column section 2 -->
        <div class="col">
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Brand Name</label
              >
              <input
                type="text"
                v-model="product.brand"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
            <div class="col">
              <label for="exampleInputPassword1" class="form-label">MRP</label>
              <input
                type="text"
                v-model="product.mrp"
                class="form-control"
                id="exampleInputPassword1"
              />
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Product Unit <i>*</i></label
              >
              <input
                type="text"
                v-model="product.unit"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
            <div class="col">
              <label for="exampleInputPassword1" class="form-label"
                >Purchase Unit</label
              >
              <input
                type="text"
                v-model="product.p_unit"
                class="form-control"
                id="exampleInputPassword1"
              />
            </div>
            <div class="col">
              <label for="exampleInputPassword1" class="form-label"
                >Sale Unit</label
              >
              <input
                type="text"
                v-model="product.s_unit"
                class="form-control"
                id="exampleInputPassword1"
              />
            </div>
          </div>
        </div>
        <!-- column section 3 -->
        <div class="col">One of three columns</div>
      </div>
      <div class="d-flex pt-3">
        <div class="me-auto">
          <button type="button" class="btn btn-success" v-on:click="submit">Save</button>
        </div>
        <div class="">
          <button type="button" class="btn btn-info">Reset</button>
        </div>
      </div>
    </form>
  </div>
</template>
<style>
</style>
<script>
export default {
  components: {},
  data() {
    return {
      product: {},
    };
  },
  methods: {
    submit() {
      let data = JSON.parse(JSON.stringify(this.product));
      console.log(data)
    },
  },
  created() {},
  mounted() {},
};
</script>