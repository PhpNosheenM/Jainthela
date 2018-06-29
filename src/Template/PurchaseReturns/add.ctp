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
								<label class=" control-label">Purchase Return No</label>
								<div class="">                                            
									<?php //$voucher_no= $LocationData->alise.'/'.$voucher_no ;
									//echo $voucher_no;
									?>
									<?= $this->Form->control('invoice_no',['class'=>'form-control','placeholder'=>'','label'=>false,'value'=>$voucher_no,'readonly']) ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class=" control-label">Party</label>
								<div class="">                                            
									<?= $this->Form->select('seller_ledger_id',$partyOptions,['class'=>'form-control select','label'=>false]) ?>
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
						<?php  
						$status=sizeof($purchase_invoices->purchase_invoice_rows[0]->item_variations_data);
						//pr($status); exit;
						if($status == 0){ ?>
							<table class="table table-bordered main_table">
								<thead>
									<tr align="center">
										<th rowspan="2" style="text-align:left;width:10px;"><label>S.N<label></th>
										<th rowspan="2" style="text-align:left;width:300px;"><label>Item<label></th>
										
										<th rowspan="2" style="text-align:center;width:130px; "><label>Unit Variation<label></th>
										<th rowspan="2" style="text-align:center;width:130px; "><label>Quantity<label></th>
										<th rowspan="2" style="text-align:center;width:180px;"><label>Rate<label></th>
										
										<th rowspan="2" style="text-align:center;"><label>Taxable Value<label></th>
										<th colspan="2" style="text-align:center;"><label id="gstDisplay">GST<label></th>
										<th rowspan="2" style="text-align:center;width:200px;"><label>Total<label></th>
										</tr>
									<tr>
										
										<th><div align="center" style="width:50px;">%</div></th>
										<th><div align="center"style="text-align:center;width:50px;">Rs</div></th>
										
									</tr>
								</thead>
								<tbody class="MainTbody"> 
								<?php foreach($purchase_invoices->purchase_invoice_rows as $purchase_invoice_row){ 
								$due_qty=$purchase_invoice_row->grn_row->quantity-$purchase_invoice_row->grn_row->transfer_quantity;
								if($due_qty > 0){
								?>
									<tr class="MainTr">
										<td  valign="top">1</td>
										 <td width="">
											<?php echo @$purchase_invoice_row->item->name;  ?>
											<input type="hidden" value="<?php echo $purchase_invoice_row->item_id; ?>" class="item_id1" >
											<input type="hidden" value="<?php echo $purchase_invoice_row->id; ?>" class="grn_row_id" >
											
										</td>
										<td width="">
											<?php echo $purchase_invoice_row->unit_variation->quantity_variation.' '.$purchase_invoice_row->unit_variation->unit->shortname; ?>
											<input type="hidden" value="<?php echo $purchase_invoice_row->unit_variation_id; ?>" class="unit_variation_id1" >
											
										</td>
										
										<td  valign="top">
											<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false,'value'=>$due_qty,'readonly']) ?>
											
										</td>
										<td valign="top">
											<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false,'value'=>$purchase_invoice_row->rate,'readonly']) ?>
										</td>
										
										<td valign="top">
											<?= $this->Form->control('taxable_value',['class'=>'form-control taxable_value','label'=>false,'readonly']) ?>
										</td>
										<td valign="top">
											
											<?php echo $purchase_invoice_row->item->gst_figure->tax_percentage; ?>
											<input type="hidden" value="<?php echo $purchase_invoice_row->item->gst_figure->id; ?>" class="gst_percentage" tax_percentage="<?php echo $purchase_invoice_row->item->gst_figure->tax_percentage; ?>"  >
											
											
											
										</td>
										<td valign="top">
											<?= $this->Form->control('gst_value',['class'=>'form-control gst_value','label'=>false,'readonly']) ?>
										</td>
										
										<td valign="top">
											<?= $this->Form->control('net_amount',['class'=>'form-control net_amount','label'=>false,'readonly']) ?>
										</td>
									</tr>
								<?php } } ?>
								</tbody>
								<tfoot>
									
									<tr>
										<td colspan="8" style="text-align:right;">Total Taxable</td>
										<td colspan="1" style="text-align:right;"><?= $this->Form->control('total_taxable_value',['class'=>'form-control total_taxable_value','label'=>false,'readonly']) ?></td>
									</tr>
									
									<tr>
										<td colspan="8" style="text-align:right;">GST Amount</td>
										<td colspan="1" style="text-align:right;"><?= $this->Form->control('total_gst',['class'=>'form-control gst_amt','label'=>false,'readonly']) ?></td>
									</tr>
									<tr>
										<td colspan="8" style="text-align:right;">Total Amount</td>
										<td colspan="1" style="text-align:right;"><?= $this->Form->control('total_amount',['class'=>'form-control total_amt','label'=>false,'readonly']) ?></td>
									</tr>
								</tfoot>
							</table>
							<?php }else{ ?>
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
										</tr>
									<tr>
										
										<th><div align="center" style="width:50px;">%</div></th>
										<th><div align="center"style="text-align:center;width:50px;">Rs</div></th>
										
									</tr>
								</thead>
								<tbody class="MainTbody"> 
								<?php foreach($purchase_invoices->purchase_invoice_rows as $purchase_invoice_row){ 
								//pr($purchase_invoice_row->item_variations_data);
								 ?>
									<tr class="MainTr">
										<td  valign="top">1</td>
										 <td width="">
											<?php 
											$merge=$purchase_invoice_row->item_variations_data->item->name.'('.@$purchase_invoice_row->item_variations_data->unit_variation->quantity_variation.'.'.@$purchase_invoice_row->item_variations_data->unit_variation->unit->shortname.')';
											echo @$merge;  ?>
											
											<input type="hidden" value="<?php echo $purchase_invoice_row->item_id; ?>" class="item_id2" >
											<input type="hidden" value="<?php echo $purchase_invoice_row->item_variation_id; ?>" class="item_variation_id2" >
											
										</td>
										
										
										<td  valign="top">
											<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false,'value'=>$purchase_invoice_row->quantity,'readonly']) ?>
											
										</td>
										<td valign="top">
											<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false,'value'=>$purchase_invoice_row->purchase_rate,'readonly']) ?>
										</td>
										
										<td valign="top">
											<?= $this->Form->control('taxable_value',['class'=>'form-control taxable_value','label'=>false,'readonly']) ?>
										</td>
										<td valign="top">
											<?php echo $purchase_invoice_row->item_variations_data->item->gst_figure->tax_percentage; ?>
											<input type="hidden" value="<?php echo $purchase_invoice_row->item_variations_data->item->gst_figure->id; ?>" class="gst_percentage" tax_percentage="<?php echo $purchase_invoice_row->item_variations_data->item->gst_figure->tax_percentage; ?>"  >
											
											
										</td>
										<td valign="top">
											<?= $this->Form->control('gst_value',['class'=>'form-control gst_value','label'=>false,'readonly']) ?>
										</td>
										
										<td valign="top">
											<?= $this->Form->control('net_amount',['class'=>'form-control net_amount','label'=>false,'readonly']) ?>
										</td>
									</tr>
								<?php } ?>
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
							<?php } ?>
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
			<td  valign="top" class="itemList"> 
				
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
				
				<?= $this->Form->select('gst_percentage',$GstFigures,['style'=>'display:none;','class'=>'form-control gst_percentage','label'=>false,'readonly']) ?>
				<span class="gstAmt" style=" text-align:left;font-size:13px;"></span>
			</td>
			<td valign="top">
				<?= $this->Form->control('gst_value',['class'=>'form-control gst_value','label'=>false,'readonly']) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('net_amount',['class'=>'form-control net_amount','label'=>false,'readonly']) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('purchase_rate',['class'=>'form-control purchase_rate','label'=>false,'readonly']) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('sales_rate',['class'=>'form-control sales_rate','label'=>false,'readonly']) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('mrp',['class'=>'form-control mrp','label'=>false,'readonly']) ?>
			</td>
			
			<td valign="top"  >
				<a class="btn btn-primary  btn-condensed btn-sm add_row" href="#" role="button" ><i class="fa fa-plus"></i></a>
				<a class="btn btn-danger  btn-condensed btn-sm delete_row " href="#" role="button" ><i class="fa fa-times"></i></a>
			</td>
			
		</tr>
	</tbody>
