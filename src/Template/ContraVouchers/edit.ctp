<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContraVoucher $contraVoucher
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $contraVoucher->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $contraVoucher->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Contra Vouchers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contraVouchers form large-9 medium-8 columns content">
    <?= $this->Form->create($contraVoucher) ?>
    <fieldset>
        <legend><?= __('Edit Contra Voucher') ?></legend>
        <?php
            echo $this->Form->control('voucher_no');
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('narration');
            echo $this->Form->control('created_by');
            echo $this->Form->control('created_on');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
