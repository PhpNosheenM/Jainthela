<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FinancialYear $financialYear
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Financial Year'), ['action' => 'edit', $financialYear->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Financial Year'), ['action' => 'delete', $financialYear->id], ['confirm' => __('Are you sure you want to delete # {0}?', $financialYear->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Financial Years'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Financial Year'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="financialYears view large-9 medium-8 columns content">
    <h3><?= h($financialYear->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($financialYear->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $financialYear->has('location') ? $this->Html->link($financialYear->location->name, ['controller' => 'Locations', 'action' => 'view', $financialYear->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $financialYear->has('city') ? $this->Html->link($financialYear->city->name, ['controller' => 'Cities', 'action' => 'view', $financialYear->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($financialYear->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fy From') ?></th>
            <td><?= h($financialYear->fy_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fy To') ?></th>
            <td><?= h($financialYear->fy_to) ?></td>
        </tr>
    </table>
</div>