</table>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>

<?php
   $js="var jvalidate = $('#jvalidate').validate({
		ignore: [],
		rules: {                                            
				seller_ledger_id: {
						required: true,
				},
				name: {
						required: true,
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
		
		$(document).on('change','.gst_percentage',function(){
			calculation();
		});
		
		
		
		$(document).on('change','.gst_type',function(){
			calculation();
		});
		
		renameRows();
		function renameRows(){ 
				var i=0; 
				var seller_type='$status';
				if(seller_type==0){
					$('.main_table tbody tr').each(function(){ 
							 $(this).attr('row_no',i);
							$(this).find('td:nth-child(1)').html(++i); i--;
							$(this).find('.item_id1 ').attr({name:'purchase_return_rows['+i+'][item_id]',id:'purchase_return_rows['+i+'][item_id]'});
							$(this).find('.grn_row_id ').attr({name:'purchase_return_rows['+i+'][purchase_invoice_row_id]',id:'purchase_return_rows['+i+'][purchase_invoice_row_id]'});
							
							$(this).find('.unit_variation_id1 ').attr({name:'purchase_return_rows['+i+'][unit_variation_id]',id:'purchase_return_rows['+i+'][unit_variation_id]'}).rules('add', 'required')
							$(this).find('.quantity ').attr({name:'purchase_return_rows['+i+'][quantity]',id:'purchase_return_rows['+i+'][quantity]'}).rules('add', 'required');
							$(this).find('.rate ').attr({name:'purchase_return_rows['+i+'][rate]',id:'purchase_return_rows['+i+'][rate]'}).rules('add', 'required');
							$(this).find('.taxable_value ').attr({name:'purchase_return_rows['+i+'][taxable_value]',id:'purchase_return_rows['+i+'][taxable_value]'});
							$(this).find('.gst_percentage ').attr({name:'purchase_return_rows['+i+'][gst_figure_id]',id:'purchase_return_rows['+i+'][gst_figure_id]'});
							$(this).find('.gst_value ').attr({name:'purchase_return_rows['+i+'][gst_value]',id:'purchase_return_rows['+i+'][gst_value]'});
							$(this).find('.net_amount ').attr({name:'purchase_return_rows['+i+'][net_amount]',id:'purchase_return_rows['+i+'][net_amount]'});
							
							i++; 
					});
				}else{
					$('.main_table tbody tr').each(function(){
							 $(this).attr('row_no',i);
							$(this).find('td:nth-child(1)').html(++i); i--;
							$(this).find('input.item_id2 ').attr({name:'purchase_return_rows['+i+'][item_id]',id:'purchase_return_rows['+i+'][item_id]'})
							$(this).find('input.item_variation_id2 ').attr({name:'purchase_return_rows['+i+'][item_variation_id]',id:'purchase_return_rows['+i+'][item_variation_id]'}).rules('add', 'required');
							$(this).find('.quantity ').attr({name:'purchase_return_rows['+i+'][quantity]',id:'purchase_return_rows['+i+'][quantity]'}).rules('add', 'required');
							$(this).find('.rate ').attr({name:'purchase_return_rows['+i+'][rate]',id:'purchase_return_rows['+i+'][rate]'}).rules('add', 'required');
							$(this).find('.taxable_value ').attr({name:'purchase_return_rows['+i+'][taxable_value]',id:'purchase_return_rows['+i+'][taxable_value]'});
							$(this).find('.gst_percentage ').attr({name:'purchase_return_rows['+i+'][gst_figure_id]',id:'purchase_return_rows['+i+'][gst_figure_id]'});
							$(this).find('.gst_value ').attr({name:'purchase_return_rows['+i+'][gst_value]',id:'purchase_return_rows['+i+'][gst_value]'});
							$(this).find('.net_amount ').attr({name:'purchase_return_rows['+i+'][net_amount]',id:'purchase_return_rows['+i+'][net_amount]'});
							
							i++; 
					});
				}
				calculation();
		}
		function calculation(){ 
			var total_amount=0;
			var total_gst=0;
			var total_taxable_value=0;
			
			
			$('.main_table tbody tr').each(function(){
				
				var gst_type=$(this).find('.gst_type option:selected').val();
				
					var qty=$(this).find('.quantity').val();
					var rate=$(this).find('.rate').val();
					var quantity_factor=$(this).find('option:selected', this).attr('quantity_factor');
					var commission=$(this).find('option:selected', this).attr('commission');
					var unit=$(this).find('option:selected', this).attr('unit');
					var item_id=$(this).find('option:selected', this).attr('item_id');
					$(this).find('.item_id').val(item_id);
					var total_qty=quantity_factor*qty;
					$(this).find('.itemQty').html(total_qty +' '+ unit);
					var taxable_value=qty*rate;
					$(this).find('.taxable_value').val(taxable_value);
					//var gst_percentage=parseFloat($(this).find('.gst_percentage option:selected').attr('tax_percentage'));
					var gst_percentage=parseFloat($(this).find('.gst_percentage').attr('tax_percentage'));
					if(!gst_percentage){ 
						gst_rate=0;
					}else{ 
						gst_rate=round(round(taxable_value*gst_percentage)/100,2);
						gst_rate1=round((gst_rate/2),2);
						gst_rate=round((gst_rate1*2),2);
					}
					$(this).find('.gst_value').val(gst_rate);
					var net_amount=gst_rate+taxable_value;
					var net_amount1=round(net_amount,2);
					$(this).find('.net_amount').val(net_amount1);
					total_taxable_value=total_taxable_value+taxable_value;
					total_gst=total_gst+gst_rate;
					total_amount=total_amount+net_amount1;
				
				
					$('.total_taxable_value').val(round(total_taxable_value,2));
					$('.gst_amt').val(round(total_gst,2));
					$('.total_amt').val(round(total_amount,2));
					
				
			});
		}
		
	});
		
		";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>