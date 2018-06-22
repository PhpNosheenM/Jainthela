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
					<h3 class="panel-title"><strong> Manage Orders </strong></h3>
					<div class="pull-right">
					<?php if($status=='pending'){
						$class1="btn btn-xs blue";
						$class2="btn btn-default";
					}else {
						$class1="btn btn-default";
						$class2="btn btn-xs blue";
					}
					 ?> 
						<?php echo $this->Html->link('Pending',['controller'=>'Orders','action' => 'manage_order?status=pending'],['escape'=>false,'class'=>$class1]); ?>
						<?php echo $this->Html->link('All',['controller'=>'Orders','action' => 'manage_order'],['escape'=>false,'class'=>$class2]); ?>&nbsp;
				</div> 	
				</div>
				<div class="panel-body">    
					<div class="table-responsive">
						<table class="table-bordered" width="100%">
							<thead>
								<tr height="40px">
									<th><?= ('SNo.') ?></th>
									<th><?= ('Order No') ?></th>
									<th><?= ('Customer Name') ?></th>
									<th><?= ('Locality') ?></th>
									<th><?= ('Grand Total') ?></th>
									<th><?= ('Order Type') ?></th>
									<th><?= ('Order Date') ?></th>
									<th><?= ('Delivery Date') ?></th>
									<th><?= ('Order Time') ?></th>
									<th><?= ('Status') ?></th>
									<th><?= ('Action') ?></th>
									<th><?= ('Edit') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($orders as $order): //pr($order); exit; 
								  
								  $order_date=$order->order_date;
								  $delivery_date=$order->delivery_date;
								  $time_from=$order->delivery_time->time_from;
								  $time_to=$order->delivery_time->time_to;
								  $delivery_time=$time_from.'-'.$time_to;
								  ?>
								<tr 
								<?php if(($order->order_status=='pending') || ($order->order_status=='pending')){ ?>
									style="background-color:#ffe4e4 !important;"
								<?php } ?> height="40px" >
									<td><?= $this->Number->format(++$i) ?></td>
									<td>
										<?php $order_id = $EncryptingDecrypting->encryptData($order->id); ?>
										<?php echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'view', $order_id, 'print'],['target'=>'_blank']); ?>
									</td>
									<td><?= h($order->customer->name) ?></td>
									<td><?= h($order->location->name) ?></td>
									<td><?= h($order->grand_total) ?></td>
									<td><?= h($order->order_type) ?></td>
									<td><?= h($order_date) ?></td>
									<td><?= h($delivery_date) ?></td>
									<td><?= h($delivery_time) ?></td>
									<td><?= h($order->order_status) ?></td>
									<td>&nbsp; 
										<?= $this->Html->link(__('Packing'), ['action' => 'edit', $order->id],['class'=>'btn btn-success  btn-condensed btn-sm','escape'=>false]) ?>
									
										<?= $this->Html->link(__('Dispatch'), ['action' => 'edit', $order->id],['class'=>'btn btn-warning  btn-condensed btn-sm','escape'=>false]) ?>
										
										<?= $this->Html->link(__('Deliver'), ['action' => 'edit', $order->id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										 
										 <?= $this->Html->link(__('Cancel'), ['action' => 'edit', $order->id],['class'=>'btn btn-danger  btn-condensed btn-sm','escape'=>false]) ?>
									</td>
									
									<td class="actions">
										<?= $this->Html->link(__('Edit'), ['action' => 'edit', $order->id],['class'=>'btn btn-condensed btn-sm','escape'=>false]) ?>
										 
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