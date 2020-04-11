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
					
					<div>
					</br>
					<center><h3>Combo Offer</h3></center>
					<hr>
						<div class="col-md-12">
							<table width="100%" class="main_combo">
								<tbody class="main_cmbs">
									
								</tbody>	
							</table>	
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
										<th rowspan="2" style="text-align:center;width:110px;"><label>Rate<label></th>
										<th rowspan="2" style="text-align:center;width:130px;"><label id="Discount">Amount<label></th>
										<th colspan="2" style="text-align:center;"><label id="Discount">Discount<label></th>
										<th colspan="2" style="text-align:center;"><label id="Discount">Promo Code<label></th>
										<th rowspan="2" style="text-align:center;"><label>Taxable Value<label></th>
										<th colspan="2" style="text-align:center;"><label id="gstDisplay">GST<label></th>
										<th rowspan="2" style="text-align:center;width:200px;"><label>Total<label></th>
										<th rowspan="2" style="text-align:center;"><label>Action<label></th>
									</tr>
									<tr>
										
										<th><div align="center" style="width:40px;">%</div></th>
										<th><div align="center"style="text-align:center;width:60px;">Rs</div></th>
										<th><div align="center" style="width:40px;">%</div></th>
										<th><div align="center"style="text-align:center;width:60px;">Rs</div></th>
										<th><div align="center" style="width:40px;">%</div></th>
										<th><div align="center"style="text-align:center;width:60px;">Rs</div></th>
										
									</tr>
								</thead>
								<tbody class="MainTbody">  
								<?php if(!empty($ids)){ 
								//pr($sales_orders->sales_order_rows);
										foreach($sales_orders->sales_order_rows as $sales_order_row){
											@$g++;
								?>
									<tr class="MainTr">
										<td  valign="top">
											<?php echo $g; ?>
										</td>
										<td  valign="top" class="itemList">
											<?= $this->Form->select('item_variation_id',$items,['empty'=>'--select--','style'=>'','class'=>'form-control item','label'=>false,'readonly', 'value'=>$sales_order_row->item_variation_id]) ?>
											<?= $this->Form->control('item_id',['type'=>'hidden','class'=>'form-control item_id','label'=>false,'readonly', 'value'=>$sales_order_row->item_id]) ?>
											
											<?= $this->Form->control('combo_offer_id',['type'=>'hidden','class'=>'form-control cmb_ofr_id','label'=>false]) ?>
										</td>
										
										<td  valign="top">
											<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false, 'value'=>$sales_order_row->quantity]) ?>
											<span class="itemQty" style="font-size:10px;"></span>
										</td>
										<td valign="top">
											<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false, 'value'=>$sales_order_row->rate]) ?>
										</td>
										<td valign="top">
											<?= $this->Form->control('amount',['class'=>'form-control amount','label'=>false, 'value'=>$sales_order_row->amount]) ?>
										</td>
										<td valign="top">
											<?= $this->Form->control('discount_percent',['class'=>'form-control discount_percent','label'=>false]) ?>
											
										</td>
										<td valign="top">
											<?= $this->Form->control('discount_amount',['class'=>'form-control discount_amount','label'=>false,'readonly']) ?>
										</td>
										
										<td valign="top">
											<?= $this->Form->control('promo_percent',['class'=>'form-control promo_percent','label'=>false]) ?>
										</td>
										
										<td valign="top">
											<?= $this->Form->control('promo_amount',['class'=>'form-control promo_amount','label'=>false,'readonly']) ?>
										</td>
										
										<td valign="top">
											<?= $this->Form->control('taxable_value',['class'=>'form-control taxable_value','label'=>false,'readonly', 'value'=>$sales_order_row->amount]) ?>
											<?= $this->Form->control('taxable_value1',['class'=>'form-control taxable_value1','label'=>false,'readonly', 'value'=>$sales_order_row->amount]) ?>
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
											<?= $this->Form->control('net_amount1',['class'=>'form-control net_amount1','label'=>false,'readonly']) ?>
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
										<td colspan="12" style="text-align:right;">Total Amount Before Discount</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('before_discount',['class'=>'form-control before_discount','label'=>false,'readonly','value'=>@$sales_orders->total_amount]) ?>
										</td>
									</tr>
									<tr>
										<td colspan="12" style="text-align:right;">Discount Amount</td>
										<td colspan="2" style="text-align:right;">
										<?php //$this->Form->control('discount_percent',['class'=>'form-control dis_per','label'=>false,'value'=>@$sales_orders->discount_percent]) ?>
										<?= $this->Form->control('discount_amount',['class'=>'form-control dis_amnt','label'=>false,'value'=>@$sales_orders->discount_amount]) ?>
										</td>
									</tr>
									<tr>
										<td colspan="12" style="text-align:right;">Total Taxable</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('total_amount',['class'=>'form-control total_taxable_value','label'=>false,'readonly','value'=>@$sales_orders->total_amount]) ?>
										</td>
									</tr>
									<tr>
										<td colspan="12" style="text-align:right;">GST Amount</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('total_gst',['class'=>'form-control gst_amt','label'=>false,'readonly','value'=>@$sales_orders->total_gst]) ?>
										</td>
									</tr>
									<tr>
										<input type="hidden" name="dlvr_amnt" id="dlvr_amnt" value="<?php echo $deliveryCharges->amount; ?>">
										
										<input type="hidden" name="dlvr_chrg" id="dlvr_chrg" value="<?php echo $deliveryCharges->charge; ?>">
										
										<input type="hidden" name="dlvr_chrg_id" id="dlvr_chrg_id" value="<?php echo $deliveryCharges->id; ?>">
										
										<input type="hidden" name="delivery_charge_id" id="delivery_charge_id">
										
										<td colspan="12" style="text-align:right;">Delivery Charges</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('delivery_charge_amount',['class'=>'form-control dlvry_chrgs','label'=>false,'readonly','value'=>@$sales_orders->delivery_charge_amount]) ?>
										</td>
									</tr>
									<tr>
										<td colspan="12" style="text-align:right;">
											<b>Total Amount</b>
										</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('grand_total',['class'=>'form-control total_amt','label'=>false,'readonly','value'=>@$sales_orders->grand_total]) ?>
										</td>
									</tr>
									<tr>
										<td colspan="12" style="text-align:right;">From Wallet</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('amount_from_wallet',['class'=>'form-control wlt_amt','label'=>false,'value'=>@$sales_orders->amount_from_wallet]) ?>
										</td>
									</tr>
									<tr>
										<td colspan="12" style="text-align:right;">Final Due Amount</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('due_amount',['class'=>'form-control due_amt','label'=>false,'value'=>@$sales_orders->due_amount,'readonly']) ?>
											<?= $this->Form->control('round_off',['type'=>'hidden','class'=>'form-control round_off','label'=>false,'value'=>@$sales_orders->round_off,'readonly']) ?>
										</td>
									</tr>
								</tfoot>
							</table>
							<div class="form-group col-md-12">
								<div id="promos"></div>
							</div>
							
							<div><input type="text" class="appliacble_taxable_total" name="appliacble_taxable_total"></div>
							
							<center><h3>Invoice Transaction Details</h3></center>
								<hr>
								<table width="100%" style="font-size:14px;">
									<tr>
										<th>Delivery Date</th>
										<th style="padding-left:40px !important;">Delivery Time</th>
									</tr>
									<tr>
										<?php 
											$next_day=$deliverydates->next_day;
											$same_day=$deliverydates->same_day;
											 foreach($holidays as $holy_data){
												$holidy[]=date('d-m-Y', strtotime($holy_data->date));  
											 }
											 
											if($same_day=='Active'){
												$g=0;
											}else if($same_day=='Deactive'){
												$g=1;
											}
											$final_count_date=$holiday_count+$next_day;
											for($t=$g;$t<=$final_count_date;$t++){
												 
												$date_days=date('d-m-Y', strtotime("+".$t."days"));
											 
												if(in_array($date_days,$holidy)){
													continue;
												}else{
													$options1[$date_days] = $date_days; 
												}
											}
											
											?>
										<td>
										<?php if(!empty($ids)){ ?>
											<?= $this->Form->select('delivery_date',$options1,['empty'=>'---Select--Deliver--Date---','class'=>'form-control select','label'=>false,'required']) ?>
											
											<?php //$this->Form->control('delivery_date',['class'=>'form-control datepicker','placeholder'=>'Delivery Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>$delivery_date,'required']) ?>
										<?php }else{ ?>
											
											<?= $this->Form->select('delivery_date',$options1,['empty'=>'---Select--Deliver--Date---','class'=>'form-control select','label'=>false,'required']) ?>
											
											<?php //$this->Form->control('delivery_date',['class'=>'form-control datepicker','placeholder'=>'Delivery Date','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date("d-m-Y"),'required']) ?>
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


<table id="cmbsampleTable" width="100%" style="display:none;">
	<tbody class="cmbsampleMainTbody">
		<tr class="cmbTr">
			<td>
				<div class="form-group col-md-8">
					 <label class=" control-label">Combo Offer</label>
					 <?= $this->Form->select('combo_id',$combos,['empty'=>'---select--combo---','style'=>'','class'=>'form-control combo','label'=>false]) ?>
				</div>
			</td>
			<td align="left">
				<div class="form-group col-md-2">
					<a style="margin-top:40px;" class="btn btn-primary btn-condensed btn-sm add_combo" role="button" ><i class="fa fa-plus"></i></a>
				</div>	
			</td>
			<td align="left">
				<div class="form-group col-md-2">
					<a style="margin-top:40px;" class="btn btn-danger  btn-condensed btn-sm delete_combo " role="button" ><i class="fa fa-times"></i></a>
				</div>
				
			</td>
			
		</tr>
	</tbody>
</table>	
<table id="sampleTable" width="100%" style="display:none;">
	<tbody class="sampleMainTbody">
		<tr class="MainTr">
			<td  valign="top">1</td>
			<td  valign="top" class="itemList"> 
				<?= $this->Form->select('item_variation_id',$items,['empty'=>'--select--','style'=>'','class'=>'form-control item','label'=>false,'readonly']) ?>
				<?= $this->Form->control('item_id',['type'=>'hidden','class'=>'form-control item_id','label'=>false,'readonly']) ?>
				
				<?= $this->Form->control('combo_offer_id',['type'=>'hidden','class'=>'form-control cmb_ofr_id','label'=>false]) ?>
			</td>
			
			<td  valign="top">
				<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false]) ?>
				<span class="itemQty" style="font-size:10px;"></span>
			</td>
			<td valign="top">
				<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('amount',['class'=>'form-control amount','label'=>false]) ?>
				
			</td>
			<td valign="top">
				<?= $this->Form->control('discount_percent',['class'=>'form-control discount_percent','label'=>false]) ?>
				
			</td>
			<td valign="top">
				<?= $this->Form->control('discount_amount',['class'=>'form-control discount_amount','label'=>false,'readonly']) ?>
				<?= $this->Form->control('txbal',['class'=>'form-control txbal','label'=>false]) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('promo_percent',['class'=>'form-control promo_percent','label'=>false]) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('promo_amount',['class'=>'form-control promo_amount','label'=>false,'readonly']) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('taxable_value',['class'=>'form-control taxable_value','label'=>false,'readonly']) ?>
				<?= $this->Form->control('taxable_value1',['class'=>'form-control taxable_value1','label'=>false,'readonly']) ?>
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
				<?= $this->Form->control('net_amount1',['class'=>'form-control net_amount1','label'=>false,'readonly']) ?>
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
		
		$(document).on('change','.combo',function(){
			$('.combo_tr').remove();
			$('.main_combo tbody tr').each(function(){
				var combo_id=$('option:selected', this).val();
				var combo_count=$(this).closest('tr').find('.delete_combo').attr('delete_combo_count');
				var url='".$this->Url->build(["controller" => "Orders", "action" => "combo_add"])."';
				url=url+'/'+combo_id+'/'+combo_count
				$.ajax({
					url: url,
					type: 'GET'
				}).done(function(response) {
					$('.main_table tbody tr:last').after(response);
					renameRows();
					calculation();
				});
			});
		});
		

		
		$(document).on('change','.prty_ldgr',function(){
			var cstmrid=$('option:selected', this).attr('customer_id');
			var customeraddressid=$('option:selected', this).attr('customer_address_id');
			var membership_discount=$('option:selected', this).attr('membership_discount');
			var wallet=$('option:selected', this).attr('wallet');
			var membership_start_date=$('option:selected', this).attr('membership_start_date');
			var membership_end_date=$('option:selected', this).attr('membership_end_date');
			$('.wlt_amt').attr('max',wallet);
			$('#customer_id').val(cstmrid);
			$('#customer_address_id').val(customeraddressid);
			var today = new Date();
				var dd = today.getDate();

				var mm = today.getMonth()+1; 
				var yyyy = today.getFullYear();
				if(dd<10) 
				{
					dd='0'+dd;
				} 

				if(mm<10) 
				{
					mm='0'+mm;
				} 
				today = dd+'-'+mm+'-'+yyyy;
				
				if(membership_start_date<=today && membership_end_date>=today){
					var member_dis_per=membership_discount;
				}else{
					var member_dis_per=0;
				}
				//$('.dis_per').val(member_dis_per);
				
				var url='".$this->Url->build(["controller" => "Orders", "action" => "promo"])."';
				url=url+'/'+cstmrid
				$.ajax({
					url: url,
					type: 'GET'
				}).done(function(response) {
					//alert(response);
					$('#promos').html(response);
				});
				
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
		
		addcomboRow();
		
		$(document).on('click','.add_combo',function(){
			addcomboRow();
			renamecomboRows();
		});
		
		$(document).on('click','.delete_combo',function(){
			var delete_combo_count=$(this).attr('delete_combo_count');
			var t=$(this).closest('tr').remove();
			$('.cmbo_'+delete_combo_count).remove();
			renamecomboRows();
			renameRows();
			calculation();
		});
		
		function renamecomboRows(){
			var b=0;
			$('.main_combo tbody tr').each(function(){
				b++;
				$(this).find('select.combo').attr({name:'combo_id',id:'combo_id',combo_count:+b});
				$(this).closest('tr').find('.delete_combo').attr({delete_combo_count:+b});
				 
			});
		}
		
		
		function addcomboRow(){
			var tr=$('#cmbsampleTable tbody').html();
			$('.main_combo tbody').append(tr);
			renamecomboRows();
		}
		
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
		$(document).on('keyup','.wlt_amt',function(){
			calculation();
		});
		
		$(document).on('keyup','.discount_percent',function(){
			calculation();
		});
		
		$(document).on('change','.gst_percentage',function(){
			calculation();
		});
		
		$(document).on('change','.promo',function(){
			calculation();
		});
		
		
		$(document).on('change','.item',function(){
			var gst_value=$(this).find('option:selected', this).attr('gst_value'); 
			var sale_rate=$(this).find('option:selected', this).attr('sale_rate'); 
			var discount_applicable=$(this).find('option:selected', this).attr('discount_applicable');
			var member_dis=$('.prty_ldgr').find('option:selected').attr('membership_discount');
			$(this).closest('tr').find('.discount_percent').val(member_dis);
			if(discount_applicable=='No'){
				$(this).closest('tr').find('.discount_percent').val(0);
				$(this).closest('tr').find('.discount_percent').attr('applicable','No');
			}else{
				$(this).closest('tr').find('.discount_percent').attr('applicable','Yes');
			}
			var gst_figure_id=$(this).find('option:selected', this).attr('gst_figure_id');  
			var item_id=$(this).find('option:selected', this).attr('item_id');  
			var current_stock=$(this).find('option:selected', this).attr('current_stock');  
			var virtual_stock=$(this).find('option:selected', this).attr('virtual_stock');  
			var demand_stock=$(this).find('option:selected', this).attr('demand_stock');  
			$(this).closest('tr').find('.item_id').val(item_id);
			$(this).closest('tr').find('.gst_percentage').val(gst_value);
			$(this).closest('tr').find('.gst_figure_id').val(gst_figure_id);
			$(this).closest('tr').find('.rate').val(sale_rate);
			var final_stock=parseFloat(current_stock)+parseFloat(virtual_stock)-parseFloat(demand_stock);
			$(this).closest('tr').find('.quantity').attr('max',final_stock);
			calculation();
		});
		
		$(document).on('change','.gst_type',function(){
			calculation();
		});
		
		function renameRows(){
			var i=0; 
			$('.main_table tbody tr').each(function(){
				$(this).attr('row_no',i);
				$(this).find('.cmb_ofr_id ').attr({name:'order_details['+i+'][combo_offer_id]',id:'order_details['+i+'][combo_offer_id]'});
				
				$(this).find('td:nth-child(1)').html(++i); i--;
				$(this).find('input.item_id ').attr({name:'order_details['+i+'][item_id]',id:'order_details['+i+'][item_id]'})
				$(this).find('select.item ').attr({name:'order_details['+i+'][item_variation_id]',id:'order_details['+i+'][item_variation_id]'}).rules('add', 'required');
				$(this).find('.quantity ').attr({name:'order_details['+i+'][quantity]',id:'order_details['+i+'][quantity]'}).rules('add', 'required');
				$(this).find('.rate ').attr({name:'order_details['+i+'][rate]',id:'order_details['+i+'][rate]'}).rules('add', 'required');
				$(this).find('.amount ').attr({name:'order_details['+i+'][amount]',id:'order_details['+i+'][amount]'}).rules('add', 'required');
				$(this).find('.discount_percent ').attr({name:'order_details['+i+'][discount_percent]',id:'order_details['+i+'][discount_percent]'}).rules('add', 'required');
				$(this).find('.discount_amount ').attr({name:'order_details['+i+'][discount_amount]',id:'order_details['+i+'][discount_amount]'}).rules('add', 'required');
				$(this).find('.txbal ').attr({name:'order_details['+i+'][txbal]',id:'order_details['+i+'][txbal]'}).rules('add', 'required');
				$(this).find('.promo_percent ').attr({name:'order_details['+i+'][promo_percent]',id:'order_details['+i+'][promo_percent]'});
				$(this).find('.promo_amount ').attr({name:'order_details['+i+'][promo_amount]',id:'order_details['+i+'][promo_amount]'});
				
				
				$(this).find('.taxable_value ').attr({name:'order_details['+i+'][taxable_value]',id:'order_details['+i+'][taxable_value]'});
				$(this).find('.taxable_value1 ').attr({name:'order_details['+i+'][taxable_value1]',id:'order_details['+i+'][taxable_value1]'});
				$(this).find('.gst_percentage ').attr({name:'order_details['+i+'][gst_percentage]',id:'order_details['+i+'][gst_percentage]'});
				$(this).find('.gst_figure_id ').attr({name:'order_details['+i+'][gst_figure_id]',id:'order_details['+i+'][gst_figure_id]'});
				$(this).find('.gst_value ').attr({name:'order_details['+i+'][gst_value]',id:'order_details['+i+'][gst_value]'});
				$(this).find('.net_amount ').attr({name:'order_details['+i+'][net_amount]',id:'order_details['+i+'][net_amount]'});
				$(this).find('.net_amount1 ').attr({name:'order_details['+i+'][net_amount1]',id:'order_details['+i+'][net_amount1]'});
				i++;
			});
		}
		function calculation(){
			var total_amount=0;
			var total_gst=0;
			var total_taxable_value=0;
			var tot_txbl=0;
			
			$('.main_table tbody tr').each(function(){
				
				
					var discount_applicable=$(this).find('option:selected', this).attr('discount_applicable');
					var member_dis=$('.prty_ldgr').find('option:selected').attr('membership_discount');
					$(this).closest('tr').find('.discount_percent').val(member_dis);
					if(discount_applicable=='No'){
						$(this).closest('tr').find('.discount_percent').val(0);
						$(this).closest('tr').find('.discount_percent').attr('applicable','No');
					}else{
						$(this).closest('tr').find('.discount_percent').attr('applicable','Yes');
					}
			
			
					var qty=$(this).find('.quantity').val();
					var rate=$(this).find('.rate').val();
					var discount_percent=$(this).find('.discount_percent').val();
					//alert(discount_percent);
					var quantity_factor=$(this).find('option:selected', this).attr('quantity_factor');
					var commission=$(this).find('option:selected', this).attr('commission');
					var unit=$(this).find('option:selected', this).attr('unit');
					var item_id=$(this).find('option:selected', this).attr('item_id');
					var item_category_id=$(this).find('option:selected', this).attr('category_id');
					$(this).find('.item_id').val(item_id);
					
					$(this).find('.item_id').val(item_id);
					var total_qty=quantity_factor*qty;
					$(this).find('.itemQty').html(total_qty +' '+ unit);
					var taxable_value_before_dis=qty*rate;
					var taxable_value_after_dis=qty*rate;
					$(this).closest('tr').find('.amount').val(taxable_value_before_dis);
					if(discount_percent){
						var dis=round(round(taxable_value_before_dis*discount_percent)/100,2);
						var taxable_value_after_dis=taxable_value_before_dis-dis;
						$(this).find('.discount_amount').val(round(dis,2));
					}
					
					$(this).find('.txbal').val(taxable_value_after_dis);
					var promo_amount=$('.promo').find('option:selected').attr('discount_amount');
					if(!promo_amount){ promo_amount=0; }
					var promo_percent=$('.promo').find('option:selected').attr('discount_percent');
					if(!promo_percent){ promo_percent=0; }
					var promo_category_id=$('.promo').find('option:selected').attr('category_id');
					if(!promo_category_id){ promo_category_id=0; }
					var promo_item_id=$('.promo').find('option:selected').attr('item_id');
					if(!promo_item_id){ promo_item_id=0; }
					var discount_of_max_amount=$('.promo').find('option:selected').attr('discount_of_max_amount');
					if(!discount_of_max_amount){ discount_of_max_amount=0; }
					var cash_back=$('.promo').find('option:selected').attr('cash_back');
					if(!cash_back){ cash_back=0; }
					 
					var applicable=$(this).closest('tr').find('.discount_percent').attr('applicable');
					if(applicable=='Yes'){
						
						if((promo_percent==0) && (cash_back==0)){
							
							if((promo_category_id>0) && (promo_category_id==item_category_id) && (promo_item_id==0) && (discount_of_max_amount==0)){
								var apply_get_txbl=$(this).find('.txbal').val();
								tot_txbl+=parseFloat(apply_get_txbl);
								taxable_value_after_dis=taxable_value_after_dis-promo_amount;
							}
							else if((promo_item_id>0) && (promo_item_id==item_id) && (discount_of_max_amount==0)){
								var apply_get_txbl=$(this).find('.txbal').val();
								tot_txbl+=parseFloat(apply_get_txbl);
								taxable_value_after_dis=taxable_value_after_dis-promo_amount;
							}
							else if((discount_of_max_amount>0) && (promo_item_id==0) && (promo_category_id==0)){
								var apply_get_txbl=$(this).find('.txbal').val();
								tot_txbl+=parseFloat(apply_get_txbl);
								taxable_value_after_dis=taxable_value_after_dis-promo_amount;
							}
							else if((promo_category_id==0) && (promo_item_id==0) && (discount_of_max_amount==0)){
								var apply_get_txbl=$(this).find('.txbal').val();
								tot_txbl+=parseFloat(apply_get_txbl);
								taxable_value_after_dis=taxable_value_after_dis-promo_amount;
								
							}
							
						}
						
						else if((promo_percent==0) && (promo_amount==0) && (discount_of_max_amount>0) && (cash_back>0)){
							
							
							
							
							
						}
						
						else{
							if((promo_category_id>0) && (promo_category_id==item_category_id) && (promo_item_id==0) && (discount_of_max_amount==0)){
								var apply_get_txbl=$(this).find('.txbal').val();
								tot_txbl+=parseFloat(apply_get_txbl);
								taxable_value_after_dis=taxable_value_after_dis-promo_amount;
							}
							else if((promo_item_id>0) && (promo_item_id==item_id) && (discount_of_max_amount==0)){
								var apply_get_txbl=$(this).find('.txbal').val();
								tot_txbl+=parseFloat(apply_get_txbl);
								taxable_value_after_dis=taxable_value_after_dis-promo_amount;
							}
							else if((discount_of_max_amount>0) && (promo_item_id==0) && (promo_category_id==0)){
								var apply_get_txbl=$(this).find('.txbal').val();
								tot_txbl+=parseFloat(apply_get_txbl);
								taxable_value_after_dis=taxable_value_after_dis-promo_amount;
							}
							else if((promo_category_id==0) && (promo_item_id==0) && (discount_of_max_amount==0)){
								var apply_get_txbl=$(this).find('.txbal').val();
								tot_txbl+=parseFloat(apply_get_txbl);
								taxable_value_after_dis=taxable_value_after_dis-promo_amount;
								
							}

						}	
						
						
					}
					  var taxable_value=taxable_value_after_dis;
					/* 
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
					$('.gst_amt').val(round(total_gst,2)); */
				  
				
			});
				$('.appliacble_taxable_total').val(tot_txbl);
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
				var free_shipping=$('.promo').find('option:selected').attr('free_shipping');
				if(free_shipping=='Yes'){
					delivery_chrg=0;
				}
				$('.dlvry_chrgs').val(delivery_chrg);
				
				var grand_total=parseFloat(final_amount)+parseFloat(delivery_chrg);
				 if(!grand_total){ grand_total=0; }
				 //alert(grand_total);
				$('.total_amt').val(round(grand_total,2));
				calculation1();
		}
		
		
		
		function calculation1(){
			var total_amount=0;
			var total_gst=0;
			var total_taxable_value=0;
			var total_discount=0;
			var before_discount_all=0;
			$('.main_table tbody tr').each(function(){
				
					var qty=$(this).find('.quantity').val();
					var rate=$(this).find('.rate').val();
					var discount_percent=$(this).find('.discount_percent').val();
					//alert(discount_percent);
					var quantity_factor=$(this).find('option:selected', this).attr('quantity_factor');
					var commission=$(this).find('option:selected', this).attr('commission');
					var unit=$(this).find('option:selected', this).attr('unit');
					var item_id=$(this).find('option:selected', this).attr('item_id');
					var item_category_id=$(this).find('option:selected', this).attr('category_id');
					$(this).find('.item_id').val(item_id);
					var before_discount=$(this).find('.amount').val();
					if(!before_discount){ before_discount=0; }
					
					var taxable_value_after_dis=parseFloat($(this).find('.txbal').val());
					var appliacble_taxable_total =parseFloat($('.appliacble_taxable_total').val());
					if(!appliacble_taxable_total){ appliacble_taxable_total=0; }
					var promo_amount=$('.promo').find('option:selected').attr('discount_amount');
					if(!promo_amount){ promo_amount=0; }
					var promo_percent=$('.promo').find('option:selected').attr('discount_percent');
					if(!promo_percent){ promo_percent=0; }
					var promo_category_id=$('.promo').find('option:selected').attr('category_id');
					if(!promo_category_id){ promo_category_id=0; }
					var promo_item_id=$('.promo').find('option:selected').attr('item_id');
					if(!promo_item_id){ promo_item_id=0; }
					var cash_back=$('.promo').find('option:selected').attr('cash_back');
					if(!cash_back){ cash_back=0; }
					
					var discount_of_max_amount=$('.promo').find('option:selected').attr('discount_of_max_amount');
					if(!discount_of_max_amount){ discount_of_max_amount=0; }
					
					
					var applicable=$(this).closest('tr').find('.discount_percent').attr('applicable');
					if((applicable=='Yes') && (cash_back==0)){
						//alert(promo_category_id);
					//alert(item_category_id);
						if(promo_percent==0){
							$(this).find('.promo_amount').val(0);
							if((promo_category_id>0) && (promo_category_id==item_category_id) && (promo_item_id==0) && (discount_of_max_amount==0)){
						var seprate_promo=parseFloat((taxable_value_after_dis/appliacble_taxable_total)*promo_amount);
						if(!seprate_promo){ seprate_promo=0; }
						var apply_get_txbl=$(this).find('.txbal').val();
						var main_seprate_promo=round(seprate_promo,2);
						$(this).find('.promo_amount').val(main_seprate_promo);
						$(this).find('.promo_percent').val(0);
						taxable_value_after_dis=taxable_value_after_dis-main_seprate_promo;
							}
						else if((promo_item_id>0) && (promo_item_id==item_id) && (discount_of_max_amount==0)){
								var seprate_promo=parseFloat((taxable_value_after_dis/appliacble_taxable_total)*promo_amount);
						if(!seprate_promo){ seprate_promo=0; }
						var main_seprate_promo=round(seprate_promo,2);
						var apply_get_txbl=$(this).find('.txbal').val();
						$(this).find('.promo_amount').val(seprate_promo);
						$(this).find('.promo_percent').val(0);
						taxable_value_after_dis=taxable_value_after_dis-seprate_promo;
							}
						else if((discount_of_max_amount>0) && (promo_item_id==0) && (promo_category_id==0)){
						
						if(discount_of_max_amount<=appliacble_taxable_total){
						var seprate_promo=parseFloat((taxable_value_after_dis/appliacble_taxable_total)*promo_amount);
						
						if(!seprate_promo){ seprate_promo=0; }
						var main_seprate_promo=round(seprate_promo,2);
						var apply_get_txbl=$(this).find('.txbal').val();
						$(this).find('.promo_amount').val(seprate_promo);
						$(this).find('.promo_percent').val(0);
						taxable_value_after_dis=taxable_value_after_dis-seprate_promo;
						}
						else{
							
							alert('Promo Code is not Applicable');
							$('.promo').val('');
							calculation();
						}
							}	
						else if((promo_category_id==0) && (promo_item_id==0) && (discount_of_max_amount==0)){
						var seprate_promo=parseFloat((taxable_value_after_dis/appliacble_taxable_total)*promo_amount);
						if(!seprate_promo){ seprate_promo=0; }
						var main_seprate_promo=round(seprate_promo,2);
						var apply_get_txbl=$(this).find('.txbal').val();
						$(this).find('.promo_amount').val(main_seprate_promo);
						$(this).find('.promo_percent').val(0);
						taxable_value_after_dis=taxable_value_after_dis-main_seprate_promo;
							}
							else{
								//alert('Promo is not Valid try Another');
								//$('.promo').val('');
								//calculation();
							}
						}
						 
						else{
							
							if((promo_category_id>0) && (promo_category_id==item_category_id) && (promo_item_id==0) && (discount_of_max_amount==0)){
							
							promo_seprate_amount=parseFloat((taxable_value_after_dis*promo_percent/100));
							$(this).find('.promo_amount').val(promo_seprate_amount);
							taxable_value_after_dis=taxable_value_after_dis-promo_seprate_amount;
							$(this).find('.promo_percent').val(promo_percent);
							
							}
							else if((promo_item_id>0) && (promo_item_id==item_id) && (discount_of_max_amount==0)){
							
							promo_seprate_amount=parseFloat((taxable_value_after_dis*promo_percent/100));
							$(this).find('.promo_amount').val(promo_seprate_amount);
							taxable_value_after_dis=taxable_value_after_dis-promo_seprate_amount;
							$(this).find('.promo_percent').val(promo_percent);
							
							}
							else if((discount_of_max_amount>0) && (promo_item_id==0) && (promo_category_id==0)){
								if(discount_of_max_amount<=appliacble_taxable_total){
								promo_seprate_amount=parseFloat((taxable_value_after_dis*promo_percent/100));
								$(this).find('.promo_amount').val(promo_seprate_amount);
								taxable_value_after_dis=taxable_value_after_dis-promo_seprate_amount;
								$(this).find('.promo_percent').val(promo_percent);
								}
								else{
									
									alert('Promo Code is not Applicable');
									$('.promo').val('');
									calculation();
								}
							}
							else if((promo_category_id==0) && (promo_item_id==0) && (discount_of_max_amount==0)){
							
							promo_seprate_amount=parseFloat((taxable_value_after_dis*promo_percent/100));
							$(this).find('.promo_amount').val(promo_seprate_amount);
							taxable_value_after_dis=taxable_value_after_dis-promo_seprate_amount;
							$(this).find('.promo_percent').val(promo_percent);
							}
						}
						
					}
				
				
					var taxable_value=round(taxable_value_after_dis,2);
					
					
					$(this).find('.net_amount1').val(taxable_value);
					$(this).find('.net_amount').val(taxable_value);
					 var gst_percentage=parseFloat($(this).find('.gst_percentage').val()); 
					if(!gst_percentage){ gst_percentage=0; }
					
					if(!gst_percentage){
						gst_rate=0;
						
					}else{
						gst_rate=round(round(taxable_value*gst_percentage)/100,2);
					}
					
				 
					var f_gst_rate1=parseFloat(taxable_value*gst_percentage);
					
					var f_gst_rate2=parseFloat(100+gst_percentage);
					var d_gst_dis=round(f_gst_rate1/f_gst_rate2, 2);
					var m_gst_dis=round(d_gst_dis/2, 2);
					var f_gst_dis=(m_gst_dis*2);
					var f_taxable=round(taxable_value-f_gst_dis, 2);
					$(this).find('.gst_value').val(f_gst_dis); 
					$(this).find('.taxable_value1').val(f_taxable); 
					$(this).find('.taxable_value').val(f_taxable);
					total_gst=total_gst+f_gst_dis;
					$(this).find('.gst_value').val(f_gst_dis);
					var net_amount=f_gst_dis+f_taxable;
					var net_amounts1=$(this).find('.net_amount').val();
					
					 total_taxable_value=total_taxable_value+f_taxable;
					//total_gst=total_gst+f_gst_dis;
					total_amount=total_amount+net_amounts1;
					var per_item_purchase_rate=net_amounts1/qty;
					$(this).find('.purchase_rate').val(per_item_purchase_rate);
					var commission_rate=(per_item_purchase_rate*commission)/100;
					var per_item_sales_rate=round(per_item_purchase_rate+commission_rate,2);
					$(this).find('.sales_rate').val(per_item_sales_rate);
					$(this).find('.mrp').val(per_item_sales_rate);  
			
					$('.total_taxable_value').val(round(total_taxable_value,2));
					$('.gst_amt').val(round(total_gst,2));  
				 
				 var main_discount_amount=$(this).find('.discount_amount').val();
				 if(!main_discount_amount){ main_discount_amount=0; }
				 
				 var main_promo_amount=$(this).find('.promo_amount').val();
				 if(!main_promo_amount){ main_promo_amount=0; }
				 
				 var final_main_discount_amount=parseFloat(main_discount_amount)+parseFloat(main_promo_amount);
				total_discount+=parseFloat(final_main_discount_amount);
				before_discount_all+=parseFloat(before_discount);
			});
			
				 
				$('.dis_amnt').val(total_discount);
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
				
				var free_shipping=$('.promo').find('option:selected').attr('free_shipping');
				if(free_shipping=='Yes'){
					delivery_chrg=0;
				}
				
				$('.dlvry_chrgs').val(delivery_chrg);
				
				var grand_total=parseFloat(final_amount)+parseFloat(delivery_chrg);
				if(!grand_total){ grand_total=0; }
				var wlt_amount=$('.wlt_amt').val();
				if(!wlt_amount){ wlt_amount=0; }
				var dummy_grand_amount=round(grand_total,2);
				var fianl_grand_amount=round(grand_total);
				var round_off_difference=0;
				if(dummy_grand_amount!=fianl_grand_amount){
					round_off_difference=parseFloat(fianl_grand_amount-dummy_grand_amount);
				}
				
				var due_amount=parseFloat(fianl_grand_amount)-parseFloat(wlt_amount);
				 //alert(grand_total);
				$('.before_discount').val(round(before_discount_all,2));
				$('.total_amt').val(fianl_grand_amount);
				$('.round_off').val(round(round_off_difference,2));
				$('.due_amt').val(round(due_amount));

				var cash_back=$('.promo').find('option:selected').attr('cash_back');
				if(!cash_back){ cash_back=0; }
				var discount_of_max_amount=parseFloat($('.promo').find('option:selected').attr('discount_of_max_amount'));
				if(!discount_of_max_amount){ discount_of_max_amount=0; }
				
				if((cash_back>0)){
				var chk_grnd_amnt=parseFloat($('.total_amt').val());
					if(chk_grnd_amnt>=discount_of_max_amount){
						alert('Applied Promo');
					}else{
						alert('Your Amount Value is Only '+chk_grnd_amnt+' And Require '+discount_of_max_amount+' Amount value to apply this Promo, Please Purchase More then Apply Again');
						$('.promo').val('');
						calculation();
					}
				}
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
			var tot_txbl=0;
			
			$('.main_table tbody tr').each(function(){
					var qty=$(this).find('.quantity').val();
					var rate=$(this).find('.rate').val();
					var discount_percent=$(this).find('.discount_percent').val();
					//alert(discount_percent);
					var quantity_factor=$(this).find('option:selected', this).attr('quantity_factor');
					var commission=$(this).find('option:selected', this).attr('commission');
					var unit=$(this).find('option:selected', this).attr('unit');
					var item_id=$(this).find('option:selected', this).attr('item_id');
					$(this).find('.item_id').val(item_id);
					var total_qty=quantity_factor*qty;
					$(this).find('.itemQty').html(total_qty +' '+ unit);
					var taxable_value_before_dis=qty*rate;
					var taxable_value_after_dis=qty*rate;
					$(this).closest('tr').find('.amount').val(taxable_value_before_dis);
					if(discount_percent){
						var dis=round(round(taxable_value_before_dis*discount_percent)/100,2);
						var taxable_value_after_dis=taxable_value_before_dis-dis;
						$(this).find('.discount_amount').val(round(dis,2));
					}
					
					$(this).find('.txbal').val(taxable_value_after_dis);
					var promo_amount=$('.promo').find('option:selected').attr('discount_amount');
					if(!promo_amount){ promo_amount=0; }
					var promo_percent=$('.promo').find('option:selected').attr('discount_percent');
					if(!promo_percent){ promo_percent=0; }
					 
					var applicable=$(this).closest('tr').find('.discount_percent').attr('applicable');
					if(applicable=='Yes'){
						
						var apply_get_txbl=$(this).find('.txbal').val();
						tot_txbl+=parseFloat(apply_get_txbl);                
						$(this).find('.promo_amount').val(promo_amount);
						$(this).find('.promo_percent').val(promo_percent);
						taxable_value_after_dis=taxable_value_after_dis-promo_amount;
						
					}
					  var taxable_value=taxable_value_after_dis;
					/* 
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
					$('.gst_amt').val(round(total_gst,2)); */
				  
				
			});
				$('.appliacble_taxable_total').val(tot_txbl);
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
				calculation1();
		}
		
		
		
		function calculation1(){
			var total_amount=0;
			var total_gst=0;
			var total_taxable_value=0;
			var total_discount=0;
			$('.main_table tbody tr').each(function(){
				 
					var qty=$(this).find('.quantity').val();
					var rate=$(this).find('.rate').val();
					var discount_percent=$(this).find('.discount_percent').val();
					//alert(discount_percent);
					var quantity_factor=$(this).find('option:selected', this).attr('quantity_factor');
					var commission=$(this).find('option:selected', this).attr('commission');
					var unit=$(this).find('option:selected', this).attr('unit');
					var item_id=$(this).find('option:selected', this).attr('item_id');
					$(this).find('.item_id').val(item_id);
					
					var taxable_value_after_dis=parseFloat($(this).find('.txbal').val());
					var appliacble_taxable_total =parseFloat($('.appliacble_taxable_total').val());
					if(!appliacble_taxable_total){ appliacble_taxable_total=0; }
					var promo_amount=$('.promo').find('option:selected').attr('discount_amount');
					if(!promo_amount){ promo_amount=0; }
					var promo_percent=$('.promo').find('option:selected').attr('discount_percent');
					if(!promo_percent){ promo_percent=0; }
					 
					var applicable=$(this).closest('tr').find('.discount_percent').attr('applicable');
					if(applicable=='Yes'){
						
						if(promo_percent==0){
						var seprate_promo=parseFloat((taxable_value_after_dis/appliacble_taxable_total)*promo_amount);
						if(!seprate_promo){ seprate_promo=0; }
						var apply_get_txbl=$(this).find('.txbal').val();
						$(this).find('.promo_amount').val(seprate_promo);
						taxable_value_after_dis=taxable_value_after_dis-seprate_promo;
						}
						else{
							promo_seprate_amount=parseFloat((taxable_value_after_dis*promo_percent/100));
							$(this).find('.promo_amount').val(promo_seprate_amount);
							taxable_value_after_dis=taxable_value_after_dis-promo_seprate_amount;
						}
						
					}
				
				
					var taxable_value=round(taxable_value_after_dis,2);
					
					$(this).find('.taxable_value').val(taxable_value);
					 var gst_percentage=parseFloat($(this).find('.gst_percentage').val()); 
					if(!gst_percentage){ gst_percentage=0; }
					
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
				 
				 var main_discount_amount=$(this).find('.discount_amount').val();
				 if(!main_discount_amount){ main_discount_amount=0; }
				 
				 var main_promo_amount=$(this).find('.promo_amount').val();
				 if(!main_promo_amount){ main_promo_amount=0; }
				 
				 var final_main_discount_amount=parseFloat(main_discount_amount)+parseFloat(main_promo_amount);
				total_discount+=parseFloat(final_main_discount_amount);
			});
			
				$('.dis_amnt').val(total_discount);
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
}
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>