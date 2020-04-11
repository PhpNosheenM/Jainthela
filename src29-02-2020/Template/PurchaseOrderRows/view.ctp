<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseOrderRow $purchaseOrderRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Purchase Order Row'), ['action' => 'edit', $purchaseOrderRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Purchase Order Row'), ['action' => 'delete', $purchaseOrderRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrderRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Order Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Orders'), ['controller' => 'PurchaseOrders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order'), ['controller' => 'PurchaseOrders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Unit Variations'), ['controller' => 'UnitVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit Variation'), ['controller' => 'UnitVariations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="purchaseOrderRows view large-9 medium-8 columns content">
    <h3><?= h($purchaseOrderRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Purchase Order') ?></th>
            <td><?= $purchaseOrderRow->has('purchase_order') ? $this->Html->link($purchaseOrderRow->purchase_order->id, ['controller' => 'PurchaseOrders', 'action' => 'view', $purchaseOrderRow->purchase_order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $purchaseOrderRow->has('item') ? $this->Html->link($purchaseOrderRow->item->name, ['controller' => 'Items', 'action' => 'view', $purchaseOrderRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $purchaseOrderRow->has('item_variation') ? $this->Html->link($purchaseOrderRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $purchaseOrderRow->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Unit Variation') ?></th>
            <td><?= $purchaseOrderRow->has('unit_variation') ? $this->Html->link($purchaseOrderRow->unit_variation->id, ['controller' => 'UnitVariations', 'action' => 'view', $purchaseOrderRow->unit_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($purchaseOrderRow->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($purchaseOrderRow->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $this->Number->format($purchaseOrderRow->rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Net Amount') ?></th>
            <td><?= $this->Number->format($purchaseOrderRow->net_amount) ?></td>
        </tr>
    </table>
</div>
