<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Stock Transfer Vouchers'); ?>
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Stock Transfer Vouchers</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
								<?= $this->Form->create('Search',['type'=>'GET']) ?>
								<?= $this->Html->link(__('<span class="fa fa-plus"></span> Add New'), ['controller'=>'Grns','action' => 'index'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
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
									<th><?= ('Voucher No.') ?></th>
									<th><?= ('Transfer To') ?></th>
									<th><?= ('Transaction Date') ?></th>
									<th><?= ('Action') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($stockTransferVouchers as $stockTransferVoucher):

									$stockTransferVoucher_id = $EncryptingDecrypting->encryptData($stockTransferVoucher->id);
								  ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($stockTransferVoucher->voucher_no) ?></td>
									<td><?= h($stockTransferVoucher->location->name) ?></td>
									<td><?= h(@$stockTransferVoucher->transaction_date) ?></td>
									<td>
									<!--<?= $this->Html->link(__('<span class="fa fa-edit"></span> Edit'), ['action' => 'edit',$stockTransferVoucher->id],['class'=>'btn btn-danger btn-xs','escape'=>false]) ?>-->
									<?= $this->Html->link(__('<span class="fa fa-search"></span> View'), ['action' => 'view',$stockTransferVoucher_id],['class'=>'btn btn-warning btn-xs','escape'=>false]) ?>
									<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $stockTransferVoucher->id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to Delete?'),'escape'=>false]) ?>
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