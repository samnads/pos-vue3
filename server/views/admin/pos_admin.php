<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-fluid border" ng-controller="posCtrl" ng-init="cartInit()">
  <div class="row">
    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 b-1 p-3">
      <?php echo form_open('', array('id' => 'posForm', 'name' => 'posForm', 'ng-submit' => 'submit()', 'role' => 'form', 'novalidate' => 'novalidate')); ?>
      <div class="form-row">
        <div class="input-group input-group-md mb-1">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
          </div>
          <select class="form-control" id="select2-customer" ng-disabled="ui.isCustLock"></select>
          <div class="input-group-append">
            <button type="button" class="btn btn-primary" ng-click="lockCustInp()"><span ng-show="ui.isCustLock" title="Change Customer"><i class="fas fa-lock-open"></i></span><span ng-hide="ui.isCustLock" title="Lock Customer"><i class="fas fa-lock"></i></span></button>
          </div>
          <div class="input-group-append">
            <button type="button" class="btn btn-secondary" ng-click="viewCust()"><i class="fas fa-binoculars"></i></button>
          </div>
          <div class="input-group-append">
            <button type="button" class="btn btn-info" ng-click="showNewCustForm()"><i class="fas fa-plus"></i></button>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="input-group input-group-md mb-1">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="far fa-trash-alt"></i></span>
          </div>
          <input type="text" class="form-control" placeholder="Scan & remove product" id="pRemove" name="pRemove" ng-model="pRemove" ng-disabled="products.length == 0">
          <div class="input-group-append">
            <button type="button" class="btn btn-info"><i class="fas fa-lock"></i></button>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="input-group input-group-md mb-1">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
          </div>
          <input type="text" class="form-control" placeholder="Scan or type product name..." id="pSearch" name="pSearch" ng-model="pSearch">
          <div class="input-group-append" ng-if="search"> <span class="input-group-text">
              <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </span> </div>
          <div class="input-group-append">
            <button type="button" class="btn btn-info"><i class="fas fa-plus"></i></button>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="panel-body table-responsive scroll1" id="prodTable" style="height: 50vh !important;">
          <table class="table table-sm table-bordered table-striped">
            <thead class="thead-dark text-center">
              <tr class="d-flex">
                <th scope="col" class="col-2">Code</th>
                <th scope="col" class="col-3">Name</th>
                <th scope="col" class="col-1">Rate</th>
                <th scope="col" class="col-2">Qty.</th>
                <th scope="col" class="col-1">Unit</th>
                <th scope="col" class="col-1">Disc</th>
                <th scope="col" class="col-1">Total</th>
                <th scope="col" class="col-1"><i class="far fa-trash-alt"></i></th>
              </tr>
            </thead>
            <tbody style="height: 51vh !important;">
              <tr class="d-flex" ng-repeat="product in products | orderBy: reverse:true track by $index">
                <td class="col-2 align-middle">{{product.code}}</td>
                <td class="col-3 align-middle">{{product.name}}<button type="button" class="btn btn-sm btn-secondary float-right" ng-click="prodInfoModal($index)"><i class="fas fa-pencil-alt"></i></button></td>
                <td class="col-1 align-middle text-right" title="MRP : {{product.mrp | number:2}}">{{product.price | number:2}}</td>
                <td class="col-2 align-middle">
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <button type="button" class="btn btn-outline-secondary" ng-click="qChangeMinus($index,product.quantity)"><i class="fas fa-minus"></i></button>
                    </div>
                    <input type="number" ng-min="0" class="form-control text-center" ng-value="product.quantity" ng-model="quantity[$index]" name="quantity{{$index}}" id="quantity{{$index}}" ng-class="posForm['quantity'+$index].$dirty && posForm['quantity'+$index].$invalid ? 'is-invalid' : ''" ng-blur="qChange($index,quantity[$index],$event)" ng-model-optionsX="{ updateOn: 'default blur' }" ng-required="true" select-on-click />
                    <div class="input-group-append">
                      <button type="button" class="btn btn-outline-secondary" ng-click="qChangePlus($index,product.quantity)"><i class="fas fa-plus"></i></button>
                    </div>
                  </div>
                </td>
                <td class="col-1 text-center align-middle">{{product.unit_code}}</td>
                <td class="col-1 align-middle text-center">{{product.discount}}</td>
                <td class="col-1 text-right align-middle">{{product.total}}</td>
                <td class="col-1 text-center align-middle">
                  <button type="button" class="btn btn-sm btn-outline-danger" title="Remove {{product.value}}" data-toggle="modal" data-target="#delProdModal" data-index="{{$index}}"><i class="fas fa-minus-circle"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row pl-2 pr-2">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 bg-dark text-light">Something</div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
          <div class="row text-white">
            <!-- position-absolute fixed-bottom -->
            <div class="col-lg-6">
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-secondary border-bottom border-dark">Items</div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-primary border-bottom border-right border-dark text-right">{{cart.quantity}}</div>
              </div>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-secondary border-bottom border-dark">Pieces</div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-primary border-bottom border-right border-dark text-right">{{cart.tQuantity}}</div>
              </div>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-secondary border-bottom border-dark">Tax</div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-primary border-bottom border-right border-dark text-right">{{cart.tax}}</div>
              </div>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-secondary border-bottom border-dark">Shipping</div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-primary border-bottom border-right border-dark text-right pointer" ng-click="showShipBox()"><span class="float-left text-black-50"><i class="fas fa-truck"></i></span>{{cart.shipping}}</div>
              </div>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-secondary border-bottom border-dark">
                  test
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-primary border-right border-bottom border-dark text-center m-0 p-0">
                  <button type="button" class="btn btn-sm  btn-danger w-100 rounded-0" ng-click="canBillModal()">Cancel</button>
                </div>
              </div>
            </div>
            <div class="col-lg-6 border-bottom border-dark">
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-secondary border-bottom border-dark">SubTotal</div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-info border-bottom border-dark text-right font-weight-bold">{{cart.subTotalWOPD | number : 2}}</div>
              </div>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-secondary border-bottom border-dark">Dis. / Prod.</div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-warning border-bottom border-dark text-right text-dark">{{cart.pDiscount | number : 2}}</div>
              </div>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-secondary border-bottom border-dark">Total</div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-info border-bottom border-dark text-right font-weight-bold">{{cart.subTotal | number : 2}}</div>
              </div>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-secondary border-bottom border-dark">Discount <span class="float-right" ng-show="cart.discType == '1'"><span class="badge badge-warning">{{ui.discountPerc}}</span></span></div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-warning border-bottom border-dark text-right text-dark pointer" ng-click="showDiscBox()">
                  <span class="float-left text-black-50" ng-show="cart.discType == '0'"><i class="fas fa-tag"></i></span>
                  <span class="float-left text-black-50" ng-show="cart.discType == '1'"><i class="fas fa-percent"></i></span>
                  {{cart.cDiscount | number : 2}}
                </div>
              </div>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-secondary border-dark">Total Disc.</div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-danger border-dark text-right">{{cart.discount | number : 2}}</div>
              </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 border-bottom border-dark">
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-dark border-right border-dark">Total Payable</div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 bg-light border-dark text-right text-dark font-weight-bold">
                  <span class="float-left">₹</span>
                  {{cart.total | number : 2}}
                </div>
              </div>
            </div>
            <div class="container">
              <div class="row">
                <div class="col-lg-4 p-0">
                  <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-6">
                      <button type="button" class="btn btn-warning w-100 rounded-0" ng-disabled="products.length == 0">Draft</button>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-6">
                      <button type="button" class="btn btn-danger w-100 rounded-0" ng-click="canBillModal()" ng-disabled="posForm.$pristine && discForm.$pristine">Cancel</button>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 p-0">
                  <button type="button" class="btn btn-info btn-lg btn-block h-100 rounded-0" ng-disabled="products.length == 0">Print</button>
                </div>
                <div class="col-lg-4 p-0">
                  <button type="button" class="btn btn-success btn-lg btn-block h-100 rounded-0" ng-disabled="products.length == 0 || cart.total < 0"><i class="fas fa-money-bill"></i>&nbsp;Checkout</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>
    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 p-3 bg-3">
      <div class="form-row">
        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
          <div class="input-group">
            <select class="selectpicker form-control" id="category" name="category" data-live-search="true" title="-- Category --" ng-disabled="!db.categories" data-style="btn-primary">
              <option ng-if="!db.categories" ng-value="0">{{string.inLoad}}</option>
              <option ng-value="{{category.id}}" ng-repeat="category in db.categories" ng-init="$last && finishCats()">{{category.name}}</option>
            </select>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
          <div class="input-group">
            <select class="selectpicker form-control" id="subcategory" title="Sub Category" name="subcategory" data-live-search="true" data-actions-box="true" ng-disabled="!db.categories || !db.subcats || db.subcats.length == 0" data-style="btn-info" multiple>
              <option ng-if="!db.categories || (data.cat && !db.subcats)" ng-value="0">{{string.inLoad}}</option>
              <option ng-if="db.subcats" ng-repeat="subcat in db.subcats" ng-value="{{subcat.id}}" ng-init="$last && finishSubCats()">{{subcat.name}}</option>
            </select>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
          <div class="form-group">
            <select class="selectpicker form-control" id="brand" data-live-search="true" title="-- Brand --" data-style="btn-success" ng-disabled="!db.brands" data-actions-box="true" multiple>
              <option ng-if="!db.brands" ng-value="0">{{string.inLoad}}</option>
              <option ng-value="{{brand.id}}" data-tokens=">{{brand.name}}" ng-repeat="brand in db.brands" ng-init="$last && finishBrands()">{{brand.name}}</option>
            </select>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-xl-2 col-lg-4 col-md-3 col-sm-3 mt-1 d-flex" ng-repeat="product in data.products">
          <div class="card pointer" ng-click="checkAndPush(product)">
            <img ng-src="{{product.thumbnail}}" class="card-img-top" alt="...">
            <div class="card-body p-1 border-bottom border-danger">
              <p class="card-text">{{product.name}}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--- set discount Modal -->
    <div class="modal" id="discModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <?php echo form_open('', array('id' => 'discForm', 'name' => 'discForm', 'ng-submit' => 'updDisc($event)', 'role' => 'form', 'novalidate' => 'novalidate')); ?>
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Discount</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body text-center">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-tag"></i></span>
              </div>
              <input type="number" ng-min="0" class="form-control" name="discount" id="discount" ng-model="ui.discount" ng-class="{ 'is-invalid' : discForm.discount.$invalid, 'is-valid' : discForm.discount.$valid }" ng-required="true" select-on-click />
              <div class="input-group-append">
                <div class="input-group-text">
                  <input type="radio" name="discountRadio" ng-model="ui.discType" value="0" ng-click="focusById('discount',true)">&nbsp;₹
                </div>
              </div>
              <div class="input-group-append">
                <div class="input-group-text">
                  <input type="radio" name="discountRadio" ng-model="ui.discType" value="1" ng-click="focusById('discount',true)">&nbsp;%
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-outline-secondary" ng-disabled="discForm.$invalid"><i class="fas fa-check"></i>&nbsp;&nbsp;Update</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!--- set shipping  Modal -->
    <div class="modal" id="shipModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <?php echo form_open('', array('id' => 'shipForm', 'name' => 'shipForm', 'ng-submit' => 'updShip($event)', 'role' => 'form', 'novalidate' => 'novalidate')); ?>
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Shipping Charge</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body text-center">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-truck"></i></span>
              </div>
              <input type="number" ng-min="0" class="form-control" name="shipping" id="shipping" ng-model="ui.shipping" ng-class="{ 'is-invalid' : shipForm.shipping.$invalid, 'is-valid' : shipForm.shipping.$valid }" ng-required="true" select-on-click />
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-outline-secondary" ng-disabled="shipForm.$invalid"><i class="fas fa-check"></i>&nbsp;&nbsp;Update</button>
          </div>
        </div>
        </form>
      </div>
    </div>
    <!--- Prtoduct Info Modal -->
    <div class="modal" id="prodInfoModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <?php echo form_open('', array('id' => 'prodUpdForm', 'name' => 'prodUpdForm', 'ng-submit' => 'prodUpdate($event,prodUpdData)', 'role' => 'form', 'novalidate' => 'novalidate')); ?>
          <div class="modal-header bg-primary text-light">
            <h5 class="modal-title">{{product['name']}} | {{product['code']}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body">
            <div class="form-row mb-2 border bg-light p-2">
              <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                <img ng-src="{{product['thumbnail']}}" class="img-fluid">
              </div>
              <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
                <div class="row">
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <label>Price</label>
                    <input type="number" ng-min="0" class="d-none" name="index" ng-model="prodUpdData.index" ng-required="true" />
                    <div class="input-group">
                      <input type="number" ng-min="0" placeholder="Product Price" ng-max="product.mrp" class="form-control text-center" ng-change="changePdtData('price')" name="price" ng-model="prodUpdData.price" ng-class="prodUpdForm.price.$invalid ? 'is-invalid' : ''" ng-required="true" />
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <label>Unit Discount</label>
                    <div class="input-group">
                      <input type="number" placeholder="Unit Discount" ng-min="0" ng-max="prodUpdData.price" class="form-control text-center" ng-change="changePdtData('unit_discount')" name="unit_discount" ng-model="prodUpdData.unit_discount" ng-class="prodUpdForm.unit_discount.$invalid || prodUpdData.unit_discount > prodUpdData.price ? 'is-invalid' : ''" ng-required="true" select-on-click />
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <label>Unit Price</label>
                    <div class="input-group">
                      <input type="number" ng-min="0" placeholder="Unit Price" ng-max="prodUpdData.price" ng-change="changePdtData('unit_price')" name="unit_price" ng-model="prodUpdData.unit_price" class="form-control text-center" ng-class="prodUpdForm.unit_price.$invalid && prodUpdForm.price.$valid ? 'is-invalid' : ''" ng-required="true" select-on-click />
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <label>Net Unit Price</label>
                    <div class="input-group">
                      <input type="number" name="net_unit_price" placeholder="Net Unit Price" ng-model="prodUpdData.net_unit_price" class="form-control text-center" readonly />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-row border bg-light p-2 mb-2">
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <label>Quantity</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <button type="button" class="btn btn-sm btn-outline-secondary" ng-click="pInfoQtyMinus(prodUpdData.quantity)"><i class="fas fa-minus"></i></button>
                  </div>
                  <input type="number" ng-min="0" ng-change="changePdtData('quantity')" class="form-control text-center" ng-value="product['quantity']" ng-model="prodUpdData.quantity" name="quantity" ng-class="prodUpdForm.quantity.$invalid ? 'is-invalid' : ''" ng-required="true" select-on-click />
                  <div class="input-group-append">
                    <button type="button" class="btn btn-sm btn-outline-secondary" ng-click="pInfoQtyPlus(prodUpdData.quantity)"><i class="fas fa-plus"></i></button>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <label>Bulk Unit</label>
                <div class="input-group">
                  <input type="number" class="form-control text-center" name="bulk_unit" ng-model="prodUpdData.bulk_unit" ng-required="false" />
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <label>Sub Total</label>
                <div class="input-group">
                  <input type="number" class="form-control text-center" name="sub_total" ng-model="prodUpdData.sub_total" ng-required="true" readonly />
                </div>
              </div>
            </div>
            <!-- <div class="form-row">
              <div class="col-lg-4">
                <table class="table table-sm table-striped table-bordered">
                  <tbody>
                    <tr>
                      <th scope="row">Name</th>
                      <td>{{product['name']}}</td>
                    </tr>
                    <tr>
                      <th scope="row">Code</th>
                      <td>{{product['code']}}</td>
                    </tr>
                    <tr>
                      <th scope="row">Category</th>
                      <td>{{product['category_name']}}</td>
                    </tr>
                    <tr>
                      <th scope="row">Sub Category</th>
                      <td>{{product['sub_category_name']}}</td>
                    </tr>
                    <tr>
                      <th scope="row">Unit</th>
                      <td>{{product['unit_code']}} ( {{product['unit_name']}} )</td>
                    </tr>
                    <tr>
                      <th scope="row">Brand</th>
                      <td>{{product['brand_name']}}</td>
                    </tr>
                    <tr ng-class="prodUpdForm.price.$invalid ? 'bg-warning' : ''">
                      <th scope="row">MRP</th>
                      <td>{{product['mrp']}}</td>
                    </tr>
                    <tr>
                      <th scope="row">Stock</th>
                      <td>52</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> -->
            <div class="form-row border p-1 bg-light">
              <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                <div class="form-group">
                  <label>Tax Method</label>
                  <div class="input-group">
                    <select class="custom-select" name="tax_method" ng-model="prodUpdData.tax_method" ng-change="PI_TaxRateChange()">
                      <option value='N'>No Tax</option>
                      <option value='I'>Inclusive</option>
                      <option value='E'>Exclusive</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                <div class="form-group">
                  <label>Tax Rate</label>
                  <div class="input-group">
                    <select class="custom-select" name="tax_id" ng-model="prodUpdData.tax_id" ng-disabled="!taxes || prodUpdData.tax_method == 'N'" ng-selected="1" ng-change="PI_TaxRateChange()"">
                      <option ng-if=" !taxes" ng-value="0">{{string.inLoad}}</option>
                      <option ng-if="prodUpdData.tax_method == 'N'" ng-value="null">-- NIL --</option>
                      <option ng-if="taxes && prodUpdData.tax_method != 'N'" ng-value="null">No Tax</option>
                      <option ng-value="{{tax.id}}" ng-repeat="tax in taxes">{{tax.name}} ~ {{tax.rate | number:2}} %</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                <div class="form-group">
                  <label>Unit Tax</label>
                  <div class="input-group">
                    <input type="number" class="form-control text-center" name="unit_tax" ng-model="prodUpdData.unit_tax" readonly ng-disabled="prodUpdData.tax_method == 'N'">
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4">
                <div class="form-group">
                  <label>Total Tax</label>
                  <div class="input-group">
                    <input type="number" class="form-control text-center" name="tax" ng-model="prodUpdData.tax" readonly ng-disabled="prodUpdData.tax_method == 'N'">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-row border bg-light  mt-2 p-2">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <label>Total</label>
                <div class="input-group">
                  <input type="number" ng-min="0" class="form-control text-center" name="total" ng-model="prodUpdData.total" readonly>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 bg-light">
                <label>Adjust Total</label>
                <div class="input-group">
                  <input type="number" placeholder="Adjust Total" ng-min="0" name="adjTotal" ng-model="prodUpdData.adjTotal" class="form-control text-center" ng-change="prodInfoAdjTotal()" ng-class="{ 'is-invalid' : prodUpdForm.adjTotal.$invalid }" />
                </div>
              </div>
            </div>
            <div class="form-row mt-3">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="alert alert-warning" role="alert" ng-show="prodUpdForm.$invalid">
                  <span class="form-text text-info" ng-messages="prodUpdForm.price.$error">
                    <span ng-message="required" class="text-danger">Price Required !</span>
                    <span ng-message="min" class="text-danger">Invalid Minimum Price !</span>
                    <span ng-message="max" class="text-danger">Price is greater than product MRP !</span>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary mr-auto" data-dismiss="modal"><i class='fa fa-stop' aria-hidden='true'></i>&nbsp;&nbsp;CANCEL</button>
            <button class="btn" ng-class="{ 'btn-success' : prodUpdForm.$valid,'btn-warning' : prodUpdForm.$invalid }" type="submit" ng-disabled="prodUpdForm.$invalid"><i class="fas fa-save"></i> SAVE</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!--- cancel billing Confirm Modal -->
    <div class="modal" id="canBillModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Cancel billing ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body text-center">Are you sure ?</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger mr-auto" ng-click="canBill()"><i class='fa fa-trash align-left' aria-hidden='true'></i>&nbsp;&nbsp;YES</button>
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class='fa fa-stop' aria-hidden='true'></i>&nbsp;&nbsp;NO</button>
          </div>
        </div>
      </div>
    </div>
    <!--- cancel billing Confirm Modal -->
    <div class="modal" id="delProdModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Delete product from cart ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body text-center"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger mr-auto" ng-click="delProd()"><i class='fa fa-trash align-left' aria-hidden='true'></i>&nbsp;&nbsp;YES</button>
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class='fa fa-stop' aria-hidden='true'></i>&nbsp;&nbsp;NO</button>
          </div>
        </div>
      </div>
    </div>
    <!--- view customer Modal -->
    <div class="modal" id="viewCust" tabindex="-1" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">{{cart.customer.name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body text-center">
            <div class="col-lg-12">
              <table class="table table-sm table-striped table-bordered">
                <tbody>
                  <tr>
                    <th scope="row">Name</th>
                    <td>{{cart.customer.name}}</td>
                  </tr>
                  <tr>
                    <th scope="row">Place</th>
                    <td>{{cart.customer.place}}</td>
                  </tr>
                  <tr>
                    <th scope="row">Email</th>
                    <td>{{cart.customer.email}}</td>
                  </tr>
                  <tr>
                    <th scope="row">Phone</th>
                    <td>{{cart.customer.phone}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <span class="mr-auto">
              <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Edit</button>
              <button type="submit" class="btn btn-outline-secondary" ng-click="printById('viewCust');"><i class="fas fa-print"></i>&nbsp;&nbsp;Print</button>
            </span>
            <button data-dismiss="modal" class="btn btn-outline-secondary"><i class="fas fa-stop"></i>&nbsp;&nbsp;Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<style>
  html,
  body,
  #outer {
    height: 100% !important;
    width: 100% !important;
    margin: 0 !important;
  }

  .bg-1 {
    background-color: rgb(0 0 0 / 20%);
  }

  .bg-2 {
    background: rgb(0 0 0 / 25%);
  }

  .bg-3 {
    background: rgb(215 226 234);
  }

  #prodInfoModal .input-group-text {
    min-width: 90px;
  }

  label {
    font-weight: 600;
  }

  .select2-results__message {
    color: #f8f9fa !important;
  }

  .pointer {
    cursor: pointer;
  }


  bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 100%;
  }


  /*
 *  STYLE 3
 */

  .scroll1::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    background-color: #F5F5F5;
  }

  .scroll1::-webkit-scrollbar {
    width: 5px;
    background-color: #F5F5F5;
  }

  .scroll1::-webkit-scrollbar-thumb {
    background-color: #000000;
  }
</style>