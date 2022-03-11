<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
</div><!-- /#col -->
</div><!-- /#row -->
</div><!-- /#page-content -->
</main>
<!-- main js files -->
<script src="<?php echo base_url('assets/js/jquery-3.5.1.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bs-custom-file-input.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/fontawesome/js/all.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/DataTables/datatables.min.js'); ?>"></script><!-- DataTables JS -->
<script src="<?php echo base_url('assets/js/cyberlikes.js?v=' . time()); ?>"></script>
<script src="<?php echo base_url('assets/js/sidebar.menu.js?v=' . time()); ?>"></script>
<!-- test js files -->
<!--<script src=""></script>-->
<?php
foreach ($js_links as $value) {
?>
  <!-- linked js file -->
  <script src="<?php echo $value; ?>"></script>
<?php
}
foreach ($js as $value) {
?>
  <!-- other js file -->
  <script src="<?php echo base_url('assets/js/' . $value . '.js?v=' . time()); ?>"></script>
<?php
}
?>
</body>

</html>