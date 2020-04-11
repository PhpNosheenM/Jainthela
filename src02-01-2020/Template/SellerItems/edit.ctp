<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SellerItem $sellerItem
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $sellerItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sellerItem->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Seller Items'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sellers'), ['controller' => 'Sellers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller'), ['controller' => 'Sellers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Seller Item Variations'), ['controller' => 'SellerItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller Item Variation'), ['controller' => 'SellerItemVariations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sellerItems form large-9 medium-8 columns content">
    <?= $this->Form->create($sellerItem) ?>
    <fieldset>
        <legend><?= __('Edit Seller Item') ?></legend>
        <?php
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('category_id', ['options' => $categories]);
            echo $this->Form->control('seller_id', ['options' => $sellers]);
            echo $this->Form->control('created_on');
            echo $this->Form->control('created_by');
            echo $this->Form->control('commission_percentage');
            echo $this->Form->control('commission_created_on');
            echo $this->Form->control('expiry_on_date');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
