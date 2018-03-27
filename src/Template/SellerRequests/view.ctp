<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SellerRequest $sellerRequest
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Seller Request'), ['action' => 'edit', $sellerRequest->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Seller Request'), ['action' => 'delete', $sellerRequest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sellerRequest->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Seller Requests'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller Request'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sellers'), ['controller' => 'Sellers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller'), ['controller' => 'Sellers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Seller Request Rows'), ['controller' => 'SellerRequestRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller Request Row'), ['controller' => 'SellerRequestRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sellerRequests view large-9 medium-8 columns content">
    <h3><?= h($sellerRequest->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Seller') ?></th>
            <td><?= $sellerRequest->has('seller') ? $this->Html->link($sellerRequest->seller->name, ['controller' => 'Sellers', 'action' => 'view', $sellerRequest->seller->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $sellerRequest->has('location') ? $this->Html->link($sellerRequest->location->name, ['controller' => 'Locations', 'action' => 'view', $sellerRequest->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($sellerRequest->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($sellerRequest->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voucher No') ?></th>
            <td><?= $this->Number->format($sellerRequest->voucher_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Taxable Value') ?></th>
            <td><?= $this->Number->format($sellerRequest->total_taxable_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Gst') ?></th>
            <td><?= $this->Number->format($sellerRequest->total_gst) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Amount') ?></th>
            <td><?= $this->Number->format($sellerRequest->total_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($sellerRequest->transaction_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Seller Request Rows') ?></h4>
        <?php if (!empty($sellerRequest->seller_request_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Seller Request Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Taxable Value') ?></th>
                <th scope="col"><?= __('Net Amount') ?></th>
                <th scope="col"><?= __('Gst Percentage') ?></th>
                <th scope="col"><?= __('Gst Value') ?></th>
                <th scope="col"><?= __('Purchase Rate') ?></th>
                <th scope="col"><?= __('Sales Rate') ?></th>
                <th scope="col"><?= __('Gst Type') ?></th>
                <th scope="col"><?= __('Mrp') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($sellerRequest->seller_request_rows as $sellerRequestRows): ?>
            <tr>
                <td><?= h($sellerRequestRows->id) ?></td>
                <td><?= h($sellerRequestRows->seller_request_id) ?></td>
                <td><?= h($sellerRequestRows->item_id) ?></td>
                <td><?= h($sellerRequestRows->item_variation_id) ?></td>
                <td><?= h($sellerRequestRows->quantity) ?></td>
                <td><?= h($sellerRequestRows->rate) ?></td>
                <td><?= h($sellerRequestRows->taxable_value) ?></td>
                <td><?= h($sellerRequestRows->net_amount) ?></td>
                <td><?= h($sellerRequestRows->gst_percentage) ?></td>
                <td><?= h($sellerRequestRows->gst_value) ?></td>
                <td><?= h($sellerRequestRows->purchase_rate) ?></td>
                <td><?= h($sellerRequestRows->sales_rate) ?></td>
                <td><?= h($sellerRequestRows->gst_type) ?></td>
                <td><?= h($sellerRequestRows->mrp) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SellerRequestRows', 'action' => 'view', $sellerRequestRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SellerRequestRows', 'action' => 'edit', $sellerRequestRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SellerRequestRows', 'action' => 'delete', $sellerRequestRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sellerRequestRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
