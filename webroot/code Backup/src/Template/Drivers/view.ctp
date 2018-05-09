<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Driver $driver
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Driver'), ['action' => 'edit', $driver->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Driver'), ['action' => 'delete', $driver->id], ['confirm' => __('Are you sure you want to delete # {0}?', $driver->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Drivers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Driver'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="drivers view large-9 medium-8 columns content">
    <h3><?= h($driver->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($driver->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Name') ?></th>
            <td><?= h($driver->user_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($driver->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mobile No') ?></th>
            <td><?= h($driver->mobile_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $driver->has('location') ? $this->Html->link($driver->location->name, ['controller' => 'Locations', 'action' => 'view', $driver->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Latitude') ?></th>
            <td><?= h($driver->latitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Longitude') ?></th>
            <td><?= h($driver->longitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($driver->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($driver->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Device Token') ?></h4>
        <?= $this->Text->autoParagraph(h($driver->device_token)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Orders') ?></h4>
        <?php if (!empty($driver->orders)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Sales Ledger Id') ?></th>
                <th scope="col"><?= __('Party Ledger Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Driver Id') ?></th>
                <th scope="col"><?= __('Customer Address Id') ?></th>
                <th scope="col"><?= __('Promotion Detail Id') ?></th>
                <th scope="col"><?= __('Order No') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Ccavvenue Tracking No') ?></th>
                <th scope="col"><?= __('Amount From Wallet') ?></th>
                <th scope="col"><?= __('Total Amount') ?></th>
                <th scope="col"><?= __('Discount Percent') ?></th>
                <th scope="col"><?= __('Total Gst') ?></th>
                <th scope="col"><?= __('Grand Total') ?></th>
                <th scope="col"><?= __('Pay Amount') ?></th>
                <th scope="col"><?= __('Online Amount') ?></th>
                <th scope="col"><?= __('Delivery Charge Id') ?></th>
                <th scope="col"><?= __('Order Type') ?></th>
                <th scope="col"><?= __('Delivery Date') ?></th>
                <th scope="col"><?= __('Delivery Time Id') ?></th>
                <th scope="col"><?= __('Order Status') ?></th>
                <th scope="col"><?= __('Cancel Reason Id') ?></th>
                <th scope="col"><?= __('Cancel Reason Other') ?></th>
                <th scope="col"><?= __('Cancel Date') ?></th>
                <th scope="col"><?= __('Order Date') ?></th>
                <th scope="col"><?= __('Payment Status') ?></th>
                <th scope="col"><?= __('Order From') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($driver->orders as $orders): ?>
            <tr>
                <td><?= h($orders->id) ?></td>
                <td><?= h($orders->location_id) ?></td>
                <td><?= h($orders->city_id) ?></td>
                <td><?= h($orders->sales_ledger_id) ?></td>
                <td><?= h($orders->party_ledger_id) ?></td>
                <td><?= h($orders->customer_id) ?></td>
                <td><?= h($orders->driver_id) ?></td>
                <td><?= h($orders->customer_address_id) ?></td>
                <td><?= h($orders->promotion_detail_id) ?></td>
                <td><?= h($orders->order_no) ?></td>
                <td><?= h($orders->voucher_no) ?></td>
                <td><?= h($orders->ccavvenue_tracking_no) ?></td>
                <td><?= h($orders->amount_from_wallet) ?></td>
                <td><?= h($orders->total_amount) ?></td>
                <td><?= h($orders->discount_percent) ?></td>
                <td><?= h($orders->total_gst) ?></td>
                <td><?= h($orders->grand_total) ?></td>
                <td><?= h($orders->pay_amount) ?></td>
                <td><?= h($orders->online_amount) ?></td>
                <td><?= h($orders->delivery_charge_id) ?></td>
                <td><?= h($orders->order_type) ?></td>
                <td><?= h($orders->delivery_date) ?></td>
                <td><?= h($orders->delivery_time_id) ?></td>
                <td><?= h($orders->order_status) ?></td>
                <td><?= h($orders->cancel_reason_id) ?></td>
                <td><?= h($orders->cancel_reason_other) ?></td>
                <td><?= h($orders->cancel_date) ?></td>
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
