<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Today Stock'); ?><!-- PAGE CONTENT WRAPPER -->
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
							<ul class="nav nav-tabs nav-justified">
								<li class="active"><a href="#tab8" data-toggle="tab" aria-expanded="true">Jainthela</a></li>
								<li class=""><a href="#tab9" data-toggle="tab" aria-expanded="false">Seller</a></li>
								
							</ul>
							<div class="panel-body tab-content">
								<div class="tab-pane active" id="tab8">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th><?= ('SNo.') ?></th>
												<th><?= ('Item Name') ?></th>
												<th><?= ('Current Stock') ?></th>
												<th><?= ('Sales Rate') ?></th>
												<th><?= ('Ready To Sale') ?></th>
											</tr>
										</thead>
										<tbody>                                            
											<?php $i = 0; $total_amt=0; ?>
											
											   <?php foreach ($ItemsVariationsForJainthela as $ItemsVariation){  
												?>
											<tr>
												<td><?= $this->Number->format(++$i) ?></td>
												<td><?php echo $ItemsVariation->item->name.' ('. $ItemsVariation->unit_variation->quantity_variation.' '.$ItemsVariation->unit_variation->unit->longname.')'; ?></td>
												<td><?php echo $ItemsVariation->current_stock; ?></td>
												<td><?php echo $ItemsVariation->sales_rate; ?></td>
												<td><?php echo $ItemsVariation->ready_to_sale; ?></td>
												
											</tr>
											 <?php } ?>
											
										</tbody>
									</table>
								</div>
								<div class="tab-pane" id="tab9">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th><?= ('SNo.') ?></th>
												<th><?= ('Seller') ?></th>
												<th><?= ('Item Name') ?></th>
												<th><?= ('Current Stock') ?></th>
												<th><?= ('Sales Rate') ?></th>
												<th><?= ('Ready To Sale') ?></th>
											</tr>
										</thead>
										<tbody>                                            
											<?php $i = 0; $total_amt=0; ?>
											
											   <?php foreach ($ItemsVariations as $ItemsVariation){  
												?>
											<tr>
												<td><?= $this->Number->format(++$i) ?></td>
												<td><?php echo $ItemsVariation->seller->name; ?></td>
												<td><?php echo $ItemsVariation->item->name.' ('. $ItemsVariation->unit_variation->quantity_variation.' '.$ItemsVariation->unit_variation->unit->longname.')'; ?></td>
												<td><?php echo $ItemsVariation->current_stock; ?></td>
												<td><?php echo $ItemsVariation->sales_rate; ?></td>
												<td><?php echo $ItemsVariation->ready_to_sale; ?></td>
												
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
