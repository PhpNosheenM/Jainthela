<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Combo Offer'); ?>
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Combo Offer</strong></h3>
				<div class="pull-right">
			<div class="pull-left">
					<?= $this->Form->create('Search',['type'=>'GET']) ?>
					<?= $this->Html->link(__(' Add New'), ['action' => 'add'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
					<div class="form-group" style="display:inline-table;width:500px;">
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
									<th><?= ('Name') ?></th>
									<th><?= ('Print Rate') ?></th>
									<th><?= ('Discount %') ?></th>
									<th><?= ('Sales Rate') ?></th>
									<th><?= ('Max Purchase') ?></th>
									<th><?= ('Valid Till') ?></th>
									<th><?= ('Ready To Sale') ?></th>
									<th><?= ('Status') ?></th>
									<th scope="col" class="actions"><?= __('Actions') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($comboOffers as $comboOffer): 
								  
											$valid_till=date('d-M-Y', strtotime($comboOffer->end_date));
								  ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($comboOffer->name) ?></td>
									<td><?= h($comboOffer->print_rate) ?></td>
									<td><?= h(@$comboOffer->discount_per) ?> %</td>
									<td><?= h(@$comboOffer->sales_rate) ?></td>
									<td><?= h($comboOffer->maximum_quantity_purchase) ?></td>
									<td><?= h($valid_till) ?></td>
									<td><?= h($comboOffer->ready_to_sale) ?></td>
									<td><?= h($comboOffer->status) ?></td>
									
									<td class="actions">
										<?php
											$comboOffer_id = $EncryptingDecrypting->encryptData($comboOffer->id);
										?>
										<?= $this->Html->link(__('<span class="fa fa-eye"></span>'), ['action' => 'view', $comboOffer_id],['class'=>'btn btn-success  btn-condensed btn-sm','escape'=>false]) ?>
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edits', $comboOffer_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $comboOffer_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
									
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
