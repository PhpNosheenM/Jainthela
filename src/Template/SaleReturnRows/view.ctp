<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SaleReturnRow $saleReturnRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sale Return Row'), ['action' => 'edit', $saleReturnRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sale Return Row'), ['action' => 'delete', $saleReturnRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleReturnRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sale Return Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['controller' => 'SaleReturns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return'), ['controller' => 'SaleReturns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Gst Figures'), ['controller' => 'GstFigures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Gst Figure'), ['controller' => 'GstFigures', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Order Details'), ['controller' => 'OrderDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order Detail'), ['controller' => 'OrderDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Ledgers'), ['controller' => 'ItemLedgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Ledger'), ['controller' => 'ItemLedgers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="saleReturnRows view large-9 medium-8 columns content">
    <h3><?= h($saleReturnRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Sale Return') ?></th>
            <td><?= $saleReturnRow->has('sale_return') ? $this->Html->link($saleReturnRow->sale_return->id, ['controller' => 'SaleReturns', 'action' => 'view', $saleReturnRow->sale_return->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $saleReturnRow->has('item_variation') ? $this->Html->link($saleReturnRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $saleReturnRow->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Figure') ?></th>
            <td><?= $saleReturnRow->has('gst_figure') ? $this->Html->link($saleReturnRow->gst_figure->name, ['controller' => 'GstFigures', 'action' => 'view', $saleReturnRow->gst_figure->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Detail') ?></th>
            <td><?= $saleReturnRow->has('order_detail') ? $this->Html->link($saleReturnRow->order_detail->id, ['controller' => 'OrderDetails', 'action' => 'view', $saleReturnRow->order_detail->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($saleReturnRow->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Return Quantity') ?></th>
            <td><?= $this->Number->format($saleReturnRow->return_quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $this->Number->format($saleReturnRow->rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($saleReturnRow->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Taxable Value') ?></th>
            <td><?= $this->Number->format($saleReturnRow->taxable_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Percentage') ?></th>
            <td><?= $this->Number->format($saleReturnRow->gst_percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Value') ?></th>
            <td><?= $this->Number->format($saleReturnRow->gst_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Net Amount') ?></th>
            <td><?= $this->Number->format($saleReturnRow->net_amount) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Item Ledgers') ?></h4>
        <?php if (!empty($saleReturnRow->item_ledgers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Unit Variation Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Seller Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Order Id') ?></th>
                <th scope="col"><?= __('Order Detail Id') ?></th>
                <th scope="col"><?= __('Grn Id') ?></th>
                <th scope="col"><?= __('Grn Row Id') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Is Opening Balance') ?></th>
                <th scope="col"><?= __('Sale Rate') ?></th>
                <th scope="col"><?= __('Purchase Rate') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Credit Note Id') ?></th>
                <th scope="col"><?= __('Credit Note Row Id') ?></th>
                <th scope="col"><?= __('Sale Return Id') ?></th>
                <th scope="col"><?= __('Sale Return Row Id') ?></th>
                <th scope="col"><?= __('Stock Transfer Voucher Id') ?></th>
                <th scope="col"><?= __('Stock Transfer Voucher Row Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Row Id') ?></th>
                <th scope="col"><?= __('Purchase Return Id') ?></th>
                <th scope="col"><?= __('Purchase Return Row Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Entry From') ?></th>
                <th scope="col"><?= __('Wastage') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($saleReturnRow->item_ledgers as $itemLedgers): ?>
            <tr>
                <td><?= h($itemLedgers->id) ?></td>
                <td><?= h($itemLedgers->item_id) ?></td>
                <td><?= h($itemLedgers->unit_variation_id) ?></td>
                <td><?= h($itemLedgers->item_variation_id) ?></td>
                <td><?= h($itemLedgers->seller_id) ?></td>
                <td><?= h($itemLedgers->transaction_date) ?></td>
                <td><?= h($itemLedgers->quantity) ?></td>
                <td><?= h($itemLedgers->rate) ?></td>
                <td><?= h($itemLedgers->amount) ?></td>
                <td><?= h($itemLedgers->order_id) ?></td>
                <td><?= h($itemLedgers->order_detail_id) ?></td>
                <td><?= h($itemLedgers->grn_id) ?></td>
                <td><?= h($itemLedgers->grn_row_id) ?></td>
                <td><?= h($itemLedgers->status) ?></td>
                <td><?= h($itemLedgers->is_opening_balance) ?></td>
                <td><?= h($itemLedgers->sale_rate) ?></td>
                <td><?= h($itemLedgers->purchase_rate) ?></td>
                <td><?= h($itemLedgers->location_id) ?></td>
                <td><?= h($itemLedgers->credit_note_id) ?></td>
                <td><?= h($itemLedgers->credit_note_row_id) ?></td>
                <td><?= h($itemLedgers->sale_return_id) ?></td>
                <td><?= h($itemLedgers->sale_return_row_id) ?></td>
                <td><?= h($itemLedgers->stock_transfer_voucher_id) ?></td>
                <td><?= h($itemLedgers->stock_transfer_voucher_row_id) ?></td>
                <td><?= h($itemLedgers->purchase_invoice_id) ?></td>
                <td><?= h($itemLedgers->purchase_invoice_row_id) ?></td>
                <td><?= h($itemLedgers->purchase_return_id) ?></td>
                <td><?= h($itemLedgers->purchase_return_row_id) ?></td>
                <td><?= h($itemLedgers->city_id) ?></td>
                <td><?= h($itemLedgers->entry_from) ?></td>
                <td><?= h($itemLedgers->wastage) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ItemLedgers', 'action' => 'view', $itemLedgers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ItemLedgers', 'action' => 'edit', $itemLedgers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ItemLedgers', 'action' => 'delete', $itemLedgers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemLedgers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
