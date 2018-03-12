<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HomeScreen[]|\Cake\Collection\CollectionInterface $homeScreens
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Home Screen'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="homeScreens index large-9 medium-8 columns content">
    <h3><?= __('Home Screens') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('layout') ?></th>
                <th scope="col"><?= $this->Paginator->sort('section_show') ?></th>
                <th scope="col"><?= $this->Paginator->sort('preference') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('screen_type') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($homeScreens as $homeScreen): ?>
            <tr>
                <td><?= $this->Number->format($homeScreen->id) ?></td>
                <td><?= h($homeScreen->title) ?></td>
                <td><?= h($homeScreen->layout) ?></td>
                <td><?= h($homeScreen->section_show) ?></td>
                <td><?= $this->Number->format($homeScreen->preference) ?></td>
                <td><?= $homeScreen->has('category') ? $this->Html->link($homeScreen->category->name, ['controller' => 'Categories', 'action' => 'view', $homeScreen->category->id]) : '' ?></td>
                <td><?= h($homeScreen->screen_type) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $homeScreen->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $homeScreen->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $homeScreen->id], ['confirm' => __('Are you sure you want to delete # {0}?', $homeScreen->id)]) ?>
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
