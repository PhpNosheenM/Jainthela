<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ledger $ledger
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ledger'), ['action' => 'edit', $ledger->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ledger'), ['action' => 'delete', $ledger->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ledger->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ledgers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounting Groups'), ['controller' => 'AccountingGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting Group'), ['controller' => 'AccountingGroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Gst Figures'), ['controller' => 'GstFigures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Gst Figure'), ['controller' => 'GstFigures', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Credit Note Rows'), ['controller' => 'CreditNoteRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Credit Note Row'), ['controller' => 'CreditNoteRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Debit Note Rows'), ['controller' => 'DebitNoteRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Debit Note Row'), ['controller' => 'DebitNoteRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Journal Voucher Rows'), ['controller' => 'JournalVoucherRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Journal Voucher Row'), ['controller' => 'JournalVoucherRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payment Rows'), ['controller' => 'PaymentRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment Row'), ['controller' => 'PaymentRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Voucher Rows'), ['controller' => 'PurchaseVoucherRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Voucher Row'), ['controller' => 'PurchaseVoucherRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Receipt Rows'), ['controller' => 'ReceiptRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receipt Row'), ['controller' => 'ReceiptRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reference Details'), ['controller' => 'ReferenceDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['controller' => 'ReferenceDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Voucher Rows'), ['controller' => 'SalesVoucherRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Voucher Row'), ['controller' => 'SalesVoucherRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ledgers view large-9 medium-8 columns content">
    <h3><?= h($ledger->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($ledger->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Accounting Group') ?></th>
            <td><?= $ledger->has('accounting_group') ? $this->Html->link($ledger->accounting_group->name, ['controller' => 'AccountingGroups', 'action' => 'view', $ledger->accounting_group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $ledger->has('location') ? $this->Html->link($ledger->location->name, ['controller' => 'Locations', 'action' => 'view', $ledger->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Supplier') ?></th>
            <td><?= $ledger->has('supplier') ? $this->Html->link($ledger->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $ledger->supplier->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $ledger->has('customer') ? $this->Html->link($ledger->customer->name, ['controller' => 'Customers', 'action' => 'view', $ledger->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Type') ?></th>
            <td><?= h($ledger->gst_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Input Output') ?></th>
            <td><?= h($ledger->input_output) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Figure') ?></th>
            <td><?= $ledger->has('gst_figure') ? $this->Html->link($ledger->gst_figure->name, ['controller' => 'GstFigures', 'action' => 'view', $ledger->gst_figure->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bill To Bill Accounting') ?></th>
            <td><?= h($ledger->bill_to_bill_accounting) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($ledger->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax Percentage') ?></th>
            <td><?= $this->Number->format($ledger->tax_percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Round Off') ?></th>
            <td><?= $this->Number->format($ledger->round_off) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cash') ?></th>
            <td><?= $this->Number->format($ledger->cash) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Flag') ?></th>
            <td><?= $this->Number->format($ledger->flag) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Default Credit Days') ?></th>
            <td><?= $this->Number->format($ledger->default_credit_days) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Freeze') ?></th>
            <td><?= $ledger->freeze ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Accounting Entries') ?></h4>
        <?php if (!empty($ledger->accounting_entries)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Ledger Id') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
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
            <?php foreach ($ledger->accounting_entries as $accountingEntries): ?>
            <tr>
                <td><?= h($accountingEntries->id) ?></td>
                <td><?= h($accountingEntries->ledger_id) ?></td>
                <td><?= h($accountingEntries->debit) ?></td>
                <td><?= h($accountingEntries->credit) ?></td>
                <td><?= h($accountingEntries->transaction_date) ?></td>
                <td><?= h($accountingEntries->location_id) ?></td>
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
        <h4><?= __('Related Credit Note Rows') ?></h4>
        <?php if (!empty($ledger->credit_note_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Credit Note Id') ?></th>
                <th scope="col"><?= __('Cr Dr') ?></th>
                <th scope="col"><?= __('Ledger Id') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Mode Of Payment') ?></th>
                <th scope="col"><?= __('Cheque No') ?></th>
                <th scope="col"><?= __('Cheque Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ledger->credit_note_rows as $creditNoteRows): ?>
            <tr>
                <td><?= h($creditNoteRows->id) ?></td>
                <td><?= h($creditNoteRows->credit_note_id) ?></td>
                <td><?= h($creditNoteRows->cr_dr) ?></td>
                <td><?= h($creditNoteRows->ledger_id) ?></td>
                <td><?= h($creditNoteRows->debit) ?></td>
                <td><?= h($creditNoteRows->credit) ?></td>
                <td><?= h($creditNoteRows->mode_of_payment) ?></td>
                <td><?= h($creditNoteRows->cheque_no) ?></td>
                <td><?= h($creditNoteRows->cheque_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CreditNoteRows', 'action' => 'view', $creditNoteRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CreditNoteRows', 'action' => 'edit', $creditNoteRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CreditNoteRows', 'action' => 'delete', $creditNoteRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $creditNoteRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Debit Note Rows') ?></h4>
        <?php if (!empty($ledger->debit_note_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Debit Note Id') ?></th>
                <th scope="col"><?= __('Cr Dr') ?></th>
                <th scope="col"><?= __('Ledger Id') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Mode Of Payment') ?></th>
                <th scope="col"><?= __('Cheque No') ?></th>
                <th scope="col"><?= __('Cheque Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ledger->debit_note_rows as $debitNoteRows): ?>
            <tr>
                <td><?= h($debitNoteRows->id) ?></td>
                <td><?= h($debitNoteRows->debit_note_id) ?></td>
                <td><?= h($debitNoteRows->cr_dr) ?></td>
                <td><?= h($debitNoteRows->ledger_id) ?></td>
                <td><?= h($debitNoteRows->debit) ?></td>
                <td><?= h($debitNoteRows->credit) ?></td>
                <td><?= h($debitNoteRows->mode_of_payment) ?></td>
                <td><?= h($debitNoteRows->cheque_no) ?></td>
                <td><?= h($debitNoteRows->cheque_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DebitNoteRows', 'action' => 'view', $debitNoteRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DebitNoteRows', 'action' => 'edit', $debitNoteRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DebitNoteRows', 'action' => 'delete', $debitNoteRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $debitNoteRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Journal Voucher Rows') ?></h4>
        <?php if (!empty($ledger->journal_voucher_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Journal Voucher Id') ?></th>
                <th scope="col"><?= __('Cr Dr') ?></th>
                <th scope="col"><?= __('Ledger Id') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Mode Of Payment') ?></th>
                <th scope="col"><?= __('Cheque No') ?></th>
                <th scope="col"><?= __('Cheque Date') ?></th>
                <th scope="col"><?= __('Total') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ledger->journal_voucher_rows as $journalVoucherRows): ?>
            <tr>
                <td><?= h($journalVoucherRows->id) ?></td>
                <td><?= h($journalVoucherRows->journal_voucher_id) ?></td>
                <td><?= h($journalVoucherRows->cr_dr) ?></td>
                <td><?= h($journalVoucherRows->ledger_id) ?></td>
                <td><?= h($journalVoucherRows->debit) ?></td>
                <td><?= h($journalVoucherRows->credit) ?></td>
                <td><?= h($journalVoucherRows->mode_of_payment) ?></td>
                <td><?= h($journalVoucherRows->cheque_no) ?></td>
                <td><?= h($journalVoucherRows->cheque_date) ?></td>
                <td><?= h($journalVoucherRows->total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'JournalVoucherRows', 'action' => 'view', $journalVoucherRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'JournalVoucherRows', 'action' => 'edit', $journalVoucherRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'JournalVoucherRows', 'action' => 'delete', $journalVoucherRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $journalVoucherRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Payment Rows') ?></h4>
        <?php if (!empty($ledger->payment_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Payment Id') ?></th>
                <th scope="col"><?= __('Cr Dr') ?></th>
                <th scope="col"><?= __('Ledger Id') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Mode Of Payment') ?></th>
                <th scope="col"><?= __('Cheque No') ?></th>
                <th scope="col"><?= __('Cheque Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ledger->payment_rows as $paymentRows): ?>
            <tr>
                <td><?= h($paymentRows->id) ?></td>
                <td><?= h($paymentRows->payment_id) ?></td>
                <td><?= h($paymentRows->cr_dr) ?></td>
                <td><?= h($paymentRows->ledger_id) ?></td>
                <td><?= h($paymentRows->debit) ?></td>
                <td><?= h($paymentRows->credit) ?></td>
                <td><?= h($paymentRows->mode_of_payment) ?></td>
                <td><?= h($paymentRows->cheque_no) ?></td>
                <td><?= h($paymentRows->cheque_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PaymentRows', 'action' => 'view', $paymentRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PaymentRows', 'action' => 'edit', $paymentRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PaymentRows', 'action' => 'delete', $paymentRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $paymentRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Purchase Voucher Rows') ?></h4>
        <?php if (!empty($ledger->purchase_voucher_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Purchase Voucher Id') ?></th>
                <th scope="col"><?= __('Cr Dr') ?></th>
                <th scope="col"><?= __('Ledger Id') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Mode Of Payment') ?></th>
                <th scope="col"><?= __('Cheque No') ?></th>
                <th scope="col"><?= __('Cheque Date') ?></th>
                <th scope="col"><?= __('Total') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ledger->purchase_voucher_rows as $purchaseVoucherRows): ?>
            <tr>
                <td><?= h($purchaseVoucherRows->id) ?></td>
                <td><?= h($purchaseVoucherRows->purchase_voucher_id) ?></td>
                <td><?= h($purchaseVoucherRows->cr_dr) ?></td>
                <td><?= h($purchaseVoucherRows->ledger_id) ?></td>
                <td><?= h($purchaseVoucherRows->debit) ?></td>
                <td><?= h($purchaseVoucherRows->credit) ?></td>
                <td><?= h($purchaseVoucherRows->mode_of_payment) ?></td>
                <td><?= h($purchaseVoucherRows->cheque_no) ?></td>
                <td><?= h($purchaseVoucherRows->cheque_date) ?></td>
                <td><?= h($purchaseVoucherRows->total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PurchaseVoucherRows', 'action' => 'view', $purchaseVoucherRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PurchaseVoucherRows', 'action' => 'edit', $purchaseVoucherRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PurchaseVoucherRows', 'action' => 'delete', $purchaseVoucherRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseVoucherRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Receipt Rows') ?></h4>
        <?php if (!empty($ledger->receipt_rows)): ?>
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
            <?php foreach ($ledger->receipt_rows as $receiptRows): ?>
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
        <?php if (!empty($ledger->reference_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Supplier Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
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
            <?php foreach ($ledger->reference_details as $referenceDetails): ?>
            <tr>
                <td><?= h($referenceDetails->id) ?></td>
                <td><?= h($referenceDetails->customer_id) ?></td>
                <td><?= h($referenceDetails->supplier_id) ?></td>
                <td><?= h($referenceDetails->transaction_date) ?></td>
                <td><?= h($referenceDetails->location_id) ?></td>
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
    <div class="related">
        <h4><?= __('Related Sales Voucher Rows') ?></h4>
        <?php if (!empty($ledger->sales_voucher_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Sales Voucher Id') ?></th>
                <th scope="col"><?= __('Cr Dr') ?></th>
                <th scope="col"><?= __('Ledger Id') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Mode Of Payment') ?></th>
                <th scope="col"><?= __('Cheque No') ?></th>
                <th scope="col"><?= __('Cheque Date') ?></th>
                <th scope="col"><?= __('Total') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ledger->sales_voucher_rows as $salesVoucherRows): ?>
            <tr>
                <td><?= h($salesVoucherRows->id) ?></td>
                <td><?= h($salesVoucherRows->sales_voucher_id) ?></td>
                <td><?= h($salesVoucherRows->cr_dr) ?></td>
                <td><?= h($salesVoucherRows->ledger_id) ?></td>
                <td><?= h($salesVoucherRows->debit) ?></td>
                <td><?= h($salesVoucherRows->credit) ?></td>
                <td><?= h($salesVoucherRows->mode_of_payment) ?></td>
                <td><?= h($salesVoucherRows->cheque_no) ?></td>
                <td><?= h($salesVoucherRows->cheque_date) ?></td>
                <td><?= h($salesVoucherRows->total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SalesVoucherRows', 'action' => 'view', $salesVoucherRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SalesVoucherRows', 'action' => 'edit', $salesVoucherRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SalesVoucherRows', 'action' => 'delete', $salesVoucherRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesVoucherRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
