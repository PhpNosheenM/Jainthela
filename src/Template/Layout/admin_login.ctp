<!DOCTYPE html>
<html lang="en" class="body-full-height">
    
<head>        
        <!-- META SECTION -->
        <title>Jainthela</title>            
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
		<?php echo $this->Html->css('theme-default.css'); ?>
        <!-- EOF CSS INCLUDE -->                                       
    </head>
    <body>
        
        <div class="login-container">
        
            <?= $this->fetch('content') ?>
            
        </div>
        
    </body>

</html>






