<div class="login-box animated fadeInDown">
	<div class="login-logo"></div>
	<?= $this->Flash->render() ?>
	<div class="login-body">
		<div class="login-title"><strong>Welcome</strong>, Please Type Email Id</div>
		<?= $this->Form->create('',['class'=>'form-horizontal','id'=>'loginform']) ?>  
		 <div class="form-group">
		  <label class="sr-only" for="inputName">Email</label>
		  <?php echo $this->Form->control('email',['class'=>'form-control','placeholder'=>'Email','label'=>false,'required'=>'required','style'=>'color: #474a4d;']); ?>
		</div>
		<?= $this->Form->button(__('Submit'),['class'=>'btn btn-login btn-block']) ?>
		<?= $this->Form->end() ?>
	
	<p class="textColorCss">In case if you forgot your email id, Please contact <br/>hello@entryhires.com for further assistance.</p>
	  <p><?php  echo $this->Html->link("Forgot your Email?<br/>", array('controller' => 'Admins', 'action' => 'forgot_email'),['class' => '','style'=>'text-align:left;width:100%;','escape'=>false]); ?></p>
	  <?php
	  if(!empty($flash))
	  {?>
	 <p class="textColorCss">Still no account? Please go to <?php echo $this->Html->link('Register', array('controller' => 'Admins', 'action' => 'add'));  ?></p>
	 
	  <?php
	  } ?>
	  </div>
	<div class="login-footer">
		<div class="pull-left">
			&copy; 2017 PHP Poets IT Solutions PVT LTD.
		</div>
		<div class="pull-right">
		</div>
	</div>
</div>