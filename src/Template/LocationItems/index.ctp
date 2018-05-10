<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationItem[]|\Cake\Collection\CollectionInterface $locationItems
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Location Item'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="locationItems index large-9 medium-8 columns content">
    <h3><?= __('Location Items') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_variation_master_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($locationItems as $locationItem): ?>
            <tr>
                <td><?= $this->Number->format($locationItem->id) ?></td>
                <td><?= $locationItem->has('item') ? $this->Html->link($locationItem->item->name, ['controller' => 'Items', 'action' => 'view', $locationItem->item->id]) : '' ?></td>
                <td><?= $this->Number->format($locationItem->item_variation_master_id) ?></td>
                <td><?= $locationItem->has('location') ? $this->Html->link($locationItem->location->name, ['controller' => 'Locations', 'action' => 'view', $locationItem->location->id]) : '' ?></td>
                <td><?= h($locationItem->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $locationItem->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locationItem->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locationItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationItem->id)]) ?>
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
