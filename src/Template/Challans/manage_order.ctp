<?php $url_excel="/?".urldecode($urll); ?>

<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Generate Bill');     ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Challans  </strong></h3>
					<div class="pull-right">
					<?php 
					
					if($status=='delivered'){
						$class1="btn btn-default";
						$class2="btn btn-default";
						$class3="btn btn-xs blue";
						$class4="btn btn-default";
						
					}else if($status=='cancel'){
						$class1="btn btn-default";
						$class2="btn btn-xs blue";
						$class3="btn btn-default";
						$class4="btn btn-default";
					}else if($status=='return'){
						$class1="btn btn-default";
						$class2="btn btn-default";
						$class3="btn btn-default";
						$class4="btn btn-xs blue";
					}else{
						$class1="btn btn-xs blue";
						$class2="btn btn-default";
						$class3="btn btn-default";
						$class4="btn btn-default";
					}
					 ?>
						
						<?php echo $this->Html->link('Pending',['controller'=>'Challans','action' => 'manage_order?status=pending'],['escape'=>false,'class'=>$class1]); ?>&nbsp;
						<?php echo $this->Html->link('Delivered',['controller'=>'Challans','action' => 'manage_order?status=Delivered'],['escape'=>false,'class'=>$class3]); ?>&nbsp;
						<?php echo $this->Html->link('Cancel',['controller'=>'Challans','action' => 'manage_order?status=cancel'],['escape'=>false,'class'=>$class2]); ?>&nbsp;
						<?php echo $this->Html->link('Returned',['controller'=>'Challans','action' => 'manage_order?status=return'],['escape'=>false,'class'=>$class4]); ?>&nbsp;
						<div class="pull-left">
							
							<?php //echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Export To Excel', '/Orders/PurchaseExcel/',['class' =>'btn btn-sm green tooltips pull-right','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>
							
							<?php echo $this->Html->link('Export To Excel',['controller'=>'Challans','action' => 'ManageOrderExcel'.@$url_excel.''],['style'=>'background:green;color:white','escape'=>false,'class'=>'btn btn-default backbutton','target'=>'_blank','escape'=>false]); ?>
						</div> 
						
				</div> 
				<div class="pull-right">
					<div class="pull-left">
						<?= $this->Form->create('Search',['type'=>'GET']) ?>
						
						<div class="col-md-4 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> FROM </span>
										<?= $this->Form->control('from_date',['class'=>'form-control datepicker','placeholder'=>'From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($from_date))]) ?>
										<span class="input-group-addon add-on"> TO </span>
										<?= $this->Form->control('to_date',['class'=>'form-control datepicker','placeholder'=>'To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($to_date))]) ?>
										</div>
								</div>
						
							<div class="form-group" style="display:inline-table">
								<div class="input-group">
									<div class="input-group-addon">
										<span class="fa fa-search"></span>
									</div>
									<input type="hidden" name="status" value="<?php echo @$status; ?>">
									<?= $this->Form->control('search',['class'=>'form-control','placeholder'=>'Search...','label'=>false]) ?>
									<div class="input-group-btn">
										<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary']) ?>
									</div>
								</div>
							</div>
						<?= $this->Form->end() ?>
					</div> 
				</div> 				
				</div>
				<div class="panel-body">    
					<div class="table">
						<table class="table-bordered" width="100%">
							<thead>
								<tr height="40px">
									<th><?= ('SNo.') ?></th>
									<?php if($user_type != "Seller"){ ?>
									<th><?= ('Order No') ?></th>
									<?php } ?>
									<th><?= ('Challan No') ?></th>
									<th><?= ('Challan From') ?></th>
									<th><?= ('Customer Name') ?></th>
									<th><?= ('Locality') ?></th>
                                    
                                     <th><?= ('Route') ?></th>
									<th><?= ('Grand Total') ?></th>
									<th><?= ('Order Type') ?></th>
									<th><?= ('Order Date') ?></th>
									<?php if($status=="delivered"){ ?>
									<th><?= ('Paid Amount') ?></th>
									<th><?= ('Pay Mode') ?></th>
									<th><?= ('Pay Amount') ?></th>
									<?php } ?>
									<th><?= ('Status') ?></th>
									<?php if($user_type != "Seller"){ ?>
									<th><?= ('Driver') ?></th>
									<?php } ?>
									<th><?= ('Action') ?></th>
									
									
								</tr>
							</thead>
							<tbody>
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								<?php 
								
										if(!empty($orders->toArray()))
										{
											foreach ($orders as $order)
											{
												if($order->order_status == 'placed')
												{
													foreach($order->challan_rows as $orderData)
													{ //pr($AllCategories); pr($orderData->item->category_id); exit;
														if($order->seller_id==3)
														{
															$order->BgColor = 'style="background: green;color: white;"';
															$order->anchorColor =  'style="color : white !important;"';
														}else
														{
															$order->BgColor = '';
															$order->anchorColor =  'style="color : #337ab7 !important;"';
														}
														 
													}	
												}else {
															$order->BgColor = '';
															$order->anchorColor =  '';
												}
															
											}			
										}
								
								//pr($orders); exit; 
								
								?>
								  <?php 
									
								  foreach ($orders as $order): //pr($order->order->order_no); exit; 
								  if(!empty($order->order->order_comment)){ 
										$cmtColr='style="background: #de6b80;color: white;"';
									}else{
										@$cmtColr='style="background: white;color: black;"';
									}
								  $order_date=$order->transaction_date;
								  $delivery_date=$order->delivery_date;
								  @$time_from=$order->delivery_time->time_from;
								  @$time_to=$order->delivery_time->time_to;
								  $delivery_time=$time_from.'-'.$time_to;
								  $tdColor = '';
								  if($order->order_status == 'placed')
								  {
									 $tdColor = 'style = "background-color: yellow;color: black;"'; 
								  }
								  if($order->order_status == 'Packed')
								  {
									 $tdColor = 'style = "background-color: #264e26;color: white;"'; 
								  }
								  if($order->order_status == 'Dispatched')
								  {
									$tdColor = 'style = "background-color: red;color: white; "'; 
								  }
								  ?>
								<tr height="40px" <?php echo $order->BgColor; ?> >
									<td style="background: white;color: black;"><?= $this->Number->format(++$i) ?></td>
									<?php if($user_type != "Seller"){ ?>
									<?php if($TotalChallans[$order->order->id] >= 1){ ?>
									<td <?php echo $cmtColr; ?>rowspan="<?php echo $TotalChallans[$order->order->id]; ?>"><?= h($order->order->order_no) ?></td>
									<?php $TotalChallans[$order->order->id]=0; } ?>
									<?php } ?>
									
									<td  >
										<?php 
										$challan_id=$order->id;
										$ordr_id=$order->id;
										$cus_id=$order->customer_id;
										//pr($order->id);
										$order_id = $EncryptingDecrypting->encryptData($order->id); 
										//pr($order_id); exit;
										$customer_id = $EncryptingDecrypting->encryptData($order->customer->id);
										$challan_id_enc = $EncryptingDecrypting->encryptData($challan_id); 
										?>
										<?php echo $this->Html->link($order->invoice_no,['controller'=>'Challans','action' => 'challan-view', $challan_id_enc, 'print'],['target'=>'_blank',$order->anchorColor]); ?>
									</td>
									<td>
									<?= $order->where_challan ?>
									</td>
									<td>&nbsp;
									<?php if($user_type != "Seller"){ ?>
										<?php echo $this->Html->link(@$order->customer->name.' ('.$order->customer->username.')',['controller'=>'Customers','action' => 'view', $customer_id, 'print'],['target'=>'_blank',$order->anchorColor]); ?>
									<?php } else { ?>
										<?php echo @$order->customer->name; ?>
									<?php } ?>
									</td>
									<td><?= h(@$order->customer_addresses_left->landmark->name) ?></td>
									
                                                                       <td data-toggle="tooltip" title="<?php echo @$order['customer_addresses_left']['landmark']['route_details'][0]['route']['narration'];?>"><?= h(@$order['customer_addresses_left']['landmark']['route_details'][0]['route']['name']) ?></td>
									<td><?= h($order->pay_amount) ?></td>
									<td><?= h($order->order_type) ?></td>
									<td><?= h($order_date) ?></td>
									<?php if($status=="delivered"){ ?>
									<td><?= h($order->pay_amount-$order->s_pay_amount) ?></td>
									<td><?= h($order->s_pay_mode) ?></td>
									<td><?= h($order->s_pay_amount) ?></td>
									<?php } ?>
									<td <?php echo $tdColor; ?>><?= h($order->order_status) ?></td>
									<?php if($user_type != "Seller"){ ?>
									<td>
									<?php
									if($order->order_status=='Delivered' || $order->order_status=='Cancel' || $order->order_status =='Returned'){
										echo @$order->driver->name;
									}else{
										echo $this->Form->select('driver_id',$drivers,['empty'=>'---Select--Driver----','class'=>'form-control input-sm driver_id select','label'=>false,'value'=>$order->driver_id]);
										
									}
										?>
									
									</td>
									<?php } ?>
									<td>&nbsp; 
									<span id="al"></span>
										<?php 
										if($order->packing_flag=='Deactive' && $order->order_status!='Cancel'){ ?>
											<?php 
											if(($order->order->order_type=="Online" || $order->order->order_type=="Wallet/Online") && ($order->order->payment_status !="Success")){
											//if($order->order->payment_status !="Success"){	
											?>
												<b style="color:red;">Payment Failed, Take</b>
												<a class="btn btn-info active cash btn-condensed btn-sm" order_id="<?php echo $order->order->id; ?>" > COD</a>
											<?php //} ?>
											
											<?php } else { ?>
											<?= $this->Form->button(__('Packing'),['class'=>'btn btn-success btn-condensed btn-sm pckg']) ?>
											<?php } ?>
											
										
											
										<?php } ?>
										
										<?php if(($order->packing_flag=='Active') && ($order->dispatch_flag=='Deactive')){ ?>
											<?= $this->Form->button(__('Dispatch'),['class'=>'btn btn-warning  btn-condensed btn-sm dsptch']) ?>
										<?php } ?>
										
										<?php if($order->dispatch_flag=='Active' && $order->order_status!='Delivered' && $order->order_status!='Cancel' && $order->order_status!='Returned'){ ?>
											<a class="btn btn-primary dlvr btn-condensed btn-sm" order_id="<?php echo $order->id; ?>" > Deliver</a>
											
										<?php } ?>
										
										<?php if($order->order_status!='Delivered' && $order->order_status!='Cancel' && $order->order_status!='Returned'){?>
											<?php if($user_type != "Seller"){ ?>  
										<a href="#" class="btn btn-danger btn-condensed btn-sm concl" order_id="<?php echo $order->id; ?>" cstmr_id="<?php echo $order->customer_id; ?>" data-toggle="modal" data-target="#modal_change_photo_<?php echo $ordr_id; ?>">Cancel</a>
											 
											 <div class="modal animated fadeIn" id="modal_change_photo_<?php echo $ordr_id; ?>" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
													<h4 class="modal-title" id="smallModalHead">You want to cancel <?= h($order->order_no) ?> Challan ?</h4>
												</div>
												<div class="modal-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label">Reason</label>
														<div class="col-md-4">
															<?= $this->Form->select('cancel_reason_id',$cancelReasons,['empty'=>'---Select--Reason----','class'=>'form-control input-sm cncl_rsn select','label'=>false]);
															?>
														</div>                            
													</div>                        
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger cnc" cus_id="<?php echo $cus_id; ?>" ord_id="<?php echo $ordr_id; ?>" id="cp_accept">Cancel</button>
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
		
											<?php } } ?>
										 <input type="hidden" class="ordr_id" value="<?php echo $order->id ?>" >
									</td>
									
									<!--<td>&nbsp; 
									
										<?php 
										if(($order->order_status!='Delivered') && ($order->order_status!='Cancel') && ($order->order_status!='Returned')){
										if(empty($order->otp)){ ?>
										
											<?= $this->form->button(__('OTP'),['class'=>'btn btn-success btn-condensed btn-sm otp']) ?>
										<?php } ?>
										
										<?php if($order->not_received=='No'){ ?>
										
											<?= $this->form->button(__('SMS'),['class'=>'btn btn-warning btn-condensed btn-sm sms']) ?>
										<?php } ?>
										
										<input type="hidden" class="otp_val" value="<?php echo $order->id ?>" mob="<?php echo @$order->customer_addresses_left->mobile_no; ?>">
										<?php } ?>		
									</td>-->	
										
									
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel-footer">
					<div class="paginator pull-right">
						<ul class="pagination">
							<?= $this->Paginator->first(__('First')) ?>
							<?= $this->Paginator->prev(__('Previous')) ?>
							<?= $this->Paginator->numbers() ?>
							<?= $this->Paginator->next(__('Next')) ?>
							<?= $this->Paginator->last(__('Last')) ?>
						</ul>
						<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
					</div>
				</div>
			</div>
			
		</div>
	</div>                    
	
</div>
<div  class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="false" style="display: none;border:0px;" id="popup">
<div class="modal-backdrop fade in" ></div>
	<div class="modal-dialog modal-sm" style="overflow-y: scroll; max-height:85%; width:1200px;  margin-top: 50px; margin-bottom:50px;">
		<div class="modal-content" style="border:0px;">
		<form method="post">
			<div class="modal-body flip-scroll">
				<p >
					 Body goes here...
				</p>
			</div>
		</form>	
		</div>
	</div>
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?php
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
		
		$(document).on('click','.button1',function(){ 
			alert();
		});
		
		
		$(document).on('click','.cnc',function(){
			var t=$(this);
			var ord_id=$(this).attr('ord_id');
			var cus_id=$(this).attr('cus_id');
			var cncl_rsn=$(this).closest('tr').find('.cncl_rsn option:selected').val();
			var url='".$this->Url->build(["controller" => "Challans", "action" => "cancelChallan"])."';
			url=url+'/'+ord_id+'/'+cncl_rsn+'/'+cus_id
			// alert(url); exit;
			$.ajax({
				url: url,
				type: 'GET'
			}).done(function(response) {
				//alert(response);
				t.html(response);
				$('.in').hide();
				t.closest('tr').find('.concl').remove();
			});
			 
		});
		
		
		
		$(document).on('click','.delete_row',function(){
			var t=$(this).closest('tr').remove();
			//manage_calculation();
			calculation();
		});
		
		$(document).on('change','.driver_id',function(){
			var mn=$(this);
			var ordr_id=$('option:selected', this).closest('tr').find('.ordr_id').val();
			var driver_id=$('option:selected', this).val();
			var url='".$this->Url->build(["controller" => "Challans", "action" => "driverAssign"])."';
			url=url+'/'+ordr_id+'/'+driver_id
			 
			$.ajax({
				url: url,
				type: 'GET'
			}).done(function(response) {
				//mn.hide();
			});
		});
		
		
		$(document).on('click','.otp',function(){
			var mn=$(this);
			var ordr_id=$(this).closest('tr').find('.otp_val').val();
			var mob=$(this).closest('tr').find('.otp_val').attr('mob');
			var url='".$this->Url->build(["controller" => "Orders", "action" => "otpSend"])."';
			url=url+'/'+ordr_id+'/'+mob
			 
			$.ajax({
				url: url,
				type: 'GET'
			}).done(function(response) {
				mn.hide();
			});
		});
		
		$(document).on('click','.sms',function(){
			var mns=$(this);
			var ordr_id=$(this).closest('tr').find('.otp_val').val();
			var mob=$(this).closest('tr').find('.otp_val').attr('mob');
			var url='".$this->Url->build(["controller" => "Orders", "action" => "smsSend"])."';
			url=url+'/'+ordr_id+'/'+mob
			 
			$.ajax({
				url: url,
				type: 'GET'
			}).done(function(response) {
			 
				mns.hide();
			});
			
		});
		
		 
			$(document).on('click','.cncl',function(){
			$('#popup').show();
			var order_id=$(this).closest('tr').find('.ordr_id').val();
			$('#popup').find('div.modal-body').html('Loading...');
			var url='".$this->Url->build(["controller" => "Orders", "action" => "cancel"])."';
			url=url+'/'+ordr_id+'/'+mob
			$.ajax({
				url: url,
				type: 'GET',
				dataType: 'text'
			}).done(function(response) {
				$('#popup').find('div.modal-body').html(response);
			});	
		});
	
		$(document).on('click','.pckg',function(){
			if(confirm('Are you sure you want to Pack Challan!'))
			{ 
				var mns1=$(this);
				var ordr_id=$(this).closest('tr').find('.ordr_id').val();
				var mn1=$(this).closest('tr').find('#al');
				var url='".$this->Url->build(["controller" => "Challans", "action" => "packing"])."';
				url=url+'/'+ordr_id
				$.ajax({
					url: url,
					type: 'GET'
				}).done(function(response) {
					mns1.hide();
					mn1.html(response);
				});
			}
		});
		
		$(document).on('click','.cncl',function(){
			var mns1=$(this);
			var ordr_id=$(this).closest('tr').find('.ordr_id').val();
			var customer_id=$(this).attr('cstmr_id');
			var mn1=$(this).closest('tr').find('#al');
			var url='".$this->Url->build(["controller" => "Orders", "action" => "cancel"])."';
			url=url+'/'+ordr_id+'/'+customer_id
			$.ajax({
				url: url,
				type: 'GET'
			}).done(function(response) {
				mns1.hide();
				mn1.html('Cancelled');
			});
		});
		
		$(document).on('click','.dsptch',function(){
			if(confirm('Are you sure you want to Dispatch Challan!'))
			{
				var mns2=$(this);
				var mn1=$(this).closest('tr').find('#al');
				var ordr_id=$(this).closest('tr').find('.ordr_id').val();
				var url='".$this->Url->build(["controller" => "Challans", "action" => "dispatch"])."';
				url=url+'/'+ordr_id
				$.ajax({
					url: url,
					type: 'GET'
				}).done(function(response) {
					mns2.hide();
					mn1.html(response);
				});
			}
			
		});
		
		$(document).on('click','.cash',function(){
			//var order_id=$(this);
			//var mn1=$(this).closest('tr').find('#al');
			var order_id=$(this).attr('order_id');
			//var ordr_id=$(this).closest('tr').find('.ordr_id').val();
			
			var url='".$this->Url->build(["controller" => "Challans", "action" => "orderIntoCod"])."';
			url=url+'/'+order_id
			//alert(url); 
			$.ajax({
				url: url,
				type: 'GET'
			}).done(function(response) {
				location.reload();
			});
			
		});
		
		$(document).on('click','.close',function(){
			$('#popup').hide();
		});
		 
		$(document).on('click','.dlvr',function(){
		$('#popup').show();
		var order_id=$(this).closest('tr').find('.ordr_id').val();
		 
 		$('#popup').find('div.modal-body').html('Loading...');
		var url='".$this->Url->build(["controller" => "Challans", "action" => "ajax_deliver"])."';
		url=url+'/'+order_id; //alert(url);
		$.ajax({
			url: url,
			type: 'GET'
			//dataType: 'text'
		}).done(function(response) {
			$('#popup').find('div.modal-body').html(response);
			calculation();
		});	
		});
	  
	  
		$(document).on('keyup','.actual_quantity',function(){
			var actual_quantity=$(this).val();
			var gst_per=$(this).attr('gst');
			var price=$(this).attr('price');
			var seprate_amount=actual_quantity*price;
			var dis_per = $(this).closest('tr').find('.dis_per').val();
			var dis_amnt=(seprate_amount*dis_per/100);
			if(!dis_amnt){ dis_amnt=0; }
			var txbl_amnt=seprate_amount-dis_amnt;
			$(this).closest('tr').find('.taxable').val(txbl_amnt);
			var gst_val=(txbl_amnt*gst_per/100);
			$(this).closest('tr').find('.gst_value').val(gst_val);
			var with_gst=txbl_amnt+gst_val;
			$(this).closest('tr').find('.net_amount').val(with_gst.toFixed(2));
			$(this).closest('tr').find('.dis_amnt').val(dis_amnt);
			
			$(this).closest('tr').find('.amount').val(with_gst.toFixed(2));
			manage_calculation();
		});
	 
	  $(document).on('keyup','.amount',function(){
		  calculation();
	  });
	 
	 function calculation(){ 
			var total_amount=0;
			var total_gst=0;
			var total_taxable_value=0;
			var main_total_taxable_value=0;
			var tot_txbl=0;
			var before_discount_all=0;
			var total_discount=0;
			$('.main_table tbody tr').each(function(){
				
				
					var discount_applicable=$(this).find('.discount_applicable').val();
					 
					$(this).closest('tr').find('.discount_percent').val();
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
					//var quantity_factor=$(this).find('option:selected', this).attr('quantity_factor');
					//var commission=$(this).find('option:selected', this).attr('commission');
					var unit=$(this).find('option:selected', this).attr('unit');
					var item_id=$(this).find('.item_id').attr('item_id');
					var item_category_id=$(this).find('.item_id').attr('category_id');
					  
					//var total_qty=quantity_factor*qty;
					//$(this).find('.itemQty').html(total_qty +' '+ unit);
					var taxable_value_before_dis=qty*rate;
					var taxable_value_after_dis=qty*rate;
					$(this).closest('tr').find('.amount').val(taxable_value_before_dis);
					if(discount_percent){
						var dis=round(round(taxable_value_before_dis*discount_percent)/100,2);
						var taxable_value_after_dis=taxable_value_before_dis-dis;
						$(this).find('.discount_amount').val(round(dis,2));
					}
					 
					$(this).closest('tr').find('.txbal').val(taxable_value_after_dis);
					 $(this).find('.promo_amount').val();
					 $(this).find('.promo_percent').val();
					 var prmo_amnt=parseFloat($(this).closest('tr').find('.promo_amount').val());
					 if(!prmo_amnt){ prmo_amnt=0; }
					 var taxable_value=parseFloat(taxable_value_after_dis-prmo_amnt);
					 $(this).closest('tr').find('.taxable1').val(taxable_value);
					 $(this).closest('tr').find('.net_amount').val(taxable_value);
					 
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
					$(this).find('.taxable_value').val(f_taxable);
					
					var before_discount=$(this).find('.amount').val();
					if(!before_discount){ before_discount=0; }
					
					var main_discount_amount=$(this).find('.discount_amount').val();
					if(!main_discount_amount){ main_discount_amount=0; }

					var main_promo_amount=$(this).find('.promo_amount').val();
					if(!main_promo_amount){ main_promo_amount=0; }
					
					var add_taxable_value=$(this).find('.taxable_value').val();
					if(!add_taxable_value){ add_taxable_value=0; }
					
					var get_gst_value=$(this).find('.gst_value').val();
					if(!get_gst_value){ get_gst_value=0; }
					
					
					var final_main_discount_amount=parseFloat(main_discount_amount)+parseFloat(main_promo_amount);
					total_discount+=parseFloat(final_main_discount_amount);
				
					before_discount_all+=parseFloat(before_discount);
					
					total_gst+=parseFloat(get_gst_value);
					
				 
				  
				  main_total_taxable_value+=parseFloat(add_taxable_value);
				
			});
				$('.dis_amnt').val(total_discount);
				$('.gst_amt').val(round(total_gst,2));  
				$('.before_discount').val(round(before_discount_all,2));
				$('.total_taxable_value').val(round(main_total_taxable_value,2));
				
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
				
				delivery_chrg=$('.dlvry_chrgs').val();
				
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
		}
		
		//manage_calculation_oth();
		
	 function manage_calculation_oth(){ 
		 var all_first_amount=0;
		 var all_first_gst_value=0;
		 var all_first_net_amount=0;
		 var all_taxable_value=0;
		 $('.main_table tbody tr').each(function(){
			 
			 var first_amount=parseFloat($(this).find('td:nth-child(11) input.amount').val());
			 if(!first_amount){ first_amount=0; }
			 var taxable=parseFloat($(this).find('td:nth-child(8) input.taxable').val());
			 if(!taxable){ taxable=0; }
			 var first_gst_value=parseFloat($(this).find('td:nth-child(10) input.gst_value').val());
			 if(!first_gst_value){ first_gst_value=0; }
			 var first_net_amount=parseFloat($(this).find('td:nth-child(11) input.net_amount').val());
			 if(!first_net_amount){ first_net_amount=0; }
			 
			 all_first_amount+=first_amount;
			 all_first_gst_value+=first_gst_value;
			 all_first_net_amount+=first_net_amount;
			 all_taxable_value+=taxable;
			
		 });
		
		 $('.txbl').val(all_taxable_value.toFixed(2));
		 $('.ttl_gst').val(all_first_gst_value.toFixed(2));
		 $('.grnd_ttl').val(all_first_net_amount.toFixed(2));
	 }
	  
		$(document).on('click','.get_order',function(){	
		var order_id=$(this).attr('order_id');
		var s1 = [];
		var s2 = [];
		var s3 = [];
		var s4 = [];
		var s5 = [];
		var s6 = [];
		$('.main_table tbody tr').each(function(){ 
		 
			 var row = [];
			 var items = [];
			 var amounts = [];
			 var gst_values = [];
			 var net_amounts = [];
			 var detail_ids = [];
			 
			var actual_quantity = $(this).find('td:nth-child(4) .actual_quantity').val();
			var amount = $(this).find('td:nth-child(6) .amount').val();
			var gst_value = $(this).find('td:nth-child(6) .gst_value').val();
			var net_amount = $(this).find('td:nth-child(6) .net_amount').val();
			var item_id = $(this).find('td:nth-child(2) .item_id').val();
			var detail_id = $(this).find('td:nth-child(2) .dtl').val();
			row.push(actual_quantity);
			 s1.push(row);
			 items.push(item_id);
			 s2.push(items);
			 amounts.push(amount);
			 s3.push(amounts);
			 gst_values.push(gst_value);
			 s4.push(gst_values);
			 net_amounts.push(net_amount);
			 s5.push(net_amounts);
			 detail_ids.push(detail_id);
			 s6.push(detail_ids);
		});
		  var txbl_value=$('.txbl').val();
		  var ttl_gst=$('.ttl_gst').val();
		  var grnd_ttl=$('.grnd_ttl').val();
		  
			$('.get_order').prop('disabled', true);
			$('.get_order').text('Delivered.....');
						var url='".$this->Url->build(['controller'=>'Orders','action'=>'updateOrders'])."';
						url=url+'/'+order_id+'/'+s2+'/'+s1+'/'+s3+'/'+s4+'/'+s5+'/'+s6+'/'+txbl_value+'/'+ttl_gst+'/'+grnd_ttl,
						 
						$.ajax({
							url: url,
						}).done(function(response) {
							var order_id=$('.get_order').attr('order_id');
							var m_data = new FormData();
							m_data.append('order_id',order_id);
							
							$.ajax({
							url: '".$this->Url->build(['controller' => 'Orders', 'action' => 'ajax_deliver_api'])."',
							data: m_data,
							processData: false,
							contentType: false,
							type: 'POST',
							dataType:'text',
							success: function(data)   // A function to be called if request succeeds
							{
								location.reload();
								//$('.setup').html(data);
							}
							});
						});	
			 
		
	});
		
		";  
echo $this->Html->scriptBlock($js, array('block' => 'scriptBottom')); 		
?>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>