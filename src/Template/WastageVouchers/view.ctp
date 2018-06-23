<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WastageVoucher $wastageVoucher
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Wastage Voucher'), ['action' => 'edit', $wastageVoucher->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Wastage Voucher'), ['action' => 'delete', $wastageVoucher->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wastageVoucher->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Wastage Vouchers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wastage Voucher'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wastage Voucher Rows'), ['controller' => 'WastageVoucherRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wastage Voucher Row'), ['controller' => 'WastageVoucherRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="wastageVouchers view large-9 medium-8 columns content">
    <h3><?= h($wastageVoucher->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $wastageVoucher->has('city') ? $this->Html->link($wastageVoucher->city->name, ['controller' => 'Cities', 'action' => 'view', $wastageVoucher->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $wastageVoucher->has('location') ? $this->Html->link($wastageVoucher->location->name, ['controller' => 'Locations', 'action' => 'view', $wastageVoucher->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($wastageVoucher->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voucher No') ?></th>
            <td><?= $this->Number->format($wastageVoucher->voucher_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($wastageVoucher->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($wastageVoucher->created_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Narration') ?></h4>
        <?= $this->Text->autoParagraph(h($wastageVoucher->narration)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Wastage Voucher Rows') ?></h4>
        <?php if (!empty($wastageVoucher->wastage_voucher_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Wastage Voucher Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($wastageVoucher->wastage_voucher_rows as $wastageVoucherRows): ?>
            <tr>
                <td><?= h($wastageVoucherRows->id) ?></td>
                <td><?= h($wastageVoucherRows->wastage_voucher_id) ?></td>
                <td><?= h($wastageVoucherRows->item_id) ?></td>
                <td><?= h($wastageVoucherRows->item_variation_id) ?></td>
                <td><?= h($wastageVoucherRows->quantity) ?></td>
                <td><?= h($wastageVoucherRows->rate) ?></td>
                <td><?= h($wastageVoucherRows->amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'WastageVoucherRows', 'action' => 'view', $wastageVoucherRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'WastageVoucherRows', 'action' => 'edit', $wastageVoucherRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'WastageVoucherRows', 'action' => 'delete', $wastageVoucherRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wastageVoucherRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
