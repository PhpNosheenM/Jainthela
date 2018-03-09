<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Seller[]|\Cake\Collection\CollectionInterface $sellers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Seller'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Seller Items'), ['controller' => 'SellerItems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller Item'), ['controller' => 'SellerItems', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Seller Ratings'), ['controller' => 'SellerRatings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seller Rating'), ['controller' => 'SellerRatings', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sellers index large-9 medium-8 columns content">
    <h3><?= __('Sellers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('username') ?></th>
                <th scope="col"><?= $this->Paginator->sort('password') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mobile_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('latitude') ?></th>
                <th scope="col"><?= $this->Paginator->sort('longitude') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gstin') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gstin_holder_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('firm_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registration_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('termination_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('timeout') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sellers as $seller): ?>
            <tr>
                <td><?= $this->Number->format($seller->id) ?></td>
                <td><?= $seller->has('city') ? $this->Html->link($seller->city->name, ['controller' => 'Cities', 'action' => 'view', $seller->city->id]) : '' ?></td>
                <td><?= h($seller->name) ?></td>
                <td><?= h($seller->username) ?></td>
                <td><?= h($seller->password) ?></td>
                <td><?= h($seller->email) ?></td>
                <td><?= h($seller->mobile_no) ?></td>
                <td><?= h($seller->latitude) ?></td>
                <td><?= h($seller->longitude) ?></td>
                <td><?= h($seller->gstin) ?></td>
                <td><?= h($seller->gstin_holder_name) ?></td>
                <td><?= h($seller->firm_name) ?></td>
                <td><?= h($seller->registration_date) ?></td>
                <td><?= h($seller->termination_date) ?></td>
                <td><?= $this->Number->format($seller->timeout) ?></td>
                <td><?= h($seller->created_on) ?></td>
                <td><?= $this->Number->format($seller->created_by) ?></td>
                <td><?= h($seller->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $seller->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $seller->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $seller->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seller->id)]) ?>
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
