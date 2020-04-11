<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Selleer Order'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>SELLER WISE ITEM REPORT</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
						</div> 
					</div> 	
				</div>
				<div class="panel-body">   			
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						<div class="form-group">
								<!--<div class="col-md-2 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> Location </span>
										<?php echo $this->Form->select('location_id',$Locations, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$location_id]); ?>
										</div>
								</div>-->
								<div class="col-md-2 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> Sellers </span>
										<?php echo $this->Form->select('seller_id',$Sellers, ['empty'=>'JainThela','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$seller_id]); ?>
										</div>
								</div>
								
								<div class="col-md-4 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> FROM </span>
										<?= $this->Form->control('from_date',['class'=>'form-control datepicker','placeholder'=>'From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($from_date))]) ?>
										<span class="input-group-addon add-on"> TO </span>
										<?= $this->Form->control('to_date',['class'=>'form-control datepicker','placeholder'=>'To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($to_date))]) ?>
										</div>
								</div>
							<div class="input-group-btn">
								<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary']) ?>
							</div>
						</div>
						
						<?= $this->Form->end() ?>
					</div>
				</div>  
				<?php $LeftTotal=0; $RightTotal=0;
				if($orders){
					 ?>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Order No') ?></th>
									<th><?= ('Party') ?></th>
									<th><?= ('GST No') ?></th>
									<th><?= ('Transaction Date') ?></th>
									<th><?= ('Location') ?></th>
									<th><?= ('Details') ?></th>
									
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; $total_sales_amount=0; $total_gst_amount=0; $total_amount=0;?>
								  <?php foreach ($orders as $order): 
								  $order_id = $EncryptingDecrypting->encryptData($order->id);
								  ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?php echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'view', $order_id],['target'=>'_blank']); ?></td>
									<td><?= h($order->party_ledger->name) ?></td>
									<td><?= h(@$order->party_ledger->customer_data->gstin) ?></td>
									<td><?= h(date("d-m-Y",strtotime($order->transaction_date))) ?></td>
									<td><?= h($order->location->name) ?></td>
									<td>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th><?= ('SNo.') ?></th>
													<th><?= ('Item') ?></th>
													<th><?= ('Taxable') ?></th>
													<th><?= ('GST') ?></th>
													<th><?= ('Amount') ?></th>
													
												</tr>
											</thead>
											<tbody>
												<?php $p=1; $ttl=0;  foreach($order->order_details as $data){  
													if($data->item_variation){
												?>
														<tr>
															<td style="width:10px;"><?= h($p++) ?></td>
															<td style="width:150px;"><?php echo $data->item->name; ?> (<?= h($data->item_variation->unit_variation->visible_variation) ?> ) </td>
															<td style="width:100px;"><?= h($data->taxable_value) ?></td>
															<td style="width:100px;"><?php echo $data->gst_value.'  ('.$data->gst_percentage;?>% )</td>
															<td style="width:100px;"><?= h($data->net_amount) ?></td>
															
														</tr>
													<?php
														$total_sales_amount+=$data->amount;
														$total_gst_amount+=$data->gst_value;
														$total_amount+=$data->amount+$data->gst_value;
														$ttl+=$data->amount+$data->gst_value;
													?>
													
													<?php }  ?>
													<?php }  ?>
													<tr></tr>
														<td colspan="4" align="right">Total</td>
														<td align="left" style="width:110px;"><b><?php echo $this->Money->moneyFormatIndia($order->pay_amount,2); ?></b></td>
													<tr></tr>
											</tbody>
										</table>
									</td>
									
								</tr>
								  <?php endforeach; ?>
							</tbody>
							<tfoot>
								<?php if($total_sales_amount > 0){ ?>
								<tr>
									<td colspan="6" align="right"><b>Total</b></td>
									<td  align="center">
										<table class="">
											<thead>
												<tr>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													
												</tr>
											</thead>
											<tbody>
													<tr>
														<td align="right" style="width:205px;" colspan="2" ></td>
														<td align="left" style="width:110px;"><b><?php echo $this->Money->moneyFormatIndia($total_sales_amount,2); ?></b></td>
														<td align="center" style="width:120px;"><b><?php echo $this->Money->moneyFormatIndia($total_gst_amount,2); ?></b></td>
														<td align="right" style="width:100px;"><b><?php echo $this->Money->moneyFormatIndia($total_amount,2); ?></b></td>
													</tr>
													
											</tbody>
										</table>
									</td>
									
								</tr>
								<?php } ?>
							</tfoot>
						</table>
					</div>
				</div>
						
			<?php }   ?>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>