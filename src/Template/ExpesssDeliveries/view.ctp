<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExpesssDelivery $expesssDelivery
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Expesss Delivery'), ['action' => 'edit', $expesssDelivery->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Expesss Delivery'), ['action' => 'delete', $expesssDelivery->id], ['confirm' => __('Are you sure you want to delete # {0}?', $expesssDelivery->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Expesss Deliveries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Expesss Delivery'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="expesssDeliveries view large-9 medium-8 columns content">
    <h3><?= h($expesssDelivery->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($expesssDelivery->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Icon') ?></th>
            <td><?= h($expesssDelivery->icon) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($expesssDelivery->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($expesssDelivery->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Content Data') ?></h4>
        <?= $this->Text->autoParagraph(h($expesssDelivery->content_data)); ?>
    </div>
</div>
