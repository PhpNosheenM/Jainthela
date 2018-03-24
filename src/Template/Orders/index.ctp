<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Order'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Drivers'), ['controller' => 'Drivers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Driver'), ['controller' => 'Drivers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customer Addresses'), ['controller' => 'CustomerAddresses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer Address'), ['controller' => 'CustomerAddresses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Promotion Details'), ['controller' => 'PromotionDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Promotion Detail'), ['controller' => 'PromotionDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Delivery Charges'), ['controller' => 'DeliveryCharges', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Delivery Charge'), ['controller' => 'DeliveryCharges', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Delivery Times'), ['controller' => 'DeliveryTimes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Delivery Time'), ['controller' => 'DeliveryTimes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cancel Reasons'), ['controller' => 'CancelReasons', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cancel Reason'), ['controller' => 'CancelReasons', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Order Details'), ['controller' => 'OrderDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order Detail'), ['controller' => 'OrderDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Wallets'), ['controller' => 'Wallets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wallet'), ['controller' => 'Wallets', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="orders index large-9 medium-8 columns content">
    <h3><?= __('Orders') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('driver_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_address_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('promotion_detail_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ccavvenue_tracking_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount_from_wallet') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_percent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_gst') ?></th>
                <th scope="col"><?= $this->Paginator->sort('grand_total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pay_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('online_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delivery_charge_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delivery_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delivery_time_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cancel_reason_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment_status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_from') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $this->Number->format($order->id) ?></td>
                <td><?= $order->has('location') ? $this->Html->link($order->location->name, ['controller' => 'Locations', 'action' => 'view', $order->location->id]) : '' ?></td>
                <td><?= $order->has('customer') ? $this->Html->link($order->customer->name, ['controller' => 'Customers', 'action' => 'view', $order->customer->id]) : '' ?></td>
                <td><?= $order->has('driver') ? $this->Html->link($order->driver->name, ['controller' => 'Drivers', 'action' => 'view', $order->driver->id]) : '' ?></td>
                <td><?= $order->has('customer_address') ? $this->Html->link($order->customer_address->id, ['controller' => 'CustomerAddresses', 'action' => 'view', $order->customer_address->id]) : '' ?></td>
                <td><?= $order->has('promotion_detail') ? $this->Html->link($order->promotion_detail->id, ['controller' => 'PromotionDetails', 'action' => 'view', $order->promotion_detail->id]) : '' ?></td>
                <td><?= h($order->order_no) ?></td>
                <td><?= h($order->ccavvenue_tracking_no) ?></td>
                <td><?= $this->Number->format($order->amount_from_wallet) ?></td>
                <td><?= $this->Number->format($order->total_amount) ?></td>
                <td><?= $this->Number->format($order->discount_percent) ?></td>
                <td><?= $this->Number->format($order->total_gst) ?></td>
                <td><?= $this->Number->format($order->grand_total) ?></td>
                <td><?= $this->Number->format($order->pay_amount) ?></td>
                <td><?= $this->Number->format($order->online_amount) ?></td>
                <td><?= $order->has('delivery_charge') ? $this->Html->link($order->delivery_charge->id, ['controller' => 'DeliveryCharges', 'action' => 'view', $order->delivery_charge->id]) : '' ?></td>
                <td><?= h($order->order_type) ?></td>
                <td><?= h($order->delivery_date) ?></td>
                <td><?= $order->has('delivery_time') ? $this->Html->link($order->delivery_time->id, ['controller' => 'DeliveryTimes', 'action' => 'view', $order->delivery_time->id]) : '' ?></td>
                <td><?= h($order->order_status) ?></td>
                <td><?= $order->has('cancel_reason') ? $this->Html->link($order->cancel_reason->id, ['controller' => 'CancelReasons', 'action' => 'view', $order->cancel_reason->id]) : '' ?></td>
                <td><?= h($order->order_date) ?></td>
                <td><?= h($order->payment_status) ?></td>
                <td><?= h($order->order_from) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $order->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $order->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete # {0}?', $order->id)]) ?>
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
