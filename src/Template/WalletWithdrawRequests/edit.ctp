<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WalletWithdrawRequest $walletWithdrawRequest
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $walletWithdrawRequest->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $walletWithdrawRequest->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Wallet Withdraw Requests'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="walletWithdrawRequests form large-9 medium-8 columns content">
    <?= $this->Form->create($walletWithdrawRequest) ?>
    <fieldset>
        <legend><?= __('Edit Wallet Withdraw Request') ?></legend>
        <?php
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('customer_id', ['options' => $customers]);
            echo $this->Form->control('amount');
            echo $this->Form->control('request_date');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
