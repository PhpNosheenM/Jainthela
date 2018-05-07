<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Item'), ['action' => 'edit', $item->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Item'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Brands'), ['controller' => 'Brands', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Brand'), ['controller' => 'Brands', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Admins'), ['controller' => 'Admins', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Admin'), ['controller' => 'Admins', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sellers'), ['controller' => 'Sellers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller'), ['controller' => 'Sellers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List App Notifications'), ['controller' => 'AppNotifications', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New App Notification'), ['controller' => 'AppNotifications', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Carts'), ['controller' => 'Carts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cart'), ['controller' => 'Carts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combo Offer Details'), ['controller' => 'ComboOfferDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo Offer Detail'), ['controller' => 'ComboOfferDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Grn Rows'), ['controller' => 'GrnRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grn Row'), ['controller' => 'GrnRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Promotion Details'), ['controller' => 'PromotionDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Promotion Detail'), ['controller' => 'PromotionDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Invoice Rows'), ['controller' => 'PurchaseInvoiceRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Invoice Row'), ['controller' => 'PurchaseInvoiceRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Return Rows'), ['controller' => 'PurchaseReturnRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Return Row'), ['controller' => 'PurchaseReturnRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Return Rows'), ['controller' => 'SaleReturnRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return Row'), ['controller' => 'SaleReturnRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Invoice Rows'), ['controller' => 'SalesInvoiceRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Invoice Row'), ['controller' => 'SalesInvoiceRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Seller Items'), ['controller' => 'SellerItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller Item'), ['controller' => 'SellerItems', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="items view large-9 medium-8 columns content">
    <h3><?= h($item->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= $item->has('category') ? $this->Html->link($item->category->name, ['controller' => 'Categories', 'action' => 'view', $item->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Brand') ?></th>
            <td><?= $item->has('brand') ? $this->Html->link($item->brand->name, ['controller' => 'Brands', 'action' => 'view', $item->brand->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Admin') ?></th>
            <td><?= $item->has('admin') ? $this->Html->link($item->admin->name, ['controller' => 'Admins', 'action' => 'view', $item->admin->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Seller') ?></th>
            <td><?= $item->has('seller') ? $this->Html->link($item->seller->name, ['controller' => 'Sellers', 'action' => 'view', $item->seller->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $item->has('city') ? $this->Html->link($item->city->name, ['controller' => 'Cities', 'action' => 'view', $item->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($item->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Request For Sample') ?></th>
            <td><?= h($item->request_for_sample) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Default Grade') ?></th>
            <td><?= h($item->default_grade) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Approve') ?></th>
            <td><?= h($item->approve) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($item->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('App Image') ?></th>
            <td><?= h($item->app_image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Web Image') ?></th>
            <td><?= h($item->web_image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alias Name') ?></th>
            <td><?= h($item->alias_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Out Of Stock') ?></th>
            <td><?= h($item->out_of_stock) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ready To Sale') ?></th>
            <td><?= h($item->ready_to_sale) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($item->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Minimum Stock') ?></th>
            <td><?= $this->Number->format($item->minimum_stock) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Next Day Requirement') ?></th>
            <td><?= $this->Number->format($item->next_day_requirement) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax') ?></th>
            <td><?= $this->Number->format($item->tax) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($item->created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited On') ?></th>
            <td><?= h($item->edited_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($item->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related App Notifications') ?></h4>
        <?php if (!empty($item->app_notifications)): ?>
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
            <?php foreach ($item->app_notifications as $appNotifications): ?>
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
        <h4><?= __('Related Carts') ?></h4>
        <?php if (!empty($item->carts)): ?>
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
            <?php foreach ($item->carts as $carts): ?>
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
        <h4><?= __('Related Combo Offer Details') ?></h4>
        <?php if (!empty($item->combo_offer_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Combo Offer Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Unit Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($item->combo_offer_details as $comboOfferDetails): ?>
            <tr>
                <td><?= h($comboOfferDetails->id) ?></td>
                <td><?= h($comboOfferDetails->combo_offer_id) ?></td>
                <td><?= h($comboOfferDetails->item_id) ?></td>
                <td><?= h($comboOfferDetails->unit_id) ?></td>
                <td><?= h($comboOfferDetails->quantity) ?></td>
                <td><?= h($comboOfferDetails->rate) ?></td>
                <td><?= h($comboOfferDetails->amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ComboOfferDetails', 'action' => 'view', $comboOfferDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ComboOfferDetails', 'action' => 'edit', $comboOfferDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ComboOfferDetails', 'action' => 'delete', $comboOfferDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comboOfferDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Grn Rows') ?></h4>
        <?php if (!empty($item->grn_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Grn Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Purchase Rate') ?></th>
                <th scope="col"><?= __('Sale Rate') ?></th>
                <th scope="col"><?= __('Import To Itemledger') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($item->grn_rows as $grnRows): ?>
            <tr>
                <td><?= h($grnRows->id) ?></td>
                <td><?= h($grnRows->grn_id) ?></td>
                <td><?= h($grnRows->item_id) ?></td>
                <td><?= h($grnRows->quantity) ?></td>
                <td><?= h($grnRows->purchase_rate) ?></td>
                <td><?= h($grnRows->sale_rate) ?></td>
                <td><?= h($grnRows->import_to_itemledger) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'GrnRows', 'action' => 'view', $grnRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'GrnRows', 'action' => 'edit', $grnRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'GrnRows', 'action' => 'delete', $grnRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grnRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Item Variations') ?></h4>
        <?php if (!empty($item->item_variations)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Unit Id') ?></th>
                <th scope="col"><?= __('Quantity Factor') ?></th>
                <th scope="col"><?= __('Print Quantity') ?></th>
                <th scope="col"><?= __('Print Rate') ?></th>
                <th scope="col"><?= __('Discount Per') ?></th>
                <th scope="col"><?= __('Sales Rate') ?></th>
                <th scope="col"><?= __('Maximum Quantity Purchase') ?></th>
                <th scope="col"><?= __('Out Of Stock') ?></th>
                <th scope="col"><?= __('Ready To Sale') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($item->item_variations as $itemVariations): ?>
            <tr>
                <td><?= h($itemVariations->id) ?></td>
                <td><?= h($itemVariations->item_id) ?></td>
                <td><?= h($itemVariations->unit_id) ?></td>
                <td><?= h($itemVariations->quantity_factor) ?></td>
                <td><?= h($itemVariations->print_quantity) ?></td>
                <td><?= h($itemVariations->print_rate) ?></td>
                <td><?= h($itemVariations->discount_per) ?></td>
                <td><?= h($itemVariations->sales_rate) ?></td>
                <td><?= h($itemVariations->maximum_quantity_purchase) ?></td>
                <td><?= h($itemVariations->out_of_stock) ?></td>
                <td><?= h($itemVariations->ready_to_sale) ?></td>
                <td><?= h($itemVariations->created_on) ?></td>
                <td><?= h($itemVariations->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ItemVariations', 'action' => 'view', $itemVariations->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ItemVariations', 'action' => 'edit', $itemVariations->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ItemVariations', 'action' => 'delete', $itemVariations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemVariations->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Promotion Details') ?></h4>
        <?php if (!empty($item->promotion_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Promotion Id') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Discount In Percentage') ?></th>
                <th scope="col"><?= __('Discount In Amount') ?></th>
                <th scope="col"><?= __('Discount Of Max Amount') ?></th>
                <th scope="col"><?= __('Coupan Name') ?></th>
                <th scope="col"><?= __('Coupan Code') ?></th>
                <th scope="col"><?= __('Buy Quntity') ?></th>
                <th scope="col"><?= __('Get Quntity') ?></th>
                <th scope="col"><?= __('Get Item Id') ?></th>
                <th scope="col"><?= __('In Wallet') ?></th>
                <th scope="col"><?= __('Is Free Shipping') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($item->promotion_details as $promotionDetails): ?>
            <tr>
                <td><?= h($promotionDetails->id) ?></td>
                <td><?= h($promotionDetails->promotion_id) ?></td>
                <td><?= h($promotionDetails->category_id) ?></td>
                <td><?= h($promotionDetails->item_id) ?></td>
                <td><?= h($promotionDetails->discount_in_percentage) ?></td>
                <td><?= h($promotionDetails->discount_in_amount) ?></td>
                <td><?= h($promotionDetails->discount_of_max_amount) ?></td>
                <td><?= h($promotionDetails->coupan_name) ?></td>
                <td><?= h($promotionDetails->coupan_code) ?></td>
                <td><?= h($promotionDetails->buy_quntity) ?></td>
                <td><?= h($promotionDetails->get_quntity) ?></td>
                <td><?= h($promotionDetails->get_item_id) ?></td>
                <td><?= h($promotionDetails->in_wallet) ?></td>
                <td><?= h($promotionDetails->is_free_shipping) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PromotionDetails', 'action' => 'view', $promotionDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PromotionDetails', 'action' => 'edit', $promotionDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PromotionDetails', 'action' => 'delete', $promotionDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $promotionDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Purchase Invoice Rows') ?></h4>
        <?php if (!empty($item->purchase_invoice_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Discount Percentage') ?></th>
                <th scope="col"><?= __('Discount Amount') ?></th>
                <th scope="col"><?= __('Pnf Percentage') ?></th>
                <th scope="col"><?= __('Pnf Amount') ?></th>
                <th scope="col"><?= __('Taxable Value') ?></th>
                <th scope="col"><?= __('Net Amount') ?></th>
                <th scope="col"><?= __('Item Gst Figure Id') ?></th>
                <th scope="col"><?= __('Gst Percentage') ?></th>
                <th scope="col"><?= __('Gst Value') ?></th>
                <th scope="col"><?= __('Round Off') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($item->purchase_invoice_rows as $purchaseInvoiceRows): ?>
            <tr>
                <td><?= h($purchaseInvoiceRows->id) ?></td>
                <td><?= h($purchaseInvoiceRows->purchase_invoice_id) ?></td>
                <td><?= h($purchaseInvoiceRows->item_id) ?></td>
                <td><?= h($purchaseInvoiceRows->quantity) ?></td>
                <td><?= h($purchaseInvoiceRows->rate) ?></td>
                <td><?= h($purchaseInvoiceRows->discount_percentage) ?></td>
                <td><?= h($purchaseInvoiceRows->discount_amount) ?></td>
                <td><?= h($purchaseInvoiceRows->pnf_percentage) ?></td>
                <td><?= h($purchaseInvoiceRows->pnf_amount) ?></td>
                <td><?= h($purchaseInvoiceRows->taxable_value) ?></td>
                <td><?= h($purchaseInvoiceRows->net_amount) ?></td>
                <td><?= h($purchaseInvoiceRows->item_gst_figure_id) ?></td>
                <td><?= h($purchaseInvoiceRows->gst_percentage) ?></td>
                <td><?= h($purchaseInvoiceRows->gst_value) ?></td>
                <td><?= h($purchaseInvoiceRows->round_off) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PurchaseInvoiceRows', 'action' => 'view', $purchaseInvoiceRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PurchaseInvoiceRows', 'action' => 'edit', $purchaseInvoiceRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PurchaseInvoiceRows', 'action' => 'delete', $purchaseInvoiceRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseInvoiceRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Purchase Return Rows') ?></h4>
        <?php if (!empty($item->purchase_return_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Purchase Return Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Discount Percentage') ?></th>
                <th scope="col"><?= __('Discount Amount') ?></th>
                <th scope="col"><?= __('Pnf Percentage') ?></th>
                <th scope="col"><?= __('Pnf Amount') ?></th>
                <th scope="col"><?= __('Taxable Value') ?></th>
                <th scope="col"><?= __('Item Gst Figure Id') ?></th>
                <th scope="col"><?= __('Gst Value') ?></th>
                <th scope="col"><?= __('Round Off') ?></th>
                <th scope="col"><?= __('Net Amount') ?></th>
                <th scope="col"><?= __('Purchase Invoice Row Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($item->purchase_return_rows as $purchaseReturnRows): ?>
            <tr>
                <td><?= h($purchaseReturnRows->id) ?></td>
                <td><?= h($purchaseReturnRows->purchase_return_id) ?></td>
                <td><?= h($purchaseReturnRows->item_id) ?></td>
                <td><?= h($purchaseReturnRows->quantity) ?></td>
                <td><?= h($purchaseReturnRows->rate) ?></td>
                <td><?= h($purchaseReturnRows->discount_percentage) ?></td>
                <td><?= h($purchaseReturnRows->discount_amount) ?></td>
                <td><?= h($purchaseReturnRows->pnf_percentage) ?></td>
                <td><?= h($purchaseReturnRows->pnf_amount) ?></td>
                <td><?= h($purchaseReturnRows->taxable_value) ?></td>
                <td><?= h($purchaseReturnRows->item_gst_figure_id) ?></td>
                <td><?= h($purchaseReturnRows->gst_value) ?></td>
                <td><?= h($purchaseReturnRows->round_off) ?></td>
                <td><?= h($purchaseReturnRows->net_amount) ?></td>
                <td><?= h($purchaseReturnRows->purchase_invoice_row_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PurchaseReturnRows', 'action' => 'view', $purchaseReturnRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PurchaseReturnRows', 'action' => 'edit', $purchaseReturnRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PurchaseReturnRows', 'action' => 'delete', $purchaseReturnRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseReturnRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sale Return Rows') ?></h4>
        <?php if (!empty($item->sale_return_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Sale Return Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Return Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Discount Percentage') ?></th>
                <th scope="col"><?= __('Taxable Value') ?></th>
                <th scope="col"><?= __('Net Amount') ?></th>
                <th scope="col"><?= __('Gst Figure Id') ?></th>
                <th scope="col"><?= __('Gst Value') ?></th>
                <th scope="col"><?= __('Sales Invoice Row Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($item->sale_return_rows as $saleReturnRows): ?>
            <tr>
                <td><?= h($saleReturnRows->id) ?></td>
                <td><?= h($saleReturnRows->sale_return_id) ?></td>
                <td><?= h($saleReturnRows->item_id) ?></td>
                <td><?= h($saleReturnRows->return_quantity) ?></td>
                <td><?= h($saleReturnRows->rate) ?></td>
                <td><?= h($saleReturnRows->discount_percentage) ?></td>
                <td><?= h($saleReturnRows->taxable_value) ?></td>
                <td><?= h($saleReturnRows->net_amount) ?></td>
                <td><?= h($saleReturnRows->gst_figure_id) ?></td>
                <td><?= h($saleReturnRows->gst_value) ?></td>
                <td><?= h($saleReturnRows->sales_invoice_row_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SaleReturnRows', 'action' => 'view', $saleReturnRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SaleReturnRows', 'action' => 'edit', $saleReturnRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SaleReturnRows', 'action' => 'delete', $saleReturnRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleReturnRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sales Invoice Rows') ?></h4>
        <?php if (!empty($item->sales_invoice_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Sales Invoice Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Discount Percentage') ?></th>
                <th scope="col"><?= __('Taxable Value') ?></th>
                <th scope="col"><?= __('Net Amount') ?></th>
                <th scope="col"><?= __('Gst Figure Id') ?></th>
                <th scope="col"><?= __('Gst Value') ?></th>
                <th scope="col"><?= __('Is Gst Excluded') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($item->sales_invoice_rows as $salesInvoiceRows): ?>
            <tr>
                <td><?= h($salesInvoiceRows->id) ?></td>
                <td><?= h($salesInvoiceRows->sales_invoice_id) ?></td>
                <td><?= h($salesInvoiceRows->item_id) ?></td>
                <td><?= h($salesInvoiceRows->quantity) ?></td>
                <td><?= h($salesInvoiceRows->rate) ?></td>
                <td><?= h($salesInvoiceRows->discount_percentage) ?></td>
                <td><?= h($salesInvoiceRows->taxable_value) ?></td>
                <td><?= h($salesInvoiceRows->net_amount) ?></td>
                <td><?= h($salesInvoiceRows->gst_figure_id) ?></td>
                <td><?= h($salesInvoiceRows->gst_value) ?></td>
                <td><?= h($salesInvoiceRows->is_gst_excluded) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SalesInvoiceRows', 'action' => 'view', $salesInvoiceRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SalesInvoiceRows', 'action' => 'edit', $salesInvoiceRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SalesInvoiceRows', 'action' => 'delete', $salesInvoiceRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesInvoiceRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Seller Items') ?></h4>
        <?php if (!empty($item->seller_items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Seller Id') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Commission Percentage') ?></th>
                <th scope="col"><?= __('Commission Created On') ?></th>
                <th scope="col"><?= __('Expiry On Date') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($item->seller_items as $sellerItems): ?>
            <tr>
                <td><?= h($sellerItems->id) ?></td>
                <td><?= h($sellerItems->item_id) ?></td>
                <td><?= h($sellerItems->category_id) ?></td>
                <td><?= h($sellerItems->seller_id) ?></td>
                <td><?= h($sellerItems->created_on) ?></td>
                <td><?= h($sellerItems->created_by) ?></td>
                <td><?= h($sellerItems->commission_percentage) ?></td>
                <td><?= h($sellerItems->commission_created_on) ?></td>
                <td><?= h($sellerItems->expiry_on_date) ?></td>
                <td><?= h($sellerItems->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SellerItems', 'action' => 'view', $sellerItems->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SellerItems', 'action' => 'edit', $sellerItems->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SellerItems', 'action' => 'delete', $sellerItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sellerItems->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
