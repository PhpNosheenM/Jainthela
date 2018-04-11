<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BulkBookingLead[]|\Cake\Collection\CollectionInterface $bulkBookingLeads
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Bulk Booking Lead'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bulk Booking Lead Rows'), ['controller' => 'BulkBookingLeadRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bulk Booking Lead Row'), ['controller' => 'BulkBookingLeadRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bulkBookingLeads index large-9 medium-8 columns content">
    <h3><?= __('Bulk Booking Leads') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lead_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mobile') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delivery_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delivery_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bulkBookingLeads as $bulkBookingLead): ?>
            <tr>
                <td><?= $this->Number->format($bulkBookingLead->id) ?></td>
                <td><?= $bulkBookingLead->has('city') ? $this->Html->link($bulkBookingLead->city->name, ['controller' => 'Cities', 'action' => 'view', $bulkBookingLead->city->id]) : '' ?></td>
                <td><?= $bulkBookingLead->has('customer') ? $this->Html->link($bulkBookingLead->customer->name, ['controller' => 'Customers', 'action' => 'view', $bulkBookingLead->customer->id]) : '' ?></td>
                <td><?= $this->Number->format($bulkBookingLead->lead_no) ?></td>
                <td><?= h($bulkBookingLead->name) ?></td>
                <td><?= h($bulkBookingLead->mobile) ?></td>
                <td><?= h($bulkBookingLead->delivery_date) ?></td>
                <td><?= h($bulkBookingLead->delivery_time) ?></td>
                <td><?= h($bulkBookingLead->created_on) ?></td>
                <td><?= h($bulkBookingLead->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $bulkBookingLead->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bulkBookingLead->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bulkBookingLead->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bulkBookingLead->id)]) ?>
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
