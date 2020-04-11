<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Landmark $landmark
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Landmark'), ['action' => 'edit', $landmark->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Landmark'), ['action' => 'delete', $landmark->id], ['confirm' => __('Are you sure you want to delete # {0}?', $landmark->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Landmarks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Landmark'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Route Rows'), ['controller' => 'RouteRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Route Row'), ['controller' => 'RouteRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="landmarks view large-9 medium-8 columns content">
    <h3><?= h($landmark->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $landmark->has('city') ? $this->Html->link($landmark->city->name, ['controller' => 'Cities', 'action' => 'view', $landmark->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= $landmark->has('location') ? $this->Html->link($landmark->location->name, ['controller' => 'Locations', 'action' => 'view', $landmark->location->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($landmark->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($landmark->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($landmark->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Route Rows') ?></h4>
        <?php if (!empty($landmark->route_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Route Id') ?></th>
                <th scope="col"><?= __('Landmark Id') ?></th>
                <th scope="col"><?= __('Priority') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($landmark->route_rows as $routeRows): ?>
            <tr>
                <td><?= h($routeRows->id) ?></td>
                <td><?= h($routeRows->route_id) ?></td>
                <td><?= h($routeRows->landmark_id) ?></td>
                <td><?= h($routeRows->priority) ?></td>
                <td><?= h($routeRows->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'RouteRows', 'action' => 'view', $routeRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'RouteRows', 'action' => 'edit', $routeRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'RouteRows', 'action' => 'delete', $routeRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $routeRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
