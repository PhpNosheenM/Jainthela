<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SaleReturnRow $saleReturnRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $saleReturnRow->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $saleReturnRow->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Sale Return Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['controller' => 'SaleReturns', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale Return'), ['controller' => 'SaleReturns', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Gst Figures'), ['controller' => 'GstFigures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Gst Figure'), ['controller' => 'GstFigures', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Order Details'), ['controller' => 'OrderDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order Detail'), ['controller' => 'OrderDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Ledgers'), ['controller' => 'ItemLedgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Ledger'), ['controller' => 'ItemLedgers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="saleReturnRows form large-9 medium-8 columns content">
    <?= $this->Form->create($saleReturnRow) ?>
    <fieldset>
        <legend><?= __('Edit Sale Return Row') ?></legend>
        <?php
            echo $this->Form->control('sale_return_id', ['options' => $saleReturns]);
            echo $this->Form->control('item_variation_id', ['options' => $itemVariations]);
            echo $this->Form->control('return_quantity');
            echo $this->Form->control('rate');
            echo $this->Form->control('amount');
            echo $this->Form->control('taxable_value');
            echo $this->Form->control('gst_percentage');
            echo $this->Form->control('gst_figure_id', ['options' => $gstFigures, 'empty' => true]);
            echo $this->Form->control('gst_value');
            echo $this->Form->control('net_amount');
            echo $this->Form->control('order_detail_id', ['options' => $orderDetails]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
