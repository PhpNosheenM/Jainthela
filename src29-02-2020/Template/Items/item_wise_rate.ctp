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

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Item</strong></h3>
				<div class="pull-right">
			
				<div class="panel-body">   			
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						<div class="form-group">
								<div class="col-md-4 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> Category </span>
										<?= $this->Form->select('category',$Allcategory,['empty'=>'-Select Category-','class'=>'form-control select','label'=>false,'value'=>$category, 'data-live-search'=>true]) ?>
										</div>
								</div>
								<div class="col-md-4 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> Item </span>
										<?= $this->Form->select('item',$ItemsData,['empty'=>'-Select Item-','class'=>'form-control select','label'=>false,'value'=>$itemid, 'data-live-search'=>true]) ?>
										</div>
								</div>
							<div class="input-group-btn">
								<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary']) ?>
							</div>
						</div>
						
						<?= $this->Form->end() ?>
					</div>
				</div> 
			
		</div> 	
				</div>
			<?= $this->Form->create($itemList,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered main_table">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Item name') ?></th>
									<th style="width:10%"><?= ('MRP') ?></th>
									<th style="width:10%"><?= ('Print Rate') ?></th>
									<th style="width:10%"><?= ('Discount %') ?></th>
									<th style="width:10%"><?= ('Sale Rate') ?></th>
									<th style="width:10%"><?= ('Ready To Sale') ?></th>
									
								</tr>
							</thead>
							<tbody class="MainTbody">                                         
								<?php $i = 0; ?>
								
								  <?php  foreach ($itemList as $itemvar):
								 $merge=$itemvar->item_name.'('.@$itemvar->visible_variation.')';
								  ?>
								<tr class="MainTr">
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($merge) ?>
									<?= $this->Form->control('id',['class'=>'form-control id','label'=>false, 'value'=>$itemvar->item_var_id,'type'=>'hidden']) ?>
									</td>
									<td><?= $this->Form->control('mrp',['class'=>'form-control mrp','label'=>false, 'value'=>$itemvar->mrp,'min'=>1]) ?></td>
									<td><?= $this->Form->control('print_rate',['class'=>'form-control print_rate','label'=>false, 'value'=>$itemvar->print_rate]) ?></td>
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
			
			//var sale_rate=$(this).find('.sales_rate').val();
			var print_rate=$(this).closest('tr').find('.print_rate').val();
			//var sale_rate=$(this).closest('tr').find('.sales_rate').val();
			var disAmt=(print_rate*dis)/(100);
			var sr=print_rate-disAmt;
			
			var sr = Math.round(sr,2);
			$(this).closest('tr').find('.sales_rate').val(round(sr,2));
		});
		
		$(document).on('keyup','.print_rate',function(){
			var print_rate=$(this).val();
			var dis=$(this).closest('tr').find('.discount_per').val();
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
	
		
		renameRows();
		function renameRows(){  
			var i=0; 
			$('.main_table tbody tr').each(function(){
				
				$(this).find('input.id ').attr({name:'item_variations['+i+'][id]',id:'item_variations['+i+'][id]'})
				$(this).find('input.mrp ').attr({name:'item_variations['+i+'][mrp]',id:'item_variations['+i+'][mrp]'})
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