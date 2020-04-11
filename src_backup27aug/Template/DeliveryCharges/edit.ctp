<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DeliveryCharge $deliveryCharge
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $deliveryCharge->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $deliveryCharge->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Delivery Charges'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="deliveryCharges form large-9 medium-8 columns content">
    <?= $this->Form->create($deliveryCharge) ?>
    <fieldset>
        <legend><?= __('Edit Delivery Charge') ?></legend>
        <?php
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('amount');
            echo $this->Form->control('charge');
            echo $this->Form->control('status');
            echo $this->Form->control('created_on');
            echo $this->Form->control('created_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
