<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grn $grn
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Grn'), ['action' => 'edit', $grn->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Grn'), ['action' => 'delete', $grn->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grn->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Grns'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grn'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Seller Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seller Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="grns view large-9 medium-8 columns content">
    <h3><?= h($grn->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $grn->has('location') ? $this->Html->link($grn->location->name, ['controller' => 'Locations', 'action' => 'view', $grn->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order') ?></th>
            <td><?= $grn->has('order') ? $this->Html->link($grn->order->id, ['controller' => 'Orders', 'action' => 'view', $grn->order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reference No') ?></th>
            <td><?= h($grn->reference_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($grn->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($grn->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voucher No') ?></th>
            <td><?= $this->Number->format($grn->voucher_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Grn No') ?></th>
            <td><?= $this->Number->format($grn->grn_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Taxable Value') ?></th>
            <td><?= $this->Number->format($grn->total_taxable_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Gst') ?></th>
            <td><?= $this->Number->format($grn->total_gst) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Amount') ?></th>
            <td><?= $this->Number->format($grn->total_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($grn->transaction_date) ?></td>
        </tr>
    </table>
</div>
