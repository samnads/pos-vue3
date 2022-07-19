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
    <form @submit="onSubmit" class="needs-validation">
      <div class="row">
        <!-- main row -->
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-3">
          <!-- column section 1 -->
          <div class="row mb-1">
            <div class="col">
              <label for="producttype" class="form-label">
                Product Type<i>*</i></label
              >
              <select
                class="form-select"
                name="type"
                :disabled="!productTypes"
                v-model="type"
                id="producttype"
                v-bind:class="[
                  errorType
                    ? 'is-invalid'
                    : productTypes && type
                    ? 'is-valid'
                    : '',
                ]"
              >
                <option selected :value="formValues.type" v-if="!productTypes">
                  Loading...
                </option>
                <option selected :value="null" v-if="productTypes">
                  Select product type...
                </option>
                <option v-for="t in productTypes" :key="t.id" :value="t.id">
                  {{ t.name }}
                </option>
              </select>
              <div class="invalid-feedback">{{ errorType }}</div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="exampleInputEmail1" class="form-label"
                >Product Code<i>*</i></label
              >
              <div class="input-group has-validation">
                <span class="input-group-text"
                  ><i class="fa-solid fa-barcode"></i
                ></span>
                <input
                  type="text"
                  name="code"
                  v-model="code"
                  class="form-control"
                  id="productcode"
                  v-bind:class="[
                    errorCode
                      ? 'is-invalid'
                      : !errorCode && code
                      ? 'is-valid'
                      : '',
                  ]"
                />
                <span
                  class="input-group-text text-primary"
                  role="button"
                  @click="genRandCode"
                  ><i class="fa-solid fa-shuffle"></i
                ></span>
                <div class="invalid-feedback">{{ errorCode }}</div>
              </div>
            </div>
            <div class="col">
              <label for="exampleInputPassword1" class="form-label"
                >Symbology<i>*</i></label
              >
              <select
                class="form-select"
                name="symbology"
                :disabled="!symbologies"
                v-model="symbology"
                id="productsymbology"
                v-bind:class="[
                  errorSymbology
                    ? 'is-invalid'
                    : symbologies && symbology
                    ? 'is-valid'
                    : '',
                ]"
              >
                <option
                  selected
                  :value="formValues.symbology"
                  v-if="!symbologies"
                >
                  Loading...
                </option>
                <option selected :value="null" v-if="symbologies">
                  -- Select symbology --
                </option>
                <option v-for="s in symbologies" :key="s.id" :value="s.id">
                  {{ s.code }}
                </option>
              </select>
              <div class="invalid-feedback">{{ errorSymbology }}</div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="" class="form-label">Product Name<i>*</i></label>
              <input
                type="text"
                name="name"
                v-model="name"
                class="form-control"
                id="productname"
                @input="handleChangeName"
                v-bind:class="[
                  errorName
                    ? 'is-invalid'
                    : !errorName && name
                    ? 'is-valid'
                    : '',
                ]"
              />
              <div class="invalid-feedback">{{ errorName }}</div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="" class="form-label">URL Slug<i>*</i></label>
              <input
                type="text"
                name="slug"
                v-model="slug"
                class="form-control"
                @input="handleChangeSlug"
                v-bind:class="[
                  errorSlug
                    ? 'is-invalid'
                    : !errorSlug && slug
                    ? 'is-valid'
                    : '',
                ]"
              />
              <div class="invalid-feedback">{{ errorSlug }}</div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="" class="form-label">Weight</label>
              <input
                type="number"
                name="weight"
                v-model="weight"
                class="form-control"
                v-bind:class="[
                  errorWeight
                    ? 'is-invalid'
                    : !errorWeight && weight
                    ? 'is-valid'
                    : '',
                ]"
              />
              <div class="invalid-feedback">{{ errorWeight }}</div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="" class="form-label">Category<i>*</i></label>
              <div class="input-group is-invalid">
                <select
                  class="form-select"
                  name="category"
                  :disabled="!computed_categories"
                  v-model="category"
                  v-bind:class="[
                    errorCategory
                      ? 'is-invalid'
                      : computed_categories && category
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option
                    selected
                    :value="formValues.category"
                    v-if="!computed_categories"
                  >
                    Loading...
                  </option>
                  <option :value="null" selected>
                    {{
                      !computed_categories
                        ? "Updating..."
                        : "-- Select (" + computed_categories.length + ")--"
                    }}
                  </option>
                  <option v-for="c in computed_categories" :key="c.id" :value="c.id">
                    {{ c.name }}
                  </option>
                </select>
                <span
                  class="input-group-text text-primary"
                  role="button"
                  @click="newCategory"
                  v-if="computed_categories"
                  ><i class="fa-solid fa-plus"></i
                ></span>
              </div>
              <div class="invalid-feedback">{{ errorCategory }}</div>
            </div>
          </div>
        </div>
        <!-- column section 2 -->
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-5">
          <div class="row mb-1">
            <div class="col">
              <label for="" class="form-label">Brand Name</label>
              <div class="input-group is-invalid">
                <select
                  class="form-select"
                  name="brand"
                  :disabled="!brands"
                  v-model="brand"
                  v-bind:class="[
                    errorBrand
                      ? 'is-invalid'
                      : brands && brand
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option
                    :value="formValues.brand"
                    v-if="brands == undefined"
                    selected
                  >
                    Loading...
                  </option>
                  <option :value="null" selected>
                    {{ brands == false ? "Updating..." : " -- Select --" }}
                  </option>
                  <option v-for="b in brands" :key="b.id" :value="b.id">
                    {{ b.name }}
                  </option>
                </select>
                <span
                  class="input-group-text text-info"
                  role="button"
                  @click="newBrand"
                  v-if="brands"
                  ><i class="fa-solid fa-plus"></i
                ></span>
              </div>
              <div class="invalid-feedback">{{ errorBrand }}</div>
            </div>
            <div class="col">
              <label class="form-label">MRP</label>
              <div class="input-group is-invalid">
                <span class="input-group-text">₹</span>
                <input
                  type="number"
                  step="any"
                  name="mrp"
                  placeholder="Maximum retail price"
                  v-model="mrp"
                  class="form-control"
                  id="productcode"
                  v-bind:class="[
                    errorMrp
                      ? 'is-invalid'
                      : !errorMrp && mrp
                      ? 'is-valid'
                      : '',
                  ]"
                />
              </div>
              <div class="invalid-feedback">{{ errorMrp }}</div>
            </div>
          </div>
          <div class="row mb-1">
            <div class="col">
              <label for="" class="form-label">Product Unit<i>*</i></label>
              <div class="input-group is-invalid">
                <select
                  class="form-select"
                  name="unit"
                  :disabled="!units"
                  v-model="unit"
                  v-bind:class="[
                    units && errorUnit
                      ? 'is-invalid'
                      : units && unit
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option
                    :value="formValues.unit"
                    v-if="units == undefined"
                    selected
                  >
                    Loading...
                  </option>
                  <option :value="null" selected>
                    {{ units == false ? "Updating..." : "-- Select --" }}
                  </option>
                  <option v-for="u in units" :key="u.id" :value="u.id">
                    {{ u.name }}
                  </option>
                </select>
                <span
                  class="input-group-text text-info"
                  role="button"
                  @click="newUnit"
                  v-if="units"
                  ><i class="fa-solid fa-plus"></i
                ></span>
              </div>
              <div class="invalid-feedback">{{ units ? errorUnit : "" }}</div>
            </div>
            <div class="col">
              <label for="" class="form-label">Purchase Unit</label>
              <div class="input-group is-invalid">
                <select
                  class="form-select"
                  name="p_unit"
                  :disabled="!unitsBulk || !unit"
                  v-model="p_unit"
                  v-bind:class="[
                    errorPUnit
                      ? 'is-invalid'
                      : !errorPUnit && p_unit
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option selected :value="formValues.p_unit" v-if="!unitsBulk">
                    {{ unitsBulk == undefined ? "Loading..." : "Updating..." }}
                  </option>
                  <option selected :value="null" v-if="unitsBulk">
                    {{
                      unit
                        ? units.find((obj) => {
                            return obj.id === unit;
                          })["name"]
                        : "Select base unit first"
                    }}
                  </option>
                  <option v-for="u in unitsBulk" :key="u.id" :value="u.id">
                    {{ u.name }}
                  </option>
                </select>
                <button
                  class="input-group-text text-info"
                  type="button"
                  @click="newUnitBulk"
                  v-if="unitsBulk && unit"
                >
                  <i class="fa-solid fa-plus"></i>
                </button>
              </div>
              <div class="invalid-feedback">{{ errorPUnit }}</div>
            </div>
            <div class="col">
              <label for="" class="form-label">Sale Unit</label>
              <div class="input-group is-invalid">
                <select
                  class="form-select"
                  name="s_unit"
                  :disabled="!unitsBulk || !unit"
                  v-model="s_unit"
                  v-bind:class="[
                    errorSUnit
                      ? 'is-invalid'
                      : !errorSUnit && s_unit
                      ? 'is-valid'
                      : '',
                  ]"
                >
                  <option selected :value="formValues.s_unit" v-if="!unitsBulk">
                    {{ unitsBulk == undefined ? "Loading..." : "Updating..." }}
                  </option>
                  <option selected :value="null" v-if="unitsBulk">
                    {{
                      unit
                        ? units.find((obj) => {
                            return obj.id === unit;
                          })["name"]
                        : "Select base unit first"
                    }}
                  </option>
                  <option v-for="u in unitsBulk" :key="u.id" :value="u.id">
                    {{ u.name }}
                  </option>
                </select>
                <button
                  class="input-group-text text-info"
                  type="button"
                  @click="newUnitBulk"
                  v-if="unitsBulk && unit"
                >
                  <i class="fa-solid fa-plus"></i>
                </button>
              </div>
              <div class="invalid-feedback">{{ errorSUnit }}</div>
            </div>
          </div>
          <div class="row mb-1">
            <div class="col">
              <label class="form-label"
                >Stock Alert Quantity<i v-if="isalert">*</i></label
              >
              <div class="input-group is-invalid">
                <span class="form-control" v-if="!isalert">{{
                  isalert ? "Enabled ✅" : "Alert Disabled ❌"
                }}</span>
                <input
                  type="number"
                  name="alert_quantity"
                  v-model="alert_quantity"
                  placeholder="Quantity for alert"
                  class="form-control"
                  v-bind:class="[
                    errorAlertQuantity
                      ? 'is-invalid'
                      : !errorAlertQuantity && alert_quantity
                      ? 'is-valid'
                      : '',
                  ]"
                  v-if="isalert"
                />
                <div
                  class="input-group-text"
                  role="button"
                  @click="toggleAlert"
                >
                  <div class="form-check form-switch">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      role="switch"
                      name="isalert"
                      v-model="isalert"
                    />
                  </div>
                </div>
              </div>
              <div class="invalid-feedback">{{ errorIsalert }}</div>
              <div class="invalid-feedback">{{ errorAlertQuantity }}</div>
            </div>
            <div class="col">
              <label class="form-label">Product Image</label>
              <div class="input-group">
                <input
                  type="file"
                  class="form-control"
                  id="inputGroupFile04"
                  aria-describedby="inputGroupFileAddon04"
                  aria-label="Upload"
                />
              </div>
            </div>
          </div>
          <div class="row mb-1">
            <div class="col">
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
            <div class="col">
              <label class="form-label">Exp. Date</label>
              <div class="input-group is-invalid">
                <span class="input-group-text"
                  ><i class="fa-solid fa-calendar"></i
                ></span>
                <input
                  type="date"
                  name="exp_date"
                  v-model="exp_date"
                  class="form-control"
                />
              </div>
              <div class="invalid-feedback">{{ errorExpDate }}</div>
            </div>
          </div>
        </div>
        <!-- column section 3 -->
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6 col-xxl-4">
          <div class="card mb-1">
            <h5 class="card-header bg-secondary text-light">
              Purchase Information
            </h5>
            <div class="card-body">
              <div class="row"></div>
            </div>
          </div>
          <div class="card">
            <h5 class="card-header bg-secondary text-light">
              Selling Information
            </h5>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <label class="form-label">Cost<i>*</i></label>
                  <div class="input-group is-invalid">
                    <input
                      type="number"
                      step="any"
                      name="cost"
                      v-model="cost"
                      class="form-control"
                      v-bind:class="[
                        errorCost
                          ? 'is-invalid'
                          : !errorCost && cost
                          ? 'is-valid'
                          : '',
                      ]"
                    /><span class="input-group-text">₹</span>
                  </div>
                  <div class="invalid-feedback">{{ errorCost }}</div>
                </div>
                <div class="col">
                  <label for="taxrate" class="form-label">Tax Rate</label>
                  <div class="input-group is-invalid">
                    <select
                      class="form-select"
                      name="tax_rate"
                      :disabled="!taxes"
                      v-model="tax_rate"
                      id="taxrate"
                      v-bind:class="[
                        errorTaxRate
                          ? 'is-invalid'
                          : taxes && tax_rate
                          ? 'is-valid'
                          : '',
                      ]"
                    >
                      <option
                        :value="formValues.tax_rate"
                        v-if="taxes == undefined"
                        selected
                      >
                        Loading...
                      </option>
                      <option :value="null" selected>
                        {{ taxes == false ? "Updating..." : "-- No Tax --" }}
                      </option>
                      <option v-for="tr in taxes" :key="tr.id" :value="tr.id">
                        {{
                          tr.name +
                          " ~ " +
                          parseInt(tr.rate).toFixed(2) +
                          (tr.type == "P" ? " %" : " (Fixed Rate)")
                        }}
                      </option>
                    </select>
                    <button
                      class="input-group-text text-info"
                      type="button"
                      @click="newTaxRate"
                      v-if="taxes"
                    >
                      <i class="fa-solid fa-plus"></i>
                    </button>
                  </div>
                  <div class="invalid-feedback">{{ errorTaxRate }}</div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="tax_method" class="form-label"
                    >Tax Method<i>*</i></label
                  >
                  <div class="input-group is-invalid">
                    <select
                      class="form-select"
                      name="tax_method"
                      v-model="tax_method"
                      id="tax_method"
                      v-bind:class="[
                        errorTaxMethod
                          ? 'is-invalid'
                          : tax_method
                          ? 'is-valid'
                          : '',
                      ]"
                    >
                      <option value="I">Inclusive</option>
                      <option value="E">Exclusive</option>
                    </select>
                  </div>
                  <div class="invalid-feedback">{{ errorTaxMethod }}</div>
                </div>
                <div class="col">
                  <label class="form-label">Tax</label>
                  <div class="input-group is-invalid">
                    <input
                      type="number"
                      step="any"
                      name="tax"
                      v-model="tax"
                      class="form-control"
                      v-bind:class="[
                        errorTax
                          ? 'is-invalid'
                          : !errorTax && tax
                          ? 'is-valid'
                          : '',
                      ]"
                      readonly
                    />
                    <span class="input-group-text">₹</span>
                  </div>
                  <div class="invalid-feedback">{{ errorTax }}</div>
                </div>
              </div>
              <div class="row mb-1">
                <div class="col">
                  <label class="form-label">Markup</label>
                  <div class="input-group is-invalid">
                    <input
                      type="number"
                      step="any"
                      name="markup"
                      v-model="markup"
                      class="form-control"
                      v-bind:class="[
                        errorMarkup
                          ? 'is-invalid'
                          : !errorMarkup && markup
                          ? 'is-valid'
                          : '',
                      ]"
                    />
                    <span class="input-group-text"
                      ><i class="fa-solid fa-percent"></i
                    ></span>
                  </div>
                  <div class="invalid-feedback">{{ errorMarkup }}</div>
                </div>
                <div class="col">
                  <label class="form-label text-success"
                    >Price Tag<i>*</i></label
                  >
                  <div class="input-group is-invalid">
                    <input
                      type="number"
                      step="any"
                      name="tag_price"
                      v-model="tag_price"
                      class="form-control"
                      v-bind:class="[
                        errorTagPrice
                          ? 'is-invalid'
                          : !errorTagPrice && tag_price
                          ? 'is-valid'
                          : '',
                      ]"
                    />
                    <span class="input-group-text">₹</span>
                  </div>
                  <div class="invalid-feedback">{{ errorTagPrice }}</div>
                </div>
              </div>
              <div class="row mb-1">
                <div class="col">
                  <label class="form-label">Auto Discount</label>
                  <div class="input-group is-invalid">
                    <input
                      type="number"
                      step="any"
                      name="auto_discount"
                      v-model="auto_discount"
                      class="form-control"
                      id="productcode"
                      v-bind:class="[
                        errorAutoDiscount
                          ? 'is-invalid'
                          : !errorAutoDiscount && auto_discount
                          ? 'is-valid'
                          : '',
                      ]"
                    />
                    <div class="input-group-text">
                      <input
                        class="form-check-input mt-0"
                        type="radio"
                        name="auto_disc_type"
                        v-model="auto_disc_type"
                        value="P"
                      />&nbsp;<strong>%</strong>
                    </div>
                    <div class="input-group-text">
                      <input
                        class="form-check-input mt-0"
                        type="radio"
                        name="auto_disc_type"
                        v-model="auto_disc_type"
                        value="F"
                      />&nbsp;<strong>₹</strong>
                    </div>
                  </div>
                  <div class="invalid-feedback">{{ errorAutoDiscount }}</div>
                  <div class="invalid-feedback">{{ errorAutoDiscType }}</div>
                </div>
                <div class="col">
                  <label class="form-label text-success"
                    >Selling Price<i>*</i></label
                  >
                  <div class="input-group is-invalid">
                    <input
                      type="number"
                      step="any"
                      name="price"
                      v-model="price"
                      class="form-control"
                      readonly
                      v-bind:class="[
                        errorPrice
                          ? 'is-invalid'
                          : !errorPrice && price
                          ? 'is-valid'
                          : '',
                      ]"
                    />
                    <span class="input-group-text">₹</span>
                  </div>
                  <div class="invalid-feedback">{{ errorPrice }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
          <div class="card">
            <h5 class="card-header bg-secondary text-light">
              Product POS Settings
            </h5>
            <div class="card-body">
              <p class="card-text text-muted">
                This options are only for product level pos settings.
              </p>
              <hr />
              <div class="row mb-1">
                <div class="col">
                  <label class="form-check-label">POS Sale</label>
                  <div class="input-group is-invalid">
                    <span class="input-group-text form-control"
                      ><div class="form-check form-switch">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          role="switch"
                          name="pos_sale"
                          v-model="pos_sale"
                        /></div
                    ></span>
                  </div>
                  <div class="invalid-feedback">{{}}</div>
                </div>
                <div class="col">
                  <label class="form-check-label">Custom Discount</label>
                  <div class="input-group is-invalid">
                    <span class="input-group-text form-control"
                      ><div class="form-check form-switch">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          role="switch"
                          name="pos_custom_discount"
                          v-model="pos_custom_discount"
                        /></div
                    ></span>
                  </div>
                  <div class="invalid-feedback">{{}}</div>
                </div>
                <div class="col">
                  <label class="form-check-label">Custom Tax</label>
                  <div class="input-group is-invalid">
                    <span class="input-group-text form-control"
                      ><div class="form-check form-switch">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          role="switch"
                          name="pos_custom_tax"
                          v-model="pos_custom_tax"
                        /></div
                    ></span>
                  </div>
                  <div class="invalid-feedback">{{}}</div>
                </div>
                <div class="col">
                  <label class="form-check-label">Product Sale Note</label>
                  <div class="input-group is-invalid">
                    <span class="input-group-text form-control"
                      ><div class="form-check form-switch">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          role="switch"
                          name="pos_sale_note"
                          v-model="pos_sale_note"
                        /></div
                    ></span>
                  </div>
                  <div class="invalid-feedback">{{}}</div>
                </div>
                <div class="col">
                  <label class="form-label"
                    >Minimum Sale Quantity<i>*</i></label
                  >
                  <div class="input-group is-invalid">
                    <input type="number" class="form-control" :value="1" />
                    <span class="input-group-text" v-if="unitsBulk"
                      ><!--{{
                      unitsBulk && unit && s_unit == null
                        ? units.find((obj) => {
                            return obj.id === unit;
                          })["code"]
                        : unitsBulk && s_unit > 0
                        ? unitsBulk.find((obj) => {
                            return obj.id === s_unit;
                          })["code"]
                        : "?"
                    }}--></span
                    >
                  </div>
                  <div class="invalid-feedback">{{ errorRefNo }}</div>
                </div>
                <div class="col">
                  <label class="form-label">Maximum Sale Quantity</label>
                  <div class="input-group is-invalid">
                    <input type="number" class="form-control" />
                    <span class="input-group-text" v-if="unitsBulk"
                      ><!--{{
                      unitsBulk && unit && s_unit == null
                        ? units.find((obj) => {
                            return obj.id === unit;
                          })["code"]
                        : unitsBulk && s_unit > 0
                        ? unitsBulk.find((obj) => {
                            return obj.id === s_unit;
                          })["code"]
                        : "?"
                    }}--></span
                    >
                  </div>
                  <div class="invalid-feedback">{{ errorRefNo }}</div>
                </div>
              </div>
              <p class="card-text text-muted">
                Custom Product Data Fields ( for example Serial No. or IMEI
                etc.)
              </p>
              <hr />
              <div class="row mb-1">
                <div class="col">
                  <label class="form-check-label"
                    >POS Data Field - 1
                    {{ dataFields.includes(dbData.pos_data_field_1)[0] }}</label
                  >
                  <select
                    class="form-select"
                    name="pos_data_field_1"
                    v-model="pos_data_field_1"
                  >
                    <option :value="null" selected>-- Select --</option>
                    <option
                      :value="dbData.pos_data_field_1"
                      v-if="
                        route.name == 'adminProductEdit' &&
                        dbData.pos_data_field_1 &&
                        !dataFields.find(
                          (o) => o.value === dbData.pos_data_field_1
                        )
                      "
                    >
                      {{ dbData.pos_data_field_1 }}
                    </option>
                    <option
                      v-for="dataField in dataFields"
                      :key="dataField.value"
                      :value="dataField.value"
                    >
                      {{ dataField.value }}
                    </option>
                  </select>
                  <div class="invalid-feedback">{{}}</div>
                </div>
                <div class="col">
                  <label class="form-check-label">POS Data Field - 2</label>
                  <select
                    class="form-select"
                    name="pos_data_field_2"
                    v-model="pos_data_field_2"
                  >
                    <option :value="null" selected>-- Select --</option>
                    <option
                      :value="formValues.pos_data_field_2"
                      v-if="
                        route.name == 'adminProductEdit' &&
                        dbData.pos_data_field_2 &&
                        !dataFields.find(
                          (o) => o.value === dbData.pos_data_field_2
                        )
                      "
                    >
                      {{ dbData.pos_data_field_2 }}
                    </option>
                    <option
                      v-for="dataField in dataFields"
                      :key="dataField.value"
                      :value="dataField.value"
                    >
                      {{ dataField.value }}
                    </option>
                  </select>
                  <div class="invalid-feedback">{{}}</div>
                </div>
                <div class="col">
                  <label class="form-check-label">POS Data Field - 3</label>
                  <input
                    type="text"
                    name="pos_data_field_3"
                    v-model="pos_data_field_3"
                    class="form-control"
                  />
                  <div class="invalid-feedback">{{}}</div>
                </div>
                <div class="col">
                  <label class="form-check-label">POS Data Field - 4</label>
                  <input
                    type="text"
                    name="pos_data_field_4"
                    v-model="pos_data_field_4"
                    class="form-control"
                  />
                  <div class="invalid-feedback">{{}}</div>
                </div>
                <div class="col">
                  <label class="form-check-label">POS Data Field - 5</label>
                  <input
                    type="text"
                    name="pos_data_field_5"
                    v-model="pos_data_field_5"
                    class="form-control"
                  />
                  <div class="invalid-feedback">{{}}</div>
                </div>
                <div class="col">
                  <label class="form-check-label">POS Data Field - 6</label>
                  <input
                    type="text"
                    name="pos_data_field_6"
                    v-model="pos_data_field_6"
                    class="form-control"
                  />
                  <div class="invalid-feedback">{{}}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row" v-if="route.name != 'adminProductEdit'">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
          <div class="card">
            <h5 class="card-header bg-secondary text-light">
              Stock Adjustment
            </h5>
            <div class="card-body">
              <p class="card-text text-muted">
                You can add an opening stock or adjust the current stock.
              </p>
              <div class="row mb-1">
                <div class="col">
                  <label class="form-label">Warehouse</label>
                  <div class="input-group is-invalid">
                    <select
                      class="form-select"
                      name="warehouse"
                      :disabled="!warehouses"
                      v-model="warehouse"
                      v-bind:class="[
                        errorWareHouse
                          ? 'is-invalid'
                          : warehouses && warehouse
                          ? 'is-valid'
                          : '',
                      ]"
                    >
                      <option :value="null" selected>
                        {{ warehouses ? "-- Select --" : "Loading..." }}
                      </option>
                      <option
                        v-for="wh in warehouses"
                        :key="wh.id"
                        :value="wh.id"
                      >
                        {{ wh.name }}
                      </option>
                    </select>
                  </div>
                  <div class="invalid-feedback">{{ errorWareHouse }}</div>
                </div>
                <div class="col">
                  <label class="form-label"
                    >Adjustment Quantity<i v-if="warehouse">*</i></label
                  >
                  <div class="input-group is-invalid">
                    <input
                      type="number"
                      name="stock_adj_count"
                      v-model="stock_adj_count"
                      class="form-control"
                      placeholder="+/-"
                      v-bind:class="[
                        errorStockAdjCount
                          ? 'is-invalid'
                          : stock_adj_count
                          ? 'is-valid'
                          : '',
                      ]"
                    />
                  </div>
                  <div class="invalid-feedback">{{ errorStockAdjCount }}</div>
                </div>
                <div class="col">
                  <label class="form-label">Reference No.</label>
                  <div class="input-group is-invalid">
                    <input
                      type="number"
                      name="ref_no"
                      v-model="ref_no"
                      class="form-control"
                    />
                  </div>
                  <div class="invalid-feedback">{{ errorRefNo }}</div>
                </div>
                <div class="col">
                  <label class="form-label">Adustment Note</label>
                  <div class="input-group is-invalid">
                    <textarea
                      type="number"
                      name="stock_adj_note"
                      v-model="stock_adj_note"
                      class="form-control"
                      rows="1"
                    >
                    </textarea>
                  </div>
                  <div class="invalid-feedback">{{ errorStockAdjNote }}</div>
                </div>
                <div class="col">
                  <label class="form-label">Opening Stock</label>
                  <div class="input-group is-invalid">
                    <input
                      type="number"
                      class="form-control"
                      :value="0"
                      disabled
                    />
                  </div>
                  <div class="invalid-feedback">{{}}</div>
                </div>
                <div class="col">
                  <label class="form-label">Final Stock</label>
                  <div class="input-group is-invalid">
                    <input
                      type="number"
                      class="form-control"
                      :value="0"
                      disabled
                    />
                  </div>
                  <div class="invalid-feedback">{{}}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex pt-3">
        <div class="me-auto">
          <button
            type="submit"
            class="btn btn-success"
            :disabled="isSubmitting"
          >
            {{ isSubmitting ? "Saving..." : "Save" }}
            <span
              class="spinner-border spinner-border-sm"
              role="status"
              aria-hidden="true"
              v-if="isSubmitting"
            ></span>
          </button>
        </div>
        <div class="">
          <button
            type="button"
            class="btn btn-secondary"
            v-if="isDirty && !isSubmitting"
            @click="resetCustom"
          >
            <i class="fa-solid fa-rotate-left"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
