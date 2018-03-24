<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ComboOffer[]|\Cake\Collection\CollectionInterface $comboOffers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Combo Offer'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Admins'), ['controller' => 'Admins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Admin'), ['controller' => 'Admins', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Carts'), ['controller' => 'Carts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cart'), ['controller' => 'Carts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Combo Offer Details'), ['controller' => 'ComboOfferDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Combo Offer Detail'), ['controller' => 'ComboOfferDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Order Details'), ['controller' => 'OrderDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order Detail'), ['controller' => 'OrderDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="comboOffers index large-9 medium-8 columns content">
    <h3><?= __('Combo Offers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('admin_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('print_rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_per') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity_factor') ?></th>
                <th scope="col"><?= $this->Paginator->sort('print_quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('maximum_quantity_purchase') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('stock_in_quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('stock_out_quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('edited_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ready_to_sale') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('combo_offer_image') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comboOffers as $comboOffer): ?>
            <tr>
                <td><?= $this->Number->format($comboOffer->id) ?></td>
                <td><?= $comboOffer->has('city') ? $this->Html->link($comboOffer->city->name, ['controller' => 'Cities', 'action' => 'view', $comboOffer->city->id]) : '' ?></td>
                <td><?= $comboOffer->has('admin') ? $this->Html->link($comboOffer->admin->name, ['controller' => 'Admins', 'action' => 'view', $comboOffer->admin->id]) : '' ?></td>
                <td><?= h($comboOffer->name) ?></td>
                <td><?= $this->Number->format($comboOffer->print_rate) ?></td>
                <td><?= $this->Number->format($comboOffer->discount_per) ?></td>
                <td><?= $this->Number->format($comboOffer->sales_rate) ?></td>
                <td><?= $this->Number->format($comboOffer->quantity_factor) ?></td>
                <td><?= $this->Number->format($comboOffer->print_quantity) ?></td>
                <td><?= $this->Number->format($comboOffer->maximum_quantity_purchase) ?></td>
                <td><?= h($comboOffer->start_date) ?></td>
                <td><?= h($comboOffer->end_date) ?></td>
                <td><?= $this->Number->format($comboOffer->stock_in_quantity) ?></td>
                <td><?= $this->Number->format($comboOffer->stock_out_quantity) ?></td>
                <td><?= h($comboOffer->created_on) ?></td>
                <td><?= h($comboOffer->edited_on) ?></td>
                <td><?= h($comboOffer->ready_to_sale) ?></td>
                <td><?= h($comboOffer->status) ?></td>
                <td><?= h($comboOffer->combo_offer_image) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $comboOffer->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $comboOffer->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $comboOffer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comboOffer->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
