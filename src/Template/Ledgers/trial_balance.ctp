<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Trial Balance'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Trial Balance</strong></h3>
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
										<?= $this->Form->control('from_date',['class'=>'form-control datepicker','placeholder'=>'From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date("d-m-Y",strtotime($from_date))]) ?>
										<span class="input-group-addon add-on"> TO </span>
										<?= $this->Form->control('to_date',['class'=>'form-control datepicker','placeholder'=>'To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date("d-m-Y",strtotime($to_date))]) ?>
								</div>
							</div>
							<div class="input-group-btn">
								<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary']) ?>
							</div>
						</div>
						
						<?= $this->Form->end() ?>
					</div>
				</div>  
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered  table-condensed" width="100%">
					<thead>
						<tr>
							<th scope="col" width="25%"></th>
							<th width="25%" scope="col" colspan="2" style="text-align:center";>Opening Balance</th>
							<th width="25%" scope="col" colspan="2" style="text-align:center";>Transactions</th>
							<th width="25%" scope="col" colspan="2" style="text-align:center";>Closing balance</th>
						</tr>
						<tr>
							<th scope="col">Ledgers</th>
							<th scope="col" style="text-align:center";>Debit</th>
							<th scope="col" style="text-align:center";>Credit</th>
							<th scope="col" style="text-align:center";>Debit</th>
							<th scope="col" style="text-align:center";>Credit</th>
							<th scope="col" style="text-align:center";>Debit</th>
							<th scope="col" style="text-align:center";>Credit</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$openingBalanceDebitTotal=0;
							$openingBalanceCreditTotal=0;
							$transactionDebitTotal=0;
							$transactionCreditTotal=0;
							$closingBalanceDebitTotal=0;
							$closingBalanceCreditTotal=0;
							$total1=0;
							$total2=0;
							
							foreach($ClosingBalanceForPrint as $key=>$ClosingBalance)
							{ //pr(@$OpeningBalanceForPrint[$key]['balance']);
								    $closing_credit=0;
									$closing_debit=0;
							?>
									<tr>
										<td style="width:200px"><a href="#" role='button' status='close' class="group_name" child='no' parent='yes' group_id='<?php  echo $key; ?>' style='color:black;'>
														<?php echo $ClosingBalance['name']; ?>
															 </a>
													</td>
										<?php if(@$OpeningBalanceForPrint[$key]['balance'] > 0){ ?>
										<td scope="col" align="right">
										<?php
										
											echo abs($OpeningBalanceForPrint[$key]['balance']);
											$openingBalanceDebitTotal +=abs($OpeningBalanceForPrint[$key]['balance']);
										?>
										</td>
										<td scope="col" align="right">-</td>
										<?php } else{ ?>
										<td scope="col" align="right">-</td>
										<td scope="col" align="right">
										<?php
										
											echo abs(@$OpeningBalanceForPrint[$key]['balance']);
											$openingBalanceCreditTotal +=abs($OpeningBalanceForPrint[$key]['balance']);
										?>
										</td>
										<?php }?>
										<td scope="col" align="right">
										<?php echo abs(@$TransactionsDr[$key]['balance']); ?>
										</td>
										<td scope="col" align="right">
										<?php echo abs(@$TransactionsCr[$key]['balance']); ?>
										</td>
										<?php if(@$ClosingBalance['balance'] > 0){ ?>
										<td scope="col" align="right">
										<?php
										
											echo abs($ClosingBalance['balance']);
											$closingBalanceDebitTotal+=abs($ClosingBalance['balance']);
										?>
										</td>
										<td scope="col" align="right">-</td>
										<?php } else{ ?>
										<td scope="col" align="right">-</td>
										<td scope="col" align="right">
										<?php
										
											echo abs($ClosingBalance['balance']);
											$closingBalanceCreditTotal +=abs($ClosingBalance['balance']);
										?>
										</td>
										<?php }?>
									</tr>
						<?php } ?>
							
					
					</tbody>
					<tfoot>
						
						<tr>
							
							<th colspan="5" style="text-align:left";>Opening Stock</th>
							<th  style="text-align:right";>
								<?php echo $openingValue; ?>
							</th>
							<th style="text-align:right";></th>
						</tr>
						<tr style="color:red;">
							<th colspan="5" style="text-align:left";>Diffrence of opening balance</th>
							
								<?php if($openingBalanceDebitTotal>@$openingBalanceCreditTotal)
									{
										$cedit_diff = $openingBalanceDebitTotal-@$openingBalanceCreditTotal;?>
										<th  style="text-align:right";>
										</th>
										<th style="text-align:right";><?php echo @$cedit_diff; ?></th>
										
								<?php } else {  
									 ?>
										
										<th style="text-align:right";><?php echo @$cedit_diff; ?></th>
										<th  style="text-align:right";>
										</th>
								<?php } ?>
							
						</tr>
						<tr>
							<th colspan="5" style="text-align:left";>Total</th>
							
							<th scope="col" style="text-align:right";>
							<?php echo @$closingBalanceDebitTotal; ?>
							</th>
							<th scope="col" style="text-align:right";>
							<?php echo round(@$closingBalanceCreditTotal,2); ?>
							</th>
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