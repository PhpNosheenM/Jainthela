<?php $this->set('title', 'Invoice'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($order,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Create Invoice </strong></h3>
				</div>
			<?php //pr($sales_orders->customer_id); ?>
				<div class="panel-body">
					<div class="row">
						<center><h3>Invoice Details</h3></center>
						<hr>
						<div class="col-md-3">
							<div class="form-group">
								<label class=" control-label">Invoice No</label>
								<div class="">
									
									<?= $this->Form->control('order_no',['class'=>'form-control','placeholder'=>'','label'=>false,'value'=>$order_no,'readonly']) ?>
								</div>
							</div>
							<div class="form-group">
								<label class=" control-label">Customer</label>
								<div class="">  
									 
										<?= $this->Form->select('party_ledger_id',$partyOptions,['empty'=>'---Select--','class'=>'form-control select prty_ldgr','label'=>false,'value'=>@$sales_orders->sales_ledger_id]) ?>
										
									<?php if(!empty($ids)){
									$transaction_date=date('d-m-Y', strtotime($sales_orders->transaction_date));
									@$delivery_date=date('d-m-Y', strtotime($sales_orders->delivery_date));
									$narration=$sales_orders->narration;
									$sales_ledger_id=$sales_orders->sales_ledger_id;
									  } ?>
								</div>
							</div>
							
						<input type="hidden" name="customer_id" id="customer_id">
						<input type="hidden" name="customer_address_id" id="customer_address_id">
						
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
								<label class=" control-label">Transaction Date </label>
								<div class="">
									<?php if(empty($ids)){ ?>
									<?= $this->Form->control('transaction_date',['class'=>'form-control datepicker','placeholder'=>'Transaction Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date("d-m-Y")]) ?>
									<?php }else{ ?>
										<?= $this->Form->control('transaction_date',['class'=>'form-control datepicker','placeholder'=>'Transaction Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>$transaction_date]) ?>
									<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label class=" control-label">Sales Account</label>
								<div class="">
									<?= $this->Form->select('sales_ledger_id',$Accountledgers,['class'=>'form-control select','label'=>false, 'value'=>@$sales_ledger_id]) ?>
								</div>
							</div>
							
						</div>
						<div class="col-md-6">
						<div class="form-group">
								<label class=" control-label">Narration</label>
								<div class="">
									<?= $this->Form->control('narration',['class'=>'form-control','placeholder'=>'Narration','label'=>false,'rows'=>'6','value'=>@$narration]) ?>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-body">
					<div class="row">
						<div class="table-responsive">
							<center><h3>Invoice Item Details</h3></center>
							<hr>
							<table class="table table-bordered main_table">
								<thead>
									<tr align="center">
										<th rowspan="2" style="text-align:left;width:10px;"><label>S.N<label></th>
										<th rowspan="2" style="text-align:left;width:300px;"><label>Item<label></th>
										
										<th rowspan="2" style="text-align:center;width:130px; "><label>Quantity<label></th>
										<th rowspan="2" style="text-align:center;width:130px;"><label>Rate<label></th>
										<th colspan="2" style="text-align:center;"><label id="Discount">Discount<label></th>
										<th rowspan="2" style="text-align:center;"><label>Taxable Value<label></th>
										<th colspan="2" style="text-align:center;"><label id="gstDisplay">GST<label></th>
										<th rowspan="2" style="text-align:center;width:200px;"><label>Total<label></th>
										<th rowspan="2" style="text-align:center;"><label>Action<label></th>
									</tr>
									<tr>
										
										<th><div align="center" style="width:50px;">%</div></th>
										<th><div align="center"style="text-align:center;width:50px;">Rs</div></th>
										<th><div align="center" style="width:50px;">%</div></th>
										<th><div align="center"style="text-align:center;width:50px;">Rs</div></th>
										
									</tr>
								</thead>
								<tbody class="MainTbody">  
								<?php if(!empty($ids)){ 
								//pr($sales_orders->sales_order_rows);
										foreach($sales_orders->sales_order_rows as $sales_order_row){
											@$g++;
								?>
									<tr class="MainTr">
										<td  valign="top"><?php echo $g; ?></td>
										<td  valign="top" class="itemList"> 
											<?= $this->Form->select('item_variation_id',$items,['empty'=>'--select--','style'=>'','class'=>'form-control item','label'=>false,'readonly', 'value'=>$sales_order_row->item_variation_id]) ?>
											<?= $this->Form->control('item_id',['type'=>'hidden','class'=>'form-control item_id','label'=>false,'readonly', 'value'=>$sales_order_row->item_id]) ?>
										</td>
										
										<td  valign="top">
											<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false, 'value'=>$sales_order_row->quantity]) ?>
											<span class="itemQty" style="font-size:10px;"></span>
										</td>
										<td valign="top">
											<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false, 'value'=>$sales_order_row->rate]) ?>
										</td>
										
										<td valign="top">
											<?= $this->Form->control('taxable_value',['class'=>'form-control taxable_value','label'=>false,'readonly', 'value'=>$sales_order_row->amount]) ?>
										</td>
										<td valign="top">
											<?= $this->Form->control('gst_percentage',['class'=>'form-control gst_percentage','label'=>false,'readonly', 'value'=>$sales_order_row->gst_percentage]) ?>
											<?= $this->Form->control('gst_figure_id',['type'=>'hidden','class'=>'form-control gst_figure_id','label'=>false,'readonly', 'value'=>$sales_order_row->gst_figure_id]) ?>
											<span class="gstAmt" style=" text-align:left;font-size:13px;"></span>
										</td>
										<td valign="top">
											<?= $this->Form->control('gst_value',['class'=>'form-control gst_value','label'=>false,'readonly', 'value'=>$sales_order_row->gst_value]) ?>
										</td>
										
										<td valign="top">
											<?= $this->Form->control('net_amount',['class'=>'form-control net_amount','label'=>false,'readonly','value'=>$sales_order_row->net_amount]) ?>
										</td>
										
										<td valign="top"  >
											<a class="btn btn-primary  btn-condensed btn-sm add_row" role="button" ><i class="fa fa-plus"></i></a>
											<a class="btn btn-danger  btn-condensed btn-sm delete_row " role="button" ><i class="fa fa-times"></i></a>
										</td>
									</tr>
								
								<?php } } ?>	
								</tbody>
								<tfoot>
									
									<tr>
										<td colspan="7" style="text-align:right;">Total Taxable</td>
										<td colspan="2" style="text-align:right;"><?= $this->Form->control('total_amount',['class'=>'form-control total_taxable_value','label'=>false,'readonly','value'=>@$sales_orders->total_amount]) ?></td>
									</tr>
									
									
									<tr>
										<td colspan="7" style="text-align:right;">GST Amount</td>
										<td colspan="2" style="text-align:right;"><?= $this->Form->control('total_gst',['class'=>'form-control gst_amt','label'=>false,'readonly','value'=>@$sales_orders->total_gst]) ?></td>
									</tr>
									
									<tr>
										<input type="hidden" name="dlvr_amnt" id="dlvr_amnt" value="<?php echo $deliveryCharges->amount; ?>">
										
										<input type="hidden" name="dlvr_chrg" id="dlvr_chrg" value="<?php echo $deliveryCharges->charge; ?>">
										
										<input type="hidden" name="dlvr_chrg_id" id="dlvr_chrg_id" value="<?php echo $deliveryCharges->id; ?>">
										
										<input type="hidden" name="delivery_charge_id" id="delivery_charge_id">
										
										<td colspan="7" style="text-align:right;">Delivery Charges</td>
										<td colspan="2" style="text-align:right;"><?= $this->Form->control('delivery_charge_amount',['class'=>'form-control dlvry_chrgs','label'=>false,'readonly','value'=>@$sales_orders->delivery_charge_amount]) ?></td>
									</tr>
									
									<tr>
										<td colspan="7" style="text-align:right;">Total Amount</td>
										<td colspan="2" style="text-align:right;"><?= $this->Form->control('grand_total',['class'=>'form-control total_amt','label'=>false,'readonly','value'=>@$sales_orders->grand_total]) ?></td>
									</tr>
								</tfoot>
							</table>
							
							<center><h3>Invoice Transaction Details</h3></center>
								<hr>
								<table width="100%" style="font-size:14px;">
									<tr>
										<th>Delivery Date</th>
										<th style="padding-left:40px !important;">Delivery Time</th>
									</tr>
									<tr>
										<td>
										<?php if(!empty($ids)){ ?>
											<?= $this->Form->control('delivery_date',['class'=>'form-control datepicker','placeholder'=>'Delivery Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>$delivery_date,'required']) ?>
										<?php }else{ ?>
											<?= $this->Form->control('delivery_date',['class'=>'form-control datepicker','placeholder'=>'Delivery Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date("d-m-Y"),'required']) ?>
										<?php }?>
											
										</td>
										<td style="padding-left:40px !important;">
											<?= $this->Form->select('delivery_time_id',$deliveryTimes,['empty'=>'----Select---Delivery---Time----','class'=>'form-control select','label'=>false,'required','value'=>@$sales_orders->delivery_time_id]) ?>
										</td>
										<td style="padding-left:40px !important;">
											<div class="col-md-4">
												<label class="check"><input name="order_type" type="radio" id="itm"  value="Credit"  class="iradio" name="iradio" checked="checked" /> Credit</label>
											</div>
											<div class="col-md-4">
												<label class="check"><input name="order_type" type="radio" id="slr"  value="COD" class="iradio" name="iradio"/> COD</label>
											</div>
											<div class="col-md-4">
												<label class="check"><input name="order_type" type="radio" id="cmbo"  value="OnLine" class="iradio" name="iradio"/> OnLine</label>
											</div>
										</td>
									</tr>
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

<?php $GstType['including'] = 'Including'; ?>
<?php $GstType['excluding'] = 'Excluding'; ?>


<table id="sampleTable" width="100%" style="display:none;">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			<td  valign="top">1</td>
			<td  valign="top" class="itemList"> 
				<?= $this->Form->select('item_variation_id',$items,['empty'=>'--select--','style'=>'','class'=>'form-control item','label'=>false,'readonly']) ?>
				<?= $this->Form->control('item_id',['type'=>'hidden','class'=>'form-control item_id','label'=>false,'readonly']) ?>
			</td>
			
			<td  valign="top">
				<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false]) ?>
				<span class="itemQty" style="font-size:10px;"></span>
			</td>
			<td valign="top">
				<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('discount_percent',['class'=>'form-control discount_percent','label'=>false]) ?>
				<?= $this->Form->control('discount_amount',['type'=>'hidden','class'=>'form-control discount_amount','label'=>false,'readonly']) ?>
				
			</td>
			<td valign="top">
				<?= $this->Form->control('taxable_value',['class'=>'form-control taxable_value','label'=>false,'readonly']) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('gst_percentage',['class'=>'form-control gst_percentage','label'=>false,'readonly']) ?>
				<?= $this->Form->control('gst_figure_id',['type'=>'hidden','class'=>'form-control gst_figure_id','label'=>false,'readonly']) ?>
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
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>

<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?php
if(empty($ids)){
   $js="var jvalidate = $('#jvalidate').validate({
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
		$(document).on('change','.prty_ldgr',function(){
			var cstmrid=$('option:selected', this).attr('customer_id');
			var customeraddressid=$('option:selected', this).attr('customer_address_id');
			$('#customer_id').val(cstmrid);
			$('#customer_address_id').val(customeraddressid);
		});
		$(document).on('change','.seller_ledger_id',function(){
			var seller_id=$('option:selected', this).attr('seller_id');
			var url='".$this->Url->build(["controller" => "PurchaseInvoices", "action" => "SelectItemSellerWise"])."';
			url=url+'/'+seller_id
			$.ajax({
				url: url,
				type: 'GET'
			}).done(function(response) {
				//$('#sampleTable tbody tr.MainTr').remove();
				var t=$('.MainTbody tr').remove();
				$('.itemList').html(response);
				addMainRow();
			});
			
		});
		 
			addMainRow(); 
		 
		$(document).on('click','.add_row',function(){
			addMainRow();
			renameRows();
		});
		
		function addMainRow(){
			var tr=$('#sampleTable tbody').html();
			$('.main_table tbody').append(tr);
			renameRows();
		}
		
		$(document).on('click','.delete_row',function(){
			var t=$(this).closest('tr').remove();
			renameRows();
			calculation();
		});
		
		$(document).on('keyup','.rate',function(){
			calculation();
		});
		$(document).on('keyup','.quantity',function(){
			calculation();
		});
		
		$(document).on('change','.gst_percentage',function(){
			calculation();
		});
		
		
		$(document).on('change','.item',function(){ 
			var gst_value=$(this).find('option:selected', this).attr('gst_value'); 
			var sale_rate=$(this).find('option:selected', this).attr('sale_rate'); 
			var gst_figure_id=$(this).find('option:selected', this).attr('gst_figure_id');  
			var item_id=$(this).find('option:selected', this).attr('item_id');  
			var current_stock=$(this).find('option:selected', this).attr('current_stock');  
			$(this).closest('tr').find('.item_id').val(item_id);
			$(this).closest('tr').find('.gst_percentage').val(gst_value);
			$(this).closest('tr').find('.gst_figure_id').val(gst_figure_id);
			$(this).closest('tr').find('.rate').val(sale_rate);
			$(this).closest('tr').find('.quantity').attr('max',current_stock);
			calculation();
		});
		
		$(document).on('change','.gst_type',function(){
			calculation();
		});
		
		function renameRows(){ 
			var i=0; 
			$('.main_table tbody tr').each(function(){
				$(this).attr('row_no',i);
				$(this).find('td:nth-child(1)').html(++i); i--;
				$(this).find('input.item_id ').attr({name:'order_details['+i+'][item_id]',id:'order_details['+i+'][item_id]'})
				$(this).find('select.item ').attr({name:'order_details['+i+'][item_variation_id]',id:'order_details['+i+'][item_variation_id]'}).rules('add', 'required');
				$(this).find('.quantity ').attr({name:'order_details['+i+'][quantity]',id:'order_details['+i+'][quantity]'}).rules('add', 'required');
				$(this).find('.rate ').attr({name:'order_details['+i+'][rate]',id:'order_details['+i+'][rate]'}).rules('add', 'required');
				$(this).find('.taxable_value ').attr({name:'order_details['+i+'][amount]',id:'order_details['+i+'][amount]'});
				$(this).find('.gst_percentage ').attr({name:'order_details['+i+'][gst_percentage]',id:'order_details['+i+'][gst_percentage]'});
				$(this).find('.gst_figure_id ').attr({name:'order_details['+i+'][gst_figure_id]',id:'order_details['+i+'][gst_figure_id]'});
				$(this).find('.gst_value ').attr({name:'order_details['+i+'][gst_value]',id:'order_details['+i+'][gst_value]'});
				$(this).find('.net_amount ').attr({name:'order_details['+i+'][net_amount]',id:'order_details['+i+'][net_amount]'});
				i++;
			});
		}
		function calculation(){
			var total_amount=0;
			var total_gst=0;
			var total_taxable_value=0;
			
			
			$('.main_table tbody tr').each(function(){
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
					var gst_percentage=parseFloat($(this).find('.gst_percentage').val()); 
					
					if(!gst_percentage){
						gst_rate=0;
					}else{ 
						gst_rate=round(round(taxable_value*gst_percentage)/100,2);
					}
					total_gst=total_gst+gst_rate;
					$(this).find('.gst_value').val(gst_rate);
					var net_amount=gst_rate+taxable_value;
					var net_amount1=round(net_amount,2);
					$(this).find('.net_amount').val(net_amount1);
					total_taxable_value=total_taxable_value+taxable_value;
					//total_gst=total_gst+gst_rate;
					total_amount=total_amount+net_amount1;
					var per_item_purchase_rate=net_amount1/qty;
					$(this).find('.purchase_rate').val(per_item_purchase_rate);
					var commission_rate=(per_item_purchase_rate*commission)/100;
					var per_item_sales_rate=round(per_item_purchase_rate+commission_rate,2);
					$(this).find('.sales_rate').val(per_item_sales_rate);
					$(this).find('.mrp').val(per_item_sales_rate);
			
					$('.total_taxable_value').val(round(total_taxable_value,2));
					$('.gst_amt').val(round(total_gst,2));
				 
				
			});
				var ttl_amnt=parseFloat($('.total_taxable_value').val());
				if(!ttl_amnt){ ttl_amnt=0; }
				var ttl_gst=parseFloat($('.gst_amt').val());
				if(!ttl_gst){ ttl_gst=0; }
				 
				var final_amount=parseFloat(ttl_amnt+ttl_gst);
				if(!final_amount){ final_amount=0; }
				 
				var dlvr_amnt=$('#dlvr_amnt').val();
				if(!dlvr_amnt){ dlvr_amnt=0; }
				var dlvr_chrg=$('#dlvr_chrg').val();
				if(!dlvr_chrg){ dlvr_chrg=0; }
				var delivery_chrg=0;
				if(final_amount<=dlvr_amnt){
					delivery_chrg=dlvr_chrg;
					var dlvr_chrg_id=$('#dlvr_chrg_id').val();
					if(!dlvr_chrg_id){ dlvr_chrg_id=0; }
					$('#delivery_charge_id').val(dlvr_chrg_id);
				}else{
					delivery_chrg=0;
					$('#delivery_charge_id').val('');
				}
				$('.dlvry_chrgs').val(delivery_chrg);
				
				var grand_total=parseFloat(final_amount)+parseFloat(delivery_chrg);
				 if(!grand_total){ grand_total=0; }
				 //alert(grand_total);
				$('.total_amt').val(round(grand_total,2));
		}
		
	
		
		";  
}else{
	$js="var jvalidate = $('#jvalidate').validate({
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
		
		$(document).ready(function() {
			var cstmrid=$('.prty_ldgr').find('option:selected').attr('customer_id');
			var customeraddressid=$('.prty_ldgr').find('option:selected').attr('customer_address_id');
			$('#customer_id').val(cstmrid);
			$('#customer_address_id').val(customeraddressid);
			
		});
		$(document).on('change','.prty_ldgr',function(){
			var cstmrid=$('option:selected', this).attr('customer_id');
			var customeraddressid=$('option:selected', this).attr('customer_address_id');
			$('#customer_id').val(cstmrid);
			$('#customer_address_id').val(customeraddressid);
		});
		
		$(document).on('change','.seller_ledger_id',function(){
			var seller_id=$('option:selected', this).attr('seller_id');
			var url='".$this->Url->build(["controller" => "PurchaseInvoices", "action" => "SelectItemSellerWise"])."';
			url=url+'/'+seller_id
			$.ajax({
				url: url,
				type: 'GET'
			}).done(function(response) {
				//$('#sampleTable tbody tr.MainTr').remove();
				var t=$('.MainTbody tr').remove();
				$('.itemList').html(response);
				addMainRow();
			});
			
		});
		 
			renameRows(); 
		 
		$(document).on('click','.add_row',function(){
			addMainRow();
			renameRows();
		});
		
		function addMainRow(){
			var tr=$('#sampleTable tbody').html();
			$('.main_table tbody').append(tr);
			renameRows();
		}
		
		$(document).on('click','.delete_row',function(){
			var t=$(this).closest('tr').remove();
			renameRows();
			calculation();
		});
		
		$(document).on('keyup','.rate',function(){
			calculation();
		});
		$(document).on('keyup','.quantity',function(){
			calculation();
		});
		
		$(document).on('change','.gst_percentage',function(){
			calculation();
		});
		
		
		$(document).ready(function() {
			var gst_value=$('.item').find('option:selected').attr('gst_value'); 
			var sale_rate=$('.item').find('option:selected').attr('sale_rate'); 
			var gst_figure_id=$('.item').find('option:selected').attr('gst_figure_id');  
			var item_id=$('.item').find('option:selected').attr('item_id');  
			var current_stock=$('.item').find('option:selected').attr('current_stock');  
			$('.item').closest('tr').find('.item_id').val(item_id);
			$('.item').closest('tr').find('.gst_percentage').val(gst_value);
			$('.item').closest('tr').find('.gst_figure_id').val(gst_figure_id);
			$('.item').closest('tr').find('.rate').val(sale_rate);
			$('.item').closest('tr').find('.quantity').attr('max',current_stock);
			calculation();
			
		});
		
		$(document).on('change','.item',function(){ 
			var gst_value=$(this).find('option:selected', this).attr('gst_value'); 
			var sale_rate=$(this).find('option:selected', this).attr('sale_rate'); 
			var gst_figure_id=$(this).find('option:selected', this).attr('gst_figure_id');  
			var item_id=$(this).find('option:selected', this).attr('item_id');  
			var current_stock=$(this).find('option:selected', this).attr('current_stock');  
			$(this).closest('tr').find('.item_id').val(item_id);
			$(this).closest('tr').find('.gst_percentage').val(gst_value);
			$(this).closest('tr').find('.gst_figure_id').val(gst_figure_id);
			$(this).closest('tr').find('.rate').val(sale_rate);
			$(this).closest('tr').find('.quantity').attr('max',current_stock);
			calculation();
		});
		
		$(document).on('change','.gst_type',function(){
			calculation();
		});
		
		function renameRows(){ 
			var i=0; 
			$('.main_table tbody tr').each(function(){
				$(this).attr('row_no',i);
				$(this).find('td:nth-child(1)').html(++i); i--;
				$(this).find('input.item_id ').attr({name:'order_details['+i+'][item_id]',id:'order_details['+i+'][item_id]'})
				$(this).find('select.item ').attr({name:'order_details['+i+'][item_variation_id]',id:'order_details['+i+'][item_variation_id]'}).rules('add', 'required');
				$(this).find('.quantity ').attr({name:'order_details['+i+'][quantity]',id:'order_details['+i+'][quantity]'}).rules('add', 'required');
				$(this).find('.rate ').attr({name:'order_details['+i+'][rate]',id:'order_details['+i+'][rate]'}).rules('add', 'required');
				$(this).find('.taxable_value ').attr({name:'order_details['+i+'][amount]',id:'order_details['+i+'][amount]'});
				$(this).find('.gst_percentage ').attr({name:'order_details['+i+'][gst_percentage]',id:'order_details['+i+'][gst_percentage]'});
				$(this).find('.gst_figure_id ').attr({name:'order_details['+i+'][gst_figure_id]',id:'order_details['+i+'][gst_figure_id]'});
				$(this).find('.gst_value ').attr({name:'order_details['+i+'][gst_value]',id:'order_details['+i+'][gst_value]'});
				$(this).find('.net_amount ').attr({name:'order_details['+i+'][net_amount]',id:'order_details['+i+'][net_amount]'});
				i++;
			});
		}
		calculation();
		function calculation(){
			var total_amount=0;
			var total_gst=0;
			var total_taxable_value=0;
			
			
			$('.main_table tbody tr').each(function(){
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
					var gst_percentage=parseFloat($(this).find('.gst_percentage').val()); 
					
					if(!gst_percentage){
						gst_rate=0;
					}else{ 
						gst_rate=round(round(taxable_value*gst_percentage)/100,2);
					}
					total_gst=total_gst+gst_rate;
					$(this).find('.gst_value').val(gst_rate);
					var net_amount=gst_rate+taxable_value;
					var net_amount1=round(net_amount,2);
					$(this).find('.net_amount').val(net_amount1);
					total_taxable_value=total_taxable_value+taxable_value;
					//total_gst=total_gst+gst_rate;
					total_amount=total_amount+net_amount1;
					var per_item_purchase_rate=net_amount1/qty;
					$(this).find('.purchase_rate').val(per_item_purchase_rate);
					var commission_rate=(per_item_purchase_rate*commission)/100;
					var per_item_sales_rate=round(per_item_purchase_rate+commission_rate,2);
					$(this).find('.sales_rate').val(per_item_sales_rate);
					$(this).find('.mrp').val(per_item_sales_rate);
			
				$('.total_taxable_value').val(round(total_taxable_value,2));
				$('.gst_amt').val(round(total_gst,2));
				
				
				
			});
				var ttl_amnt=parseFloat($('.total_taxable_value').val());
				if(!ttl_amnt){ ttl_amnt=0; }
				var ttl_gst=parseFloat($('.gst_amt').val());
				if(!ttl_gst){ ttl_gst=0; }
				
				var final_amount=parseFloat(ttl_amnt+ttl_gst);
				if(!final_amount){ final_amount=0; }
				
				var dlvr_amnt=$('#dlvr_amnt').val();
				if(!dlvr_amnt){ dlvr_amnt=0; }
				var dlvr_chrg=$('#dlvr_chrg').val();
				if(!dlvr_chrg){ dlvr_chrg=0; }
				var delivery_chrg=0;
				if(final_amount<=dlvr_amnt){
					delivery_chrg=dlvr_chrg;
					var dlvr_chrg_id=$('#dlvr_chrg_id').val();
					if(!dlvr_chrg_id){ dlvr_chrg_id=0; }
					$('#delivery_charge_id').val(dlvr_chrg_id);
				}else{
					delivery_chrg=0;
					$('#delivery_charge_id').val('');
				}
				$('.dlvry_chrgs').val(delivery_chrg);
				
				var grand_total=parseFloat(final_amount)+parseFloat(delivery_chrg);
				 if(!grand_total){ grand_total=0; }
				$('#grand_total').val(round(grand_total,2));
		}
		
	
		
		";  
}
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>