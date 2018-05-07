<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Seller $seller
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Seller'), ['action' => 'edit', $seller->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Seller'), ['action' => 'delete', $seller->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seller->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sellers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Seller Items'), ['controller' => 'SellerItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller Item'), ['controller' => 'SellerItems', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Seller Ratings'), ['controller' => 'SellerRatings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller Rating'), ['controller' => 'SellerRatings', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sellers view large-9 medium-8 columns content">
    <h3><?= h($seller->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $seller->has('city') ? $this->Html->link($seller->city->name, ['controller' => 'Cities', 'action' => 'view', $seller->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($seller->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($seller->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($seller->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($seller->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mobile No') ?></th>
            <td><?= h($seller->mobile_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Latitude') ?></th>
            <td><?= h($seller->latitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Longitude') ?></th>
            <td><?= h($seller->longitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gstin') ?></th>
            <td><?= h($seller->gstin) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gstin Holder Name') ?></th>
            <td><?= h($seller->gstin_holder_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Firm Name') ?></th>
            <td><?= h($seller->firm_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($seller->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($seller->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Timeout') ?></th>
            <td><?= $this->Number->format($seller->timeout) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($seller->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registration Date') ?></th>
            <td><?= h($seller->registration_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Termination Date') ?></th>
            <td><?= h($seller->termination_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($seller->created_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Gstin Holder Address') ?></h4>
        <?= $this->Text->autoParagraph(h($seller->gstin_holder_address)); ?>
    </div>
    <div class="row">
        <h4><?= __('Firm Address') ?></h4>
        <?= $this->Text->autoParagraph(h($seller->firm_address)); ?>
    </div>
    <div class="row">
        <h4><?= __('Termination Reason') ?></h4>
        <?= $this->Text->autoParagraph(h($seller->termination_reason)); ?>
    </div>
    <div class="row">
        <h4><?= __('Breif Decription') ?></h4>
        <?= $this->Text->autoParagraph(h($seller->breif_decription)); ?>
    </div>
    <div class="row">
        <h4><?= __('Passkey') ?></h4>
        <?= $this->Text->autoParagraph(h($seller->passkey)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Items') ?></h4>
        <?php if (!empty($seller->items)): ?>
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
            <?php foreach ($seller->items as $items): ?>
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
        <h4><?= __('Related Seller Items') ?></h4>
        <?php if (!empty($seller->seller_items)): ?>
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
            <?php foreach ($seller->seller_items as $sellerItems): ?>
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
    <div class="related">
        <h4><?= __('Related Seller Ratings') ?></h4>
        <?php if (!empty($seller->seller_ratings)): ?>
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
            <?php foreach ($seller->seller_ratings as $sellerRatings): ?>
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
</div>
