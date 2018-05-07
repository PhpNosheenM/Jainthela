<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notify $notify
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Notifies'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="notifies form large-9 medium-8 columns content">
    <?= $this->Form->create($notify) ?>
    <fieldset>
        <legend><?= __('Add Notify') ?></legend>
        <?php
            echo $this->Form->control('customer_id', ['options' => $customers]);
            echo $this->Form->control('item_variation_id', ['options' => $itemVariations]);
            echo $this->Form->control('send_flag');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
