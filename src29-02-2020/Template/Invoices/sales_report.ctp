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
								<div class="col-md-4 col-xs-12">
									<div class="input-group">
									<span class="input-group-addon add-on"> FROM </span>
										<?= $this->Form->control('from_date',['class'=>'form-control datepicker','placeholder'=>'From','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($from_date))]) ?>
										<span class="input-group-addon add-on"> TO </span>
										<?= $this->Form->control('to_date',['class'=>'form-control datepicker','placeholder'=>'To','label'=>false,'type'=>'text','data-date-format' => 'dd-mm-yyyy','value'=>date('d-m-Y',strtotime($to_date))]) ?>
										</div>
								</div>
								<div class="col-md-3 col-xs-12">
									<div class="input-group">
									
										<span class="input-group-addon add-on"> Invoice Type </span>
										<?php $options['COD'] = 'Cash'; ?>
										<?php $options['Wallet'] = 'Wallet'; ?>
										<?php $options['Online'] = 'Online'; ?>
										<?php $options['Credit'] = 'Credit'; ?>
										<?= $this->Form->select('invoice_type',$options,['empty'=>'--select--','class'=>'form-control select','label'=>false,'value'=>@$invoice_type]) ?>
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
					<div class="table-responsive">GST
						<table class="table table-bordered">
							<tr>
								<td >Bill No</td>
								<td >Challa No</td>
								<td width="100px" >Invoice Date</td>
								<td width="100px" >Invoice Type</td>
								<td >Party Name</td>
								<td >GST No.</td>
							<?php foreach($GstFigures as $GstFigure){ ?>
								<?php if($GstFigure->tax_percentage==0){ ?>
										<td >Sales 0%</td>
								<?php }else{ ?>
									<td >Sales <?php echo $GstFigure->tax_percentage;?>%</td>
									<td >CGST <?php echo $GstFigure->tax_percentage/2; ?>%</td>
									<td >SGST <?php echo $GstFigure->tax_percentage/2; ?>%</td>
								<?php } ?>
									
							<?php } ?>
								<td >Invoice Total</td>
							</tr>
							<?php  
							$totalTaxAble=[];
							$totalGSTAmt=[];
							$totalAmtZero=0;
							$TotalrowTotal11=0;
							
							?>
							<?php foreach($InvoiceNo as $key=>$data){ ?>
							<tr>
							<td ><?php echo $data; ?></td>
							<td ><?php echo $ChallaNo[$key]; ?></td>
							<td ><?php echo date('d-m-Y',strtotime($InvoiceDate[$key])); ?></td>
							<td ><?php echo $InvoiceType[$key]; ?></td>
							<td ><?php echo $InvoiceCustomer[$key]; ?></td>
							<td ><?php echo $InvoiceCustomerGST[$key]; ?></td>
							
							<?php  ?>
							<?php $rowTotal=0; foreach($GstFigures as $GstFigure1){  ?>
								<?php if($GstFigure1->tax_percentage==0){ ?>
										<td ><?php echo @$totalGstTaxable[$key][$GstFigure1->id]; 
										$totalAmtZero = $totalAmtZero+@$totalGstTaxable[$key][$GstFigure1->id];
										//echo $totalAmtZero;
										?></td>
								<?php }else if(empty($totalGstTaxable[$key][$GstFigure1->id])){ ?>
									<td >-</td>
									<td >-</td>
									<td >-</td>
								<?php }else{ ?>
									<td ><?php echo @$totalGstTaxable[$key][$GstFigure1->id]; ?></td>
									<td ><?php echo @$totalGst[$key][$GstFigure1->id]/2; ?></td>
									<td ><?php echo @$totalGst[$key][$GstFigure1->id]/2; ?></td>
								<?php 
								}
								@$totalTaxAble[$GstFigure1->id]+=@$totalGstTaxable[$key][$GstFigure1->id];
								@$totalGSTAmt[$GstFigure1->id]+=@$totalGst[$key][$GstFigure1->id];
								$rowTotal+=@$totalGstTaxable[$key][$GstFigure1->id]+@$totalGst[$key][$GstFigure1->id];
								?>
									
							<?php }  ?>
								<td ><?php echo @$rowTotal; $TotalrowTotal11+=@$rowTotal; ?></td>
							<?php }  ?>
							</tr>
								<tr>
								<td colspan="6"></td>
								<?php foreach($GstFigures as $GstFigure){ ?>
								<?php if($GstFigure->tax_percentage==0){ ?>
										<td ><?php echo $totalAmtZero;?></td>
								<?php }else{ ?>
									<td ><?php echo @$totalTaxAble[$GstFigure->id];?></td>
									<td ><?php echo @$totalGSTAmt[$GstFigure->id]/2;?></td>
									<td ><?php echo @$totalGSTAmt[$GstFigure->id]/2;?></td>
									
									
								<?php } ?>
									
							<?php } ?>
							<td ><?php echo $TotalrowTotal11; ?></td>
							</tr>
							
						</table>
					</div>
				</div>
				
				
				<div class="panel-body">    
					<div class="table-responsive">IGST
						<table class="table table-bordered">
							<tr>
								<td >Bill No</td>
								<td width="100px" >Invoice Date</td>
								<td >Party Name</td>
								<td >GST No.</td>
							<?php foreach($GstFigures as $GstFigure){ ?>
								<?php if($GstFigure->tax_percentage==0){ ?>
										<td >Sales 0%</td>
								<?php }else{ ?>
									<td >Sales <?php echo $GstFigure->tax_percentage;?>%</td>
									<td >IGST <?php echo $GstFigure->tax_percentage; ?>%</td>
								<?php } ?>
									
							<?php } ?>
								<td >Invoice Total</td>
							</tr>
							<?php  
							$totalTaxAble=[];
							$totalGSTAmt=[];
							$totalAmtZero=0;
							$TotalrowTotal1=0;
							?>
							<?php if(@$InvoiceNoIGST){ ?>
							<?php foreach(@$InvoiceNoIGST as $key=>$data){ ?>
							<tr>
							<td ><?php echo $data; ?></td>
							<td ><?php echo date('d-m-Y',strtotime($InvoiceDate[$key])); ?></td>
							<td ><?php echo $InvoiceCustomer[$key]; ?></td>
							<td ><?php echo $InvoiceCustomerGST[$key]; ?></td>
							
							<?php $rowTotal1=0; foreach($GstFigures as $GstFigure1){  ?>
								<?php if($GstFigure1->tax_percentage==0){ ?>
										<td ><?php echo @$totalIGstTaxable[$key][$GstFigure1->id]; 
										$totalAmtZero = $totalAmtZero+@$totalIGstTaxable[$key][$GstFigure1->id];
										?></td>
								<?php }else{ ?>
									<td ><?php echo @$totalIGstTaxable[$key][$GstFigure1->id]; ?></td>
									<td ><?php echo @$totalIGst[$key][$GstFigure1->id]; ?></td>
								
								<?php 
								}
								@$totalTaxAble[$GstFigure1->id]+=@$totalIGstTaxable[$key][$GstFigure1->id];
								@$totalGSTAmt[$GstFigure1->id]+=@$totalIGst[$key][$GstFigure1->id];
								$rowTotal1+=@$totalIGstTaxable[$key][$GstFigure1->id]+@$totalIGst[$key][$GstFigure1->id];;
								?>
									
							<?php }  ?>
								<td ><?php echo @$rowTotal1; $TotalrowTotal1+=@$rowTotal1; ?></td>
							<?php }  ?>
							</tr>
							<tr>
								<td colspan="4"></td>
								<?php foreach($GstFigures as $GstFigure){ ?>
								<?php if($GstFigure->tax_percentage==0){ ?>
										<td ><?php echo $totalAmtZero; ?></td>
								<?php }else{ ?>
									<td ><?php echo $totalTaxAble[$GstFigure->id];?></td>
									<td ><?php echo $totalGSTAmt[$GstFigure->id];?></td>
								<?php } ?>
								
							<?php } ?>
							<td ><?php echo $TotalrowTotal1; ?></td>	
							</tr>
							<?php }  ?>
						</table>
					</div>
				</div>
				
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>