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
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Item</strong></h3>
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
									<th><?= ('Category') ?></th>
									<th><?= ('Item') ?></th>
									<th><?= ('Seller') ?></th>
									<th><?= ('Commission') ?></th>
									<th><?= ('Date From') ?></th>
									<th><?= ('Date To') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1); ?>
								
								  <?php foreach ($SellerItems as $data): ?>
								<tr>
									<td><?= $this->Number->format(++$i) ?></td>
									<td><?= h($item->category->name) ?></td>
									<td><?= h($item->item->name) ?></td>
									<td><?= h($item->seller->name) ?></td>
									<td><?= h(@$item->commission_percentage) ?></td>
									<td><?= h(@$item->commission_created_on) ?></td>
									<td><?= h($item->expiry_on_date) ?></td>
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


<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SellerItem[]|\Cake\Collection\CollectionInterface $sellerItems
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Seller Item'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sellers'), ['controller' => 'Sellers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller'), ['controller' => 'Sellers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Seller Item Variations'), ['controller' => 'SellerItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller Item Variation'), ['controller' => 'SellerItemVariations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sellerItems index large-9 medium-8 columns content">
    <h3><?= __('Seller Items') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('seller_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('commission_percentage') ?></th>
                <th scope="col"><?= $this->Paginator->sort('commission_created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('expiry_on_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sellerItems as $sellerItem): ?>
            <tr>
                <td><?= $this->Number->format($sellerItem->id) ?></td>
                <td><?= $sellerItem->has('item') ? $this->Html->link($sellerItem->item->name, ['controller' => 'Items', 'action' => 'view', $sellerItem->item->id]) : '' ?></td>
                <td><?= $sellerItem->has('category') ? $this->Html->link($sellerItem->category->name, ['controller' => 'Categories', 'action' => 'view', $sellerItem->category->id]) : '' ?></td>
                <td><?= $sellerItem->has('seller') ? $this->Html->link($sellerItem->seller->name, ['controller' => 'Sellers', 'action' => 'view', $sellerItem->seller->id]) : '' ?></td>
                <td><?= h($sellerItem->created_on) ?></td>
                <td><?= $this->Number->format($sellerItem->created_by) ?></td>
                <td><?= $this->Number->format($sellerItem->commission_percentage) ?></td>
                <td><?= h($sellerItem->commission_created_on) ?></td>
                <td><?= h($sellerItem->expiry_on_date) ?></td>
                <td><?= $this->Number->format($sellerItem->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $sellerItem->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sellerItem->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sellerItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sellerItem->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
