<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payments
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Payment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payment Rows'), ['controller' => 'PaymentRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payment Row'), ['controller' => 'PaymentRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="payments index large-9 medium-8 columns content">
    <h3><?= __('Payments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $payment): ?>
            <tr>
                <td><?= $this->Number->format($payment->id) ?></td>
                <td><?= $this->Number->format($payment->voucher_no) ?></td>
                <td><?= $payment->has('location') ? $this->Html->link($payment->location->name, ['controller' => 'Locations', 'action' => 'view', $payment->location->id]) : '' ?></td>
                <td><?= h($payment->transaction_date) ?></td>
                <td><?= h($payment->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $payment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $payment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $payment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payment->id)]) ?>
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
