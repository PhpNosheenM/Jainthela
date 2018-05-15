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
				<div class="pull-right">
			<div class="pull-left">
				<?= $this->Form->create('Search',['type'=>'GET']) ?>
					<div class="form-group" style="display:inline-table">
						<div class="input-group">
							<div class="input-group-addon">
								<span class="fa fa-search"></span>
							</div>
							<?= $this->Form->control('search',['class'=>'form-control','placeholder'=>'Search...','label'=>false]) ?>
							<div class="input-group-btn">
								<?= $this->Form->button(__('Search'),['class'=>'btn btn-primary']) ?>
							</div>
						</div>
					</div>
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
									<th><?= ('Firm Name') ?></th>
									<th><?= ('Firm Email') ?></th>
									<th><?= ('Firm Address') ?></th>
									<th><?= ('Firm Contact') ?></th>
									<th><?= ('Firm Pincode') ?></th>
									<th><?= ('Pan') ?></th>
									<th><?= ('GSTIN') ?></th>
									<th><?= ('GSTIN Holder') ?></th>
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
									<td><?= h($seller->firm_email) ?></td>
									<td><?= h($seller->firm_address) ?></td>
									<td><?= h($seller->firm_contact) ?></td>
									<td><?= h($seller->firm_pincode) ?></td>
									<td><?= h($seller->pan) ?></td>
									<td><?= h($seller->gstin) ?></td>
									<td><?= h($seller->gstin_holder_name) ?></td>
									<td><?= h($seller->status) ?></td>
									<td class="actions">
										
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $seller->id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $seller->id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?', $seller->id),'escape'=>false]) ?>
									
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