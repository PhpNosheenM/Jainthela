<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Profit and Loss Statement'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Trading Report & Profit and Loss Statement</strong></h3>
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
					<table style="margin-top:20px" class="table table-bordered">
						<thead>
							<tr style="background-color: #c4ffbd;">
								<td width="50%">
									<table width="100%">
										<tbody>
											<tr>
												<td><b>Particulars</b></td>
												<td align="right"><b>Amount</b></td>
											</tr>
										</tbody>
									</table>
								</td>
								<td width="50%">
									<table width="100%">
										<tbody>
											<tr>
												<td><b>Particulars</b></td>
												<td align="right"><b>Amount</b></td>
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
											<?php if($openingValue>=0) { ?>
												<tr>
													<td>Opening Stock</td>
													<td align="right">
														<?php 
														echo $openingValue;
														$LeftTotal+=$openingValue;
														?>
													</td>
												</tr>
											<?php } ?>
											<?php foreach($groupForPrint as $key=>$groupForPrintRow){ 
												if(($groupForPrintRow['balance']>0) or ($groupForPrintRow['balance']==0 && $groupForPrintRow['nature']==4)){
													if($groupForPrintRow['name']=="Indirect Expenses"){
													
													} else{?>
												<tr>
													<td><a href="#" role='button' status='close' class="group_name" child='no' parent='yes' group_id='<?php  echo $key; ?>' style='color:black;'>
														<?php echo $groupForPrintRow['name']; ?>
															 </a></td>
													<td align="right">
														<?php if($groupForPrintRow['balance']!=0){
															echo (abs($groupForPrintRow['balance']));
															$LeftTotal+=abs($groupForPrintRow['balance']);
														} ?>
													</td>
												</tr>
												<?php } } ?>
											<?php } ?>
										</tbody>
									</table>
								</td>
								<td>
									<table width="100%">
										<tbody>
											<?php if($openingValue<0) { ?>
												<tr>
													<td>Opening Stock</td>
													<td align="right">
														<?php 
														echo ($openingValue);
														$RightTotal+=$openingValue;
														?>
													</td>
												</tr>
											<?php } ?>
											<?php foreach($groupForPrint as $groupForPrintRow){ 
												if(($groupForPrintRow['balance']<0) or ($groupForPrintRow['balance']==0 && $groupForPrintRow['nature']==3)){ 
												if($groupForPrintRow['name']=="Indirect Incomes" ||$groupForPrintRow['name']=="Direct Incomes"){
													} else{
												?>
												<tr>
													<td><a href="#" role='button' status='close' class="group_name" child='no' parent='yes' group_id='<?php  echo $key; ?>' style='color:black;'>
														<?php echo $groupForPrintRow['name']; ?>
															 </a></td>
													<td align="right">
														<?php if($groupForPrintRow['balance']!=0){
															echo (abs($groupForPrintRow['balance'])); 
															$RightTotal+=abs($groupForPrintRow['balance']); 
														} ?>
													</td>
												</tr>
												<?php } } ?>
											<?php } ?>
												<tr>
													<td>Closing Stock</td>
													<td align="right">
														<?php 
														echo ($closingValue); 
														$RightTotal+=$closingValue; 
														?>
													</td>
												</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr >
								<td>
									<?php 
									$totalDiff=$RightTotal-$LeftTotal;
									if($totalDiff>=0){ ?>
									<table width="100%">
										<tbody>
											<tr>
												<td>Gross Profit</td>
												<td align="right">
													<?php echo ($totalDiff); $LeftTotal+=$totalDiff; ?>
												</td>
											</tr>
										</tbody>
									</table>
									<?php } ?>
								</td>
								<td>
									<?php if($totalDiff<0){ ?>
									<table width="100%">
										<tbody>
											<tr>
												<td>Gross Loss</td>
												<td align="right">
													<?php echo (abs($totalDiff)); $RightTotal+=abs($totalDiff); ?>
												</td>
											</tr>
										</tbody>
									</table>
									<?php } ?>
								</td>
							</tr>
							
							
							
						</tbody>
						<tfoot>
							<tr>
								<td>
									<table width="100%">
										<tbody>
											<tr>
												<td><b>Total</b></td>
												<td align="right"><b><?php echo ($LeftTotal); ?></b></td>
											</tr>
										</tbody>
									</table>
								</td>
								<td>
									<table width="100%">
										<tbody>
											<tr>
												<td><b>Total</b></td>
												<td align="right"><b><?php echo ($RightTotal); ?></b></td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tfoot>
					</table>
					<?php $LeftpnlTotal=0;  $RightpnlTotal=0;  ?>
					<table class="table table-bordered">
						<thead>
							<tr style="background-color: #c4ffbd;">
								<td width="50%">
									<table width="100%">
										<tbody>
											<tr>
												<td><b>Particulars</b></td>
												<td align="right"><b>Balance</b></td>
											</tr>
										</tbody>
									</table>
								</td>
								<td width="50%">
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
											<?php if($totalDiff < 0){ ?>
												<tr>
													<td>Gross Loss</td>
													<td align="right">
														<?php echo abs($totalDiff); 
														$LeftpnlTotal+=abs($totalDiff); ?>
													</td>
												</tr>
											<?php } ?>
											<?php foreach($groupForPrint as $key=>$groupForPrintRow){ 
												if(($groupForPrintRow['balance']>0) or ($groupForPrintRow['balance']==0 && $groupForPrintRow['nature']==4)){
												if($groupForPrintRow['name']=="Indirect Expenses"){
													?>
												<tr>
													<td>
													<a href="#" role='button' status='close' class="group_name" child='no' parent='yes' group_id='<?php  echo $key; ?>' style='color:black;'>
														<?php echo $groupForPrintRow['name']; ?>
															 </a>
													</td>
													<td align="right">
														<?php if($groupForPrintRow['balance']!=0){
															echo (abs($groupForPrintRow['balance']));
															$LeftpnlTotal+=abs($groupForPrintRow['balance']);
														} ?>
													</td>
												</tr>
											<?php }} ?>
											<?php } ?>
										</tbody>
									</table>
								</td>
								<td>
									<table width="100%">
										<tbody>
											<?php if($totalDiff > 0){ ?>
												<tr>
													<td>Gross Profit</td>
													<td align="right">
														<?php echo (abs($totalDiff)); $RightpnlTotal+=abs($totalDiff); ?>
													</td>
												</tr>
											<?php } ?>
											<?php foreach($groupForPrint as $key=>$groupForPrintRow){ 
												if(($groupForPrintRow['balance']<0) or ($groupForPrintRow['balance']==0 && $groupForPrintRow['nature']==3)){
												if($groupForPrintRow['name']=="Indirect Incomes" ||$groupForPrintRow['name']=="Direct Incomes"){
													?>
												<tr>
													<td>
													<a href="#" role='button' status='close' class="group_name" child='no' parent='yes' group_id='<?php  echo $key; ?>' style='color:black;'>
														<?php echo $groupForPrintRow['name']; ?>
															 </a>
													</td>
													<td align="right">
														<?php if($groupForPrintRow['balance']!=0){
															echo (abs($groupForPrintRow['balance'])); 
															$RightpnlTotal+=abs($groupForPrintRow['balance']); 
														} ?>
													</td>
												</tr>
												<?php } } ?>
											<?php } ?>
												
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<?php 
									$totalDiff=$RightpnlTotal-$LeftpnlTotal;
									if($totalDiff>=0){ ?>
									<table width="100%">
										<tbody>
											<tr>
												<td>Net Profit</td>
												<td align="right">
													<?php echo ($totalDiff); $LeftpnlTotal+=$totalDiff; ?>
												</td>
											</tr>
										</tbody>
									</table>
									<?php } ?>
								</td>
								<td>
									<?php if($totalDiff<0){ ?>
									<table width="100%">
										<tbody>
											<tr>
												<td>Net Loss</td>
												<td align="right">
													<?php echo (abs($totalDiff)); $RightpnlTotal+=abs($totalDiff); ?>
												</td>
											</tr>
										</tbody>
									</table>
									<?php } ?>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td>
									<table width="100%">
										<tbody>
											<tr>
												<td><b>Total</b></td>
												<td align="right"><b><?php echo ($LeftpnlTotal); ?></b></td>
											</tr>
										</tbody>
									</table>
								</td>
								<td>
									<table width="100%">
										<tbody>
											<tr>
												<td><b>Total</b></td>
												<td align="right"><b><?php echo ($RightpnlTotal); ?></b></td>
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