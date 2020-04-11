<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Customers'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Customers Detail Chart</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
								<div class="form-group" style="display:inline-table">
									<div class="input-group">
										 <span class="fa fa-user" style="font-size:20px;">
											: <?php echo $customer->name; ?>&nbsp; | &nbsp; 
										 </span>
										 <span class="fa fa-phone" style="font-size:20px;">
											: <?php echo $customer->username; ?>
										 </span> 
									</div>
								</div>
							<?= $this->Form->end() ?>
						</div> 
					</div> 	
				</div>
				
				<div class="row">
					<div class="col-md-12 col-md-offset-4 " style="margin-top:2%;">
						<div class="col-md-2">                        
                            <a href="#" class="tile tile-info">
                                <span class="fa fa-briefcase"></span>
                                <p><b>WALLET - <?= h($wallet_remaining) ?></b></p>
                            </a>                        
                        </div>
						
						<div class="col-md-2">                        
                            <a href="#" class="tile tile-warning">
                                <span class="fa fa-shopping-cart"></span>
                                <p><b>ORDERS - <?= h($order_count) ?></b></p>
                            </a>                        
                        </div>
					</div>
				</div>
				
				<div class="panel-body">
					<div class="table-responsive">
						<table width="100%" class="table table-condensed  table-bordered" >
		<tr>
			<td width="50%" valign="top" align="left" style="background-color: rgba(228, 226, 226, 0.38);">
				<table class="table table-condensed table-bordered" id="main_tble">
					<caption style="text-align:center;font-size:20px;">Advance In Wallet</caption>
					<thead>
						
						<tr>
							<th>Sr</th>
							<th>Plan</th>
							<th>Type</th>
							<th>Advance</th>
							<th>Narration</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach($wallet_advances as $wallet_advance){ 
						
						if($wallet_advance->add_amount == 0){
							?>
							<tr></tr>
							
						<?php }else{@$m++; ?>
							
							<tr>
								<td><?php echo $m; ?></td>
								<td>
									<?= h(@$wallet_advance->plans_left->name) ?>
								</td>
								<td>
									<?= h(@$wallet_advance->amount_type) ?>
								</td>
								<td>
									<?= h(@$wallet_advance->add_amount) ?>
								</td>
								<td>
									<?= h(@$wallet_advance->narration) ?>
								</td>
								<td>
									<?= h(@$wallet_advance->created_on) ?>
								</td>
						<?php }} ?>														 
					</tbody>
				</table>
			</td>
			<td width="50%" valign="top" align="right" style="background-color: rgba(228, 226, 226, 0.38);">
				<table class="table table-condensed  table-bordered" id="main_tble2">
					<caption style="text-align:center;font-size:20px;">Consumed From Wallet</caption>
					<thead>
						<tr>
							<th>Sr</th>
							<th>Order</th>
							<th>Consumed</th>
							<th>Narration</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($wallet_consumes as $wallet_consume){  
						
						if($wallet_consume->used_amount == 0){
							?>
							<tr></tr>
							
						<?php }else{ @$s++;?>
							<tr>
								<td><?= $s ?></td>
								<td>
									<?= h(@$wallet_consume->orders_left->order_no) ?>
								</td>
								<td>
									<?= h(@$wallet_consume->used_amount) ?>
								</td>
								<td>
									<?= h(@$wallet_consume->narration) ?>
								</td>
								<td>
									<?= h(@$wallet_advance->created_on) ?>
								</td>
							</tr>	
						<?php }} ?>
						 
					</tbody>
				</table>	
			</td>
		</tr>
	</table>
	
	
	
	<table width="100%" class="table table-condensed  table-bordered" >
		<tr>
			<td width="50%" valign="top" align="left" style="background-color: rgba(228, 226, 226, 0.38);">
				<table class="table table-condensed table-bordered" id="main_tble">
					<caption style="text-align:center;font-size:20px;">
						Membership Offer
					</caption>
					<thead>
						
						<tr>
							<th>Sr</th>
							<th>Plan</th>
							<th>Amount</th>
							<th>Discount %</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Created On</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach($memberships as $data){ 
						$start_date=date('d-M-Y', strtotime($data->start_date));
						$end_date=date('d-M-Y', strtotime($data->end_date));
						 @$k++; ?>
							
							<tr>
								<td><?php echo $k; ?></td>
								<td>
									<?= h(@$data->plan->name) ?>
								</td>
								<td>
									<?= h(@$data->amount) ?>
								</td>
								<td>
									<?= h(@$data->discount_percentage) ?> %
								</td>
								<td>
									<?php echo $start_date; ?>
								</td>	
								<td>	
									<?php echo $end_date; ?>
								</td>
								<td>
									<?= h(@$data->created_on) ?>
								</td>
						<?php  } ?>														 
					</tbody>
				</table>
			</td>
			<td width="50%" valign="top" align="right" style="background-color: rgba(228, 226, 226, 0.38);">
				<table class="table table-condensed  table-bordered" id="main_tble2">
					<caption style="text-align:center;font-size:20px;">Order Details</caption>
					<thead>
						<tr>
								<th>Sr</th>
								<th>Order</th>
								<th>Date</th>
								<th>Order Type</th>
								<th>Promotion</th>
								<th>Total</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach($Orders as $Order){
							@$t++;
							$order_id=$EncryptingDecrypting->encryptData($Order->id);
								?>
								<tr>
									<td><?= $t ?></td>
									<td>
										<?php echo $this->Html->link($Order->order_no,['controller'=>'Orders','action' => 'view', $order_id, 'print'],['target'=>'_blank']); ?>
									</td>
									<td>
										<?= h(date('d-M-Y', strtotime(@$Order->order_date))) ?>
									</td>
									<td>
										<?= h(@$Order->order_type) ?>
									</td>
									<td>
										<?= h(@$Order->promotion_details_Left->coupon_name) ?>
									</td>
									<td>
										<?= h(@$Order->pay_amount) ?>
									</td>
									
									<td>
										<?= h(@$Order->order_status) ?>
									</td>
								</tr>
							<?php } ?>														 
						</tbody>
						</table>
					</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	
	
				<table class="table table-condensed table-bordered" id="main_tble">
					<caption style="text-align:center;font-size:20px;">
						Customer Address Details
					</caption>
					<thead>
						
						<tr>
							<th>Sr</th>
							<th>Receiver Name</th>
							<th>Mobile No</th>
							<th>Location</th>
							<th>House No</th>
							<th>Address</th>
							<th>AREA</th>
							<th>Pincode</th>
							<th>Latitude</th>
							<th>Longitude</th>
							<th>Default Address</th>
							<th>Deleted</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($customeraddresses as $cus_data){
								@$gm++;
								$default_address=$cus_data->default_address;
								if($default_address==1){
									$default_show='<b>Yes</b>';
								}else{
									$default_show='No';
								}
								$is_deleted=$cus_data->is_deleted;
								if($is_deleted==1){
									$delete_show='Yes';
								}else{
									$delete_show='No';
								}
							?>
						
						<tr>
							<td><?php echo @$gm; ?></td>
							<td><?= h(@$cus_data->receiver_name) ?></td>
							<td><?= h(@$cus_data->mobile_no) ?></td>
							<td><?= h(@$cus_data->location->name) ?></td>
							<td><?= h(@$cus_data->house_no) ?></td>
							<td><?= h(@$cus_data->address) ?></td>
							
							<td><?= h(@$cus_data->landmark->name) ?></td>
							<td><?= h(@$cus_data->pincode) ?></td>
							<td><?= h(@$cus_data->latitude) ?></td>
							<td><?= h(@$cus_data->longitude) ?></td>
							<td>
								<center>
									<?php echo $default_show; ?>
								</center>
							</td>
							<td><?= h($delete_show) ?></td>
						</tr>
						<?php } ?>
					<tbody>
				</table>
	 
 
					</div>
				</div>
				 
			</div>
			
		</div>
	</div>                    
	
</div>