<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompanyDetail $companyDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Company Detail'), ['action' => 'edit', $companyDetail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Company Detail'), ['action' => 'delete', $companyDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $companyDetail->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Company Details'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company Detail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="companyDetails view large-9 medium-8 columns content">
    <h3><?= h($companyDetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $companyDetail->has('city') ? $this->Html->link($companyDetail->city->name, ['controller' => 'Cities', 'action' => 'view', $companyDetail->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($companyDetail->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Web') ?></th>
            <td><?= h($companyDetail->web) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mobile') ?></th>
            <td><?= h($companyDetail->mobile) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($companyDetail->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Flag') ?></th>
            <td><?= $this->Number->format($companyDetail->flag) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Address') ?></h4>
        <?= $this->Text->autoParagraph(h($companyDetail->address)); ?>
    </div>
</div>
