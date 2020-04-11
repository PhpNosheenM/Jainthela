<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Promotions'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Promotions</strong></h3>
				<div class="pull-right">
			<div class="pull-left">
				<?= $this->Form->create('Search',['type'=>'GET']) ?>
				<?= $this->Html->link(__('Add New'), ['action' => 'add'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
					<div class="form-group" style="display:inline-table;width:500px;">
						<div class="input-group">
							<div class="input-group-addon">
								<span class="fa fa-search"></span>
							</div>
							<?= $this->Form->control('search',['class'=>'form-control','placeholder'=>'Search...','label'=>false,'value'=>@$search]) ?>
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
									<th><?= ('Offer Name') ?></th>
									<th><?= ('Admin') ?></th>
									<th><?= ('City') ?></th>
									<th><?= ('Start Date') ?></th>
									<th><?= ('End Date') ?></th>
									<th><?= ('Status') ?></th>
									<th scope="col" class="actions"><?= __('Actions') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($promotions as $promotion) : ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($promotion->offer_name) ?></td>
									<td><?= h(@$promotion->admin->name) ?></td>
									<td><?= h($promotion->city->name) ?></td>
									<td><?= h(date("d-m-Y",strtotime($promotion->start_date))) ?></td>
									<td><?= h(date("d-m-Y",strtotime($promotion->end_date))) ?></td>
									<td><?= h($promotion->status) ?></td>
									<td class="actions">
										<?php
											$promotion_id = $EncryptingDecrypting->encryptData($promotion->id);
										?>
										<?= $this->Html->link(__('<span class="fa fa-eye"></span>'), ['action' => 'view', $promotion_id],['class'=>'btn btn-success  btn-condensed btn-sm','escape'=>false]) ?>
										 
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $promotion_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
									
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
