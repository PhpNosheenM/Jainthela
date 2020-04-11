<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContraVoucherRow $contraVoucherRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Contra Voucher Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contra Vouchers'), ['controller' => 'ContraVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contra Voucher'), ['controller' => 'ContraVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contraVoucherRows form large-9 medium-8 columns content">
    <?= $this->Form->create($contraVoucherRow) ?>
    <fieldset>
        <legend><?= __('Add Contra Voucher Row') ?></legend>
        <?php
            echo $this->Form->control('contra_voucher_id', ['options' => $contraVouchers]);
            echo $this->Form->control('cr_dr');
            echo $this->Form->control('ledger_id', ['options' => $ledgers]);
            echo $this->Form->control('debit');
            echo $this->Form->control('credit');
            echo $this->Form->control('mode_of_payment');
            echo $this->Form->control('cheque_no');
            echo $this->Form->control('cheque_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
