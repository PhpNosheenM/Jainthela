<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccountingGroup $accountingGroup
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $accountingGroup->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $accountingGroup->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Accounting Groups'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Nature Of Groups'), ['controller' => 'NatureOfGroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Nature Of Group'), ['controller' => 'NatureOfGroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Parent Accounting Groups'), ['controller' => 'AccountingGroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parent Accounting Group'), ['controller' => 'AccountingGroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="accountingGroups form large-9 medium-8 columns content">
    <?= $this->Form->create($accountingGroup) ?>
    <fieldset>
        <legend><?= __('Edit Accounting Group') ?></legend>
        <?php
            echo $this->Form->control('nature_of_group_id', ['options' => $natureOfGroups, 'empty' => true]);
            echo $this->Form->control('name');
            echo $this->Form->control('parent_id', ['options' => $parentAccountingGroups, 'empty' => true]);
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('customer');
            echo $this->Form->control('supplier');
            echo $this->Form->control('purchase_voucher_first_ledger');
            echo $this->Form->control('purchase_voucher_purchase_ledger');
            echo $this->Form->control('purchase_voucher_all_ledger');
            echo $this->Form->control('sale_invoice_party');
            echo $this->Form->control('sale_invoice_sales_account');
            echo $this->Form->control('credit_note_party');
            echo $this->Form->control('credit_note_sales_account');
            echo $this->Form->control('bank');
            echo $this->Form->control('cash');
            echo $this->Form->control('purchase_invoice_purchase_account');
            echo $this->Form->control('purchase_invoice_party');
            echo $this->Form->control('receipt_ledger');
            echo $this->Form->control('payment_ledger');
            echo $this->Form->control('credit_note_first_row');
            echo $this->Form->control('credit_note_all_row');
            echo $this->Form->control('debit_note_first_row');
            echo $this->Form->control('debit_note_all_row');
            echo $this->Form->control('sales_voucher_first_ledger');
            echo $this->Form->control('sales_voucher_sales_ledger');
            echo $this->Form->control('sales_voucher_all_ledger');
            echo $this->Form->control('journal_voucher_ledger');
            echo $this->Form->control('contra_voucher_ledger');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
