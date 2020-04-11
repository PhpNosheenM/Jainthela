<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WalletWithdrawRequest $walletWithdrawRequest
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Wallet Withdraw Request'), ['action' => 'edit', $walletWithdrawRequest->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Wallet Withdraw Request'), ['action' => 'delete', $walletWithdrawRequest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $walletWithdrawRequest->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Wallet Withdraw Requests'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wallet Withdraw Request'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="walletWithdrawRequests view large-9 medium-8 columns content">
    <h3><?= h($walletWithdrawRequest->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $walletWithdrawRequest->has('city') ? $this->Html->link($walletWithdrawRequest->city->name, ['controller' => 'Cities', 'action' => 'view', $walletWithdrawRequest->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $walletWithdrawRequest->has('customer') ? $this->Html->link($walletWithdrawRequest->customer->name, ['controller' => 'Customers', 'action' => 'view', $walletWithdrawRequest->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($walletWithdrawRequest->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($walletWithdrawRequest->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($walletWithdrawRequest->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Request Date') ?></th>
            <td><?= h($walletWithdrawRequest->request_date) ?></td>
        </tr>
    </table>
</div>
