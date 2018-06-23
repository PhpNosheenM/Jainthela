<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WastageVoucher[]|\Cake\Collection\CollectionInterface $wastageVouchers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Wastage Voucher'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Wastage Voucher Rows'), ['controller' => 'WastageVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wastage Voucher Row'), ['controller' => 'WastageVoucherRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="wastageVouchers index large-9 medium-8 columns content">
    <h3><?= __('Wastage Vouchers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wastageVouchers as $wastageVoucher): ?>
            <tr>
                <td><?= $this->Number->format($wastageVoucher->id) ?></td>
                <td><?= $this->Number->format($wastageVoucher->voucher_no) ?></td>
                <td><?= $wastageVoucher->has('city') ? $this->Html->link($wastageVoucher->city->name, ['controller' => 'Cities', 'action' => 'view', $wastageVoucher->city->id]) : '' ?></td>
                <td><?= $wastageVoucher->has('location') ? $this->Html->link($wastageVoucher->location->name, ['controller' => 'Locations', 'action' => 'view', $wastageVoucher->location->id]) : '' ?></td>
                <td><?= h($wastageVoucher->created_on) ?></td>
                <td><?= $this->Number->format($wastageVoucher->created_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $wastageVoucher->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $wastageVoucher->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $wastageVoucher->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wastageVoucher->id)]) ?>
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
