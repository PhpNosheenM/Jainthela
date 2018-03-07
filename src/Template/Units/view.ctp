<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Unit $unit
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Unit'), ['action' => 'edit', $unit->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Unit'), ['action' => 'delete', $unit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $unit->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Units'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combo Offer Details'), ['controller' => 'ComboOfferDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo Offer Detail'), ['controller' => 'ComboOfferDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="units view large-9 medium-8 columns content">
    <h3><?= h($unit->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Longname') ?></th>
            <td><?= h($unit->longname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shortname') ?></th>
            <td><?= h($unit->shortname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Unit Name') ?></th>
            <td><?= h($unit->unit_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($unit->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City Id') ?></th>
            <td><?= $this->Number->format($unit->city_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($unit->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($unit->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($unit->created_on) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Combo Offer Details') ?></h4>
        <?php if (!empty($unit->combo_offer_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Combo Offer Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Unit Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($unit->combo_offer_details as $comboOfferDetails): ?>
            <tr>
                <td><?= h($comboOfferDetails->id) ?></td>
                <td><?= h($comboOfferDetails->combo_offer_id) ?></td>
                <td><?= h($comboOfferDetails->item_id) ?></td>
                <td><?= h($comboOfferDetails->unit_id) ?></td>
                <td><?= h($comboOfferDetails->quantity) ?></td>
                <td><?= h($comboOfferDetails->rate) ?></td>
                <td><?= h($comboOfferDetails->amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ComboOfferDetails', 'action' => 'view', $comboOfferDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ComboOfferDetails', 'action' => 'edit', $comboOfferDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ComboOfferDetails', 'action' => 'delete', $comboOfferDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comboOfferDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Item Variations') ?></h4>
        <?php if (!empty($unit->item_variations)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Unit Id') ?></th>
                <th scope="col"><?= __('Alise Name') ?></th>
                <th scope="col"><?= __('Quantity Factor') ?></th>
                <th scope="col"><?= __('Print Quantity') ?></th>
                <th scope="col"><?= __('Print Rate') ?></th>
                <th scope="col"><?= __('Discount Per') ?></th>
                <th scope="col"><?= __('Sales Rate') ?></th>
                <th scope="col"><?= __('Maximum Quantity Purchase') ?></th>
                <th scope="col"><?= __('Out Of Stock') ?></th>
                <th scope="col"><?= __('Ready To Sale') ?></th>
                <th scope="col"><?= __('Created On') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($unit->item_variations as $itemVariations): ?>
            <tr>
                <td><?= h($itemVariations->id) ?></td>
                <td><?= h($itemVariations->item_id) ?></td>
                <td><?= h($itemVariations->unit_id) ?></td>
                <td><?= h($itemVariations->alise_name) ?></td>
                <td><?= h($itemVariations->quantity_factor) ?></td>
                <td><?= h($itemVariations->print_quantity) ?></td>
                <td><?= h($itemVariations->print_rate) ?></td>
                <td><?= h($itemVariations->discount_per) ?></td>
                <td><?= h($itemVariations->sales_rate) ?></td>
                <td><?= h($itemVariations->maximum_quantity_purchase) ?></td>
                <td><?= h($itemVariations->out_of_stock) ?></td>
                <td><?= h($itemVariations->ready_to_sale) ?></td>
                <td><?= h($itemVariations->created_on) ?></td>
                <td><?= h($itemVariations->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ItemVariations', 'action' => 'view', $itemVariations->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ItemVariations', 'action' => 'edit', $itemVariations->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ItemVariations', 'action' => 'delete', $itemVariations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemVariations->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
