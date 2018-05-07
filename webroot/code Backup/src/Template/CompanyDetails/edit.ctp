<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompanyDetail $companyDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $companyDetail->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $companyDetail->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Company Details'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="companyDetails form large-9 medium-8 columns content">
    <?= $this->Form->create($companyDetail) ?>
    <fieldset>
        <legend><?= __('Edit Company Detail') ?></legend>
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
