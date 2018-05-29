<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SalesOrderRow $salesOrderRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sales Order Row'), ['action' => 'edit', $salesOrderRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sales Order Row'), ['action' => 'delete', $salesOrderRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesOrderRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sales Order Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Order Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Orders'), ['controller' => 'SalesOrders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Order'), ['controller' => 'SalesOrders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combo Offers'), ['controller' => 'ComboOffers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo Offer'), ['controller' => 'ComboOffers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Gst Figures'), ['controller' => 'GstFigures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Gst Figure'), ['controller' => 'GstFigures', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="salesOrderRows view large-9 medium-8 columns content">
    <h3><?= h($salesOrderRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Sales Order') ?></th>
            <td><?= $salesOrderRow->has('sales_order') ? $this->Html->link($salesOrderRow->sales_order->id, ['controller' => 'SalesOrders', 'action' => 'view', $salesOrderRow->sales_order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $salesOrderRow->has('item') ? $this->Html->link($salesOrderRow->item->name, ['controller' => 'Items', 'action' => 'view', $salesOrderRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $salesOrderRow->has('item_variation') ? $this->Html->link($salesOrderRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $salesOrderRow->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Combo Offer') ?></th>
            <td><?= $salesOrderRow->has('combo_offer') ? $this->Html->link($salesOrderRow->combo_offer->name, ['controller' => 'ComboOffers', 'action' => 'view', $salesOrderRow->combo_offer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Figure') ?></th>
            <td><?= $salesOrderRow->has('gst_figure') ? $this->Html->link($salesOrderRow->gst_figure->name, ['controller' => 'GstFigures', 'action' => 'view', $salesOrderRow->gst_figure->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($salesOrderRow->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($salesOrderRow->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $this->Number->format($salesOrderRow->rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($salesOrderRow->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Percentage') ?></th>
            <td><?= $this->Number->format($salesOrderRow->gst_percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Value') ?></th>
            <td><?= $this->Number->format($salesOrderRow->gst_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Net Amount') ?></th>
            <td><?= $this->Number->format($salesOrderRow->net_amount) ?></td>
        </tr>
    </table>
</div>
