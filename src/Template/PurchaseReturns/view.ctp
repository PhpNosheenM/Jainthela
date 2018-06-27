<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseReturn $purchaseReturn
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Purchase Return'), ['action' => 'edit', $purchaseReturn->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Purchase Return'), ['action' => 'delete', $purchaseReturn->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseReturn->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Returns'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Return'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Invoices'), ['controller' => 'PurchaseInvoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Invoice'), ['controller' => 'PurchaseInvoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Financial Years'), ['controller' => 'FinancialYears', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Financial Year'), ['controller' => 'FinancialYears', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Seller Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Ledgers'), ['controller' => 'ItemLedgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Ledger'), ['controller' => 'ItemLedgers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Return Rows'), ['controller' => 'PurchaseReturnRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Return Row'), ['controller' => 'PurchaseReturnRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reference Details'), ['controller' => 'ReferenceDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['controller' => 'ReferenceDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="purchaseReturns view large-9 medium-8 columns content">
    <h3><?= h($purchaseReturn->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Purchase Invoice') ?></th>
            <td><?= $purchaseReturn->has('purchase_invoice') ? $this->Html->link($purchaseReturn->purchase_invoice->id, ['controller' => 'PurchaseInvoices', 'action' => 'view', $purchaseReturn->purchase_invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Financial Year') ?></th>
            <td><?= $purchaseReturn->has('financial_year') ? $this->Html->link($purchaseReturn->financial_year->id, ['controller' => 'FinancialYears', 'action' => 'view', $purchaseReturn->financial_year->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voucher No') ?></th>
            <td><?= h($purchaseReturn->voucher_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Invoice No') ?></th>
            <td><?= h($purchaseReturn->invoice_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $purchaseReturn->has('location') ? $this->Html->link($purchaseReturn->location->name, ['controller' => 'Locations', 'action' => 'view', $purchaseReturn->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Seller Ledger') ?></th>
            <td><?= $purchaseReturn->has('seller_ledger') ? $this->Html->link($purchaseReturn->seller_ledger->name, ['controller' => 'Ledgers', 'action' => 'view', $purchaseReturn->seller_ledger->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Ledger') ?></th>
            <td><?= $purchaseReturn->has('purchase_ledger') ? $this->Html->link($purchaseReturn->purchase_ledger->name, ['controller' => 'Ledgers', 'action' => 'view', $purchaseReturn->purchase_ledger->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Entry From') ?></th>
            <td><?= h($purchaseReturn->entry_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $purchaseReturn->has('city') ? $this->Html->link($purchaseReturn->city->name, ['controller' => 'Cities', 'action' => 'view', $purchaseReturn->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($purchaseReturn->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($purchaseReturn->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Taxable Value') ?></th>
            <td><?= $this->Number->format($purchaseReturn->total_taxable_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Gst') ?></th>
            <td><?= $this->Number->format($purchaseReturn->total_gst) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Amount') ?></th>
            <td><?= $this->Number->format($purchaseReturn->total_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($purchaseReturn->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited By') ?></th>
            <td><?= $this->Number->format($purchaseReturn->edited_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($purchaseReturn->transaction_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($purchaseReturn->created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited On') ?></th>
            <td><?= h($purchaseReturn->edited_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Narration') ?></h4>
        <?= $this->Text->autoParagraph(h($purchaseReturn->narration)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Accounting Entries') ?></h4>
        <?php if (!empty($purchaseReturn->accounting_entries)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Ledger Id') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Purchase Voucher Id') ?></th>
                <th scope="col"><?= __('Purchase Voucher Row Id') ?></th>
                <th scope="col"><?= __('Is Opening Balance') ?></th>
                <th scope="col"><?= __('Sales Invoice Id') ?></th>
                <th scope="col"><?= __('Order Id') ?></th>
                <th scope="col"><?= __('Sale Return Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Id') ?></th>
                <th scope="col"><?= __('Purchase Return Id') ?></th>
                <th scope="col"><?= __('Receipt Id') ?></th>
                <th scope="col"><?= __('Receipt Row Id') ?></th>
                <th scope="col"><?= __('Payment Id') ?></th>
                <th scope="col"><?= __('Payment Row Id') ?></th>
                <th scope="col"><?= __('Credit Note Id') ?></th>
                <th scope="col"><?= __('Credit Note Row Id') ?></th>
                <th scope="col"><?= __('Debit Note Id') ?></th>
                <th scope="col"><?= __('Debit Note Row Id') ?></th>
                <th scope="col"><?= __('Sales Voucher Id') ?></th>
                <th scope="col"><?= __('Sales Voucher Row Id') ?></th>
                <th scope="col"><?= __('Journal Voucher Id') ?></th>
                <th scope="col"><?= __('Journal Voucher Row Id') ?></th>
                <th scope="col"><?= __('Contra Voucher Id') ?></th>
                <th scope="col"><?= __('Contra Voucher Row Id') ?></th>
                <th scope="col"><?= __('Reconciliation Date') ?></th>
                <th scope="col"><?= __('Entry From') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($purchaseReturn->accounting_entries as $accountingEntries): ?>
            <tr>
                <td><?= h($accountingEntries->id) ?></td>
                <td><?= h($accountingEntries->ledger_id) ?></td>
                <td><?= h($accountingEntries->debit) ?></td>
                <td><?= h($accountingEntries->credit) ?></td>
                <td><?= h($accountingEntries->transaction_date) ?></td>
                <td><?= h($accountingEntries->location_id) ?></td>
                <td><?= h($accountingEntries->city_id) ?></td>
                <td><?= h($accountingEntries->purchase_voucher_id) ?></td>
                <td><?= h($accountingEntries->purchase_voucher_row_id) ?></td>
                <td><?= h($accountingEntries->is_opening_balance) ?></td>
                <td><?= h($accountingEntries->sales_invoice_id) ?></td>
                <td><?= h($accountingEntries->order_id) ?></td>
                <td><?= h($accountingEntries->sale_return_id) ?></td>
                <td><?= h($accountingEntries->purchase_invoice_id) ?></td>
                <td><?= h($accountingEntries->purchase_return_id) ?></td>
                <td><?= h($accountingEntries->receipt_id) ?></td>
                <td><?= h($accountingEntries->receipt_row_id) ?></td>
                <td><?= h($accountingEntries->payment_id) ?></td>
                <td><?= h($accountingEntries->payment_row_id) ?></td>
                <td><?= h($accountingEntries->credit_note_id) ?></td>
                <td><?= h($accountingEntries->credit_note_row_id) ?></td>
                <td><?= h($accountingEntries->debit_note_id) ?></td>
                <td><?= h($accountingEntries->debit_note_row_id) ?></td>
                <td><?= h($accountingEntries->sales_voucher_id) ?></td>
                <td><?= h($accountingEntries->sales_voucher_row_id) ?></td>
                <td><?= h($accountingEntries->journal_voucher_id) ?></td>
                <td><?= h($accountingEntries->journal_voucher_row_id) ?></td>
                <td><?= h($accountingEntries->contra_voucher_id) ?></td>
                <td><?= h($accountingEntries->contra_voucher_row_id) ?></td>
                <td><?= h($accountingEntries->reconciliation_date) ?></td>
                <td><?= h($accountingEntries->entry_from) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AccountingEntries', 'action' => 'view', $accountingEntries->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AccountingEntries', 'action' => 'edit', $accountingEntries->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccountingEntries', 'action' => 'delete', $accountingEntries->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountingEntries->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Item Ledgers') ?></h4>
        <?php if (!empty($purchaseReturn->item_ledgers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Unit Variation Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Seller Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Order Id') ?></th>
                <th scope="col"><?= __('Order Detail Id') ?></th>
                <th scope="col"><?= __('Grn Id') ?></th>
                <th scope="col"><?= __('Grn Row Id') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Is Opening Balance') ?></th>
                <th scope="col"><?= __('Sale Rate') ?></th>
                <th scope="col"><?= __('Purchase Rate') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Credit Note Id') ?></th>
                <th scope="col"><?= __('Credit Note Row Id') ?></th>
                <th scope="col"><?= __('Sale Return Id') ?></th>
                <th scope="col"><?= __('Sale Return Row Id') ?></th>
                <th scope="col"><?= __('Stock Transfer Voucher Id') ?></th>
                <th scope="col"><?= __('Stock Transfer Voucher Row Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Row Id') ?></th>
                <th scope="col"><?= __('Purchase Return Id') ?></th>
                <th scope="col"><?= __('Purchase Return Row Id') ?></th>
                <th scope="col"><?= __('Wastage Voucher Id') ?></th>
                <th scope="col"><?= __('Wastage Voucher Row Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Entry From') ?></th>
                <th scope="col"><?= __('Wastage') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($purchaseReturn->item_ledgers as $itemLedgers): ?>
            <tr>
                <td><?= h($itemLedgers->id) ?></td>
                <td><?= h($itemLedgers->item_id) ?></td>
                <td><?= h($itemLedgers->unit_variation_id) ?></td>
                <td><?= h($itemLedgers->item_variation_id) ?></td>
                <td><?= h($itemLedgers->seller_id) ?></td>
                <td><?= h($itemLedgers->transaction_date) ?></td>
                <td><?= h($itemLedgers->quantity) ?></td>
                <td><?= h($itemLedgers->rate) ?></td>
                <td><?= h($itemLedgers->amount) ?></td>
                <td><?= h($itemLedgers->order_id) ?></td>
                <td><?= h($itemLedgers->order_detail_id) ?></td>
                <td><?= h($itemLedgers->grn_id) ?></td>
                <td><?= h($itemLedgers->grn_row_id) ?></td>
                <td><?= h($itemLedgers->status) ?></td>
                <td><?= h($itemLedgers->is_opening_balance) ?></td>
                <td><?= h($itemLedgers->sale_rate) ?></td>
                <td><?= h($itemLedgers->purchase_rate) ?></td>
                <td><?= h($itemLedgers->location_id) ?></td>
                <td><?= h($itemLedgers->credit_note_id) ?></td>
                <td><?= h($itemLedgers->credit_note_row_id) ?></td>
                <td><?= h($itemLedgers->sale_return_id) ?></td>
                <td><?= h($itemLedgers->sale_return_row_id) ?></td>
                <td><?= h($itemLedgers->stock_transfer_voucher_id) ?></td>
                <td><?= h($itemLedgers->stock_transfer_voucher_row_id) ?></td>
                <td><?= h($itemLedgers->purchase_invoice_id) ?></td>
                <td><?= h($itemLedgers->purchase_invoice_row_id) ?></td>
                <td><?= h($itemLedgers->purchase_return_id) ?></td>
                <td><?= h($itemLedgers->purchase_return_row_id) ?></td>
                <td><?= h($itemLedgers->wastage_voucher_id) ?></td>
                <td><?= h($itemLedgers->wastage_voucher_row_id) ?></td>
                <td><?= h($itemLedgers->city_id) ?></td>
                <td><?= h($itemLedgers->entry_from) ?></td>
                <td><?= h($itemLedgers->wastage) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ItemLedgers', 'action' => 'view', $itemLedgers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ItemLedgers', 'action' => 'edit', $itemLedgers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ItemLedgers', 'action' => 'delete', $itemLedgers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemLedgers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Purchase Return Rows') ?></h4>
        <?php if (!empty($purchaseReturn->purchase_return_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Purchase Return Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Row Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Discount Percentage') ?></th>
                <th scope="col"><?= __('Discount Amount') ?></th>
                <th scope="col"><?= __('Taxable Value') ?></th>
                <th scope="col"><?= __('Net Amount') ?></th>
                <th scope="col"><?= __('Gst Percentage') ?></th>
                <th scope="col"><?= __('Gst Value') ?></th>
                <th scope="col"><?= __('Round Off') ?></th>
                <th scope="col"><?= __('Purchase Rate') ?></th>
                <th scope="col"><?= __('Sales Rate') ?></th>
                <th scope="col"><?= __('Gst Type') ?></th>
                <th scope="col"><?= __('Mrp') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($purchaseReturn->purchase_return_rows as $purchaseReturnRows): ?>
            <tr>
                <td><?= h($purchaseReturnRows->id) ?></td>
                <td><?= h($purchaseReturnRows->purchase_return_id) ?></td>
                <td><?= h($purchaseReturnRows->purchase_invoice_row_id) ?></td>
                <td><?= h($purchaseReturnRows->item_id) ?></td>
                <td><?= h($purchaseReturnRows->item_variation_id) ?></td>
                <td><?= h($purchaseReturnRows->quantity) ?></td>
                <td><?= h($purchaseReturnRows->rate) ?></td>
                <td><?= h($purchaseReturnRows->discount_percentage) ?></td>
                <td><?= h($purchaseReturnRows->discount_amount) ?></td>
                <td><?= h($purchaseReturnRows->taxable_value) ?></td>
                <td><?= h($purchaseReturnRows->net_amount) ?></td>
                <td><?= h($purchaseReturnRows->gst_percentage) ?></td>
                <td><?= h($purchaseReturnRows->gst_value) ?></td>
                <td><?= h($purchaseReturnRows->round_off) ?></td>
                <td><?= h($purchaseReturnRows->purchase_rate) ?></td>
                <td><?= h($purchaseReturnRows->sales_rate) ?></td>
                <td><?= h($purchaseReturnRows->gst_type) ?></td>
                <td><?= h($purchaseReturnRows->mrp) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PurchaseReturnRows', 'action' => 'view', $purchaseReturnRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PurchaseReturnRows', 'action' => 'edit', $purchaseReturnRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PurchaseReturnRows', 'action' => 'delete', $purchaseReturnRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseReturnRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Reference Details') ?></h4>
        <?php if (!empty($purchaseReturn->reference_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Vendor Id') ?></th>
                <th scope="col"><?= __('Seller Id') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Location Id') ?></th>
                <th scope="col"><?= __('Ledger Id') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Ref Name') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Receipt Id') ?></th>
                <th scope="col"><?= __('Order Id') ?></th>
                <th scope="col"><?= __('Receipt Row Id') ?></th>
                <th scope="col"><?= __('Payment Row Id') ?></th>
                <th scope="col"><?= __('Payment Id') ?></th>
                <th scope="col"><?= __('Contra Voucher Row Id') ?></th>
                <th scope="col"><?= __('Contra Voucher Id') ?></th>
                <th scope="col"><?= __('Credit Note Id') ?></th>
                <th scope="col"><?= __('Credit Note Row Id') ?></th>
                <th scope="col"><?= __('Debit Note Id') ?></th>
                <th scope="col"><?= __('Debit Note Row Id') ?></th>
                <th scope="col"><?= __('Sales Voucher Row Id') ?></th>
                <th scope="col"><?= __('Purchase Voucher Row Id') ?></th>
                <th scope="col"><?= __('Journal Voucher Row Id') ?></th>
                <th scope="col"><?= __('Journal Voucher Id') ?></th>
                <th scope="col"><?= __('Sale Return Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Id') ?></th>
                <th scope="col"><?= __('Purchase Return Id') ?></th>
                <th scope="col"><?= __('Sales Invoice Id') ?></th>
                <th scope="col"><?= __('Opening Balance') ?></th>
                <th scope="col"><?= __('Due Days') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($purchaseReturn->reference_details as $referenceDetails): ?>
            <tr>
                <td><?= h($referenceDetails->id) ?></td>
                <td><?= h($referenceDetails->customer_id) ?></td>
                <td><?= h($referenceDetails->vendor_id) ?></td>
                <td><?= h($referenceDetails->seller_id) ?></td>
                <td><?= h($referenceDetails->transaction_date) ?></td>
                <td><?= h($referenceDetails->city_id) ?></td>
                <td><?= h($referenceDetails->location_id) ?></td>
                <td><?= h($referenceDetails->ledger_id) ?></td>
                <td><?= h($referenceDetails->type) ?></td>
                <td><?= h($referenceDetails->ref_name) ?></td>
                <td><?= h($referenceDetails->debit) ?></td>
                <td><?= h($referenceDetails->credit) ?></td>
                <td><?= h($referenceDetails->receipt_id) ?></td>
                <td><?= h($referenceDetails->order_id) ?></td>
                <td><?= h($referenceDetails->receipt_row_id) ?></td>
                <td><?= h($referenceDetails->payment_row_id) ?></td>
                <td><?= h($referenceDetails->payment_id) ?></td>
                <td><?= h($referenceDetails->contra_voucher_row_id) ?></td>
                <td><?= h($referenceDetails->contra_voucher_id) ?></td>
                <td><?= h($referenceDetails->credit_note_id) ?></td>
                <td><?= h($referenceDetails->credit_note_row_id) ?></td>
                <td><?= h($referenceDetails->debit_note_id) ?></td>
                <td><?= h($referenceDetails->debit_note_row_id) ?></td>
                <td><?= h($referenceDetails->sales_voucher_row_id) ?></td>
                <td><?= h($referenceDetails->purchase_voucher_row_id) ?></td>
                <td><?= h($referenceDetails->journal_voucher_row_id) ?></td>
                <td><?= h($referenceDetails->journal_voucher_id) ?></td>
                <td><?= h($referenceDetails->sale_return_id) ?></td>
                <td><?= h($referenceDetails->purchase_invoice_id) ?></td>
                <td><?= h($referenceDetails->purchase_return_id) ?></td>
                <td><?= h($referenceDetails->sales_invoice_id) ?></td>
                <td><?= h($referenceDetails->opening_balance) ?></td>
                <td><?= h($referenceDetails->due_days) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ReferenceDetails', 'action' => 'view', $referenceDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ReferenceDetails', 'action' => 'edit', $referenceDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ReferenceDetails', 'action' => 'delete', $referenceDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $referenceDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
