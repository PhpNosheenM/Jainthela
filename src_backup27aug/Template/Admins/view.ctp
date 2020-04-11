<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Admin $admin
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Admin'), ['action' => 'edit', $admin->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Admin'), ['action' => 'delete', $admin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $admin->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Admins'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Admin'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combo Offers'), ['controller' => 'ComboOffers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo Offer'), ['controller' => 'ComboOffers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Feedbacks'), ['controller' => 'Feedbacks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feedback'), ['controller' => 'Feedbacks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Plans'), ['controller' => 'Plans', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Plan'), ['controller' => 'Plans', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Promotions'), ['controller' => 'Promotions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Promotion'), ['controller' => 'Promotions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Units'), ['controller' => 'Units', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit'), ['controller' => 'Units', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="admins view large-9 medium-8 columns content">
    <h3><?= h($admin->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $admin->has('location') ? $this->Html->link($admin->location->name, ['controller' => 'Locations', 'action' => 'view', $admin->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= $admin->has('role') ? $this->Html->link($admin->role->name, ['controller' => 'Roles', 'action' => 'view', $admin->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($admin->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($admin->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($admin->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($admin->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mobile No') ?></th>
            <td><?= h($admin->mobile_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($admin->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($admin->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Timeout') ?></th>
            <td><?= $this->Number->format($admin->timeout) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($admin->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($admin->created_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Passkey') ?></h4>
        <?= $this->Text->autoParagraph(h($admin->passkey)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Combo Offers') ?></h4>
        <?php if (!empty($admin->combo_offers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Print Rate') ?></th>
                <th scope="col"><?= __('Discount Per') ?></th>
                <th scope="col"><?= __('Sales Rate') ?></th>
                <th scope="col"><?= __('Quantity Factor') ?></th>
                <th scope="col"><?= __('Print Quantity') ?></th>
                <th scope="col"><?= __('Maximum Quantity Purchase') ?></th>
                <th scope="col"><?= __('Start Date') ?></th>
                <th scope="col"><?= __('End Date') ?></th>
                <th scope="col"><?= __('Stock In Quantity') ?></th>
                <th scope="col"><?= __('Stock Out Quantity') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Edited On') ?></th>
                <th scope="col"><?= __('Ready To Sale') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($admin->combo_offers as $comboOffers): ?>
            <tr>
                <td><?= h($comboOffers->id) ?></td>
                <td><?= h($comboOffers->city_id) ?></td>
                <td><?= h($comboOffers->admin_id) ?></td>
                <td><?= h($comboOffers->name) ?></td>
                <td><?= h($comboOffers->print_rate) ?></td>
                <td><?= h($comboOffers->discount_per) ?></td>
                <td><?= h($comboOffers->sales_rate) ?></td>
                <td><?= h($comboOffers->quantity_factor) ?></td>
                <td><?= h($comboOffers->print_quantity) ?></td>
                <td><?= h($comboOffers->maximum_quantity_purchase) ?></td>
                <td><?= h($comboOffers->start_date) ?></td>
                <td><?= h($comboOffers->end_date) ?></td>
                <td><?= h($comboOffers->stock_in_quantity) ?></td>
                <td><?= h($comboOffers->stock_out_quantity) ?></td>
                <td><?= h($comboOffers->created_on) ?></td>
                <td><?= h($comboOffers->edited_on) ?></td>
                <td><?= h($comboOffers->ready_to_sale) ?></td>
                <td><?= h($comboOffers->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ComboOffers', 'action' => 'view', $comboOffers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ComboOffers', 'action' => 'edit', $comboOffers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ComboOffers', 'action' => 'delete', $comboOffers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comboOffers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Feedbacks') ?></h4>
        <?php if (!empty($admin->feedbacks)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Mobile No') ?></th>
                <th scope="col"><?= __('Comment') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($admin->feedbacks as $feedbacks): ?>
            <tr>
                <td><?= h($feedbacks->id) ?></td>
                <td><?= h($feedbacks->admin_id) ?></td>
                <td><?= h($feedbacks->customer_id) ?></td>
                <td><?= h($feedbacks->name) ?></td>
                <td><?= h($feedbacks->email) ?></td>
                <td><?= h($feedbacks->mobile_no) ?></td>
                <td><?= h($feedbacks->comment) ?></td>
                <td><?= h($feedbacks->created_on) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Feedbacks', 'action' => 'view', $feedbacks->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Feedbacks', 'action' => 'edit', $feedbacks->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Feedbacks', 'action' => 'delete', $feedbacks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feedbacks->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Items') ?></h4>
        <?php if (!empty($admin->items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('Seller Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Minimum Stock') ?></th>
                <th scope="col"><?= __('Next Day Requirement') ?></th>
                <th scope="col"><?= __('Request For Sample') ?></th>
                <th scope="col"><?= __('Default Grade') ?></th>
                <th scope="col"><?= __('Tax') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Edited On') ?></th>
                <th scope="col"><?= __('Approve') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($admin->items as $items): ?>
            <tr>
                <td><?= h($items->id) ?></td>
                <td><?= h($items->category_id) ?></td>
                <td><?= h($items->admin_id) ?></td>
                <td><?= h($items->seller_id) ?></td>
                <td><?= h($items->city_id) ?></td>
                <td><?= h($items->name) ?></td>
                <td><?= h($items->description) ?></td>
                <td><?= h($items->minimum_stock) ?></td>
                <td><?= h($items->next_day_requirement) ?></td>
                <td><?= h($items->request_for_sample) ?></td>
                <td><?= h($items->default_grade) ?></td>
                <td><?= h($items->tax) ?></td>
                <td><?= h($items->created_on) ?></td>
                <td><?= h($items->edited_on) ?></td>
                <td><?= h($items->approve) ?></td>
                <td><?= h($items->status) ?></td>
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
        <h4><?= __('Related Plans') ?></h4>
        <?php if (!empty($admin->plans)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Benifit Per') ?></th>
                <th scope="col"><?= __('Total Amount') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($admin->plans as $plans): ?>
            <tr>
                <td><?= h($plans->id) ?></td>
                <td><?= h($plans->admin_id) ?></td>
                <td><?= h($plans->city_id) ?></td>
                <td><?= h($plans->name) ?></td>
                <td><?= h($plans->amount) ?></td>
                <td><?= h($plans->benifit_per) ?></td>
                <td><?= h($plans->total_amount) ?></td>
                <td><?= h($plans->created_on) ?></td>
                <td><?= h($plans->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Plans', 'action' => 'view', $plans->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Plans', 'action' => 'edit', $plans->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Plans', 'action' => 'delete', $plans->id], ['confirm' => __('Are you sure you want to delete # {0}?', $plans->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Promotions') ?></h4>
        <?php if (!empty($admin->promotions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('City Id') ?></th>
                <th scope="col"><?= __('Offer Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Start Date') ?></th>
                <th scope="col"><?= __('End Date') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($admin->promotions as $promotions): ?>
            <tr>
                <td><?= h($promotions->id) ?></td>
                <td><?= h($promotions->admin_id) ?></td>
                <td><?= h($promotions->city_id) ?></td>
                <td><?= h($promotions->offer_name) ?></td>
                <td><?= h($promotions->description) ?></td>
                <td><?= h($promotions->start_date) ?></td>
                <td><?= h($promotions->end_date) ?></td>
                <td><?= h($promotions->created_on) ?></td>
                <td><?= h($promotions->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Promotions', 'action' => 'view', $promotions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Promotions', 'action' => 'edit', $promotions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Promotions', 'action' => 'delete', $promotions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $promotions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Units') ?></h4>
        <?php if (!empty($admin->units)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Longname') ?></th>
                <th scope="col"><?= __('Shortname') ?></th>
                <th scope="col"><?= __('Unit Name') ?></th>
                <th scope="col"><?= __('Admin Id') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($admin->units as $units): ?>
            <tr>
                <td><?= h($units->id) ?></td>
                <td><?= h($units->longname) ?></td>
                <td><?= h($units->shortname) ?></td>
                <td><?= h($units->unit_name) ?></td>
                <td><?= h($units->admin_id) ?></td>
                <td><?= h($units->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Units', 'action' => 'view', $units->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Units', 'action' => 'edit', $units->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Units', 'action' => 'delete', $units->id], ['confirm' => __('Are you sure you want to delete # {0}?', $units->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
