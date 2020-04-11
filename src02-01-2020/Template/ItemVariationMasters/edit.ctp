<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemVariationMaster $itemVariationMaster
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $itemVariationMaster->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $itemVariationMaster->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Item Variation Masters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Unit Variations'), ['controller' => 'UnitVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Unit Variation'), ['controller' => 'UnitVariations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemVariationMasters form large-9 medium-8 columns content">
    <?= $this->Form->create($itemVariationMaster) ?>
    <fieldset>
        <legend><?= __('Edit Item Variation Master') ?></legend>
        <?php
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('unit_variation_id', ['options' => $unitVariations]);
            echo $this->Form->control('created_on');
            echo $this->Form->control('edited_on');
            echo $this->Form->control('created_by');
            echo $this->Form->control('edited_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
