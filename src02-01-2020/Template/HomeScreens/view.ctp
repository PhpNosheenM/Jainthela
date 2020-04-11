<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HomeScreen $homeScreen
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Home Screen'), ['action' => 'edit', $homeScreen->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Home Screen'), ['action' => 'delete', $homeScreen->id], ['confirm' => __('Are you sure you want to delete # {0}?', $homeScreen->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Home Screens'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Home Screen'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="homeScreens view large-9 medium-8 columns content">
    <h3><?= h($homeScreen->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($homeScreen->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Layout') ?></th>
            <td><?= h($homeScreen->layout) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Section Show') ?></th>
            <td><?= h($homeScreen->section_show) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= $homeScreen->has('category') ? $this->Html->link($homeScreen->category->name, ['controller' => 'Categories', 'action' => 'view', $homeScreen->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Screen Type') ?></th>
            <td><?= h($homeScreen->screen_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($homeScreen->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Preference') ?></th>
            <td><?= $this->Number->format($homeScreen->preference) ?></td>
        </tr>
    </table>
</div>
