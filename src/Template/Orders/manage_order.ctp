<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Invoice'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Manage Invoice </strong></h3>
					<div class="pull-right">
					<?php if($status=='placed'){
						$class1="btn btn-xs blue";
						$class2="btn btn-default";
					}else {
						$class1="btn btn-default";
						$class2="btn btn-xs blue";
					}
					 ?>
						<?php echo $this->Html->link('Pending',['controller'=>'Orders','action' => 'manage_order?status=placed'],['escape'=>false,'class'=>$class1]); ?>
						<?php echo $this->Html->link('All',['controller'=>'Orders','action' => 'manage_order'],['escape'=>false,'class'=>$class2]); ?>&nbsp;
				</div> 	
				</div>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table-bordered" width="100%">
							<thead>
								<tr height="40px">
									<th><?= ('SNo.') ?></th>
									<th><?= ('Invoice No') ?></th>
									<th><?= ('Customer Name') ?></th>
									<th><?= ('Locality') ?></th>
									<th><?= ('Grand Total') ?></th>
									<th><?= ('Invoice Type') ?></th>
									<th><?= ('Invoice Date') ?></th>
									<th><?= ('Delivery Date') ?></th>
									<th><?= ('Delivery Time') ?></th>
									<th><?= ('Status') ?></th>
									<th><?= ('Action') ?></th>
									<th><?= ('Other') ?></th>
									<th><?= ('Edit') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($orders as $order): //pr($order); exit; 
								  
								  $order_date=$order->transaction_date;
								  $delivery_date=$order->delivery_date;
								  @$time_from=$order->delivery_time->time_from;
								  @$time_to=$order->delivery_time->time_to;
								  $delivery_time=$time_from.'-'.$time_to;
								  ?>
								<tr 
								<?php if(($order->order_status=='pending') || ($order->order_status=='pending')){ ?>
									style="background-color:#ffe4e4 !important;"
								<?php } ?> height="40px" >
									<td><?= $this->Number->format(++$i) ?></td>
									<td>
										<?php $order_id = $EncryptingDecrypting->encryptData($order->id); ?>
										<?php echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'view', $order_id, 'print'],['target'=>'_blank']); ?>
									</td>
									<td><?= h(@$order->customer->name) ?></td>
									<td><?= h($order->location->name) ?></td>
									<td><?= h($order->grand_total) ?></td>
									<td><?= h($order->order_type) ?></td>
									<td><?= h($order_date) ?></td>
									<td><?= h($delivery_date) ?></td>
									<td><?= h($delivery_time) ?></td>
									<td><?= h($order->order_status) ?></td>
									<td>&nbsp; 
									<span id="al"></span>
										<?php if($order->packing_flag=='Deactive'){ ?>
											<?= $this->form->button(__('Packing'),['class'=>'btn btn-success btn-condensed btn-sm pckg']) ?>
										<?php } ?>
										
										<?php if(($order->packing_flag=='Active') && ($order->dispatch_flag=='Deactive')){ ?>
											<?= $this->form->button(__('Dispatch'),['class'=>'btn btn-warning  btn-condensed btn-sm dsptch']) ?>
										<?php } ?>
										
										<?php if($order->dispatch_flag=='Active'){ ?>
											 
											<a class="btn btn-primary dlvr btn-condensed btn-sm" order_id="<?php echo $order->id; ?>" > Deliver</a>
										<?php } ?>
										
										 <?= $this->Html->link(__('Cancel'), ['action' => 'edit', $order->id],['class'=>'btn btn-danger  btn-condensed btn-sm','escape'=>false]) ?>
										 <input type="hidden" class="ordr_id" value="<?php echo $order->id ?>" >
									</td>
									
									<td>&nbsp; 
									
										<?php 
										if(($order->order_status!='Delivered') && ($order->order_status!='Delivered')){
										if(empty($order->otp)){ ?>
										
											<?= $this->form->button(__('OTP'),['class'=>'btn btn-success btn-condensed btn-sm otp']) ?>
										<?php } ?>
										
										<?php if($order->not_received=='No'){ ?>
										
											<?= $this->form->button(__('SMS'),['class'=>'btn btn-warning btn-condensed btn-sm sms']) ?>
										<?php } ?>
										
										<input type="hidden" class="otp_val" value="<?php echo $order->id ?>" mob="<?php echo $order->customer_address->mobile_no; ?>">
										<?php } ?>		
									</td>	
										
									<td class="actions">
										<?= $this->Html->link(__('Edit'), ['action' => 'edit', $order->id],['class'=>'btn btn-condensed btn-sm','escape'=>false]) ?>
										 
									</td>
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
	<div class="modal-dialog modal-sm" style="overflow-y: scroll; max-height:85%; width:800px;  margin-top: 50px; margin-bottom:50px;">
		<div class="modal-content" style="border:0px;">
			<div class="modal-body flip-scroll">
				<p >
					 Body goes here...
				</p>
			</div>
		</div>
	</div>
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>
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
		
		$(document).on('click','.pckg',function(){
			var mns1=$(this);
			var ordr_id=$(this).closest('tr').find('.ordr_id').val();
			var mn1=$(this).closest('tr').find('#al');
			var url='".$this->Url->build(["controller" => "Orders", "action" => "packing"])."';
			url=url+'/'+ordr_id
			$.ajax({
				url: url,
				type: 'GET'
			}).done(function(response) {
				mns1.hide();
				mn1.html(response);
			});
			
		});
		
		$(document).on('click','.dsptch',function(){
			var mns2=$(this);
			var mn1=$(this).closest('tr').find('#al');
			var ordr_id=$(this).closest('tr').find('.ordr_id').val();
			var url='".$this->Url->build(["controller" => "Orders", "action" => "dispatch"])."';
			url=url+'/'+ordr_id
			$.ajax({
				url: url,
				type: 'GET'
			}).done(function(response) {
				mns2.hide();
				mn1.html(response);
			});
			
		});
		
		 
		$(document).on('click','.dlvr',function(){
		$('#popup').show();
		var order_id=$(this).closest('tr').find('.ordr_id').val();
		 
 		$('#popup').find('div.modal-body').html('Loading...');
		var url='".$this->Url->build(["controller" => "Orders", "action" => "ajax_deliver"])."';
		url=url+'/'+order_id;
		$.ajax({
			url: url,
			type: 'GET'
			//dataType: 'text'
		}).done(function(response) {
			$('#popup').find('div.modal-body').html(response);
		});	
		});
	  
	  
		$(document).on('keyup','.actual_quantity',function(){
			var actual_quantity=$(this).val();
			var gst_per=$(this).attr('gst');
			var price=$(this).attr('price');
			var seprate_amount=actual_quantity*price;
			$(this).closest('tr').find('.amount').val(seprate_amount);
			var gst_val=(seprate_amount*gst_per/100);
			$(this).closest('tr').find('.gst_value').val(gst_val);
			var with_gst=seprate_amount+gst_val;
			$(this).closest('tr').find('.net_amount').val(with_gst);
			manage_calculation();
		});
	 
	 function manage_calculation(){
		 var all_first_amount=0;
		 var all_first_gst_value=0;
		 var all_first_net_amount=0;
		 $('.main_table tbody tr').each(function(){
			 
			 var first_amount=parseFloat($(this).find('td:nth-child(6) input.amount').val());
			 if(!first_amount){ first_amount=0; }
			 var first_gst_value=parseFloat($(this).find('td:nth-child(6) input.gst_value').val());
			 if(!first_gst_value){ first_gst_value=0; }
			 var first_net_amount=parseFloat($(this).find('td:nth-child(6) input.net_amount').val());
			 if(!first_net_amount){ first_net_amount=0; }
			 
			 all_first_amount+=first_amount;
			 all_first_gst_value+=first_gst_value;
			 all_first_net_amount+=first_net_amount;
			
		 });
		
		 $('.txbl').val(all_first_amount.toFixed(2));
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
