<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderDetail $orderDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Order Detail'), ['action' => 'edit', $orderDetail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Order Detail'), ['action' => 'delete', $orderDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderDetail->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Order Details'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order Detail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combo Offers'), ['controller' => 'ComboOffers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo Offer'), ['controller' => 'ComboOffers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="orderDetails view large-9 medium-8 columns content">
    <h3><?= h($orderDetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Order') ?></th>
            <td><?= $orderDetail->has('order') ? $this->Html->link($orderDetail->order->id, ['controller' => 'Orders', 'action' => 'view', $orderDetail->order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $orderDetail->has('item_variation') ? $this->Html->link($orderDetail->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $orderDetail->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Combo Offer') ?></th>
            <td><?= $orderDetail->has('combo_offer') ? $this->Html->link($orderDetail->combo_offer->name, ['controller' => 'ComboOffers', 'action' => 'view', $orderDetail->combo_offer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($orderDetail->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($orderDetail->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $this->Number->format($orderDetail->rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($orderDetail->amount) ?></td>
        </tr>
    </table>
</div>
