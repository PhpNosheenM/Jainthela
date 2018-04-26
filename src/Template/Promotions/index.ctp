<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Promotion[]|\Cake\Collection\CollectionInterface $promotions
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Promotion'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Admins'), ['controller' => 'Admins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Admin'), ['controller' => 'Admins', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Promotion Details'), ['controller' => 'PromotionDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Promotion Detail'), ['controller' => 'PromotionDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Wallets'), ['controller' => 'Wallets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wallet'), ['controller' => 'Wallets', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="promotions index large-9 medium-8 columns content">
    <h3><?= __('Promotions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('admin_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('offer_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($promotions as $promotion): ?>
            <tr>
                <td><?= $this->Number->format($promotion->id) ?></td>
                <td><?= $promotion->has('admin') ? $this->Html->link($promotion->admin->name, ['controller' => 'Admins', 'action' => 'view', $promotion->admin->id]) : '' ?></td>
                <td><?= $promotion->has('city') ? $this->Html->link($promotion->city->name, ['controller' => 'Cities', 'action' => 'view', $promotion->city->id]) : '' ?></td>
                <td><?= h($promotion->offer_name) ?></td>
                <td><?= h($promotion->start_date) ?></td>
                <td><?= h($promotion->end_date) ?></td>
                <td><?= h($promotion->created_on) ?></td>
                <td><?= h($promotion->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $promotion->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $promotion->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $promotion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $promotion->id)]) ?>
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
