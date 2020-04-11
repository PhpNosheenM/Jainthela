<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DeliveryDate $deliveryDate
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $deliveryDate->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $deliveryDate->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Delivery Dates'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="deliveryDates form large-9 medium-8 columns content">
    <?= $this->Form->create($deliveryDate) ?>
    <fieldset>
        <legend><?= __('Edit Delivery Date') ?></legend>
        <?php
            echo $this->Form->control('same_day');
            echo $this->Form->control('next_day');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
