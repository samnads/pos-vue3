<template>
<div class="modal" id="detailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{product.name}} | {{product.code}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger me-auto" >DELETE</button>
        <button type="button" class="btn btn-primary">Print</button>
        <button type="button" class="btn btn-warning">Edit</button>
        <button type="button" class="btn btn-dark">Copy</button>
      </div>
    </div>
  </div>
</div>
</template>
<script>
export default {
 props: {
   product: Object
 },
}
</script>

