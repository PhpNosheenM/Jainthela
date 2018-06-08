<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Change Password'); ?>
	<div class="page-content-wrap">
		<div class="page-title">
			<h2><span class="fa fa-arrow-circle-o-left"></span> Sellers Change Password</h2>
		</div>
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Change Password</h3>
					</div>
					<?= $this->Form->create($seller,['id'=>"jvalidate",'type'=>'file']) ?>
					<?php $js=''; ?>
					<div class="panel-body">
						<div class="form-group">
							<label>Old Password</label>
							<?= $this->Form->control('old_password',['type'=>'password','class'=>'form-control','placeholder'=>'Old Password','label'=>false]) ?>
							<span class="help-block"></span>
						</div>
						<div class="form-group">
							<label>New Password</label>
							<?= $this->Form->control('password',['type'=>'password','id'=>'password','class'=>'form-control','placeholder'=>'New Password','label'=>false,'value'=>'']) ?>
							<span class="help-block"></span>
						</div>
						<div class="form-group">
							<label>Confirm Password</label>
							<?= $this->Form->control('confirm_password',['type'=>'password','class'=>'form-control','placeholder'=>'Confirm Password','label'=>false]) ?>
							<span class="help-block"></span>
						</div>
					</div>
				</div>
				<div class="panel-footer">
						 <center>
							<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
						 </center>
				</div>
					<?= $this->Form->end() ?>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>
<!-- END CONTENT FRAME -->
<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js.='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {
				old_password: {
						required: true,
				},
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
