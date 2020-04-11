<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WishList $wishList
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $wishList->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $wishList->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Wish Lists'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Wish List Items'), ['controller' => 'WishListItems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wish List Item'), ['controller' => 'WishListItems', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="wishLists form large-9 medium-8 columns content">
    <?= $this->Form->create($wishList) ?>
    <fieldset>
        <legend><?= __('Edit Wish List') ?></legend>
        <?php
            echo $this->Form->control('customer_id', ['options' => $customers]);
            echo $this->Form->control('created_on');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
