<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SalesOrder $salesOrder
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sales Order'), ['action' => 'edit', $salesOrder->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sales Order'), ['action' => 'delete', $salesOrder->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesOrder->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sales Orders'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Order'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Party Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Party Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
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
        <li><?= $this->Html->link(__('List Sales Order Rows'), ['controller' => 'SalesOrderRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Order Row'), ['controller' => 'SalesOrderRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="salesOrders view large-9 medium-8 columns content">
    <h3><?= h($salesOrder->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $salesOrder->has('location') ? $this->Html->link($salesOrder->location->name, ['controller' => 'Locations', 'action' => 'view', $salesOrder->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $salesOrder->has('city') ? $this->Html->link($salesOrder->city->name, ['controller' => 'Cities', 'action' => 'view', $salesOrder->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Party Ledger') ?></th>
            <td><?= $salesOrder->has('party_ledger') ? $this->Html->link($salesOrder->party_ledger->name, ['controller' => 'Ledgers', 'action' => 'view', $salesOrder->party_ledger->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $salesOrder->has('customer') ? $this->Html->link($salesOrder->customer->name, ['controller' => 'Customers', 'action' => 'view', $salesOrder->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Driver') ?></th>
            <td><?= $salesOrder->has('driver') ? $this->Html->link($salesOrder->driver->name, ['controller' => 'Drivers', 'action' => 'view', $salesOrder->driver->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer Address') ?></th>
            <td><?= $salesOrder->has('customer_address') ? $this->Html->link($salesOrder->customer_address->id, ['controller' => 'CustomerAddresses', 'action' => 'view', $salesOrder->customer_address->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Promotion Detail') ?></th>
            <td><?= $salesOrder->has('promotion_detail') ? $this->Html->link($salesOrder->promotion_detail->id, ['controller' => 'PromotionDetails', 'action' => 'view', $salesOrder->promotion_detail->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Order No') ?></th>
            <td><?= h($salesOrder->sales_order_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ccavvenue Tracking No') ?></th>
            <td><?= h($salesOrder->ccavvenue_tracking_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delivery Charge') ?></th>
            <td><?= $salesOrder->has('delivery_charge') ? $this->Html->link($salesOrder->delivery_charge->id, ['controller' => 'DeliveryCharges', 'action' => 'view', $salesOrder->delivery_charge->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Order Type') ?></th>
            <td><?= h($salesOrder->sales_order_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delivery Time') ?></th>
            <td><?= $salesOrder->has('delivery_time') ? $this->Html->link($salesOrder->delivery_time->id, ['controller' => 'DeliveryTimes', 'action' => 'view', $salesOrder->delivery_time->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Order Status') ?></th>
            <td><?= h($salesOrder->sales_order_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cancel Reason') ?></th>
            <td><?= $salesOrder->has('cancel_reason') ? $this->Html->link($salesOrder->cancel_reason->id, ['controller' => 'CancelReasons', 'action' => 'view', $salesOrder->cancel_reason->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Status') ?></th>
            <td><?= h($salesOrder->payment_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Order From') ?></th>
            <td><?= h($salesOrder->sales_order_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($salesOrder->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Ledger Id') ?></th>
            <td><?= $this->Number->format($salesOrder->sales_ledger_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voucher No') ?></th>
            <td><?= $this->Number->format($salesOrder->voucher_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount From Wallet') ?></th>
            <td><?= $this->Number->format($salesOrder->amount_from_wallet) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Amount') ?></th>
            <td><?= $this->Number->format($salesOrder->total_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Percent') ?></th>
            <td><?= $this->Number->format($salesOrder->discount_percent) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Gst') ?></th>
            <td><?= $this->Number->format($salesOrder->total_gst) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Grand Total') ?></th>
            <td><?= $this->Number->format($salesOrder->grand_total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pay Amount') ?></th>
            <td><?= $this->Number->format($salesOrder->pay_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Online Amount') ?></th>
            <td><?= $this->Number->format($salesOrder->online_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delivery Date') ?></th>
            <td><?= h($salesOrder->delivery_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cancel Date') ?></th>
            <td><?= h($salesOrder->cancel_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($salesOrder->transaction_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Order Date') ?></th>
            <td><?= h($salesOrder->sales_order_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Cancel Reason Other') ?></h4>
        <?= $this->Text->autoParagraph(h($salesOrder->cancel_reason_other)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sales Order Rows') ?></h4>
        <?php if (!empty($salesOrder->sales_order_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Sales Order Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Combo Offer Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Gst Percentage') ?></th>
                <th scope="col"><?= __('Gst Figure Id') ?></th>
                <th scope="col"><?= __('Gst Value') ?></th>
                <th scope="col"><?= __('Net Amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($salesOrder->sales_order_rows as $salesOrderRows): ?>
            <tr>
                <td><?= h($salesOrderRows->id) ?></td>
                <td><?= h($salesOrderRows->sales_order_id) ?></td>
                <td><?= h($salesOrderRows->item_id) ?></td>
                <td><?= h($salesOrderRows->item_variation_id) ?></td>
                <td><?= h($salesOrderRows->combo_offer_id) ?></td>
                <td><?= h($salesOrderRows->quantity) ?></td>
                <td><?= h($salesOrderRows->rate) ?></td>
                <td><?= h($salesOrderRows->amount) ?></td>
                <td><?= h($salesOrderRows->gst_percentage) ?></td>
                <td><?= h($salesOrderRows->gst_figure_id) ?></td>
                <td><?= h($salesOrderRows->gst_value) ?></td>
                <td><?= h($salesOrderRows->net_amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SalesOrderRows', 'action' => 'view', $salesOrderRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SalesOrderRows', 'action' => 'edit', $salesOrderRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SalesOrderRows', 'action' => 'delete', $salesOrderRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesOrderRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
