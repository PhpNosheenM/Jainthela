<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location $location
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Location'), ['action' => 'edit', $location->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Location'), ['action' => 'delete', $location->id], ['confirm' => __('Are you sure you want to delete # {0}?', $location->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounting Groups'), ['controller' => 'AccountingGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting Group'), ['controller' => 'AccountingGroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Admins'), ['controller' => 'Admins', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Admin'), ['controller' => 'Admins', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Credit Notes'), ['controller' => 'CreditNotes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Credit Note'), ['controller' => 'CreditNotes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customer Addresses'), ['controller' => 'CustomerAddresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer Address'), ['controller' => 'CustomerAddresses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Debit Notes'), ['controller' => 'DebitNotes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Debit Note'), ['controller' => 'DebitNotes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Drivers'), ['controller' => 'Drivers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Driver'), ['controller' => 'Drivers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Grns'), ['controller' => 'Grns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grn'), ['controller' => 'Grns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Gst Figures'), ['controller' => 'GstFigures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Gst Figure'), ['controller' => 'GstFigures', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Journal Vouchers'), ['controller' => 'JournalVouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Journal Voucher'), ['controller' => 'JournalVouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Invoices'), ['controller' => 'PurchaseInvoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Invoice'), ['controller' => 'PurchaseInvoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Returns'), ['controller' => 'PurchaseReturns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Return'), ['controller' => 'PurchaseReturns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Vouchers'), ['controller' => 'PurchaseVouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Voucher'), ['controller' => 'PurchaseVouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Receipts'), ['controller' => 'Receipts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receipt'), ['controller' => 'Receipts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reference Details'), ['controller' => 'ReferenceDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['controller' => 'ReferenceDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['controller' => 'SaleReturns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return'), ['controller' => 'SaleReturns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Invoices'), ['controller' => 'SalesInvoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Invoice'), ['controller' => 'SalesInvoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Vouchers'), ['controller' => 'SalesVouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Voucher'), ['controller' => 'SalesVouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="locations view large-9 medium-8 columns content">
    <h3><?= h($location->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $location->has('city') ? $this->Html->link($location->city->name, ['controller' => 'Cities', 'action' => 'view', $location->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($location->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Latitude') ?></th>
            <td><?= h($location->latitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Longitude') ?></th>
            <td><?= h($location->longitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($location->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= $this->Number->format($location->created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($location->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($location->status) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Accounting Entries') ?></h4>
        <?php if (!empty($location->accounting_entries)): ?>
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
            <?php foreach ($location->accounting_entries as $accountingEntries): ?>
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
        <h4><?= __('Related Accounting Groups') ?></h4>
        <?php if (!empty($location->accounting_groups)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Nature Of Group Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Parent Id') ?></th>
                <th scope="col"><?= __('Lft') ?></th>
                <th scope="col"><?= __('Rght') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Customer') ?></th>
                <th scope="col"><?= __('Supplier') ?></th>
                <th scope="col"><?= __('Purchase Voucher First Ledger') ?></th>
                <th scope="col"><?= __('Purchase Voucher Purchase Ledger') ?></th>
                <th scope="col"><?= __('Purchase Voucher All Ledger') ?></th>
                <th scope="col"><?= __('Sale Invoice Party') ?></th>
                <th scope="col"><?= __('Sale Invoice Sales Account') ?></th>
                <th scope="col"><?= __('Credit Note Party') ?></th>
                <th scope="col"><?= __('Credit Note Sales Account') ?></th>
                <th scope="col"><?= __('Bank') ?></th>
                <th scope="col"><?= __('Cash') ?></th>
                <th scope="col"><?= __('Purchase Invoice Purchase Account') ?></th>
                <th scope="col"><?= __('Purchase Invoice Party') ?></th>
                <th scope="col"><?= __('Receipt Ledger') ?></th>
                <th scope="col"><?= __('Payment Ledger') ?></th>
                <th scope="col"><?= __('Credit Note First Row') ?></th>
                <th scope="col"><?= __('Credit Note All Row') ?></th>
                <th scope="col"><?= __('Debit Note First Row') ?></th>
                <th scope="col"><?= __('Debit Note All Row') ?></th>
                <th scope="col"><?= __('Sales Voucher First Ledger') ?></th>
                <th scope="col"><?= __('Sales Voucher Sales Ledger') ?></th>
                <th scope="col"><?= __('Sales Voucher All Ledger') ?></th>
                <th scope="col"><?= __('Journal Voucher Ledger') ?></th>
                <th scope="col"><?= __('Contra Voucher Ledger') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->accounting_groups as $accountingGroups): ?>
            <tr>
                <td><?= h($accountingGroups->id) ?></td>
                <td><?= h($accountingGroups->nature_of_group_id) ?></td>
                <td><?= h($accountingGroups->name) ?></td>
                <td><?= h($accountingGroups->parent_id) ?></td>
                <td><?= h($accountingGroups->lft) ?></td>
                <td><?= h($accountingGroups->rght) ?></td>
                <td><?= h($accountingGroups->location_id) ?></td>
                <td><?= h($accountingGroups->customer) ?></td>
                <td><?= h($accountingGroups->supplier) ?></td>
                <td><?= h($accountingGroups->purchase_voucher_first_ledger) ?></td>
                <td><?= h($accountingGroups->purchase_voucher_purchase_ledger) ?></td>
                <td><?= h($accountingGroups->purchase_voucher_all_ledger) ?></td>
                <td><?= h($accountingGroups->sale_invoice_party) ?></td>
                <td><?= h($accountingGroups->sale_invoice_sales_account) ?></td>
                <td><?= h($accountingGroups->credit_note_party) ?></td>
                <td><?= h($accountingGroups->credit_note_sales_account) ?></td>
                <td><?= h($accountingGroups->bank) ?></td>
                <td><?= h($accountingGroups->cash) ?></td>
                <td><?= h($accountingGroups->purchase_invoice_purchase_account) ?></td>
                <td><?= h($accountingGroups->purchase_invoice_party) ?></td>
                <td><?= h($accountingGroups->receipt_ledger) ?></td>
                <td><?= h($accountingGroups->payment_ledger) ?></td>
                <td><?= h($accountingGroups->credit_note_first_row) ?></td>
                <td><?= h($accountingGroups->credit_note_all_row) ?></td>
                <td><?= h($accountingGroups->debit_note_first_row) ?></td>
                <td><?= h($accountingGroups->debit_note_all_row) ?></td>
                <td><?= h($accountingGroups->sales_voucher_first_ledger) ?></td>
                <td><?= h($accountingGroups->sales_voucher_sales_ledger) ?></td>
                <td><?= h($accountingGroups->sales_voucher_all_ledger) ?></td>
                <td><?= h($accountingGroups->journal_voucher_ledger) ?></td>
                <td><?= h($accountingGroups->contra_voucher_ledger) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AccountingGroups', 'action' => 'view', $accountingGroups->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AccountingGroups', 'action' => 'edit', $accountingGroups->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccountingGroups', 'action' => 'delete', $accountingGroups->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountingGroups->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Admins') ?></h4>
        <?php if (!empty($location->admins)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Role Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Username') ?></th>
                <th scope="col"><?= __('Password') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Mobile No') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Passkey') ?></th>
                <th scope="col"><?= __('Timeout') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->admins as $admins): ?>
            <tr>
                <td><?= h($admins->id) ?></td>
                <td><?= h($admins->location_id) ?></td>
                <td><?= h($admins->role_id) ?></td>
                <td><?= h($admins->name) ?></td>
                <td><?= h($admins->username) ?></td>
                <td><?= h($admins->password) ?></td>
                <td><?= h($admins->email) ?></td>
                <td><?= h($admins->mobile_no) ?></td>
                <td><?= h($admins->created_on) ?></td>
                <td><?= h($admins->created_by) ?></td>
                <td><?= h($admins->passkey) ?></td>
                <td><?= h($admins->timeout) ?></td>
                <td><?= h($admins->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Admins', 'action' => 'view', $admins->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Admins', 'action' => 'edit', $admins->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Admins', 'action' => 'delete', $admins->id], ['confirm' => __('Are you sure you want to delete # {0}?', $admins->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Credit Notes') ?></h4>
        <?php if (!empty($location->credit_notes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Narration') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->credit_notes as $creditNotes): ?>
            <tr>
                <td><?= h($creditNotes->id) ?></td>
                <td><?= h($creditNotes->status) ?></td>
                <td><?= h($creditNotes->voucher_no) ?></td>
                <td><?= h($creditNotes->location_id) ?></td>
                <td><?= h($creditNotes->transaction_date) ?></td>
                <td><?= h($creditNotes->narration) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CreditNotes', 'action' => 'view', $creditNotes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CreditNotes', 'action' => 'edit', $creditNotes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CreditNotes', 'action' => 'delete', $creditNotes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $creditNotes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Customer Addresses') ?></h4>
        <?php if (!empty($location->customer_addresses)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Pincode') ?></th>
                <th scope="col"><?= __('House No') ?></th>
                <th scope="col"><?= __('Address') ?></th>
                <th scope="col"><?= __('Landmark') ?></th>
                <th scope="col"><?= __('Latitude') ?></th>
                <th scope="col"><?= __('Longitude') ?></th>
                <th scope="col"><?= __('Default Address') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->customer_addresses as $customerAddresses): ?>
            <tr>
                <td><?= h($customerAddresses->id) ?></td>
                <td><?= h($customerAddresses->customer_id) ?></td>
                <td><?= h($customerAddresses->city_id) ?></td>
                <td><?= h($customerAddresses->location_id) ?></td>
                <td><?= h($customerAddresses->pincode) ?></td>
                <td><?= h($customerAddresses->house_no) ?></td>
                <td><?= h($customerAddresses->address) ?></td>
                <td><?= h($customerAddresses->landmark) ?></td>
                <td><?= h($customerAddresses->latitude) ?></td>
                <td><?= h($customerAddresses->longitude) ?></td>
                <td><?= h($customerAddresses->default_address) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CustomerAddresses', 'action' => 'view', $customerAddresses->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CustomerAddresses', 'action' => 'edit', $customerAddresses->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CustomerAddresses', 'action' => 'delete', $customerAddresses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerAddresses->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Debit Notes') ?></h4>
        <?php if (!empty($location->debit_notes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Narration') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->debit_notes as $debitNotes): ?>
            <tr>
                <td><?= h($debitNotes->id) ?></td>
                <td><?= h($debitNotes->voucher_no) ?></td>
                <td><?= h($debitNotes->location_id) ?></td>
                <td><?= h($debitNotes->transaction_date) ?></td>
                <td><?= h($debitNotes->narration) ?></td>
                <td><?= h($debitNotes->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DebitNotes', 'action' => 'view', $debitNotes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DebitNotes', 'action' => 'edit', $debitNotes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DebitNotes', 'action' => 'delete', $debitNotes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $debitNotes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Drivers') ?></h4>
        <?php if (!empty($location->drivers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('User Name') ?></th>
                <th scope="col"><?= __('Password') ?></th>
                <th scope="col"><?= __('Mobile No') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Device Token') ?></th>
                <th scope="col"><?= __('Latitude') ?></th>
                <th scope="col"><?= __('Longitude') ?></th>
                <th scope="col"><?= __('Supplier Type') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->drivers as $drivers): ?>
            <tr>
                <td><?= h($drivers->id) ?></td>
                <td><?= h($drivers->name) ?></td>
                <td><?= h($drivers->user_name) ?></td>
                <td><?= h($drivers->password) ?></td>
                <td><?= h($drivers->mobile_no) ?></td>
                <td><?= h($drivers->location_id) ?></td>
                <td><?= h($drivers->device_token) ?></td>
                <td><?= h($drivers->latitude) ?></td>
                <td><?= h($drivers->longitude) ?></td>
                <td><?= h($drivers->supplier_type) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Drivers', 'action' => 'view', $drivers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Drivers', 'action' => 'edit', $drivers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Drivers', 'action' => 'delete', $drivers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $drivers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Grns') ?></h4>
        <?php if (!empty($location->grns)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Company Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Reference No') ?></th>
                <th scope="col"><?= __('Total Purchase') ?></th>
                <th scope="col"><?= __('Total Sale') ?></th>
                <th scope="col"><?= __('Supplier Ledger Id') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->grns as $grns): ?>
            <tr>
                <td><?= h($grns->id) ?></td>
                <td><?= h($grns->voucher_no) ?></td>
                <td><?= h($grns->location_id) ?></td>
                <td><?= h($grns->company_id) ?></td>
                <td><?= h($grns->transaction_date) ?></td>
                <td><?= h($grns->reference_no) ?></td>
                <td><?= h($grns->total_purchase) ?></td>
                <td><?= h($grns->total_sale) ?></td>
                <td><?= h($grns->supplier_ledger_id) ?></td>
                <td><?= h($grns->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Grns', 'action' => 'view', $grns->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Grns', 'action' => 'edit', $grns->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Grns', 'action' => 'delete', $grns->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grns->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Gst Figures') ?></h4>
        <?php if (!empty($location->gst_figures)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Tax Percentage') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->gst_figures as $gstFigures): ?>
            <tr>
                <td><?= h($gstFigures->id) ?></td>
                <td><?= h($gstFigures->name) ?></td>
                <td><?= h($gstFigures->location_id) ?></td>
                <td><?= h($gstFigures->tax_percentage) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'GstFigures', 'action' => 'view', $gstFigures->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'GstFigures', 'action' => 'edit', $gstFigures->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'GstFigures', 'action' => 'delete', $gstFigures->id], ['confirm' => __('Are you sure you want to delete # {0}?', $gstFigures->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Journal Vouchers') ?></h4>
        <?php if (!empty($location->journal_vouchers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Reference No') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Narration') ?></th>
                <th scope="col"><?= __('Total Credit Amount') ?></th>
                <th scope="col"><?= __('Total Debit Amount') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->journal_vouchers as $journalVouchers): ?>
            <tr>
                <td><?= h($journalVouchers->id) ?></td>
                <td><?= h($journalVouchers->voucher_no) ?></td>
                <td><?= h($journalVouchers->reference_no) ?></td>
                <td><?= h($journalVouchers->location_id) ?></td>
                <td><?= h($journalVouchers->transaction_date) ?></td>
                <td><?= h($journalVouchers->narration) ?></td>
                <td><?= h($journalVouchers->total_credit_amount) ?></td>
                <td><?= h($journalVouchers->total_debit_amount) ?></td>
                <td><?= h($journalVouchers->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'JournalVouchers', 'action' => 'view', $journalVouchers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'JournalVouchers', 'action' => 'edit', $journalVouchers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'JournalVouchers', 'action' => 'delete', $journalVouchers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $journalVouchers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Orders') ?></h4>
        <?php if (!empty($location->orders)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Driver Id') ?></th>
                <th scope="col"><?= __('Customer Address Id') ?></th>
                <th scope="col"><?= __('Offer Detail Id') ?></th>
                <th scope="col"><?= __('Order No') ?></th>
                <th scope="col"><?= __('Ccavvenue Tracking No') ?></th>
                <th scope="col"><?= __('Amount From Wallet') ?></th>
                <th scope="col"><?= __('Total Amount') ?></th>
                <th scope="col"><?= __('Discount Percent') ?></th>
                <th scope="col"><?= __('Grand Total') ?></th>
                <th scope="col"><?= __('Pay Amount') ?></th>
                <th scope="col"><?= __('Online Amount') ?></th>
                <th scope="col"><?= __('Delivery Charge Id') ?></th>
                <th scope="col"><?= __('Order Type') ?></th>
                <th scope="col"><?= __('Delivery Date') ?></th>
                <th scope="col"><?= __('Delivery Time Id') ?></th>
                <th scope="col"><?= __('Order Status') ?></th>
                <th scope="col"><?= __('Cancel Reason Id') ?></th>
                <th scope="col"><?= __('Order Date') ?></th>
                <th scope="col"><?= __('Payment Status') ?></th>
                <th scope="col"><?= __('Order From') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->orders as $orders): ?>
            <tr>
                <td><?= h($orders->id) ?></td>
                <td><?= h($orders->location_id) ?></td>
                <td><?= h($orders->customer_id) ?></td>
                <td><?= h($orders->driver_id) ?></td>
                <td><?= h($orders->customer_address_id) ?></td>
                <td><?= h($orders->offer_detail_id) ?></td>
                <td><?= h($orders->order_no) ?></td>
                <td><?= h($orders->ccavvenue_tracking_no) ?></td>
                <td><?= h($orders->amount_from_wallet) ?></td>
                <td><?= h($orders->total_amount) ?></td>
                <td><?= h($orders->discount_percent) ?></td>
                <td><?= h($orders->grand_total) ?></td>
                <td><?= h($orders->pay_amount) ?></td>
                <td><?= h($orders->online_amount) ?></td>
                <td><?= h($orders->delivery_charge_id) ?></td>
                <td><?= h($orders->order_type) ?></td>
                <td><?= h($orders->delivery_date) ?></td>
                <td><?= h($orders->delivery_time_id) ?></td>
                <td><?= h($orders->order_status) ?></td>
                <td><?= h($orders->cancel_reason_id) ?></td>
                <td><?= h($orders->order_date) ?></td>
                <td><?= h($orders->payment_status) ?></td>
                <td><?= h($orders->order_from) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Orders', 'action' => 'view', $orders->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Orders', 'action' => 'edit', $orders->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Orders', 'action' => 'delete', $orders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orders->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Payments') ?></h4>
        <?php if (!empty($location->payments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Narration') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->payments as $payments): ?>
            <tr>
                <td><?= h($payments->id) ?></td>
                <td><?= h($payments->voucher_no) ?></td>
                <td><?= h($payments->location_id) ?></td>
                <td><?= h($payments->transaction_date) ?></td>
                <td><?= h($payments->narration) ?></td>
                <td><?= h($payments->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Payments', 'action' => 'view', $payments->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Payments', 'action' => 'edit', $payments->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Payments', 'action' => 'delete', $payments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payments->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Purchase Invoices') ?></h4>
        <?php if (!empty($location->purchase_invoices)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Supplier Ledger Id') ?></th>
                <th scope="col"><?= __('Purchase Ledger Id') ?></th>
                <th scope="col"><?= __('Grn Id') ?></th>
                <th scope="col"><?= __('Narration') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->purchase_invoices as $purchaseInvoices): ?>
            <tr>
                <td><?= h($purchaseInvoices->id) ?></td>
                <td><?= h($purchaseInvoices->voucher_no) ?></td>
                <td><?= h($purchaseInvoices->location_id) ?></td>
                <td><?= h($purchaseInvoices->transaction_date) ?></td>
                <td><?= h($purchaseInvoices->supplier_ledger_id) ?></td>
                <td><?= h($purchaseInvoices->purchase_ledger_id) ?></td>
                <td><?= h($purchaseInvoices->grn_id) ?></td>
                <td><?= h($purchaseInvoices->narration) ?></td>
                <td><?= h($purchaseInvoices->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PurchaseInvoices', 'action' => 'view', $purchaseInvoices->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PurchaseInvoices', 'action' => 'edit', $purchaseInvoices->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PurchaseInvoices', 'action' => 'delete', $purchaseInvoices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseInvoices->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Purchase Returns') ?></h4>
        <?php if (!empty($location->purchase_returns)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Id') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Total Amount') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->purchase_returns as $purchaseReturns): ?>
            <tr>
                <td><?= h($purchaseReturns->id) ?></td>
                <td><?= h($purchaseReturns->purchase_invoice_id) ?></td>
                <td><?= h($purchaseReturns->voucher_no) ?></td>
                <td><?= h($purchaseReturns->location_id) ?></td>
                <td><?= h($purchaseReturns->transaction_date) ?></td>
                <td><?= h($purchaseReturns->total_amount) ?></td>
                <td><?= h($purchaseReturns->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PurchaseReturns', 'action' => 'view', $purchaseReturns->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PurchaseReturns', 'action' => 'edit', $purchaseReturns->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PurchaseReturns', 'action' => 'delete', $purchaseReturns->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseReturns->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Purchase Vouchers') ?></h4>
        <?php if (!empty($location->purchase_vouchers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Supplier Invoice No') ?></th>
                <th scope="col"><?= __('Supplier Invoice Date') ?></th>
                <th scope="col"><?= __('Narration') ?></th>
                <th scope="col"><?= __('Total Credit Amount') ?></th>
                <th scope="col"><?= __('Total Debit Amount') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->purchase_vouchers as $purchaseVouchers): ?>
            <tr>
                <td><?= h($purchaseVouchers->id) ?></td>
                <td><?= h($purchaseVouchers->voucher_no) ?></td>
                <td><?= h($purchaseVouchers->location_id) ?></td>
                <td><?= h($purchaseVouchers->transaction_date) ?></td>
                <td><?= h($purchaseVouchers->supplier_invoice_no) ?></td>
                <td><?= h($purchaseVouchers->supplier_invoice_date) ?></td>
                <td><?= h($purchaseVouchers->narration) ?></td>
                <td><?= h($purchaseVouchers->total_credit_amount) ?></td>
                <td><?= h($purchaseVouchers->total_debit_amount) ?></td>
                <td><?= h($purchaseVouchers->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PurchaseVouchers', 'action' => 'view', $purchaseVouchers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PurchaseVouchers', 'action' => 'edit', $purchaseVouchers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PurchaseVouchers', 'action' => 'delete', $purchaseVouchers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseVouchers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Receipts') ?></h4>
        <?php if (!empty($location->receipts)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Narration') ?></th>
                <th scope="col"><?= __('Voucher Amount') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Sales Invoice Id') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->receipts as $receipts): ?>
            <tr>
                <td><?= h($receipts->id) ?></td>
                <td><?= h($receipts->voucher_no) ?></td>
                <td><?= h($receipts->location_id) ?></td>
                <td><?= h($receipts->transaction_date) ?></td>
                <td><?= h($receipts->narration) ?></td>
                <td><?= h($receipts->voucher_amount) ?></td>
                <td><?= h($receipts->amount) ?></td>
                <td><?= h($receipts->sales_invoice_id) ?></td>
                <td><?= h($receipts->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Receipts', 'action' => 'view', $receipts->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Receipts', 'action' => 'edit', $receipts->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Receipts', 'action' => 'delete', $receipts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receipts->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Reference Details') ?></h4>
        <?php if (!empty($location->reference_details)): ?>
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
            <?php foreach ($location->reference_details as $referenceDetails): ?>
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
        <h4><?= __('Related Sale Returns') ?></h4>
        <?php if (!empty($location->sale_returns)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Amount Before Tax') ?></th>
                <th scope="col"><?= __('Total Cgst') ?></th>
                <th scope="col"><?= __('Total Sgst') ?></th>
                <th scope="col"><?= __('Total Igst') ?></th>
                <th scope="col"><?= __('Amount After Tax') ?></th>
                <th scope="col"><?= __('Round Off') ?></th>
                <th scope="col"><?= __('Sales Ledger Id') ?></th>
                <th scope="col"><?= __('Party Ledger Id') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Sales Invoice Id') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->sale_returns as $saleReturns): ?>
            <tr>
                <td><?= h($saleReturns->id) ?></td>
                <td><?= h($saleReturns->voucher_no) ?></td>
                <td><?= h($saleReturns->transaction_date) ?></td>
                <td><?= h($saleReturns->customer_id) ?></td>
                <td><?= h($saleReturns->amount_before_tax) ?></td>
                <td><?= h($saleReturns->total_cgst) ?></td>
                <td><?= h($saleReturns->total_sgst) ?></td>
                <td><?= h($saleReturns->total_igst) ?></td>
                <td><?= h($saleReturns->amount_after_tax) ?></td>
                <td><?= h($saleReturns->round_off) ?></td>
                <td><?= h($saleReturns->sales_ledger_id) ?></td>
                <td><?= h($saleReturns->party_ledger_id) ?></td>
                <td><?= h($saleReturns->location_id) ?></td>
                <td><?= h($saleReturns->sales_invoice_id) ?></td>
                <td><?= h($saleReturns->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SaleReturns', 'action' => 'view', $saleReturns->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SaleReturns', 'action' => 'edit', $saleReturns->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SaleReturns', 'action' => 'delete', $saleReturns->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleReturns->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sales Invoices') ?></h4>
        <?php if (!empty($location->sales_invoices)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Amount Before Tax') ?></th>
                <th scope="col"><?= __('Total Cgst') ?></th>
                <th scope="col"><?= __('Total Sgst') ?></th>
                <th scope="col"><?= __('Total Igst') ?></th>
                <th scope="col"><?= __('Amount After Tax') ?></th>
                <th scope="col"><?= __('Round Off') ?></th>
                <th scope="col"><?= __('Sales Ledger Id') ?></th>
                <th scope="col"><?= __('Party Ledger Id') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Invoice Receipt Type') ?></th>
                <th scope="col"><?= __('Receipt Amount') ?></th>
                <th scope="col"><?= __('Discount Amount') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->sales_invoices as $salesInvoices): ?>
            <tr>
                <td><?= h($salesInvoices->id) ?></td>
                <td><?= h($salesInvoices->voucher_no) ?></td>
                <td><?= h($salesInvoices->transaction_date) ?></td>
                <td><?= h($salesInvoices->customer_id) ?></td>
                <td><?= h($salesInvoices->amount_before_tax) ?></td>
                <td><?= h($salesInvoices->total_cgst) ?></td>
                <td><?= h($salesInvoices->total_sgst) ?></td>
                <td><?= h($salesInvoices->total_igst) ?></td>
                <td><?= h($salesInvoices->amount_after_tax) ?></td>
                <td><?= h($salesInvoices->round_off) ?></td>
                <td><?= h($salesInvoices->sales_ledger_id) ?></td>
                <td><?= h($salesInvoices->party_ledger_id) ?></td>
                <td><?= h($salesInvoices->location_id) ?></td>
                <td><?= h($salesInvoices->invoice_receipt_type) ?></td>
                <td><?= h($salesInvoices->receipt_amount) ?></td>
                <td><?= h($salesInvoices->discount_amount) ?></td>
                <td><?= h($salesInvoices->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SalesInvoices', 'action' => 'view', $salesInvoices->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SalesInvoices', 'action' => 'edit', $salesInvoices->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SalesInvoices', 'action' => 'delete', $salesInvoices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesInvoices->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sales Vouchers') ?></h4>
        <?php if (!empty($location->sales_vouchers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Reference No') ?></th>
                <th scope="col"><?= __('Narration') ?></th>
                <th scope="col"><?= __('TotalMainDr') ?></th>
                <th scope="col"><?= __('TotalMainCr') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->sales_vouchers as $salesVouchers): ?>
            <tr>
                <td><?= h($salesVouchers->id) ?></td>
                <td><?= h($salesVouchers->voucher_no) ?></td>
                <td><?= h($salesVouchers->location_id) ?></td>
                <td><?= h($salesVouchers->transaction_date) ?></td>
                <td><?= h($salesVouchers->reference_no) ?></td>
                <td><?= h($salesVouchers->narration) ?></td>
                <td><?= h($salesVouchers->totalMainDr) ?></td>
                <td><?= h($salesVouchers->totalMainCr) ?></td>
                <td><?= h($salesVouchers->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SalesVouchers', 'action' => 'view', $salesVouchers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SalesVouchers', 'action' => 'edit', $salesVouchers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SalesVouchers', 'action' => 'delete', $salesVouchers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesVouchers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Suppliers') ?></h4>
        <?php if (!empty($location->suppliers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Address') ?></th>
                <th scope="col"><?= __('Mobile No') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Edited On') ?></th>
                <th scope="col"><?= __('Edited By') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->suppliers as $suppliers): ?>
            <tr>
                <td><?= h($suppliers->id) ?></td>
                <td><?= h($suppliers->location_id) ?></td>
                <td><?= h($suppliers->name) ?></td>
                <td><?= h($suppliers->address) ?></td>
                <td><?= h($suppliers->mobile_no) ?></td>
                <td><?= h($suppliers->email) ?></td>
                <td><?= h($suppliers->created_on) ?></td>
                <td><?= h($suppliers->created_by) ?></td>
                <td><?= h($suppliers->edited_on) ?></td>
                <td><?= h($suppliers->edited_by) ?></td>
                <td><?= h($suppliers->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Suppliers', 'action' => 'view', $suppliers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Suppliers', 'action' => 'edit', $suppliers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Suppliers', 'action' => 'delete', $suppliers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $suppliers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
