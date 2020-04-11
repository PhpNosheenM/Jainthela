<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WishList[]|\Cake\Collection\CollectionInterface $wishLists
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Wish List'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Wish List Items'), ['controller' => 'WishListItems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wish List Item'), ['controller' => 'WishListItems', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="wishLists index large-9 medium-8 columns content">
    <h3><?= __('Wish Lists') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wishLists as $wishList): ?>
            <tr>
                <td><?= $this->Number->format($wishList->id) ?></td>
                <td><?= $wishList->has('customer') ? $this->Html->link($wishList->customer->name, ['controller' => 'Customers', 'action' => 'view', $wishList->customer->id]) : '' ?></td>
                <td><?= h($wishList->created_on) ?></td>
                <td><?= $this->Number->format($wishList->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $wishList->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $wishList->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $wishList->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wishList->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
