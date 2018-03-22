<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receipt $receipt
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $receipt->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $receipt->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Receipts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales Invoices'), ['controller' => 'SalesInvoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sales Invoice'), ['controller' => 'SalesInvoices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Receipt Rows'), ['controller' => 'ReceiptRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Receipt Row'), ['controller' => 'ReceiptRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reference Details'), ['controller' => 'ReferenceDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['controller' => 'ReferenceDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="receipts form large-9 medium-8 columns content">
    <?= $this->Form->create($receipt) ?>
    <fieldset>
        <legend><?= __('Edit Receipt') ?></legend>
        <?php
            echo $this->Form->control('voucher_no');
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('narration');
            echo $this->Form->control('voucher_amount');
            echo $this->Form->control('amount');
            echo $this->Form->control('sales_invoice_id', ['options' => $salesInvoices]);
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
