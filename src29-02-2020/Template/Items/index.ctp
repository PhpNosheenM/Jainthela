<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: transparent;
    padding: 8px 8px !important; 
    background: #F0F4F9;
    color: #656C78;
    font-size: 13px;
}
</style>
<?php $this->set('title', 'Item'); ?><!-- PAGE CONTENT WRAPPER -->
<div class="content-frame">
	<div class="content-frame-top">
        <div class="page-title">
			<h2></h2>
		</div>
		<div class="pull-right">
			<?php  if(($status=='Deactive') || ($status=='deactive')){
						$class1="btn btn-default";
						$class2="btn btn-xs blue";
					}else{
						$class1="btn btn-xs blue";
						$class2="btn btn-default";
					}
			 ?>
				<?php echo $this->Html->link('All',['controller'=>'Items','action' => 'index?status=Active'],['escape'=>false,'class'=>$class1]); ?>
				<?php echo $this->Html->link('Archive',['controller'=>'Items','action' => 'index?status=Deactive'],['escape'=>false,'class'=>$class2]); ?>&nbsp;
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Item</strong></h3>
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
									<th><?= ('Type In Hindi') ?></th>
									<th><?= ('HSN Code') ?></th>
									<th><?= ('category') ?></th>
									<th><?= ('brand') ?></th>
									<th><?= ('minimum stock') ?></th>
									<th><?= ('Stock Manage By') ?></th>
									<th><?= ('Discount Enable') ?></th>
									<th><?= ('Item Status') ?></th>
									<?php if($status=='deactive'){ ?>
									<th><?= ('Edited On') ?></th>
									<?php } ?>
									<th scope="col" class="actions"><?= __('Actions') ?></th>
								</tr>
							</thead>
							<tbody>                                            
								<?php $i = 0; ?>
								
								  <?php foreach ($items as $item): ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($item->name) ?></td>
									<td><?= h($item->alias_name) ?></td>
									<td><?= h($item->hsn_code) ?></td>
									<td><?= h(@$item->category->name) ?></td>
									<td><?= h(@$item->brand->name) ?></td>
									<td><?= h($item->minimum_stock) ?></td>
									<td><?= h($item->item_maintain_by) ?></td>
									<td><?= h($item->is_discount_enable) ?></td>
									<td><?= h($item->status) ?></td>
									<?php if($status=='deactive'){ ?>
									<td><?= h($item->edited_on) ?></td>
									<?php } ?>
									
									<td class="actions">
										<?php
											$item_id = $EncryptingDecrypting->encryptData($item->id);
										?>
										
										<?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $item_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
										<?php if($item->status=="Active"){ ?>
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'delete', $item_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to Deactive?'),'escape'=>false]) ?>
										<?php } ?>
										<?php if($status=="deactive"){ ?>
										<?= $this->Form->postLink('<span class="fa fa-remove"></span>', ['action' => 'deleteParmanent', $item_id], ['class'=>'btn btn-danger btn-condensed btn-sm','confirm' => __('Are you sure you want to Deactive Permanent?'),'escape'=>false]) ?>
										<?php } ?>
									
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
			
		</div>
	</div>                    
	
</div>