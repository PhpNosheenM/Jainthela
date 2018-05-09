<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccountingGroup $accountingGroup
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Accounting Group'), ['action' => 'edit', $accountingGroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Accounting Group'), ['action' => 'delete', $accountingGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountingGroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Accounting Groups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting Group'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Nature Of Groups'), ['controller' => 'NatureOfGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Nature Of Group'), ['controller' => 'NatureOfGroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Accounting Groups'), ['controller' => 'AccountingGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Accounting Group'), ['controller' => 'AccountingGroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Child Accounting Groups'), ['controller' => 'AccountingGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Accounting Group'), ['controller' => 'AccountingGroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="accountingGroups view large-9 medium-8 columns content">
    <h3><?= h($accountingGroup->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nature Of Group') ?></th>
            <td><?= $accountingGroup->has('nature_of_group') ? $this->Html->link($accountingGroup->nature_of_group->name, ['controller' => 'NatureOfGroups', 'action' => 'view', $accountingGroup->nature_of_group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($accountingGroup->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent Accounting Group') ?></th>
            <td><?= $accountingGroup->has('parent_accounting_group') ? $this->Html->link($accountingGroup->parent_accounting_group->name, ['controller' => 'AccountingGroups', 'action' => 'view', $accountingGroup->parent_accounting_group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $accountingGroup->has('location') ? $this->Html->link($accountingGroup->location->name, ['controller' => 'Locations', 'action' => 'view', $accountingGroup->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($accountingGroup->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lft') ?></th>
            <td><?= $this->Number->format($accountingGroup->lft) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rght') ?></th>
            <td><?= $this->Number->format($accountingGroup->rght) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sale Invoice Party') ?></th>
            <td><?= $this->Number->format($accountingGroup->sale_invoice_party) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sale Invoice Sales Account') ?></th>
            <td><?= $this->Number->format($accountingGroup->sale_invoice_sales_account) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit Note Party') ?></th>
            <td><?= $this->Number->format($accountingGroup->credit_note_party) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit Note Sales Account') ?></th>
            <td><?= $this->Number->format($accountingGroup->credit_note_sales_account) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bank') ?></th>
            <td><?= $this->Number->format($accountingGroup->bank) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $accountingGroup->customer ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Supplier') ?></th>
            <td><?= $accountingGroup->supplier ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Voucher First Ledger') ?></th>
            <td><?= $accountingGroup->purchase_voucher_first_ledger ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Voucher Purchase Ledger') ?></th>
            <td><?= $accountingGroup->purchase_voucher_purchase_ledger ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Voucher All Ledger') ?></th>
            <td><?= $accountingGroup->purchase_voucher_all_ledger ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cash') ?></th>
            <td><?= $accountingGroup->cash ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Invoice Purchase Account') ?></th>
            <td><?= $accountingGroup->purchase_invoice_purchase_account ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Invoice Party') ?></th>
            <td><?= $accountingGroup->purchase_invoice_party ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Receipt Ledger') ?></th>
            <td><?= $accountingGroup->receipt_ledger ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Ledger') ?></th>
            <td><?= $accountingGroup->payment_ledger ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit Note First Row') ?></th>
            <td><?= $accountingGroup->credit_note_first_row ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit Note All Row') ?></th>
            <td><?= $accountingGroup->credit_note_all_row ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debit Note First Row') ?></th>
            <td><?= $accountingGroup->debit_note_first_row ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debit Note All Row') ?></th>
            <td><?= $accountingGroup->debit_note_all_row ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Voucher First Ledger') ?></th>
            <td><?= $accountingGroup->sales_voucher_first_ledger ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Voucher Sales Ledger') ?></th>
            <td><?= $accountingGroup->sales_voucher_sales_ledger ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Voucher All Ledger') ?></th>
            <td><?= $accountingGroup->sales_voucher_all_ledger ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Journal Voucher Ledger') ?></th>
            <td><?= $accountingGroup->journal_voucher_ledger ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Contra Voucher Ledger') ?></th>
            <td><?= $accountingGroup->contra_voucher_ledger ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Accounting Groups') ?></h4>
        <?php if (!empty($accountingGroup->child_accounting_groups)): ?>
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
            <?php foreach ($accountingGroup->child_accounting_groups as $childAccountingGroups): ?>
            <tr>
                <td><?= h($childAccountingGroups->id) ?></td>
                <td><?= h($childAccountingGroups->nature_of_group_id) ?></td>
                <td><?= h($childAccountingGroups->name) ?></td>
                <td><?= h($childAccountingGroups->parent_id) ?></td>
                <td><?= h($childAccountingGroups->lft) ?></td>
                <td><?= h($childAccountingGroups->rght) ?></td>
                <td><?= h($childAccountingGroups->location_id) ?></td>
                <td><?= h($childAccountingGroups->customer) ?></td>
                <td><?= h($childAccountingGroups->supplier) ?></td>
                <td><?= h($childAccountingGroups->purchase_voucher_first_ledger) ?></td>
                <td><?= h($childAccountingGroups->purchase_voucher_purchase_ledger) ?></td>
                <td><?= h($childAccountingGroups->purchase_voucher_all_ledger) ?></td>
                <td><?= h($childAccountingGroups->sale_invoice_party) ?></td>
                <td><?= h($childAccountingGroups->sale_invoice_sales_account) ?></td>
                <td><?= h($childAccountingGroups->credit_note_party) ?></td>
                <td><?= h($childAccountingGroups->credit_note_sales_account) ?></td>
                <td><?= h($childAccountingGroups->bank) ?></td>
                <td><?= h($childAccountingGroups->cash) ?></td>
                <td><?= h($childAccountingGroups->purchase_invoice_purchase_account) ?></td>
                <td><?= h($childAccountingGroups->purchase_invoice_party) ?></td>
                <td><?= h($childAccountingGroups->receipt_ledger) ?></td>
                <td><?= h($childAccountingGroups->payment_ledger) ?></td>
                <td><?= h($childAccountingGroups->credit_note_first_row) ?></td>
                <td><?= h($childAccountingGroups->credit_note_all_row) ?></td>
                <td><?= h($childAccountingGroups->debit_note_first_row) ?></td>
                <td><?= h($childAccountingGroups->debit_note_all_row) ?></td>
                <td><?= h($childAccountingGroups->sales_voucher_first_ledger) ?></td>
                <td><?= h($childAccountingGroups->sales_voucher_sales_ledger) ?></td>
                <td><?= h($childAccountingGroups->sales_voucher_all_ledger) ?></td>
                <td><?= h($childAccountingGroups->journal_voucher_ledger) ?></td>
                <td><?= h($childAccountingGroups->contra_voucher_ledger) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AccountingGroups', 'action' => 'view', $childAccountingGroups->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AccountingGroups', 'action' => 'edit', $childAccountingGroups->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccountingGroups', 'action' => 'delete', $childAccountingGroups->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childAccountingGroups->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Ledgers') ?></h4>
        <?php if (!empty($accountingGroup->ledgers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Accounting Group Id') ?></th>
                <th scope="col"><?= __('Freeze') ?></th>
                <th scope="col"><?= __('Company Id') ?></th>
                <th scope="col"><?= __('Supplier Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Tax Percentage') ?></th>
                <th scope="col"><?= __('Gst Type') ?></th>
                <th scope="col"><?= __('Input Output') ?></th>
                <th scope="col"><?= __('Gst Figure Id') ?></th>
                <th scope="col"><?= __('Bill To Bill Accounting') ?></th>
                <th scope="col"><?= __('Round Off') ?></th>
                <th scope="col"><?= __('Cash') ?></th>
                <th scope="col"><?= __('Flag') ?></th>
                <th scope="col"><?= __('Default Credit Days') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($accountingGroup->ledgers as $ledgers): ?>
            <tr>
                <td><?= h($ledgers->id) ?></td>
                <td><?= h($ledgers->name) ?></td>
                <td><?= h($ledgers->accounting_group_id) ?></td>
                <td><?= h($ledgers->freeze) ?></td>
                <td><?= h($ledgers->company_id) ?></td>
                <td><?= h($ledgers->supplier_id) ?></td>
                <td><?= h($ledgers->customer_id) ?></td>
                <td><?= h($ledgers->tax_percentage) ?></td>
                <td><?= h($ledgers->gst_type) ?></td>
                <td><?= h($ledgers->input_output) ?></td>
                <td><?= h($ledgers->gst_figure_id) ?></td>
                <td><?= h($ledgers->bill_to_bill_accounting) ?></td>
                <td><?= h($ledgers->round_off) ?></td>
                <td><?= h($ledgers->cash) ?></td>
                <td><?= h($ledgers->flag) ?></td>
                <td><?= h($ledgers->default_credit_days) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Ledgers', 'action' => 'view', $ledgers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Ledgers', 'action' => 'edit', $ledgers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Ledgers', 'action' => 'delete', $ledgers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ledgers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
