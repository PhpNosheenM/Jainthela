<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receipt $receipt
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Receipt'), ['action' => 'edit', $receipt->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Receipt'), ['action' => 'delete', $receipt->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receipt->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Receipts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receipt'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Invoices'), ['controller' => 'SalesInvoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Invoice'), ['controller' => 'SalesInvoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Receipt Rows'), ['controller' => 'ReceiptRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receipt Row'), ['controller' => 'ReceiptRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reference Details'), ['controller' => 'ReferenceDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['controller' => 'ReferenceDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="receipts view large-9 medium-8 columns content">
    <h3><?= h($receipt->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $receipt->has('location') ? $this->Html->link($receipt->location->name, ['controller' => 'Locations', 'action' => 'view', $receipt->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Invoice') ?></th>
            <td><?= $receipt->has('sales_invoice') ? $this->Html->link($receipt->sales_invoice->id, ['controller' => 'SalesInvoices', 'action' => 'view', $receipt->sales_invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($receipt->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($receipt->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voucher No') ?></th>
            <td><?= $this->Number->format($receipt->voucher_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voucher Amount') ?></th>
            <td><?= $this->Number->format($receipt->voucher_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($receipt->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($receipt->transaction_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Narration') ?></h4>
        <?= $this->Text->autoParagraph(h($receipt->narration)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Accounting Entries') ?></h4>
        <?php if (!empty($receipt->accounting_entries)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Ledger Id') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Purchase Voucher Id') ?></th>
                <th scope="col"><?= __('Purchase Voucher Row Id') ?></th>
                <th scope="col"><?= __('Is Opening Balance') ?></th>
                <th scope="col"><?= __('Sales Invoice Id') ?></th>
                <th scope="col"><?= __('Sale Return Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Id') ?></th>
                <th scope="col"><?= __('Purchase Return Id') ?></th>
                <th scope="col"><?= __('Receipt Id') ?></th>
                <th scope="col"><?= __('Receipt Row Id') ?></th>
                <th scope="col"><?= __('Payment Id') ?></th>
                <th scope="col"><?= __('Payment Row Id') ?></th>
                <th scope="col"><?= __('Credit Note Id') ?></th>
                <th scope="col"><?= __('Credit Note Row Id') ?></th>
                <th scope="col"><?= __('Debit Note Id') ?></th>
                <th scope="col"><?= __('Debit Note Row Id') ?></th>
                <th scope="col"><?= __('Sales Voucher Id') ?></th>
                <th scope="col"><?= __('Sales Voucher Row Id') ?></th>
                <th scope="col"><?= __('Journal Voucher Id') ?></th>
                <th scope="col"><?= __('Journal Voucher Row Id') ?></th>
                <th scope="col"><?= __('Contra Voucher Id') ?></th>
                <th scope="col"><?= __('Contra Voucher Row Id') ?></th>
                <th scope="col"><?= __('Reconciliation Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($receipt->accounting_entries as $accountingEntries): ?>
            <tr>
                <td><?= h($accountingEntries->id) ?></td>
                <td><?= h($accountingEntries->ledger_id) ?></td>
                <td><?= h($accountingEntries->debit) ?></td>
                <td><?= h($accountingEntries->credit) ?></td>
                <td><?= h($accountingEntries->transaction_date) ?></td>
                <td><?= h($accountingEntries->location_id) ?></td>
                <td><?= h($accountingEntries->city_id) ?></td>
                <td><?= h($accountingEntries->purchase_voucher_id) ?></td>
                <td><?= h($accountingEntries->purchase_voucher_row_id) ?></td>
                <td><?= h($accountingEntries->is_opening_balance) ?></td>
                <td><?= h($accountingEntries->sales_invoice_id) ?></td>
                <td><?= h($accountingEntries->sale_return_id) ?></td>
                <td><?= h($accountingEntries->purchase_invoice_id) ?></td>
                <td><?= h($accountingEntries->purchase_return_id) ?></td>
                <td><?= h($accountingEntries->receipt_id) ?></td>
                <td><?= h($accountingEntries->receipt_row_id) ?></td>
                <td><?= h($accountingEntries->payment_id) ?></td>
                <td><?= h($accountingEntries->payment_row_id) ?></td>
                <td><?= h($accountingEntries->credit_note_id) ?></td>
                <td><?= h($accountingEntries->credit_note_row_id) ?></td>
                <td><?= h($accountingEntries->debit_note_id) ?></td>
                <td><?= h($accountingEntries->debit_note_row_id) ?></td>
                <td><?= h($accountingEntries->sales_voucher_id) ?></td>
                <td><?= h($accountingEntries->sales_voucher_row_id) ?></td>
                <td><?= h($accountingEntries->journal_voucher_id) ?></td>
                <td><?= h($accountingEntries->journal_voucher_row_id) ?></td>
                <td><?= h($accountingEntries->contra_voucher_id) ?></td>
                <td><?= h($accountingEntries->contra_voucher_row_id) ?></td>
                <td><?= h($accountingEntries->reconciliation_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AccountingEntries', 'action' => 'view', $accountingEntries->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AccountingEntries', 'action' => 'edit', $accountingEntries->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccountingEntries', 'action' => 'delete', $accountingEntries->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountingEntries->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Receipt Rows') ?></h4>
        <?php if (!empty($receipt->receipt_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Receipt Id') ?></th>
                <th scope="col"><?= __('Cr Dr') ?></th>
                <th scope="col"><?= __('Ledger Id') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Mode Of Payment') ?></th>
                <th scope="col"><?= __('Cheque No') ?></th>
                <th scope="col"><?= __('Cheque Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($receipt->receipt_rows as $receiptRows): ?>
            <tr>
                <td><?= h($receiptRows->id) ?></td>
                <td><?= h($receiptRows->receipt_id) ?></td>
                <td><?= h($receiptRows->cr_dr) ?></td>
                <td><?= h($receiptRows->ledger_id) ?></td>
                <td><?= h($receiptRows->debit) ?></td>
                <td><?= h($receiptRows->credit) ?></td>
                <td><?= h($receiptRows->mode_of_payment) ?></td>
                <td><?= h($receiptRows->cheque_no) ?></td>
                <td><?= h($receiptRows->cheque_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ReceiptRows', 'action' => 'view', $receiptRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ReceiptRows', 'action' => 'edit', $receiptRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ReceiptRows', 'action' => 'delete', $receiptRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receiptRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Reference Details') ?></h4>
        <?php if (!empty($receipt->reference_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Supplier Id') ?></th>
                <th scope="col"><?= __('Seller Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Ledger Id') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Ref Name') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Receipt Id') ?></th>
                <th scope="col"><?= __('Receipt Row Id') ?></th>
                <th scope="col"><?= __('Payment Row Id') ?></th>
                <th scope="col"><?= __('Credit Note Id') ?></th>
                <th scope="col"><?= __('Credit Note Row Id') ?></th>
                <th scope="col"><?= __('Debit Note Id') ?></th>
                <th scope="col"><?= __('Debit Note Row Id') ?></th>
                <th scope="col"><?= __('Sales Voucher Row Id') ?></th>
                <th scope="col"><?= __('Purchase Voucher Row Id') ?></th>
                <th scope="col"><?= __('Journal Voucher Row Id') ?></th>
                <th scope="col"><?= __('Sale Return Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Id') ?></th>
                <th scope="col"><?= __('Purchase Return Id') ?></th>
                <th scope="col"><?= __('Sales Invoice Id') ?></th>
                <th scope="col"><?= __('Opening Balance') ?></th>
                <th scope="col"><?= __('Due Days') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($receipt->reference_details as $referenceDetails): ?>
            <tr>
                <td><?= h($referenceDetails->id) ?></td>
                <td><?= h($referenceDetails->customer_id) ?></td>
                <td><?= h($referenceDetails->supplier_id) ?></td>
                <td><?= h($referenceDetails->seller_id) ?></td>
                <td><?= h($referenceDetails->transaction_date) ?></td>
                <td><?= h($referenceDetails->ledger_id) ?></td>
                <td><?= h($referenceDetails->type) ?></td>
                <td><?= h($referenceDetails->ref_name) ?></td>
                <td><?= h($referenceDetails->debit) ?></td>
                <td><?= h($referenceDetails->credit) ?></td>
                <td><?= h($referenceDetails->receipt_id) ?></td>
                <td><?= h($referenceDetails->receipt_row_id) ?></td>
                <td><?= h($referenceDetails->payment_row_id) ?></td>
                <td><?= h($referenceDetails->credit_note_id) ?></td>
                <td><?= h($referenceDetails->credit_note_row_id) ?></td>
                <td><?= h($referenceDetails->debit_note_id) ?></td>
                <td><?= h($referenceDetails->debit_note_row_id) ?></td>
                <td><?= h($referenceDetails->sales_voucher_row_id) ?></td>
                <td><?= h($referenceDetails->purchase_voucher_row_id) ?></td>
                <td><?= h($referenceDetails->journal_voucher_row_id) ?></td>
                <td><?= h($referenceDetails->sale_return_id) ?></td>
                <td><?= h($referenceDetails->purchase_invoice_id) ?></td>
                <td><?= h($referenceDetails->purchase_return_id) ?></td>
                <td><?= h($referenceDetails->sales_invoice_id) ?></td>
                <td><?= h($referenceDetails->opening_balance) ?></td>
                <td><?= h($referenceDetails->due_days) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ReferenceDetails', 'action' => 'view', $referenceDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ReferenceDetails', 'action' => 'edit', $referenceDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ReferenceDetails', 'action' => 'delete', $referenceDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $referenceDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
