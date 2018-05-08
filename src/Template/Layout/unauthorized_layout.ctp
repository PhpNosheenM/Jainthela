<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="bootstrap admin template">
	<meta name="author" content="">
	<title>Unauthorized</title>

	<?php
			echo $this->Html->meta(
			'favicon.ico',
			'/img/favicon.ico',
			['type' => 'icon']
			);
		?>
	<?= $this->Html->css('theme-default.css') ?>
	<style>

h4{
	text-shadow: rgba(0, 0, 0, 0) 0 0 1px !important;
}

	</style>
</head>
<body class="page-maintenance layout-full">
  
  <div class="page">
	 <div class="hideFlash"><?= $this->Flash->render() ?></div>
	<?= $this->fetch('content') ?>
  </div>
 
 

</body>

</html>