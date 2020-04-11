<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemLedger $itemLedger
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Item Ledger'), ['action' => 'edit', $itemLedger->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Item Ledger'), ['action' => 'delete', $itemLedger->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemLedger->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Item Ledgers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Ledger'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Invoices'), ['controller' => 'SalesInvoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Invoice'), ['controller' => 'SalesInvoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Invoice Rows'), ['controller' => 'SalesInvoiceRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Invoice Row'), ['controller' => 'SalesInvoiceRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Credit Notes'), ['controller' => 'CreditNotes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Credit Note'), ['controller' => 'CreditNotes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Credit Note Rows'), ['controller' => 'CreditNoteRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Credit Note Row'), ['controller' => 'CreditNoteRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['controller' => 'SaleReturns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return'), ['controller' => 'SaleReturns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Return Rows'), ['controller' => 'SaleReturnRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return Row'), ['controller' => 'SaleReturnRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Invoices'), ['controller' => 'PurchaseInvoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Invoice'), ['controller' => 'PurchaseInvoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Invoice Rows'), ['controller' => 'PurchaseInvoiceRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Invoice Row'), ['controller' => 'PurchaseInvoiceRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Returns'), ['controller' => 'PurchaseReturns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Return'), ['controller' => 'PurchaseReturns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Return Rows'), ['controller' => 'PurchaseReturnRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Return Row'), ['controller' => 'PurchaseReturnRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="itemLedgers view large-9 medium-8 columns content">
    <h3><?= h($itemLedger->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $itemLedger->has('item') ? $this->Html->link($itemLedger->item->name, ['controller' => 'Items', 'action' => 'view', $itemLedger->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $itemLedger->has('item_variation') ? $this->Html->link($itemLedger->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $itemLedger->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($itemLedger->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Opening Balance') ?></th>
            <td><?= h($itemLedger->is_opening_balance) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Invoice') ?></th>
            <td><?= $itemLedger->has('sales_invoice') ? $this->Html->link($itemLedger->sales_invoice->id, ['controller' => 'SalesInvoices', 'action' => 'view', $itemLedger->sales_invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Invoice Row') ?></th>
            <td><?= $itemLedger->has('sales_invoice_row') ? $this->Html->link($itemLedger->sales_invoice_row->id, ['controller' => 'SalesInvoiceRows', 'action' => 'view', $itemLedger->sales_invoice_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $itemLedger->has('location') ? $this->Html->link($itemLedger->location->name, ['controller' => 'Locations', 'action' => 'view', $itemLedger->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit Note') ?></th>
            <td><?= $itemLedger->has('credit_note') ? $this->Html->link($itemLedger->credit_note->id, ['controller' => 'CreditNotes', 'action' => 'view', $itemLedger->credit_note->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit Note Row') ?></th>
            <td><?= $itemLedger->has('credit_note_row') ? $this->Html->link($itemLedger->credit_note_row->id, ['controller' => 'CreditNoteRows', 'action' => 'view', $itemLedger->credit_note_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sale Return') ?></th>
            <td><?= $itemLedger->has('sale_return') ? $this->Html->link($itemLedger->sale_return->id, ['controller' => 'SaleReturns', 'action' => 'view', $itemLedger->sale_return->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sale Return Row') ?></th>
            <td><?= $itemLedger->has('sale_return_row') ? $this->Html->link($itemLedger->sale_return_row->id, ['controller' => 'SaleReturnRows', 'action' => 'view', $itemLedger->sale_return_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Invoice') ?></th>
            <td><?= $itemLedger->has('purchase_invoice') ? $this->Html->link($itemLedger->purchase_invoice->id, ['controller' => 'PurchaseInvoices', 'action' => 'view', $itemLedger->purchase_invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Invoice Row') ?></th>
            <td><?= $itemLedger->has('purchase_invoice_row') ? $this->Html->link($itemLedger->purchase_invoice_row->id, ['controller' => 'PurchaseInvoiceRows', 'action' => 'view', $itemLedger->purchase_invoice_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Return') ?></th>
            <td><?= $itemLedger->has('purchase_return') ? $this->Html->link($itemLedger->purchase_return->id, ['controller' => 'PurchaseReturns', 'action' => 'view', $itemLedger->purchase_return->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Return Row') ?></th>
            <td><?= $itemLedger->has('purchase_return_row') ? $this->Html->link($itemLedger->purchase_return_row->id, ['controller' => 'PurchaseReturnRows', 'action' => 'view', $itemLedger->purchase_return_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $itemLedger->has('city') ? $this->Html->link($itemLedger->city->name, ['controller' => 'Cities', 'action' => 'view', $itemLedger->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Entry From') ?></th>
            <td><?= h($itemLedger->entry_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($itemLedger->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($itemLedger->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $this->Number->format($itemLedger->rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($itemLedger->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sale Rate') ?></th>
            <td><?= $this->Number->format($itemLedger->sale_rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Rate') ?></th>
            <td><?= $this->Number->format($itemLedger->purchase_rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($itemLedger->transaction_date) ?></td>
        </tr>
    </table>
</div>
