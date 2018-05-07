<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SellerItem $sellerItem
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Seller Item'), ['action' => 'edit', $sellerItem->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Seller Item'), ['action' => 'delete', $sellerItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sellerItem->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Seller Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sellers'), ['controller' => 'Sellers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller'), ['controller' => 'Sellers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Seller Item Variations'), ['controller' => 'SellerItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller Item Variation'), ['controller' => 'SellerItemVariations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sellerItems view large-9 medium-8 columns content">
    <h3><?= h($sellerItem->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $sellerItem->has('item') ? $this->Html->link($sellerItem->item->name, ['controller' => 'Items', 'action' => 'view', $sellerItem->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= $sellerItem->has('category') ? $this->Html->link($sellerItem->category->name, ['controller' => 'Categories', 'action' => 'view', $sellerItem->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Seller') ?></th>
            <td><?= $sellerItem->has('seller') ? $this->Html->link($sellerItem->seller->name, ['controller' => 'Sellers', 'action' => 'view', $sellerItem->seller->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($sellerItem->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($sellerItem->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Commission Percentage') ?></th>
            <td><?= $this->Number->format($sellerItem->commission_percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($sellerItem->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($sellerItem->created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Commission Created On') ?></th>
            <td><?= h($sellerItem->commission_created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Expiry On Date') ?></th>
            <td><?= h($sellerItem->expiry_on_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Seller Item Variations') ?></h4>
        <?php if (!empty($sellerItem->seller_item_variations)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Seller Item Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Unit Variation Id') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Edited On') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Edited By') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($sellerItem->seller_item_variations as $sellerItemVariations): ?>
            <tr>
                <td><?= h($sellerItemVariations->id) ?></td>
                <td><?= h($sellerItemVariations->seller_item_id) ?></td>
                <td><?= h($sellerItemVariations->item_id) ?></td>
                <td><?= h($sellerItemVariations->unit_variation_id) ?></td>
                <td><?= h($sellerItemVariations->created_on) ?></td>
                <td><?= h($sellerItemVariations->edited_on) ?></td>
                <td><?= h($sellerItemVariations->created_by) ?></td>
                <td><?= h($sellerItemVariations->edited_by) ?></td>
                <td><?= h($sellerItemVariations->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SellerItemVariations', 'action' => 'view', $sellerItemVariations->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SellerItemVariations', 'action' => 'edit', $sellerItemVariations->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SellerItemVariations', 'action' => 'delete', $sellerItemVariations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sellerItemVariations->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
