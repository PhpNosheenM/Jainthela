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
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
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
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($appMenu->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($appMenu->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent Id') ?></th>
            <td><?= $this->Number->format($appMenu->parent_id) ?></td>
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
</div>
