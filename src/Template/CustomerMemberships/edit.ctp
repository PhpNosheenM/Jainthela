<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerMembership $customerMembership
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $customerMembership->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $customerMembership->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Customer Memberships'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Plans'), ['controller' => 'Plans', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Plan'), ['controller' => 'Plans', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="customerMemberships form large-9 medium-8 columns content">
    <?= $this->Form->create($customerMembership) ?>
    <fieldset>
        <legend><?= __('Edit Customer Membership') ?></legend>
        <?php
            echo $this->Form->control('customer_id', ['options' => $customers]);
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('plan_id', ['options' => $plans]);
            echo $this->Form->control('amount');
            echo $this->Form->control('discount_percentage');
            echo $this->Form->control('start_date');
            echo $this->Form->control('end_date');
            echo $this->Form->control('created_on');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
