<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Item'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Pending Item Request</strong></h3>
				<div class="pull-right">
			
		</div> 	
				</div>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?= ('SNo.') ?></th>
									<th><?= ('Seller name') ?></th>
									<th><?= ('status') ?></th>
									<th><?= ('Action') ?></th>
									 
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($sellerRequests as $sellerRequest): ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($sellerRequest->seller->name) ?></td>
									<td><?= h($sellerRequest->status) ?></td>
									<td> <?= $this->Html->link(__('<span class="">View</span>'), ['action' => 'View', $sellerRequest->id],['class'=>'btn btn-success btn-sm','escape'=>false]) ?>
									<?= $this->Html->link(__('<span class="">Approve</span>'), ['action' => 'sellerRequestApprove', $sellerRequest->id],['class'=>'btn btn-success btn-sm','escape'=>false]) ?>
									<?= $this->Html->link(__('<span class="">Un-Approve</span>'), ['action' => 'sellerRequestCancle', $sellerRequest->id],['class'=>'btn btn-danger btn-sm','escape'=>false]) ?></td>
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