<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WastageVoucherRow $wastageVoucherRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Wastage Voucher Row'), ['action' => 'edit', $wastageVoucherRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Wastage Voucher Row'), ['action' => 'delete', $wastageVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wastageVoucherRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Wastage Voucher Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wastage Voucher Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wastage Vouchers'), ['controller' => 'WastageVouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wastage Voucher'), ['controller' => 'WastageVouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="wastageVoucherRows view large-9 medium-8 columns content">
    <h3><?= h($wastageVoucherRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Wastage Voucher') ?></th>
            <td><?= $wastageVoucherRow->has('wastage_voucher') ? $this->Html->link($wastageVoucherRow->wastage_voucher->id, ['controller' => 'WastageVouchers', 'action' => 'view', $wastageVoucherRow->wastage_voucher->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $wastageVoucherRow->has('item') ? $this->Html->link($wastageVoucherRow->item->name, ['controller' => 'Items', 'action' => 'view', $wastageVoucherRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $wastageVoucherRow->has('item_variation') ? $this->Html->link($wastageVoucherRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $wastageVoucherRow->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($wastageVoucherRow->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($wastageVoucherRow->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $this->Number->format($wastageVoucherRow->rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($wastageVoucherRow->amount) ?></td>
        </tr>
    </table>
</div>
