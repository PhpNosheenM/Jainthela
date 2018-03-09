<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Seller $seller
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $seller->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $seller->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Sellers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Seller Items'), ['controller' => 'SellerItems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller Item'), ['controller' => 'SellerItems', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Seller Ratings'), ['controller' => 'SellerRatings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller Rating'), ['controller' => 'SellerRatings', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sellers form large-9 medium-8 columns content">
    <?= $this->Form->create($seller) ?>
    <fieldset>
        <legend><?= __('Edit Seller') ?></legend>
        <?php
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('name');
            echo $this->Form->control('username');
            echo $this->Form->control('password');
            echo $this->Form->control('email');
            echo $this->Form->control('mobile_no');
            echo $this->Form->control('latitude');
            echo $this->Form->control('longitude');
            echo $this->Form->control('gstin');
            echo $this->Form->control('gstin_holder_name');
            echo $this->Form->control('gstin_holder_address');
            echo $this->Form->control('firm_name');
            echo $this->Form->control('firm_address');
            echo $this->Form->control('registration_date');
            echo $this->Form->control('termination_date');
            echo $this->Form->control('termination_reason');
            echo $this->Form->control('breif_decription');
            echo $this->Form->control('passkey');
            echo $this->Form->control('timeout');
            echo $this->Form->control('created_on');
            echo $this->Form->control('created_by');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
