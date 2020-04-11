<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cart $cart
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cart'), ['action' => 'edit', $cart->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cart'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Carts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cart'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combo Offers'), ['controller' => 'ComboOffers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo Offer'), ['controller' => 'ComboOffers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="carts view large-9 medium-8 columns content">
    <h3><?= h($cart->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $cart->has('city') ? $this->Html->link($cart->city->name, ['controller' => 'Cities', 'action' => 'view', $cart->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $cart->has('customer') ? $this->Html->link($cart->customer->name, ['controller' => 'Customers', 'action' => 'view', $cart->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $cart->has('item_variation') ? $this->Html->link($cart->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $cart->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Combo Offer') ?></th>
            <td><?= $cart->has('combo_offer') ? $this->Html->link($cart->combo_offer->name, ['controller' => 'ComboOffers', 'action' => 'view', $cart->combo_offer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($cart->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($cart->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $this->Number->format($cart->rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($cart->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cart Count') ?></th>
            <td><?= $this->Number->format($cart->cart_count) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($cart->created_on) ?></td>
        </tr>
    </table>
</div>
