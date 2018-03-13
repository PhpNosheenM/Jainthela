<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccountingGroup[]|\Cake\Collection\CollectionInterface $accountingGroups
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Accounting Group'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Nature Of Groups'), ['controller' => 'NatureOfGroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Nature Of Group'), ['controller' => 'NatureOfGroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="accountingGroups index large-9 medium-8 columns content">
    <h3><?= __('Accounting Groups') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nature_of_group_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer') ?></th>
                <th scope="col"><?= $this->Paginator->sort('supplier') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_voucher_first_ledger') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_voucher_purchase_ledger') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_voucher_all_ledger') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sale_invoice_party') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sale_invoice_sales_account') ?></th>
                <th scope="col"><?= $this->Paginator->sort('credit_note_party') ?></th>
                <th scope="col"><?= $this->Paginator->sort('credit_note_sales_account') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bank') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cash') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_invoice_purchase_account') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_invoice_party') ?></th>
                <th scope="col"><?= $this->Paginator->sort('receipt_ledger') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment_ledger') ?></th>
                <th scope="col"><?= $this->Paginator->sort('credit_note_first_row') ?></th>
                <th scope="col"><?= $this->Paginator->sort('credit_note_all_row') ?></th>
                <th scope="col"><?= $this->Paginator->sort('debit_note_first_row') ?></th>
                <th scope="col"><?= $this->Paginator->sort('debit_note_all_row') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_voucher_first_ledger') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_voucher_sales_ledger') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_voucher_all_ledger') ?></th>
                <th scope="col"><?= $this->Paginator->sort('journal_voucher_ledger') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contra_voucher_ledger') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($accountingGroups as $accountingGroup): ?>
            <tr>
                <td><?= $this->Number->format($accountingGroup->id) ?></td>
                <td><?= $accountingGroup->has('nature_of_group') ? $this->Html->link($accountingGroup->nature_of_group->name, ['controller' => 'NatureOfGroups', 'action' => 'view', $accountingGroup->nature_of_group->id]) : '' ?></td>
                <td><?= h($accountingGroup->name) ?></td>
                <td><?= $accountingGroup->has('parent_accounting_group') ? $this->Html->link($accountingGroup->parent_accounting_group->name, ['controller' => 'AccountingGroups', 'action' => 'view', $accountingGroup->parent_accounting_group->id]) : '' ?></td>
                <td><?= $accountingGroup->has('location') ? $this->Html->link($accountingGroup->location->name, ['controller' => 'Locations', 'action' => 'view', $accountingGroup->location->id]) : '' ?></td>
                <td><?= h($accountingGroup->customer) ?></td>
                <td><?= h($accountingGroup->supplier) ?></td>
                <td><?= h($accountingGroup->purchase_voucher_first_ledger) ?></td>
                <td><?= h($accountingGroup->purchase_voucher_purchase_ledger) ?></td>
                <td><?= h($accountingGroup->purchase_voucher_all_ledger) ?></td>
                <td><?= $this->Number->format($accountingGroup->sale_invoice_party) ?></td>
                <td><?= $this->Number->format($accountingGroup->sale_invoice_sales_account) ?></td>
                <td><?= $this->Number->format($accountingGroup->credit_note_party) ?></td>
                <td><?= $this->Number->format($accountingGroup->credit_note_sales_account) ?></td>
                <td><?= $this->Number->format($accountingGroup->bank) ?></td>
                <td><?= h($accountingGroup->cash) ?></td>
                <td><?= h($accountingGroup->purchase_invoice_purchase_account) ?></td>
                <td><?= h($accountingGroup->purchase_invoice_party) ?></td>
                <td><?= h($accountingGroup->receipt_ledger) ?></td>
                <td><?= h($accountingGroup->payment_ledger) ?></td>
                <td><?= h($accountingGroup->credit_note_first_row) ?></td>
                <td><?= h($accountingGroup->credit_note_all_row) ?></td>
                <td><?= h($accountingGroup->debit_note_first_row) ?></td>
                <td><?= h($accountingGroup->debit_note_all_row) ?></td>
                <td><?= h($accountingGroup->sales_voucher_first_ledger) ?></td>
                <td><?= h($accountingGroup->sales_voucher_sales_ledger) ?></td>
                <td><?= h($accountingGroup->sales_voucher_all_ledger) ?></td>
                <td><?= h($accountingGroup->journal_voucher_ledger) ?></td>
                <td><?= h($accountingGroup->contra_voucher_ledger) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $accountingGroup->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $accountingGroup->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $accountingGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountingGroup->id)]) ?>
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
