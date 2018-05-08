<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}

</style><?php $this->set('title', 'Location'); ?>
<div class="page-content-wrap">
        <div class="page-title">                    
			<h2><span class="fa fa-arrow-circle-o-left"></span> Location</h2>
		</div> 
	<div class="row col-md-12" >
				<div class="col-md-3" ></div>
				<div class="col-md-6" >
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Edit Location</h3>
						</div>
						<?= $this->Form->create($location,['id'=>"jvalidate",'type'=>'file']) ?>
						<?php $js=''; ?>
						<div class="panel-body">
						    <div class="form-group">
									<label>Name</label>
									<?= $this->Form->control('name',['class'=>'form-control','placeholder'=>'Name','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							
							 <div class="form-group">
									<label>Alise</label>
									<?= $this->Form->control('alise',['class'=>'form-control','placeholder'=>'Alise','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							
							 <div class="form-group">
									<label>Latitude</label>
									<?= $this->Form->control('latitude',['class'=>'form-control','placeholder'=>'Latitude','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							
							 <div class="form-group">
									<label>Longitude</label>
									<?= $this->Form->control('longitude',['class'=>'form-control','placeholder'=>'Longitude','label'=>false]) ?>
									<span class="help-block"></span>
					        </div>
							 
							<div class="form-group">
								<label>Status</label>
								<?php $options['Active'] = 'Active'; ?>
								<?php $options['Deactive'] = 'Deactive'; ?>
								<?= $this->Form->select('status',$options,['class'=>'form-control select','label'=>false]) ?>
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
				 <div class="col-md-3" ></div>
	</div>
</div>
<!-- END CONTENT FRAME -->
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js.='var jvalidate = $("#jvalidate").validate({
		ignore: [],
		rules: {
				name: {
						required: true,
				},
				
			}
		});
		  
	 
		';  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>