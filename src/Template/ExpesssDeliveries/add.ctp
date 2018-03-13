<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExpesssDelivery $expesssDelivery
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Expesss Deliveries'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="expesssDeliveries form large-9 medium-8 columns content">
    <?= $this->Form->create($expesssDelivery) ?>
    <fieldset>
        <legend><?= __('Add Expesss Delivery') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('icon');
            echo $this->Form->control('content_data');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
