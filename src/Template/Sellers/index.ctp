<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Seller'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Seller</strong></h3>
					<ul class="panel-controls">
						<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
					</ul>
				</div>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('name') ?></th>
									<th><?= ('firm_name') ?></th>
									<th><?= ('email') ?></th>
									<th><?= ('mobile no') ?></th>
									<th><?= ('GSTIN') ?></th>
									<th><?= ('GSTIN Holder') ?></th>
									<th><?= ('Registration Date') ?></th>
									<th><?= ('status') ?></th>
									<th scope="col" class="actions"><?= __('Actions') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								  <?php foreach ($sellers as $seller): ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($seller->name) ?></td>
									<td><?= h($seller->firm_name) ?></td>
									<td><?= h($seller->email) ?></td>
									<td><?= h($seller->mobile_no) ?></td>
									<td><?= h($seller->gstin) ?></td>
									<td><?= h($seller->gstin_holder_name) ?></td>
									<td><?= h($seller->registration_date) ?></td>
									
									<td><?= h($seller->status) ?></td>
									<td class="actions">
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $seller->id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $seller->id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?', $seller->id),'escape'=>false]) ?>
										<?= $this->Html->link(__('View'), ['action' => 'view', $seller->id]) ?>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel-footer">
					<div class="paginator pull-right">
						<ul class="pagination">
							<?= $this->Paginator->first(__('First')) ?>
							<?= $this->Paginator->prev(__('Previous')) ?>
							<?= $this->Paginator->numbers() ?>
							<?= $this->Paginator->next(__('Next')) ?>
							<?= $this->Paginator->last(__('Last')) ?>
						</ul>
						<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
					</div>
				</div>
			</div>
			
		</div>
	</div>                    
	
</div>