<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ComboOffer $comboOffer
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Combo Offer'), ['action' => 'edit', $comboOffer->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Combo Offer'), ['action' => 'delete', $comboOffer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comboOffer->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Combo Offers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo Offer'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Admins'), ['controller' => 'Admins', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Admin'), ['controller' => 'Admins', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Carts'), ['controller' => 'Carts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cart'), ['controller' => 'Carts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combo Offer Details'), ['controller' => 'ComboOfferDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo Offer Detail'), ['controller' => 'ComboOfferDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Order Details'), ['controller' => 'OrderDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order Detail'), ['controller' => 'OrderDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="comboOffers view large-9 medium-8 columns content">
    <h3><?= h($comboOffer->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $comboOffer->has('city') ? $this->Html->link($comboOffer->city->name, ['controller' => 'Cities', 'action' => 'view', $comboOffer->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Admin') ?></th>
            <td><?= $comboOffer->has('admin') ? $this->Html->link($comboOffer->admin->name, ['controller' => 'Admins', 'action' => 'view', $comboOffer->admin->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($comboOffer->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ready To Sale') ?></th>
            <td><?= h($comboOffer->ready_to_sale) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($comboOffer->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Combo Offer Image') ?></th>
            <td><?= h($comboOffer->combo_offer_image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($comboOffer->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Print Rate') ?></th>
            <td><?= $this->Number->format($comboOffer->print_rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Per') ?></th>
            <td><?= $this->Number->format($comboOffer->discount_per) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Rate') ?></th>
            <td><?= $this->Number->format($comboOffer->sales_rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity Factor') ?></th>
            <td><?= $this->Number->format($comboOffer->quantity_factor) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Print Quantity') ?></th>
            <td><?= $this->Number->format($comboOffer->print_quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Maximum Quantity Purchase') ?></th>
            <td><?= $this->Number->format($comboOffer->maximum_quantity_purchase) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Stock In Quantity') ?></th>
            <td><?= $this->Number->format($comboOffer->stock_in_quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Stock Out Quantity') ?></th>
            <td><?= $this->Number->format($comboOffer->stock_out_quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Date') ?></th>
            <td><?= h($comboOffer->start_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Date') ?></th>
            <td><?= h($comboOffer->end_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($comboOffer->created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited On') ?></th>
            <td><?= h($comboOffer->edited_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($comboOffer->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Carts') ?></h4>
        <?php if (!empty($comboOffer->carts)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Combo Offer Id') ?></th>
                <th scope="col"><?= __('Unit Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Cart Count') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($comboOffer->carts as $carts): ?>
            <tr>
                <td><?= h($carts->id) ?></td>
                <td><?= h($carts->city_id) ?></td>
                <td><?= h($carts->customer_id) ?></td>
                <td><?= h($carts->item_variation_id) ?></td>
                <td><?= h($carts->combo_offer_id) ?></td>
                <td><?= h($carts->unit_id) ?></td>
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
        <?php if (!empty($comboOffer->combo_offer_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Combo Offer Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Unit Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($comboOffer->combo_offer_details as $comboOfferDetails): ?>
            <tr>
                <td><?= h($comboOfferDetails->id) ?></td>
                <td><?= h($comboOfferDetails->combo_offer_id) ?></td>
                <td><?= h($comboOfferDetails->item_variation_id) ?></td>
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
        <h4><?= __('Related Order Details') ?></h4>
        <?php if (!empty($comboOffer->order_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Order Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Combo Offer Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($comboOffer->order_details as $orderDetails): ?>
            <tr>
                <td><?= h($orderDetails->id) ?></td>
                <td><?= h($orderDetails->order_id) ?></td>
                <td><?= h($orderDetails->item_variation_id) ?></td>
                <td><?= h($orderDetails->combo_offer_id) ?></td>
                <td><?= h($orderDetails->quantity) ?></td>
                <td><?= h($orderDetails->rate) ?></td>
                <td><?= h($orderDetails->amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'OrderDetails', 'action' => 'view', $orderDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'OrderDetails', 'action' => 'edit', $orderDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'OrderDetails', 'action' => 'delete', $orderDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
