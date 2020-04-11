<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccountingEntry $accountingEntry
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Accounting Entry'), ['action' => 'edit', $accountingEntry->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Accounting Entry'), ['action' => 'delete', $accountingEntry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountingEntry->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Vouchers'), ['controller' => 'PurchaseVouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Voucher'), ['controller' => 'PurchaseVouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Voucher Rows'), ['controller' => 'PurchaseVoucherRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Voucher Row'), ['controller' => 'PurchaseVoucherRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Invoices'), ['controller' => 'SalesInvoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Invoice'), ['controller' => 'SalesInvoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['controller' => 'SaleReturns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return'), ['controller' => 'SaleReturns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Invoices'), ['controller' => 'PurchaseInvoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Invoice'), ['controller' => 'PurchaseInvoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Returns'), ['controller' => 'PurchaseReturns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Return'), ['controller' => 'PurchaseReturns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Receipts'), ['controller' => 'Receipts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receipt'), ['controller' => 'Receipts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Receipt Rows'), ['controller' => 'ReceiptRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receipt Row'), ['controller' => 'ReceiptRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
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
        <li><?= $this->Html->link(__('List Sales Vouchers'), ['controller' => 'SalesVouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Voucher'), ['controller' => 'SalesVouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Voucher Rows'), ['controller' => 'SalesVoucherRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Voucher Row'), ['controller' => 'SalesVoucherRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Journal Vouchers'), ['controller' => 'JournalVouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Journal Voucher'), ['controller' => 'JournalVouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Journal Voucher Rows'), ['controller' => 'JournalVoucherRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Journal Voucher Row'), ['controller' => 'JournalVoucherRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="accountingEntries view large-9 medium-8 columns content">
    <h3><?= h($accountingEntry->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Ledger') ?></th>
            <td><?= $accountingEntry->has('ledger') ? $this->Html->link($accountingEntry->ledger->name, ['controller' => 'Ledgers', 'action' => 'view', $accountingEntry->ledger->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $accountingEntry->has('location') ? $this->Html->link($accountingEntry->location->name, ['controller' => 'Locations', 'action' => 'view', $accountingEntry->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $accountingEntry->has('city') ? $this->Html->link($accountingEntry->city->name, ['controller' => 'Cities', 'action' => 'view', $accountingEntry->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Voucher') ?></th>
            <td><?= $accountingEntry->has('purchase_voucher') ? $this->Html->link($accountingEntry->purchase_voucher->id, ['controller' => 'PurchaseVouchers', 'action' => 'view', $accountingEntry->purchase_voucher->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Voucher Row') ?></th>
            <td><?= $accountingEntry->has('purchase_voucher_row') ? $this->Html->link($accountingEntry->purchase_voucher_row->id, ['controller' => 'PurchaseVoucherRows', 'action' => 'view', $accountingEntry->purchase_voucher_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Opening Balance') ?></th>
            <td><?= h($accountingEntry->is_opening_balance) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Invoice') ?></th>
            <td><?= $accountingEntry->has('sales_invoice') ? $this->Html->link($accountingEntry->sales_invoice->id, ['controller' => 'SalesInvoices', 'action' => 'view', $accountingEntry->sales_invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sale Return') ?></th>
            <td><?= $accountingEntry->has('sale_return') ? $this->Html->link($accountingEntry->sale_return->id, ['controller' => 'SaleReturns', 'action' => 'view', $accountingEntry->sale_return->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Invoice') ?></th>
            <td><?= $accountingEntry->has('purchase_invoice') ? $this->Html->link($accountingEntry->purchase_invoice->id, ['controller' => 'PurchaseInvoices', 'action' => 'view', $accountingEntry->purchase_invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Return') ?></th>
            <td><?= $accountingEntry->has('purchase_return') ? $this->Html->link($accountingEntry->purchase_return->id, ['controller' => 'PurchaseReturns', 'action' => 'view', $accountingEntry->purchase_return->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Receipt') ?></th>
            <td><?= $accountingEntry->has('receipt') ? $this->Html->link($accountingEntry->receipt->id, ['controller' => 'Receipts', 'action' => 'view', $accountingEntry->receipt->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Receipt Row') ?></th>
            <td><?= $accountingEntry->has('receipt_row') ? $this->Html->link($accountingEntry->receipt_row->id, ['controller' => 'ReceiptRows', 'action' => 'view', $accountingEntry->receipt_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment') ?></th>
            <td><?= $accountingEntry->has('payment') ? $this->Html->link($accountingEntry->payment->id, ['controller' => 'Payments', 'action' => 'view', $accountingEntry->payment->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Row') ?></th>
            <td><?= $accountingEntry->has('payment_row') ? $this->Html->link($accountingEntry->payment_row->id, ['controller' => 'PaymentRows', 'action' => 'view', $accountingEntry->payment_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit Note') ?></th>
            <td><?= $accountingEntry->has('credit_note') ? $this->Html->link($accountingEntry->credit_note->id, ['controller' => 'CreditNotes', 'action' => 'view', $accountingEntry->credit_note->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit Note Row') ?></th>
            <td><?= $accountingEntry->has('credit_note_row') ? $this->Html->link($accountingEntry->credit_note_row->id, ['controller' => 'CreditNoteRows', 'action' => 'view', $accountingEntry->credit_note_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debit Note') ?></th>
            <td><?= $accountingEntry->has('debit_note') ? $this->Html->link($accountingEntry->debit_note->id, ['controller' => 'DebitNotes', 'action' => 'view', $accountingEntry->debit_note->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debit Note Row') ?></th>
            <td><?= $accountingEntry->has('debit_note_row') ? $this->Html->link($accountingEntry->debit_note_row->id, ['controller' => 'DebitNoteRows', 'action' => 'view', $accountingEntry->debit_note_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Voucher') ?></th>
            <td><?= $accountingEntry->has('sales_voucher') ? $this->Html->link($accountingEntry->sales_voucher->id, ['controller' => 'SalesVouchers', 'action' => 'view', $accountingEntry->sales_voucher->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Voucher Row') ?></th>
            <td><?= $accountingEntry->has('sales_voucher_row') ? $this->Html->link($accountingEntry->sales_voucher_row->id, ['controller' => 'SalesVoucherRows', 'action' => 'view', $accountingEntry->sales_voucher_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Journal Voucher') ?></th>
            <td><?= $accountingEntry->has('journal_voucher') ? $this->Html->link($accountingEntry->journal_voucher->id, ['controller' => 'JournalVouchers', 'action' => 'view', $accountingEntry->journal_voucher->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Journal Voucher Row') ?></th>
            <td><?= $accountingEntry->has('journal_voucher_row') ? $this->Html->link($accountingEntry->journal_voucher_row->id, ['controller' => 'JournalVoucherRows', 'action' => 'view', $accountingEntry->journal_voucher_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Entry From') ?></th>
            <td><?= h($accountingEntry->entry_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($accountingEntry->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debit') ?></th>
            <td><?= $this->Number->format($accountingEntry->debit) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit') ?></th>
            <td><?= $this->Number->format($accountingEntry->credit) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Contra Voucher Id') ?></th>
            <td><?= $this->Number->format($accountingEntry->contra_voucher_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Contra Voucher Row Id') ?></th>
            <td><?= $this->Number->format($accountingEntry->contra_voucher_row_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($accountingEntry->transaction_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reconciliation Date') ?></th>
            <td><?= h($accountingEntry->reconciliation_date) ?></td>
        </tr>
    </table>
</div>
