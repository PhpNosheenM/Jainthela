<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UnitVariation $unitVariation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $unitVariation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $unitVariation->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Unit Variations'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Units'), ['controller' => 'Units', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Unit'), ['controller' => 'Units', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="unitVariations form large-9 medium-8 columns content">
    <?= $this->Form->create($unitVariation) ?>
    <fieldset>
        <legend><?= __('Edit Unit Variation') ?></legend>
        <?php
            echo $this->Form->control('unit_id', ['options' => $units]);
            echo $this->Form->control('quantity_variation');
            echo $this->Form->control('convert_unit_qty');
            echo $this->Form->control('created_by');
            echo $this->Form->control('created_on');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
