<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Landmark $landmark
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Landmarks'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Route Rows'), ['controller' => 'RouteRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Route Row'), ['controller' => 'RouteRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="landmarks form large-9 medium-8 columns content">
    <?= $this->Form->create($landmark) ?>
    <fieldset>
        <legend><?= __('Add Landmark') ?></legend>
        <?php
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('location_id', ['options' => $locations]);
            echo $this->Form->control('name');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
