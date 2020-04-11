<?php ini_set('memory_limit', '256M'); ?>
<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Zero Rate Item'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Today Stock</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
						</div> 
					</div> 	
				</div>
				
				
				
					<div class="row">
					<div class="col-md-12">                        
					<!-- START JUSTIFIED TABS -->
						<div class="panel panel-default tabs">
							
							<div class="panel-body tab-content">
								<div class="tab-pane active" id="tab8">
									<table class="table datatable1">
										<thead>
											<tr>
												<th><?= ('SNo.') ?></th>
												<th><?= ('Item Name') ?></th>
												<th><?= ('Brand') ?></th>
												<th><?= ('Sales Rate') ?></th>
												<th><?= ('Current Stock') ?></th>
												<th><?= ('Ready To Sale') ?></th>
											</tr>
										</thead>
										<tbody>                                            
											<?php $i = 0; $total_amt=0; ?>
											
											   <?php foreach ($ItemsVariationsForJainthela as $ItemsVariation){ $item_id = $EncryptingDecrypting->encryptData($ItemsVariation->item_id);
												?>
											<tr>
												<td><?= $this->Number->format(++$i) ?></td>
												<td><?php echo $ItemsVariation->item_name.' ('. $ItemsVariation->visible_variation.')'; ?></td>
												<td><?php echo $ItemsVariation->brand; ?></td>
												<td><?php echo $ItemsVariation->sales_rate; ?></td>
												<td><?php echo $ItemsVariation->current_stock; ?></td>
												<td><?php echo $ItemsVariation->ready_to_sale; ?></td>
												<td><?= $this->Form->postLink('<span class="fa fa-remove">Deactive</span>', ['action' => 'zeroRateItemDeactive', $item_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to Deactive?'),'escape'=>false]) ?></td>
												
											</tr>
											 <?php } ?>
											
										</tbody>
									</table>
								</div>
								                     
							</div>
						</div>                                         
						<!-- END JUSTIFIED TABS -->
					</div>
				</div>
					 
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>                    
</div>
