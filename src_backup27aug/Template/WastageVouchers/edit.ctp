<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WastageVoucher $wastageVoucher
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $wastageVoucher->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $wastageVoucher->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Wastage Vouchers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Wastage Voucher Rows'), ['controller' => 'WastageVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wastage Voucher Row'), ['controller' => 'WastageVoucherRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="wastageVouchers form large-9 medium-8 columns content">
    <?= $this->Form->create($wastageVoucher) ?>
    <fieldset>
        <legend><?= __('Edit Wastage Voucher') ?></legend>
        <?php
            echo $this->Form->control('voucher_no');
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('created_on');
            echo $this->Form->control('created_by');
            echo $this->Form->control('narration');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
