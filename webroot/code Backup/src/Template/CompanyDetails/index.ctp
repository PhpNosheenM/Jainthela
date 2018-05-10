<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompanyDetail[]|\Cake\Collection\CollectionInterface $companyDetails
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Company Detail'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="companyDetails index large-9 medium-8 columns content">
    <h3><?= __('Company Details') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('web') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mobile') ?></th>
                <th scope="col"><?= $this->Paginator->sort('flag') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($companyDetails as $companyDetail): ?>
            <tr>
                <td><?= $this->Number->format($companyDetail->id) ?></td>
                <td><?= $companyDetail->has('city') ? $this->Html->link($companyDetail->city->name, ['controller' => 'Cities', 'action' => 'view', $companyDetail->city->id]) : '' ?></td>
                <td><?= h($companyDetail->email) ?></td>
                <td><?= h($companyDetail->web) ?></td>
                <td><?= h($companyDetail->mobile) ?></td>
                <td><?= $this->Number->format($companyDetail->flag) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $companyDetail->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $companyDetail->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $companyDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $companyDetail->id)]) ?>
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
