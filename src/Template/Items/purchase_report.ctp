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
				if($PurchaseInvoices){
				?>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Invoice No') ?></th>
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
									<td colspan="3" align="right"><b>Total</b></td>
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