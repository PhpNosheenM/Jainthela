<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grn $grn
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Grns'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Seller Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="grns form large-9 medium-8 columns content">
    <?= $this->Form->create($grn) ?>
    <fieldset>
        <legend><?= __('Add Grn') ?></legend>
        <?php
            echo $this->Form->control('voucher_no');
            echo $this->Form->control('grn_no');
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('order_id', ['options' => $orders]);
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('reference_no');
            echo $this->Form->control('status');
            echo $this->Form->control('total_taxable_value');
            echo $this->Form->control('total_gst');
            echo $this->Form->control('total_amount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
