<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Payable Report'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Payable Report</strong></h3>
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
									
										<span class="input-group-addon add-on"> Date </span>
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
									<?php
				if(!empty($reference_details))
				{
				?>
					<table class="table table-bordered  table-condensed" width="100%" border="1">
						<thead>
							<tr>
								<th scope="col"> Transaction Date </th>
								<th scope="col">Reference Name</th>
								<th scope="col">Party</th>
								<th scope="col">Over Due Days</th>
								<th scope="col">Pending Amount</th>
							</tr>
						</thead>
						<tbody><?php $sno = 1;  $total_pending_amt=0;
							if($to_date){
								  foreach ($reference_details as $reference_detail): //pr($reference_detail);
									$duebalance = $reference_detail->total_debit - $reference_detail->total_credit;
									if($duebalance > 0)
									{ ?>
										<tr >
											<td><?php echo $reference_detail->transaction_date; ?></td>
											<td><?= $reference_detail->ref_name ?></td>
											<td><?php echo $reference_detail->ledger->name; ?></td>
											<td><?php 
											$due_days=$reference_detail->due_days;
											if(empty($due_days)){
											$due_days=0;	
											}
											$ref_date = date('Y-m-d',strtotime($reference_detail->transaction_date));
											$ref_date_add_days= date('Y-m-d', strtotime($ref_date.'+' .$due_days.'days'));
											$ref_date_create =  date_create($ref_date_add_days );
											$run_time_date_create = date_create($to_date);
											
											$diff=date_diff($ref_date_create,$run_time_date_create);
											$diff_val =$diff->format("%R%a");
											if($diff_val>0){
											echo $diff->format("%a days");
											}else { echo '0 days';}
											?></td>
											<td class="rightAligntextClass"><?php echo $this->Money->moneyFormatIndia($duebalance);  ?></td>
											<?php $total_pending_amt+=$duebalance; ?>
										</tr>
							<?php } endforeach;  } ?>
						</tbody>
						<tfoot>
							
							<tr>
								<td scope="col" colspan="4" style="text-align:right";><b>Closing Balance</b></td>
								<td class="rightAligntextClass"><?php echo $this->Money->moneyFormatIndia($total_pending_amt);  ?></td>
								
							</tr>
						</tfoot>
					</table>
				<?php } ?>
					
					
					
					</div>
				</div>
			</div>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>