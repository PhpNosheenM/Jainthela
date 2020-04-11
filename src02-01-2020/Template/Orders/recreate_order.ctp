<?php $this->set('title', 'Order'); ?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
		<?= $this->Form->create($order,['id'=>'jvalidate','class'=>'form-horizontal','type'=>'file']) ?>  
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Create Order </strong></h3>
				</div>
			<?php //pr($sales_orders->customer_id); ?>
				<div class="panel-body">
					<div class="row">
						<center><h3>Order Details</h3></center>
						<hr>
						<div class="col-md-3">
							<div class="form-group">
								<label class=" control-label">Order No</label>
								<div class="">
									<?= $this->Form->control('order_no',['class'=>'form-control','placeholder'=>'','label'=>false,'value'=>$Orders->order_no,'readonly']) ?>
								</div>
							</div>
							<div class="form-group">
								<label class=" control-label">Customer</label>
								<div class="">  
									
										<?= $this->Form->select('customer_id',$partyOptions,['empty'=>'---Select--','class'=>'form-control select prty_ldgr','label'=>false,'data-live-search'=>true,'value'=>'']) ?>
										<input type="hidden" name="customer_address_id" id="customer_address_id">
									
								</div>
							</div>
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
									<?= $this->Form->select('sales_ledger_id',$Accountledgers,['class'=>'form-control select','label'=>false, 'value'=>@$sales_ledger_id,'data-live-search'=>true]) ?>
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
						<center><h3>Order Item Details</h3></center>
							<hr>
							<table class="table table-bordered main_table">
								<thead>
									<tr align="center">
										<th rowspan="2" style="text-align:left;width:5px;"><label>S.N<label></th>
										<th rowspan="2" style="text-align:left;width:400px;"><label>Item Variations<label></th>
										<th rowspan="2" style="text-align:center;width:130px; "><label>Quantity<label></th>
										<th rowspan="2" style="text-align:center;width:150px;"><label>Rate<label></th>
										<th rowspan="2" style="text-align:center;width:130px;"><label id="Discount">Amount<label></th>
										<th rowspan="2" style="text-align:center;width:130px;"><label id="Discount">Discount<label></th>
										<th rowspan="2" style="text-align:center;"><label>Taxable Value<label></th>
										<th rowspan="2" style="text-align:center;width:200px;"><label>Total<label></th>
										<th rowspan="2" style="text-align:center;"><label>Action<label></th>
									</tr>
									
								</thead>
								<tbody class="MainTbody">  
								<?php  if(!empty($Orders)){ 
								//pr($sales_orders->sales_order_rows);
										foreach($Orders->order_details as $sales_order_row){
											//pr($sales_order_row);
											@$g++;
								?>
									<tr class="MainTr">
										<td  valign="top">
											<?php echo $g; ?>
										</td>
										<td  valign="top" class="itemList">
											<?= $this->Form->select('item_variation_id',$items,['empty'=>'--select--','style'=>'','class'=>'form-control item','label'=>false,'readonly', 'value'=>$sales_order_row->item_variation_id]) ?>
											<?= $this->Form->control('item_id',['type'=>'hidden','class'=>'form-control item_id','label'=>false,'readonly', 'value'=>$sales_order_row->item_id]) ?>
											
										</td>
										
										<td  valign="top">
											<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false, 'value'=>$sales_order_row->quantity]) ?>
											
										</td>
										<td valign="top">
											<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false, 'value'=>$sales_order_row->rate]) ?>
											<?= $this->Form->control('original_rate',['type'=>'hidden','class'=>'form-control original_rate','label'=>false,'value'=>$sales_order_row->rate]) ?>
										</td>
										<td valign="top">
											<?= $this->Form->control('amount',['class'=>'form-control amount','label'=>false, 'value'=>$sales_order_row->amount]) ?>
										
											<?= $this->Form->control('discount_percent',['type'=>'hidden','class'=>'form-control discount_percent','label'=>false, 'value'=>$sales_order_row->discount_percent]) ?>
											
											<?= $this->Form->control('txbal',['type'=>'hidden','class'=>'form-control txbal','label'=>false]) ?>
											<?= $this->Form->control('promo_percent',['type'=>'hidden','class'=>'form-control promo_percent','label'=>false, 'value'=>$sales_order_row->promo_percent]) ?>
											<?= $this->Form->control('promo_amount',['type'=>'hidden','class'=>'form-control promo_amount','label'=>false,'readonly', 'value'=>$sales_order_row->promo_amount]) ?>
										</td>
										<td>
										<?= $this->Form->control('discount_amount',['class'=>'form-control discount_amount','label'=>false,'readonly']) ?>
										</td>
										<td valign="top">
											<?= $this->Form->control('taxable_value',['class'=>'form-control taxable_value','label'=>false,'readonly', 'value'=>$sales_order_row->taxable_value]) ?>
											<?= $this->Form->control('taxable_value1',['type'=>'hidden','class'=>'form-control taxable_value1','label'=>false,'readonly', 'value'=>$sales_order_row->amount]) ?>
											<?= $this->Form->control('gst_percentage',['type'=>'hidden','class'=>'form-control gst_percentage','label'=>false,'readonly', 'value'=>$sales_order_row->gst_percentage]) ?>
											<?= $this->Form->control('gst_figure_id',['type'=>'hidden','type'=>'hidden','class'=>'form-control gst_figure_id','label'=>false,'readonly', 'value'=>$sales_order_row->gst_figure_id]) ?>
											<span class="gstAmt" style=" text-align:left;font-size:13px;"></span>
											<?= $this->Form->control('gst_value',['type'=>'hidden','class'=>'form-control gst_value','label'=>false,'readonly', 'value'=>$sales_order_row->gst_value]) ?>
										</td>
										
										<td valign="top">
											<?= $this->Form->control('net_amount',['class'=>'form-control net_amount','label'=>false,'readonly','value'=>$sales_order_row->net_amount]) ?>
											<?= $this->Form->control('net_amount1',['type'=>'hidden','class'=>'form-control net_amount1','label'=>false,'readonly']) ?>
										</td>
										
										<td valign="top"  >
											<a class="btn btn-primary  btn-condensed btn-sm add_row" role="button" ><i class="fa fa-plus"></i></a>
											<a class="btn btn-danger  btn-condensed btn-sm delete_row " role="button" ><i class="fa fa-times"></i></a>
										</td>
									</tr>
								
								<?php } } ?>	
								
								<?php if(!empty($CancelItemOrder)){  
									foreach($CancelItemOrder->order_details as $sales_order_row){
											@$g++;
								?>
									<tr class="MainTr">
										<td  valign="top">
											<?php echo $g; ?>
										</td>
										<td  valign="top" class="itemList">
											<?= $this->Form->select('item_variation_id',$items,['empty'=>'--select--','style'=>'','class'=>'form-control item itemSel','label'=>false,'readonly', 'value'=>$sales_order_row->item_variation_id]) ?>
											<?= $this->Form->control('item_id',['type'=>'hidden','class'=>'form-control item_id','label'=>false,'readonly', 'value'=>$sales_order_row->item_id]) ?>
											
										</td>
										
										<td  valign="top">
											<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false, 'value'=>$sales_order_row->quantity]) ?>
											
										</td>
										<td valign="top">
											<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false, 'value'=>$sales_order_row->rate]) ?>
										</td>
										<td valign="top">
											<?= $this->Form->control('amount',['class'=>'form-control amount','label'=>false, 'value'=>$sales_order_row->amount]) ?>
										
											<?= $this->Form->control('discount_percent',['type'=>'hidden','class'=>'form-control discount_percent','label'=>false, 'value'=>$sales_order_row->discount_percent]) ?>
											<?= $this->Form->control('discount_amount',['type'=>'hidden','class'=>'form-control discount_amount','label'=>false,'readonly',]) ?>
											<?= $this->Form->control('txbal',['type'=>'hidden','class'=>'form-control txbal','label'=>false]) ?>
											
										</td>
										
										<td valign="top">
											<?= $this->Form->control('taxable_value',['class'=>'form-control taxable_value','label'=>false,'readonly', 'value'=>$sales_order_row->taxable_value]) ?>
											<?= $this->Form->control('taxable_value1',['type'=>'hidden','class'=>'form-control taxable_value1','label'=>false,'readonly', 'value'=>$sales_order_row->amount]) ?>
											<?= $this->Form->control('gst_percentage',['type'=>'hidden','class'=>'form-control gst_percentage','label'=>false,'readonly', 'value'=>$sales_order_row->gst_percentage]) ?>
											<?= $this->Form->control('gst_figure_id',['type'=>'hidden','type'=>'hidden','class'=>'form-control gst_figure_id','label'=>false,'readonly', 'value'=>$sales_order_row->gst_figure_id]) ?>
											<span class="gstAmt" style=" text-align:left;font-size:13px;"></span>
											<?= $this->Form->control('gst_value',['type'=>'hidden','class'=>'form-control gst_value','label'=>false,'readonly', 'value'=>$sales_order_row->gst_value]) ?>
										</td>
										
										<td valign="top">
											<?= $this->Form->control('net_amount',['class'=>'form-control net_amount','label'=>false,'readonly','value'=>$sales_order_row->net_amount]) ?>
											<?= $this->Form->control('net_amount1',['type'=>'hidden','class'=>'form-control net_amount1','label'=>false,'readonly']) ?>
										</td>
										<?php
											@$sales_orders->grand_total+=$sales_order_row->net_amount;
											@$sales_orders->total_amount+=$sales_order_row->taxable_value;
											@$sales_orders->total_gst+=$sales_order_row->gst_value;
										?>
										<td valign="top"  >
											<!--<a class="btn btn-primary  btn-condensed btn-sm add_row" role="button" ><i class="fa fa-plus"></i></a>
											<a class="btn btn-danger  btn-condensed btn-sm delete_row " role="button" ><i class="fa fa-times"></i></a>-->
										</td>
									</tr>
								
								<?php } } ?>	
								</tbody>
								<tfoot>
									<tr>
										<td colspan="7" style="text-align:right;">
											<b>Delivery charge</b>
										</td>
										<td colspan="2" style="text-align:right;">
										<?= $this->Form->control('delivery_charge_amount',['class'=>'form-control delivery_charge','label'=>false,'total_delivery_charge'=>@$deliveryCharges->charge,'total_delivery_amount'=>@$deliveryCharges->amount,'value'=>@$deliveryCharges->charge]) ?>
										</td>
									</tr>
									<tr>
										<td colspan="7" style="text-align:right;">
											<b>Total Amount</b>
										</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('grand_total',['type'=>'hidden','class'=>'form-control grand_total','label'=>false,'readonly','value'=>@$sales_orders->grand_total]) ?>
											<?= $this->Form->control('pay_amount',['type'=>'hidden','class'=>'form-control pay_amount','label'=>false,'readonly','value'=>@$sales_orders->pay_amount]) ?>
											
											<?= $this->Form->control('show_amount',['type'=>'text','class'=>'form-control pay_amount','label'=>false,'readonly']) ?>
											
											<?= $this->Form->control('total_gst',['type'=>'hidden','class'=>'form-control gst_amt','label'=>false,'readonly','value'=>@$sales_orders->total_gst]) ?>
											<?= $this->Form->control('total_amount',['type'=>'hidden','class'=>'form-control total_taxable_value','label'=>false,'readonly','value'=>@$sales_orders->total_amount]) ?>
											<?= $this->Form->control('discount_amount',['type'=>'hidden','class'=>'form-control dis_amnt','label'=>false,'value'=>0]) ?>
											<?= $this->Form->control('txbal',['type'=>'hidden','class'=>'form-control txbal','label'=>false]) ?>
											<?= $this->Form->control('before_discount',['type'=>'hidden','class'=>'form-control before_discount','label'=>false,'readonly','value'=>@$sales_orders->total_amount]) ?>
										</td>
									</tr>
									
								</tfoot>
							</table>
							<div class="form-group col-md-12">
								<div id="promos"></div>
							</div>
							
							<div><input type="text" class="appliacble_taxable_total" name="appliacble_taxable_total" style="display:none;"></div>
							
							<center><h3>Order Transaction Details</h3></center>
								<hr>
								<table width="100%" style="font-size:14px;">
									 
									 <tr>
										 
										<td style="padding-left:40px !important;">
											<?php /*
											$order_type['Credit'] = 'Credit'; 
											$order_type['Wallet'] = 'Wallet'; 
											$order_type['COD'] = 'COD';
											  $this->Form->select('order_type',$order_type,['class'=>'form-control select odr_typ','label'=>false,'required']) 
											  */
											  ?>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<div class="col-md-3">
													<label class="check">
														Order Type
													</label>
												</div>	
												<div class="col-md-3">
													<label class="check">
														<input type="radio" class="iradio" name="order_type"  value="Credit" /> Credit</label>
												</div>
												<div class="col-md-3">
													<label class="check">
														<input type="radio" class="iradio" name="order_type" checked="checked" value="COD" />COD</label>
												</div>
												
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
			<td width="60%">
				<div class="form-group col-md-8">
					 <label class=" control-label">Combo Offer</label>
					 <?= $this->Form->select('combo_id',$combos,['empty'=>'---select--combo---','style'=>'','class'=>'form-control combo select','label'=>false,'data-live-search'=>true]) ?>
				</div>
			</td>
			<td width="20%">
				<div class="form-group col-md-4">
					 <label class=" control-label">Quantity</label>
					 <?= $this->Form->input('combo_quantity',['style'=>'','class'=>'form-control combo_qty','label'=>false,'value'=>1]) ?>
				</div>
			</td>
			<td align="left" width="10%">
				<div class="form-group col-md-2">
					<a style="margin-top:40px;" class="btn btn-primary btn-condensed btn-sm add_combo" role="button" ><i class="fa fa-plus"></i></a>
				</div>	
			</td>
			<td align="left" width="10%">
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
				<?= $this->Form->select('item_variation_id',$items,['empty'=>'--select--','style'=>'','class'=>'form-control item itemSel','label'=>false,'readonly','data-live-search'=>true]) ?>
				<?= $this->Form->control('item_id',['type'=>'hidden','class'=>'form-control item_id','label'=>false,'readonly']) ?>
				
			</td>
			
			<td  valign="top">
				<?= $this->Form->control('quantity',['class'=>'form-control quantity','label'=>false]) ?>
				
			</td>
			<td valign="top">
				
				<?= $this->Form->control('rate',['class'=>'form-control rate','label'=>false]) ?>
				<?= $this->Form->control('original_rate',['type'=>'hidden','readonly','class'=>'form-control original_rate','label'=>false]) ?>
			</td>
			<td valign="top">
				<?= $this->Form->control('amount',['class'=>'form-control amount','label'=>false]) ?>
				
			
				<?= $this->Form->control('discount_percent',['type'=>'hidden','class'=>'form-control discount_percent','label'=>false]) ?>
				
				<?= $this->Form->control('txbal',['type'=>'hidden','class'=>'form-control txbal','label'=>false]) ?>
			
			</td>
			<td>
			<?= $this->Form->control('discount_amount',['class'=>'form-control discount_amount','label'=>false,'readonly']) ?>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('taxable_value',['class'=>'form-control taxable_value','label'=>false,'readonly']) ?>
				<?= $this->Form->control('taxable_value1',['type'=>'hidden','class'=>'form-control taxable_value1','label'=>false,'readonly']) ?>
			
				<?= $this->Form->control('gst_percentage',['type'=>'hidden','class'=>'form-control gst_percentage','label'=>false,'readonly']) ?>
				<?= $this->Form->control('gst_figure_id',['type'=>'hidden','type'=>'hidden','class'=>'form-control gst_figure_id','label'=>false,'readonly']) ?>
				<?= $this->Form->control('gst_value',['type'=>'hidden','class'=>'form-control gst_value','label'=>false,'readonly']) ?>
				<span class="gstAmt" style=" text-align:left;font-size:13px;"></span>
			</td>
			
			<td valign="top">
				<?= $this->Form->control('net_amount',['class'=>'form-control net_amount','label'=>false,'readonly']) ?>
				<?= $this->Form->control('net_amount1',['type'=>'hidden','class'=>'form-control net_amount1','label'=>false,'readonly']) ?>
			</td>
			
			<td valign="top" width="10%" >
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
if(empty($ids) && empty($CancelItemOrder)){
   $js="var jvalidate = $('#jvalidate').validate({
		ignore: [],
		rules: {                                            
				customer_id: {
						required: true,
				},
				sales_ledger_id: {
						required: true,
				},
				delivery_charge_amount: {
						required: true,
				},
				
			}
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
					//$('#promos').html(response);
				});
				calculation();
		});
		
		$(document).on('change','.itemSel',function(){
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
			var mpq=$(this).find('option:selected', this).attr('maximum_quantity_purchase');  
			$(this).closest('tr').find('.item_id').val(item_id);
			$(this).closest('tr').find('.gst_percentage').val(gst_value);
			$(this).closest('tr').find('.gst_figure_id').val(gst_figure_id);
			$(this).closest('tr').find('.rate').val(sale_rate);
			$(this).closest('tr').find('.original_rate').val(sale_rate);
			var final_stock=parseFloat(current_stock)+parseFloat(virtual_stock)-parseFloat(demand_stock);
			
			//alert(final_stock);
			var put_stock=0;
			if(final_stock>mpq){
				put_stock=final_stock;
			}else{
				put_stock=mpq;
			}
			//alert(put_stock);
			$(this).closest('tr').find('.quantity').attr('max',put_stock);
			calculation();
			
		});
		
		
		$(document).on('click','.add_row',function(){ 
			addMainRow();
		});
		
		function addMainRow(){ 
			var tr=$('#sampleTable tbody').html();
			$('.main_table tbody').append(tr);
			renameRows();
		}
		
		
		
		$(document).on('keyup','.rate',function(){
			var salrate=$(this).val();
			$(this).closest('tr').find('.original_rate').val(salrate);
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
		$(document).on('keyup','.delivery_charge',function(){
			calculation();
		});
		
		$(document).on('change','.gst_percentage',function(){
			calculation();
		});
		
		
		$(document).on('click','.delete_row',function(){ 
			var t=$(this).closest('tr').remove();
			renameRows();
			calculation();
		});
		
		renameRows();
		function renameRows(){  
			var i=0; 
			$('.main_table tbody tr').each(function(){
				$(this).attr('row_no',i);
				
				$(this).find('td:nth-child(1)').html(++i); i--;
				$(this).find('input.item_id ').attr({name:'order_details['+i+'][item_id]',id:'order_details['+i+'][item_id]'})
				$(this).find('.item').selectpicker();
				$(this).find('select.item ').attr({name:'order_details['+i+'][item_variation_id]',id:'order_details['+i+'][item_variation_id]'}).rules('add', 'required');
				$(this).find('.quantity ').attr({name:'order_details['+i+'][quantity]',id:'order_details['+i+'][quantity]'}).rules('add', 'required');
				$(this).find('.rate ').attr({name:'order_details['+i+'][rate]',id:'order_details['+i+'][rate]'}).rules('add', 'required');
				$(this).find('.original_rate ').attr({name:'order_details['+i+'][original_rate]',id:'order_details['+i+'][original_rate]'});
				$(this).find('.amount ').attr({name:'order_details['+i+'][amount]',id:'order_details['+i+'][amount]'}).rules('add', 'required');
				$(this).find('.discount_percent ').attr({name:'order_details['+i+'][discount_percent]',id:'order_details['+i+'][discount_percent]'});
				$(this).find('.discount_amount ').attr({name:'order_details['+i+'][discount_amount]',id:'order_details['+i+'][discount_amount]'});
				$(this).find('.txbal ').attr({name:'order_details['+i+'][txbal]',id:'order_details['+i+'][txbal]'});
				
				$(this).find('.taxable_value ').attr({name:'order_details['+i+'][taxable_value]',id:'order_details['+i+'][taxable_value]'});
				$(this).find('.taxable_value1 ').attr({name:'order_details['+i+'][taxable_value1]',id:'order_details['+i+'][taxable_value1]'});
				$(this).find('.gst_percentage ').attr({name:'order_details['+i+'][gst_percentage]',id:'order_details['+i+'][gst_percentage]'});
				$(this).find('.gst_figure_id ').attr({name:'order_details['+i+'][gst_figure_id]',id:'order_details['+i+'][gst_figure_id]'});
				$(this).find('.gst_value ').attr({name:'order_details['+i+'][gst_value]',id:'order_details['+i+'][gst_value]'});
				$(this).find('.net_amount ').attr({name:'order_details['+i+'][net_amount]',id:'order_details['+i+'][net_amount]'});
				$(this).find('.net_amount1 ').attr({name:'order_details['+i+'][net_amount1]',id:'order_details['+i+'][net_amount1]'});
				i++;
				
			});  
			calculation();
		}
		
		function calculation(){
			var total_amount=0;
			var total_gst=0;
			var total_taxable_value=0;
			var tot_txbl=0;
			var tot_discount_amount=0;
			 
			$('.main_table tbody tr').each(function(){ 
				
					var discount_applicable=$(this).find('option:selected', this).attr('discount_applicable');
					var member_dis=$('.prty_ldgr').find('option:selected').attr('membership_discount');
					$(this).closest('tr').find('.discount_percent').val(member_dis);
					//var original_rate=$(this).find('.original_rate').val();
					var rate=$(this).find('.rate').val();
					
					//$(this).closest('tr').find('.rate').val(original_rate);
					var qty=$(this).find('.quantity').val();
					var gst_percentage=parseFloat($(this).find('.gst_percentage').val()); 
					
					var original_amount=qty*rate;
					var actual_amount=qty*rate;
					
					if(discount_applicable=='No'){
						$(this).closest('tr').find('.discount_percent').val(0);
						$(this).closest('tr').find('.discount_amount').val(0);
						$(this).closest('tr').find('.discount_percent').attr('applicable','No');
						var original_amount=original_amount;
					}else{
						$(this).closest('tr').find('.discount_percent').attr('applicable','Yes');
						
						var dis=member_dis*original_amount/100;
						tot_discount_amount=tot_discount_amount+dis; 
						$(this).closest('tr').find('.discount_percent').val(round(member_dis,2));
						//alert(tot_discount_amount);
						$(this).closest('tr').find('.discount_amount').val(round(dis,2));
						//alert(tot_discount_amount);
						var original_amount=original_amount-dis;
						
					}
					
					var taxable_value=original_amount;
					
					$(this).find('.amount').val(round(actual_amount,2));
					if(!gst_percentage){ 
						gst_rate=0;
					}else{ 
						var x=100+gst_percentage;
						gst_rate=(round(((taxable_value*gst_percentage)/x),2));
						
						gst_rate1=round((gst_rate/2),2);
						gst_rate=round((gst_rate1*2),2);
					} 
					
					taxable_value=taxable_value-gst_rate;
					//$(this).find('.taxable_value').val(taxable_value,2);
					$(this).find('.taxable_value').val(round(taxable_value,2));
					$(this).find('.gst_value').val(gst_rate);
					var net_amount=gst_rate+taxable_value;
					var net_amount1=round(net_amount,2);
					$(this).find('.net_amount').val(round(net_amount,2));
					//$(this).find('.net_amount').val(net_amount);
					total_gst=total_gst+gst_rate;
					total_amount=total_amount+net_amount1;
					total_taxable_value=total_taxable_value+taxable_value;
					
				});	
				
				$('.dis_amnt').val(round(tot_discount_amount,2));
				$('.gst_amt').val(round(total_gst,2));
				$('.total_taxable_value').val(round(total_taxable_value,2));
				var charge=parseFloat($('.delivery_charge').val());
				//var deliveryamount=parseFloat($('.delivery_charge').attr('total_delivery_amount'));
				//alert(charge);
				//alert(deliveryamount);
				total_amount=total_amount+charge;
				$('.grand_total').val(round(total_amount,2));
				/* if(total_amount < deliveryamount){
					total_amount=total_amount+charge;
					$('.delivery_charge').val(charge);
				}else{
					$('.delivery_charge').val(0);
					total_amount=total_amount;
				} */
				
				
				$('.pay_amount').val(round(total_amount,2));
				//$('.pay_amount').val('asdsfsdfs');
				
				
		}
		
				
		
		
		
	 
		";  

}
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
