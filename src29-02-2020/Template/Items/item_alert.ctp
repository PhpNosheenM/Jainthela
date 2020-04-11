<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php   $this->set('title', 'Item');  ?><!-- PAGE CONTENT WRAPPER --> 
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Minimum stock items</strong></h3>
				 	
				</div>
			  
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered main_table">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Item name') ?></th>
									<th><?= ('Stock') ?></th>
									<th><?= ('Status') ?></th>
									
									
									
								</tr>
							</thead>
							<tbody class="MainTbody">                                         
								<?php $i = 0; ?>
								
								  <?php  foreach ($ItemVariations as $itemvar):
								 
								  ?>
								<tr class="MainTr">
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($itemvar->item->name) ?></td>
									<td><?= h($itemvar->current_stock) ?></td>
									<td><?= h($itemvar->status) ?></td>
									
									
								</tr>
								<?php  endforeach;  ?>
							</tbody>
						</table>
						
					</div>
				</div>
				<div class="panel-footer">
					
				</div>
			</div>
			
		</div>
	</div>                    
	<?= $this->Form->end() ?>
</div>
