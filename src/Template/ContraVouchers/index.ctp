<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContraVoucher[]|\Cake\Collection\CollectionInterface $contraVouchers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Contra Voucher'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contraVouchers index large-9 medium-8 columns content">
    <h3><?= __('Contra Vouchers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contraVouchers as $contraVoucher): ?>
            <tr>
                <td><?= $this->Number->format($contraVoucher->id) ?></td>
                <td><?= $this->Number->format($contraVoucher->voucher_no) ?></td>
                <td><?= $contraVoucher->has('location') ? $this->Html->link($contraVoucher->location->name, ['controller' => 'Locations', 'action' => 'view', $contraVoucher->location->id]) : '' ?></td>
                <td><?= h($contraVoucher->transaction_date) ?></td>
                <td><?= $this->Number->format($contraVoucher->created_by) ?></td>
                <td><?= h($contraVoucher->created_on) ?></td>
                <td><?= h($contraVoucher->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $contraVoucher->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contraVoucher->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contraVoucher->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contraVoucher->id)]) ?>
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
