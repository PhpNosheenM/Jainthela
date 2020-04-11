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
											<td width="18%">
												<label>Item<label>
											</td>
											<td width="5%">
												<label>Quantity<label>
											</td>
											<td width="7%">
												<label>Rate<label>
											</td>
											<td width="7%">
												<label>Amount<label>
											</td>
											<td width="7%">
												<label>LCD Dis (%)<label>
											</td>
											<td width="7%">
												<label>LCD Dis (Rs)<label>
											</td>
											<td width="7%">
												<label>Promo Dis (%)<label>
											</td>
											<td width="7%">
												<label>Promo Dis (Rs)<label>
											</td>
											<td width="7%">
												<label>Taxable<label>
											</td>
											<td width="7%">
												<label>GST (%)<label>
											</td>
											<td width="7%">
												<label>GST (Rs)<label>
											</td>
											
											<td width="15%">
												<label>Net Amount<label>
											</td>
											<td width="15%">
												<label>Cancel<label>
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
													<?php echo $this->Form->input('order_details['.$k.'][item_id]', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm number item_id','value'=>@$order_detail->item_id,'detail_id'=>$order_detail->id,'category_id'=>$order_detail->item_variation->item->category_id]); ?>
													<?php echo $this->Form->input('order_details['.$k.'][id]', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm number dtl','value'=>@$order_detail->id]); ?>
													
													<?= h(@$order_detail->item_variation->item->name.'('.$order_detail->item_variation->item->alias_name.')')?>
													<input type="hidden" class="discount_applicable" value="<?php echo $order_detail->item_variation->item->is_discount_enable;?>">
												</td>
												<td align="center">
													<?php 
													@$quantity=$order_detail->quantity;
													echo $this->Form->input('order_details['.$k.'][quantity]', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm number quantity','value'=>@$quantity]); ?>
													<?= h(@$quantity)?>
												</td>
												
												<td align="center">
													<?php 
													echo $this->Form->input('order_details['.$k.'][rate]', ['label' => false,'class' => 'form-control input-sm number rate','min'=>0.01,'value'=>$price, 'readonly'=>'readonly']); ?>
													<label class="error"></label>
												</td>
												
												<td align="center">
													<?php 
													@$amount=$order_detail->amount;
													echo $this->Form->input('order_details['.$k.'][actual_quantity]', ['label' => false,'class' => 'form-control input-sm number amount','min'=>1,'value'=>@$amount,'price' => $price, 'gst'=>$order_detail->gst_percentage]); ?>
													<label class="error"></label>
												</td>
												
												
												
												
												<td align="center">
													<?php echo $this->Form->input('order_details['.$k.'][discount_percent]', ['label' => false,'class' => 'form-control input-sm number discount_percent','value'=>$order_detail->discount_percent, 'readonly'=>'readonly']); ?>
													<label class="error"></label>
												</td>
												
												<td align="center">
													<?php 
													$lcd_dis_amnt=$order_detail->discount_amount;
													echo $this->Form->input('order_details['.$k.'][discount_amount]', ['label' => false,'class' => 'form-control input-sm number discount_amount','value'=>$order_detail->discount_amount, 'readonly'=>'readonly']);
							
													$after_lcd_txable=$quantity*$price-$lcd_dis_amnt;
													?>
													<input type="text" class="txbal" value="<?php echo $after_lcd_txable; ?>">
													<label class="error"></label>
												</td>
												
												
												<td align="center">
													<?php echo $this->Form->input('order_details['.$k.'][discount_percent]', ['label' => false,'class' => 'form-control input-sm number promo_percent','value'=>$order_detail->promo_percent, 'readonly'=>'readonly']); ?>
													<label class="error"></label>
												</td>
												
												<td align="center">
													<?php 
													$promos_amnt=$order_detail->promo_amount;
													echo $this->Form->input('order_details['.$k.'][discount_amount]', ['label' => false,'class' => 'form-control input-sm number promo_amount','value'=>$order_detail->promo_amount, 'readonly'=>'readonly']); ?>
													<label class="error"></label>
												</td>
												
												
												
												<td align="center">
													<?php echo $this->Form->input('order_details['.$k.'][taxable_value]', ['label' => false,'class' => 'form-control input-sm number taxable_value', 'readonly'=>'readonly','value'=>$order_detail->taxable_value]); ?>
													<?php 
													$txable1=$after_lcd_txable-$promos_amnt;
													echo $this->Form->input('order_details['.$k.'][taxable1]', ['label' => false,'class' => 'form-control input-sm number taxable1', 'readonly'=>'readonly','value'=>$txable1]); ?>
													<label class="error"></label>
												</td>
												
												<td align="center">
													<?php echo $this->Form->input('order_details['.$k.'][gst_percentage]', ['label' => false,'class' => 'form-control input-sm number gst_percentage','value'=>$order_detail->gst_percentage, 'readonly'=>'readonly']); ?>
													<label class="error"></label>
												</td>
												
												<td align="center">
													<?php echo $this->Form->input('order_details['.$k.'][gst_value]', ['type'=>'text','label' => false,'class' => 'form-control input-sm number gst_value','min'=>0.01,'value'=>$order_detail->gst_value]); ?>
													<label class="error"></label>
												</td>
												
												
												
												<td align="center">
													<?php echo $this->Form->input('order_details['.$k.'][net_amount]', ['type'=>'text','label' => false,'class' => 'form-control input-sm number net_amount','min'=>0.01,'value'=>$order_detail->net_amount]); ?>
													<label class="error"></label>
													
													<?php //echo $this->Form->input('order_details['.$k.'][gst_value]', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm number gst_value','min'=>0.01,'value'=>$order_detail->gst_value]); ?>
													
													
												</td>
												<td>
													<a class="btn btn-danger  btn-condensed btn-sm delete_row " role="button" ><i class="fa fa-times"></i></a>
												</td>
											</tr>
										<?php $k++; }  ?>	
										
									</tbody>
									<tfoot>
										<tr>
										<td colspan="12" style="text-align:right;">Total Amount Before Discount</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('before_discount',['class'=>'form-control before_discount','label'=>false,'readonly','value'=>@$Orders->total_amount]) ?>
										</td>
									</tr>
									<tr>
										<td colspan="12" style="text-align:right;">Discount Amount</td>
										<td colspan="2" style="text-align:right;">
										 
										<?= $this->Form->control('discount_amount',['class'=>'form-control dis_amnt','label'=>false,'value'=>@$Orders->discount_amount]) ?>
										</td>
									</tr>
									<tr>
										<td colspan="12" style="text-align:right;">Total Taxable</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('total_amount',['class'=>'form-control total_taxable_value','label'=>false,'readonly','value'=>@$Orders->total_amount]) ?>
										</td>
									</tr>
									<tr>
										<td colspan="12" style="text-align:right;">GST Amount</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('total_gst',['class'=>'form-control gst_amt','label'=>false,'readonly','value'=>@$Orders->total_gst]) ?>
											<?= $this->Form->control('order_id',['class'=>'form-control','type'=>'hidden','readonly','value'=>@$Orders->id]) ?>
										</td>
									</tr>
									<tr>
										<input type="hidden" name="dlvr_amnt" id="dlvr_amnt" value="<?php echo $deliveryCharges->amount; ?>">
										
										<input type="hidden" name="dlvr_chrg" id="dlvr_chrg" value="<?php echo $deliveryCharges->charge; ?>">
										
										<input type="hidden" name="dlvr_chrg_id" id="dlvr_chrg_id" value="<?php echo $deliveryCharges->id; ?>">
										
										<input type="hidden" name="delivery_charge_id" id="delivery_charge_id">
										
										<td colspan="12" style="text-align:right;">Delivery Charges</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('delivery_charge_amount',['class'=>'form-control dlvry_chrgs','label'=>false,'readonly','value'=>@$Orders->delivery_charge_amount]) ?>
										</td>
									</tr>
									<tr>
										<td colspan="12" style="text-align:right;">
											<b>Total Amount</b>
										</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('grand_total',['class'=>'form-control total_amt','label'=>false,'readonly','value'=>@$Orders->grand_total]) ?>
										</td>
									</tr>
									<tr>
										<td colspan="12" style="text-align:right;">From Wallet</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('amount_from_wallet',['class'=>'form-control wlt_amt','label'=>false,'value'=>@$Orders->amount_from_wallet]) ?>
										</td>
									</tr>
									<tr>
										<td colspan="12" style="text-align:right;">Final Due Amount</td>
										<td colspan="2" style="text-align:right;">
											<?= $this->Form->control('due_amount',['class'=>'form-control due_amt','label'=>false,'value'=>@$Orders->due_amount,'readonly']) ?>
											<?= $this->Form->control('round_off',['type'=>'hidden','class'=>'form-control round_off','label'=>false,'value'=>@$Orders->round_off,'readonly']) ?>
										</td>
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
							<input type="submit" name="submit">
							<a class="btn blue get_order" id="submits" order_id="<?php echo $order_id; ?>" ><i class="fa fa-shopping-cart"></i> Deliver</a>
						</td>
					</tr>
				</tfoot>	
		</table>
		
</div>

