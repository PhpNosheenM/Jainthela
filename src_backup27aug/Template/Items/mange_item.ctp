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
					<h3 class="panel-title"><strong>Item</strong></h3>
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
									<th style="width:10%"><?= ('Print Rate') ?></th>
									<th style="width:20%"><?= ('Discount %') ?>
									<?= $this->Form->control('discount_amt',['style'=>'width:100px;float:right;    margin-right: 30px;margin-top: -22px;','type'=>'text','class'=>'form-control discount_all','label'=>false, 'placeholder'=>'Discount All']) ?> </th>
									<th style="width:10%"><?= ('Sale Rate') ?></th>
									<th  style="width:15%" style="text-align:center">
									<?php $options1=[]; $options1=[['text'=>'Yes','value'=>'Yes'],['text'=>'No','value'=>'No']] ?>
									<?= $this->Form->select('sale',$options1,['empty'=>'-Ready To Sale-','class'=>'form-control select statusAll','label'=>false]) ?>
									</th>
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
									<td><?= $this->Form->control('print_rate',['class'=>'form-control print_rate','label'=>false, 'value'=>$itemvar->print_rate,'readonly']) ?></td>
									<td><?= $this->Form->control('discount_per',['class'=>'form-control discount_per','label'=>false, 'value'=>$itemvar->discount_per]) ?></td>
									<td><?= $this->Form->control('sales_rate',['class'=>'form-control sales_rate','label'=>false, 'value'=>$itemvar->sales_rate,'readonly']) ?></td>
									<td>
									<?php $options1=[]; $options1=[['text'=>'Yes','value'=>'Yes'],['text'=>'No','value'=>'No']] ?>
									<?= $this->Form->select('ready_to_sale',$options1,['empty'=>'-Select-','class'=>'form-control select status','label'=>false,'value'=>$itemvar->ready_to_sale]) ?>
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
			var print_rate=$(this).closest('tr').find('.print_rate').val();
			var disAmt=(print_rate*dis)/(100);
			var sr=print_rate-disAmt;
			var sr = Math.round(sr,2);
			$(this).closest('tr').find('.sales_rate').val(round(sr,2));
		});
		
		$(document).on('change','.statusAll',function(){
			var sel=$(this).find('option:selected').val();
			$('.status option').removeAttr('selected','selected');
			$('.status option[value='+sel+']').attr('selected','selected');
			$('.filter-option').html(sel);
		});
		
		$(document).on('keyup','.discount_all',function(){ 
			var t=$(this).val(); 
			$('.discount_per').val(t);
			calculation();
		});
		function calculation(){  
			var i=0; 
			$('.main_table tbody tr').each(function(){
				var dis=$(this).find('input.discount_per').val(); 
				var print_rate=$(this).find('.print_rate').val();
				var disAmt=(print_rate*dis)/(100);
				var sr=print_rate-disAmt;
				var sr = Math.round(sr,2);
				$(this).find('.sales_rate').val(round(sr,2));
			});
		}

		
		renameRows();
		function renameRows(){  
			var i=0; 
			$('.main_table tbody tr').each(function(){
				
				$(this).find('input.id ').attr({name:'item_variations['+i+'][id]',id:'item_variations['+i+'][id]'})
				$(this).find('input.print_rate ').attr({name:'item_variations['+i+'][print_rate]',id:'item_variations['+i+'][print_rate]'})
				$(this).find('input.discount_per ').attr({name:'item_variations['+i+'][discount_per]',id:'item_variations['+i+'][discount_per]'})
				$(this).find('input.sales_rate ').attr({name:'item_variations['+i+'][sales_rate]',id:'item_variations['+i+'][sales_rate]'})
				$(this).find('select.status ').attr({name:'item_variations['+i+'][ready_to_sale]',id:'item_variations['+i+'][ready_to_sale]'});
				i++;
			});
		}

	";  

echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>