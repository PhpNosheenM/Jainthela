<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Routes'); ?>
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Routes</strong></h3>
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
									<th><?= ('City') ?></th>
									<th><?= ('Locations') ?></th>
									<th><?= ('Narration') ?></th>
									<th><?= ('Created On') ?></th>
									<th><?= ('Status') ?></th>
									<th scope="col" class="actions"><?= __('Actions') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($routes as $data): 
								   
								  ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($data->name) ?></td>
									<td><?= h($data->city->name) ?></td>
									<td><?= h(@$data->location->name) ?> </td>
									<td><?= h(@$data->narration) ?></td>
									<td><?= h($data->created_on) ?></td>
									<td><?= h($data->status) ?></td>
									
									<td class="actions">
										<?php
											$route_id = $EncryptingDecrypting->encryptData($data->id);
										?>
										<?= $this->Html->link(__('<span class="fa fa-eye"></span>'), ['action' => 'view', $route_id],['class'=>'btn btn-success  btn-condensed btn-sm','escape'=>false]) ?>
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $route_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $route_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
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
