<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Purchase Report'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>PURCHASE REPORT</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
						</div> 
					</div> 	
				</div>
				<div class="panel-body">   			
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						<div class="form-group">
								<div class="col-md-2 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> Gst </span>
										<?php echo $this->Form->select('gst_figure_id',$GstFigures, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$gst_figure_id]); ?>
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
				if($gst_figure_id){ ?>
					<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Invoice No') ?></th>
									<th><?= ('Party') ?></th>
									<th><?= ('Transaction Date') ?></th>
									<th><?= ('Details') ?></th>
									
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; $total_sales_amount=0; $total_gst_amount=0; $total_amount=0;?>
								  <?php foreach ($PurchaseInvoices as $order): 
								  ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?php echo $this->Html->link($order->invoice_no,['controller'=>'PurchaseInvoices','action' => 'view', $order->id],['target'=>'_blank']); ?></td>
									<td><?= h($order->seller_ledger->name) ?></td>
									<td><?= h(date("d-m-Y",strtotime($order->transaction_date))) ?></td>
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
												<?php $p=1;  foreach($order->purchase_invoice_rows as $data){  ?>
														<tr>
															<td style="width:10px;"><?= h($p++) ?></td>
															<td style="width:150px;"><?= h($data->item->name) ?></td>
															<td style="width:100px;"><?= h($data->amount) ?></td>
															<td style="width:100px;"><?php echo $data->gst_value.'  ('.$data->gst_percentage;?>% )</td>
															<td style="width:100px;"><?= h($data->net_amount) ?></td>
															
														</tr>
													<?php
														$total_sales_amount+=$data->amount;
														$total_gst_amount+=$data->gst_value;
														$total_amount+=$data->amount+$data->gst_value;
													?>
												<?php  } ?>
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
				<?php } else {?>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Invoice No') ?></th>
									<th><?= ('Party') ?></th>
									<th><?= ('GST No') ?></th>
									<th><?= ('Transaction Date') ?></th>
									<th><?= ('Taxable Amount') ?></th>
									<th><?= ('GST') ?></th>
									<th><?= ('Total') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; $total_sales_amount=0; $total_gst_amount=0; $total_amount=0;?>
								  <?php foreach ($PurchaseInvoices as $order): //pr($order); exit; ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?php echo $this->Html->link($order->invoice_no,['controller'=>'Orders','action' => 'view', $order->id],['target'=>'_blank']); ?></td>
									<td><?= h($order->seller_ledger->name) ?></td>
									<td><?= h(@$order->seller_ledger->seller_data->gstin) ?></td>
									<td><?= h(date("d-m-Y",strtotime($order->transaction_date))) ?></td>
									<td><?php echo $this->Money->moneyFormatIndia($order->total_taxable_value,2); ?></td>
									<td><?php echo $this->Money->moneyFormatIndia($order->total_gst,2); ?></td>
									<td><?php echo $this->Money->moneyFormatIndia($order->total_amount,2); ?></td>
									<?php
										$total_sales_amount+=$order->total_taxable_value;
										$total_gst_amount+=$order->total_gst;
										$total_amount+=$order->total_amount;
									?>
								</tr>
								<?php endforeach; ?>
							</tbody>
							<tfoot>
								<?php if($total_sales_amount > 0){ ?>
								<tr>
									<td colspan="5" align="right"><b>Total</b></td>
									<td><b><?php echo $this->Money->moneyFormatIndia($total_sales_amount,2); ?></b></td>
									<td><b><?php echo $this->Money->moneyFormatIndia($total_gst_amount,2); ?></b></td>
									<td><b><?php echo $this->Money->moneyFormatIndia($total_amount,2); ?></b></td>
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
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>