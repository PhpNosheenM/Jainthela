<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoiceRow $invoiceRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Invoice Row'), ['action' => 'edit', $invoiceRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Invoice Row'), ['action' => 'delete', $invoiceRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Invoice Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoice Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Order Details'), ['controller' => 'OrderDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order Detail'), ['controller' => 'OrderDetails', 'action' => 'add']) ?> </li>
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
<div class="invoiceRows view large-9 medium-8 columns content">
    <h3><?= h($invoiceRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Invoice') ?></th>
            <td><?= $invoiceRow->has('invoice') ? $this->Html->link($invoiceRow->invoice->id, ['controller' => 'Invoices', 'action' => 'view', $invoiceRow->invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Detail') ?></th>
            <td><?= $invoiceRow->has('order_detail') ? $this->Html->link($invoiceRow->order_detail->id, ['controller' => 'OrderDetails', 'action' => 'view', $invoiceRow->order_detail->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $invoiceRow->has('item') ? $this->Html->link($invoiceRow->item->name, ['controller' => 'Items', 'action' => 'view', $invoiceRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $invoiceRow->has('item_variation') ? $this->Html->link($invoiceRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $invoiceRow->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Combo Offer') ?></th>
            <td><?= $invoiceRow->has('combo_offer') ? $this->Html->link($invoiceRow->combo_offer->name, ['controller' => 'ComboOffers', 'action' => 'view', $invoiceRow->combo_offer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Figure') ?></th>
            <td><?= $invoiceRow->has('gst_figure') ? $this->Html->link($invoiceRow->gst_figure->name, ['controller' => 'GstFigures', 'action' => 'view', $invoiceRow->gst_figure->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Item Cancel') ?></th>
            <td><?= h($invoiceRow->is_item_cancel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($invoiceRow->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($invoiceRow->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Actual Quantity') ?></th>
            <td><?= $this->Number->format($invoiceRow->actual_quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $this->Number->format($invoiceRow->rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($invoiceRow->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Percent') ?></th>
            <td><?= $this->Number->format($invoiceRow->discount_percent) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Amount') ?></th>
            <td><?= $this->Number->format($invoiceRow->discount_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Promo Percent') ?></th>
            <td><?= $this->Number->format($invoiceRow->promo_percent) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Promo Amount') ?></th>
            <td><?= $this->Number->format($invoiceRow->promo_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Taxable Value') ?></th>
            <td><?= $this->Number->format($invoiceRow->taxable_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Percentage') ?></th>
            <td><?= $this->Number->format($invoiceRow->gst_percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Value') ?></th>
            <td><?= $this->Number->format($invoiceRow->gst_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Net Amount') ?></th>
            <td><?= $this->Number->format($invoiceRow->net_amount) ?></td>
        </tr>
    </table>
</div>
