<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExpesssDelivery[]|\Cake\Collection\CollectionInterface $expesssDeliveries
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Expesss Delivery'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="expesssDeliveries index large-9 medium-8 columns content">
    <h3><?= __('Expesss Deliveries') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('icon') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expesssDeliveries as $expesssDelivery): ?>
            <tr>
                <td><?= $this->Number->format($expesssDelivery->id) ?></td>
                <td><?= h($expesssDelivery->title) ?></td>
                <td><?= h($expesssDelivery->icon) ?></td>
                <td><?= h($expesssDelivery->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $expesssDelivery->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $expesssDelivery->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $expesssDelivery->id], ['confirm' => __('Are you sure you want to delete # {0}?', $expesssDelivery->id)]) ?>
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
