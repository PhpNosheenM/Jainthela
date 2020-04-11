<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerMembership $customerMembership
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Customer Membership'), ['action' => 'edit', $customerMembership->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Customer Membership'), ['action' => 'delete', $customerMembership->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerMembership->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Customer Memberships'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer Membership'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Plans'), ['controller' => 'Plans', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Plan'), ['controller' => 'Plans', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="customerMemberships view large-9 medium-8 columns content">
    <h3><?= h($customerMembership->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $customerMembership->has('customer') ? $this->Html->link($customerMembership->customer->name, ['controller' => 'Customers', 'action' => 'view', $customerMembership->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $customerMembership->has('city') ? $this->Html->link($customerMembership->city->name, ['controller' => 'Cities', 'action' => 'view', $customerMembership->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Plan') ?></th>
            <td><?= $customerMembership->has('plan') ? $this->Html->link($customerMembership->plan->name, ['controller' => 'Plans', 'action' => 'view', $customerMembership->plan->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($customerMembership->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($customerMembership->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Percentage') ?></th>
            <td><?= $this->Number->format($customerMembership->discount_percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Date') ?></th>
            <td><?= h($customerMembership->start_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Date') ?></th>
            <td><?= h($customerMembership->end_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($customerMembership->created_on) ?></td>
        </tr>
    </table>
</div>
