<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Balance Sheet'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Balance Sheet</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
						</div> 
					</div> 	
				</div>
				<div class="panel-body">   			
					<div class="row">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
						<div class="form-group">
								
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
				<?php $LeftTotal=0; $RightTotal=0; ?>
				<div class="panel-body">    
					<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr style="background-color: #c4ffbd;">
								<td style="width: 50%;">
									<table width="100%">
										<tbody>
											<tr>
												<td><b>Particulars</b></td>
												<td align="right"><b>Balance</b></td>
											</tr>
										</tbody>
									</table>
								</td>
								<td>
									<table width="100%">
										<tbody>
											<tr>
												<td><b>Particulars</b></td>
												<td align="right"><b>Balance</b></td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<table width="100%">
										<tbody>
											<?php foreach($groupForPrint as $key=>$groupForPrintRow){ 
													
												if(($groupForPrintRow['balance']<0)){ ?>
												<tr>
													<td>
													<a href="#" role='button' status='close' class="group_name" child='no' parent='yes' group_id='<?php  echo $key; ?>' style='color:black;'>
														<?php echo $groupForPrintRow['name']; ?>
															 </a>
													</td>
													<td align="right">
														<?php if($groupForPrintRow['balance']!=0){
															echo $this->Money->moneyFormatIndia(abs($groupForPrintRow['balance']));
															$LeftTotal+=abs($groupForPrintRow['balance']);
														} ?>
													</td>
												</tr>
												<?php } ?>
											<?php } ?>
										</tbody>
									</table>
								</td>
								<td>
									<table width="100%">
										<tbody>
											<?php foreach($groupForPrint as $key=>$groupForPrintRow){ 
												if(($groupForPrintRow['balance']>0)){ ?>
												<tr>
													<td>
													<a href="#" role='button' status='close' class="group_name" child='no' parent='yes' group_id='<?php  echo $key; ?>' style='color:black;'>
														<?php echo $groupForPrintRow['name']; ?>
															 </a>
													</td>
													<td align="right">
														<?php if($groupForPrintRow['balance']!=0){
															echo $this->Money->moneyFormatIndia(abs($groupForPrintRow['balance'])); 
															$RightTotal+=abs($groupForPrintRow['balance']); 
														} ?>
													</td>
												</tr>
												<?php } ?>
											<?php } ?>
												<tr>
													<td>Closing Stock</td>
													<td align="right">
														<?php 
														echo $this->Money->moneyFormatIndia($closingValue); 
														$RightTotal+=abs($closingValue); 
														?>
													</td>
												</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<?php if($GrossProfit!=0){ ?>
							<tr>
								<td>
									<?php 
									if($GrossProfit>0){ ?>
									<table width="100%">
										<tbody>
											<tr>
												<td>Profit & Loss A/c</td>
												<td align="right">
													<?php 
													echo $this->Money->moneyFormatIndia($GrossProfit);
													$LeftTotal+=$GrossProfit;
													?>
												</td>
											</tr>
										</tbody>
									</table>
									<?php } ?>
								</td>
								<td>
									<?php if($GrossProfit<0){ ?>
									<table width="100%">
										<tbody>
											<tr>
												<td>Profit & Loss A/c</td>
												<td align="right">
													<?php 
													echo $this->Money->moneyFormatIndia(abs($GrossProfit)); 
													$RightTotal+=abs($GrossProfit);
													?>
												</td>
											</tr>
										</tbody>
									</table>
									<?php } ?>
								</td>
							</tr>
							<?php } ?>
							<?php if($differenceInOpeningBalance!=0){ ?>
							<tr>
								<td>
									<?php if($differenceInOpeningBalance>0){ ?>
									<table width="100%">
										<tbody>
											<tr>
												<td><span style="color:red;">Difference In Opening Balance</span></td>
												<td align="right">
													<?php 
													echo $this->Money->moneyFormatIndia(abs($differenceInOpeningBalance)); 
													$LeftTotal+=abs($differenceInOpeningBalance);
													?>
												</td>
											</tr>
										</tbody>
									</table>
									<?php } ?>
								</td>
								<td>
									<?php if($differenceInOpeningBalance<0){ ?>
									<table width="100%">
										<tbody>
											<tr>
												<td><span style="color:red;">Difference In Opening Balance</span></td>
												<td align="right">
													<?php 
													echo $this->Money->moneyFormatIndia(abs($differenceInOpeningBalance)); 
													$RightTotal+=abs($differenceInOpeningBalance);
													?>
												</td>
											</tr>
										</tbody>
									</table>
									<?php } ?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td>
									<table width="100%">
										<tbody>
											<tr>
												<td><b>Total</b></td>
												<td align="right"><b><?php echo $this->Money->moneyFormatIndia($LeftTotal); ?></b></td>
											</tr>
										</tbody>
									</table>
								</td>
								<td>
									<table width="100%">
										<tbody>
											<tr>
												<td><b>Total</b></td>
												<td align="right"><b><?php echo $this->Money->moneyFormatIndia($RightTotal); ?></b></td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tfoot>
					</table>
					
					
					
					</div>
				</div>
			</div>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>