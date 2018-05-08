<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="bootstrap admin template">
	<meta name="author" content="">
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<title>Unauthorized</title>

	<?php
		echo $this->Html->meta(
		'favicon.ico',
		'/img/favicon.ico',
		['type' => 'icon']
		);
	?>
	<!-- Stylesheets -->
	<?php echo $this->Html->css('/assets/css/bootstrap.min.css'); ?>
	<?php echo $this->Html->css('/assets/css/bootstrap-extend.min.css'); ?>
	<?php echo $this->Html->css('/assets/css/site.min.css'); ?>
	<?php echo $this->Html->css('/css/style.css'); ?>
	<?php echo $this->Html->css('/assets/skins/grey.css'); ?>
	<!-- Plugins -->
	<?php echo $this->Html->css('/assets/vendor/animsition/animsition.min.css'); ?>
	<?php echo $this->Html->css('/assets/vendor/asscrollable/asScrollable.css'); ?>
	<?php echo $this->Html->css('/assets/vendor/switchery/switchery.css'); ?>
	<?php echo $this->Html->css('/assets/vendor/intro-js/introjs.min.css'); ?>
	<?php echo $this->Html->css('/assets/vendor/slidepanel/slidePanel.css'); ?>
	<?php echo $this->Html->css('/assets/vendor/flag-icon-css/flag-icon.css'); ?>
		<?php echo $this->Html->css('/assets/vendor/toastr/toastr.css'); ?>
	
	<!-- Page -->
	
	<!-- Fonts -->
	<?php echo $this->Html->css('/assets/fonts/web-icons/web-icons.min.css'); ?>
	<?php echo $this->Html->css('/assets/fonts/brand-icons/brand-icons.min.css'); ?>
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

	<!-- Page -->
	
	<style>

h4{
	text-shadow: rgba(0, 0, 0, 0) 0 0 1px !important;
}

	</style>
	<?php echo $this->Html->script('/assets/vendor/modernizr/modernizr.js'); ?>
	<?php echo $this->Html->script('/assets/vendor/breakpoints/breakpoints.js'); ?>
	<script>
		Breakpoints();
	</script>
</head>
<body class="page-maintenance layout-full">
  
  <div class="page">
	 <div class="hideFlash"><?= $this->Flash->render() ?></div>
	<?= $this->fetch('content') ?>
  </div>
  <!-- End Page 

  <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
-->

  <!-- Core  -->
  <?php echo $this->Html->script('/assets/vendor/jquery/jquery.js'); ?>
    <?php echo $this->Html->script('/assets/vendor/jquery/jquery.min.js'); ?>
  <?php echo $this->Html->script('/assets/vendor/bootstrap/bootstrap.js'); ?>
  <?php echo $this->Html->script('/assets/vendor/animsition/jquery.animsition.js'); ?>
  <?php echo $this->Html->script('/assets/vendor/asscroll/jquery-asScroll.js'); ?>
  <?php echo $this->Html->script('/assets/vendor/mousewheel/jquery.mousewheel.js'); ?>
  <?php echo $this->Html->script('/assets/vendor/asscrollable/jquery.asScrollable.all.js'); ?>
  <?php echo $this->Html->script('/assets/vendor/ashoverscroll/jquery-asHoverScroll.js'); ?>

  <!-- Plugins -->
  <?php echo $this->Html->script('/assets/vendor/switchery/switchery.min.js'); ?>
  <?php echo $this->Html->script('/assets/vendor/intro-js/intro.js'); ?>
  <?php echo $this->Html->script('/assets/vendor/screenfull/screenfull.js'); ?>

 
 <!-- Scripts -->
  <?php echo $this->Html->script('/assets/js/core.js'); ?>
  <?php echo $this->Html->script('/assets/js/site.js'); ?>

  <?php echo $this->Html->script('/assets/js/sections/menu.js'); ?>
  <?php echo $this->Html->script('/assets/js/sections/menubar.js'); ?>
  <?php echo $this->Html->script('/assets/js/sections/gridmenu.js'); ?>
  <?php echo $this->Html->script('/assets/js/sections/sidebar.js'); ?>

  <?php echo $this->Html->script('/assets/js/configs/config-colors.js'); ?>
  <?php echo $this->Html->script('/assets/js/configs/config-tour.js'); ?>

  <?php echo $this->Html->script('/assets/js/components/asscrollable.js'); ?>
  <?php echo $this->Html->script('/assets/js/components/animsition.js'); ?>
  <?php echo $this->Html->script('/assets/js/components/slidepanel.js'); ?>
  <?php echo $this->Html->script('/assets/js/components/switchery.js'); ?>
  <?php echo $this->Html->script('/js/disable-right-click.js'); ?>


	 <script>
    (function(document, window, $) {
      'use strict';

      var Site = window.Site;
      $(document).ready(function() {
        Site.run();
      });
    })(document, window, jQuery);
  </script>
 
 

</body>

</html>