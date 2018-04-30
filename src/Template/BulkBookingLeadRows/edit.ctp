<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BulkBookingLeadRow $bulkBookingLeadRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $bulkBookingLeadRow->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $bulkBookingLeadRow->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Bulk Booking Lead Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Bulk Booking Leads'), ['controller' => 'BulkBookingLeads', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bulk Booking Lead'), ['controller' => 'BulkBookingLeads', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bulkBookingLeadRows form large-9 medium-8 columns content">
    <?= $this->Form->create($bulkBookingLeadRow) ?>
    <fieldset>
        <legend><?= __('Edit Bulk Booking Lead Row') ?></legend>
        <?php
            echo $this->Form->control('bulk_booking_lead_id', ['options' => $bulkBookingLeads]);
            echo $this->Form->control('image_name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
