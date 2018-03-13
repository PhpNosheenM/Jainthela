<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ledger[]|\Cake\Collection\CollectionInterface $ledgers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ledger'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting Groups'), ['controller' => 'AccountingGroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accounting Group'), ['controller' => 'AccountingGroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Gst Figures'), ['controller' => 'GstFigures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Gst Figure'), ['controller' => 'GstFigures', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Credit Note Rows'), ['controller' => 'CreditNoteRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Credit Note Row'), ['controller' => 'CreditNoteRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Debit Note Rows'), ['controller' => 'DebitNoteRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Debit Note Row'), ['controller' => 'DebitNoteRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Journal Voucher Rows'), ['controller' => 'JournalVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Journal Voucher Row'), ['controller' => 'JournalVoucherRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payment Rows'), ['controller' => 'PaymentRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payment Row'), ['controller' => 'PaymentRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Voucher Rows'), ['controller' => 'PurchaseVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Voucher Row'), ['controller' => 'PurchaseVoucherRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Receipt Rows'), ['controller' => 'ReceiptRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Receipt Row'), ['controller' => 'ReceiptRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reference Details'), ['controller' => 'ReferenceDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['controller' => 'ReferenceDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales Voucher Rows'), ['controller' => 'SalesVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sales Voucher Row'), ['controller' => 'SalesVoucherRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ledgers index large-9 medium-8 columns content">
    <h3><?= __('Ledgers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('accounting_group_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('freeze') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('supplier_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tax_percentage') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('input_output') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_figure_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bill_to_bill_accounting') ?></th>
                <th scope="col"><?= $this->Paginator->sort('round_off') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cash') ?></th>
                <th scope="col"><?= $this->Paginator->sort('flag') ?></th>
                <th scope="col"><?= $this->Paginator->sort('default_credit_days') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ledgers as $ledger): ?>
            <tr>
                <td><?= $this->Number->format($ledger->id) ?></td>
                <td><?= h($ledger->name) ?></td>
                <td><?= $ledger->has('accounting_group') ? $this->Html->link($ledger->accounting_group->name, ['controller' => 'AccountingGroups', 'action' => 'view', $ledger->accounting_group->id]) : '' ?></td>
                <td><?= h($ledger->freeze) ?></td>
                <td><?= $ledger->has('location') ? $this->Html->link($ledger->location->name, ['controller' => 'Locations', 'action' => 'view', $ledger->location->id]) : '' ?></td>
                <td><?= $ledger->has('supplier') ? $this->Html->link($ledger->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $ledger->supplier->id]) : '' ?></td>
                <td><?= $ledger->has('customer') ? $this->Html->link($ledger->customer->name, ['controller' => 'Customers', 'action' => 'view', $ledger->customer->id]) : '' ?></td>
                <td><?= $this->Number->format($ledger->tax_percentage) ?></td>
                <td><?= h($ledger->gst_type) ?></td>
                <td><?= h($ledger->input_output) ?></td>
                <td><?= $ledger->has('gst_figure') ? $this->Html->link($ledger->gst_figure->name, ['controller' => 'GstFigures', 'action' => 'view', $ledger->gst_figure->id]) : '' ?></td>
                <td><?= h($ledger->bill_to_bill_accounting) ?></td>
                <td><?= $this->Number->format($ledger->round_off) ?></td>
                <td><?= $this->Number->format($ledger->cash) ?></td>
                <td><?= $this->Number->format($ledger->flag) ?></td>
                <td><?= $this->Number->format($ledger->default_credit_days) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ledger->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ledger->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ledger->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ledger->id)]) ?>
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
