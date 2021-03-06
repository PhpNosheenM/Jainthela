<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Sales Orders'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong> Sales Orders</strong></h3>
					<div class="pull-right">
						<div class="pull-left">
							<?= $this->Form->create('Search',['type'=>'GET']) ?>
									<?= $this->Html->link(__('<span class="fa fa-plus"></span> Add Sales Orders'), ['action' => 'add'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
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
									<th><?= ('Delivery Date') ?></th>
									<th><?= ('Delivery Time') ?></th>
									<th><?= ('Manage Order') ?></th>
									<th><?= ('Delete') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($salesOrders as $order): //pr($order); exit;]
											$trans_date=date('d-M-Y', strtotime($order->delivery_date));
											$status=$order->order_status;
											$sales_order_id = $EncryptingDecrypting->encryptData($order->id);
											$time_from=$order->delivery_time->time_from;
											$time_to=$order->delivery_time->time_to;
											$show_time=$time_from.' - '.$time_to;
										?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($order->sales_order_no) ?></td>
									<td><?= h($order->customer->name) ?></td>
									<td><?= h($order->city->name) ?></td>
									<td><?= h($order->grand_total) ?></td>
									<td><?= h($trans_date) ?></td>
									<td><?= h($show_time) ?></td>
									<?php if($status=='Yes'){ ?>
									<td><?= h($order->order_status) ?></td>
									<td>Used</td>
									<?php }else{ ?>
									<?php $order_id = $EncryptingDecrypting->encryptData($order->id); ?>
									<td>
										<?= $this->Html->link(__('<span class="fa fa-pencil"> Create Order </span>'), ['controller'=>'Orders', 'action' => 'add', $order_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
									</td>
									<td>
									<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $sales_order_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
									</td>
									<?php } ?>
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