<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Account Statement'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Account Statement<?php if($Ledger){ echo " For ";?> <u><?php  echo $Ledger->name; } ?></strong></h3>
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
									<span class="input-group-addon add-on"> Ledger </span>
										<?php echo $this->Form->select('ledger_id',$queryLedgers, ['empty'=>'--Select Ledger--','label' => false,'class' => 'form-control input-sm ledger select', 'data-live-search'=>true,'value'=>@$ledger_id]); ?>
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
				<?php $LeftTotal=0; $RightTotal=0; ?>
				<div class="panel-body">    
					<div class="table-responsive">
									<?php
				if(!empty($AccountingLedgers))
				{
				?>
					<table class="table table-bordered  table-condensed" width="100%" border="1">
						<thead>
							<tr>
								<th colspan="4">
								<span style="float:left";>
								<?php if(@$AccountingLedger->ledger->name){?>
									<?php echo 'Account Ledger of '; echo @$id= $AccountingLedger->ledger->name; echo ' '; echo 'Date from '; echo $from_date; echo ' to '; echo $to_date;?>
									<?php } ?>		</span>
								<span style="float:right";><b>Opening Balance</b></span></th>
								<th style="text-align:right";>
								<?php
									if(!empty($opening_balance))
									{
										echo $opening_balance.' '. $opening_balance_type;
									} 
								?>
								</th>
								
							</tr>
							<tr>
								<th width="10%" scope="col">Date</th>
								<th width="20%" scope="col" style="text-align:center";>Voucher Type</th>
								<th width="20%" scope="col" style="text-align:center";>Voucher No</th>
								<th width="25%" scope="col" style="text-align:center";>Debit</th>
								<th width="25%" scope="col" style="text-align:center";>Credit</th>
							</tr>
						</thead>
						<tbody>
						<?php if(!empty($Invoices)){ 
							foreach($Invoices as $Invoice){  
							$voucher_no = $Invoice->invoice_no;
							$order_id = $EncryptingDecrypting->encryptData($Invoice->id);
							@$url_link=$this->Html->link($voucher_no,['controller'=>'Invoices','action' => 'pdfView', $order_id, 'print'],['target'=>'_blank']);

							?>
							<tr>
								<td style="text-align:left";><?php echo date("d-m-Y",strtotime($Invoice->transaction_date)); ?></td>
								<td style="text-align:left";><?php echo "Invoice (CASH)"; ?></td>
								<td style="text-align:left";><?php echo $url_link; ?></td>
								<td style="text-align:right";><?php echo $Invoice->grand_total; ?></td>
								<td style="text-align:right";></td>
						
						<?php } } ?>
						<?php
						if(!empty($AccountingLedgers))
						{
							$total_credit=0;$total_debit=0;
							//pr($AccountingLedgers->toArray());     exit;
						foreach($AccountingLedgers as $AccountingLedger)
						{   // pr($AccountingLedger); exit;
							$id= $AccountingLedger->id;
						?>
							<tr>
								<td><?php echo date("d-m-Y",strtotime($AccountingLedger->transaction_date)); ?></td>
								<td>
								<?php 
								if(!empty($AccountingLedger->is_opening_balance=='yes')){
									echo 'Opening Balance';
									@$voucher_no='-';
									@$url_link='-';
								}
								else if(!empty($AccountingLedger->purchase_voucher_id)){
									@$voucher_no=$AccountingLedger->purchase_voucher->voucher_no;
									@$url_link=$this->Html->link($voucher_no,['controller'=>'PurchaseVouchers','action' => 'view', $AccountingLedger->purchase_voucher_id],['target'=>'_blank']); 
									echo 'Purchase Vouchers';
								}
								else if(!empty($AccountingLedger->purchase_invoice_id)){
									echo 'Purchase Invoices';
									@$voucher_no=$AccountingLedger->purchase_invoice->voucher_no;
									@$url_link=$this->Html->link($voucher_no,['controller'=>'PurchaseInvoices','action' => 'view', $AccountingLedger->purchase_invoice_id],['target'=>'_blank']);
								}
								else if(!empty($AccountingLedger->purchase_return_id)){
									echo 'Purchase Returns';
									@$voucher_no=$AccountingLedger->purchase_return->voucher_no;
									@$url_link=$this->Html->link($voucher_no,['controller'=>'PurchaseReturns','action' => 'view', $AccountingLedger->purchase_return_id],['target'=>'_blank']);
								}
								else if(!empty($AccountingLedger->sales_invoice_id)){
									echo 'Sales Invoices';
									@$voucher_no=$AccountingLedger->sales_invoice->voucher_no;
									@$url_link=$this->Html->link($voucher_no,['controller'=>'SalesInvoices','action' => 'sales-invoice-bill', $AccountingLedger->sales_invoice_id],['target'=>'_blank']);
								}
								else if(!empty($AccountingLedger->sale_return_id)){
									echo 'Sales Returns';
									@$voucher_no=$AccountingLedger->sale_return->voucher_no;
									@$url_link=$this->Html->link($voucher_no,['controller'=>'SaleReturns','action' => 'view', $AccountingLedger->sale_return_id],['target'=>'_blank']);
								}
								else if(!empty($AccountingLedger->sales_voucher_id)){
									echo 'Sales Vouchers';
									@$voucher_no=$AccountingLedger->sales_voucher->voucher_no;
									@$url_link=$this->Html->link($voucher_no,['controller'=>'SalesVouchers','action' => 'view', $AccountingLedger->sales_voucher_id],['target'=>'_blank']);
								}
								else if(!empty($AccountingLedger->journal_voucher_id)){ 
									echo 'Journal Vouchers';
									 $journal_voucher_id = $EncryptingDecrypting->encryptData($AccountingLedger->journal_voucher_id);
									@$voucher_no=$AccountingLedger->journal_voucher->voucher_no;
									@$url_link=$this->Html->link($voucher_no,['controller'=>'JournalVouchers','action' => 'view', $journal_voucher_id],['target'=>'_blank']);
								}
								else if(!empty($AccountingLedger->contra_voucher_id)){
									echo 'Contra Vouchers';
									@$voucher_no=$AccountingLedger->contra_voucher->voucher_no;
									@$url_link=$this->Html->link($voucher_no,['controller'=>'ContraVouchers','action' => 'view', $AccountingLedger->contra_voucher_id],['target'=>'_blank']);
								}
								else if(!empty($AccountingLedger->receipt_id)){
									echo 'Receipt Vouchers';
									 $receipt_id = $EncryptingDecrypting->encryptData($AccountingLedger->receipt_id);
									@$voucher_no=$AccountingLedger->receipt->voucher_no;
									@$url_link=$this->Html->link($voucher_no,['controller'=>'Receipts','action' => 'view', $receipt_id],['target'=>'_blank']);
								}
								else if(!empty($AccountingLedger->payment_id)){
									echo 'Payment Vouchers';
									@$voucher_no=$AccountingLedger->payment->voucher_no;
									@$url_link=$this->Html->link($voucher_no,['controller'=>'Payments','action' => 'view', $AccountingLedger->payment_id],['target'=>'_blank']);
								}
								else if(!empty($AccountingLedger->credit_note_id)){
									echo 'Credit Note Vouchers';
									@$voucher_no=$AccountingLedger->credit_note->voucher_no;
									@$url_link=$this->Html->link($voucher_no,['controller'=>'CreditNotes','action' => 'view', $AccountingLedger->credit_note_id],['target'=>'_blank']);
								}
								else if(!empty($AccountingLedger->debit_note_id)){
									echo 'Debit Note Vouchers';
									@$voucher_no=$AccountingLedger->debit_note->voucher_no;
									@$url_link=$this->Html->link($voucher_no,['controller'=>'DebitNotes','action' => 'view', $AccountingLedger->debit_note_id],['target'=>'_blank']);
								}else if(!empty($AccountingLedger->order_id)){
									echo 'Orders'; //pr($AccountingLedger); exit;
									@$voucher_no=$AccountingLedger->order->order_no;
									@$url_link=$this->Html->link($voucher_no,['controller'=>'Orders','action' => 'view', $AccountingLedger->order_id],['target'=>'_blank']);
								}else if(!empty($AccountingLedger->invoice_id)){
									echo 'Invoices'; //pr($AccountingLedger->invoice->invoice_no); exit;
									@$voucher_no=$AccountingLedger->invoice->invoice_no;
									
									
									$order_id = $EncryptingDecrypting->encryptData($AccountingLedger->invoice->id);
									@$url_link=$this->Html->link($voucher_no,['controller'=>'Invoices','action' => 'pdfView', $order_id, 'print'],['target'=>'_blank']);
								}
								?>
								</td>
								<td class="rightAligntextClass"><?php echo $url_link; ?></td>
								<td style="text-align:right";>
								<?php 
									if(!empty($AccountingLedger->total_debit_sum))
									{
										echo $this->Money->moneyFormatIndia($AccountingLedger->total_debit_sum);
										$total_debit +=round($AccountingLedger->total_debit_sum,2);
									}
									else
									{
										echo "-";
									}
								?>
								</td>
								<td style="text-align:right";>
								<?php 
									if(!empty($AccountingLedger->total_credit_sum))
									{
										echo $this->Money->moneyFormatIndia($AccountingLedger->total_credit_sum); 
										$total_credit +=round($AccountingLedger->total_credit_sum,2);
									}else
									{
										echo "-";
									}
								?>
								</td>
							</tr>
						<?php  } 
						} ?>
						</tbody>
						<tfoot>
							<tr>
								<td scope="col" colspan="3" style="text-align:right";><b>Total</b></td>
								<td scope="col" style="text-align:right";><?php echo $this->Money->moneyFormatIndia(@$total_debit, 2);?></td>
								<td scope="col" style="text-align:right";><?php echo $this->Money->moneyFormatIndia(@$total_credit);?></td>
							</tr>
							<tr>
								<td scope="col" colspan="4" style="text-align:right";><b>Closing Balance</b></td>
								<td scope="col" style="text-align:right";><b>
								<?php
									if($opening_balance_type=='Dr'){
									@$closingBalance= $opening_balance+$total_debit-$total_credit;
									}
									else{
									@$closingBalance= $opening_balance+$total_credit-$total_debit;
									}
									if($closingBalance>0)
									{
									@$closing_bal_type='Cr';
									}
									else if($closingBalance<0){
									@$closing_bal_type='Dr';	
									}
									else{
									@$closing_bal_type='';	
									}
									echo $this->Money->moneyFormatIndia(round(abs($closingBalance),2)); echo ' '.$closing_bal_type;
								?>
								</b></td>
								
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

<?= $this->Html->script('plugins/fileinput/fileinput.min.js',['block'=>'jsFileInput']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>
<?= $this->Html->script('plugins/jquery-validation/jquery.validate.js',['block'=>'jsValidate']) ?>

<script type="text/javascript">
		//var url='<?php echo $this->Url->build(['controller'=>'AccountingEntries','action'=>'getLedgerList']); ?>';
		 
		/*  $(".itemName").select2({
            allowClear: true,
            theme: "classic",
            tags:true,
            placeholder : 'Select Ledgers',
            minimumInputLength: 1,
            ajax: {
                url: '<?php echo $this->Url->build(['controller'=>'AccountingEntries','action'=>'getLedgerList']); ?>',
                dataType: 'json',
                delay: 250,
                type : 'GET',
                data: function(params) {
                    return {
                        con_id:params.term,
                    };
                },
                processResults: function (data) {
					return { 
					  results: data
					};
					
				  },
                
            }
        }); */
     
</script>