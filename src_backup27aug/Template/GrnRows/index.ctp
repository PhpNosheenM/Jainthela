<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GrnRow[]|\Cake\Collection\CollectionInterface $grnRows
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Grn Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="grnRows index large-9 medium-8 columns content">
    <h3><?= __('Grn Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('grn_row_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_variation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('taxable_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('net_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_percentage') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mrp') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grnRows as $grnRow): ?>
            <tr>
                <td><?= $this->Number->format($grnRow->id) ?></td>
                <td><?= $this->Number->format($grnRow->grn_row_id) ?></td>
                <td><?= $grnRow->has('item') ? $this->Html->link($grnRow->item->name, ['controller' => 'Items', 'action' => 'view', $grnRow->item->id]) : '' ?></td>
                <td><?= $grnRow->has('item_variation') ? $this->Html->link($grnRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $grnRow->item_variation->id]) : '' ?></td>
                <td><?= $this->Number->format($grnRow->quantity) ?></td>
                <td><?= $this->Number->format($grnRow->rate) ?></td>
                <td><?= $this->Number->format($grnRow->taxable_value) ?></td>
                <td><?= $this->Number->format($grnRow->net_amount) ?></td>
                <td><?= $this->Number->format($grnRow->gst_percentage) ?></td>
                <td><?= $this->Number->format($grnRow->gst_value) ?></td>
                <td><?= $this->Number->format($grnRow->purchase_rate) ?></td>
                <td><?= $this->Number->format($grnRow->sales_rate) ?></td>
                <td><?= h($grnRow->gst_type) ?></td>
                <td><?= $this->Number->format($grnRow->mrp) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $grnRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $grnRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $grnRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grnRow->id)]) ?>
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
