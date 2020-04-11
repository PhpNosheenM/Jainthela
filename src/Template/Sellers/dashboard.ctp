<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Purchase Order'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Pending Order</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
						</div> 
					</div> 	
				</div>
				
				<?php $LeftTotal=0; $RightTotal=0;
				if(sizeof($orders->toArray()) > 0){ 
				?>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Item') ?></th>
									<th><?= ('Quantity') ?></th>
									
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; $total_sales_amount=0; $total_gst_amount=0; $total_amount=0;?>
								  <?php foreach ($orders as $order){ 
								  if(sizeof($order->order_details) > 0){
									  foreach($order->order_details as $data){
								  ?>
									<tr>
										<td><?= $this->Number->format(++$i) ?></td>
										<td><?= h($data->item_variation->item->name.'  ('. $data->item_variation->unit_variation->quantity_variation.'  '.$data->item_variation->unit_variation->unit->shortname.')') ?></td>
										<td><?= h($data->total_qty) ?></td>
										
									</tr>
													
								  <?php } } }?>
							</tbody>
						</table>
									
								
							<tfoot>
								
							</tfoot>
						</table>
					</div>
				</div>
				<?php } else {?>
				<div class="row">
					<div class="col-md-10">
					No Result Found
					</div>
				</div> 
				<?php } ?>
		</div>
	</div>                    
</div>
<?= $this->Html->script('plugins/bootstrap/bootstrap-datepicker.js',['block'=>'jsDatePicker']) ?>
<?= $this->Html->script('plugins/bootstrap/bootstrap-select.js',['block'=>'jsSelect']) ?>