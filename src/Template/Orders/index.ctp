<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Orders'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Orders</strong></h3>
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
									<th><?= ('Order No') ?></th>
									<th><?= ('Customer Name') ?></th>
									<th><?= ('Locality') ?></th>
									<th><?= ('Grand Total') ?></th>
									<th><?= ('Order Type') ?></th>
									<th><?= ('Status') ?></th>
									
									<th scope="col" class="actions"><?= __('Actions') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($orders as $order): //pr($order); exit; ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td>
										<?php echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'view', $order->id, 'print'],['target'=>'_blank']); ?>
									</td>
									<td><?= h($order->party_ledger->name) ?></td>
									<td><?= h($order->location->name) ?></td>
									<td><?= h($order->grand_total) ?></td>
									<td><?= h($order->order_type) ?></td>
									<td><?= h($order->order_status) ?></td>
									
									
									
									<td class="actions">
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $order->id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										
										<!--<?= $this->Html->link(__('<span class="fa fa-credit-card"> Order Deliver</span>'), ['action' => 'orderDeliver', $order->id],['class'=>'btn btn-success btn-sm','escape'=>false]) ?>-->
										
										
										
									
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