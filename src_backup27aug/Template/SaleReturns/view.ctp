<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SaleReturn $saleReturn
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sale Return'), ['action' => 'edit', $saleReturn->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sale Return'), ['action' => 'delete', $saleReturn->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleReturn->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Party Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Party Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounting Entries'), ['controller' => 'AccountingEntries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting Entry'), ['controller' => 'AccountingEntries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Ledgers'), ['controller' => 'ItemLedgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Ledger'), ['controller' => 'ItemLedgers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reference Details'), ['controller' => 'ReferenceDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['controller' => 'ReferenceDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Return Rows'), ['controller' => 'SaleReturnRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return Row'), ['controller' => 'SaleReturnRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="saleReturns view large-9 medium-8 columns content">
    <h3><?= h($saleReturn->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $saleReturn->has('customer') ? $this->Html->link($saleReturn->customer->name, ['controller' => 'Customers', 'action' => 'view', $saleReturn->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Party Ledger') ?></th>
            <td><?= $saleReturn->has('party_ledger') ? $this->Html->link($saleReturn->party_ledger->name, ['controller' => 'Ledgers', 'action' => 'view', $saleReturn->party_ledger->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $saleReturn->has('location') ? $this->Html->link($saleReturn->location->name, ['controller' => 'Locations', 'action' => 'view', $saleReturn->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $saleReturn->has('city') ? $this->Html->link($saleReturn->city->name, ['controller' => 'Cities', 'action' => 'view', $saleReturn->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order') ?></th>
            <td><?= $saleReturn->has('order') ? $this->Html->link($saleReturn->order->id, ['controller' => 'Orders', 'action' => 'view', $saleReturn->order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($saleReturn->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($saleReturn->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voucher No') ?></th>
            <td><?= $this->Number->format($saleReturn->voucher_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount Before Tax') ?></th>
            <td><?= $this->Number->format($saleReturn->amount_before_tax) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Cgst') ?></th>
            <td><?= $this->Number->format($saleReturn->total_cgst) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Sgst') ?></th>
            <td><?= $this->Number->format($saleReturn->total_sgst) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Igst') ?></th>
            <td><?= $this->Number->format($saleReturn->total_igst) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount After Tax') ?></th>
            <td><?= $this->Number->format($saleReturn->amount_after_tax) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Round Off') ?></th>
            <td><?= $this->Number->format($saleReturn->round_off) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Ledger Id') ?></th>
            <td><?= $this->Number->format($saleReturn->sales_ledger_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($saleReturn->transaction_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Accounting Entries') ?></h4>
        <?php if (!empty($saleReturn->accounting_entries)): ?>
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
            <?php foreach ($saleReturn->accounting_entries as $accountingEntries): ?>
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
        <?php if (!empty($saleReturn->item_ledgers)): ?>
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
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Entry From') ?></th>
                <th scope="col"><?= __('Wastage') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($saleReturn->item_ledgers as $itemLedgers): ?>
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
        <h4><?= __('Related Reference Details') ?></h4>
        <?php if (!empty($saleReturn->reference_details)): ?>
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
            <?php foreach ($saleReturn->reference_details as $referenceDetails): ?>
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
    <div class="related">
        <h4><?= __('Related Sale Return Rows') ?></h4>
        <?php if (!empty($saleReturn->sale_return_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Sale Return Id') ?></th>
                <th scope="col"><?= __('Item Variation Id') ?></th>
                <th scope="col"><?= __('Return Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Taxable Value') ?></th>
                <th scope="col"><?= __('Gst Percentage') ?></th>
                <th scope="col"><?= __('Gst Figure Id') ?></th>
                <th scope="col"><?= __('Gst Value') ?></th>
                <th scope="col"><?= __('Net Amount') ?></th>
                <th scope="col"><?= __('Order Detail Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($saleReturn->sale_return_rows as $saleReturnRows): ?>
            <tr>
                <td><?= h($saleReturnRows->id) ?></td>
                <td><?= h($saleReturnRows->sale_return_id) ?></td>
                <td><?= h($saleReturnRows->item_variation_id) ?></td>
                <td><?= h($saleReturnRows->return_quantity) ?></td>
                <td><?= h($saleReturnRows->rate) ?></td>
                <td><?= h($saleReturnRows->amount) ?></td>
                <td><?= h($saleReturnRows->taxable_value) ?></td>
                <td><?= h($saleReturnRows->gst_percentage) ?></td>
                <td><?= h($saleReturnRows->gst_figure_id) ?></td>
                <td><?= h($saleReturnRows->gst_value) ?></td>
                <td><?= h($saleReturnRows->net_amount) ?></td>
                <td><?= h($saleReturnRows->order_detail_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SaleReturnRows', 'action' => 'view', $saleReturnRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SaleReturnRows', 'action' => 'edit', $saleReturnRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SaleReturnRows', 'action' => 'delete', $saleReturnRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleReturnRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
