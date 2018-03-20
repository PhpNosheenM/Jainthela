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
    </ul>
</nav>
<div class="appMenus form large-9 medium-8 columns content">
    <?= $this->Form->create($appMenu) ?>
    <fieldset>
        <legend><?= __('Add App Menu') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('link');
            echo $this->Form->control('city_id');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
