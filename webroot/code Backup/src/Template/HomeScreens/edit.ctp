<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HomeScreen $homeScreen
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $homeScreen->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $homeScreen->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Home Screens'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="homeScreens form large-9 medium-8 columns content">
    <?= $this->Form->create($homeScreen) ?>
    <fieldset>
        <legend><?= __('Edit Home Screen') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('layout');
            echo $this->Form->control('section_show');
            echo $this->Form->control('preference');
            echo $this->Form->control('category_id', ['options' => $categories]);
            echo $this->Form->control('screen_type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
