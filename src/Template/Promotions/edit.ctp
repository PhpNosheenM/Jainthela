<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Promotion $promotion
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $promotion->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $promotion->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Promotions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Admins'), ['controller' => 'Admins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Admin'), ['controller' => 'Admins', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Promotion Details'), ['controller' => 'PromotionDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Promotion Detail'), ['controller' => 'PromotionDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Wallets'), ['controller' => 'Wallets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wallet'), ['controller' => 'Wallets', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="promotions form large-9 medium-8 columns content">
    <?= $this->Form->create($promotion) ?>
    <fieldset>
        <legend><?= __('Edit Promotion') ?></legend>
        <?php
            echo $this->Form->control('admin_id', ['options' => $admins]);
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('offer_name');
            echo $this->Form->control('description');
            echo $this->Form->control('start_date');
            echo $this->Form->control('end_date');
            echo $this->Form->control('created_on');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
