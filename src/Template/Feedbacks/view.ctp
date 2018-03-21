<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feedback $feedback
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Feedback'), ['action' => 'edit', $feedback->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Feedback'), ['action' => 'delete', $feedback->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feedback->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Feedbacks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feedback'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="feedbacks view large-9 medium-8 columns content">
    <h3><?= h($feedback->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $feedback->has('customer') ? $this->Html->link($feedback->customer->name, ['controller' => 'Customers', 'action' => 'view', $feedback->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $feedback->has('city') ? $this->Html->link($feedback->city->name, ['controller' => 'Cities', 'action' => 'view', $feedback->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($feedback->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($feedback->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mobile No') ?></th>
            <td><?= h($feedback->mobile_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($feedback->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($feedback->created_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Comment') ?></h4>
        <?= $this->Text->autoParagraph(h($feedback->comment)); ?>
    </div>
</div>
