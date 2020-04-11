<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Customers'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Customers</strong></h3>
				<div class="pull-right">
			<div class="pull-left">
				
			</div> 
		</div> 	
				</div>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table datatable">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Customer No') ?></th>
									<th><?= ('Name') ?></th>
									<th><?= ('firm_name') ?></th>
									<th><?= ('email') ?></th>
									<th><?= ('user_name') ?></th>
									<th><?= ('GSTIN') ?></th>
									<th><?= ('status') ?></th>
									<th><?= ('Created On') ?></th>
									<th scope="col" class="actions"><?= __('Actions') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; ?>
								
								  <?php foreach ($customers as $customer):
										$customer_id = $EncryptingDecrypting->encryptData($customer->id);
									?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($customer->customer_no) ?></td>
									<td>
										<?php echo $this->Html->link($customer->name,['controller'=>'Customers','action' => 'view', $customer_id, 'print'],['target'=>'_blank']); ?>
									</td>
									<td><?= h($customer->firm_name) ?></td>
									<td><?= h($customer->email) ?></td>
									<td><?= h($customer->username) ?></td>
									<td><?= h($customer->gstin) ?></td>
									<td><?= h($customer->status) ?></td>
									<td><?= h($customer->created_on) ?></td>
									<td class="actions">
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $customer_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $customer_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
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