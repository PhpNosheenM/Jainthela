<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseOrderRow Entity
 *
 * @property int $id
 * @property int $purchase_order_id
 * @property int $item_id
 * @property int $item_variation_id
 * @property int $unit_variation_id
 * @property float $quantity
 * @property float $rate
 * @property float $net_amount
 *
 * @property \App\Model\Entity\PurchaseOrder $purchase_order
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ItemVariation $item_variation
 * @property \App\Model\Entity\UnitVariation $unit_variation
 */
class PurchaseOrderRow extends Entity
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
        'purchase_order_id' => true,
        'item_id' => true,
        'item_variation_id' => true,
        'unit_variation_id' => true,
        'quantity' => true,
        'rate' => true,
        'net_amount' => true,
        'purchase_order' => true,
        'item' => true,
        'item_variation' => true,
        'unit_variation' => true
    ];
}
