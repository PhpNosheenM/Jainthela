<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReferenceDetail $referenceDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $referenceDetail->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $referenceDetail->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Reference Details'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Receipts'), ['controller' => 'Receipts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Receipt'), ['controller' => 'Receipts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Receipt Rows'), ['controller' => 'ReceiptRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Receipt Row'), ['controller' => 'ReceiptRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payment Rows'), ['controller' => 'PaymentRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payment Row'), ['controller' => 'PaymentRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Credit Notes'), ['controller' => 'CreditNotes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Credit Note'), ['controller' => 'CreditNotes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Credit Note Rows'), ['controller' => 'CreditNoteRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Credit Note Row'), ['controller' => 'CreditNoteRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Debit Notes'), ['controller' => 'DebitNotes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Debit Note'), ['controller' => 'DebitNotes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Debit Note Rows'), ['controller' => 'DebitNoteRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Debit Note Row'), ['controller' => 'DebitNoteRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales Voucher Rows'), ['controller' => 'SalesVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sales Voucher Row'), ['controller' => 'SalesVoucherRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Voucher Rows'), ['controller' => 'PurchaseVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Voucher Row'), ['controller' => 'PurchaseVoucherRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Journal Voucher Rows'), ['controller' => 'JournalVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Journal Voucher Row'), ['controller' => 'JournalVoucherRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['controller' => 'SaleReturns', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale Return'), ['controller' => 'SaleReturns', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Invoices'), ['controller' => 'PurchaseInvoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Invoice'), ['controller' => 'PurchaseInvoices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Returns'), ['controller' => 'PurchaseReturns', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Return'), ['controller' => 'PurchaseReturns', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales Invoices'), ['controller' => 'SalesInvoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sales Invoice'), ['controller' => 'SalesInvoices', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="referenceDetails form large-9 medium-8 columns content">
    <?= $this->Form->create($referenceDetail) ?>
    <fieldset>
        <legend><?= __('Edit Reference Detail') ?></legend>
        <?php
            echo $this->Form->control('customer_id', ['options' => $customers, 'empty' => true]);
            echo $this->Form->control('supplier_id', ['options' => $suppliers, 'empty' => true]);
            echo $this->Form->control('transaction_date', ['empty' => true]);
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('ledger_id', ['options' => $ledgers]);
            echo $this->Form->control('type');
            echo $this->Form->control('ref_name');
            echo $this->Form->control('debit');
            echo $this->Form->control('credit');
            echo $this->Form->control('receipt_id', ['options' => $receipts]);
            echo $this->Form->control('receipt_row_id', ['options' => $receiptRows]);
            echo $this->Form->control('payment_row_id', ['options' => $paymentRows]);
            echo $this->Form->control('credit_note_id', ['options' => $creditNotes, 'empty' => true]);
            echo $this->Form->control('credit_note_row_id', ['options' => $creditNoteRows]);
            echo $this->Form->control('debit_note_id', ['options' => $debitNotes, 'empty' => true]);
            echo $this->Form->control('debit_note_row_id', ['options' => $debitNoteRows, 'empty' => true]);
            echo $this->Form->control('sales_voucher_row_id', ['options' => $salesVoucherRows, 'empty' => true]);
            echo $this->Form->control('purchase_voucher_row_id', ['options' => $purchaseVoucherRows]);
            echo $this->Form->control('journal_voucher_row_id', ['options' => $journalVoucherRows]);
            echo $this->Form->control('sale_return_id', ['options' => $saleReturns, 'empty' => true]);
            echo $this->Form->control('purchase_invoice_id', ['options' => $purchaseInvoices, 'empty' => true]);
            echo $this->Form->control('purchase_return_id', ['options' => $purchaseReturns, 'empty' => true]);
            echo $this->Form->control('sales_invoice_id', ['options' => $salesInvoices, 'empty' => true]);
            echo $this->Form->control('opening_balance');
            echo $this->Form->control('due_days');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
