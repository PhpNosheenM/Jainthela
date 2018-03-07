<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\City $city
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit City'), ['action' => 'edit', $city->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete City'), ['action' => 'delete', $city->id], ['confirm' => __('Are you sure you want to delete # {0}?', $city->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List States'), ['controller' => 'States', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New State'), ['controller' => 'States', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List App Notifications'), ['controller' => 'AppNotifications', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New App Notification'), ['controller' => 'AppNotifications', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Banners'), ['controller' => 'Banners', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Banner'), ['controller' => 'Banners', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bulk Booking Leads'), ['controller' => 'BulkBookingLeads', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bulk Booking Lead'), ['controller' => 'BulkBookingLeads', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Carts'), ['controller' => 'Carts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cart'), ['controller' => 'Carts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combo Offers'), ['controller' => 'ComboOffers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo Offer'), ['controller' => 'ComboOffers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Company Details'), ['controller' => 'CompanyDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company Detail'), ['controller' => 'CompanyDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customer Addresses'), ['controller' => 'CustomerAddresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer Address'), ['controller' => 'CustomerAddresses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Delivery Charges'), ['controller' => 'DeliveryCharges', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Delivery Charge'), ['controller' => 'DeliveryCharges', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Delivery Times'), ['controller' => 'DeliveryTimes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Delivery Time'), ['controller' => 'DeliveryTimes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Plans'), ['controller' => 'Plans', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Plan'), ['controller' => 'Plans', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Promotions'), ['controller' => 'Promotions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Promotion'), ['controller' => 'Promotions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sellers'), ['controller' => 'Sellers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller'), ['controller' => 'Sellers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Supplier Areas'), ['controller' => 'SupplierAreas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Supplier Area'), ['controller' => 'SupplierAreas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cities view large-9 medium-8 columns content">
    <h3><?= h($city->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= $city->has('state') ? $this->Html->link($city->state->name, ['controller' => 'States', 'action' => 'view', $city->state->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($city->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($city->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($city->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($city->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($city->created_on) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related App Notifications') ?></h4>
        <?php if (!empty($city->app_notifications)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Message') ?></th>
                <th scope="col"><?= __('App Link') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Screen Type') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Edited By') ?></th>
                <th scope="col"><?= __('Edited On') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->app_notifications as $appNotifications): ?>
            <tr>
                <td><?= h($appNotifications->id) ?></td>
                <td><?= h($appNotifications->city_id) ?></td>
                <td><?= h($appNotifications->message) ?></td>
                <td><?= h($appNotifications->app_link) ?></td>
                <td><?= h($appNotifications->item_id) ?></td>
                <td><?= h($appNotifications->screen_type) ?></td>
                <td><?= h($appNotifications->created_by) ?></td>
                <td><?= h($appNotifications->created_on) ?></td>
                <td><?= h($appNotifications->edited_by) ?></td>
                <td><?= h($appNotifications->edited_on) ?></td>
                <td><?= h($appNotifications->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AppNotifications', 'action' => 'view', $appNotifications->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AppNotifications', 'action' => 'edit', $appNotifications->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AppNotifications', 'action' => 'delete', $appNotifications->id], ['confirm' => __('Are you sure you want to delete # {0}?', $appNotifications->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Banners') ?></h4>
        <?php if (!empty($city->banners)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Link Name') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->banners as $banners): ?>
            <tr>
                <td><?= h($banners->id) ?></td>
                <td><?= h($banners->city_id) ?></td>
                <td><?= h($banners->link_name) ?></td>
                <td><?= h($banners->name) ?></td>
                <td><?= h($banners->created_on) ?></td>
                <td><?= h($banners->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Banners', 'action' => 'view', $banners->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Banners', 'action' => 'edit', $banners->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Banners', 'action' => 'delete', $banners->id], ['confirm' => __('Are you sure you want to delete # {0}?', $banners->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Bulk Booking Leads') ?></h4>
        <?php if (!empty($city->bulk_booking_leads)): ?>
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
            <?php foreach ($city->bulk_booking_leads as $bulkBookingLeads): ?>
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
        <?php if (!empty($city->carts)): ?>
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
            <?php foreach ($city->carts as $carts): ?>
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
        <h4><?= __('Related Categories') ?></h4>
        <?php if (!empty($city->categories)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Parent Id') ?></th>
                <th scope="col"><?= __('Lft') ?></th>
                <th scope="col"><?= __('Rght') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Edited On') ?></th>
                <th scope="col"><?= __('Edited By') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->categories as $categories): ?>
            <tr>
                <td><?= h($categories->id) ?></td>
                <td><?= h($categories->name) ?></td>
                <td><?= h($categories->parent_id) ?></td>
                <td><?= h($categories->lft) ?></td>
                <td><?= h($categories->rght) ?></td>
                <td><?= h($categories->city_id) ?></td>
                <td><?= h($categories->created_on) ?></td>
                <td><?= h($categories->created_by) ?></td>
                <td><?= h($categories->edited_on) ?></td>
                <td><?= h($categories->edited_by) ?></td>
                <td><?= h($categories->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Categories', 'action' => 'view', $categories->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Categories', 'action' => 'edit', $categories->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Categories', 'action' => 'delete', $categories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categories->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Combo Offers') ?></h4>
        <?php if (!empty($city->combo_offers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Print Rate') ?></th>
                <th scope="col"><?= __('Discount Per') ?></th>
                <th scope="col"><?= __('Sales Rate') ?></th>
                <th scope="col"><?= __('Quantity Factor') ?></th>
                <th scope="col"><?= __('Print Quantity') ?></th>
                <th scope="col"><?= __('Maximum Quantity Purchase') ?></th>
                <th scope="col"><?= __('Start Date') ?></th>
                <th scope="col"><?= __('End Date') ?></th>
                <th scope="col"><?= __('Stock In Quantity') ?></th>
                <th scope="col"><?= __('Stock Out Quantity') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Edited On') ?></th>
                <th scope="col"><?= __('Ready To Sale') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->combo_offers as $comboOffers): ?>
            <tr>
                <td><?= h($comboOffers->id) ?></td>
                <td><?= h($comboOffers->city_id) ?></td>
                <td><?= h($comboOffers->admin_id) ?></td>
                <td><?= h($comboOffers->name) ?></td>
                <td><?= h($comboOffers->print_rate) ?></td>
                <td><?= h($comboOffers->discount_per) ?></td>
                <td><?= h($comboOffers->sales_rate) ?></td>
                <td><?= h($comboOffers->quantity_factor) ?></td>
                <td><?= h($comboOffers->print_quantity) ?></td>
                <td><?= h($comboOffers->maximum_quantity_purchase) ?></td>
                <td><?= h($comboOffers->start_date) ?></td>
                <td><?= h($comboOffers->end_date) ?></td>
                <td><?= h($comboOffers->stock_in_quantity) ?></td>
                <td><?= h($comboOffers->stock_out_quantity) ?></td>
                <td><?= h($comboOffers->created_on) ?></td>
                <td><?= h($comboOffers->edited_on) ?></td>
                <td><?= h($comboOffers->ready_to_sale) ?></td>
                <td><?= h($comboOffers->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ComboOffers', 'action' => 'view', $comboOffers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ComboOffers', 'action' => 'edit', $comboOffers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ComboOffers', 'action' => 'delete', $comboOffers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comboOffers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Company Details') ?></h4>
        <?php if (!empty($city->company_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Web') ?></th>
                <th scope="col"><?= __('Mobile') ?></th>
                <th scope="col"><?= __('Address') ?></th>
                <th scope="col"><?= __('Flag') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->company_details as $companyDetails): ?>
            <tr>
                <td><?= h($companyDetails->id) ?></td>
                <td><?= h($companyDetails->city_id) ?></td>
                <td><?= h($companyDetails->email) ?></td>
                <td><?= h($companyDetails->web) ?></td>
                <td><?= h($companyDetails->mobile) ?></td>
                <td><?= h($companyDetails->address) ?></td>
                <td><?= h($companyDetails->flag) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CompanyDetails', 'action' => 'view', $companyDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CompanyDetails', 'action' => 'edit', $companyDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CompanyDetails', 'action' => 'delete', $companyDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $companyDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Customer Addresses') ?></h4>
        <?php if (!empty($city->customer_addresses)): ?>
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
            <?php foreach ($city->customer_addresses as $customerAddresses): ?>
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
        <h4><?= __('Related Customers') ?></h4>
        <?php if (!empty($city->customers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Username') ?></th>
                <th scope="col"><?= __('Password') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Mobile No') ?></th>
                <th scope="col"><?= __('Latitude') ?></th>
                <th scope="col"><?= __('Longitude') ?></th>
                <th scope="col"><?= __('Device Id Name') ?></th>
                <th scope="col"><?= __('Device Token') ?></th>
                <th scope="col"><?= __('Referral Code') ?></th>
                <th scope="col"><?= __('Discount In Percentage') ?></th>
                <th scope="col"><?= __('Passkey') ?></th>
                <th scope="col"><?= __('Timeout') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Gstin') ?></th>
                <th scope="col"><?= __('Gstin Holder Name') ?></th>
                <th scope="col"><?= __('Gstin Holder Address') ?></th>
                <th scope="col"><?= __('Firm Name') ?></th>
                <th scope="col"><?= __('Firm State Id') ?></th>
                <th scope="col"><?= __('Firm Address') ?></th>
                <th scope="col"><?= __('Firm City Id') ?></th>
                <th scope="col"><?= __('Discount Created On') ?></th>
                <th scope="col"><?= __('Discount Expiry') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->customers as $customers): ?>
            <tr>
                <td><?= h($customers->id) ?></td>
                <td><?= h($customers->city_id) ?></td>
                <td><?= h($customers->name) ?></td>
                <td><?= h($customers->username) ?></td>
                <td><?= h($customers->password) ?></td>
                <td><?= h($customers->email) ?></td>
                <td><?= h($customers->mobile_no) ?></td>
                <td><?= h($customers->latitude) ?></td>
                <td><?= h($customers->longitude) ?></td>
                <td><?= h($customers->device_id_name) ?></td>
                <td><?= h($customers->device_token) ?></td>
                <td><?= h($customers->referral_code) ?></td>
                <td><?= h($customers->discount_in_percentage) ?></td>
                <td><?= h($customers->passkey) ?></td>
                <td><?= h($customers->timeout) ?></td>
                <td><?= h($customers->created_on) ?></td>
                <td><?= h($customers->created_by) ?></td>
                <td><?= h($customers->status) ?></td>
                <td><?= h($customers->gstin) ?></td>
                <td><?= h($customers->gstin_holder_name) ?></td>
                <td><?= h($customers->gstin_holder_address) ?></td>
                <td><?= h($customers->firm_name) ?></td>
                <td><?= h($customers->firm_state_id) ?></td>
                <td><?= h($customers->firm_address) ?></td>
                <td><?= h($customers->firm_city_id) ?></td>
                <td><?= h($customers->discount_created_on) ?></td>
                <td><?= h($customers->discount_expiry) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Customers', 'action' => 'view', $customers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Customers', 'action' => 'edit', $customers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Customers', 'action' => 'delete', $customers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Delivery Charges') ?></h4>
        <?php if (!empty($city->delivery_charges)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Charge') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->delivery_charges as $deliveryCharges): ?>
            <tr>
                <td><?= h($deliveryCharges->id) ?></td>
                <td><?= h($deliveryCharges->city_id) ?></td>
                <td><?= h($deliveryCharges->amount) ?></td>
                <td><?= h($deliveryCharges->charge) ?></td>
                <td><?= h($deliveryCharges->type) ?></td>
                <td><?= h($deliveryCharges->created_on) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DeliveryCharges', 'action' => 'view', $deliveryCharges->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DeliveryCharges', 'action' => 'edit', $deliveryCharges->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DeliveryCharges', 'action' => 'delete', $deliveryCharges->id], ['confirm' => __('Are you sure you want to delete # {0}?', $deliveryCharges->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Delivery Times') ?></h4>
        <?php if (!empty($city->delivery_times)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Time From') ?></th>
                <th scope="col"><?= __('Time To') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->delivery_times as $deliveryTimes): ?>
            <tr>
                <td><?= h($deliveryTimes->id) ?></td>
                <td><?= h($deliveryTimes->city_id) ?></td>
                <td><?= h($deliveryTimes->time_from) ?></td>
                <td><?= h($deliveryTimes->time_to) ?></td>
                <td><?= h($deliveryTimes->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DeliveryTimes', 'action' => 'view', $deliveryTimes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DeliveryTimes', 'action' => 'edit', $deliveryTimes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DeliveryTimes', 'action' => 'delete', $deliveryTimes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $deliveryTimes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Items') ?></h4>
        <?php if (!empty($city->items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('Seller Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Minimum Stock') ?></th>
                <th scope="col"><?= __('Next Day Requirement') ?></th>
                <th scope="col"><?= __('Request For Sample') ?></th>
                <th scope="col"><?= __('Default Grade') ?></th>
                <th scope="col"><?= __('Tax') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Edited On') ?></th>
                <th scope="col"><?= __('Approve') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->items as $items): ?>
            <tr>
                <td><?= h($items->id) ?></td>
                <td><?= h($items->category_id) ?></td>
                <td><?= h($items->admin_id) ?></td>
                <td><?= h($items->seller_id) ?></td>
                <td><?= h($items->city_id) ?></td>
                <td><?= h($items->name) ?></td>
                <td><?= h($items->description) ?></td>
                <td><?= h($items->minimum_stock) ?></td>
                <td><?= h($items->next_day_requirement) ?></td>
                <td><?= h($items->request_for_sample) ?></td>
                <td><?= h($items->default_grade) ?></td>
                <td><?= h($items->tax) ?></td>
                <td><?= h($items->created_on) ?></td>
                <td><?= h($items->edited_on) ?></td>
                <td><?= h($items->approve) ?></td>
                <td><?= h($items->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Locations') ?></h4>
        <?php if (!empty($city->locations)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Latitude') ?></th>
                <th scope="col"><?= __('Longitude') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->locations as $locations): ?>
            <tr>
                <td><?= h($locations->id) ?></td>
                <td><?= h($locations->city_id) ?></td>
                <td><?= h($locations->name) ?></td>
                <td><?= h($locations->latitude) ?></td>
                <td><?= h($locations->longitude) ?></td>
                <td><?= h($locations->created_on) ?></td>
                <td><?= h($locations->created_by) ?></td>
                <td><?= h($locations->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Locations', 'action' => 'view', $locations->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Locations', 'action' => 'edit', $locations->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Locations', 'action' => 'delete', $locations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locations->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Plans') ?></h4>
        <?php if (!empty($city->plans)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Benifit Per') ?></th>
                <th scope="col"><?= __('Total Amount') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->plans as $plans): ?>
            <tr>
                <td><?= h($plans->id) ?></td>
                <td><?= h($plans->admin_id) ?></td>
                <td><?= h($plans->city_id) ?></td>
                <td><?= h($plans->name) ?></td>
                <td><?= h($plans->amount) ?></td>
                <td><?= h($plans->benifit_per) ?></td>
                <td><?= h($plans->total_amount) ?></td>
                <td><?= h($plans->created_on) ?></td>
                <td><?= h($plans->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Plans', 'action' => 'view', $plans->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Plans', 'action' => 'edit', $plans->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Plans', 'action' => 'delete', $plans->id], ['confirm' => __('Are you sure you want to delete # {0}?', $plans->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Promotions') ?></h4>
        <?php if (!empty($city->promotions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Offer Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Start Date') ?></th>
                <th scope="col"><?= __('End Date') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->promotions as $promotions): ?>
            <tr>
                <td><?= h($promotions->id) ?></td>
                <td><?= h($promotions->admin_id) ?></td>
                <td><?= h($promotions->city_id) ?></td>
                <td><?= h($promotions->offer_name) ?></td>
                <td><?= h($promotions->description) ?></td>
                <td><?= h($promotions->start_date) ?></td>
                <td><?= h($promotions->end_date) ?></td>
                <td><?= h($promotions->created_on) ?></td>
                <td><?= h($promotions->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Promotions', 'action' => 'view', $promotions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Promotions', 'action' => 'edit', $promotions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Promotions', 'action' => 'delete', $promotions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $promotions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Roles') ?></h4>
        <?php if (!empty($city->roles)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->roles as $roles): ?>
            <tr>
                <td><?= h($roles->id) ?></td>
                <td><?= h($roles->city_id) ?></td>
                <td><?= h($roles->name) ?></td>
                <td><?= h($roles->created_on) ?></td>
                <td><?= h($roles->created_by) ?></td>
                <td><?= h($roles->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Roles', 'action' => 'view', $roles->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Roles', 'action' => 'edit', $roles->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Roles', 'action' => 'delete', $roles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roles->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sellers') ?></h4>
        <?php if (!empty($city->sellers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Username') ?></th>
                <th scope="col"><?= __('Password') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Mobile No') ?></th>
                <th scope="col"><?= __('Latitude') ?></th>
                <th scope="col"><?= __('Longitude') ?></th>
                <th scope="col"><?= __('Gstin') ?></th>
                <th scope="col"><?= __('Gstin Holder Name') ?></th>
                <th scope="col"><?= __('Gstin Holder Address') ?></th>
                <th scope="col"><?= __('Firm Name') ?></th>
                <th scope="col"><?= __('Firm State Id') ?></th>
                <th scope="col"><?= __('Firm Address') ?></th>
                <th scope="col"><?= __('Firm City Id') ?></th>
                <th scope="col"><?= __('Registration Date') ?></th>
                <th scope="col"><?= __('Terimation Date') ?></th>
                <th scope="col"><?= __('Terimation Reason') ?></th>
                <th scope="col"><?= __('Breif Decription') ?></th>
                <th scope="col"><?= __('Passkey') ?></th>
                <th scope="col"><?= __('Timeout') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->sellers as $sellers): ?>
            <tr>
                <td><?= h($sellers->id) ?></td>
                <td><?= h($sellers->city_id) ?></td>
                <td><?= h($sellers->name) ?></td>
                <td><?= h($sellers->username) ?></td>
                <td><?= h($sellers->password) ?></td>
                <td><?= h($sellers->email) ?></td>
                <td><?= h($sellers->mobile_no) ?></td>
                <td><?= h($sellers->latitude) ?></td>
                <td><?= h($sellers->longitude) ?></td>
                <td><?= h($sellers->gstin) ?></td>
                <td><?= h($sellers->gstin_holder_name) ?></td>
                <td><?= h($sellers->gstin_holder_address) ?></td>
                <td><?= h($sellers->firm_name) ?></td>
                <td><?= h($sellers->firm_state_id) ?></td>
                <td><?= h($sellers->firm_address) ?></td>
                <td><?= h($sellers->firm_city_id) ?></td>
                <td><?= h($sellers->registration_date) ?></td>
                <td><?= h($sellers->terimation_date) ?></td>
                <td><?= h($sellers->terimation_reason) ?></td>
                <td><?= h($sellers->breif_decription) ?></td>
                <td><?= h($sellers->passkey) ?></td>
                <td><?= h($sellers->timeout) ?></td>
                <td><?= h($sellers->created_on) ?></td>
                <td><?= h($sellers->created_by) ?></td>
                <td><?= h($sellers->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Sellers', 'action' => 'view', $sellers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Sellers', 'action' => 'edit', $sellers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Sellers', 'action' => 'delete', $sellers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sellers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Supplier Areas') ?></h4>
        <?php if (!empty($city->supplier_areas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->supplier_areas as $supplierAreas): ?>
            <tr>
                <td><?= h($supplierAreas->id) ?></td>
                <td><?= h($supplierAreas->city_id) ?></td>
                <td><?= h($supplierAreas->name) ?></td>
                <td><?= h($supplierAreas->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SupplierAreas', 'action' => 'view', $supplierAreas->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SupplierAreas', 'action' => 'edit', $supplierAreas->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SupplierAreas', 'action' => 'delete', $supplierAreas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supplierAreas->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
