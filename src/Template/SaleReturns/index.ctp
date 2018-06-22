<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SaleReturn[]|\Cake\Collection\CollectionInterface $saleReturns
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Sale Return'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Party Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Party Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Ledgers'), ['controller' => 'ItemLedgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Ledger'), ['controller' => 'ItemLedgers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reference Details'), ['controller' => 'ReferenceDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['controller' => 'ReferenceDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sale Return Rows'), ['controller' => 'SaleReturnRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale Return Row'), ['controller' => 'SaleReturnRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="saleReturns index large-9 medium-8 columns content">
    <h3><?= __('Sale Returns') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount_before_tax') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_cgst') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_sgst') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_igst') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount_after_tax') ?></th>
                <th scope="col"><?= $this->Paginator->sort('round_off') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_ledger_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('party_ledger_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($saleReturns as $saleReturn): ?>
            <tr>
                <td><?= $this->Number->format($saleReturn->id) ?></td>
                <td><?= $this->Number->format($saleReturn->voucher_no) ?></td>
                <td><?= h($saleReturn->transaction_date) ?></td>
                <td><?= $saleReturn->has('customer') ? $this->Html->link($saleReturn->customer->name, ['controller' => 'Customers', 'action' => 'view', $saleReturn->customer->id]) : '' ?></td>
                <td><?= $this->Number->format($saleReturn->amount_before_tax) ?></td>
                <td><?= $this->Number->format($saleReturn->total_cgst) ?></td>
                <td><?= $this->Number->format($saleReturn->total_sgst) ?></td>
                <td><?= $this->Number->format($saleReturn->total_igst) ?></td>
                <td><?= $this->Number->format($saleReturn->amount_after_tax) ?></td>
                <td><?= $this->Number->format($saleReturn->round_off) ?></td>
                <td><?= $this->Number->format($saleReturn->sales_ledger_id) ?></td>
                <td><?= $saleReturn->has('party_ledger') ? $this->Html->link($saleReturn->party_ledger->name, ['controller' => 'Ledgers', 'action' => 'view', $saleReturn->party_ledger->id]) : '' ?></td>
                <td><?= $saleReturn->has('location') ? $this->Html->link($saleReturn->location->name, ['controller' => 'Locations', 'action' => 'view', $saleReturn->location->id]) : '' ?></td>
                <td><?= $saleReturn->has('city') ? $this->Html->link($saleReturn->city->name, ['controller' => 'Cities', 'action' => 'view', $saleReturn->city->id]) : '' ?></td>
                <td><?= $saleReturn->has('order') ? $this->Html->link($saleReturn->order->id, ['controller' => 'Orders', 'action' => 'view', $saleReturn->order->id]) : '' ?></td>
                <td><?= h($saleReturn->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $saleReturn->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $saleReturn->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $saleReturn->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleReturn->id)]) ?>
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
