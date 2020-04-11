<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppMenu $appMenu
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List App Menus'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Parent App Menus'), ['controller' => 'AppMenus', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parent App Menu'), ['controller' => 'AppMenus', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="appMenus form large-9 medium-8 columns content">
    <?= $this->Form->create($appMenu) ?>
    <fieldset>
        <legend><?= __('Add App Menu') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('link');
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('status');
            echo $this->Form->control('parent_id', ['options' => $parentAppMenus, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
