<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BulkOrderPerforma $bulkOrderPerforma
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Bulk Order Performas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bulk Order Performa Rows'), ['controller' => 'BulkOrderPerformaRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bulk Order Performa Row'), ['controller' => 'BulkOrderPerformaRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bulkOrderPerformas form large-9 medium-8 columns content">
    <?= $this->Form->create($bulkOrderPerforma) ?>
    <fieldset>
        <legend><?= __('Add Bulk Order Performa') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('created_on');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
