<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderDetail Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int $item_variation_id
 * @property int $combo_offer_id
 * @property float $quantity
 * @property float $rate
 * @property float $amount
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\ItemVariation $item_variation
 * @property \App\Model\Entity\ComboOffer $combo_offer
 */
class OrderDetail extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'order_id' => true,
        'item_id' => true,
        'item_variation_id' => true,
        'combo_offer_id' => true,
        'quantity' => true,
        'rate' => true,
        'amount' => true,
        'gst_percentage' => true,
        'gst_figure_id' => true,
        'gst_value' => true,
        'net_amount' => true,
        'order' => true,
        'item_variation' => true,
        'combo_offer' => true
    ];
}
