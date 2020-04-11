<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BulkBookingLeadRow $bulkBookingLeadRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Bulk Booking Lead Row'), ['action' => 'edit', $bulkBookingLeadRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Bulk Booking Lead Row'), ['action' => 'delete', $bulkBookingLeadRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bulkBookingLeadRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Bulk Booking Lead Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bulk Booking Lead Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bulk Booking Leads'), ['controller' => 'BulkBookingLeads', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bulk Booking Lead'), ['controller' => 'BulkBookingLeads', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="bulkBookingLeadRows view large-9 medium-8 columns content">
    <h3><?= h($bulkBookingLeadRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Bulk Booking Lead') ?></th>
            <td><?= $bulkBookingLeadRow->has('bulk_booking_lead') ? $this->Html->link($bulkBookingLeadRow->bulk_booking_lead->name, ['controller' => 'BulkBookingLeads', 'action' => 'view', $bulkBookingLeadRow->bulk_booking_lead->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Image Name') ?></th>
            <td><?= h($bulkBookingLeadRow->image_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($bulkBookingLeadRow->id) ?></td>
        </tr>
    </table>
</div>
