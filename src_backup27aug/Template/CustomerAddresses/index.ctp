<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerAddress[]|\Cake\Collection\CollectionInterface $customerAddresses
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Customer Address'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="customerAddresses index large-9 medium-8 columns content">
    <h3><?= __('Customer Addresses') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pincode') ?></th>
                <th scope="col"><?= $this->Paginator->sort('house_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('latitude') ?></th>
                <th scope="col"><?= $this->Paginator->sort('longitude') ?></th>
                <th scope="col"><?= $this->Paginator->sort('default_address') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customerAddresses as $customerAddress): ?>
            <tr>
                <td><?= $this->Number->format($customerAddress->id) ?></td>
                <td><?= $customerAddress->has('customer') ? $this->Html->link($customerAddress->customer->name, ['controller' => 'Customers', 'action' => 'view', $customerAddress->customer->id]) : '' ?></td>
                <td><?= $customerAddress->has('city') ? $this->Html->link($customerAddress->city->name, ['controller' => 'Cities', 'action' => 'view', $customerAddress->city->id]) : '' ?></td>
                <td><?= $customerAddress->has('location') ? $this->Html->link($customerAddress->location->name, ['controller' => 'Locations', 'action' => 'view', $customerAddress->location->id]) : '' ?></td>
                <td><?= $this->Number->format($customerAddress->pincode) ?></td>
                <td><?= h($customerAddress->house_no) ?></td>
                <td><?= h($customerAddress->latitude) ?></td>
                <td><?= h($customerAddress->longitude) ?></td>
                <td><?= $this->Number->format($customerAddress->default_address) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $customerAddress->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $customerAddress->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $customerAddress->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerAddress->id)]) ?>
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
