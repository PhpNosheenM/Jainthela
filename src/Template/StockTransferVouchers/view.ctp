<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StockTransferVoucher $stockTransferVoucher
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Stock Transfer Voucher'), ['action' => 'edit', $stockTransferVoucher->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Stock Transfer Voucher'), ['action' => 'delete', $stockTransferVoucher->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stockTransferVoucher->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Stock Transfer Vouchers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stock Transfer Voucher'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Grns'), ['controller' => 'Grns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grn'), ['controller' => 'Grns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Stock Transfer Voucher Rows'), ['controller' => 'StockTransferVoucherRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stock Transfer Voucher Row'), ['controller' => 'StockTransferVoucherRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="stockTransferVouchers view large-9 medium-8 columns content">
    <h3><?= h($stockTransferVoucher->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Grn') ?></th>
            <td><?= $stockTransferVoucher->has('grn') ? $this->Html->link($stockTransferVoucher->grn->id, ['controller' => 'Grns', 'action' => 'view', $stockTransferVoucher->grn->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $stockTransferVoucher->has('city') ? $this->Html->link($stockTransferVoucher->city->name, ['controller' => 'Cities', 'action' => 'view', $stockTransferVoucher->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $stockTransferVoucher->has('location') ? $this->Html->link($stockTransferVoucher->location->name, ['controller' => 'Locations', 'action' => 'view', $stockTransferVoucher->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($stockTransferVoucher->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voucher No') ?></th>
            <td><?= $this->Number->format($stockTransferVoucher->voucher_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($stockTransferVoucher->transaction_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Narration') ?></h4>
        <?= $this->Text->autoParagraph(h($stockTransferVoucher->narration)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Stock Transfer Voucher Rows') ?></h4>
        <?php if (!empty($stockTransferVoucher->stock_transfer_voucher_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Stock Transfer Voucher Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($stockTransferVoucher->stock_transfer_voucher_rows as $stockTransferVoucherRows): ?>
            <tr>
                <td><?= h($stockTransferVoucherRows->id) ?></td>
                <td><?= h($stockTransferVoucherRows->stock_transfer_voucher_id) ?></td>
                <td><?= h($stockTransferVoucherRows->item_id) ?></td>
                <td><?= h($stockTransferVoucherRows->item_variation_id) ?></td>
                <td><?= h($stockTransferVoucherRows->rate) ?></td>
                <td><?= h($stockTransferVoucherRows->quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'StockTransferVoucherRows', 'action' => 'view', $stockTransferVoucherRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'StockTransferVoucherRows', 'action' => 'edit', $stockTransferVoucherRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'StockTransferVoucherRows', 'action' => 'delete', $stockTransferVoucherRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stockTransferVoucherRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
