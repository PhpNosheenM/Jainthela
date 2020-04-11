<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Challan[]|\Cake\Collection\CollectionInterface $challans
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Challan'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sellers'), ['controller' => 'Sellers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller'), ['controller' => 'Sellers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Financial Years'), ['controller' => 'FinancialYears', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Financial Year'), ['controller' => 'FinancialYears', 'action' => 'add']) ?></li>
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
        <li><?= $this->Html->link(__('List Challan Rows'), ['controller' => 'ChallanRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Challan Row'), ['controller' => 'ChallanRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="challans index large-9 medium-8 columns content">
    <h3><?= __('Challans') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('seller_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('seller_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('financial_year_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_ledger_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('party_ledger_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('driver_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_address_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('promotion_detail_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ccavvenue_tracking_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount_from_wallet') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_percent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_gst') ?></th>
                <th scope="col"><?= $this->Paginator->sort('grand_total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('round_off') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pay_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('due_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('online_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delivery_charge_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delivery_charge_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delivery_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delivery_time_sloat') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delivery_time_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cancel_reason_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cancel_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment_status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_from') ?></th>
                <th scope="col"><?= $this->Paginator->sort('packing_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('packing_flag') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dispatch_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dispatch_flag') ?></th>
                <th scope="col"><?= $this->Paginator->sort('otp') ?></th>
                <th scope="col"><?= $this->Paginator->sort('otp_confirmation') ?></th>
                <th scope="col"><?= $this->Paginator->sort('not_received') ?></th>
                <th scope="col"><?= $this->Paginator->sort('online_return_amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($challans as $challan): ?>
            <tr>
                <td><?= $this->Number->format($challan->id) ?></td>
                <td><?= $challan->has('order') ? $this->Html->link($challan->order->id, ['controller' => 'Orders', 'action' => 'view', $challan->order->id]) : '' ?></td>
                <td><?= $challan->has('location') ? $this->Html->link($challan->location->name, ['controller' => 'Locations', 'action' => 'view', $challan->location->id]) : '' ?></td>
                <td><?= $challan->has('seller') ? $this->Html->link($challan->seller->name, ['controller' => 'Sellers', 'action' => 'view', $challan->seller->id]) : '' ?></td>
                <td><?= h($challan->seller_name) ?></td>
                <td><?= $challan->has('financial_year') ? $this->Html->link($challan->financial_year->id, ['controller' => 'FinancialYears', 'action' => 'view', $challan->financial_year->id]) : '' ?></td>
                <td><?= $challan->has('city') ? $this->Html->link($challan->city->name, ['controller' => 'Cities', 'action' => 'view', $challan->city->id]) : '' ?></td>
                <td><?= $this->Number->format($challan->sales_ledger_id) ?></td>
                <td><?= $challan->has('party_ledger') ? $this->Html->link($challan->party_ledger->name, ['controller' => 'Ledgers', 'action' => 'view', $challan->party_ledger->id]) : '' ?></td>
                <td><?= $challan->has('customer') ? $this->Html->link($challan->customer->name, ['controller' => 'Customers', 'action' => 'view', $challan->customer->id]) : '' ?></td>
                <td><?= $challan->has('driver') ? $this->Html->link($challan->driver->name, ['controller' => 'Drivers', 'action' => 'view', $challan->driver->id]) : '' ?></td>
                <td><?= $challan->has('customer_address') ? $this->Html->link($challan->customer_address->id, ['controller' => 'CustomerAddresses', 'action' => 'view', $challan->customer_address->id]) : '' ?></td>
                <td><?= $challan->has('promotion_detail') ? $this->Html->link($challan->promotion_detail->id, ['controller' => 'PromotionDetails', 'action' => 'view', $challan->promotion_detail->id]) : '' ?></td>
                <td><?= h($challan->invoice_no) ?></td>
                <td><?= $this->Number->format($challan->voucher_no) ?></td>
                <td><?= h($challan->ccavvenue_tracking_no) ?></td>
                <td><?= $this->Number->format($challan->amount_from_wallet) ?></td>
                <td><?= $this->Number->format($challan->total_amount) ?></td>
                <td><?= $this->Number->format($challan->discount_percent) ?></td>
                <td><?= $this->Number->format($challan->discount_amount) ?></td>
                <td><?= $this->Number->format($challan->total_gst) ?></td>
                <td><?= $this->Number->format($challan->grand_total) ?></td>
                <td><?= $this->Number->format($challan->round_off) ?></td>
                <td><?= $this->Number->format($challan->pay_amount) ?></td>
                <td><?= $this->Number->format($challan->due_amount) ?></td>
                <td><?= $this->Number->format($challan->online_amount) ?></td>
                <td><?= $challan->has('delivery_charge') ? $this->Html->link($challan->delivery_charge->id, ['controller' => 'DeliveryCharges', 'action' => 'view', $challan->delivery_charge->id]) : '' ?></td>
                <td><?= h($challan->delivery_charge_amount) ?></td>
                <td><?= h($challan->order_type) ?></td>
                <td><?= h($challan->delivery_date) ?></td>
                <td><?= h($challan->delivery_time_sloat) ?></td>
                <td><?= $challan->has('delivery_time') ? $this->Html->link($challan->delivery_time->id, ['controller' => 'DeliveryTimes', 'action' => 'view', $challan->delivery_time->id]) : '' ?></td>
                <td><?= h($challan->order_status) ?></td>
                <td><?= $challan->has('cancel_reason') ? $this->Html->link($challan->cancel_reason->reason, ['controller' => 'CancelReasons', 'action' => 'view', $challan->cancel_reason->id]) : '' ?></td>
                <td><?= h($challan->cancel_date) ?></td>
                <td><?= h($challan->transaction_date) ?></td>
                <td><?= h($challan->order_date) ?></td>
                <td><?= h($challan->payment_status) ?></td>
                <td><?= h($challan->order_from) ?></td>
                <td><?= h($challan->packing_on) ?></td>
                <td><?= h($challan->packing_flag) ?></td>
                <td><?= h($challan->dispatch_on) ?></td>
                <td><?= h($challan->dispatch_flag) ?></td>
                <td><?= h($challan->otp) ?></td>
                <td><?= h($challan->otp_confirmation) ?></td>
                <td><?= h($challan->not_received) ?></td>
                <td><?= $this->Number->format($challan->online_return_amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $challan->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $challan->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $challan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challan->id)]) ?>
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
