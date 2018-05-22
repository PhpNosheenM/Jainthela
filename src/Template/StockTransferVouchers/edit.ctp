<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StockTransferVoucher $stockTransferVoucher
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $stockTransferVoucher->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $stockTransferVoucher->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Stock Transfer Vouchers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Grns'), ['controller' => 'Grns', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Grn'), ['controller' => 'Grns', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Stock Transfer Voucher Rows'), ['controller' => 'StockTransferVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Stock Transfer Voucher Row'), ['controller' => 'StockTransferVoucherRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stockTransferVouchers form large-9 medium-8 columns content">
    <?= $this->Form->create($stockTransferVoucher) ?>
    <fieldset>
        <legend><?= __('Edit Stock Transfer Voucher') ?></legend>
        <?php
            echo $this->Form->control('grn_id', ['options' => $grns, 'empty' => true]);
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('voucher_no');
            echo $this->Form->control('narration');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
