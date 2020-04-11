<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GrnRow $grnRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $grnRow->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $grnRow->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Grn Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Grn Rows'), ['controller' => 'GrnRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Grn Row'), ['controller' => 'GrnRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="grnRows form large-9 medium-8 columns content">
    <?= $this->Form->create($grnRow) ?>
    <fieldset>
        <legend><?= __('Edit Grn Row') ?></legend>
        <?php
            echo $this->Form->control('grn_row_id');
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('item_variation_id', ['options' => $itemVariations]);
            echo $this->Form->control('quantity');
            echo $this->Form->control('rate');
            echo $this->Form->control('taxable_value');
            echo $this->Form->control('net_amount');
            echo $this->Form->control('gst_percentage');
            echo $this->Form->control('gst_value');
            echo $this->Form->control('purchase_rate');
            echo $this->Form->control('sales_rate');
            echo $this->Form->control('gst_type');
            echo $this->Form->control('mrp');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
