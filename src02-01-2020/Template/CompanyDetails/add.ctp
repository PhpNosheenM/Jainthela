<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompanyDetail $companyDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Company Details'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="companyDetails form large-9 medium-8 columns content">
    <?= $this->Form->create($companyDetail) ?>
    <fieldset>
        <legend><?= __('Add Company Detail') ?></legend>
        <?php
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('email');
            echo $this->Form->control('web');
            echo $this->Form->control('mobile');
            echo $this->Form->control('address');
            echo $this->Form->control('flag');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
