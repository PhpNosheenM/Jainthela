<style>
	tfoot {
    display: table-footer-group;
    vertical-align: middle;
    border-color: inherit;
}
label{
	margin-bottom: 1px !important;
}
</style>
<div style="" class="qwerty">
	<button type="button" class="btn btn-secondary" data-dismiss="popup">Close</button>
		<center><h4>INVOICE NUMBER:- <?php echo $Orders->order_no; ?></h4></center>
		
		
		<table class=" " width="100%" border="0">
			<thead>
				<tr style="background-color:#fff; color:#000;">
					<td align="left" class="modal-header" colspan="5">
						<b>
							<?php 
								
								$order_id=$Orders->id;
								$order_no=$Orders->order_no;
								$customer_name=$Orders->customer->name;
								$customer_mobile=$Orders->customer->username;
								$order_date=date('d-m-Y h:i a', strtotime($Orders->order_date));
							?>								
							Deliver Order of Customer: <?= h(ucwords($customer_name).' ('.$customer_mobile.')') ?>
						</b>
					</td>
					
				</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<div class="portlet-body">
							
								<table class="table table-condensed table-bordered main_table" id="main_table">
									
									<thead>
										<tr align="center">
											<td width="4%">
												<label>Sr<label>
											</td>
											<td width="30%">
												<label>Item<label>
											</td>
											<td width="14%">
												<label>Quantity<label>
											</td>
											<td width="14%">
												<label>Actual Quantity<label>
											</td>
											<td width="20%">
												<label>Rate<label>
											</td>
											<td width="20%">
												<label>Amount<label>
											</td>
											
										</tr>
									</thead>
									<tbody id='main_tbody' class="tab">
										
										<?php $i=1; $k=0;  
										
										foreach($Orders->order_details as $order_detail){ 
										
											 @$minimum_quantity_factor=$order_detail->item_variation->minimum_quantity_factor;
											 $price=$order_detail->rate;
											 $real_amount=$order_detail->amount;
										?>
											<tr class="main_tr tab">
												<td align="center">
													<?= h($i++)?>
												</td>
												<td align="center">
													<?php echo $this->Form->input('order_details['.$k.'][item_id]', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm number item_id','value'=>@$order_detail->item_id]); ?>
													<?= h(@$order_detail->item_variation->item->name.'('.$order_detail->item_variation->item->alias_name.')')?>
												</td>
												<td align="center">
													<?php echo $this->Form->input('order_details['.$k.'][quantity]', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm number ','value'=>@$order_detail->quantity]); ?>
													<?= h(@$order_detail->quantity)?>
												</td>
												
												<td align="center">
													<?php echo $this->Form->input('order_details['.$k.'][actual_quantity]', ['label' => false,'class' => 'form-control input-sm number actual_quantity','min'=>1,'value'=>@$order_detail->actual_quantity, 'minimum_quantity_factor'=>$minimum_quantity_factor, 'price' => $price, 'gst'=>$order_detail->gst_percentage]); ?>
													<label class="error"></label>
												</td>
												
												<td align="center">
													<?php echo $this->Form->input('order_details['.$k.'][rate]', ['label' => false,'class' => 'form-control input-sm number rate','min'=>0.01,'value'=>$price, 'readonly'=>'readonly']); ?>
													<label class="error"></label>
												</td>
												
												<td align="center">
													<?php echo $this->Form->input('order_details['.$k.'][amount]', ['label' => false,'class' => 'form-control input-sm number amount','min'=>0.01,'value'=>$real_amount, 'readonly'=>'readonly']); ?>
													<label class="error"></label>
													
													<?php echo $this->Form->input('order_details['.$k.'][gst_value]', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm number gst_value','min'=>0.01,'value'=>$order_detail->gst_value]); ?>
													
													<?php echo $this->Form->input('order_details['.$k.'][net_amount]', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm number net_amount','min'=>0.01,'value'=>$order_detail->net_amount]); ?>
												</td>
											</tr>
										<?php $k++; }  ?>	
										
									</tbody>
									<tfoot>
										<tr>
											<td colspan="5" align="right">Taxable Value</td>
											<td><?php echo $this->Form->input('total_amount', ['label' => false,'class' => 'form-control input-sm txbl','value'=>$Orders->total_amount]); ?></td>
										</tr>
										<tr>
											<td colspan="5" align="right">Total GST</td>
											<td><?php echo $this->Form->input('total_gst', ['label' => false,'class' => 'form-control input-sm ttl_gst','value'=>$Orders->total_gst]); ?></td>
										</tr>
										<tr>
											<td colspan="5" align="right">Grand Value</td>
											<td><?php echo $this->Form->input('grand_total', ['label' => false,'class' => 'form-control input-sm grnd_ttl','value'=>$Orders->grand_total]); ?></td>
										</tr>
									</tfoot>
								</table>		
						
							</div>
						</td>
					</tr>
				</tbody>
				
				<tfoot>
					
					<tr>
						<td align="right">
							<a class="btn blue get_order" id="submits" order_id="<?php echo $order_id; ?>" ><i class="fa fa-shopping-cart"></i> Deliver</a>
						</td>
					</tr>
				</tfoot>	
		</table>
		
</div>

