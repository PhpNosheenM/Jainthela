<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppNotification $appNotification
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $appNotification->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $appNotification->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List App Notifications'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Combo Offers'), ['controller' => 'ComboOffers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Combo Offer'), ['controller' => 'ComboOffers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Wish Lists'), ['controller' => 'WishLists', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wish List'), ['controller' => 'WishLists', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List App Notification Customers'), ['controller' => 'AppNotificationCustomers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New App Notification Customer'), ['controller' => 'AppNotificationCustomers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="appNotifications form large-9 medium-8 columns content">
    <?= $this->Form->create($appNotification) ?>
    <fieldset>
        <legend><?= __('Edit App Notification') ?></legend>
        <?php
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('message');
            echo $this->Form->control('image_web');
            echo $this->Form->control('image_app');
            echo $this->Form->control('app_link');
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('item_variation_id', ['options' => $itemVariations]);
            echo $this->Form->control('combo_offer_id', ['options' => $comboOffers]);
            echo $this->Form->control('wish_list_id', ['options' => $wishLists]);
            echo $this->Form->control('category_id', ['options' => $categories]);
            echo $this->Form->control('screen_type');
            echo $this->Form->control('created_by');
            echo $this->Form->control('created_on');
            echo $this->Form->control('edited_by');
            echo $this->Form->control('edited_on');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
