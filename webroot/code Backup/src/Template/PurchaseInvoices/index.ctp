<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Purchase Invoice'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Purchase Invoice</strong></h3>
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
									<th><?= ('Invoice No') ?></th>
									<th><?= ('Party') ?></th>
									<th><?= ('Location') ?></th>
									<th><?= ('Amount') ?></th>
									
									<th scope="col" class="actions"><?= __('Actions') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($purchaseInvoices as $purchaseInvoice): //pr($purchaseInvoice);  ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($purchaseInvoice->invoice_no) ?></td>
									<td><?= h($purchaseInvoice->seller_ledger->seller->name) ?></td>
									<td><?= h($purchaseInvoice->location->name) ?></td>
									<td><?= h($purchaseInvoice->total_amount) ?></td>
									
									<td class="actions">
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $purchaseInvoice->id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										
									
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