<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BulkBookingLeadRow[]|\Cake\Collection\CollectionInterface $bulkBookingLeadRows
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Bulk Booking Lead Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bulk Booking Leads'), ['controller' => 'BulkBookingLeads', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bulk Booking Lead'), ['controller' => 'BulkBookingLeads', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bulkBookingLeadRows index large-9 medium-8 columns content">
    <h3><?= __('Bulk Booking Lead Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bulk_booking_lead_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('image_name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bulkBookingLeadRows as $bulkBookingLeadRow): ?>
            <tr>
                <td><?= $this->Number->format($bulkBookingLeadRow->id) ?></td>
                <td><?= $bulkBookingLeadRow->has('bulk_booking_lead') ? $this->Html->link($bulkBookingLeadRow->bulk_booking_lead->name, ['controller' => 'BulkBookingLeads', 'action' => 'view', $bulkBookingLeadRow->bulk_booking_lead->id]) : '' ?></td>
                <td><?= h($bulkBookingLeadRow->image_name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $bulkBookingLeadRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bulkBookingLeadRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bulkBookingLeadRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bulkBookingLeadRow->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
