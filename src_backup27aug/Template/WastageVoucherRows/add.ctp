<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WastageVoucherRow $wastageVoucherRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Wastage Voucher Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Wastage Vouchers'), ['controller' => 'WastageVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wastage Voucher'), ['controller' => 'WastageVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="wastageVoucherRows form large-9 medium-8 columns content">
    <?= $this->Form->create($wastageVoucherRow) ?>
    <fieldset>
        <legend><?= __('Add Wastage Voucher Row') ?></legend>
        <?php
            echo $this->Form->control('wastage_voucher_id', ['options' => $wastageVouchers]);
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('item_variation_id', ['options' => $itemVariations]);
            echo $this->Form->control('quantity');
            echo $this->Form->control('rate');
            echo $this->Form->control('amount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
