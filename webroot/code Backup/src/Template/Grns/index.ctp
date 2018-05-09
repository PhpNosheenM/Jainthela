<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grn[]|\Cake\Collection\CollectionInterface $grns
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Grn'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Seller Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="grns index large-9 medium-8 columns content">
    <h3><?= __('Grns') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('grn_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reference_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_taxable_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_gst') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grns as $grn): ?>
            <tr>
                <td><?= $this->Number->format($grn->id) ?></td>
                <td><?= $this->Number->format($grn->voucher_no) ?></td>
                <td><?= $this->Number->format($grn->grn_no) ?></td>
                <td><?= $grn->has('location') ? $this->Html->link($grn->location->name, ['controller' => 'Locations', 'action' => 'view', $grn->location->id]) : '' ?></td>
                <td><?= $grn->has('order') ? $this->Html->link($grn->order->id, ['controller' => 'Orders', 'action' => 'view', $grn->order->id]) : '' ?></td>
                <td><?= h($grn->transaction_date) ?></td>
                <td><?= h($grn->reference_no) ?></td>
                <td><?= h($grn->status) ?></td>
                <td><?= $this->Number->format($grn->total_taxable_value) ?></td>
                <td><?= $this->Number->format($grn->total_gst) ?></td>
                <td><?= $this->Number->format($grn->total_amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $grn->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $grn->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $grn->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grn->id)]) ?>
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
