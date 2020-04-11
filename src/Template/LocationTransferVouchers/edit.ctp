<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationTransferVoucher $locationTransferVoucher
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $locationTransferVoucher->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $locationTransferVoucher->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Location Transfer Vouchers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Financial Years'), ['controller' => 'FinancialYears', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Financial Year'), ['controller' => 'FinancialYears', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Location Transfer Voucher Rows'), ['controller' => 'LocationTransferVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location Transfer Voucher Row'), ['controller' => 'LocationTransferVoucherRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="locationTransferVouchers form large-9 medium-8 columns content">
    <?= $this->Form->create($locationTransferVoucher) ?>
    <fieldset>
        <legend><?= __('Edit Location Transfer Voucher') ?></legend>
        <?php
            echo $this->Form->control('voucher_no');
            echo $this->Form->control('financial_year_id', ['options' => $financialYears]);
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('location_out_id');
            echo $this->Form->control('location_in_id');
            echo $this->Form->control('created_on');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
