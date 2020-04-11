<?php $this->set('title', 'Purchase Return'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($purchaseReturn,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Purchase Return</strong></h3>
				</div>
			
				<div class="panel-body">    
					<div class="row">
						<div class="col-md-3">
							
							
							<div class="form-group">
								<label class=" control-label">Party</label>
								<div class="">                                            
									<?= $this->Form->select('seller_ledger_id',$partyOptions,['empty'=>'--select party--','class'=>'form-control select seller_ledger_id','label'=>false]) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class=" control-label">Purchase Invoice No</label>
								<div id="unit_variations">                                      
									
									
									<?= $this->Form->control('invoice_no',['type'=>'hidden','class'=>'form-control','placeholder'=>'','label'=>false,'value'=>$voucher_no,'readonly']) ?>
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
								<label class=" control-label">Purchase Account</label>
								<div class="">                                            
									<?= $this->Form->select('purchase_ledger_id',$Accountledgers,['class'=>'form-control select','label'=>false]) ?>
								</div>
							</div>
							
						</div>
						<div class="col-md-6">
						<div class="form-group">
								<label class=" control-label">Narration</label>
								<div class=""> 
									<?= $this->Form->control('narration',['class'=>'form-control','placeholder'=>'Narration','label'=>false,'rows'=>'6']) ?>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-body">    
					<div class="row">
						<div class="table-responsive">
						
								<table class="table table-bordered main_table">
								<thead>
									<tr align="center">
										<th rowspan="2" style="text-align:left;width:10px;"><label>S.N<label></th>
										<th rowspan="2" style="text-align:left;width:300px;"><label>Item Variation<label></th>
										<th rowspan="2" style="text-align:center;width:130px; "><label>Quantity<label></th>
										<th rowspan="2" style="text-align:center;width:180px;"><label>Rate<label></th>
										
										<th rowspan="2" style="text-align:center;"><label>Taxable Value<label></th>
										<th colspan="2" style="text-align:center;"><label id="gstDisplay">GST<label></th>
										<th rowspan="2" style="text-align:center;width:200px;"><label>Total<label></th>
										<th rowspan="2" style="text-align:center;width:50px;"><label><label></th>
										</tr>
									<tr>
										
										<th><div align="center" style="width:50px;">%</div></th>
										<th><div align="center"style="text-align:center;width:50px;">Rs</div></th>
										
									</tr>
								</thead>
								<tbody class="MainTbody"> 
								
								
								</tbody>
								<tfoot>
									
									<tr>
										<td colspan="7" style="text-align:right;">Total Taxable</td>
										<td colspan="1" style="text-align:right;"><?= $this->Form->control('total_taxable_value',['class'=>'form-control total_taxable_value','label'=>false,'readonly']) ?></td>
									</tr>
									
									<tr>
										<td colspan="7" style="text-align:right;">GST Amount</td>
										<td colspan="1" style="text-align:right;"><?= $this->Form->control('total_gst',['class'=>'form-control gst_amt','label'=>false,'readonly']) ?></td>
									</tr>
									<tr>
										 
										<td colspan="7" style="text-align:right;">Total Amount</td>
										<td colspan="1" style="text-align:right;"><?= $this->Form->control('total_amount',['class'=>'form-control total_amt','label'=>false,'readonly']) ?></td>
									</tr>
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

<?php $GstType['excluding'] = 'Excluding'; ?>
<?php $GstType['including'] = 'Including'; ?>



<table id="sampleTable" width="100%" style="display:none;">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			<td  valign="top">1</td>
			<td  valign="top" class=""> 
				<?= $this->Form->control('item_id',['type'=>'hidden','class'=>'form-control item_id','label'=>false]) ?>
				<?= $this->Form->control('unit_variation_id',['type'=>'hidden','class'=>'form-control unit_variation_id','label'=>false]) ?>
				<?= $this->Form->select('item_variation_id',$items,['empty'=>'--select--','style'=>'','class'=>'form-control item itemSel','label'=>false,'readonly','data-live-search'=>true]) ?>
			</td>
			
			<td  valign="top">
				<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false]) ?>
				<span class="itemQty" style="font-size:10px;"></span>
			</td>
			<td valign="top">
				<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false]) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('taxable_value',['class'=>'form-control taxable_value','label'=>false,'readonly']) ?>
			</td>
			<td valign="top">
				
				<?= $this->Form->control('gst_percentage',['type'=>'text','class'=>'form-control gst_percentage','label'=>false,'readonly']) ?>
				<?= $this->Form->control('gst_figure_id',['type'=>'hidden','type'=>'hidden','class'=>'form-control gst_figure_id','label'=>false,'readonly']) ?>
				
				<span class="gstAmt" style=" text-align:left;font-size:13px;"></span>
			</td>
			<td valign="top">
				<?= $this->Form->control('gst_value',['class'=>'form-control gst_value','label'=>false,'readonly']) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('net_amount',['class'=>'form-control net_amount','label'=>false,'readonly']) ?>
			</td>
			<td valign="top"  >
				<a class="btn btn-primary  btn-condensed btn-sm add_row" role="button" ><i class="fa fa-plus"></i></a>
				<a class="btn btn-danger  btn-condensed btn-sm delete_row " role="button" ><i class="fa fa-times"></i></a>
			</td>
			
		</tr>
	</tbody>
</table>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>

