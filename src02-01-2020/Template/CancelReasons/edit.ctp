<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CancelReason $cancelReason
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cancelReason->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cancelReason->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Cancel Reasons'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="cancelReasons form large-9 medium-8 columns content">
    <?= $this->Form->create($cancelReason) ?>
    <fieldset>
        <legend><?= __('Edit Cancel Reason') ?></legend>
        <?php
            echo $this->Form->control('reason');
            echo $this->Form->control('created_on');
            echo $this->Form->control('created_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
