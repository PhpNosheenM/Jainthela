<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BulkBookingLead $bulkBookingLead
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $bulkBookingLead->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $bulkBookingLead->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Bulk Booking Leads'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bulk Booking Lead Rows'), ['controller' => 'BulkBookingLeadRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bulk Booking Lead Row'), ['controller' => 'BulkBookingLeadRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bulkBookingLeads form large-9 medium-8 columns content">
    <?= $this->Form->create($bulkBookingLead) ?>
    <fieldset>
        <legend><?= __('Edit Bulk Booking Lead') ?></legend>
        <?php
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('customer_id', ['options' => $customers]);
            echo $this->Form->control('lead_no');
            echo $this->Form->control('name');
            echo $this->Form->control('mobile');
            echo $this->Form->control('lead_description');
            echo $this->Form->control('delivery_date');
            echo $this->Form->control('delivery_time');
            echo $this->Form->control('created_on');
            echo $this->Form->control('status');
            echo $this->Form->control('reason');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
