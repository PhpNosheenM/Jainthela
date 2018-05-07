<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PromotionDetail $promotionDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Promotion Detail'), ['action' => 'edit', $promotionDetail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Promotion Detail'), ['action' => 'delete', $promotionDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $promotionDetail->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Promotion Details'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Promotion Detail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Promotions'), ['controller' => 'Promotions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Promotion'), ['controller' => 'Promotions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="promotionDetails view large-9 medium-8 columns content">
    <h3><?= h($promotionDetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Promotion') ?></th>
            <td><?= $promotionDetail->has('promotion') ? $this->Html->link($promotionDetail->promotion->id, ['controller' => 'Promotions', 'action' => 'view', $promotionDetail->promotion->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= $promotionDetail->has('category') ? $this->Html->link($promotionDetail->category->name, ['controller' => 'Categories', 'action' => 'view', $promotionDetail->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $promotionDetail->has('item') ? $this->Html->link($promotionDetail->item->name, ['controller' => 'Items', 'action' => 'view', $promotionDetail->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Coupan Name') ?></th>
            <td><?= h($promotionDetail->coupan_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('In Wallet') ?></th>
            <td><?= h($promotionDetail->in_wallet) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Free Shipping') ?></th>
            <td><?= h($promotionDetail->is_free_shipping) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($promotionDetail->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount In Percentage') ?></th>
            <td><?= $this->Number->format($promotionDetail->discount_in_percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount In Amount') ?></th>
            <td><?= $this->Number->format($promotionDetail->discount_in_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Of Max Amount') ?></th>
            <td><?= $this->Number->format($promotionDetail->discount_of_max_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Coupan Code') ?></th>
            <td><?= $this->Number->format($promotionDetail->coupan_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Buy Quntity') ?></th>
            <td><?= $this->Number->format($promotionDetail->buy_quntity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Get Quntity') ?></th>
            <td><?= $this->Number->format($promotionDetail->get_quntity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Get Item Id') ?></th>
            <td><?= $this->Number->format($promotionDetail->get_item_id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Orders') ?></h4>
        <?php if (!empty($promotionDetail->orders)): ?>
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
            <?php foreach ($promotionDetail->orders as $orders): ?>
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
