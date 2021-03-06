<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DeliveryTime $deliveryTime
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $deliveryTime->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $deliveryTime->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Delivery Times'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="deliveryTimes form large-9 medium-8 columns content">
    <?= $this->Form->create($deliveryTime) ?>
    <fieldset>
        <legend><?= __('Edit Delivery Time') ?></legend>
        <?php
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('time_from');
            echo $this->Form->control('time_to');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
