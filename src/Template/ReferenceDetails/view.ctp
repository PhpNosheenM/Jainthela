<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReferenceDetail $referenceDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Reference Detail'), ['action' => 'edit', $referenceDetail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Reference Detail'), ['action' => 'delete', $referenceDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $referenceDetail->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Reference Details'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Receipts'), ['controller' => 'Receipts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receipt'), ['controller' => 'Receipts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Receipt Rows'), ['controller' => 'ReceiptRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receipt Row'), ['controller' => 'ReceiptRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payment Rows'), ['controller' => 'PaymentRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment Row'), ['controller' => 'PaymentRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Credit Notes'), ['controller' => 'CreditNotes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Credit Note'), ['controller' => 'CreditNotes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Credit Note Rows'), ['controller' => 'CreditNoteRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Credit Note Row'), ['controller' => 'CreditNoteRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Debit Notes'), ['controller' => 'DebitNotes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Debit Note'), ['controller' => 'DebitNotes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Debit Note Rows'), ['controller' => 'DebitNoteRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Debit Note Row'), ['controller' => 'DebitNoteRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Voucher Rows'), ['controller' => 'SalesVoucherRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Voucher Row'), ['controller' => 'SalesVoucherRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Voucher Rows'), ['controller' => 'PurchaseVoucherRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Voucher Row'), ['controller' => 'PurchaseVoucherRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Journal Voucher Rows'), ['controller' => 'JournalVoucherRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Journal Voucher Row'), ['controller' => 'JournalVoucherRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['controller' => 'SaleReturns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return'), ['controller' => 'SaleReturns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Invoices'), ['controller' => 'PurchaseInvoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Invoice'), ['controller' => 'PurchaseInvoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Returns'), ['controller' => 'PurchaseReturns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Return'), ['controller' => 'PurchaseReturns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Invoices'), ['controller' => 'SalesInvoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Invoice'), ['controller' => 'SalesInvoices', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="referenceDetails view large-9 medium-8 columns content">
    <h3><?= h($referenceDetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $referenceDetail->has('customer') ? $this->Html->link($referenceDetail->customer->name, ['controller' => 'Customers', 'action' => 'view', $referenceDetail->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Supplier') ?></th>
            <td><?= $referenceDetail->has('supplier') ? $this->Html->link($referenceDetail->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $referenceDetail->supplier->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $referenceDetail->has('location') ? $this->Html->link($referenceDetail->location->name, ['controller' => 'Locations', 'action' => 'view', $referenceDetail->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ledger') ?></th>
            <td><?= $referenceDetail->has('ledger') ? $this->Html->link($referenceDetail->ledger->name, ['controller' => 'Ledgers', 'action' => 'view', $referenceDetail->ledger->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($referenceDetail->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ref Name') ?></th>
            <td><?= h($referenceDetail->ref_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Receipt') ?></th>
            <td><?= $referenceDetail->has('receipt') ? $this->Html->link($referenceDetail->receipt->id, ['controller' => 'Receipts', 'action' => 'view', $referenceDetail->receipt->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Receipt Row') ?></th>
            <td><?= $referenceDetail->has('receipt_row') ? $this->Html->link($referenceDetail->receipt_row->id, ['controller' => 'ReceiptRows', 'action' => 'view', $referenceDetail->receipt_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Row') ?></th>
            <td><?= $referenceDetail->has('payment_row') ? $this->Html->link($referenceDetail->payment_row->id, ['controller' => 'PaymentRows', 'action' => 'view', $referenceDetail->payment_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit Note') ?></th>
            <td><?= $referenceDetail->has('credit_note') ? $this->Html->link($referenceDetail->credit_note->id, ['controller' => 'CreditNotes', 'action' => 'view', $referenceDetail->credit_note->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit Note Row') ?></th>
            <td><?= $referenceDetail->has('credit_note_row') ? $this->Html->link($referenceDetail->credit_note_row->id, ['controller' => 'CreditNoteRows', 'action' => 'view', $referenceDetail->credit_note_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debit Note') ?></th>
            <td><?= $referenceDetail->has('debit_note') ? $this->Html->link($referenceDetail->debit_note->id, ['controller' => 'DebitNotes', 'action' => 'view', $referenceDetail->debit_note->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debit Note Row') ?></th>
            <td><?= $referenceDetail->has('debit_note_row') ? $this->Html->link($referenceDetail->debit_note_row->id, ['controller' => 'DebitNoteRows', 'action' => 'view', $referenceDetail->debit_note_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Voucher Row') ?></th>
            <td><?= $referenceDetail->has('sales_voucher_row') ? $this->Html->link($referenceDetail->sales_voucher_row->id, ['controller' => 'SalesVoucherRows', 'action' => 'view', $referenceDetail->sales_voucher_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Voucher Row') ?></th>
            <td><?= $referenceDetail->has('purchase_voucher_row') ? $this->Html->link($referenceDetail->purchase_voucher_row->id, ['controller' => 'PurchaseVoucherRows', 'action' => 'view', $referenceDetail->purchase_voucher_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Journal Voucher Row') ?></th>
            <td><?= $referenceDetail->has('journal_voucher_row') ? $this->Html->link($referenceDetail->journal_voucher_row->id, ['controller' => 'JournalVoucherRows', 'action' => 'view', $referenceDetail->journal_voucher_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sale Return') ?></th>
            <td><?= $referenceDetail->has('sale_return') ? $this->Html->link($referenceDetail->sale_return->id, ['controller' => 'SaleReturns', 'action' => 'view', $referenceDetail->sale_return->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Invoice') ?></th>
            <td><?= $referenceDetail->has('purchase_invoice') ? $this->Html->link($referenceDetail->purchase_invoice->id, ['controller' => 'PurchaseInvoices', 'action' => 'view', $referenceDetail->purchase_invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Return') ?></th>
            <td><?= $referenceDetail->has('purchase_return') ? $this->Html->link($referenceDetail->purchase_return->id, ['controller' => 'PurchaseReturns', 'action' => 'view', $referenceDetail->purchase_return->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Invoice') ?></th>
            <td><?= $referenceDetail->has('sales_invoice') ? $this->Html->link($referenceDetail->sales_invoice->id, ['controller' => 'SalesInvoices', 'action' => 'view', $referenceDetail->sales_invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Opening Balance') ?></th>
            <td><?= h($referenceDetail->opening_balance) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($referenceDetail->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debit') ?></th>
            <td><?= $this->Number->format($referenceDetail->debit) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit') ?></th>
            <td><?= $this->Number->format($referenceDetail->credit) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Due Days') ?></th>
            <td><?= $this->Number->format($referenceDetail->due_days) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($referenceDetail->transaction_date) ?></td>
        </tr>
    </table>
</div>
