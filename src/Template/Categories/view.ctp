<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Category'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Child Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Promotion Details'), ['controller' => 'PromotionDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Promotion Detail'), ['controller' => 'PromotionDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Seller Items'), ['controller' => 'SellerItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller Item'), ['controller' => 'SellerItems', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="categories view large-9 medium-8 columns content">
    <h3><?= h($category->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($category->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent Category') ?></th>
            <td><?= $category->has('parent_category') ? $this->Html->link($category->parent_category->name, ['controller' => 'Categories', 'action' => 'view', $category->parent_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $category->has('city') ? $this->Html->link($category->city->name, ['controller' => 'Cities', 'action' => 'view', $category->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($category->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($category->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lft') ?></th>
            <td><?= $this->Number->format($category->lft) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rght') ?></th>
            <td><?= $this->Number->format($category->rght) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($category->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited By') ?></th>
            <td><?= $this->Number->format($category->edited_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($category->created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited On') ?></th>
            <td><?= h($category->edited_on) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Categories') ?></h4>
        <?php if (!empty($category->child_categories)): ?>
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
            <?php foreach ($category->child_categories as $childCategories): ?>
            <tr>
                <td><?= h($childCategories->id) ?></td>
                <td><?= h($childCategories->name) ?></td>
                <td><?= h($childCategories->parent_id) ?></td>
                <td><?= h($childCategories->lft) ?></td>
                <td><?= h($childCategories->rght) ?></td>
                <td><?= h($childCategories->city_id) ?></td>
                <td><?= h($childCategories->created_on) ?></td>
                <td><?= h($childCategories->created_by) ?></td>
                <td><?= h($childCategories->edited_on) ?></td>
                <td><?= h($childCategories->edited_by) ?></td>
                <td><?= h($childCategories->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Categories', 'action' => 'view', $childCategories->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Categories', 'action' => 'edit', $childCategories->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Categories', 'action' => 'delete', $childCategories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childCategories->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Items') ?></h4>
        <?php if (!empty($category->items)): ?>
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
            <?php foreach ($category->items as $items): ?>
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
        <h4><?= __('Related Promotion Details') ?></h4>
        <?php if (!empty($category->promotion_details)): ?>
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
            <?php foreach ($category->promotion_details as $promotionDetails): ?>
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
        <h4><?= __('Related Seller Items') ?></h4>
        <?php if (!empty($category->seller_items)): ?>
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
            <?php foreach ($category->seller_items as $sellerItems): ?>
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
