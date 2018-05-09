<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Customer'), ['action' => 'edit', $customer->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Customer'), ['action' => 'delete', $customer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customer->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List App Notification Customers'), ['controller' => 'AppNotificationCustomers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New App Notification Customer'), ['controller' => 'AppNotificationCustomers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bulk Booking Leads'), ['controller' => 'BulkBookingLeads', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bulk Booking Lead'), ['controller' => 'BulkBookingLeads', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Carts'), ['controller' => 'Carts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cart'), ['controller' => 'Carts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customer Addresses'), ['controller' => 'CustomerAddresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer Address'), ['controller' => 'CustomerAddresses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Feedbacks'), ['controller' => 'Feedbacks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feedback'), ['controller' => 'Feedbacks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reference Details'), ['controller' => 'ReferenceDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['controller' => 'ReferenceDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['controller' => 'SaleReturns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return'), ['controller' => 'SaleReturns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Invoices'), ['controller' => 'SalesInvoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Invoice'), ['controller' => 'SalesInvoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Seller Ratings'), ['controller' => 'SellerRatings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller Rating'), ['controller' => 'SellerRatings', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wallets'), ['controller' => 'Wallets', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wallet'), ['controller' => 'Wallets', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="customers view large-9 medium-8 columns content">
    <h3><?= h($customer->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $customer->has('city') ? $this->Html->link($customer->city->name, ['controller' => 'Cities', 'action' => 'view', $customer->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($customer->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($customer->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($customer->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($customer->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Latitude') ?></th>
            <td><?= h($customer->latitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Longitude') ?></th>
            <td><?= h($customer->longitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Referral Code') ?></th>
            <td><?= h($customer->referral_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Otp') ?></th>
            <td><?= h($customer->otp) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gstin') ?></th>
            <td><?= h($customer->gstin) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gstin Holder Name') ?></th>
            <td><?= h($customer->gstin_holder_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Firm Name') ?></th>
            <td><?= h($customer->firm_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($customer->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount In Percentage') ?></th>
            <td><?= $this->Number->format($customer->discount_in_percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Timeout') ?></th>
            <td><?= $this->Number->format($customer->timeout) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($customer->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $this->Number->format($customer->active) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($customer->created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Created On') ?></th>
            <td><?= h($customer->discount_created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Expiry') ?></th>
            <td><?= h($customer->discount_expiry) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Device Id Name') ?></h4>
        <?= $this->Text->autoParagraph(h($customer->device_id_name)); ?>
    </div>
    <div class="row">
        <h4><?= __('Device Token') ?></h4>
        <?= $this->Text->autoParagraph(h($customer->device_token)); ?>
    </div>
    <div class="row">
        <h4><?= __('Gstin Holder Address') ?></h4>
        <?= $this->Text->autoParagraph(h($customer->gstin_holder_address)); ?>
    </div>
    <div class="row">
        <h4><?= __('Firm Address') ?></h4>
        <?= $this->Text->autoParagraph(h($customer->firm_address)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related App Notification Customers') ?></h4>
        <?php if (!empty($customer->app_notification_customers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('App Notification Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Sent') ?></th>
                <th scope="col"><?= __('Send On') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customer->app_notification_customers as $appNotificationCustomers): ?>
            <tr>
                <td><?= h($appNotificationCustomers->id) ?></td>
                <td><?= h($appNotificationCustomers->app_notification_id) ?></td>
                <td><?= h($appNotificationCustomers->customer_id) ?></td>
                <td><?= h($appNotificationCustomers->sent) ?></td>
                <td><?= h($appNotificationCustomers->send_on) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AppNotificationCustomers', 'action' => 'view', $appNotificationCustomers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AppNotificationCustomers', 'action' => 'edit', $appNotificationCustomers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AppNotificationCustomers', 'action' => 'delete', $appNotificationCustomers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $appNotificationCustomers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Bulk Booking Leads') ?></h4>
        <?php if (!empty($customer->bulk_booking_leads)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Lead No') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Mobile') ?></th>
                <th scope="col"><?= __('Lead Description') ?></th>
                <th scope="col"><?= __('Delivery Date') ?></th>
                <th scope="col"><?= __('Delivery Time') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Reason') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customer->bulk_booking_leads as $bulkBookingLeads): ?>
            <tr>
                <td><?= h($bulkBookingLeads->id) ?></td>
                <td><?= h($bulkBookingLeads->city_id) ?></td>
                <td><?= h($bulkBookingLeads->customer_id) ?></td>
                <td><?= h($bulkBookingLeads->lead_no) ?></td>
                <td><?= h($bulkBookingLeads->name) ?></td>
                <td><?= h($bulkBookingLeads->mobile) ?></td>
                <td><?= h($bulkBookingLeads->lead_description) ?></td>
                <td><?= h($bulkBookingLeads->delivery_date) ?></td>
                <td><?= h($bulkBookingLeads->delivery_time) ?></td>
                <td><?= h($bulkBookingLeads->created_on) ?></td>
                <td><?= h($bulkBookingLeads->status) ?></td>
                <td><?= h($bulkBookingLeads->reason) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'BulkBookingLeads', 'action' => 'view', $bulkBookingLeads->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'BulkBookingLeads', 'action' => 'edit', $bulkBookingLeads->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'BulkBookingLeads', 'action' => 'delete', $bulkBookingLeads->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bulkBookingLeads->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Carts') ?></h4>
        <?php if (!empty($customer->carts)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Combo Offer Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Cart Count') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customer->carts as $carts): ?>
            <tr>
                <td><?= h($carts->id) ?></td>
                <td><?= h($carts->city_id) ?></td>
                <td><?= h($carts->customer_id) ?></td>
                <td><?= h($carts->item_id) ?></td>
                <td><?= h($carts->combo_offer_id) ?></td>
                <td><?= h($carts->quantity) ?></td>
                <td><?= h($carts->rate) ?></td>
                <td><?= h($carts->amount) ?></td>
                <td><?= h($carts->cart_count) ?></td>
                <td><?= h($carts->created_on) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Carts', 'action' => 'view', $carts->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Carts', 'action' => 'edit', $carts->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Carts', 'action' => 'delete', $carts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carts->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Customer Addresses') ?></h4>
        <?php if (!empty($customer->customer_addresses)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Pincode') ?></th>
                <th scope="col"><?= __('House No') ?></th>
                <th scope="col"><?= __('Address') ?></th>
                <th scope="col"><?= __('Landmark') ?></th>
                <th scope="col"><?= __('Latitude') ?></th>
                <th scope="col"><?= __('Longitude') ?></th>
                <th scope="col"><?= __('Default Address') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customer->customer_addresses as $customerAddresses): ?>
            <tr>
                <td><?= h($customerAddresses->id) ?></td>
                <td><?= h($customerAddresses->customer_id) ?></td>
                <td><?= h($customerAddresses->city_id) ?></td>
                <td><?= h($customerAddresses->location_id) ?></td>
                <td><?= h($customerAddresses->pincode) ?></td>
                <td><?= h($customerAddresses->house_no) ?></td>
                <td><?= h($customerAddresses->address) ?></td>
                <td><?= h($customerAddresses->landmark) ?></td>
                <td><?= h($customerAddresses->latitude) ?></td>
                <td><?= h($customerAddresses->longitude) ?></td>
                <td><?= h($customerAddresses->default_address) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CustomerAddresses', 'action' => 'view', $customerAddresses->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CustomerAddresses', 'action' => 'edit', $customerAddresses->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CustomerAddresses', 'action' => 'delete', $customerAddresses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerAddresses->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Feedbacks') ?></h4>
        <?php if (!empty($customer->feedbacks)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Mobile No') ?></th>
                <th scope="col"><?= __('Comment') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customer->feedbacks as $feedbacks): ?>
            <tr>
                <td><?= h($feedbacks->id) ?></td>
                <td><?= h($feedbacks->admin_id) ?></td>
                <td><?= h($feedbacks->customer_id) ?></td>
                <td><?= h($feedbacks->name) ?></td>
                <td><?= h($feedbacks->email) ?></td>
                <td><?= h($feedbacks->mobile_no) ?></td>
                <td><?= h($feedbacks->comment) ?></td>
                <td><?= h($feedbacks->created_on) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Feedbacks', 'action' => 'view', $feedbacks->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Feedbacks', 'action' => 'edit', $feedbacks->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Feedbacks', 'action' => 'delete', $feedbacks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feedbacks->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Ledgers') ?></h4>
        <?php if (!empty($customer->ledgers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Accounting Group Id') ?></th>
                <th scope="col"><?= __('Freeze') ?></th>
                <th scope="col"><?= __('Company Id') ?></th>
                <th scope="col"><?= __('Supplier Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Tax Percentage') ?></th>
                <th scope="col"><?= __('Gst Type') ?></th>
                <th scope="col"><?= __('Input Output') ?></th>
                <th scope="col"><?= __('Gst Figure Id') ?></th>
                <th scope="col"><?= __('Bill To Bill Accounting') ?></th>
                <th scope="col"><?= __('Round Off') ?></th>
                <th scope="col"><?= __('Cash') ?></th>
                <th scope="col"><?= __('Flag') ?></th>
                <th scope="col"><?= __('Default Credit Days') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customer->ledgers as $ledgers): ?>
            <tr>
                <td><?= h($ledgers->id) ?></td>
                <td><?= h($ledgers->name) ?></td>
                <td><?= h($ledgers->accounting_group_id) ?></td>
                <td><?= h($ledgers->freeze) ?></td>
                <td><?= h($ledgers->company_id) ?></td>
                <td><?= h($ledgers->supplier_id) ?></td>
                <td><?= h($ledgers->customer_id) ?></td>
                <td><?= h($ledgers->tax_percentage) ?></td>
                <td><?= h($ledgers->gst_type) ?></td>
                <td><?= h($ledgers->input_output) ?></td>
                <td><?= h($ledgers->gst_figure_id) ?></td>
                <td><?= h($ledgers->bill_to_bill_accounting) ?></td>
                <td><?= h($ledgers->round_off) ?></td>
                <td><?= h($ledgers->cash) ?></td>
                <td><?= h($ledgers->flag) ?></td>
                <td><?= h($ledgers->default_credit_days) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Ledgers', 'action' => 'view', $ledgers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Ledgers', 'action' => 'edit', $ledgers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Ledgers', 'action' => 'delete', $ledgers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ledgers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Orders') ?></h4>
        <?php if (!empty($customer->orders)): ?>
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
            <?php foreach ($customer->orders as $orders): ?>
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
    <div class="related">
        <h4><?= __('Related Reference Details') ?></h4>
        <?php if (!empty($customer->reference_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Supplier Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Ledger Id') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Ref Name') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Receipt Id') ?></th>
                <th scope="col"><?= __('Receipt Row Id') ?></th>
                <th scope="col"><?= __('Payment Row Id') ?></th>
                <th scope="col"><?= __('Credit Note Id') ?></th>
                <th scope="col"><?= __('Credit Note Row Id') ?></th>
                <th scope="col"><?= __('Debit Note Id') ?></th>
                <th scope="col"><?= __('Debit Note Row Id') ?></th>
                <th scope="col"><?= __('Sales Voucher Row Id') ?></th>
                <th scope="col"><?= __('Purchase Voucher Row Id') ?></th>
                <th scope="col"><?= __('Journal Voucher Row Id') ?></th>
                <th scope="col"><?= __('Sale Return Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Id') ?></th>
                <th scope="col"><?= __('Purchase Return Id') ?></th>
                <th scope="col"><?= __('Sales Invoice Id') ?></th>
                <th scope="col"><?= __('Opening Balance') ?></th>
                <th scope="col"><?= __('Due Days') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customer->reference_details as $referenceDetails): ?>
            <tr>
                <td><?= h($referenceDetails->id) ?></td>
                <td><?= h($referenceDetails->customer_id) ?></td>
                <td><?= h($referenceDetails->supplier_id) ?></td>
                <td><?= h($referenceDetails->transaction_date) ?></td>
                <td><?= h($referenceDetails->location_id) ?></td>
                <td><?= h($referenceDetails->ledger_id) ?></td>
                <td><?= h($referenceDetails->type) ?></td>
                <td><?= h($referenceDetails->ref_name) ?></td>
                <td><?= h($referenceDetails->debit) ?></td>
                <td><?= h($referenceDetails->credit) ?></td>
                <td><?= h($referenceDetails->receipt_id) ?></td>
                <td><?= h($referenceDetails->receipt_row_id) ?></td>
                <td><?= h($referenceDetails->payment_row_id) ?></td>
                <td><?= h($referenceDetails->credit_note_id) ?></td>
                <td><?= h($referenceDetails->credit_note_row_id) ?></td>
                <td><?= h($referenceDetails->debit_note_id) ?></td>
                <td><?= h($referenceDetails->debit_note_row_id) ?></td>
                <td><?= h($referenceDetails->sales_voucher_row_id) ?></td>
                <td><?= h($referenceDetails->purchase_voucher_row_id) ?></td>
                <td><?= h($referenceDetails->journal_voucher_row_id) ?></td>
                <td><?= h($referenceDetails->sale_return_id) ?></td>
                <td><?= h($referenceDetails->purchase_invoice_id) ?></td>
                <td><?= h($referenceDetails->purchase_return_id) ?></td>
                <td><?= h($referenceDetails->sales_invoice_id) ?></td>
                <td><?= h($referenceDetails->opening_balance) ?></td>
                <td><?= h($referenceDetails->due_days) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ReferenceDetails', 'action' => 'view', $referenceDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ReferenceDetails', 'action' => 'edit', $referenceDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ReferenceDetails', 'action' => 'delete', $referenceDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $referenceDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sale Returns') ?></h4>
        <?php if (!empty($customer->sale_returns)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Amount Before Tax') ?></th>
                <th scope="col"><?= __('Total Cgst') ?></th>
                <th scope="col"><?= __('Total Sgst') ?></th>
                <th scope="col"><?= __('Total Igst') ?></th>
                <th scope="col"><?= __('Amount After Tax') ?></th>
                <th scope="col"><?= __('Round Off') ?></th>
                <th scope="col"><?= __('Sales Ledger Id') ?></th>
                <th scope="col"><?= __('Party Ledger Id') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Sales Invoice Id') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customer->sale_returns as $saleReturns): ?>
            <tr>
                <td><?= h($saleReturns->id) ?></td>
                <td><?= h($saleReturns->voucher_no) ?></td>
                <td><?= h($saleReturns->transaction_date) ?></td>
                <td><?= h($saleReturns->customer_id) ?></td>
                <td><?= h($saleReturns->amount_before_tax) ?></td>
                <td><?= h($saleReturns->total_cgst) ?></td>
                <td><?= h($saleReturns->total_sgst) ?></td>
                <td><?= h($saleReturns->total_igst) ?></td>
                <td><?= h($saleReturns->amount_after_tax) ?></td>
                <td><?= h($saleReturns->round_off) ?></td>
                <td><?= h($saleReturns->sales_ledger_id) ?></td>
                <td><?= h($saleReturns->party_ledger_id) ?></td>
                <td><?= h($saleReturns->location_id) ?></td>
                <td><?= h($saleReturns->sales_invoice_id) ?></td>
                <td><?= h($saleReturns->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SaleReturns', 'action' => 'view', $saleReturns->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SaleReturns', 'action' => 'edit', $saleReturns->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SaleReturns', 'action' => 'delete', $saleReturns->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleReturns->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sales Invoices') ?></h4>
        <?php if (!empty($customer->sales_invoices)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Voucher No') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Amount Before Tax') ?></th>
                <th scope="col"><?= __('Total Cgst') ?></th>
                <th scope="col"><?= __('Total Sgst') ?></th>
                <th scope="col"><?= __('Total Igst') ?></th>
                <th scope="col"><?= __('Amount After Tax') ?></th>
                <th scope="col"><?= __('Round Off') ?></th>
                <th scope="col"><?= __('Sales Ledger Id') ?></th>
                <th scope="col"><?= __('Party Ledger Id') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Invoice Receipt Type') ?></th>
                <th scope="col"><?= __('Receipt Amount') ?></th>
                <th scope="col"><?= __('Discount Amount') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customer->sales_invoices as $salesInvoices): ?>
            <tr>
                <td><?= h($salesInvoices->id) ?></td>
                <td><?= h($salesInvoices->voucher_no) ?></td>
                <td><?= h($salesInvoices->transaction_date) ?></td>
                <td><?= h($salesInvoices->customer_id) ?></td>
                <td><?= h($salesInvoices->amount_before_tax) ?></td>
                <td><?= h($salesInvoices->total_cgst) ?></td>
                <td><?= h($salesInvoices->total_sgst) ?></td>
                <td><?= h($salesInvoices->total_igst) ?></td>
                <td><?= h($salesInvoices->amount_after_tax) ?></td>
                <td><?= h($salesInvoices->round_off) ?></td>
                <td><?= h($salesInvoices->sales_ledger_id) ?></td>
                <td><?= h($salesInvoices->party_ledger_id) ?></td>
                <td><?= h($salesInvoices->location_id) ?></td>
                <td><?= h($salesInvoices->invoice_receipt_type) ?></td>
                <td><?= h($salesInvoices->receipt_amount) ?></td>
                <td><?= h($salesInvoices->discount_amount) ?></td>
                <td><?= h($salesInvoices->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SalesInvoices', 'action' => 'view', $salesInvoices->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SalesInvoices', 'action' => 'edit', $salesInvoices->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SalesInvoices', 'action' => 'delete', $salesInvoices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesInvoices->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Seller Ratings') ?></h4>
        <?php if (!empty($customer->seller_ratings)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Seller Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Rating') ?></th>
                <th scope="col"><?= __('Comment') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customer->seller_ratings as $sellerRatings): ?>
            <tr>
                <td><?= h($sellerRatings->id) ?></td>
                <td><?= h($sellerRatings->seller_id) ?></td>
                <td><?= h($sellerRatings->customer_id) ?></td>
                <td><?= h($sellerRatings->rating) ?></td>
                <td><?= h($sellerRatings->comment) ?></td>
                <td><?= h($sellerRatings->created_on) ?></td>
                <td><?= h($sellerRatings->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SellerRatings', 'action' => 'view', $sellerRatings->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SellerRatings', 'action' => 'edit', $sellerRatings->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SellerRatings', 'action' => 'delete', $sellerRatings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sellerRatings->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Wallets') ?></h4>
        <?php if (!empty($customer->wallets)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Order Id') ?></th>
                <th scope="col"><?= __('Plan Id') ?></th>
                <th scope="col"><?= __('Promotion Id') ?></th>
                <th scope="col"><?= __('Add Amount') ?></th>
                <th scope="col"><?= __('Used Amount') ?></th>
                <th scope="col"><?= __('Cancel To Wallet Online') ?></th>
                <th scope="col"><?= __('Narration') ?></th>
                <th scope="col"><?= __('Return Order Id') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customer->wallets as $wallets): ?>
            <tr>
                <td><?= h($wallets->id) ?></td>
                <td><?= h($wallets->customer_id) ?></td>
                <td><?= h($wallets->order_id) ?></td>
                <td><?= h($wallets->plan_id) ?></td>
                <td><?= h($wallets->promotion_id) ?></td>
                <td><?= h($wallets->add_amount) ?></td>
                <td><?= h($wallets->used_amount) ?></td>
                <td><?= h($wallets->cancel_to_wallet_online) ?></td>
                <td><?= h($wallets->narration) ?></td>
                <td><?= h($wallets->return_order_id) ?></td>
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
