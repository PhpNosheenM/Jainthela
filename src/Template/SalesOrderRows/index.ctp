<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SalesOrderRow[]|\Cake\Collection\CollectionInterface $salesOrderRows
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Sales Order Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales Orders'), ['controller' => 'SalesOrders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sales Order'), ['controller' => 'SalesOrders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Combo Offers'), ['controller' => 'ComboOffers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Combo Offer'), ['controller' => 'ComboOffers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Gst Figures'), ['controller' => 'GstFigures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Gst Figure'), ['controller' => 'GstFigures', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="salesOrderRows index large-9 medium-8 columns content">
    <h3><?= __('Sales Order Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_order_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_variation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('combo_offer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_percentage') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_figure_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('net_amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salesOrderRows as $salesOrderRow): ?>
            <tr>
                <td><?= $this->Number->format($salesOrderRow->id) ?></td>
                <td><?= $salesOrderRow->has('sales_order') ? $this->Html->link($salesOrderRow->sales_order->id, ['controller' => 'SalesOrders', 'action' => 'view', $salesOrderRow->sales_order->id]) : '' ?></td>
                <td><?= $salesOrderRow->has('item') ? $this->Html->link($salesOrderRow->item->name, ['controller' => 'Items', 'action' => 'view', $salesOrderRow->item->id]) : '' ?></td>
                <td><?= $salesOrderRow->has('item_variation') ? $this->Html->link($salesOrderRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $salesOrderRow->item_variation->id]) : '' ?></td>
                <td><?= $salesOrderRow->has('combo_offer') ? $this->Html->link($salesOrderRow->combo_offer->name, ['controller' => 'ComboOffers', 'action' => 'view', $salesOrderRow->combo_offer->id]) : '' ?></td>
                <td><?= $this->Number->format($salesOrderRow->quantity) ?></td>
                <td><?= $this->Number->format($salesOrderRow->rate) ?></td>
                <td><?= $this->Number->format($salesOrderRow->amount) ?></td>
                <td><?= $this->Number->format($salesOrderRow->gst_percentage) ?></td>
                <td><?= $salesOrderRow->has('gst_figure') ? $this->Html->link($salesOrderRow->gst_figure->name, ['controller' => 'GstFigures', 'action' => 'view', $salesOrderRow->gst_figure->id]) : '' ?></td>
                <td><?= $this->Number->format($salesOrderRow->gst_value) ?></td>
                <td><?= $this->Number->format($salesOrderRow->net_amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $salesOrderRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $salesOrderRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $salesOrderRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesOrderRow->id)]) ?>
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
