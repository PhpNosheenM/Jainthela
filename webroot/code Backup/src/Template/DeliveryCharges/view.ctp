<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DeliveryCharge $deliveryCharge
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Delivery Charge'), ['action' => 'edit', $deliveryCharge->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Delivery Charge'), ['action' => 'delete', $deliveryCharge->id], ['confirm' => __('Are you sure you want to delete # {0}?', $deliveryCharge->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Delivery Charges'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Delivery Charge'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="deliveryCharges view large-9 medium-8 columns content">
    <h3><?= h($deliveryCharge->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $deliveryCharge->has('city') ? $this->Html->link($deliveryCharge->city->name, ['controller' => 'Cities', 'action' => 'view', $deliveryCharge->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($deliveryCharge->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($deliveryCharge->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($deliveryCharge->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Charge') ?></th>
            <td><?= $this->Number->format($deliveryCharge->charge) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($deliveryCharge->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($deliveryCharge->created_on) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Orders') ?></h4>
        <?php if (!empty($deliveryCharge->orders)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Driver Id') ?></th>
                <th scope="col"><?= __('Customer Address Id') ?></th>
                <th scope="col"><?= __('Offer Detail Id') ?></th>
                <th scope="col"><?= __('Order No') ?></th>
                <th scope="col"><?= __('Ccavvenue Tracking No') ?></th>
                <th scope="col"><?= __('Amount From Wallet') ?></th>
                <th scope="col"><?= __('Total Amount') ?></th>
                <th scope="col"><?= __('Discount Percent') ?></th>
                <th scope="col"><?= __('Grand Total') ?></th>
                <th scope="col"><?= __('Pay Amount') ?></th>
                <th scope="col"><?= __('Online Amount') ?></th>
                <th scope="col"><?= __('Delivery Charge Id') ?></th>
                <th scope="col"><?= __('Order Type') ?></th>
                <th scope="col"><?= __('Delivery Date') ?></th>
                <th scope="col"><?= __('Delivery Time Id') ?></th>
                <th scope="col"><?= __('Order Status') ?></th>
                <th scope="col"><?= __('Cancel Reason Id') ?></th>
                <th scope="col"><?= __('Order Date') ?></th>
                <th scope="col"><?= __('Payment Status') ?></th>
                <th scope="col"><?= __('Order From') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($deliveryCharge->orders as $orders): ?>
            <tr>
                <td><?= h($orders->id) ?></td>
                <td><?= h($orders->location_id) ?></td>
                <td><?= h($orders->customer_id) ?></td>
                <td><?= h($orders->driver_id) ?></td>
                <td><?= h($orders->customer_address_id) ?></td>
                <td><?= h($orders->offer_detail_id) ?></td>
                <td><?= h($orders->order_no) ?></td>
                <td><?= h($orders->ccavvenue_tracking_no) ?></td>
                <td><?= h($orders->amount_from_wallet) ?></td>
                <td><?= h($orders->total_amount) ?></td>
                <td><?= h($orders->discount_percent) ?></td>
                <td><?= h($orders->grand_total) ?></td>
                <td><?= h($orders->pay_amount) ?></td>
                <td><?= h($orders->online_amount) ?></td>
                <td><?= h($orders->delivery_charge_id) ?></td>
                <td><?= h($orders->order_type) ?></td>
                <td><?= h($orders->delivery_date) ?></td>
                <td><?= h($orders->delivery_time_id) ?></td>
                <td><?= h($orders->order_status) ?></td>
                <td><?= h($orders->cancel_reason_id) ?></td>
                <td><?= h($orders->order_date) ?></td>
                <td><?= h($orders->payment_status) ?></td>
                <td><?= h($orders->order_from) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Orders', 'action' => 'view', $orders->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Orders', 'action' => 'edit', $orders->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Orders', 'action' => 'delete', $orders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orders->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
