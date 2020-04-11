<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PromotionDetail $promotionDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $promotionDetail->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $promotionDetail->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Promotion Details'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Promotions'), ['controller' => 'Promotions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Promotion'), ['controller' => 'Promotions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="promotionDetails form large-9 medium-8 columns content">
    <?= $this->Form->create($promotionDetail) ?>
    <fieldset>
        <legend><?= __('Edit Promotion Detail') ?></legend>
        <?php
            echo $this->Form->control('promotion_id', ['options' => $promotions]);
            echo $this->Form->control('category_id', ['options' => $categories]);
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('discount_in_percentage');
            echo $this->Form->control('discount_in_amount');
            echo $this->Form->control('discount_of_max_amount');
            echo $this->Form->control('coupan_name');
            echo $this->Form->control('coupan_code');
            echo $this->Form->control('buy_quntity');
            echo $this->Form->control('get_quntity');
            echo $this->Form->control('get_item_id');
            echo $this->Form->control('in_wallet');
            echo $this->Form->control('is_free_shipping');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
