<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemVariationMaster[]|\Cake\Collection\CollectionInterface $itemVariationMasters
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Item Variation Master'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Unit Variations'), ['controller' => 'UnitVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Unit Variation'), ['controller' => 'UnitVariations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemVariationMasters index large-9 medium-8 columns content">
    <h3><?= __('Item Variation Masters') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('unit_variation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('edited_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('edited_by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itemVariationMasters as $itemVariationMaster): ?>
            <tr>
                <td><?= $this->Number->format($itemVariationMaster->id) ?></td>
                <td><?= $itemVariationMaster->has('item') ? $this->Html->link($itemVariationMaster->item->name, ['controller' => 'Items', 'action' => 'view', $itemVariationMaster->item->id]) : '' ?></td>
                <td><?= $itemVariationMaster->has('unit_variation') ? $this->Html->link($itemVariationMaster->unit_variation->id, ['controller' => 'UnitVariations', 'action' => 'view', $itemVariationMaster->unit_variation->id]) : '' ?></td>
                <td><?= h($itemVariationMaster->created_on) ?></td>
                <td><?= h($itemVariationMaster->edited_on) ?></td>
                <td><?= $this->Number->format($itemVariationMaster->created_by) ?></td>
                <td><?= $this->Number->format($itemVariationMaster->edited_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $itemVariationMaster->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $itemVariationMaster->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $itemVariationMaster->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemVariationMaster->id)]) ?>
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
