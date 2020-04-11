
<div class="login-box animated fadeInDown">
	<div class=""></div>
	<?= $this->Flash->render() ?>
	<div class="login-body">
		<div class="login-title" style="text-align:center;"><strong>Please Select City/Location</strong></div>
		<?= $this->Form->create('',['class'=>'form-horizontal','id'=>'loginform']) ?>  
		<div class="form-group">
			<div class="col-md-12">
				<?= $this->Form->select('city_id',$Cities,['empty'=>'--Select City--','class'=>'form-control select city' ,'label'=>false,'required'=>true]) ?>
			</div>
			<div class="col-md-1"></div>
			<div class="col-md-10" id="location">
				
			
			</div>
		</div>
	   
		<div class="form-group">
			<div class="col-md-3"></div>
			<div class="col-md-6 bt" style='display:none;'>
				<?= $this->Form->button(__('Ok'),['class'=>'btn btn-info btn-block']) ?>
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

<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>

<?php
	$js="$(document).on('change', '.city',function(){
			var city_id=$(this).val();
			if(city_id>0){
			var url='".$this->Url->build(['controller'=>'SuperAdmins','action'=>'selectLocation'])."';
			url=url+'/'+city_id;
			$.ajax({
				url: url,
			}).done(function(response) { 
				$('#location').html(response);
				$('.location_id').selectpicker();
				$('.finencial_year_id').selectpicker();
				$('.bt').show();
			});
			}else{
				$('#location').html('');
				$('.bt').hide();
				}
		});
		
		function sel_loc(){
			
		}
		
		";  
		
		
		
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>