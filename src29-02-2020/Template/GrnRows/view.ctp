<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GrnRow $grnRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Grn Row'), ['action' => 'edit', $grnRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Grn Row'), ['action' => 'delete', $grnRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grnRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Grn Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grn Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Grn Rows'), ['controller' => 'GrnRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grn Row'), ['controller' => 'GrnRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="grnRows view large-9 medium-8 columns content">
    <h3><?= h($grnRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $grnRow->has('item') ? $this->Html->link($grnRow->item->name, ['controller' => 'Items', 'action' => 'view', $grnRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $grnRow->has('item_variation') ? $this->Html->link($grnRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $grnRow->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Type') ?></th>
            <td><?= h($grnRow->gst_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($grnRow->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Grn Row Id') ?></th>
            <td><?= $this->Number->format($grnRow->grn_row_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($grnRow->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $this->Number->format($grnRow->rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Taxable Value') ?></th>
            <td><?= $this->Number->format($grnRow->taxable_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Net Amount') ?></th>
            <td><?= $this->Number->format($grnRow->net_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Percentage') ?></th>
            <td><?= $this->Number->format($grnRow->gst_percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Value') ?></th>
            <td><?= $this->Number->format($grnRow->gst_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Rate') ?></th>
            <td><?= $this->Number->format($grnRow->purchase_rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Rate') ?></th>
            <td><?= $this->Number->format($grnRow->sales_rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mrp') ?></th>
            <td><?= $this->Number->format($grnRow->mrp) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Grn Rows') ?></h4>
        <?php if (!empty($grnRow->grn_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Grn Row Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Taxable Value') ?></th>
                <th scope="col"><?= __('Net Amount') ?></th>
                <th scope="col"><?= __('Gst Percentage') ?></th>
                <th scope="col"><?= __('Gst Value') ?></th>
                <th scope="col"><?= __('Purchase Rate') ?></th>
                <th scope="col"><?= __('Sales Rate') ?></th>
                <th scope="col"><?= __('Gst Type') ?></th>
                <th scope="col"><?= __('Mrp') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($grnRow->grn_rows as $grnRows): ?>
            <tr>
                <td><?= h($grnRows->id) ?></td>
                <td><?= h($grnRows->grn_row_id) ?></td>
                <td><?= h($grnRows->item_id) ?></td>
                <td><?= h($grnRows->item_variation_id) ?></td>
                <td><?= h($grnRows->quantity) ?></td>
                <td><?= h($grnRows->rate) ?></td>
                <td><?= h($grnRows->taxable_value) ?></td>
                <td><?= h($grnRows->net_amount) ?></td>
                <td><?= h($grnRows->gst_percentage) ?></td>
                <td><?= h($grnRows->gst_value) ?></td>
                <td><?= h($grnRows->purchase_rate) ?></td>
                <td><?= h($grnRows->sales_rate) ?></td>
                <td><?= h($grnRows->gst_type) ?></td>
                <td><?= h($grnRows->mrp) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'GrnRows', 'action' => 'view', $grnRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'GrnRows', 'action' => 'edit', $grnRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'GrnRows', 'action' => 'delete', $grnRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grnRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
