<?php $this->set('title', 'Location Transfer'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($locationTransferVoucher,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Create Location Transfer Voucher </strong></h3>
				</div>
			<?php //pr($sales_orders->customer_id); ?>
				<div class="panel-body">
					<div class="row">
						<center><h3>Location Details</h3></center>
						<hr>
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label class=" control-label">Select Loction</label>
								<div class="">
									
									<?= $this->Form->select('location_in_id',$locations,['empty'=>'---Select--','class'=>'form-control select location_in','label'=>false,'required'=>'required']) ?>
								</div>
							</div>
							 						
						</div>
						<div class="col-md-3"></div>
					</div>
					
					<div>
					</br>
					<center><h3>Item Details</h3></center>
					<hr>
						<div class="col-md-12">
							<table class="table table-bordered main_table">
								<thead>
									<tr align="center">
										<th style="text-align:left;width:5px;"><label>S.N<label></th>
										<th style="text-align:left;width:400px;"><label>Item Variations<label></th>
										<th style="text-align:center;width:130px; "><label>Quantity<label></th>
										<th style="text-align:center;width:130px; "><label>Action<label></th>
										</tr>
									 
								</thead>
								<tbody class="MainTbody"> 
									
								</tbody>	
							</table>	
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





<table id="sampleTable" width="100%" style="display:none;">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			<td  valign="top">1</td>
			<td  valign="top" class="itemList"> 
				<?= $this->Form->select('item_variation_id',$ItemToBeShown,['empty'=>'--select--','style'=>'','class'=>'form-control item','label'=>false,'readonly']) ?>
				<?= $this->Form->control('item_id',['type'=>'hidden','class'=>'form-control item_id','label'=>false,'readonly']) ?>
				<?= $this->Form->control('unit_variation_id',['type'=>'hidden','class'=>'form-control unit_variation_id','label'=>false,'readonly']) ?> 
			</td>
			
			<td  valign="top">
				<?= $this->Form->control('quantity',['type'=>'number','class'=>'form-control quantity','label'=>false]) ?>
				<span class="itemQty" style="font-size:10px;"></span>
			</td>
			 
			 
			
			<td valign="top"  >
				<a class="btn btn-primary  btn-condensed btn-sm add_row" role="button" ><i class="fa fa-plus"></i></a>
				<a class="btn btn-danger  btn-condensed btn-sm delete_row " role="button" ><i class="fa fa-times"></i></a>
			</td>
		</tr>
	</tbody>
</table>

<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>

<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
 <?php $js="var jvalidate = $('#jvalidate').validate({
		ignore: [],
		rules: {                                            
				party_ledger_id: {
						required: true,
				},
				sales_ledger_id: {
						required: true,
				},
				
			}
		});
		
		$(document).on('click','.add_row',function(){
			addMainRow();
			renameRows();
		});
		
		$(document).on('click','.delete_row',function(){
			var t=$(this).closest('tr').remove();
			renameRows();
		});
		
		addMainRow();
		
		function addMainRow(){
			var tr=$('#sampleTable tbody').html();
			$('.main_table tbody').append(tr);
			renameRows();
		}
		
		function renameRows(){ 
			var i=0; 
			$('.main_table tbody tr').each(function(){
				$(this).attr('row_no',i);
				$(this).find('td:nth-child(1)').html(++i); i--;
				$(this).find('input.item ').attr({name:'location_transfer_voucher_rows['+i+'][item_variation_id]',id:'location_transfer_voucher_rows['+i+'][item_variation_id]'})
				$(this).find('input.item_id ').attr({name:'location_transfer_voucher_rows['+i+'][item_id]',id:'location_transfer_voucher_rows['+i+'][item_id]'})
				$(this).find('input.unit_variation_id ').attr({name:'location_transfer_voucher_rows['+i+'][unit_variation_id]',id:'location_transfer_voucher_rows['+i+'][unit_variation_id]'})
				$(this).find('select.item ').attr({name:'location_transfer_voucher_rows['+i+'][item_variation_id]',id:'location_transfer_voucher_rows['+i+'][item_variation_id]'}).rules('add', 'required');
				$(this).find('.quantity ').attr({name:'location_transfer_voucher_rows['+i+'][quantity]',id:'location_transfer_voucher_rows['+i+'][quantity]'}).rules('add', 'required');
				 
				i++;
			});
		}
		
		
		$(document).on('change','.item',function(){ 
			var item_id=$(this).find('option:selected', this).attr('item_id');
			var current_stock=$(this).find('option:selected', this).attr('current_stock');
			var unit_variation_id=$(this).find('option:selected', this).attr('unit_variation_id');
			$(this).closest('tr').find('.unit_variation_id').val(unit_variation_id);
			$(this).closest('tr').find('.item_id').val(item_id);
			$(this).closest('tr').find('.quantity').attr('max',current_stock);
		});
		
			
		";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>