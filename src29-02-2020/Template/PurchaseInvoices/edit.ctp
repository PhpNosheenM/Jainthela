<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseInvoice $purchaseInvoice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $purchaseInvoice->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseInvoice->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Purchase Invoices'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Ledgers'), ['controller' => 'ItemLedgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Ledger'), ['controller' => 'ItemLedgers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Invoice Rows'), ['controller' => 'PurchaseInvoiceRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Invoice Row'), ['controller' => 'PurchaseInvoiceRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Returns'), ['controller' => 'PurchaseReturns', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Return'), ['controller' => 'PurchaseReturns', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reference Details'), ['controller' => 'ReferenceDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['controller' => 'ReferenceDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="purchaseInvoices form large-9 medium-8 columns content">
    <?= $this->Form->create($purchaseInvoice) ?>
    <fieldset>
        <legend><?= __('Edit Purchase Invoice') ?></legend>
        <?php
            echo $this->Form->control('voucher_no');
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('seller_ledger_id');
            echo $this->Form->control('purchase_ledger_id');
            echo $this->Form->control('narration');
            echo $this->Form->control('status');
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('created_by');
            echo $this->Form->control('created_on');
            echo $this->Form->control('edited_by');
            echo $this->Form->control('edited_on');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
