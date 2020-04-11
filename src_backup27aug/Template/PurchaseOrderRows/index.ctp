<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseOrderRow[]|\Cake\Collection\CollectionInterface $purchaseOrderRows
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Purchase Order Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Orders'), ['controller' => 'PurchaseOrders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Order'), ['controller' => 'PurchaseOrders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Unit Variations'), ['controller' => 'UnitVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Unit Variation'), ['controller' => 'UnitVariations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="purchaseOrderRows index large-9 medium-8 columns content">
    <h3><?= __('Purchase Order Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_order_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_variation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('unit_variation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('net_amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchaseOrderRows as $purchaseOrderRow): ?>
            <tr>
                <td><?= $this->Number->format($purchaseOrderRow->id) ?></td>
                <td><?= $purchaseOrderRow->has('purchase_order') ? $this->Html->link($purchaseOrderRow->purchase_order->id, ['controller' => 'PurchaseOrders', 'action' => 'view', $purchaseOrderRow->purchase_order->id]) : '' ?></td>
                <td><?= $purchaseOrderRow->has('item') ? $this->Html->link($purchaseOrderRow->item->name, ['controller' => 'Items', 'action' => 'view', $purchaseOrderRow->item->id]) : '' ?></td>
                <td><?= $purchaseOrderRow->has('item_variation') ? $this->Html->link($purchaseOrderRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $purchaseOrderRow->item_variation->id]) : '' ?></td>
                <td><?= $purchaseOrderRow->has('unit_variation') ? $this->Html->link($purchaseOrderRow->unit_variation->id, ['controller' => 'UnitVariations', 'action' => 'view', $purchaseOrderRow->unit_variation->id]) : '' ?></td>
                <td><?= $this->Number->format($purchaseOrderRow->quantity) ?></td>
                <td><?= $this->Number->format($purchaseOrderRow->rate) ?></td>
                <td><?= $this->Number->format($purchaseOrderRow->net_amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $purchaseOrderRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $purchaseOrderRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $purchaseOrderRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrderRow->id)]) ?>
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
