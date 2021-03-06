<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SaleReturn $saleReturn
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $saleReturn->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $saleReturn->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Party Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Party Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Ledgers'), ['controller' => 'ItemLedgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Ledger'), ['controller' => 'ItemLedgers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reference Details'), ['controller' => 'ReferenceDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['controller' => 'ReferenceDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sale Return Rows'), ['controller' => 'SaleReturnRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale Return Row'), ['controller' => 'SaleReturnRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="saleReturns form large-9 medium-8 columns content">
    <?= $this->Form->create($saleReturn) ?>
    <fieldset>
        <legend><?= __('Edit Sale Return') ?></legend>
        <?php
            echo $this->Form->control('voucher_no');
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('customer_id', ['options' => $customers]);
            echo $this->Form->control('amount_before_tax');
            echo $this->Form->control('total_cgst');
            echo $this->Form->control('total_sgst');
            echo $this->Form->control('total_igst');
            echo $this->Form->control('amount_after_tax');
            echo $this->Form->control('round_off');
            echo $this->Form->control('sales_ledger_id');
            echo $this->Form->control('party_ledger_id', ['options' => $partyLedgers]);
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('order_id', ['options' => $orders]);
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
