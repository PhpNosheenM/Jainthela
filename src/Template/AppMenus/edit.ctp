<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppMenu $appMenu
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $appMenu->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $appMenu->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List App Menus'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="appMenus form large-9 medium-8 columns content">
    <?= $this->Form->create($appMenu) ?>
    <fieldset>
        <legend><?= __('Edit App Menu') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('link');
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('status');
            echo $this->Form->control('parent_id');
            echo $this->Form->control('lft');
            echo $this->Form->control('rght');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
