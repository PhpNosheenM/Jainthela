<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemLedger[]|\Cake\Collection\CollectionInterface $itemLedgers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Item Ledger'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales Invoices'), ['controller' => 'SalesInvoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sales Invoice'), ['controller' => 'SalesInvoices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales Invoice Rows'), ['controller' => 'SalesInvoiceRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sales Invoice Row'), ['controller' => 'SalesInvoiceRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Credit Notes'), ['controller' => 'CreditNotes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Credit Note'), ['controller' => 'CreditNotes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Credit Note Rows'), ['controller' => 'CreditNoteRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Credit Note Row'), ['controller' => 'CreditNoteRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['controller' => 'SaleReturns', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale Return'), ['controller' => 'SaleReturns', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sale Return Rows'), ['controller' => 'SaleReturnRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale Return Row'), ['controller' => 'SaleReturnRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Invoices'), ['controller' => 'PurchaseInvoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Invoice'), ['controller' => 'PurchaseInvoices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Invoice Rows'), ['controller' => 'PurchaseInvoiceRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Invoice Row'), ['controller' => 'PurchaseInvoiceRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Returns'), ['controller' => 'PurchaseReturns', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Return'), ['controller' => 'PurchaseReturns', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Return Rows'), ['controller' => 'PurchaseReturnRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Return Row'), ['controller' => 'PurchaseReturnRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemLedgers index large-9 medium-8 columns content">
    <h3><?= __('Item Ledgers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_variation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_opening_balance') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sale_rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_invoice_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_invoice_row_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('credit_note_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('credit_note_row_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sale_return_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sale_return_row_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_invoice_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_invoice_row_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_return_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_return_row_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('entry_from') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itemLedgers as $itemLedger): ?>
            <tr>
                <td><?= $this->Number->format($itemLedger->id) ?></td>
                <td><?= $itemLedger->has('item') ? $this->Html->link($itemLedger->item->name, ['controller' => 'Items', 'action' => 'view', $itemLedger->item->id]) : '' ?></td>
                <td><?= $itemLedger->has('item_variation') ? $this->Html->link($itemLedger->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $itemLedger->item_variation->id]) : '' ?></td>
                <td><?= h($itemLedger->transaction_date) ?></td>
                <td><?= $this->Number->format($itemLedger->quantity) ?></td>
                <td><?= $this->Number->format($itemLedger->rate) ?></td>
                <td><?= $this->Number->format($itemLedger->amount) ?></td>
                <td><?= h($itemLedger->status) ?></td>
                <td><?= h($itemLedger->is_opening_balance) ?></td>
                <td><?= $this->Number->format($itemLedger->sale_rate) ?></td>
                <td><?= $this->Number->format($itemLedger->purchase_rate) ?></td>
                <td><?= $itemLedger->has('sales_invoice') ? $this->Html->link($itemLedger->sales_invoice->id, ['controller' => 'SalesInvoices', 'action' => 'view', $itemLedger->sales_invoice->id]) : '' ?></td>
                <td><?= $itemLedger->has('sales_invoice_row') ? $this->Html->link($itemLedger->sales_invoice_row->id, ['controller' => 'SalesInvoiceRows', 'action' => 'view', $itemLedger->sales_invoice_row->id]) : '' ?></td>
                <td><?= $itemLedger->has('location') ? $this->Html->link($itemLedger->location->name, ['controller' => 'Locations', 'action' => 'view', $itemLedger->location->id]) : '' ?></td>
                <td><?= $itemLedger->has('credit_note') ? $this->Html->link($itemLedger->credit_note->id, ['controller' => 'CreditNotes', 'action' => 'view', $itemLedger->credit_note->id]) : '' ?></td>
                <td><?= $itemLedger->has('credit_note_row') ? $this->Html->link($itemLedger->credit_note_row->id, ['controller' => 'CreditNoteRows', 'action' => 'view', $itemLedger->credit_note_row->id]) : '' ?></td>
                <td><?= $itemLedger->has('sale_return') ? $this->Html->link($itemLedger->sale_return->id, ['controller' => 'SaleReturns', 'action' => 'view', $itemLedger->sale_return->id]) : '' ?></td>
                <td><?= $itemLedger->has('sale_return_row') ? $this->Html->link($itemLedger->sale_return_row->id, ['controller' => 'SaleReturnRows', 'action' => 'view', $itemLedger->sale_return_row->id]) : '' ?></td>
                <td><?= $itemLedger->has('purchase_invoice') ? $this->Html->link($itemLedger->purchase_invoice->id, ['controller' => 'PurchaseInvoices', 'action' => 'view', $itemLedger->purchase_invoice->id]) : '' ?></td>
                <td><?= $itemLedger->has('purchase_invoice_row') ? $this->Html->link($itemLedger->purchase_invoice_row->id, ['controller' => 'PurchaseInvoiceRows', 'action' => 'view', $itemLedger->purchase_invoice_row->id]) : '' ?></td>
                <td><?= $itemLedger->has('purchase_return') ? $this->Html->link($itemLedger->purchase_return->id, ['controller' => 'PurchaseReturns', 'action' => 'view', $itemLedger->purchase_return->id]) : '' ?></td>
                <td><?= $itemLedger->has('purchase_return_row') ? $this->Html->link($itemLedger->purchase_return_row->id, ['controller' => 'PurchaseReturnRows', 'action' => 'view', $itemLedger->purchase_return_row->id]) : '' ?></td>
                <td><?= $itemLedger->has('city') ? $this->Html->link($itemLedger->city->name, ['controller' => 'Cities', 'action' => 'view', $itemLedger->city->id]) : '' ?></td>
                <td><?= h($itemLedger->entry_from) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $itemLedger->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $itemLedger->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $itemLedger->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemLedger->id)]) ?>
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
