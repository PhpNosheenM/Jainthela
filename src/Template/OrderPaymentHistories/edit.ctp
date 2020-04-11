<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderPaymentHistory $orderPaymentHistory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $orderPaymentHistory->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $orderPaymentHistory->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Order Payment Histories'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="orderPaymentHistories form large-9 medium-8 columns content">
    <?= $this->Form->create($orderPaymentHistory) ?>
    <fieldset>
        <legend><?= __('Edit Order Payment History') ?></legend>
        <?php
            echo $this->Form->control('order_id', ['options' => $orders]);
            echo $this->Form->control('invoice_id', ['options' => $invoices, 'empty' => true]);
            echo $this->Form->control('online_amount');
            echo $this->Form->control('cod_amount');
            echo $this->Form->control('wallet_amount');
            echo $this->Form->control('total');
            echo $this->Form->control('wallet_return');
            echo $this->Form->control('entry_from');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
