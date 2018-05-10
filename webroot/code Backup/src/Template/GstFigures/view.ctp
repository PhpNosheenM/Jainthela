<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GstFigure $gstFigure
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Gst Figure'), ['action' => 'edit', $gstFigure->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Gst Figure'), ['action' => 'delete', $gstFigure->id], ['confirm' => __('Are you sure you want to delete # {0}?', $gstFigure->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Gst Figures'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Gst Figure'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Return Rows'), ['controller' => 'SaleReturnRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return Row'), ['controller' => 'SaleReturnRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Invoice Rows'), ['controller' => 'SalesInvoiceRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Invoice Row'), ['controller' => 'SalesInvoiceRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="gstFigures view large-9 medium-8 columns content">
    <h3><?= h($gstFigure->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($gstFigure->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $gstFigure->has('location') ? $this->Html->link($gstFigure->location->name, ['controller' => 'Locations', 'action' => 'view', $gstFigure->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($gstFigure->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax Percentage') ?></th>
            <td><?= $this->Number->format($gstFigure->tax_percentage) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Ledgers') ?></h4>
        <?php if (!empty($gstFigure->ledgers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Accounting Group Id') ?></th>
                <th scope="col"><?= __('Freeze') ?></th>
                <th scope="col"><?= __('Company Id') ?></th>
                <th scope="col"><?= __('Supplier Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Tax Percentage') ?></th>
                <th scope="col"><?= __('Gst Type') ?></th>
                <th scope="col"><?= __('Input Output') ?></th>
                <th scope="col"><?= __('Gst Figure Id') ?></th>
                <th scope="col"><?= __('Bill To Bill Accounting') ?></th>
                <th scope="col"><?= __('Round Off') ?></th>
                <th scope="col"><?= __('Cash') ?></th>
                <th scope="col"><?= __('Flag') ?></th>
                <th scope="col"><?= __('Default Credit Days') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($gstFigure->ledgers as $ledgers): ?>
            <tr>
                <td><?= h($ledgers->id) ?></td>
                <td><?= h($ledgers->name) ?></td>
                <td><?= h($ledgers->accounting_group_id) ?></td>
                <td><?= h($ledgers->freeze) ?></td>
                <td><?= h($ledgers->company_id) ?></td>
                <td><?= h($ledgers->supplier_id) ?></td>
                <td><?= h($ledgers->customer_id) ?></td>
                <td><?= h($ledgers->tax_percentage) ?></td>
                <td><?= h($ledgers->gst_type) ?></td>
                <td><?= h($ledgers->input_output) ?></td>
                <td><?= h($ledgers->gst_figure_id) ?></td>
                <td><?= h($ledgers->bill_to_bill_accounting) ?></td>
                <td><?= h($ledgers->round_off) ?></td>
                <td><?= h($ledgers->cash) ?></td>
                <td><?= h($ledgers->flag) ?></td>
                <td><?= h($ledgers->default_credit_days) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Ledgers', 'action' => 'view', $ledgers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Ledgers', 'action' => 'edit', $ledgers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Ledgers', 'action' => 'delete', $ledgers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ledgers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sale Return Rows') ?></h4>
        <?php if (!empty($gstFigure->sale_return_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Sale Return Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Return Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Discount Percentage') ?></th>
                <th scope="col"><?= __('Taxable Value') ?></th>
                <th scope="col"><?= __('Net Amount') ?></th>
                <th scope="col"><?= __('Gst Figure Id') ?></th>
                <th scope="col"><?= __('Gst Value') ?></th>
                <th scope="col"><?= __('Sales Invoice Row Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($gstFigure->sale_return_rows as $saleReturnRows): ?>
            <tr>
                <td><?= h($saleReturnRows->id) ?></td>
                <td><?= h($saleReturnRows->sale_return_id) ?></td>
                <td><?= h($saleReturnRows->item_id) ?></td>
                <td><?= h($saleReturnRows->return_quantity) ?></td>
                <td><?= h($saleReturnRows->rate) ?></td>
                <td><?= h($saleReturnRows->discount_percentage) ?></td>
                <td><?= h($saleReturnRows->taxable_value) ?></td>
                <td><?= h($saleReturnRows->net_amount) ?></td>
                <td><?= h($saleReturnRows->gst_figure_id) ?></td>
                <td><?= h($saleReturnRows->gst_value) ?></td>
                <td><?= h($saleReturnRows->sales_invoice_row_id) ?></td>
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
    <div class="related">
        <h4><?= __('Related Sales Invoice Rows') ?></h4>
        <?php if (!empty($gstFigure->sales_invoice_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Sales Invoice Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Discount Percentage') ?></th>
                <th scope="col"><?= __('Taxable Value') ?></th>
                <th scope="col"><?= __('Net Amount') ?></th>
                <th scope="col"><?= __('Gst Figure Id') ?></th>
                <th scope="col"><?= __('Gst Value') ?></th>
                <th scope="col"><?= __('Is Gst Excluded') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($gstFigure->sales_invoice_rows as $salesInvoiceRows): ?>
            <tr>
                <td><?= h($salesInvoiceRows->id) ?></td>
                <td><?= h($salesInvoiceRows->sales_invoice_id) ?></td>
                <td><?= h($salesInvoiceRows->item_id) ?></td>
                <td><?= h($salesInvoiceRows->quantity) ?></td>
                <td><?= h($salesInvoiceRows->rate) ?></td>
                <td><?= h($salesInvoiceRows->discount_percentage) ?></td>
                <td><?= h($salesInvoiceRows->taxable_value) ?></td>
                <td><?= h($salesInvoiceRows->net_amount) ?></td>
                <td><?= h($salesInvoiceRows->gst_figure_id) ?></td>
                <td><?= h($salesInvoiceRows->gst_value) ?></td>
                <td><?= h($salesInvoiceRows->is_gst_excluded) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SalesInvoiceRows', 'action' => 'view', $salesInvoiceRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SalesInvoiceRows', 'action' => 'edit', $salesInvoiceRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SalesInvoiceRows', 'action' => 'delete', $salesInvoiceRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salesInvoiceRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
