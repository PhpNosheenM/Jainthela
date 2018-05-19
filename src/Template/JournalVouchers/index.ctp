<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\JournalVoucher[]|\Cake\Collection\CollectionInterface $journalVouchers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Journal Voucher'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Journal Voucher Rows'), ['controller' => 'JournalVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Journal Voucher Row'), ['controller' => 'JournalVoucherRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="journalVouchers index large-9 medium-8 columns content">
    <h3><?= __('Journal Vouchers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reference_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_credit_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_debit_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($journalVouchers as $journalVoucher): ?>
            <tr>
                <td><?= $this->Number->format($journalVoucher->id) ?></td>
                <td><?= $this->Number->format($journalVoucher->voucher_no) ?></td>
                <td><?= $this->Number->format($journalVoucher->reference_no) ?></td>
                <td><?= $journalVoucher->has('location') ? $this->Html->link($journalVoucher->location->name, ['controller' => 'Locations', 'action' => 'view', $journalVoucher->location->id]) : '' ?></td>
                <td><?= $journalVoucher->has('city') ? $this->Html->link($journalVoucher->city->name, ['controller' => 'Cities', 'action' => 'view', $journalVoucher->city->id]) : '' ?></td>
                <td><?= h($journalVoucher->transaction_date) ?></td>
                <td><?= $this->Number->format($journalVoucher->total_credit_amount) ?></td>
                <td><?= $this->Number->format($journalVoucher->total_debit_amount) ?></td>
                <td><?= h($journalVoucher->status) ?></td>
                <td><?= $this->Number->format($journalVoucher->created_by) ?></td>
                <td><?= h($journalVoucher->created_on) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $journalVoucher->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $journalVoucher->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $journalVoucher->id], ['confirm' => __('Are you sure you want to delete # {0}?', $journalVoucher->id)]) ?>
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
