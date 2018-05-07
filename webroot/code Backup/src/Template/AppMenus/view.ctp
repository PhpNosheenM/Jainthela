<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppMenu $appMenu
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit App Menu'), ['action' => 'edit', $appMenu->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete App Menu'), ['action' => 'delete', $appMenu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $appMenu->id)]) ?> </li>
        <li><?= $this->Html->link(__('List App Menus'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New App Menu'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent App Menus'), ['controller' => 'AppMenus', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent App Menu'), ['controller' => 'AppMenus', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Child App Menus'), ['controller' => 'AppMenus', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child App Menu'), ['controller' => 'AppMenus', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="appMenus view large-9 medium-8 columns content">
    <h3><?= h($appMenu->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($appMenu->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link') ?></th>
            <td><?= h($appMenu->link) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $appMenu->has('city') ? $this->Html->link($appMenu->city->name, ['controller' => 'Cities', 'action' => 'view', $appMenu->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent App Menu') ?></th>
            <td><?= $appMenu->has('parent_app_menu') ? $this->Html->link($appMenu->parent_app_menu->name, ['controller' => 'AppMenus', 'action' => 'view', $appMenu->parent_app_menu->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($appMenu->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($appMenu->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lft') ?></th>
            <td><?= $this->Number->format($appMenu->lft) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rght') ?></th>
            <td><?= $this->Number->format($appMenu->rght) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related App Menus') ?></h4>
        <?php if (!empty($appMenu->child_app_menus)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Link') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Parent Id') ?></th>
                <th scope="col"><?= __('Lft') ?></th>
                <th scope="col"><?= __('Rght') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($appMenu->child_app_menus as $childAppMenus): ?>
            <tr>
                <td><?= h($childAppMenus->id) ?></td>
                <td><?= h($childAppMenus->name) ?></td>
                <td><?= h($childAppMenus->link) ?></td>
                <td><?= h($childAppMenus->city_id) ?></td>
                <td><?= h($childAppMenus->status) ?></td>
                <td><?= h($childAppMenus->parent_id) ?></td>
                <td><?= h($childAppMenus->lft) ?></td>
                <td><?= h($childAppMenus->rght) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AppMenus', 'action' => 'view', $childAppMenus->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AppMenus', 'action' => 'edit', $childAppMenus->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AppMenus', 'action' => 'delete', $childAppMenus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childAppMenus->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
