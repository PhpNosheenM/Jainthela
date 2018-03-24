<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Order'), ['action' => 'edit', $order->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Order'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete # {0}?', $order->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Drivers'), ['controller' => 'Drivers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Driver'), ['controller' => 'Drivers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customer Addresses'), ['controller' => 'CustomerAddresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer Address'), ['controller' => 'CustomerAddresses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Promotion Details'), ['controller' => 'PromotionDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Promotion Detail'), ['controller' => 'PromotionDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Delivery Charges'), ['controller' => 'DeliveryCharges', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Delivery Charge'), ['controller' => 'DeliveryCharges', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Delivery Times'), ['controller' => 'DeliveryTimes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Delivery Time'), ['controller' => 'DeliveryTimes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cancel Reasons'), ['controller' => 'CancelReasons', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cancel Reason'), ['controller' => 'CancelReasons', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Order Details'), ['controller' => 'OrderDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order Detail'), ['controller' => 'OrderDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wallets'), ['controller' => 'Wallets', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wallet'), ['controller' => 'Wallets', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="orders view large-9 medium-8 columns content">
    <h3><?= h($order->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $order->has('location') ? $this->Html->link($order->location->name, ['controller' => 'Locations', 'action' => 'view', $order->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $order->has('customer') ? $this->Html->link($order->customer->name, ['controller' => 'Customers', 'action' => 'view', $order->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Driver') ?></th>
            <td><?= $order->has('driver') ? $this->Html->link($order->driver->name, ['controller' => 'Drivers', 'action' => 'view', $order->driver->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer Address') ?></th>
            <td><?= $order->has('customer_address') ? $this->Html->link($order->customer_address->id, ['controller' => 'CustomerAddresses', 'action' => 'view', $order->customer_address->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Promotion Detail') ?></th>
            <td><?= $order->has('promotion_detail') ? $this->Html->link($order->promotion_detail->id, ['controller' => 'PromotionDetails', 'action' => 'view', $order->promotion_detail->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order No') ?></th>
            <td><?= h($order->order_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ccavvenue Tracking No') ?></th>
            <td><?= h($order->ccavvenue_tracking_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delivery Charge') ?></th>
            <td><?= $order->has('delivery_charge') ? $this->Html->link($order->delivery_charge->id, ['controller' => 'DeliveryCharges', 'action' => 'view', $order->delivery_charge->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Type') ?></th>
            <td><?= h($order->order_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delivery Time') ?></th>
            <td><?= $order->has('delivery_time') ? $this->Html->link($order->delivery_time->id, ['controller' => 'DeliveryTimes', 'action' => 'view', $order->delivery_time->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Status') ?></th>
            <td><?= h($order->order_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cancel Reason') ?></th>
            <td><?= $order->has('cancel_reason') ? $this->Html->link($order->cancel_reason->id, ['controller' => 'CancelReasons', 'action' => 'view', $order->cancel_reason->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Status') ?></th>
            <td><?= h($order->payment_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order From') ?></th>
            <td><?= h($order->order_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($order->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount From Wallet') ?></th>
            <td><?= $this->Number->format($order->amount_from_wallet) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Amount') ?></th>
            <td><?= $this->Number->format($order->total_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Percent') ?></th>
            <td><?= $this->Number->format($order->discount_percent) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Gst') ?></th>
            <td><?= $this->Number->format($order->total_gst) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Grand Total') ?></th>
            <td><?= $this->Number->format($order->grand_total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pay Amount') ?></th>
            <td><?= $this->Number->format($order->pay_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Online Amount') ?></th>
            <td><?= $this->Number->format($order->online_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delivery Date') ?></th>
            <td><?= h($order->delivery_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Date') ?></th>
            <td><?= h($order->order_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Order Details') ?></h4>
        <?php if (!empty($order->order_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Order Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Combo Offer Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($order->order_details as $orderDetails): ?>
            <tr>
                <td><?= h($orderDetails->id) ?></td>
                <td><?= h($orderDetails->order_id) ?></td>
                <td><?= h($orderDetails->item_variation_id) ?></td>
                <td><?= h($orderDetails->combo_offer_id) ?></td>
                <td><?= h($orderDetails->quantity) ?></td>
                <td><?= h($orderDetails->rate) ?></td>
                <td><?= h($orderDetails->amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'OrderDetails', 'action' => 'view', $orderDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'OrderDetails', 'action' => 'edit', $orderDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'OrderDetails', 'action' => 'delete', $orderDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Wallets') ?></h4>
        <?php if (!empty($order->wallets)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Order Id') ?></th>
                <th scope="col"><?= __('Plan Id') ?></th>
                <th scope="col"><?= __('Promotion Id') ?></th>
                <th scope="col"><?= __('Add Amount') ?></th>
                <th scope="col"><?= __('Used Amount') ?></th>
                <th scope="col"><?= __('Cancel To Wallet Online') ?></th>
                <th scope="col"><?= __('Narration') ?></th>
                <th scope="col"><?= __('Return Order Id') ?></th>
                <th scope="col"><?= __('Amount Type') ?></th>
                <th scope="col"><?= __('Transaction Type') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($order->wallets as $wallets): ?>
            <tr>
                <td><?= h($wallets->id) ?></td>
                <td><?= h($wallets->city_id) ?></td>
                <td><?= h($wallets->customer_id) ?></td>
                <td><?= h($wallets->order_id) ?></td>
                <td><?= h($wallets->plan_id) ?></td>
                <td><?= h($wallets->promotion_id) ?></td>
                <td><?= h($wallets->add_amount) ?></td>
                <td><?= h($wallets->used_amount) ?></td>
                <td><?= h($wallets->cancel_to_wallet_online) ?></td>
                <td><?= h($wallets->narration) ?></td>
                <td><?= h($wallets->return_order_id) ?></td>
                <td><?= h($wallets->amount_type) ?></td>
                <td><?= h($wallets->transaction_type) ?></td>
                <td><?= h($wallets->created_on) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Wallets', 'action' => 'view', $wallets->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Wallets', 'action' => 'edit', $wallets->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Wallets', 'action' => 'delete', $wallets->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wallets->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
