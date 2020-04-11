<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notify $notify
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Notify'), ['action' => 'edit', $notify->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Notify'), ['action' => 'delete', $notify->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notify->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Notifies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notify'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="notifies view large-9 medium-8 columns content">
    <h3><?= h($notify->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $notify->has('customer') ? $this->Html->link($notify->customer->name, ['controller' => 'Customers', 'action' => 'view', $notify->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $notify->has('item_variation') ? $this->Html->link($notify->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $notify->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Send Flag') ?></th>
            <td><?= h($notify->send_flag) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($notify->id) ?></td>
        </tr>
    </table>
</div>
