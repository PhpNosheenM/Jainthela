<?php $this->set('title', 'Purchase Order'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($purchaseOrder,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Purchase Order </strong></h3>
				</div>
			
				<div class="panel-body">
					<div class="row">
					<center><h3> Purchase Details</h3></center>
							<hr>
						<div class="col-md-3">
							
							<div class="form-group">
								<label class=" control-label">Vendors</label>
								<div class="">     
									<?= $this->Form->select('vendor_id',$vendors,['empty'=>'---Select--','class'=>'form-control select vendor_id','label'=>false,'data-live-search'=>true]) ?>	
									
									<?php //$this->Form->select('customer_id',$customers,['empty'=>'---Select--','class'=>'form-control select','label'=>false]) ?>
								</div>
								
							</div>
						
							
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class=" control-label">Transaction Date </label>
								<div class="">                                            
									<?= $this->Form->control('transaction_date',['class'=>'form-control datepicker','placeholder'=>'Transaction Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date("d-m-Y")]) ?>
								</div>
							</div>
							<div class="form-group">
								<label class=" control-label"></label>
								<div class="">                                            
									<?php //$this->Form->select('sales_ledger_id',$Accountledgers,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
						</div>
						<div class="col-md-6">
						<div class="form-group">
								
							</div>
						</div>
					</div>
					<div class="panel-body">    
						<div class="row">
							<div class="">
								
								<center><h3> Item Details</h3></center>
								<hr>
								<table class="table table-bordered main_table">
									<thead>
										<tr align="center">
										<th rowspan="2" style="text-align:left;width:10px;"><label>S.N<label></th>
										<th rowspan="2" style="text-align:left;width:300px;"><label>Item<label></th>
										<th rowspan="2" style="text-align:center;width:130px; "><label>Quantity<label></th>
										<th rowspan="2" style="text-align:center;width:110px;"><label>Action<label></th>
									</thead>
									<tbody class="MainTbody">  
										
									</tbody>
									<tfoot>
										<?= $this->Form->control('total_amount',['type'=>'hidden','class'=>'form-control total_taxable_value','label'=>false,'readonly','value'=>@$sales_orders->total_amount]) ?>
										<?= $this->Form->control('total_gst',['type'=>'hidden','class'=>'form-control gst_amt','label'=>false,'readonly','value'=>@$sales_orders->total_gst]) ?>
										<?= $this->Form->control('grand_total',['type'=>'hidden','class'=>'form-control total_amt','label'=>false,'readonly','value'=>@$sales_orders->grand_total]) ?>
									</tfoot>
								</table>
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


<table id="sampleTable" width="100%" style="display:none;">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			<td  valign="top">1</td>
			<td  valign="top" class="itemList"> 
				<?= $this->Form->select('item_variation_id',$items,['empty'=>'--select--','style'=>'','class'=>'form-control item','label'=>false,'data-live-search'=>true,'readonly']) ?>
				<?= $this->Form->control('item_id',['type'=>'hidden','class'=>'form-control item_id','label'=>false,'readonly']) ?>
			</td>
			<td  valign="top">
				<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false]) ?>
				<?= $this->Form->control('rate',['type'=>'hidden','class'=>'form-control rate','label'=>false,'readonly']) ?>
				<?= $this->Form->control('net_amount',['type'=>'hidden','class'=>'form-control net_amount','label'=>false,'readonly']) ?>
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
<?php
   $js="var jvalidate = $('#jvalidate').validate({
		ignore: [],
		rules: {                                            
				vendor_id: {
						required: true,
				},
				
			}                                        
		});
		
		
		addMainRow();
		$(document).on('click','.add_row',function(){
			addMainRow();
			renameRows();
		});
		
		function addMainRow(){
			var tr=$('#sampleTable tbody').html();
			$('.main_table tbody').append(tr);
			$('.select').select();
			renameRows();
		}
		
		$(document).on('click','.delete_row',function(){
			var t=$(this).closest('tr').remove();
			renameRows();
			
		});
	
		$(document).on('change','.item',function(){ 
			var mrp=$(this).find('option:selected', this).attr('mrp'); 
			var item_id=$(this).find('option:selected', this).attr('item_id'); 
			$(this).closest('tr').find('.rate').val(mrp);
			$(this).closest('tr').find('.item_id').val(item_id);
			
		});
		
		$(document).on('change','.gst_type',function(){
			calculation();
		});
		
		$(document).on('keyup','.quantity',function(){
			calculation();
		});
		
		function renameRows(){ 
			var i=0; 
			$('.main_table tbody tr').each(function(){
				$(this).attr('row_no',i);
				$(this).find('td:nth-child(1)').html(++i); i--;
				$(this).find('.item').selectpicker();
				$(this).find('input.item_id ').attr({name:'purchase_order_rows['+i+'][item_id]',id:'purchase_order_rows['+i+'][item_id]'})
				$(this).find('select.item ').attr({name:'purchase_order_rows['+i+'][item_variation_id]',id:'purchase_order_rows['+i+'][item_variation_id]'}).rules('add', 'required');
				$(this).find('.quantity ').attr({name:'purchase_order_rows['+i+'][quantity]',id:'purchase_order_rows['+i+'][quantity]'}).rules('add', 'required');
				$(this).find('.rate ').attr({name:'purchase_order_rows['+i+'][rate]',id:'purchase_order_rows['+i+'][rate]'}).rules('add', 'required');
				
				$(this).find('.net_amount ').attr({name:'purchase_order_rows['+i+'][net_amount]',id:'purchase_order_rows['+i+'][net_amount]'});
				
				i++;
			});
		}
		
		function calculation(){
			$('.main_table tbody tr').each(function(){ 
				var qty=$(this).find('.quantity').val();
				var rate=$(this).find('.rate').val();
				var amt=qty*rate;
				$(this).find('.net_amount').val(amt);
			});
	
		}
	
	
		
		";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>