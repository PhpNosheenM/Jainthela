<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Vendor $vendor
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Vendor'), ['action' => 'edit', $vendor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Vendor'), ['action' => 'delete', $vendor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendor->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Vendors'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vendor'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Vendor Details'), ['controller' => 'VendorDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vendor Detail'), ['controller' => 'VendorDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="vendors view large-9 medium-8 columns content">
    <h3><?= h($vendor->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $vendor->has('city') ? $this->Html->link($vendor->city->name, ['controller' => 'Cities', 'action' => 'view', $vendor->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($vendor->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gstin') ?></th>
            <td><?= h($vendor->gstin) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pan') ?></th>
            <td><?= h($vendor->pan) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gstin Holder Name') ?></th>
            <td><?= h($vendor->gstin_holder_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Firm Name') ?></th>
            <td><?= h($vendor->firm_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Firm Email') ?></th>
            <td><?= h($vendor->firm_email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Firm Contact') ?></th>
            <td><?= h($vendor->firm_contact) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Firm Pincode') ?></th>
            <td><?= h($vendor->firm_pincode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bill To Bill Accounting') ?></th>
            <td><?= h($vendor->bill_to_bill_accounting) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debit Credit') ?></th>
            <td><?= h($vendor->debit_credit) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($vendor->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($vendor->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($vendor->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Opening Balance Value') ?></th>
            <td><?= $this->Number->format($vendor->opening_balance_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registration Date') ?></th>
            <td><?= h($vendor->registration_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Termination Date') ?></th>
            <td><?= h($vendor->termination_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($vendor->created_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Gstin Holder Address') ?></h4>
        <?= $this->Text->autoParagraph(h($vendor->gstin_holder_address)); ?>
    </div>
    <div class="row">
        <h4><?= __('Firm Address') ?></h4>
        <?= $this->Text->autoParagraph(h($vendor->firm_address)); ?>
    </div>
    <div class="row">
        <h4><?= __('Termination Reason') ?></h4>
        <?= $this->Text->autoParagraph(h($vendor->termination_reason)); ?>
    </div>
    <div class="row">
        <h4><?= __('Breif Decription') ?></h4>
        <?= $this->Text->autoParagraph(h($vendor->breif_decription)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Ledgers') ?></h4>
        <?php if (!empty($vendor->ledgers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Accounting Group Id') ?></th>
                <th scope="col"><?= __('Freeze') ?></th>
                <th scope="col"><?= __('Supplier Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Seller Id') ?></th>
                <th scope="col"><?= __('Vendor Id') ?></th>
                <th scope="col"><?= __('Tax Percentage') ?></th>
                <th scope="col"><?= __('Gst Type') ?></th>
                <th scope="col"><?= __('Input Output') ?></th>
                <th scope="col"><?= __('Gst Figure Id') ?></th>
                <th scope="col"><?= __('Bill To Bill Accounting') ?></th>
                <th scope="col"><?= __('Round Off') ?></th>
                <th scope="col"><?= __('Cash') ?></th>
                <th scope="col"><?= __('Flag') ?></th>
                <th scope="col"><?= __('Default Credit Days') ?></th>
                <th scope="col"><?= __('Commission') ?></th>
                <th scope="col"><?= __('Sales Account') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($vendor->ledgers as $ledgers): ?>
            <tr>
                <td><?= h($ledgers->id) ?></td>
                <td><?= h($ledgers->name) ?></td>
                <td><?= h($ledgers->accounting_group_id) ?></td>
                <td><?= h($ledgers->freeze) ?></td>
                <td><?= h($ledgers->supplier_id) ?></td>
                <td><?= h($ledgers->customer_id) ?></td>
                <td><?= h($ledgers->seller_id) ?></td>
                <td><?= h($ledgers->vendor_id) ?></td>
                <td><?= h($ledgers->tax_percentage) ?></td>
                <td><?= h($ledgers->gst_type) ?></td>
                <td><?= h($ledgers->input_output) ?></td>
                <td><?= h($ledgers->gst_figure_id) ?></td>
                <td><?= h($ledgers->bill_to_bill_accounting) ?></td>
                <td><?= h($ledgers->round_off) ?></td>
                <td><?= h($ledgers->cash) ?></td>
                <td><?= h($ledgers->flag) ?></td>
                <td><?= h($ledgers->default_credit_days) ?></td>
                <td><?= h($ledgers->commission) ?></td>
                <td><?= h($ledgers->sales_account) ?></td>
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
        <h4><?= __('Related Vendor Details') ?></h4>
        <?php if (!empty($vendor->vendor_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Vendor Id') ?></th>
                <th scope="col"><?= __('Contact Person') ?></th>
                <th scope="col"><?= __('Contact No') ?></th>
                <th scope="col"><?= __('Contact Email') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($vendor->vendor_details as $vendorDetails): ?>
            <tr>
                <td><?= h($vendorDetails->id) ?></td>
                <td><?= h($vendorDetails->vendor_id) ?></td>
                <td><?= h($vendorDetails->contact_person) ?></td>
                <td><?= h($vendorDetails->contact_no) ?></td>
                <td><?= h($vendorDetails->contact_email) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'VendorDetails', 'action' => 'view', $vendorDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'VendorDetails', 'action' => 'edit', $vendorDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'VendorDetails', 'action' => 'delete', $vendorDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendorDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
