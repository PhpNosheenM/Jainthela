<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StockTransferVoucher[]|\Cake\Collection\CollectionInterface $stockTransferVouchers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Stock Transfer Voucher'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Grns'), ['controller' => 'Grns', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Grn'), ['controller' => 'Grns', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Stock Transfer Voucher Rows'), ['controller' => 'StockTransferVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Stock Transfer Voucher Row'), ['controller' => 'StockTransferVoucherRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stockTransferVouchers index large-9 medium-8 columns content">
    <h3><?= __('Stock Transfer Vouchers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('grn_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_no') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stockTransferVouchers as $stockTransferVoucher): ?>
            <tr>
                <td><?= $this->Number->format($stockTransferVoucher->id) ?></td>
                <td><?= $stockTransferVoucher->has('grn') ? $this->Html->link($stockTransferVoucher->grn->id, ['controller' => 'Grns', 'action' => 'view', $stockTransferVoucher->grn->id]) : '' ?></td>
                <td><?= $stockTransferVoucher->has('city') ? $this->Html->link($stockTransferVoucher->city->name, ['controller' => 'Cities', 'action' => 'view', $stockTransferVoucher->city->id]) : '' ?></td>
                <td><?= h($stockTransferVoucher->transaction_date) ?></td>
                <td><?= $stockTransferVoucher->has('location') ? $this->Html->link($stockTransferVoucher->location->name, ['controller' => 'Locations', 'action' => 'view', $stockTransferVoucher->location->id]) : '' ?></td>
                <td><?= $this->Number->format($stockTransferVoucher->voucher_no) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $stockTransferVoucher->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $stockTransferVoucher->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $stockTransferVoucher->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stockTransferVoucher->id)]) ?>
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
