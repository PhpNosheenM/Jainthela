<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Order Performas'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Bulk Order Performas</strong></h3>
				<div class="pull-right">
			<div class="pull-left">
				<?= $this->Form->create('Search',['type'=>'GET']) ?>
				<?= $this->Html->link(__('<span class="fa fa-plus"></span> Add New'), ['controller'=>'SalesOrders','action' => 'bulkBookingPerforma'],['class'=>'btn btn-success','escape'=>false]) ?>
					
				<?= $this->Form->end() ?>
			</div> 
		</div> 	
				</div>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('name') ?></th>
									
									<th scope="col" class="actions"><?= __('Actions') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								 <?php $i=0; foreach ($bulkOrderPerformas as $bulkOrderPerforma): ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($bulkOrderPerforma->name) ?></td>
									
									<td class="actions">
										<?= $this->Html->link(__('<span class="fa fa-search"></span> View'), ['action' => 'view',$bulkOrderPerforma->id],['class'=>'btn btn-warning btn-xs','escape'=>false]) ?>
										<?php //echo $this->Html->link('Export To Excel',['controller'=>'BulkOrderPerformas','action' => 'excelExport',$bulkOrderPerforma->id],['escape'=>false,'class'=>'btn btn-default backbutton','target'=>'_blank','escape'=>false]); ?>
										</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>                    
</div>
