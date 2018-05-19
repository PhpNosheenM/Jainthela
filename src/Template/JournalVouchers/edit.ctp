<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\JournalVoucher $journalVoucher
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $journalVoucher->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $journalVoucher->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Journal Vouchers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Journal Voucher Rows'), ['controller' => 'JournalVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Journal Voucher Row'), ['controller' => 'JournalVoucherRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="journalVouchers form large-9 medium-8 columns content">
    <?= $this->Form->create($journalVoucher) ?>
    <fieldset>
        <legend><?= __('Edit Journal Voucher') ?></legend>
        <?php
            echo $this->Form->control('voucher_no');
            echo $this->Form->control('reference_no');
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('narration');
            echo $this->Form->control('total_credit_amount');
            echo $this->Form->control('total_debit_amount');
            echo $this->Form->control('status');
            echo $this->Form->control('created_by');
            echo $this->Form->control('created_on');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
