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
					<h3 class="panel-title"><strong>Statement<?php if(@$Customer){ echo " For ";?> <u><?php  echo $Customer->name; } ?></strong></h3>
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
									<span class="input-group-addon add-on"> Customer </span>
										<select class="itemName form-control select" style="width:100%" name="ledger_id"></select>
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
					if(!empty($Invoices))
					{
					?>
					<table class="table table-bordered  table-condensed" width="100%" border="1">
						<thead>
							<tr>
								<th >S.N.</th>
								<th >Invoice No</th>
								<th >Invoice Date</th>
								<th >Payment Type</th>
								<th >Amount</th>
							</tr>
							</thead>
							<tbody>
							<?php $i=1; $total=0; $AmountHistory=[];
								foreach($Invoices as $Invoice)
								{ 
								$total+=$Invoice->pay_amount;
								@$AmountHistory[$data->order_type]+=$data->pay_amount;
							?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td>
									<?php $order_id = $EncryptingDecrypting->encryptData($Invoice->id); ?>
											<?php echo $this->Html->link($Invoice->invoice_no,['controller'=>'Invoices','action' => 'pdfView', $order_id, 'print'],['target'=>'_blank']); ?>
									</td>
									<td><?php echo $Invoice->transaction_date; ?></td>
									<td><?php echo $Invoice->order_type; ?></td>
									<td><?php echo $Invoice->pay_amount; ?></td>
								</tr>
							<?php }	?>
							<tr>
								<td colspan="4" style="text-align:right"><b>Total</b></td>
								<td><b><?php echo $total; ?></b></td>
							</tr>
							</tbody>
							</table>
						<?php }	?>
					</div>
				</div>
			</div>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


<script type="text/javascript">
		//var url='<?php echo $this->Url->build(['controller'=>'AccountingEntries','action'=>'getLedgerList']); ?>';
		 
		 $(".itemName").select2({
            allowClear: true,
            theme: "classic",
            tags:true,
            placeholder : 'Select Ledgers',
            minimumInputLength: 1,
            ajax: {
                url: '<?php echo $this->Url->build(['controller'=>'AccountingEntries','action'=>'getCustomerList']); ?>',
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
        });
     
</script>