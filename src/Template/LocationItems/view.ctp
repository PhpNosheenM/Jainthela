<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationItem $locationItem
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Location Item'), ['action' => 'edit', $locationItem->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Location Item'), ['action' => 'delete', $locationItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationItem->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Location Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="locationItems view large-9 medium-8 columns content">
    <h3><?= h($locationItem->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $locationItem->has('item') ? $this->Html->link($locationItem->item->name, ['controller' => 'Items', 'action' => 'view', $locationItem->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $locationItem->has('location') ? $this->Html->link($locationItem->location->name, ['controller' => 'Locations', 'action' => 'view', $locationItem->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($locationItem->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($locationItem->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation Master Id') ?></th>
            <td><?= $this->Number->format($locationItem->item_variation_master_id) ?></td>
        </tr>
    </table>
</div>
