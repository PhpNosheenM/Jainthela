<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FinancialYear $financialYear
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Financial Years'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="financialYears form large-9 medium-8 columns content">
    <?= $this->Form->create($financialYear) ?>
    <fieldset>
        <legend><?= __('Add Financial Year') ?></legend>
        <?php
            echo $this->Form->control('fy_from');
            echo $this->Form->control('fy_to');
            echo $this->Form->control('status');
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('city_id', ['options' => $cities]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
