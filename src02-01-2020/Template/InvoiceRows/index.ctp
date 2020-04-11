<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoiceRow[]|\Cake\Collection\CollectionInterface $invoiceRows
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Invoice Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Order Details'), ['controller' => 'OrderDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order Detail'), ['controller' => 'OrderDetails', 'action' => 'add']) ?></li>
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
<div class="invoiceRows index large-9 medium-8 columns content">
    <h3><?= __('Invoice Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_detail_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_variation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('combo_offer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('actual_quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_percent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('promo_percent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('promo_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('taxable_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_percentage') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_figure_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('net_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_item_cancel') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoiceRows as $invoiceRow): ?>
            <tr>
                <td><?= $this->Number->format($invoiceRow->id) ?></td>
                <td><?= $invoiceRow->has('invoice') ? $this->Html->link($invoiceRow->invoice->id, ['controller' => 'Invoices', 'action' => 'view', $invoiceRow->invoice->id]) : '' ?></td>
                <td><?= $invoiceRow->has('order_detail') ? $this->Html->link($invoiceRow->order_detail->id, ['controller' => 'OrderDetails', 'action' => 'view', $invoiceRow->order_detail->id]) : '' ?></td>
                <td><?= $invoiceRow->has('item') ? $this->Html->link($invoiceRow->item->name, ['controller' => 'Items', 'action' => 'view', $invoiceRow->item->id]) : '' ?></td>
                <td><?= $invoiceRow->has('item_variation') ? $this->Html->link($invoiceRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $invoiceRow->item_variation->id]) : '' ?></td>
                <td><?= $invoiceRow->has('combo_offer') ? $this->Html->link($invoiceRow->combo_offer->name, ['controller' => 'ComboOffers', 'action' => 'view', $invoiceRow->combo_offer->id]) : '' ?></td>
                <td><?= $this->Number->format($invoiceRow->quantity) ?></td>
                <td><?= $this->Number->format($invoiceRow->actual_quantity) ?></td>
                <td><?= $this->Number->format($invoiceRow->rate) ?></td>
                <td><?= $this->Number->format($invoiceRow->amount) ?></td>
                <td><?= $this->Number->format($invoiceRow->discount_percent) ?></td>
                <td><?= $this->Number->format($invoiceRow->discount_amount) ?></td>
                <td><?= $this->Number->format($invoiceRow->promo_percent) ?></td>
                <td><?= $this->Number->format($invoiceRow->promo_amount) ?></td>
                <td><?= $this->Number->format($invoiceRow->taxable_value) ?></td>
                <td><?= $this->Number->format($invoiceRow->gst_percentage) ?></td>
                <td><?= $invoiceRow->has('gst_figure') ? $this->Html->link($invoiceRow->gst_figure->name, ['controller' => 'GstFigures', 'action' => 'view', $invoiceRow->gst_figure->id]) : '' ?></td>
                <td><?= $this->Number->format($invoiceRow->gst_value) ?></td>
                <td><?= $this->Number->format($invoiceRow->net_amount) ?></td>
                <td><?= h($invoiceRow->is_item_cancel) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $invoiceRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invoiceRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $invoiceRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceRow->id)]) ?>
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
