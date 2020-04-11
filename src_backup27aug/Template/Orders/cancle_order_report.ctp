<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Cancel Item'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>CANCEL ITEM REPORT</strong></h3>
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
								</div>
								<div class="col-md-2 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> Sellers </span>
										<?php echo $this->Form->select('seller_id',$Sellers, ['empty'=>'JainThela','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$seller_id]); ?>
										</div>
								</div>-->
								
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
									<th><?= ('Customer') ?></th>
									<th><?= ('Order Type') ?></th>
									<th><?= ('Order Date') ?></th>
									<th><?= ('Location') ?></th>
									<th><?= ('Details') ?></th>
									<?php if($location_id){ ?>
									<th><?= ('Action') ?></th>
									<?php } ?>
									
									
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; $total_sales_amount=0; $total_gst_amount=0; $total_amount=0;?>
								  <?php foreach ($orders as $order): //pr($order); exit;
								  if($order->order_details){
								  $order_id = $EncryptingDecrypting->encryptData($order->id);
								  ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?php echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'view', $order_id],['target'=>'_blank']); ?></td>
									<td><?= h($order->customer->name) ?></td>
									<td><?= h($order->order_type) ?></td>
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
												<?php $p=1; $ttl=0;  
												foreach($order->order_details as $data){ 
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
														$ttl+=$data->net_amount;
													?>
													
													
													<?php }  ?>
													<tr></tr>
														<td colspan="4" align="right">Total</td>
														<td align="left" style="width:110px;"><b><?php echo $this->Money->moneyFormatIndia($ttl,2); ?></b></td>
													<tr></tr>
											</tbody>
										</table>
									</td>
									<?php if($location_id){ ?>
									<td>
									<?php 
									 $order_id = $EncryptingDecrypting->encryptData($order->id); 
									echo $this->Html->link( ' <span class="fa fa-pencil"> Create New Order </span>', '/Orders/Add?order_id='.$order_id.'&&status=cancel',['class' =>'btn btn-primary  btn-condensed btn-sm','target'=>'_blank','escape'=>false]); ?>
									
									</td>
									 <?php }  ?>
								</tr>
								  <?php } endforeach; ?>
							</tbody>
							<tfoot>
								
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