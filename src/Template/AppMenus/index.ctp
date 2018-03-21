<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppMenu[]|\Cake\Collection\CollectionInterface $appMenus
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New App Menu'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="appMenus index large-9 medium-8 columns content">
    <h3><?= __('App Menus') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('link') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lft') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rght') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appMenus as $appMenu): ?>
            <tr>
                <td><?= $this->Number->format($appMenu->id) ?></td>
                <td><?= h($appMenu->name) ?></td>
                <td><?= h($appMenu->link) ?></td>
                <td><?= $appMenu->has('city') ? $this->Html->link($appMenu->city->name, ['controller' => 'Cities', 'action' => 'view', $appMenu->city->id]) : '' ?></td>
                <td><?= $this->Number->format($appMenu->status) ?></td>
                <td><?= $this->Number->format($appMenu->parent_id) ?></td>
                <td><?= $this->Number->format($appMenu->lft) ?></td>
                <td><?= $this->Number->format($appMenu->rght) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $appMenu->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $appMenu->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $appMenu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $appMenu->id)]) ?>
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
