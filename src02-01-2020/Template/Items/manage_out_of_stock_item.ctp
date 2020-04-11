<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php   $this->set('title', 'Item');  ?><!-- PAGE CONTENT WRAPPER --> 
<div class="page-content-wrap">
<?= $this->Form->create($itemList,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Out Of Stock Item List</strong></h3>
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
									<th><?= ('SNo.') ?></th>
									<th><?= ('Item name') ?></th>
									<th style="width:10%"><?= ('Sale Rate') ?></th>
									<th  style="width:10%"><?= ('status') ?></th>
								</tr>
							</thead>
							<tbody class="MainTbody">                                         
								<?php $i = 0; ?>
								
								  <?php  foreach ($itemList as $itemvar): //pr($itemvar); 
								 $merge=$itemvar->item->name.'('.@$itemvar->unit_variation->visible_variation.')';
								  ?>
								<tr class="MainTr">
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($merge) ?>
									<?= $this->Form->control('id',['class'=>'form-control id','label'=>false, 'value'=>$itemvar->id,'type'=>'hidden']) ?>
									</td>
									
									<td><?= $this->Form->control('sales_rate',['class'=>'form-control sales_rate','label'=>false, 'value'=>$itemvar->sales_rate,'readonly']) ?></td>
									<td>
									<?php $options1=[]; $options1=[['text'=>'Active','value'=>'Active'],['text'=>'Deactive','value'=>'Deactive']] ?>
									<?= $this->Form->select('status',$options1,['empty'=>'-Select-','class'=>'form-control select status','label'=>false,'value'=>$itemvar->status]) ?>
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
			var dis=$(this).val();
			var div=100-dis;
			//alert(div);
			//var sale_rate=$(this).find('.sales_rate').val();
			var sale_rate=$(this).closest('tr').find('.sales_rate').val();
			var disAmt=(sale_rate*100)/(div);
			//var disAmt = Math.round(disAmt,2);
			$(this).closest('tr').find('.print_rate').val(round(disAmt,2));
	});
		
		renameRows();
		function renameRows(){  
			var i=0; 
			$('.main_table tbody tr').each(function(){
				
				$(this).find('input.id ').attr({name:'item_variations['+i+'][id]',id:'item_variations['+i+'][id]'})
				$(this).find('input.sales_rate ').attr({name:'item_variations['+i+'][sales_rate]',id:'item_variations['+i+'][sales_rate]'})
				$(this).find('select.status ').attr({name:'item_variations['+i+'][status]',id:'item_variations['+i+'][status]'});
				i++;
			});
		}

	";  

echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>