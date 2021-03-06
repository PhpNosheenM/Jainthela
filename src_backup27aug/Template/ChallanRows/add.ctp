<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChallanRow $challanRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Challan Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Challans'), ['controller' => 'Challans', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Challan'), ['controller' => 'Challans', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Order Details'), ['controller' => 'OrderDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order Detail'), ['controller' => 'OrderDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Combo Offers'), ['controller' => 'ComboOffers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Combo Offer'), ['controller' => 'ComboOffers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Gst Figures'), ['controller' => 'GstFigures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Gst Figure'), ['controller' => 'GstFigures', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="challanRows form large-9 medium-8 columns content">
    <?= $this->Form->create($challanRow) ?>
    <fieldset>
        <legend><?= __('Add Challan Row') ?></legend>
        <?php
            echo $this->Form->control('challan_id', ['options' => $challans]);
            echo $this->Form->control('order_detail_id', ['options' => $orderDetails]);
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('item_variation_id', ['options' => $itemVariations, 'empty' => true]);
            echo $this->Form->control('combo_offer_id', ['options' => $comboOffers, 'empty' => true]);
            echo $this->Form->control('quantity');
            echo $this->Form->control('actual_quantity');
            echo $this->Form->control('rate');
            echo $this->Form->control('amount');
            echo $this->Form->control('discount_percent');
            echo $this->Form->control('discount_amount');
            echo $this->Form->control('promo_percent');
            echo $this->Form->control('promo_amount');
            echo $this->Form->control('taxable_value');
            echo $this->Form->control('gst_percentage');
            echo $this->Form->control('gst_figure_id', ['options' => $gstFigures]);
            echo $this->Form->control('gst_value');
            echo $this->Form->control('net_amount');
            echo $this->Form->control('is_item_cancel');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
