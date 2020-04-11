<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php   $this->set('title', 'Brand List');  ?><!-- PAGE CONTENT WRAPPER --> 
<div class="page-content-wrap">
<?= $this->Form->create($brands,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Brand List</strong></h3>
				<div class="pull-right">
			<div class="pull-left">
			
			</div> 
		</div> 	
				</div>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered main_table">
							<thead>
								<tr>
									<th style="width:10%"><?= ('SNo.') ?></th>
									<th style="width:60%"><?= ('Brand name') ?></th>
									<th style="width:20%"><?= ('Discount') ?>
									<?= $this->Form->control('discount_amt',['style'=>'width:100px;float:right;    margin-right: 60px;margin-top: -22px;','type'=>'text','class'=>'form-control discount_all','label'=>false, 'placeholder'=>'Discount All']) ?> 
									</th>
									<th  style="width:10%"><?= ('status') ?></th>
								</tr>
							</thead>
							<tbody class="MainTbody">                                         
								<?php $i = 0; ?>
								
								  <?php  foreach ($brands as $brand): 
								
								  ?>
								<tr class="MainTr">
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($brand->name) ?>
									<?= $this->Form->control('id',['class'=>'form-control id','label'=>false, 'value'=>$brand->id,'type'=>'hidden']) ?>
									</td>
									
									<td><?= $this->Form->control('discount',['type'=>'text','class'=>'form-control discount_per','label'=>false, 'value'=>$brand->discount]) ?></td>
									<td><?= h($brand->status) ?>
									
									</td>
									
									
								</tr>
								<?php  endforeach;  ?>
							</tbody>
						</table>
						<div align="center" class="form-actions">
							<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary btns']) ?>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					
				</div>
			</div>
			
		</div>
	</div>                    
	<?= $this->Form->end() ?>
</div>

<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>

<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
   $js="
   
		$(document).on('keyup','.discount_per',function(){
			renameRows();
		});
		$(document).on('keyup','.discount_all',function(){ 
			var t=$(this).val(); 
			$('.discount_per').val(t);
		});
		
		renameRows();
		function renameRows(){  
			var i=0; 
			$('.main_table tbody tr').each(function(){
				var dis=$(this).find('input.discount_per').val();
				if(dis){
					$(this).find('input.id ').attr({name:'brands['+i+'][id]',id:'brands['+i+'][id]'})
					$(this).find('input.discount_per ').attr({name:'brands['+i+'][discount]',id:'brands['+i+'][discount]'})
					i++;
				}else{
					$(this).find('input.id ').attr({name:'q',id:'q'})
					$(this).find('input.discount_per ').attr({name:'q',id:'q'})
				}
			});
		}

	";  

echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>