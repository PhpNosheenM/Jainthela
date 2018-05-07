<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Vendor $vendor
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $vendor->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $vendor->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Vendors'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Vendor Details'), ['controller' => 'VendorDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vendor Detail'), ['controller' => 'VendorDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="vendors form large-9 medium-8 columns content">
    <?= $this->Form->create($vendor) ?>
    <fieldset>
        <legend><?= __('Edit Vendor') ?></legend>
        <?php
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('name');
            echo $this->Form->control('gstin');
            echo $this->Form->control('pan');
            echo $this->Form->control('gstin_holder_name');
            echo $this->Form->control('gstin_holder_address');
            echo $this->Form->control('firm_name');
            echo $this->Form->control('firm_address');
            echo $this->Form->control('firm_email');
            echo $this->Form->control('firm_contact');
            echo $this->Form->control('firm_pincode');
            echo $this->Form->control('registration_date');
            echo $this->Form->control('termination_date');
            echo $this->Form->control('termination_reason');
            echo $this->Form->control('breif_decription');
            echo $this->Form->control('created_on');
            echo $this->Form->control('created_by');
            echo $this->Form->control('bill_to_bill_accounting');
            echo $this->Form->control('opening_balance_value');
            echo $this->Form->control('debit_credit');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
