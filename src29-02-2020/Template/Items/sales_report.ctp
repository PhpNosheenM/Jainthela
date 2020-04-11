<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}

</style>
<?php $this->set('title', 'Sales Report'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>SALES REPORT</strong></h3>
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
									<span class="input-group-addon add-on"> Location </span>
										<?php echo $this->Form->select('location_id',$Locations, ['empty'=>'--Select--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>$location_id]); ?>
										</div>
								</div>
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
				if($orders){
					if($gst_figure_id){ ?>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th style="text-align:center;"><?= ('SNo.') ?></th>
									<th style="text-align:center;"><?= ('Invoice No') ?></th>
									<th style="text-align:center;"><?= ('Transaction Date') ?></th>
									<th style="text-align:center;"><?= ('Party') ?></th>
									<th style="text-align:center;"><?= ('GST No') ?></th>
									<th style="text-align:center;"><?= ('GST Rate') ?></th>
									<th style="text-align:center;"><?= ('Taxable Amount') ?></th>
									<th style="text-align:center;"><?= ('GST Amount') ?></th>
									
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; $total_sales_amount=0; $total_gst_amount=0; $total_amount=0;?>
								  <?php foreach ($orders as $order): //pr($order); exit;
								  ?>
								<tr>
									<td align="center"><?= $this->Number->format(++$i) ?></td>
									<td align="center"><?php //echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'view', $order->id],['target'=>'_blank']);
										echo $order->invoice_no;
										?></td>
									<td align="center"><?= h(date("d-m-Y",strtotime($order->transaction_date))) ?></td>
									<td align="center"><?= h($order->party_ledger->name) ?></td>
									<td align="center"><?= h(@$order->party_ledger->customer_data->gstin) ?></td>
									<td align="right"><?= h($order->invoice_rows[0]->gst_figure->name) ?></td>
									
									<td align="right">
										<!--<table class="table table-bordered">
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
												
											</tbody>
										</table>-->
										
										<?php $p=1; $Total_taxable=0; $Total_tax=0;  foreach($order->invoice_rows as $data){  ?>
													<?php
														$Total_tax+=$data->gst_value;;
														$Total_taxable+=$data->taxable_value;;
														$total_sales_amount+=$data->taxable_value;
														$total_gst_amount+=$data->gst_value;
														//$total_amount+=$data->amount+$data->gst_value;
													?>
												<?php  } ?>
										<?= h(@$Total_taxable) ?>
										
									</td>
									<td align="right">
									<?= h(@$Total_tax) ?>
									</td>
									
								</tr>
								  <?php endforeach; ?>
							</tbody>
							<tfoot>
								<?php if($total_sales_amount > 0){ ?>
								<tr>
									<td colspan="6" align="right"><b>Total</b></td>
									<td align="right" style="width:110px;"><b><?php echo $this->Money->moneyFormatIndia($total_sales_amount,2); ?></b></td>
									<td align="right" style="width:120px;"><b><?php echo $this->Money->moneyFormatIndia($total_gst_amount,2); ?></b></td>
									
								</tr>
								<?php } ?>
							</tfoot>
						</table>
					</div>
				</div>
						
					<?php }else{ 
				?>
				<div class="panel-body">    
					<div class="table">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Invoice No') ?></th>
									<th style=""><?= ('Order No') ?></th>
									<th><?= ('Party') ?></th>
									<th style=""><?= ('GST No') ?></th>
									<th><?= ('Transaction Date') ?></th>
									<th><?= ('Taxable Amount') ?></th>
									<th><?= ('GST') ?></th>
									<th><?= ('Total') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php 
								$other=0;
								$TotalSellerWise=[];
								$totalGstPerWise=[];
								$totalTaxableGstPerWise=[];
								$i = 0; $total_sales_amount=0; $total_gst_amount=0; $total_amount=0;?>
								  <?php foreach ($orders as $order):  //pr($order->order->order_no); exit;
									if($order->seller_id==3)
											{
												@$TotalSellerWise[$order->seller_id]+=$order->grand_total;
												$order->BgColor = 'style="background: green;color: white;"';
												
											}else if(empty($order->seller_id))
											{
												@$TotalSellerWise[0]+=@$order->grand_total;
												$order->BgColor = '';
											}else 
											{
												@$other+=@$order->grand_total;
												$order->BgColor = '';
											}
									?>
								
								<tr height="40px"  >
									<td <?php echo $order->BgColor; ?>><?= $this->Number->format(++$i) ?></td>
									<td <?php echo $order->BgColor; ?>><?php //echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'view', $order->id],['target'=>'_blank']);
										echo $order->invoice_no;
										?></td>
									<td <?php echo $order->BgColor; ?>><?= h($order->order->order_no) ?></td>
									<td <?php echo $order->BgColor; ?>><?= h($order->party_ledger->name) ?></td>
									<td align="center" <?php echo $order->BgColor; ?>><?= h(@$order->party_ledger->customer_data->gstin) ?></td>
									<td <?php echo $order->BgColor; ?>><?= h(date("d-m-Y",strtotime($order->transaction_date))) ?></td>
									<td <?php echo $order->BgColor; ?>><?php echo $this->Money->moneyFormatIndia($order->total_amount,2); ?></td>
									<td <?php echo $order->BgColor; ?>><?php echo $this->Money->moneyFormatIndia($order->total_gst,2); ?></td>
									<td <?php echo $order->BgColor; ?>><?php echo $this->Money->moneyFormatIndia($order->grand_total,2); ?></td>
									<?php
										$total_sales_amount+=$order->total_amount;
										$total_gst_amount+=$order->total_gst;
										$total_amount+=$order->grand_total;
									?>
								</tr>
								<?php endforeach; ?>
							</tbody>
							<tfoot>
								<?php if($total_sales_amount > 0){ ?>
								<tr>
									<td colspan="4" align="right"><b>Total</b></td>
									<td><b><?php echo $this->Money->moneyFormatIndia($total_sales_amount,2); ?></b></td>
									<td><b><?php echo $this->Money->moneyFormatIndia($total_gst_amount,2); ?></b></td>
									<td><b><?php echo $this->Money->moneyFormatIndia($total_amount,2); ?></b></td>
								</tr>
								<?php } ?>
							</tfoot>
						</table>
					</div>
				</div>
				<?php } } ?>
				<div class="panel-body">    
					<div class="table">
						<table class="table table-bordered" style="width:310px;">
							<tr>
								<td style="background: green;color: white;">Fruits And Vegitables</td>
								<td style="background: green;color: white;"><?php echo @$TotalSellerWise[3]; ?></td>
							</tr>
							<tr>
								<td>Grocery</td>
								<td><?php echo @$TotalSellerWise[0]; ?></td>
							</tr>
							<tr>
								<td>Others</td>
								<td><?php echo @$other; ?></td>
							</tr>
						</table>
					</div>
				</div>
				
				
			<!--	<?php if((!empty($location_id)) && (empty($gst_figure_id))){ ?>
				<div class="panel-body">    
					<div class="table-responsive">GST
						<table class="table table-bordered">
							<tr>
								<?php foreach($GstFiguresData as $GstFigure){ ?>
									<td align="center" colspan="3"><?php echo $GstFigure->tax_percentage; ?>%</td>
								<?php } ?>
									<td align="center" colspan="3">Total</td>
							</tr>
							<tr>
								<td >Taxable</td>
								<td >CGST</td>
								<td >SGST</td>
								<td >Taxable</td>
								<td >CGST</td>
								<td >SGST</td>
								<td >Taxable</td>
								<td >CGST</td>
								<td >SGST</td>
								<td >Taxable</td>
								<td >CGST</td>
								<td >SGST</td>
								<td >Taxable</td>
								<td >CGST</td>
								<td >SGST</td>
								<td >Total Taxable</td>
								<td >Total CGST</td>
								<td >Total SGST</td>
							</tr>
							<tr>
								<?php $totalTax=0;$totalTaxable=0; foreach($GstFiguresData as $GstFigure){ ?>
								
									<?php if(empty(@$TotalgstTaxable[$GstFigure->id])){ ?>
										<td>-</td>
										<td>-</td>
										<td>-</td>
									<?php }else{ ?>
									<td><?php echo @$TotalgstTaxable[$GstFigure->id]; ?></td>
									<td><?php echo @$TotalgstTax[$GstFigure->id]/2; ?></td>
									<td><?php echo @$TotalgstTax[$GstFigure->id]/2; ?></td>
									
								<?php 
									$totalTax+=@$TotalgstTax[$GstFigure->id];
									$totalTaxable+=@$TotalgstTaxable[$GstFigure->id];
								} } ?>
									<td><?php echo @$totalTaxable; ?></td>
									<td><?php echo @$totalTax/2; ?></td>
									<td><?php echo @$totalTax/2; ?></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="panel-body">    
					<div class="table-responsive">IGST
						<table class="table table-bordered">
							<tr>
								<?php foreach($GstFiguresData as $GstFigure){ ?>
									<td align="center" colspan="2"><?php echo $GstFigure->tax_percentage; ?>%</td>
								<?php } ?>
									<td align="center" colspan="2">Total</td>
							</tr>
							<tr>
								<td >Taxable</td>
								<td >IGST</td>
								<td >Taxable</td>
								<td >IGST</td>
								<td >Taxable</td>
								<td >IGST</td>
								<td >Taxable</td>
								<td >IGST</td>
								<td >Taxable</td>
								<td >IGST</td>
								<td >Total Taxable</td>
								<td >Total IGST</td>
							</tr>
							<tr>
								<?php  $totalTax=0;$totalTaxable=0;  foreach($GstFiguresData as $GstFigure){ ?>
								
									<?php if(empty(@$TotalIgstTaxable[$GstFigure->id])){ ?>
										<td>-</td>
										<td>-</td>
									<?php }else{ ?>
									<td><?php echo @$TotalIgstTaxable[$GstFigure->id]; ?></td>
									<td><?php echo @$TotalIgstTax[$GstFigure->id]; ?></td>
									
								<?php 
									$totalTax+=@$TotalIgstTax[$GstFigure->id];
									$totalTaxable+=@$TotalIgstTaxable[$GstFigure->id];
								} } ?>
									<td><?php echo @$totalTaxable; ?></td>
									<td><?php echo @$totalTax; ?></td>
									
							</tr>
						</table>
					</div>
				</div>
				
				<?php }  ?>-->
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>