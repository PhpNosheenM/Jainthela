<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Seller $seller
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Seller'), ['action' => 'edit', $seller->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Seller'), ['action' => 'delete', $seller->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seller->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sellers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Seller Items'), ['controller' => 'SellerItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller Item'), ['controller' => 'SellerItems', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Seller Ratings'), ['controller' => 'SellerRatings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller Rating'), ['controller' => 'SellerRatings', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reference Details'), ['controller' => 'ReferenceDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reference Detail'), ['controller' => 'ReferenceDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sellers view large-9 medium-8 columns content">
    <h3><?= h($seller->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $seller->has('location') ? $this->Html->link($seller->location->name, ['controller' => 'Locations', 'action' => 'view', $seller->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($seller->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($seller->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($seller->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($seller->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mobile No') ?></th>
            <td><?= h($seller->mobile_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Latitude') ?></th>
            <td><?= h($seller->latitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Longitude') ?></th>
            <td><?= h($seller->longitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gstin') ?></th>
            <td><?= h($seller->gstin) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gstin Holder Name') ?></th>
            <td><?= h($seller->gstin_holder_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Firm Name') ?></th>
            <td><?= h($seller->firm_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($seller->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bill To Bill Accounting') ?></th>
            <td><?= h($seller->bill_to_bill_accounting) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debit Credit') ?></th>
            <td><?= h($seller->debit_credit) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Saller Image') ?></th>
            <td><?= h($seller->saller_image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($seller->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Timeout') ?></th>
            <td><?= $this->Number->format($seller->timeout) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($seller->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Opening Balance Value') ?></th>
            <td><?= $this->Number->format($seller->opening_balance_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registration Date') ?></th>
            <td><?= h($seller->registration_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Termination Date') ?></th>
            <td><?= h($seller->termination_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($seller->created_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Gstin Holder Address') ?></h4>
        <?= $this->Text->autoParagraph(h($seller->gstin_holder_address)); ?>
    </div>
    <div class="row">
        <h4><?= __('Firm Address') ?></h4>
        <?= $this->Text->autoParagraph(h($seller->firm_address)); ?>
    </div>
    <div class="row">
        <h4><?= __('Termination Reason') ?></h4>
        <?= $this->Text->autoParagraph(h($seller->termination_reason)); ?>
    </div>
    <div class="row">
        <h4><?= __('Breif Decription') ?></h4>
        <?= $this->Text->autoParagraph(h($seller->breif_decription)); ?>
    </div>
    <div class="row">
        <h4><?= __('Passkey') ?></h4>
        <?= $this->Text->autoParagraph(h($seller->passkey)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Items') ?></h4>
        <?php if (!empty($seller->items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('Seller Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Brand Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Alias Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Minimum Stock') ?></th>
                <th scope="col"><?= __('Next Day Requirement') ?></th>
                <th scope="col"><?= __('Request For Sample') ?></th>
                <th scope="col"><?= __('Default Grade') ?></th>
                <th scope="col"><?= __('Tax') ?></th>
                <th scope="col"><?= __('Gst Figure Id') ?></th>
                <th scope="col"><?= __('Item Maintain By') ?></th>
                <th scope="col"><?= __('Out Of Stock') ?></th>
                <th scope="col"><?= __('Ready To Sale') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Edited On') ?></th>
                <th scope="col"><?= __('Approve') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Section Show') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($seller->items as $items): ?>
            <tr>
                <td><?= h($items->id) ?></td>
                <td><?= h($items->category_id) ?></td>
                <td><?= h($items->admin_id) ?></td>
                <td><?= h($items->seller_id) ?></td>
                <td><?= h($items->city_id) ?></td>
                <td><?= h($items->brand_id) ?></td>
                <td><?= h($items->name) ?></td>
                <td><?= h($items->alias_name) ?></td>
                <td><?= h($items->description) ?></td>
                <td><?= h($items->minimum_stock) ?></td>
                <td><?= h($items->next_day_requirement) ?></td>
                <td><?= h($items->request_for_sample) ?></td>
                <td><?= h($items->default_grade) ?></td>
                <td><?= h($items->tax) ?></td>
                <td><?= h($items->gst_figure_id) ?></td>
                <td><?= h($items->item_maintain_by) ?></td>
                <td><?= h($items->out_of_stock) ?></td>
                <td><?= h($items->ready_to_sale) ?></td>
                <td><?= h($items->created_on) ?></td>
                <td><?= h($items->edited_on) ?></td>
                <td><?= h($items->approve) ?></td>
                <td><?= h($items->status) ?></td>
                <td><?= h($items->section_show) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Seller Items') ?></h4>
        <?php if (!empty($seller->seller_items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Seller Id') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Commission Percentage') ?></th>
                <th scope="col"><?= __('Commission Created On') ?></th>
                <th scope="col"><?= __('Expiry On Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($seller->seller_items as $sellerItems): ?>
            <tr>
                <td><?= h($sellerItems->id) ?></td>
                <td><?= h($sellerItems->category_id) ?></td>
                <td><?= h($sellerItems->item_id) ?></td>
                <td><?= h($sellerItems->seller_id) ?></td>
                <td><?= h($sellerItems->created_on) ?></td>
                <td><?= h($sellerItems->created_by) ?></td>
                <td><?= h($sellerItems->commission_percentage) ?></td>
                <td><?= h($sellerItems->commission_created_on) ?></td>
                <td><?= h($sellerItems->expiry_on_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SellerItems', 'action' => 'view', $sellerItems->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SellerItems', 'action' => 'edit', $sellerItems->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SellerItems', 'action' => 'delete', $sellerItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sellerItems->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Seller Ratings') ?></h4>
        <?php if (!empty($seller->seller_ratings)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Seller Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Rating') ?></th>
                <th scope="col"><?= __('Comment') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($seller->seller_ratings as $sellerRatings): ?>
            <tr>
                <td><?= h($sellerRatings->id) ?></td>
                <td><?= h($sellerRatings->seller_id) ?></td>
                <td><?= h($sellerRatings->customer_id) ?></td>
                <td><?= h($sellerRatings->rating) ?></td>
                <td><?= h($sellerRatings->comment) ?></td>
                <td><?= h($sellerRatings->created_on) ?></td>
                <td><?= h($sellerRatings->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SellerRatings', 'action' => 'view', $sellerRatings->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SellerRatings', 'action' => 'edit', $sellerRatings->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SellerRatings', 'action' => 'delete', $sellerRatings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sellerRatings->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Reference Details') ?></h4>
        <?php if (!empty($seller->reference_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Supplier Id') ?></th>
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
                <th scope="col"><?= __('Receipt Row Id') ?></th>
                <th scope="col"><?= __('Payment Row Id') ?></th>
                <th scope="col"><?= __('Credit Note Id') ?></th>
                <th scope="col"><?= __('Credit Note Row Id') ?></th>
                <th scope="col"><?= __('Debit Note Id') ?></th>
                <th scope="col"><?= __('Debit Note Row Id') ?></th>
                <th scope="col"><?= __('Sales Voucher Row Id') ?></th>
                <th scope="col"><?= __('Purchase Voucher Row Id') ?></th>
                <th scope="col"><?= __('Journal Voucher Row Id') ?></th>
                <th scope="col"><?= __('Sale Return Id') ?></th>
                <th scope="col"><?= __('Purchase Invoice Id') ?></th>
                <th scope="col"><?= __('Purchase Return Id') ?></th>
                <th scope="col"><?= __('Sales Invoice Id') ?></th>
                <th scope="col"><?= __('Opening Balance') ?></th>
                <th scope="col"><?= __('Due Days') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($seller->reference_details as $referenceDetails): ?>
            <tr>
                <td><?= h($referenceDetails->id) ?></td>
                <td><?= h($referenceDetails->customer_id) ?></td>
                <td><?= h($referenceDetails->supplier_id) ?></td>
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
                <td><?= h($referenceDetails->receipt_row_id) ?></td>
                <td><?= h($referenceDetails->payment_row_id) ?></td>
                <td><?= h($referenceDetails->credit_note_id) ?></td>
                <td><?= h($referenceDetails->credit_note_row_id) ?></td>
                <td><?= h($referenceDetails->debit_note_id) ?></td>
                <td><?= h($referenceDetails->debit_note_row_id) ?></td>
                <td><?= h($referenceDetails->sales_voucher_row_id) ?></td>
                <td><?= h($referenceDetails->purchase_voucher_row_id) ?></td>
                <td><?= h($referenceDetails->journal_voucher_row_id) ?></td>
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
