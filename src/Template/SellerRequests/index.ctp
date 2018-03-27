<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SellerRequest[]|\Cake\Collection\CollectionInterface $sellerRequests
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Seller Request'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sellers'), ['controller' => 'Sellers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller'), ['controller' => 'Sellers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Seller Request Rows'), ['controller' => 'SellerRequestRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller Request Row'), ['controller' => 'SellerRequestRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sellerRequests index large-9 medium-8 columns content">
    <h3><?= __('Seller Requests') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('seller_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_taxable_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_gst') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_amount') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sellerRequests as $sellerRequest): ?>
            <tr>
                <td><?= $this->Number->format($sellerRequest->id) ?></td>
                <td><?= $sellerRequest->has('seller') ? $this->Html->link($sellerRequest->seller->name, ['controller' => 'Sellers', 'action' => 'view', $sellerRequest->seller->id]) : '' ?></td>
                <td><?= $this->Number->format($sellerRequest->voucher_no) ?></td>
                <td><?= $sellerRequest->has('location') ? $this->Html->link($sellerRequest->location->name, ['controller' => 'Locations', 'action' => 'view', $sellerRequest->location->id]) : '' ?></td>
                <td><?= h($sellerRequest->transaction_date) ?></td>
                <td><?= h($sellerRequest->status) ?></td>
                <td><?= $this->Number->format($sellerRequest->total_taxable_value) ?></td>
                <td><?= $this->Number->format($sellerRequest->total_gst) ?></td>
                <td><?= $this->Number->format($sellerRequest->total_amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $sellerRequest->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sellerRequest->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sellerRequest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sellerRequest->id)]) ?>
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
