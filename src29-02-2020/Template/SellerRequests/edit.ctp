<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SellerRequest $sellerRequest
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $sellerRequest->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sellerRequest->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Seller Requests'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Sellers'), ['controller' => 'Sellers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller'), ['controller' => 'Sellers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Seller Request Rows'), ['controller' => 'SellerRequestRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller Request Row'), ['controller' => 'SellerRequestRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sellerRequests form large-9 medium-8 columns content">
    <?= $this->Form->create($sellerRequest) ?>
    <fieldset>
        <legend><?= __('Edit Seller Request') ?></legend>
        <?php
            echo $this->Form->control('seller_id', ['options' => $sellers]);
            echo $this->Form->control('voucher_no');
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('status');
            echo $this->Form->control('total_taxable_value');
            echo $this->Form->control('total_gst');
            echo $this->Form->control('total_amount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
