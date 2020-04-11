<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Expiry Report'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Expiry Report</strong></h3>
					<div class="pull-right">
						<div class="pull-left"">
						</div> 
					</div> 	
				</div>
				<div class="panel-body">   			
					<div class="row">
						<div class="col-md-9"></div>
						<div class="col-md-2">Expired In <?php echo $day_no; ?> days</div>
						<div class="col-md-1" style=" background-color: #f27c41; width: 20px;height: 20px;border: 1px; padding: 1px; margin: 1px;">
						</div> 
					</div>
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						

						<div class="col-md-2">
							<div class="form-group">
								<label></label>
								<?php echo $this->Form->select('location_id',$Locations, ['label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$location_id]); ?>
								
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label></label>
								<?php echo $this->Form->select('item_variation_id',$listItems, ['empty'=>'--Select Item--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$item_variation_id]); ?>
								
							</div>
						</div>
						
						
						<div class="col-md-2">
							<div class="form-group">
								<label></label>
								<?php 
								$days=[['text'=>'3 days','value'=>3],['text'=>'5 days','value'=>5],['text'=>'7 days','value'=>7],['text'=>'10 days','value'=>10],['text'=>'15 days','value'=>15]];
								echo $this->Form->select('day_no',$days, ['empty'=>'--Select Item--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$day_no]); ?>
								
							</div>
						</div>
						
						
						
						<div class="col-md-3">
							<div class="form-group">
								<label></label></br/>
								<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary','label'=>false]) ?>
							</div>
						</div>
						
						<?= $this->Form->end() ?>
					</div>
				</div>  
				<?php if(!empty($itemStock)){ ?>
					<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Item') ?></th>
									<th><?= ('Details') ?></th>
									
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; $total_sales_amount=0; $total_gst_amount=0; $total_amount=0;?>
								  <?php foreach ($itemStock as $key=>$Data): 
								  ?>
								  <?php if($Data){ ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									
									<td><?= h($itemName[$key]) ?></td>
									
									<td>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th><?= ('SNo.') ?></th>
													<th><?= ('Qty') ?></th>
													<th><?= ('Rate') ?></th>
													<th><?= ('Expiry Date') ?></th>
													
												</tr>
											</thead>
											<tbody>
												<?php $p=1;  foreach($Data as $data1){  
														$td=date('d-m-Y'); 
														$sevendays=$day_no; 
														$expiryDays= date('d-m-Y', strtotime($td. ' + '.$sevendays.' days'));
														$edate=date('d-m-Y',strtotime(($data1['expiry_date'])));
														
														$ed=strtotime($edate);
														$tdsevenDays=strtotime($expiryDays);
														
														if($ed <= $tdsevenDays){
															/* pr($edate);
															pr($expiryDays);exit; */
													?>
														<tr style="background-color:#f27c41">
															<td style="width:10px;background-color: #f27c41;color: white;"><?= h($p++) ?></td>
															<td style="width:150px;background-color: #f27c41;color: white;"><?= h($data1['qty']) ?></td>
															<td style="width:100px;background-color: #f27c41;color: white;"><?= h($data1['rate']) ?></td>
															
															<td style="width:100px;background-color: #f27c41;color: white;">
															<?php echo date('d-m-Y',strtotime(($data1['expiry_date']))); ?>
															</td>
														</tr>
													<?php }else{  ?>
														<tr>
															<td style="width:10px;"><?= h($p++) ?></td>
															<td style="width:150px;"><?= h($data1['qty']) ?></td>
															<td style="width:100px;"><?= h($data1['rate']) ?></td>
															
															<td style="width:100px;">
															<?php echo date('d-m-Y',strtotime(($data1['expiry_date']))); ?>
															
															</td>
														</tr>
													<?php } ?>
												<?php  } ?>
											</tbody>
										</table>
									</td>
								</tr>
								<?php } ?>
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
				<?php } ?>
			</div>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>