<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TermCondition $termCondition
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Term Conditions'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="termConditions form large-9 medium-8 columns content">
    <?= $this->Form->create($termCondition) ?>
    <fieldset>
        <legend><?= __('Add Term Condition') ?></legend>
        <?php
            echo $this->Form->control('term_name');
            echo $this->Form->control('term');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
