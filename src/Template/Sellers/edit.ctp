<!-- PAGE CONTENT WRAPPER -->
<?php $this->set('title', 'Seller'); ?>
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
		
		<?= $this->Form->create($seller,['id'=>"jvalidate",'class'=>"form-horizontal"]) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Seller</strong></h3>
				</div>
			
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3 control-label">Seller Name</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Seller Name','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Firm Name</label>
								<div class="col-md-9">                                            
									<?= $this->Form->control('firm_name',['class'=>'form-control','placeholder'=>'Firm Name','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Firm Address</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('firm_address',['class'=>'form-control','placeholder'=>'Firm Address','label'=>false,'rows'=>'4']) ?>
								</div>
							</div>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Latitude</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('latitude',['class'=>'form-control','placeholder'=>'Latitude','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Longitude</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('longitude',['class'=>'form-control','placeholder'=>'Longitude','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Status</label>
								<div class="col-md-9 col-xs-12">
									<?php $options['Active'] = 'Active'; ?>
								<?php $options['Deactive'] = 'Deactive'; ?>
								<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
						</div>
						<div class="col-md-6">
							<div class="form-group">                                        
								<label class="col-md-3 control-label">GSTIN</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('gstin',['class'=>'form-control','placeholder'=>'GSTIN','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">GSTIN Holder</label>
								<div class="col-md-9 col-xs-12">
									<?= $this->Form->control('gstin_holder_name',['class'=>'form-control','placeholder'=>'GSTIN Holder Name','label'=>false]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">GSTIN Holder Address</label>
								<div class="col-md-9 col-xs-12"> 
									<?= $this->Form->control('gstin_holder_address',['class'=>'form-control','placeholder'=>'GSTIN Holder Address','label'=>false,'rows'=>'4']) ?>
								</div>
							</div>
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Email</label>
								<div class="col-md-9 col-xs-12">
									<div class="input-group">
										<span class="input-group-addon"><span class="fa fa-envelope"></span></span>
										<?= $this->Form->control('email',['class'=>'form-control','placeholder'=>'Email','label'=>false]) ?>
									</div>  
									<label id="email-error" class="error" for="email" style="display: none;"></label>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">User Name</label>
								<div class="col-md-9"> 
									<div class="input-group">
										<span class="input-group-addon"><span class="fa fa-user"></span></span>								
										<?= $this->Form->control('username',['class'=>'form-control','placeholder'=>'User Name','label'=>false]) ?>
									</div>
									<label id="username-error" class="error" for="username" style="display: none;"></label>
								</div>
							</div>
							
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Password</label>
								<div class="col-md-9 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
									<?= $this->Form->control('password',['class'=>'form-control','placeholder'=>'Password','label'=>false,'type'=>'password']) ?>
									</div>
									<label id="password-error" class="error" for="password" style="display: none;"></label>
								</div>
							</div>
							
							<div class="form-group">                                        
								<label class="col-md-3 control-label">Mobile</label>
								<div class="col-md-9 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-mobile"></span></span>
									<?= $this->Form->control('mobile_no',['class'=>'form-control','placeholder'=>'Mobile No','label'=>false]) ?>
									</div>
									<label id="mobile_no-error" class="error" for="mobile-no" style="display: none;"></label>
								</div>
							</div>
							
							
							
						</div>
						
					</div>

				</div>
				<div class="panel-footer">
					<center>
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
					</center>
				</div>
			</div>
			<?= $this->Form->end() ?>
		</div>
	</div>                    
	
</div>

<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				name: {
						required: true,
				},
				firm_name: {
						required: true,
				},
				email: {
						required: true,
				},
				user_name: {
						required: true,
				},
				password: {
						required: true,
				},
				mobile_no: {
						required: true,
				},
			}                                        
		});';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>