<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Journal Voucher'); ?>
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Journal Voucher</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
								<?= $this->Form->create('Search',['type'=>'GET']) ?>
								<?= $this->Html->link(__('<span class="fa fa-plus"></span> Add New'), ['action' => 'add'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
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
									<th><?= ('City') ?></th>
									<th><?= ('Narration') ?></th>
									<th><?= ('Amount') ?></th>
									<th><?= ('Transaction Date') ?></th>
									<th><?= ('Created On') ?></th>
									<th><?= ('Action') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($journalVouchers as $journalVoucher): 
								  
											$transaction_date=date('d-M-Y', strtotime($journalVoucher->transaction_date));
											foreach($journalVoucher->journal_voucher_rows as $data){
												$amount=$data->credit;
											}
											$journalVoucher_id = $EncryptingDecrypting->encryptData($journalVoucher->id);
								  ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($journalVoucher->voucher_no) ?></td>
									<td><?= h($journalVoucher->city->name) ?></td>
									<td><?= h(@$journalVoucher->narration) ?></td>
									<td><?= h(@$amount) ?></td>
									<td><?= h(@$transaction_date) ?></td>
									<td><?= h($journalVoucher->created_on) ?></td>
									<td>
										<?= $this->Html->link(__('<span class="fa fa-edit"></span> Edit'), ['action' => 'edit',$journalVoucher_id],['class'=>'btn btn-danger btn-xs','escape'=>false]) ?>
										<?= $this->Html->link(__('<span class="fa fa-search"></span> View'), ['action' => 'view',$journalVoucher_id],['class'=>'btn btn-warning btn-xs','escape'=>false]) ?></td>
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