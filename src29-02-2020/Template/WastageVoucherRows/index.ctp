<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WastageVoucherRow[]|\Cake\Collection\CollectionInterface $wastageVoucherRows
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Wastage Voucher Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Wastage Vouchers'), ['controller' => 'WastageVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wastage Voucher'), ['controller' => 'WastageVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="wastageVoucherRows index large-9 medium-8 columns content">
    <h3><?= __('Wastage Voucher Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('wastage_voucher_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_variation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wastageVoucherRows as $wastageVoucherRow): ?>
            <tr>
                <td><?= $this->Number->format($wastageVoucherRow->id) ?></td>
                <td><?= $wastageVoucherRow->has('wastage_voucher') ? $this->Html->link($wastageVoucherRow->wastage_voucher->id, ['controller' => 'WastageVouchers', 'action' => 'view', $wastageVoucherRow->wastage_voucher->id]) : '' ?></td>
                <td><?= $wastageVoucherRow->has('item') ? $this->Html->link($wastageVoucherRow->item->name, ['controller' => 'Items', 'action' => 'view', $wastageVoucherRow->item->id]) : '' ?></td>
                <td><?= $wastageVoucherRow->has('item_variation') ? $this->Html->link($wastageVoucherRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $wastageVoucherRow->item_variation->id]) : '' ?></td>
                <td><?= $this->Number->format($wastageVoucherRow->quantity) ?></td>
                <td><?= $this->Number->format($wastageVoucherRow->rate) ?></td>
                <td><?= $this->Number->format($wastageVoucherRow->amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $wastageVoucherRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $wastageVoucherRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $wastageVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wastageVoucherRow->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
