<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- main js files -->
<script src="<?php echo base_url('assets/js/jquery-3.5.1.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/fontawesome/js/all.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/cyberlikes.js?v=' . time()); ?>"></script>
<!-- test js files -->
<!--<script src=""></script>-->
<!-- local js files -->
<?php
foreach ($js as $value) {
?>
  <script src="<?php echo base_url('assets/js/' . $value . '.js?v=' . time()); ?>"></script>
<?php
}
?>
<!-- local js end -->
<!-- linked js files -->
<?php
foreach ($js_links as $value) {
?>
  <script src="<?php echo $value; ?>"></script>
<?php
}
?>
</body>

</html>