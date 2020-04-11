<!DOCTYPE html>
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?= $this->fetch('title') ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<?= $this->Html->css('theme-default.css') ?>
		  <?= $this->fetch('cssEditor')?>

<style media="print">
	.hide_at_print {
		display:none !important;
	}
</style>
<style>
	.error-message {
		color: red;
		font-style: inherit;
	}
</style>


<style>
.self-table > tbody > tr > td, .self-table > tr > td
{
	border-top:none !important;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
 
    vertical-align:middle !important;
}
option 
{
    border-top:1px solid #CACACA;
    padding:4px;
	cursor:pointer;
}
select 
{
	cursor:pointer;
}
.myshortlogo
{
	font: 15px "Open Sans",sans-serif;
	text-transform: uppercase !important;
	box-sizing:border-box;
}
.toast_success_notify{
	margin: 0px 0px 6px;
	border-radius: 3px;
	background-position: 15px center;
	background-repeat: no-repeat;
	box-shadow: 0px 0px 12px ;
	color: #FFF;
	opacity: 0.8;
	background-color: #42893D;
}
.tost_edit_notify{
	margin: 0px 0px 6px;
	border-radius: 3px;
	background-position: 15px center;
	background-repeat: no-repeat;
	box-shadow: 0px 0px 12px #999;
	color: #FFF;
	opacity: 0.8;
	background-color: #B0B343;	
}
.tost_delete_notify{
	margin: 0px 0px 6px;
	border-radius: 3px;
	background-position: 15px center;
	background-repeat: no-repeat;
	box-shadow: 0px 0px 12px #999;
	color: #FFF;
	opacity: 0.8;
	background-color: #D75C48;
}
</style>
<!-- END THEME STYLES -->
<!-- <link rel="shortcut icon" href="favicon.ico"/> -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-quick-sidebar-open ">
	<?php echo $this->fetch('content'); ?>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
		<?= $this->Html->script('plugins/jquery/jquery.min.js') ?>
		<?= $this->Html->script('plugins/jquery/jquery-ui.min.js') ?>
		<?= $this->Html->script('plugins/bootstrap/bootstrap.min.js') ?>      
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->        
		<?= $this->Html->script('plugins/icheck/icheck.min.js') ?>  
		<?= $this->Html->script('plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') ?> 
		<!--<?= $this->Html->script('plugins/bootstrap/bootstrap-timepicker.min.js') ?>-->
		<?= $this->fetch('jsFileInput') ?>
		<?= $this->fetch('jsDatePicker') ?>
		<?= $this->fetch('jsTimePicker') ?>
		<?= $this->fetch('jsSelect') ?>
		<?= $this->fetch('jsValidate') ?>
		  <?= $this->fetch('jsPluginEditor')?>
            <?= $this->fetch('jsEditor')?>
            <?= $this->fetch('jsEditor2')?>
        <!-- END THIS PAGE PLUGINS-->        

        <!-- START TEMPLATE -->
		
		<?= $this->Html->script('settings.js') ?>  
		<?= $this->Html->script('plugins.js') ?>  
		<?= $this->Html->script('actions.js') ?>  	
        <!-- END TEMPLATE -->
		<?= $this->fetch('scriptBottom') ?>


      

 
</div>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>