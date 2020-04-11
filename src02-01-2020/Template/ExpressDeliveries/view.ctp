<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExpressDelivery $expressDelivery
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Express Delivery'), ['action' => 'edit', $expressDelivery->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Express Delivery'), ['action' => 'delete', $expressDelivery->id], ['confirm' => __('Are you sure you want to delete # {0}?', $expressDelivery->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Express Deliveries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Express Delivery'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="expressDeliveries view large-9 medium-8 columns content">
    <h3><?= h($expressDelivery->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($expressDelivery->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Icon') ?></th>
            <td><?= h($expressDelivery->icon) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($expressDelivery->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($expressDelivery->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Content Data') ?></h4>
        <?= $this->Text->autoParagraph(h($expressDelivery->content_data)); ?>
    </div>
</div>
