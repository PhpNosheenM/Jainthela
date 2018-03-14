<!DOCTYPE html>
<html lang="en">
   
<head>        
        <!-- META SECTION -->
        <title><?= $title ?></title>          
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
       <?php
			echo $this->Html->meta(
			'favicon.ico',
			'/img/favicon.ico',
			['type' => 'icon']
			);
		?>
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <?= $this->Html->css('theme-default.css') ?>
		
        <!-- EOF CSS INCLUDE -->                                      
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top-fixed">
            
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar page-sidebar-fixed scroll">
                <!-- START X-NAVIGATION -->
				<?= $this->element('sidebar_menu') ?>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                  
                    <!-- POWER OFF -->
                    <li class="xn-icon-button pull-right last">
                        <a href="#"><span class="fa fa-power-off"></span></a>
                        <ul class="xn-drop-left animated zoomIn">
                            <li><a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span> Sign Out</a></li>
                        </ul>                        
                    </li> 
                    <!-- END POWER OFF -->
					
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                    
                
                <!-- PAGE CONTENT WRAPPER -->
					<?= $this->fetch('content') ?>                
                <!-- END PAGE CONTENT WRAPPER -->                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
							<?= $this->Html->link('Yes',['controller'=>'Admins','action'=>'logout'],['escap'=>false,'class'=>'btn btn-success btn-lg']) ?>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
		<?= $this->Html->script('plugins/jquery/jquery.min.js') ?>
		<?= $this->Html->script('plugins/jquery/jquery-ui.min.js') ?>
		<?= $this->Html->script('plugins/bootstrap/bootstrap.min.js') ?>      
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->        
		<?= $this->Html->script('plugins/icheck/icheck.min.js') ?>  
		<?= $this->Html->script('plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') ?>  
		<?= $this->fetch('jsFileInput') ?>
		<?= $this->fetch('jsDatePicker') ?>
		<?= $this->fetch('jsSelect') ?>
		<?= $this->fetch('jsValidate') ?>
		
        <!-- END THIS PAGE PLUGINS-->        

        <!-- START TEMPLATE -->
		
		<?= $this->Html->script('settings.js') ?>  
		<?= $this->Html->script('plugins.js') ?>  
		<?= $this->Html->script('actions.js') ?>  	
        <!-- END TEMPLATE -->
		<?= $this->fetch('scriptBottom') ?>
    <!-- END SCRIPTS -->         
    </body>
</html>

<script>

$(document).ready(function() {  
		round();
		function round(value, exp) { 
		  if (typeof exp === 'undefined' || +exp === 0)
			return Math.round(value);

		  value = +value;
		  exp = +exp;

		  if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
			return 0;

		  // Shift
		  value = value.toString().split('e');
		  value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

		  // Shift back
		  value = value.toString().split('e');
		  return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
		}
});

</script>