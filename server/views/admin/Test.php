<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-fluid" ng-controller="posCtrl" ng-init="cartInit()">
<button type="button" class="btn btn-outline-secondary" ng-click="showDiscBox()"><i class="fas fa-check"></i>&nbsp;&nbsp;OPEN</button>
<pre style="font-size: 10px;">{{discForm | json}}</pre>
<!--- set discount Modal -->
<div class="modal" id="discModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <?php echo form_open('', array('id' => 'discForm', 'name' => 'discForm', 'ng-submit' => 'updDisc()', 'role' => 'form', 'novalidate' => 'novalidate')); ?>
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Discount</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body text-center">
            <div class="input-group mb-3">
              <input type="number" ng-min="0" class="form-control" name="discount" id="cartDiscount" ng-model="ui.discountR" ng-change="test()" ng-click="selDiscInp()" ng-class="{ 'is-invalid' : discForm.discount.$invalid, 'is-valid' : discForm.discount.$valid }" ng-required="required">
              <div class="input-group-append">
                <div class="input-group-text">
                  <input type="radio" name="discount" ng-model="ui.discType" value="0" ng-change="selDiscInp()">&nbsp;₹
                </div>
              </div>
              <div class="input-group-append">
                <div class="input-group-text">
                  <input type="radio" name="discount" ng-model="ui.discType" value="1" ng-change="selDiscInp()">&nbsp;%
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
</style>