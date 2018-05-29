<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SalesOrder[]|\Cake\Collection\CollectionInterface $salesOrders
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Sales Order'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Party Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Party Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?></li>
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
        <li><?= $this->Html->link(__('List Sales Order Rows'), ['controller' => 'SalesOrderRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sales Order Row'), ['controller' => 'SalesOrderRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="salesOrders index large-9 medium-8 columns content">
    <h3><?= __('Sales Orders') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_ledger_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('party_ledger_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('driver_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_address_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('promotion_detail_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_order_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ccavvenue_tracking_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount_from_wallet') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_percent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_gst') ?></th>
                <th scope="col"><?= $this->Paginator->sort('grand_total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pay_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('online_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delivery_charge_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_order_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delivery_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delivery_time_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_order_status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cancel_reason_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cancel_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_order_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment_status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_order_from') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salesOrders as $salesOrder): ?>
            <tr>
                <td><?= $this->Number->format($salesOrder->id) ?></td>
                <td><?= $salesOrder->has('location') ? $this->Html->link($salesOrder->location->name, ['controller' => 'Locations', 'action' => 'view', $salesOrder->location->id]) : '' ?></td>
                <td><?= $salesOrder->has('city') ? $this->Html->link($salesOrder->city->name, ['controller' => 'Cities', 'action' => 'view', $salesOrder->city->id]) : '' ?></td>
                <td><?= $this->Number->format($salesOrder->sales_ledger_id) ?></td>
                <td><?= $salesOrder->has('party_ledger') ? $this->Html->link($salesOrder->party_ledger->name, ['controller' => 'Ledgers', 'action' => 'view', $salesOrder->party_ledger->id]) : '' ?></td>
                <td><?= $salesOrder->has('customer') ? $this->Html->link($salesOrder->customer->name, ['controller' => 'Customers', 'action' => 'view', $salesOrder->customer->id]) : '' ?></td>
                <td><?= $salesOrder->has('driver') ? $this->Html->link($salesOrder->driver->name, ['controller' => 'Drivers', 'action' => 'view', $salesOrder->driver->id]) : '' ?></td>
                <td><?= $salesOrder->has('customer_address') ? $this->Html->link($salesOrder->customer_address->id, ['controller' => 'CustomerAddresses', 'action' => 'view', $salesOrder->customer_address->id]) : '' ?></td>
                <td><?= $salesOrder->has('promotion_detail') ? $this->Html->link($salesOrder->promotion_detail->id, ['controller' => 'PromotionDetails', 'action' => 'view', $salesOrder->promotion_detail->id]) : '' ?></td>
                <td><?= h($salesOrder->sales_order_no) ?></td>
                <td><?= $this->Number->format($salesOrder->voucher_no) ?></td>
                <td><?= h($salesOrder->ccavvenue_tracking_no) ?></td>
                <td><?= $this->Number->format($salesOrder->amount_from_wallet) ?></td>
                <td><?= $this->Number->format($salesOrder->total_amount) ?></td>
                <td><?= $this->Number->format($salesOrder->discount_percent) ?></td>
                <td><?= $this->Number->format($salesOrder->total_gst) ?></td>
                <td><?= $this->Number->format($salesOrder->grand_total) ?></td>
                <td><?= $this->Number->format($salesOrder->pay_amount) ?></td>
                <td><?= $this->Number->format($salesOrder->online_amount) ?></td>
                <td><?= $salesOrder->has('delivery_charge') ? $this->Html->link($salesOrder->delivery_charge->id, ['controller' => 'DeliveryCharges', 'action' => 'view', $salesOrder->delivery_charge->id]) : '' ?></td>
                <td><?= h($salesOrder->sales_order_type) ?></td>
                <td><?= h($salesOrder->delivery_date) ?></td>
                <td><?= $salesOrder->has('delivery_time') ? $this->Html->link($salesOrder->delivery_time->id, ['controller' => 'DeliveryTimes', 'action' => 'view', $salesOrder->delivery_time->id]) : '' ?></td>
                <td><?= h($salesOrder->sales_order_status) ?></td>
                <td><?= $salesOrder->has('cancel_reason') ? $this->Html->link($salesOrder->cancel_reason->id, ['controller' => 'CancelReasons', 'action' => 'view', $salesOrder->cancel_reason->id]) : '' ?></td>
                <td><?= h($salesOrder->cancel_date) ?></td>
                <td><?= h($salesOrder->transaction_date) ?></td>
                <td><?= h($salesOrder->sales_order_date) ?></td>
                <td><?= h($salesOrder->payment_status) ?></td>
                <td><?= h($salesOrder->sales_order_from) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $salesOrder->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $salesOrder->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $salesOrder->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesOrder->id)]) ?>
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
