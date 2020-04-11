<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Invoice'), ['action' => 'edit', $invoice->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Invoice'), ['action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Invoices'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoice'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sellers'), ['controller' => 'Sellers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller'), ['controller' => 'Sellers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Financial Years'), ['controller' => 'FinancialYears', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Financial Year'), ['controller' => 'FinancialYears', 'action' => 'add']) ?> </li>
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
        <li><?= $this->Html->link(__('List Invoice Rows'), ['controller' => 'InvoiceRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoice Row'), ['controller' => 'InvoiceRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="invoices view large-9 medium-8 columns content">
    <h3><?= h($invoice->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Order') ?></th>
            <td><?= $invoice->has('order') ? $this->Html->link($invoice->order->id, ['controller' => 'Orders', 'action' => 'view', $invoice->order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $invoice->has('location') ? $this->Html->link($invoice->location->name, ['controller' => 'Locations', 'action' => 'view', $invoice->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Seller') ?></th>
            <td><?= $invoice->has('seller') ? $this->Html->link($invoice->seller->name, ['controller' => 'Sellers', 'action' => 'view', $invoice->seller->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Financial Year') ?></th>
            <td><?= $invoice->has('financial_year') ? $this->Html->link($invoice->financial_year->id, ['controller' => 'FinancialYears', 'action' => 'view', $invoice->financial_year->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $invoice->has('city') ? $this->Html->link($invoice->city->name, ['controller' => 'Cities', 'action' => 'view', $invoice->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Party Ledger') ?></th>
            <td><?= $invoice->has('party_ledger') ? $this->Html->link($invoice->party_ledger->name, ['controller' => 'Ledgers', 'action' => 'view', $invoice->party_ledger->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $invoice->has('customer') ? $this->Html->link($invoice->customer->name, ['controller' => 'Customers', 'action' => 'view', $invoice->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Driver') ?></th>
            <td><?= $invoice->has('driver') ? $this->Html->link($invoice->driver->name, ['controller' => 'Drivers', 'action' => 'view', $invoice->driver->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer Address') ?></th>
            <td><?= $invoice->has('customer_address') ? $this->Html->link($invoice->customer_address->id, ['controller' => 'CustomerAddresses', 'action' => 'view', $invoice->customer_address->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Promotion Detail') ?></th>
            <td><?= $invoice->has('promotion_detail') ? $this->Html->link($invoice->promotion_detail->id, ['controller' => 'PromotionDetails', 'action' => 'view', $invoice->promotion_detail->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Invoice No') ?></th>
            <td><?= h($invoice->invoice_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ccavvenue Tracking No') ?></th>
            <td><?= h($invoice->ccavvenue_tracking_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delivery Charge') ?></th>
            <td><?= $invoice->has('delivery_charge') ? $this->Html->link($invoice->delivery_charge->id, ['controller' => 'DeliveryCharges', 'action' => 'view', $invoice->delivery_charge->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delivery Charge Amount') ?></th>
            <td><?= h($invoice->delivery_charge_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Type') ?></th>
            <td><?= h($invoice->order_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delivery Time Sloat') ?></th>
            <td><?= h($invoice->delivery_time_sloat) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delivery Time') ?></th>
            <td><?= $invoice->has('delivery_time') ? $this->Html->link($invoice->delivery_time->id, ['controller' => 'DeliveryTimes', 'action' => 'view', $invoice->delivery_time->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Status') ?></th>
            <td><?= h($invoice->order_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cancel Reason') ?></th>
            <td><?= $invoice->has('cancel_reason') ? $this->Html->link($invoice->cancel_reason->reason, ['controller' => 'CancelReasons', 'action' => 'view', $invoice->cancel_reason->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Status') ?></th>
            <td><?= h($invoice->payment_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order From') ?></th>
            <td><?= h($invoice->order_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Packing Flag') ?></th>
            <td><?= h($invoice->packing_flag) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dispatch Flag') ?></th>
            <td><?= h($invoice->dispatch_flag) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Otp') ?></th>
            <td><?= h($invoice->otp) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Otp Confirmation') ?></th>
            <td><?= h($invoice->otp_confirmation) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Not Received') ?></th>
            <td><?= h($invoice->not_received) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($invoice->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Ledger Id') ?></th>
            <td><?= $this->Number->format($invoice->sales_ledger_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voucher No') ?></th>
            <td><?= $this->Number->format($invoice->voucher_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount From Wallet') ?></th>
            <td><?= $this->Number->format($invoice->amount_from_wallet) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Amount') ?></th>
            <td><?= $this->Number->format($invoice->total_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Percent') ?></th>
            <td><?= $this->Number->format($invoice->discount_percent) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Amount') ?></th>
            <td><?= $this->Number->format($invoice->discount_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Gst') ?></th>
            <td><?= $this->Number->format($invoice->total_gst) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Grand Total') ?></th>
            <td><?= $this->Number->format($invoice->grand_total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Round Off') ?></th>
            <td><?= $this->Number->format($invoice->round_off) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pay Amount') ?></th>
            <td><?= $this->Number->format($invoice->pay_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Due Amount') ?></th>
            <td><?= $this->Number->format($invoice->due_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Online Amount') ?></th>
            <td><?= $this->Number->format($invoice->online_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Online Return Amount') ?></th>
            <td><?= $this->Number->format($invoice->online_return_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Delivery Date') ?></th>
            <td><?= h($invoice->delivery_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cancel Date') ?></th>
            <td><?= h($invoice->cancel_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($invoice->transaction_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Date') ?></th>
            <td><?= h($invoice->order_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Packing On') ?></th>
            <td><?= h($invoice->packing_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dispatch On') ?></th>
            <td><?= h($invoice->dispatch_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Address') ?></h4>
        <?= $this->Text->autoParagraph(h($invoice->address)); ?>
    </div>
    <div class="row">
        <h4><?= __('Cancel Reason Other') ?></h4>
        <?= $this->Text->autoParagraph(h($invoice->cancel_reason_other)); ?>
    </div>
    <div class="row">
        <h4><?= __('Narration') ?></h4>
        <?= $this->Text->autoParagraph(h($invoice->narration)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Invoice Rows') ?></h4>
        <?php if (!empty($invoice->invoice_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Invoice Id') ?></th>
                <th scope="col"><?= __('Order Detail Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Combo Offer Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Actual Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Discount Percent') ?></th>
                <th scope="col"><?= __('Discount Amount') ?></th>
                <th scope="col"><?= __('Promo Percent') ?></th>
                <th scope="col"><?= __('Promo Amount') ?></th>
                <th scope="col"><?= __('Taxable Value') ?></th>
                <th scope="col"><?= __('Gst Percentage') ?></th>
                <th scope="col"><?= __('Gst Figure Id') ?></th>
                <th scope="col"><?= __('Gst Value') ?></th>
                <th scope="col"><?= __('Net Amount') ?></th>
                <th scope="col"><?= __('Is Item Cancel') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($invoice->invoice_rows as $invoiceRows): ?>
            <tr>
                <td><?= h($invoiceRows->id) ?></td>
                <td><?= h($invoiceRows->invoice_id) ?></td>
                <td><?= h($invoiceRows->order_detail_id) ?></td>
                <td><?= h($invoiceRows->item_id) ?></td>
                <td><?= h($invoiceRows->item_variation_id) ?></td>
                <td><?= h($invoiceRows->combo_offer_id) ?></td>
                <td><?= h($invoiceRows->quantity) ?></td>
                <td><?= h($invoiceRows->actual_quantity) ?></td>
                <td><?= h($invoiceRows->rate) ?></td>
                <td><?= h($invoiceRows->amount) ?></td>
                <td><?= h($invoiceRows->discount_percent) ?></td>
                <td><?= h($invoiceRows->discount_amount) ?></td>
                <td><?= h($invoiceRows->promo_percent) ?></td>
                <td><?= h($invoiceRows->promo_amount) ?></td>
                <td><?= h($invoiceRows->taxable_value) ?></td>
                <td><?= h($invoiceRows->gst_percentage) ?></td>
                <td><?= h($invoiceRows->gst_figure_id) ?></td>
                <td><?= h($invoiceRows->gst_value) ?></td>
                <td><?= h($invoiceRows->net_amount) ?></td>
                <td><?= h($invoiceRows->is_item_cancel) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'InvoiceRows', 'action' => 'view', $invoiceRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'InvoiceRows', 'action' => 'edit', $invoiceRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'InvoiceRows', 'action' => 'delete', $invoiceRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
