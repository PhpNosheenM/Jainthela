<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ComboOfferDetail $comboOfferDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Combo Offer Detail'), ['action' => 'edit', $comboOfferDetail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Combo Offer Detail'), ['action' => 'delete', $comboOfferDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comboOfferDetail->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Combo Offer Details'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo Offer Detail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combo Offers'), ['controller' => 'ComboOffers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo Offer'), ['controller' => 'ComboOffers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Units'), ['controller' => 'Units', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit'), ['controller' => 'Units', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="comboOfferDetails view large-9 medium-8 columns content">
    <h3><?= h($comboOfferDetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Combo Offer') ?></th>
            <td><?= $comboOfferDetail->has('combo_offer') ? $this->Html->link($comboOfferDetail->combo_offer->name, ['controller' => 'ComboOffers', 'action' => 'view', $comboOfferDetail->combo_offer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $comboOfferDetail->has('item_variation') ? $this->Html->link($comboOfferDetail->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $comboOfferDetail->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($comboOfferDetail->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($comboOfferDetail->quantity) ?></td>
        </tr>
    </table>
</div>
