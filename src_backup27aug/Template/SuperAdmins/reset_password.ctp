<div class="login-box animated fadeInDown">
	<div class="login-logo"></div>
	<?= $this->Flash->render() ?>
	<div class="login-body">
		<div class="login-title">Please Reset New Password</div>
		 <?= $this->Form->create() ?>  
		 <?php $js=''; ?>
		<div class="form-group">
		  <label class="sr-only" for="inputName">New Password</label>
		  <?php echo $this->Form->control('password',['id'=>'password','class'=>'form-control','placeholder'=>'New Password','label'=>false,'required'=>'required','id'=>'inputPassword']); ?>
		  <span toggle="#inputPassword" class="icon wb-eye field-icon toggle-password"></span>
		 <span id="pswdmsg" class="pswdmsgs" style="display:none;font-size: 12px;">No limitations. Be creative and choose however you want</span>
		</div>
		<div class="form-group">
		  <label class="sr-only" for="inputName">Confirm Password</label>
		  <?php echo $this->Form->control('confirm_password',['id'=>'confirm_password','class'=>'form-control','placeholder'=>'Confirm Password','label'=>false,'required'=>'required','type'=>'password']); ?>
		</div>
		<?= $this->Form->button(__('Login'),['class'=>'btn btn-gradient btn-block']) ?>
	  <?= $this->Form->end() ?>
	 
	  </div>
	<div class="login-footer">
		<div class="pull-left">
			&copy; 2017 PHP Poets IT Solutions PVT LTD.
		</div>
		<div class="pull-right">
		</div>
	</div>
</div>
<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js.='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {
				password: {
						required: true,
				},
				confirm_password: {
						required: true,
						equalTo: "#password"
				},
				
			}
		});
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>