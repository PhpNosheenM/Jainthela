<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseOrderRow $purchaseOrderRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $purchaseOrderRow->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrderRow->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Purchase Order Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Orders'), ['controller' => 'PurchaseOrders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Order'), ['controller' => 'PurchaseOrders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Unit Variations'), ['controller' => 'UnitVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Unit Variation'), ['controller' => 'UnitVariations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="purchaseOrderRows form large-9 medium-8 columns content">
    <?= $this->Form->create($purchaseOrderRow) ?>
    <fieldset>
        <legend><?= __('Edit Purchase Order Row') ?></legend>
        <?php
            echo $this->Form->control('purchase_order_id', ['options' => $purchaseOrders]);
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('item_variation_id', ['options' => $itemVariations]);
            echo $this->Form->control('unit_variation_id', ['options' => $unitVariations]);
            echo $this->Form->control('quantity');
            echo $this->Form->control('rate');
            echo $this->Form->control('net_amount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
