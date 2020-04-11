<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Purchase Order'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Purchase Order</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
						</div> 
					</div> 	
				</div>
				<div class="panel-body">   			
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						<div class="form-group">
								<div class="col-md-3 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> Location </span>
										<?php echo $this->Form->select('location_id',$Locations, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$location_id]); ?>
										</div>
								</div>
								
								<div class="col-md-3 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> Sellers </span>
										<?php echo $this->Form->select('seller_id',$Sellers, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$seller_id]); ?>
										</div>
								</div>
								
								<div class="col-md-3 col-xs-12">
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
				if(sizeof($orders->toArray()) > 0){ 
				?>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Invoice No') ?></th>
									<th><?= ('Transaction Date') ?></th>
									<th><?= ('Location') ?></th>
									<th><?= ('Details') ?></th>
									
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; $total_sales_amount=0; $total_gst_amount=0; $total_amount=0;?>
								  <?php foreach ($orders as $order): 
								  if(sizeof($order->order_details) > 0){
								  ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?php echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'view', $order->id],['target'=>'_blank']); ?></td>
									<td><?= h(date("d-m-Y",strtotime($order->transaction_date))) ?></td>
									<td><?= h($order->location->name) ?></td>
									<td>
										<table class="table table-bordered" style="background-color:white;">
											<thead >
												<tr >
													<th style="background-color:white;"><?= ('SNo.') ?></th>
													<th style="background-color:white;"><?= ('Seller') ?></th>
													<th style="background-color:white;"><?= ('Item') ?></th>
													<th style="background-color:white;"><?= ('quantity') ?></th>
												</tr>
											</thead>
											<tbody>
												<?php $p=1;  foreach($order->order_details as $data){ //pr($data->item_variation); exit;  ?>
														<tr>
															<td style="width:10px; background-color:white;"><?= h($p++) ?></td>
															<?php if(@$data->item_variation->sellers_data->name){ ?>
															<td style="width:150px; background-color:white;"><?= h($data->item_variation->sellers_data->name) ?></td>
															<?php }else{ ?>
															<td style="width:150px; background-color:white;"><?php echo "JainThela"; ?></td>
															<?php } ?>
															<td style="width:100px; background-color:white;"><?= h($data->item->name) ?></td>
															<td style="width:100px; background-color:white;	"><?= h($data->quantity) ?></td>
															
														</tr>
													
												<?php  } ?>
											</tbody>
										</table>
									</td>
									
								</tr>
								  <?php } endforeach; ?>
							</tbody>
							<tfoot>
								
							</tfoot>
						</table>
					</div>
				</div>
				<?php } else {?>
				<div class="row">
					<div class="col-md-10">
					No Result Found
					</div>
				</div> 
				<?php } ?>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>