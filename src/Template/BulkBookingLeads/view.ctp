<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BulkBookingLead $bulkBookingLead
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Bulk Booking Lead'), ['action' => 'edit', $bulkBookingLead->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Bulk Booking Lead'), ['action' => 'delete', $bulkBookingLead->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bulkBookingLead->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Bulk Booking Leads'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bulk Booking Lead'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bulk Booking Lead Rows'), ['controller' => 'BulkBookingLeadRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bulk Booking Lead Row'), ['controller' => 'BulkBookingLeadRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="bulkBookingLeads view large-9 medium-8 columns content">
    <h3><?= h($bulkBookingLead->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $bulkBookingLead->has('city') ? $this->Html->link($bulkBookingLead->city->name, ['controller' => 'Cities', 'action' => 'view', $bulkBookingLead->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $bulkBookingLead->has('customer') ? $this->Html->link($bulkBookingLead->customer->name, ['controller' => 'Customers', 'action' => 'view', $bulkBookingLead->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($bulkBookingLead->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mobile') ?></th>
            <td><?= h($bulkBookingLead->mobile) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delivery Time') ?></th>
            <td><?= h($bulkBookingLead->delivery_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($bulkBookingLead->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($bulkBookingLead->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lead No') ?></th>
            <td><?= $this->Number->format($bulkBookingLead->lead_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delivery Date') ?></th>
            <td><?= h($bulkBookingLead->delivery_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($bulkBookingLead->created_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Lead Description') ?></h4>
        <?= $this->Text->autoParagraph(h($bulkBookingLead->lead_description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Reason') ?></h4>
        <?= $this->Text->autoParagraph(h($bulkBookingLead->reason)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Bulk Booking Lead Rows') ?></h4>
        <?php if (!empty($bulkBookingLead->bulk_booking_lead_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Bulk Booking Lead Id') ?></th>
                <th scope="col"><?= __('Image Name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($bulkBookingLead->bulk_booking_lead_rows as $bulkBookingLeadRows): ?>
            <tr>
                <td><?= h($bulkBookingLeadRows->id) ?></td>
                <td><?= h($bulkBookingLeadRows->bulk_booking_lead_id) ?></td>
                <td><?= h($bulkBookingLeadRows->image_name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'BulkBookingLeadRows', 'action' => 'view', $bulkBookingLeadRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'BulkBookingLeadRows', 'action' => 'edit', $bulkBookingLeadRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'BulkBookingLeadRows', 'action' => 'delete', $bulkBookingLeadRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bulkBookingLeadRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