</template>
<style>
</style>
<script>
import {
  useForm,
  useField,
  useIsFormDirty,
  useIsFormValid,
} from "vee-validate";
import * as yup from "yup";
import { ref, computed } from "vue";
import { useStore } from "vuex";
//import adminMixin from "@/mixins/admin.js";
import admin from "@/mixins/admin.js";
import adminProduct from "@/mixins/adminProduct.js";
import { useRouter, useRoute } from "vue-router";
export default {
  props: {},
  components: {
  },
  setup() {
    const route = useRoute();
    const router = useRouter();
    const { randCode } = adminProduct();
    const {
      notifyDefault,
      axiosAsyncCallReturnData,
      axiosAsyncStoreUpdateReturnData,
      axiosAsyncStoreReturnBool,
      x_percentage_of_y,
    } = admin();
    /**************************************** */ // from store
    const store = useStore();
    let productTypes = computed(function () {
      return store.state.productTypes;
    });
    let symbologies = computed(function () {
      return store.state.symbologies;
    });
    let categories = computed(function () {
      return store.state.categories;
    });
    let brands = computed(function () {
      return store.state.brands;
    });
    let units = computed(function () {
      return store.state.units;
    });
    let unitsBulk = computed(function () {
      return store.state.units_bulk;
    });
    let taxes = computed(function () {
      return store.state.TAXES;
    });
    let warehouses = computed(function () {
      return store.state.WARE_HOUSES;
    });
    /**************************************** */ // category things
    var cats_list = ref([]);
    var hyphen_count = ref(0);
    /************************************************************************* */
    var formValues = {}; // pre form values
    var dbData = ref({}); // pre form data for edit product
    var dataFields = [
      { value: "Serial No." },
      { value: "IMEI No." },
      { value: "Color" },
    ];
    if (route.name == "adminProductEdit" && route.params.data) {
      dbData.value = JSON.parse(route.params.data); // required
      formValues = {
        type: dbData.value.type,
        code: dbData.value.code,
        symbology: dbData.value.symbology,
        name: dbData.value.name,
        slug: dbData.value.slug,
        weight: dbData.value.weight,
        category: dbData.value.category,
        cost: Number(dbData.value.cost),
        tax_method: dbData.value.tax_method,
        tax_rate: dbData.value.tax_rate,
        //markup: dbData.value.markup,
        brand: dbData.value.brand,
        mrp: dbData.value.mrp,
        unit: dbData.value.unit,
        p_unit: dbData.value.p_unit,
        s_unit: dbData.value.s_unit,
        isalert: dbData.value.alert == "1" ? true : false,
        alert_quantity: dbData.value.alert_quantity,
        mfg_date: dbData.value.mfg_date,
        exp_date: dbData.value.exp_date,
        tag_price: dbData.value.price,
        price: dbData.value.price - dbData.value.auto_discount,
        auto_discount: dbData.value.auto_discount,
        pos_sale: dbData.value.pos_sale == "1" ? true : false,
        pos_custom_discount:
          dbData.value.pos_custom_discount == "1" ? true : false,
        pos_custom_tax: dbData.value.pos_custom_tax == "1" ? true : false,
        pos_sale_note: dbData.value.pos_sale_note == "1" ? true : false,
        pos_min_sale_qty: dbData.value.pos_min_sale_qty,
        pos_max_sale_qty: dbData.value.pos_max_sale_qty,
        pos_data_field_1: dbData.value.pos_data_field_1,
        pos_data_field_2: dbData.value.pos_data_field_2,
        pos_data_field_3: dbData.value.pos_data_field_3,
        pos_data_field_4: dbData.value.pos_data_field_4,
        pos_data_field_5: dbData.value.pos_data_field_5,
        pos_data_field_6: dbData.value.pos_data_field_6,
        auto_disc_type: "F",
      };
    } else if (route.name == "adminProductCopy" && route.params.data) {
      formValues = {};
    } else if (route.name == "adminProductNew") {
      formValues = {
        type: 1,
        symbology: 1,
        category: 2,
        brand: null,
        unit: 1,
        p_unit: null,
        s_unit: null,
        isalert: true,
        tax_rate: null,
        tax_method: "I",
        markup: 50,
        auto_disc_type: "F",
        warehouse: null,
        pos_sale: true,
        pos_custom_discount: true,
        pos_sale_note: true,
        pos_data_field_1: null,
        pos_data_field_2: null,
      };
    } else {
      router.push({ name: "adminProductList" }).catch(() => {});
    }
    /************************************************************************* */
    const schema = computed(() => {
      return yup.object({
        type: yup
          .number()
          .required()
          .min(1)
          .nullable(true)
          .label("Product Type"),
        code: yup
          .string()
          .required()
          .min(3)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("Product Code"),
        symbology: yup
          .number()
          .required()
          .min(1)
          .nullable(true)
          .label("Barcode Symbology"),
        name: yup
          .string()
          .required()
          .min(3)
          .max(100)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("Product Name"),
        slug: yup
          .string()
          .required()
          .min(3)
          .max(100)
          .transform((_, val) => (val.length > 0 ? val : undefined))
          .label("URL Slug"),
        weight: yup
          .number()
          .min(0)
          .max(10)
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Product Weight"),
        category: yup
          .number()
          .required()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Category"),
        brand: yup.number().nullable(true).label("Brand Name"),
        tag_price: yup
          .number()
          .required()
          .nullable(true)
          .typeError("Tag Price must be a number")
          .when("mrp", {
            is: (mrp) => Number(mrp),
            then: yup
              .number()
              .required()
              .nullable(true)
              .typeError("Tag Price must be a number")
              .max(yup.ref("mrp"), "Tag Price must be less than MRP"),
          })
          .label("Tag Price"),
        price: yup
          .number()
          .required()
          .nullable(true)
          .typeError("Selling Price must be a number")
          .when("mrp", {
            is: (mrp) => Number(mrp),
            then: yup
              .number()
              .required()
              .nullable(true)
              .typeError("Selling Price must be a number")
              .max(yup.ref("mrp"), "Selling Price must be less than MRP"),
          })
          .label("Selling Price"),
        mrp: yup
          .number()
          .nullable(true)
          .typeError("MRP must be a number")
          .transform((_, val) => (val ? Number(val) : null))
          .label("MRP"),
        markup: yup
          .number()
          .nullable(true)
          .typeError("Markupn must be a number")
          .transform((_, val) => (val ? Number(val) : null))
          .label("Markup"),
        unit: yup
          .number()
          .required()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Unit"),
        p_unit: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Purchase Unit"),
        s_unit: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Sale Unit"),
        alert_quantity: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .when("isalert", {
            is: true,
            then: yup
              .number()
              .nullable(true)
              .transform((_, val) => (val === Number(val) ? val : null))
              .required(),
          })
          .label("Alert Quantity"),
        tax_rate: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Tax Rate"),
        tax: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Tax"),
        cost: yup
          .number()
          .required()
          .nullable(true)
          .typeError("Cost must be a number")
          .transform((_, val) => (val ? Number(val) : null))
          .label("Cost"),
        auto_discount: yup
          .number()
          .nullable(true)
          .typeError("Discount must be a number")
          .min(0, "Discount price can't be less than 0")
          .transform((_, val) => (val ? Number(val) : null))
          .label("Auto Discount"),
        auto_disc_type: yup
          .string()
          .matches(/(F|P)/)
          .label("Auto Discount Type"),
        mfg_date: yup
          .date()
          .nullable(true)
          .transform((curr, orig) => (orig === "" ? null : curr))
          .label("Mfg. date"),
        exp_date: yup
          .date()
          .nullable(true)
          .transform((curr, orig) => (orig === "" ? null : curr))
          .when("mfg_date", {
            is: (mfg_date) => mfg_date,
            then: yup
              .date()
              .nullable(true)
              .transform((curr, orig) => (orig === "" ? null : curr))
              .min(
                yup.ref("mfg_date"),
                "Exp. date can't be less than Mfg. date"
              ),
          })
          .label("Exp. date"),
        warehouse: yup
          .number()
          .nullable(true)
          .transform((_, val) => (val === Number(val) ? val : null))
          .label("Warehouse"),
        stock_adj_count: yup
          .number()
          .nullable(true)
          .typeError("Invalid input")
          .when("warehouse", {
            is: (warehouse) => Number(warehouse),
            then: yup
              .number()
              .required()
              .nullable(true)
              .typeError("Invalid input"),
          })
          .label("Stock Adj. Count"),
      });
    });
    /************************************************************************* */
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
    /************************************************************************* */
    const { value: type, errorMessage: errorType } = useField("type");
    const { value: code, errorMessage: errorCode } = useField("code");
    const { value: symbology, errorMessage: errorSymbology } =
      useField("symbology");
    const {
      errorMessage: errorName,
      value: name,
      meta: metaName,
    } = useField("name");
    const { value: slug, errorMessage: errorSlug } = useField("slug");
    const { value: weight, errorMessage: errorWeight } = useField("weight");
    const { value: category, errorMessage: errorCategory } =
      useField("category");
    const { value: brand, errorMessage: errorBrand } = useField("brand");
    const { value: mrp, errorMessage: errorMrp } = useField("mrp");
    const { value: unit, errorMessage: errorUnit } = useField("unit");
    const { value: p_unit, errorMessage: errorPUnit } = useField("p_unit");
    const { value: s_unit, errorMessage: errorSUnit } = useField("s_unit");
    const { value: isalert, errorMessage: errorIsalert } = useField("isalert");
    const { value: alert_quantity, errorMessage: errorAlertQuantity } =
      useField("alert_quantity");
    const { value: mfg_date, errorMessage: errorMfgDate } =
      useField("mfg_date");
    const { value: exp_date, errorMessage: errorExpDate } =
      useField("exp_date");
    const { value: tax_rate, errorMessage: errorTaxRate } =
      useField("tax_rate");
    const { value: tax, errorMessage: errorTax } = useField("tax");
    const { value: tax_method, errorMessage: errorTaxMethod } =
      useField("tax_method");
    const { value: cost, errorMessage: errorCost } = useField("cost");
    const { value: markup, errorMessage: errorMarkup } = useField("markup");
    const { value: auto_discount, errorMessage: errorAutoDiscount } =
      useField("auto_discount");
    const { value: auto_disc_type, errorMessage: errorAutoDiscType } =
      useField("auto_disc_type");
    const { value: price, errorMessage: errorPrice } = useField("price");
    const { value: tag_price, errorMessage: errorTagPrice } =
      useField("tag_price");
    const { value: warehouse, errorMessage: errorWareHouse } =
      useField("warehouse");
    const { value: stock_adj_count, errorMessage: errorStockAdjCount } =
      useField("stock_adj_count");
    const { value: ref_no, errorMessage: errorRefNo } = useField("ref_no");
    const { value: stock_adj_note, errorMessage: errorStockAdjNote } =
      useField("stock_adj_note");
    // pos settings
    const { value: pos_sale } = useField("pos_sale");
    const { value: pos_custom_discount } = useField("pos_custom_discount");
    const { value: pos_custom_tax } = useField("pos_custom_tax");
    const { value: pos_sale_note } = useField("pos_sale_note");
    const { value: pos_data_field_1 } = useField("pos_data_field_1");
    const { value: pos_data_field_2 } = useField("pos_data_field_2");
    const { value: pos_data_field_3 } = useField("pos_data_field_3");
    const { value: pos_data_field_4 } = useField("pos_data_field_4");
    const { value: pos_data_field_5 } = useField("pos_data_field_5");
    const { value: pos_data_field_6 } = useField("pos_data_field_6");
    /************************************************************************* */
    const isDirty = useIsFormDirty();
    const isValid = useIsFormValid();
    /************************************************************************* */
    function onInvalidSubmit({ values }) {
      console.log("Form field errors found !");
      console.log(values);
    }
    const onSubmit = handleSubmit((values) => {
      values.db = route.name == "adminProductEdit" ? dbData.value : undefined; // for edit product
      return axiosAsyncCallReturnData(
        route.name == "adminProductEdit" ? "PUT" : "POST",
        "product",
        {
          action: "create",
          data: values,
        }
      ).then(function (data) {
        if (data.success == true) {
          console.log("Product added !");
        } else if (data.success == false) {
          console.log("Product not added !");
          // valid error
          if (data.errors) {
            for (var key in data.errors) {
              setFieldError(key, data.errors[key]);
            }
          }
        } else {
          // other error
        }
      });
    }, onInvalidSubmit);
    /************************************************************************* */
    function genRandCode() {
      setFieldValue("code", randCode());
    }
    function toggleAlert() {
      if (!isalert.value) {
        alert_quantity.value = null;
        isalert.value = true;
      } else {
        alert_quantity.value = null;
        isalert.value = false;
      }
    }
    function handleChangeName() {
      if (name.value) {
        setFieldValue(
          "slug",
          name.value.trim().replace(/\s+/g, "-").toLowerCase()
        );
      }
    }
    function handleChangeSlug() {
      if (slug.value) {
        setFieldValue(
          "slug",
          slug.value.trim().replace(/\s+/g, "-").toLowerCase()
        );
      }
    }
    function resetCustom() {
      resetForm();
    }
    function autoDiscConvert(tag_price, auto_discount, type) {
      let ad = 0;
      if (type == "F") {
        ad = (auto_discount / 100) * tag_price;
      } else {
        ad = (auto_discount / tag_price) * 100;
      }
      return Number(ad).toFixed(2);
    }
    return {
      route,
      /**************** default form sel values */
      formValues,
      /**************** event handler */
      genRandCode,
      // modals
      toggleAlert,
      //
      handleChangeName,
      handleChangeSlug,
      /************** db */
      productTypes,
      symbologies,
      categories,
      brands,
      units,
      unitsBulk,
      taxes,
      warehouses,
      /******* fields   */
      type,
      errorType,
      code,
      errorCode,
      symbology,
      errorSymbology,
      name,
      metaName,
      errorName,
      slug,
      errorSlug,
      weight,
      errorWeight,
      category,
      errorCategory,
      brand,
      errorBrand,
      mrp,
      errorMrp,
      unit,
      errorUnit,
      p_unit,
      errorPUnit,
      s_unit,
      errorSUnit,
      isalert,
      errorIsalert,
      alert_quantity,
      errorAlertQuantity,
      mfg_date,
      errorMfgDate,
      errorExpDate,
      exp_date,
      tax_rate,
      tax,
      errorTax,
      errorTaxRate,
      tax_method,
      errorTaxMethod,
      cost,
      errorCost,
      markup,
      errorMarkup,
      auto_discount,
      errorAutoDiscount,
      auto_disc_type,
      errorAutoDiscType,
      price,
      tag_price,
      errorTagPrice,
      errorPrice,
      warehouse,
      errorWareHouse,
      stock_adj_count,
      errorStockAdjCount,
      ref_no,
      errorRefNo,
      stock_adj_note,
      errorStockAdjNote,
      //
      pos_sale,
      pos_custom_discount,
      pos_custom_tax,
      pos_sale_note,
      //
      dbData,
      dataFields,
      pos_data_field_1,
      pos_data_field_2,
      pos_data_field_3,
      pos_data_field_4,
      pos_data_field_5,
      pos_data_field_6,
      /*************** */
      isDirty,
      isValid,
      onSubmit,
      isSubmitting,
      resetForm,
      resetCustom,
      autoDiscConvert,
      notifyDefault,
      /******************/
      axiosAsyncCallReturnData,
      axiosAsyncStoreUpdateReturnData,
      axiosAsyncStoreReturnBool,
      x_percentage_of_y,
      cats_list,
      hyphen_count,
    };
  },
  data() {
    return {};
  },
  /* eslint-disable */
  computed: {
    // a computed getter
    computed_categories() {
      this.cats_list = [];
      return this.make_category_tree();
    },
  },
  methods: {
    make_category_tree(
      array = this.categories,
      parent = null,
      length = 0,
      first = true
    ) {
      var search = [];
      if (Array.isArray(array)) {
        search = array.filter(
          (category) => category.parent == (first ? null : parent)
        );
        while (search.length > 0) {
          search.forEach((element) => {
            search = this.categories.filter(
              (category) => category.parent == element.id
            ); // check for subs
            if (search.length) {
              element.name =
                "---".repeat(length) +
                "■ " +
                element.name +
                " (" +
                search.length +
                ")";
            } else if (!search.length && first) {
              element.name = "".repeat(length) + "  ■ " + element.name;
              this.hyphen_count = 0;
            }
            else {
              element.name = "---".repeat(length) + "  • " + element.name;
              this.hyphen_count = 0;
            }
            this.cats_list.push(element);
            if (search.length > 0) {
              this.hyphen_count = this.hyphen_count + 1;
              this.make_category_tree(search, element.id, this.hyphen_count, false);
            } else {
            }
            search = [];
          });
        }
        return this.cats_list;
      }
      return undefined;
    },
    loadBrandsAndSet: function (id) {
      this.brand = null; // form data
      let self = this;
      this.axiosAsyncStoreUpdateReturnData("storeBrands", "brand", {
        action: "dropdown",
      }).then(function (data) {
        if (data.success == true) {
          self.brand = id;
        }
      });
    },
    loadUnits: function (id) {
      let self = this;
      this.unit = null; // form data
      this.axiosAsyncStoreUpdateReturnData("storeUnits", "unit", {
        action: "list_base",
      }).then(function (data) {
        if (data.success == true) {
          self.unit = id;
        }
      });
    },
    updateTaxRates: function (id) {
      let self = this;
      this.tax_rate = null;
      this.axiosAsyncStoreUpdateReturnData("storeTaxes", "tax", {
        action: "dropdown",
      }).then(function (data) {
        if (data.success == true) {
          self.tax_rate = id;
        }
      });
    },
    changePunitSunit: function (id) {
      let self = this;
      this.axiosAsyncStoreUpdateReturnData("storeUnitsBulk", "product", {
        action: "create",
        dropdown: "sub_units",
        id: self.unit,
      }).then(function (data) {
        if (data.success == true) {
          self.p_unit = self.s_unit = id;
        }
      });
    },
  },
  watch: {
    unit(value) {
      if (value) {
        this.axiosAsyncStoreUpdateReturnData("storeUnitsBulk", "product", {
          action: "create",
          dropdown: "sub_units",
          id: value,
        }).then(function (data) {
          if (data.success == true) {
            this.p_unit = null;
            this.s_unit = null;
          }
        });
      } else {
        this.p_unit = null;
        this.s_unit = null;
      }
    },
    cost(cost) {
      if (cost) {
        let markup = this.markup ? this.markup : 0;
        let auto_discount = this.auto_discount ? this.auto_discount : 0;
        this.tag_price = cost + (markup / 100) * cost;
        this.price = this.tag_price - auto_discount;
      }
    },
    markup(markup) {
      if (this.cost) {
        this.tag_price = Number(
          this.x_percentage_of_y(markup, this.cost) + this.cost
        ).toFixed(2);
      } else {
        this.tag_price = null;
      }
    },
    auto_discount(auto_discount) {
      if (this.auto_disc_type == "F") {
        this.price = Number(this.tag_price - auto_discount).toFixed(2);
      } else {
        this.price = Number(
          this.tag_price - this.x_percentage_of_y(auto_discount, this.tag_price)
        ).toFixed(2);
      }
    },
    auto_disc_type(type) {
      this.auto_discount = this.autoDiscConvert(
        this.tag_price,
        this.auto_discount,
        type
      );
    },
    tag_price(tag_price) {
      if (this.cost) {
        //let profit = this.tag_price - this.cost;
        //this.markup = null;
      } else {
        //this.markup = null;
      }
      this.price = Number(tag_price - this.auto_discount).toFixed(2);
    },
    tax_method() {},
    tax_rate(rate) {
      this.tax = Number(this.x_percentage_of_y(rate, this.tag_price)).toFixed(
        2
      );
    },
  },
  created() {},
  mounted() {
    if (!this.productTypes) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeProductTypes", "product", {
        action: "create",
        dropdown: "product_types",
      });
      // get product types
    }
    if (!this.symbologies) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeSymbologies", "product", {
        action: "create",
        dropdown: "barcode_symbologies",
      }); // get symbologies
    }
    if (!this.categories) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeCategories", "product", {
        action: "create",
        dropdown: "categories",
      }); // get categories
    }
    if (!this.brands) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeBrands", "product", {
        action: "create",
        dropdown: "brands",
      }); // get brands
    }
    if (!this.units) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeUnits", "product", {
        action: "create",
        dropdown: "base_units",
      }); // get units
    }
    if (!this.taxes) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeTaxes", "product", {
        action: "create",
        dropdown: "tax_rates",
      }); // get tax rates
    }
    if (!this.warehouses) {
      // if not found on store
      this.axiosAsyncStoreReturnBool("storeWareHouses", "product", {
        action: "create",
        dropdown: "warehouses",
      }); // get ware houses
    }
    this.axiosAsyncStoreReturnBool("storeUnitsBulk", "product", {
      action: "create",
      dropdown: "sub_units",
      id: this.unit,
    });
    //
  },
  beforeUnmount() {
  },
};
</script>