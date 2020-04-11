<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WishList $wishList
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Wish List'), ['action' => 'edit', $wishList->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Wish List'), ['action' => 'delete', $wishList->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wishList->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Wish Lists'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wish List'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wish List Items'), ['controller' => 'WishListItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wish List Item'), ['controller' => 'WishListItems', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="wishLists view large-9 medium-8 columns content">
    <h3><?= h($wishList->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $wishList->has('customer') ? $this->Html->link($wishList->customer->name, ['controller' => 'Customers', 'action' => 'view', $wishList->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($wishList->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($wishList->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($wishList->created_on) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Wish List Items') ?></h4>
        <?php if (!empty($wishList->wish_list_items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Wish List Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($wishList->wish_list_items as $wishListItems): ?>
            <tr>
                <td><?= h($wishListItems->id) ?></td>
                <td><?= h($wishListItems->wish_list_id) ?></td>
                <td><?= h($wishListItems->item_id) ?></td>
                <td><?= h($wishListItems->item_variation_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'WishListItems', 'action' => 'view', $wishListItems->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'WishListItems', 'action' => 'edit', $wishListItems->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'WishListItems', 'action' => 'delete', $wishListItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wishListItems->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
