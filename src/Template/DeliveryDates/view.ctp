<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DeliveryDate $deliveryDate
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Delivery Date'), ['action' => 'edit', $deliveryDate->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Delivery Date'), ['action' => 'delete', $deliveryDate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $deliveryDate->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Delivery Dates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Delivery Date'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="deliveryDates view large-9 medium-8 columns content">
    <h3><?= h($deliveryDate->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Same Day') ?></th>
            <td><?= h($deliveryDate->same_day) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($deliveryDate->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Next Day') ?></th>
            <td><?= $this->Number->format($deliveryDate->next_day) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($deliveryDate->status) ?></td>
        </tr>
    </table>
</div>
