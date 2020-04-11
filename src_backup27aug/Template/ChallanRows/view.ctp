<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChallanRow $challanRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Challan Row'), ['action' => 'edit', $challanRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Challan Row'), ['action' => 'delete', $challanRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challanRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Challan Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Challan Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Challans'), ['controller' => 'Challans', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Challan'), ['controller' => 'Challans', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Order Details'), ['controller' => 'OrderDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order Detail'), ['controller' => 'OrderDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combo Offers'), ['controller' => 'ComboOffers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combo Offer'), ['controller' => 'ComboOffers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Gst Figures'), ['controller' => 'GstFigures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Gst Figure'), ['controller' => 'GstFigures', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="challanRows view large-9 medium-8 columns content">
    <h3><?= h($challanRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Challan') ?></th>
            <td><?= $challanRow->has('challan') ? $this->Html->link($challanRow->challan->id, ['controller' => 'Challans', 'action' => 'view', $challanRow->challan->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Detail') ?></th>
            <td><?= $challanRow->has('order_detail') ? $this->Html->link($challanRow->order_detail->id, ['controller' => 'OrderDetails', 'action' => 'view', $challanRow->order_detail->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $challanRow->has('item') ? $this->Html->link($challanRow->item->name, ['controller' => 'Items', 'action' => 'view', $challanRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $challanRow->has('item_variation') ? $this->Html->link($challanRow->item_variation->name, ['controller' => 'ItemVariations', 'action' => 'view', $challanRow->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Combo Offer') ?></th>
            <td><?= $challanRow->has('combo_offer') ? $this->Html->link($challanRow->combo_offer->name, ['controller' => 'ComboOffers', 'action' => 'view', $challanRow->combo_offer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Figure') ?></th>
            <td><?= $challanRow->has('gst_figure') ? $this->Html->link($challanRow->gst_figure->name, ['controller' => 'GstFigures', 'action' => 'view', $challanRow->gst_figure->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Item Cancel') ?></th>
            <td><?= h($challanRow->is_item_cancel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($challanRow->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($challanRow->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Actual Quantity') ?></th>
            <td><?= $this->Number->format($challanRow->actual_quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $this->Number->format($challanRow->rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($challanRow->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Percent') ?></th>
            <td><?= $this->Number->format($challanRow->discount_percent) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Amount') ?></th>
            <td><?= $this->Number->format($challanRow->discount_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Promo Percent') ?></th>
            <td><?= $this->Number->format($challanRow->promo_percent) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Promo Amount') ?></th>
            <td><?= $this->Number->format($challanRow->promo_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Taxable Value') ?></th>
            <td><?= $this->Number->format($challanRow->taxable_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Percentage') ?></th>
            <td><?= $this->Number->format($challanRow->gst_percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gst Value') ?></th>
            <td><?= $this->Number->format($challanRow->gst_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Net Amount') ?></th>
            <td><?= $this->Number->format($challanRow->net_amount) ?></td>
        </tr>
    </table>
</div>
