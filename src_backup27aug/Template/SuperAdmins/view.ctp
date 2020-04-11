<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SuperAdmin $superAdmin
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Super Admin'), ['action' => 'edit', $superAdmin->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Super Admin'), ['action' => 'delete', $superAdmin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $superAdmin->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Super Admins'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Super Admin'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="superAdmins view large-9 medium-8 columns content">
    <h3><?= h($superAdmin->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $superAdmin->has('city') ? $this->Html->link($superAdmin->city->name, ['controller' => 'Cities', 'action' => 'view', $superAdmin->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= $superAdmin->has('role') ? $this->Html->link($superAdmin->role->name, ['controller' => 'Roles', 'action' => 'view', $superAdmin->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($superAdmin->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($superAdmin->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($superAdmin->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($superAdmin->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mobile No') ?></th>
            <td><?= h($superAdmin->mobile_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($superAdmin->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($superAdmin->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($superAdmin->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Timeout') ?></th>
            <td><?= $this->Number->format($superAdmin->timeout) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($superAdmin->created_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Passkey') ?></h4>
        <?= $this->Text->autoParagraph(h($superAdmin->passkey)); ?>
    </div>
</div>
