<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}

</style>
<?php $this->set('title', 'HSN Wise Report'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>HSN WISE SALES</strong></h3>
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
									<span class="input-group-addon add-on"> HSN No. </span>
										<?php echo $this->Form->input('search', ['label' => false,'class' => 'form-control input-sm']); ?>
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
				if($hsn){
					 ?>
				
						
					
				<div class="panel-body">    
					<div class="table">
						<table class="table table-bordered  table-condensed" width="100%" border="1">
							<thead>
								
								<tr>
									<th style="text-align:center;background-color:#a3bad0"  scope="col">S.N</th>
									<th style="text-align:center;background-color:#a3bad0"  scope="col">HSN No.</th>
									<th style="text-align:center;background-color:#a3bad0"  scope="col">Quantity</th>
									<th style="text-align:center;background-color:#a3bad0"  scope="col">Taxable</th>
									<th style="text-align:center;background-color:#a3bad0"  scope="col" >GST Amount</th>
									<th style="text-align:center;background-color:#a3bad0"  scope="col" >IGST Amount</th>
									<th style="text-align:center;background-color:#a3bad0"  scope="col" >Total Value</th>
								</tr>
							</thead>
							<tbody>
							<?php $i=0; $total_taxable=0; $total_tax=0; $total=0; $total_qty=0; $total_tax_igst=0;
							foreach ($hsn as $hsn): 	 
								if($hsn){	$i++; 	?>
								<tr>
									<td style="text-align:center;"><?= h($i) ?></td>
									<td style="text-align:center;"><?= h($hsn) ?></td>
									<td style="text-align:center;"><?= h($quantity[$hsn]) ?></td>
									<td style="text-align:center;"><?= h(round($taxable_value[$hsn],2)) ?></td>
									<td style="text-align:center;"><?= h(round(@$gst[@$hsn],2)) ?></td>
									<td style="text-align:center;"><?= h(round(@$igst[@$hsn],2)) ?></td>
									<td style="text-align:center;"><?= h(round($total_value[$hsn],2)) ?></td>
									<?php 
									$total_qty+=$quantity[$hsn];
									$total_taxable+=$taxable_value[$hsn];
									$total_tax+=@$gst[@$hsn];
									$total_tax_igst+=@$igst[@$hsn];
									$total+=$total_value[$hsn];
									?>
									
								</tr>
								<?php } endforeach; ?>
							</tbody>
							<tfoot>
							<tr>
									<td colspan="2" scope="col"  style="text-align:right";><b> Total </b></td>
									<td scope="col" style="text-align:center;"><b><?php echo $this->Number->format(abs(@$total_qty),['places'=>2]); ?></b></td>
									<td scope="col" style="text-align:center;"><b><?php echo $this->Number->format(abs(@$total_taxable),['places'=>2]); ?></b></td>
									<td scope="col" style="text-align:center"><b><?php echo $this->Number->format(abs(@$total_tax),['places'=>2]); ?></b></td>
									<td scope="col" style="text-align:center"><b><?php echo $this->Number->format(abs(@$total_tax_igst),['places'=>2]); ?></b></td>
									<td scope="col" style="text-align:center"><b><?php echo $this->Number->format(abs(@$total),['places'=>2]); ?></b></td>
									
								</tr>
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