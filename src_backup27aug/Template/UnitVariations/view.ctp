<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UnitVariation $unitVariation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Unit Variation'), ['action' => 'edit', $unitVariation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Unit Variation'), ['action' => 'delete', $unitVariation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $unitVariation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Unit Variations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit Variation'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Units'), ['controller' => 'Units', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit'), ['controller' => 'Units', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="unitVariations view large-9 medium-8 columns content">
    <h3><?= h($unitVariation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Unit') ?></th>
            <td><?= $unitVariation->has('unit') ? $this->Html->link($unitVariation->unit->unit_name, ['controller' => 'Units', 'action' => 'view', $unitVariation->unit->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($unitVariation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity Variation') ?></th>
            <td><?= $this->Number->format($unitVariation->quantity_variation) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Convert Unit Qty') ?></th>
            <td><?= $this->Number->format($unitVariation->convert_unit_qty) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($unitVariation->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($unitVariation->created_on) ?></td>
        </tr>
    </table>
</div>
