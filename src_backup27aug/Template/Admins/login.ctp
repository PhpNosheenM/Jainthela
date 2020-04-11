<div class="login-box animated fadeInDown">
                <div class="login-logo"></div>
				<?= $this->Flash->render() ?>
                <div class="login-body">
                    <div class="login-title"><strong>Welcome</strong>, Please login</div>
					<?= $this->Form->create('',['class'=>'form-horizontal','id'=>'loginform']) ?>  
                    <div class="form-group">
                        <div class="col-md-12">
							<?= $this->Form->control('username',['class'=>'form-control','placeholder'=>'Username','label'=>false,'required'=>'required']) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <?php echo $this->Form->control('password',['class'=>'form-control','placeholder'=>'Password','label'=>false,'required'=>'required']); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
							<?php  echo $this->Html->link("Forgot your password?", array('controller' => 'Admins', 'action' => 'forgot_password'),['class' => 'btn btn-link btn-block','style'=>'','escape'=>false]); ?>
                        </div>
                        <div class="col-md-6">
							<?= $this->Form->button(__('Log In'),['class'=>'btn btn-info btn-block']) ?>
                        </div>
                    </div>
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