<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Promotion $promotion
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Promotion'), ['action' => 'edit', $promotion->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Promotion'), ['action' => 'delete', $promotion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $promotion->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Promotions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Promotion'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Admins'), ['controller' => 'Admins', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Admin'), ['controller' => 'Admins', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Promotion Details'), ['controller' => 'PromotionDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Promotion Detail'), ['controller' => 'PromotionDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wallets'), ['controller' => 'Wallets', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wallet'), ['controller' => 'Wallets', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="promotions view large-9 medium-8 columns content">
    <h3><?= h($promotion->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Admin') ?></th>
            <td><?= $promotion->has('admin') ? $this->Html->link($promotion->admin->name, ['controller' => 'Admins', 'action' => 'view', $promotion->admin->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $promotion->has('city') ? $this->Html->link($promotion->city->name, ['controller' => 'Cities', 'action' => 'view', $promotion->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Offer Name') ?></th>
            <td><?= h($promotion->offer_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($promotion->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($promotion->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Date') ?></th>
            <td><?= h($promotion->start_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Date') ?></th>
            <td><?= h($promotion->end_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($promotion->created_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($promotion->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Promotion Details') ?></h4>
        <?php if (!empty($promotion->promotion_details)): ?>
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
            <?php foreach ($promotion->promotion_details as $promotionDetails): ?>
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
        <h4><?= __('Related Wallets') ?></h4>
        <?php if (!empty($promotion->wallets)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Order Id') ?></th>
                <th scope="col"><?= __('Plan Id') ?></th>
                <th scope="col"><?= __('Promotion Id') ?></th>
                <th scope="col"><?= __('Add Amount') ?></th>
                <th scope="col"><?= __('Used Amount') ?></th>
                <th scope="col"><?= __('Cancel To Wallet Online') ?></th>
                <th scope="col"><?= __('Narration') ?></th>
                <th scope="col"><?= __('Return Order Id') ?></th>
                <th scope="col"><?= __('Amount Type') ?></th>
                <th scope="col"><?= __('Transaction Type') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($promotion->wallets as $wallets): ?>
            <tr>
                <td><?= h($wallets->id) ?></td>
                <td><?= h($wallets->city_id) ?></td>
                <td><?= h($wallets->customer_id) ?></td>
                <td><?= h($wallets->order_id) ?></td>
                <td><?= h($wallets->plan_id) ?></td>
                <td><?= h($wallets->promotion_id) ?></td>
                <td><?= h($wallets->add_amount) ?></td>
                <td><?= h($wallets->used_amount) ?></td>
                <td><?= h($wallets->cancel_to_wallet_online) ?></td>
                <td><?= h($wallets->narration) ?></td>
                <td><?= h($wallets->return_order_id) ?></td>
                <td><?= h($wallets->amount_type) ?></td>
                <td><?= h($wallets->transaction_type) ?></td>
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
