<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TermCondition[]|\Cake\Collection\CollectionInterface $termConditions
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Term Condition'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="termConditions index large-9 medium-8 columns content">
    <h3><?= __('Term Conditions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('term_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($termConditions as $termCondition): ?>
            <tr>
                <td><?= $this->Number->format($termCondition->id) ?></td>
                <td><?= h($termCondition->term_name) ?></td>
                <td><?= $this->Number->format($termCondition->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $termCondition->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $termCondition->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $termCondition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $termCondition->id)]) ?>
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