<?php
	$kk='<input type="text" class="form-control input-sm ref_name " placeholder="Reference Name">';
	$dd='<input type="text" class="form-control input-sm rightAligntextClass dueDays " placeholder="Due Days">';
   $js="var jvalidate = $('#jvalidate').validate({
		ignore: [],
		rules: {                                            
				seller_ledger_id: {
						required: true,
				},
				name: {
						required: true,
				},
				invoice_no: {
						required: true,
						//maxlength: false,
				},
				
			}                                        
		});
		
	$(document).ready(function() {	
		$(document).on('keyup','.rate',function(){
			calculation();
		});
		$(document).on('keyup','.quantity',function(){
			calculation();
		});
		$(document).on('change','.item',function(){
			calculation();
		});
	
	$(document).on('change','.seller_ledger_id',function(){ 
		
		var sel=$(this).find('option:selected').val();
		var url='".$this->Url->build(["controller" => "PurchaseReturns", "action" => "getSeller"])."';
			url=url+'/'+sel;
			$.ajax({
				url: url,
				type: 'GET'
			}).done(function(response) {
				 $('#unit_variations').html(response);
			});
		
		});
		
		addMainRow();
		function addMainRow(){ 
			var tr=$('#sampleTable tbody').html();
			$('.main_table tbody').append(tr);
			renameRows();
		}
		 $(document).on('click','.add_row',function(){ 
			addMainRow();
		});
		
		 $(document).on('click','.delete_row',function(){
			var t=$(this).closest('tr').remove();
			renameRows();
			calculation();
		});
		
		function renameRows(){ 
				var i=0; 
				
					$('.main_table tbody tr').each(function(){ 
							 $(this).attr('row_no',i);
							$(this).find('td:nth-child(1)').html(++i); i--;
							$(this).find('.item').selectpicker();
							$(this).find('select.item ').attr({name:'purchase_return_rows['+i+'][item_variation_id]',id:'purchase_return_rows['+i+'][item_variation_id]'}).rules('add', 'required');
							
							$(this).find('.item_id ').attr({name:'purchase_return_rows['+i+'][item_id]',id:'purchase_return_rows['+i+'][item_id]'});
							
							$(this).find('.unit_variation_id ').attr({name:'purchase_return_rows['+i+'][unit_variation_id]',id:'purchase_return_rows['+i+'][unit_variation_id]'});
							
							$(this).find('.quantity ').attr({name:'purchase_return_rows['+i+'][quantity]',id:'purchase_return_rows['+i+'][quantity]'}).rules('add', 'required');
							$(this).find('.rate ').attr({name:'purchase_return_rows['+i+'][rate]',id:'purchase_return_rows['+i+'][rate]'}).rules('add', 'required');
							$(this).find('.taxable_value ').attr({name:'purchase_return_rows['+i+'][taxable_value]',id:'purchase_return_rows['+i+'][taxable_value]'});
							$(this).find('.gst_figure_id ').attr({name:'purchase_return_rows['+i+'][gst_figure_id]',id:'purchase_return_rows['+i+'][gst_figure_id]'});
							$(this).find('.gst_percentage ').attr({name:'purchase_return_rows['+i+'][gst_percentage]',id:'purchase_return_rows['+i+'][gst_percentage]'});
							$(this).find('.gst_value ').attr({name:'purchase_return_rows['+i+'][gst_value]',id:'purchase_return_rows['+i+'][gst_value]'});
							$(this).find('.net_amount ').attr({name:'purchase_return_rows['+i+'][net_amount]',id:'purchase_return_rows['+i+'][net_amount]'});
							
							i++; 
					});
				
				calculation();
		}
		function calculation(){ 
			var total_amount=0;
			var total_gst=0;
			var total_taxable_value=0;
			
			
			$('.main_table tbody tr').each(function(){
					var qty=$(this).find('.quantity').val();
					var rate=$(this).find('.rate').val();
					var current_stock=$(this).find('option:selected', this).attr('current_stock');
					var unit=$(this).find('option:selected', this).attr('unit');
					var item_id=$(this).find('option:selected', this).attr('item_id');
					var unit_variation_id=$(this).find('option:selected', this).attr('unit_variation_id');
					$(this).find('.item_id').val(item_id);
					$(this).find('.unit_variation_id').val(unit_variation_id);
					$(this).find('.itemQty').html(current_stock);
					$(this).find('.quantity').attr('max',current_stock);
					var taxable_value=qty*rate;
					var gst_percentage1=parseFloat($(this).find('.itemSel option:selected').attr('gst_value'));
					var gst_figure_id=parseFloat($(this).find('.itemSel option:selected').attr('gst_figure_id'));
					
					if(!gst_percentage1){ 
						gst_rate=0;
						gst_percentage1=0;
					}else{ 
						var x=100+gst_percentage1;
						gst_rate=(round((taxable_value*gst_percentage1)/x,2));
						
						gst_rate1=round((gst_rate/2),2);
						gst_rate=round((gst_rate1*2),2);
					} 
					taxable_value=taxable_value-gst_rate;
					$(this).find('.taxable_value').val(taxable_value);
					//$(this).find('.gst_value').val(gst_rate);
					var net_amount=gst_rate+taxable_value;
					var net_amount1=round(net_amount,2);
					$(this).find('.net_amount').val(net_amount);
					total_taxable_value=total_taxable_value+taxable_value;
					total_gst=total_gst+gst_rate;
					total_amount=total_amount+net_amount1;
					//alert(gst_percentage);
					$(this).closest('tr').find('.gst_percentage').val(gst_percentage1);
					$(this).closest('tr').find('.gst_figure_id').val(gst_figure_id);
					$(this).closest('tr').find('.gst_value').val(gst_rate);
				
					$('.total_taxable_value').val(round(total_taxable_value,2));
					$('.gst_amt').val(round(total_gst,2));
					$('.total_amt').val(round(total_amount,2));
				
				
			});
		}
		
	});
		
		";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>