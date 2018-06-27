<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseReturn[]|\Cake\Collection\CollectionInterface $purchaseReturns
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Purchase Return'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Invoices'), ['controller' => 'PurchaseInvoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Invoice'), ['controller' => 'PurchaseInvoices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Financial Years'), ['controller' => 'FinancialYears', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Financial Year'), ['controller' => 'FinancialYears', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Seller Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Ledgers'), ['controller' => 'ItemLedgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Ledger'), ['controller' => 'ItemLedgers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Return Rows'), ['controller' => 'PurchaseReturnRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Return Row'), ['controller' => 'PurchaseReturnRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reference Details'), ['controller' => 'ReferenceDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['controller' => 'ReferenceDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="purchaseReturns index large-9 medium-8 columns content">
    <h3><?= __('Purchase Returns') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_invoice_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('financial_year_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('seller_ledger_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_ledger_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_taxable_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_gst') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('entry_from') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('edited_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('edited_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchaseReturns as $purchaseReturn): ?>
            <tr>
                <td><?= $this->Number->format($purchaseReturn->id) ?></td>
                <td><?= $purchaseReturn->has('purchase_invoice') ? $this->Html->link($purchaseReturn->purchase_invoice->id, ['controller' => 'PurchaseInvoices', 'action' => 'view', $purchaseReturn->purchase_invoice->id]) : '' ?></td>
                <td><?= $purchaseReturn->has('financial_year') ? $this->Html->link($purchaseReturn->financial_year->id, ['controller' => 'FinancialYears', 'action' => 'view', $purchaseReturn->financial_year->id]) : '' ?></td>
                <td><?= h($purchaseReturn->voucher_no) ?></td>
                <td><?= h($purchaseReturn->invoice_no) ?></td>
                <td><?= $purchaseReturn->has('location') ? $this->Html->link($purchaseReturn->location->name, ['controller' => 'Locations', 'action' => 'view', $purchaseReturn->location->id]) : '' ?></td>
                <td><?= h($purchaseReturn->transaction_date) ?></td>
                <td><?= $purchaseReturn->has('seller_ledger') ? $this->Html->link($purchaseReturn->seller_ledger->name, ['controller' => 'Ledgers', 'action' => 'view', $purchaseReturn->seller_ledger->id]) : '' ?></td>
                <td><?= $purchaseReturn->has('purchase_ledger') ? $this->Html->link($purchaseReturn->purchase_ledger->name, ['controller' => 'Ledgers', 'action' => 'view', $purchaseReturn->purchase_ledger->id]) : '' ?></td>
                <td><?= $this->Number->format($purchaseReturn->total_taxable_value) ?></td>
                <td><?= $this->Number->format($purchaseReturn->total_gst) ?></td>
                <td><?= $this->Number->format($purchaseReturn->total_amount) ?></td>
                <td><?= h($purchaseReturn->entry_from) ?></td>
                <td><?= $purchaseReturn->has('city') ? $this->Html->link($purchaseReturn->city->name, ['controller' => 'Cities', 'action' => 'view', $purchaseReturn->city->id]) : '' ?></td>
                <td><?= $this->Number->format($purchaseReturn->created_by) ?></td>
                <td><?= $this->Number->format($purchaseReturn->edited_by) ?></td>
                <td><?= h($purchaseReturn->created_on) ?></td>
                <td><?= h($purchaseReturn->edited_on) ?></td>
                <td><?= h($purchaseReturn->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $purchaseReturn->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $purchaseReturn->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $purchaseReturn->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseReturn->id)]) ?>
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
