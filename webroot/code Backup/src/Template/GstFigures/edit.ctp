<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GstFigure $gstFigure
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $gstFigure->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $gstFigure->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Gst Figures'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sale Return Rows'), ['controller' => 'SaleReturnRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale Return Row'), ['controller' => 'SaleReturnRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales Invoice Rows'), ['controller' => 'SalesInvoiceRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sales Invoice Row'), ['controller' => 'SalesInvoiceRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="gstFigures form large-9 medium-8 columns content">
    <?= $this->Form->create($gstFigure) ?>
    <fieldset>
        <legend><?= __('Edit Gst Figure') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('tax_percentage');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
