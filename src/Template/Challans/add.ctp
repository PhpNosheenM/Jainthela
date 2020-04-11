<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Challan $challan
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Challans'), ['action' => 'index']) ?></li>
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
<div class="challans form large-9 medium-8 columns content">
    <?= $this->Form->create($challan) ?>
    <fieldset>
        <legend><?= __('Add Challan') ?></legend>
        <?php
            echo $this->Form->control('order_id', ['options' => $orders]);
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('seller_id', ['options' => $sellers, 'empty' => true]);
            echo $this->Form->control('seller_name');
            echo $this->Form->control('financial_year_id', ['options' => $financialYears]);
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('sales_ledger_id');
            echo $this->Form->control('party_ledger_id', ['options' => $partyLedgers]);
            echo $this->Form->control('customer_id', ['options' => $customers]);
            echo $this->Form->control('driver_id', ['options' => $drivers]);
            echo $this->Form->control('customer_address_id', ['options' => $customerAddresses]);
            echo $this->Form->control('address');
            echo $this->Form->control('promotion_detail_id', ['options' => $promotionDetails]);
            echo $this->Form->control('invoice_no');
            echo $this->Form->control('voucher_no');
            echo $this->Form->control('ccavvenue_tracking_no');
            echo $this->Form->control('amount_from_wallet');
            echo $this->Form->control('total_amount');
            echo $this->Form->control('discount_percent');
            echo $this->Form->control('discount_amount');
            echo $this->Form->control('total_gst');
            echo $this->Form->control('grand_total');
            echo $this->Form->control('round_off');
            echo $this->Form->control('pay_amount');
            echo $this->Form->control('due_amount');
            echo $this->Form->control('online_amount');
            echo $this->Form->control('delivery_charge_id', ['options' => $deliveryCharges]);
            echo $this->Form->control('delivery_charge_amount');
            echo $this->Form->control('order_type');
            echo $this->Form->control('delivery_date');
            echo $this->Form->control('delivery_time_sloat');
            echo $this->Form->control('delivery_time_id', ['options' => $deliveryTimes]);
            echo $this->Form->control('order_status');
            echo $this->Form->control('cancel_reason_id', ['options' => $cancelReasons]);
            echo $this->Form->control('cancel_reason_other');
            echo $this->Form->control('cancel_date');
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('order_date');
            echo $this->Form->control('payment_status');
            echo $this->Form->control('order_from');
            echo $this->Form->control('narration');
            echo $this->Form->control('packing_on');
            echo $this->Form->control('packing_flag');
            echo $this->Form->control('dispatch_on');
            echo $this->Form->control('dispatch_flag');
            echo $this->Form->control('otp');
            echo $this->Form->control('otp_confirmation');
            echo $this->Form->control('not_received');
            echo $this->Form->control('online_return_amount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
