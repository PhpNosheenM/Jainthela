<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseInvoiceRow $purchaseInvoiceRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Purchase Invoice Row'), ['action' => 'edit', $purchaseInvoiceRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Purchase Invoice Row'), ['action' => 'delete', $purchaseInvoiceRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseInvoiceRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Invoice Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Invoice Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Invoices'), ['controller' => 'PurchaseInvoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Invoice'), ['controller' => 'PurchaseInvoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Ledgers'), ['controller' => 'ItemLedgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Ledger'), ['controller' => 'ItemLedgers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Return Rows'), ['controller' => 'PurchaseReturnRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Return Row'), ['controller' => 'PurchaseReturnRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="purchaseInvoiceRows view large-9 medium-8 columns content">
    <h3><?= h($purchaseInvoiceRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Purchase Invoice') ?></th>
            <td><?= $purchaseInvoiceRow->has('purchase_invoice') ? $this->Html->link($purchaseInvoiceRow->purchase_invoice->id, ['controller' => 'PurchaseInvoices', 'action' => 'view', $purchaseInvoiceRow->purchase_invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $purchaseInvoiceRow->has('item') ? $this->Html->link($purchaseInvoiceRow->item->name, ['controller' => 'Items', 'action' => 'view', $purchaseInvoiceRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $purchaseInvoiceRow->has('item_variation') ? $this->Html->link($purchaseInvoiceRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $purchaseInvoiceRow->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($purchaseInvoiceRow->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($purchaseInvoiceRow->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $this->Number->format($purchaseInvoiceRow->rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Percentage') ?></th>
            <td><?= $this->Number->format($purchaseInvoiceRow->discount_percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Amount') ?></th>
            <td><?= $this->Number->format($purchaseInvoiceRow->discount_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Taxable Value') ?></th>
            <td><?= $this->Number->format($purchaseInvoiceRow->taxable_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Net Amount') ?></th>
            <td><?= $this->Number->format($purchaseInvoiceRow->net_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Gst Figure Id') ?></th>
            <td><?= $this->Number->format($purchaseInvoiceRow->item_gst_figure_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Percentage') ?></th>
            <td><?= $this->Number->format($purchaseInvoiceRow->gst_percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Value') ?></th>
            <td><?= $this->Number->format($purchaseInvoiceRow->gst_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Round Off') ?></th>
            <td><?= $this->Number->format($purchaseInvoiceRow->round_off) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Item Ledgers') ?></h4>
        <?php if (!empty($purchaseInvoiceRow->item_ledgers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Is Opening Balance') ?></th>
                <th scope="col"><?= __('Sale Rate') ?></th>
                <th scope="col"><?= __('Purchase Rate') ?></th>
                <th scope="col"><?= __('Sales Invoice Id') ?></th>
                <th scope="col"><?= __('Sales Invoice Row Id') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Credit Note Id') ?></th>
                <th scope="col"><?= __('Credit Note Row Id') ?></th>
                <th scope="col"><?= __('Sale Return Id') ?></th>
                <th scope="col"><?= __('Sale Return Row Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Row Id') ?></th>
                <th scope="col"><?= __('Purchase Return Id') ?></th>
                <th scope="col"><?= __('Purchase Return Row Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($purchaseInvoiceRow->item_ledgers as $itemLedgers): ?>
            <tr>
                <td><?= h($itemLedgers->id) ?></td>
                <td><?= h($itemLedgers->item_id) ?></td>
                <td><?= h($itemLedgers->item_variation_id) ?></td>
                <td><?= h($itemLedgers->transaction_date) ?></td>
                <td><?= h($itemLedgers->quantity) ?></td>
                <td><?= h($itemLedgers->rate) ?></td>
                <td><?= h($itemLedgers->amount) ?></td>
                <td><?= h($itemLedgers->status) ?></td>
                <td><?= h($itemLedgers->is_opening_balance) ?></td>
                <td><?= h($itemLedgers->sale_rate) ?></td>
                <td><?= h($itemLedgers->purchase_rate) ?></td>
                <td><?= h($itemLedgers->sales_invoice_id) ?></td>
                <td><?= h($itemLedgers->sales_invoice_row_id) ?></td>
                <td><?= h($itemLedgers->location_id) ?></td>
                <td><?= h($itemLedgers->credit_note_id) ?></td>
                <td><?= h($itemLedgers->credit_note_row_id) ?></td>
                <td><?= h($itemLedgers->sale_return_id) ?></td>
                <td><?= h($itemLedgers->sale_return_row_id) ?></td>
                <td><?= h($itemLedgers->purchase_invoice_id) ?></td>
                <td><?= h($itemLedgers->purchase_invoice_row_id) ?></td>
                <td><?= h($itemLedgers->purchase_return_id) ?></td>
                <td><?= h($itemLedgers->purchase_return_row_id) ?></td>
                <td><?= h($itemLedgers->city_id) ?></td>
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
    <div class="related">
        <h4><?= __('Related Purchase Return Rows') ?></h4>
        <?php if (!empty($purchaseInvoiceRow->purchase_return_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Purchase Return Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Discount Percentage') ?></th>
                <th scope="col"><?= __('Discount Amount') ?></th>
                <th scope="col"><?= __('Pnf Percentage') ?></th>
                <th scope="col"><?= __('Pnf Amount') ?></th>
                <th scope="col"><?= __('Taxable Value') ?></th>
                <th scope="col"><?= __('Item Gst Figure Id') ?></th>
                <th scope="col"><?= __('Gst Value') ?></th>
                <th scope="col"><?= __('Round Off') ?></th>
                <th scope="col"><?= __('Net Amount') ?></th>
                <th scope="col"><?= __('Purchase Invoice Row Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($purchaseInvoiceRow->purchase_return_rows as $purchaseReturnRows): ?>
            <tr>
                <td><?= h($purchaseReturnRows->id) ?></td>
                <td><?= h($purchaseReturnRows->purchase_return_id) ?></td>
                <td><?= h($purchaseReturnRows->item_id) ?></td>
                <td><?= h($purchaseReturnRows->quantity) ?></td>
                <td><?= h($purchaseReturnRows->rate) ?></td>
                <td><?= h($purchaseReturnRows->discount_percentage) ?></td>
                <td><?= h($purchaseReturnRows->discount_amount) ?></td>
                <td><?= h($purchaseReturnRows->pnf_percentage) ?></td>
                <td><?= h($purchaseReturnRows->pnf_amount) ?></td>
                <td><?= h($purchaseReturnRows->taxable_value) ?></td>
                <td><?= h($purchaseReturnRows->item_gst_figure_id) ?></td>
                <td><?= h($purchaseReturnRows->gst_value) ?></td>
                <td><?= h($purchaseReturnRows->round_off) ?></td>
                <td><?= h($purchaseReturnRows->net_amount) ?></td>
                <td><?= h($purchaseReturnRows->purchase_invoice_row_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PurchaseReturnRows', 'action' => 'view', $purchaseReturnRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PurchaseReturnRows', 'action' => 'edit', $purchaseReturnRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PurchaseReturnRows', 'action' => 'delete', $purchaseReturnRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseReturnRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
