<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderPaymentHistory $orderPaymentHistory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Order Payment History'), ['action' => 'edit', $orderPaymentHistory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Order Payment History'), ['action' => 'delete', $orderPaymentHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderPaymentHistory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Order Payment Histories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order Payment History'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="orderPaymentHistories view large-9 medium-8 columns content">
    <h3><?= h($orderPaymentHistory->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Order') ?></th>
            <td><?= $orderPaymentHistory->has('order') ? $this->Html->link($orderPaymentHistory->order->id, ['controller' => 'Orders', 'action' => 'view', $orderPaymentHistory->order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Invoice') ?></th>
            <td><?= $orderPaymentHistory->has('invoice') ? $this->Html->link($orderPaymentHistory->invoice->id, ['controller' => 'Invoices', 'action' => 'view', $orderPaymentHistory->invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Entry From') ?></th>
            <td><?= h($orderPaymentHistory->entry_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($orderPaymentHistory->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Online Amount') ?></th>
            <td><?= $this->Number->format($orderPaymentHistory->online_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cod Amount') ?></th>
            <td><?= $this->Number->format($orderPaymentHistory->cod_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Wallet Amount') ?></th>
            <td><?= $this->Number->format($orderPaymentHistory->wallet_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total') ?></th>
            <td><?= $this->Number->format($orderPaymentHistory->total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Wallet Return') ?></th>
            <td><?= $this->Number->format($orderPaymentHistory->wallet_return) ?></td>
        </tr>
    </table>
</div>
