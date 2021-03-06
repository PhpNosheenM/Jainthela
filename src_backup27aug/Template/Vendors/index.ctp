<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Vendors'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Vendors List</strong></h3>
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
									<th><?= ('name') ?></th>
									<th><?= ('Firm Name') ?></th>
									<th><?= ('Firm Address') ?></th>
									<th><?= ('Firm Pincode') ?></th>
									<th><?= ('GSTIN') ?></th>
									<th><?= ('Pan') ?></th>
 									<th><?= ('status') ?></th>
									<th scope="col" class="actions"><?= __('Actions') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($vendors as $vendor): ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($vendor->name) ?></td>
									<td><?= h($vendor->firm_name) ?></td>
									<td><?= h($vendor->firm_address) ?></td>
									<td><?= h($vendor->firm_pincode) ?></td>
									<td><?= h($vendor->gstin) ?></td>
									<td><?= h($vendor->pan) ?></td>
 									<td><?= h($vendor->status) ?></td>
									<td class="actions">
										<?php
											$vendor_id = $EncryptingDecrypting->encryptData($vendor->id);
										?>
										
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $vendor_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
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