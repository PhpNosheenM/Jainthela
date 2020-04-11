<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChallanRow[]|\Cake\Collection\CollectionInterface $challanRows
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Challan Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Challans'), ['controller' => 'Challans', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Challan'), ['controller' => 'Challans', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Order Details'), ['controller' => 'OrderDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order Detail'), ['controller' => 'OrderDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Combo Offers'), ['controller' => 'ComboOffers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Combo Offer'), ['controller' => 'ComboOffers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Gst Figures'), ['controller' => 'GstFigures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Gst Figure'), ['controller' => 'GstFigures', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="challanRows index large-9 medium-8 columns content">
    <h3><?= __('Challan Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('challan_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_detail_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_variation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('combo_offer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('actual_quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_percent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('promo_percent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('promo_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('taxable_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_percentage') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_figure_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gst_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('net_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_item_cancel') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($challanRows as $challanRow): ?>
            <tr>
                <td><?= $this->Number->format($challanRow->id) ?></td>
                <td><?= $challanRow->has('challan') ? $this->Html->link($challanRow->challan->id, ['controller' => 'Challans', 'action' => 'view', $challanRow->challan->id]) : '' ?></td>
                <td><?= $challanRow->has('order_detail') ? $this->Html->link($challanRow->order_detail->id, ['controller' => 'OrderDetails', 'action' => 'view', $challanRow->order_detail->id]) : '' ?></td>
                <td><?= $challanRow->has('item') ? $this->Html->link($challanRow->item->name, ['controller' => 'Items', 'action' => 'view', $challanRow->item->id]) : '' ?></td>
                <td><?= $challanRow->has('item_variation') ? $this->Html->link($challanRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $challanRow->item_variation->id]) : '' ?></td>
                <td><?= $challanRow->has('combo_offer') ? $this->Html->link($challanRow->combo_offer->name, ['controller' => 'ComboOffers', 'action' => 'view', $challanRow->combo_offer->id]) : '' ?></td>
                <td><?= $this->Number->format($challanRow->quantity) ?></td>
                <td><?= $this->Number->format($challanRow->actual_quantity) ?></td>
                <td><?= $this->Number->format($challanRow->rate) ?></td>
                <td><?= $this->Number->format($challanRow->amount) ?></td>
                <td><?= $this->Number->format($challanRow->discount_percent) ?></td>
                <td><?= $this->Number->format($challanRow->discount_amount) ?></td>
                <td><?= $this->Number->format($challanRow->promo_percent) ?></td>
                <td><?= $this->Number->format($challanRow->promo_amount) ?></td>
                <td><?= $this->Number->format($challanRow->taxable_value) ?></td>
                <td><?= $this->Number->format($challanRow->gst_percentage) ?></td>
                <td><?= $challanRow->has('gst_figure') ? $this->Html->link($challanRow->gst_figure->name, ['controller' => 'GstFigures', 'action' => 'view', $challanRow->gst_figure->id]) : '' ?></td>
                <td><?= $this->Number->format($challanRow->gst_value) ?></td>
                <td><?= $this->Number->format($challanRow->net_amount) ?></td>
                <td><?= h($challanRow->is_item_cancel) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $challanRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $challanRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $challanRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challanRow->id)]) ?>
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
