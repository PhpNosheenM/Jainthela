<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Vendor[]|\Cake\Collection\CollectionInterface $vendors
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Vendor'), ['action' => 'add']) ?></li>
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
<div class="vendors index large-9 medium-8 columns content">
    <h3><?= __('Vendors') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gstin') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pan') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gstin_holder_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('firm_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('firm_email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('firm_contact') ?></th>
                <th scope="col"><?= $this->Paginator->sort('firm_pincode') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registration_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('termination_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bill_to_bill_accounting') ?></th>
                <th scope="col"><?= $this->Paginator->sort('opening_balance_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('debit_credit') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendors as $vendor): ?>
            <tr>
                <td><?= $this->Number->format($vendor->id) ?></td>
                <td><?= $vendor->has('city') ? $this->Html->link($vendor->city->name, ['controller' => 'Cities', 'action' => 'view', $vendor->city->id]) : '' ?></td>
                <td><?= h($vendor->name) ?></td>
                <td><?= h($vendor->gstin) ?></td>
                <td><?= h($vendor->pan) ?></td>
                <td><?= h($vendor->gstin_holder_name) ?></td>
                <td><?= h($vendor->firm_name) ?></td>
                <td><?= h($vendor->firm_email) ?></td>
                <td><?= h($vendor->firm_contact) ?></td>
                <td><?= h($vendor->firm_pincode) ?></td>
                <td><?= h($vendor->registration_date) ?></td>
                <td><?= h($vendor->termination_date) ?></td>
                <td><?= h($vendor->created_on) ?></td>
                <td><?= $this->Number->format($vendor->created_by) ?></td>
                <td><?= h($vendor->bill_to_bill_accounting) ?></td>
                <td><?= $this->Number->format($vendor->opening_balance_value) ?></td>
                <td><?= h($vendor->debit_credit) ?></td>
                <td><?= h($vendor->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $vendor->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $vendor->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $vendor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendor->id)]) ?>
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
