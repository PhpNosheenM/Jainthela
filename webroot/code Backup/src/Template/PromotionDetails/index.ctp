<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PromotionDetail[]|\Cake\Collection\CollectionInterface $promotionDetails
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Promotion Detail'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Promotions'), ['controller' => 'Promotions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Promotion'), ['controller' => 'Promotions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="promotionDetails index large-9 medium-8 columns content">
    <h3><?= __('Promotion Details') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('promotion_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_in_percentage') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_in_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_of_max_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('coupan_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('coupan_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('buy_quntity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('get_quntity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('get_item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('in_wallet') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_free_shipping') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($promotionDetails as $promotionDetail): ?>
            <tr>
                <td><?= $this->Number->format($promotionDetail->id) ?></td>
                <td><?= $promotionDetail->has('promotion') ? $this->Html->link($promotionDetail->promotion->id, ['controller' => 'Promotions', 'action' => 'view', $promotionDetail->promotion->id]) : '' ?></td>
                <td><?= $promotionDetail->has('category') ? $this->Html->link($promotionDetail->category->name, ['controller' => 'Categories', 'action' => 'view', $promotionDetail->category->id]) : '' ?></td>
                <td><?= $promotionDetail->has('item') ? $this->Html->link($promotionDetail->item->name, ['controller' => 'Items', 'action' => 'view', $promotionDetail->item->id]) : '' ?></td>
                <td><?= $this->Number->format($promotionDetail->discount_in_percentage) ?></td>
                <td><?= $this->Number->format($promotionDetail->discount_in_amount) ?></td>
                <td><?= $this->Number->format($promotionDetail->discount_of_max_amount) ?></td>
                <td><?= h($promotionDetail->coupan_name) ?></td>
                <td><?= $this->Number->format($promotionDetail->coupan_code) ?></td>
                <td><?= $this->Number->format($promotionDetail->buy_quntity) ?></td>
                <td><?= $this->Number->format($promotionDetail->get_quntity) ?></td>
                <td><?= $this->Number->format($promotionDetail->get_item_id) ?></td>
                <td><?= h($promotionDetail->in_wallet) ?></td>
                <td><?= h($promotionDetail->is_free_shipping) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $promotionDetail->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $promotionDetail->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $promotionDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $promotionDetail->id)]) ?>
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
