<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderPaymentHistory[]|\Cake\Collection\CollectionInterface $orderPaymentHistories
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Order Payment History'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="orderPaymentHistories index large-9 medium-8 columns content">
    <h3><?= __('Order Payment Histories') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('online_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cod_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('wallet_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('wallet_return') ?></th>
                <th scope="col"><?= $this->Paginator->sort('entry_from') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderPaymentHistories as $orderPaymentHistory): ?>
            <tr>
                <td><?= $this->Number->format($orderPaymentHistory->id) ?></td>
                <td><?= $orderPaymentHistory->has('order') ? $this->Html->link($orderPaymentHistory->order->id, ['controller' => 'Orders', 'action' => 'view', $orderPaymentHistory->order->id]) : '' ?></td>
                <td><?= $orderPaymentHistory->has('invoice') ? $this->Html->link($orderPaymentHistory->invoice->id, ['controller' => 'Invoices', 'action' => 'view', $orderPaymentHistory->invoice->id]) : '' ?></td>
                <td><?= $this->Number->format($orderPaymentHistory->online_amount) ?></td>
                <td><?= $this->Number->format($orderPaymentHistory->cod_amount) ?></td>
                <td><?= $this->Number->format($orderPaymentHistory->wallet_amount) ?></td>
                <td><?= $this->Number->format($orderPaymentHistory->total) ?></td>
                <td><?= $this->Number->format($orderPaymentHistory->wallet_return) ?></td>
                <td><?= h($orderPaymentHistory->entry_from) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $orderPaymentHistory->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $orderPaymentHistory->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $orderPaymentHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderPaymentHistory->id)]) ?>
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
