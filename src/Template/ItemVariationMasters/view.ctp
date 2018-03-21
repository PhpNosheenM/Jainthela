<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemVariationMaster $itemVariationMaster
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Item Variation Master'), ['action' => 'edit', $itemVariationMaster->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Item Variation Master'), ['action' => 'delete', $itemVariationMaster->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemVariationMaster->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Item Variation Masters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation Master'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Unit Variations'), ['controller' => 'UnitVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit Variation'), ['controller' => 'UnitVariations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="itemVariationMasters view large-9 medium-8 columns content">
    <h3><?= h($itemVariationMaster->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $itemVariationMaster->has('item') ? $this->Html->link($itemVariationMaster->item->name, ['controller' => 'Items', 'action' => 'view', $itemVariationMaster->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Unit Variation') ?></th>
            <td><?= $itemVariationMaster->has('unit_variation') ? $this->Html->link($itemVariationMaster->unit_variation->id, ['controller' => 'UnitVariations', 'action' => 'view', $itemVariationMaster->unit_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($itemVariationMaster->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($itemVariationMaster->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited By') ?></th>
            <td><?= $this->Number->format($itemVariationMaster->edited_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($itemVariationMaster->created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited On') ?></th>
            <td><?= h($itemVariationMaster->edited_on) ?></td>
        </tr>
    </table>
</div>
