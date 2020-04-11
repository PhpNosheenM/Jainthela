<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Settings'); ?>
<div class="content-frame">
	<div class="content-frame-top">
        <div class="page-title">
			<h2> Settings</h2>
		</div>
		<div class="pull-right">
			
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
				
					<h3 class="panel-title">EDIT Settings</h3>
				
				</div>
				<?= $this->Form->create($item) ?>
		        <div class="panel-body">
					
					
					<div class="form-group">
						<label>Delivery Day</label>
						<?php $options[1] = '1 Day'; 
						 $options[2] = '2 Day';
						 $options[3] = '3 Day'; 
						 $options[4] = '4 Day'; 
						 $options[5] = '5 Day'; 
						 $options[6] = '6 Day'; 
						 $options[7] = '7 Day'; 
						 
						 ?>
						<?= $this->Form->select('delivery_day',$options,['class'=>'form-control select','label'=>false]) ?>
					</div>
					
					<div class="form-group">
						<label>Maximum Order Day</label>
						<?= $this->Form->control('maximum_order_day',['class'=>'form-control','placeholder'=>'Maximum Order Day','label'=>false]) ?>
						<span class="help-block"></span>
					</div>
					
					<div class="form-group">
						<label>Maximum Order Message Popup</label>
						<?= $this->Form->control('maximum_order_message',['class'=>'form-control','placeholder'=>'Maximum Order Message Popup','label'=>false,'type'=>'textarea']) ?>
						<span class="help-block"></span>
					</div>
					
					
				     
				</div>
				<div class="panel-footer">
                 <center>
						<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
				 </center>
               </div> 
			    <?= $this->Form->end() ?>
			</div>
		</div>
		
			
		</div>
		
	</div>
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {                                            
				unit_name: {
						required: true,
				},
				longname: {
						required: true,
				},
				shortname: {
						required: true,
				},
			   
			}                                        
		});';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
