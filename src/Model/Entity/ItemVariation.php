<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemVariation Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $unit_id
 * @property float $quantity_factor
 * @property float $print_quantity
 * @property float $print_rate
 * @property float $discount_per
 * @property float $sales_rate
 * @property float $maximum_quantity_purchase
 * @property int $out_of_stock
 * @property string $ready_to_sale
 * @property \Cake\I18n\FrozenTime $created_on
 * @property string $status
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\Unit $unit
 * @property \App\Model\Entity\OrderDetail[] $order_details
 */
class ItemVariation extends Entity
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
        'item_id' => true,
        'unit_variation_id' => true,
        'quantity_factor' => true,
        'print_quantity' => true,
        'print_rate' => true,
        'discount_per' => true,
        'sales_rate' => true,
        'maximum_quantity_purchase' => true,
        'out_of_stock' => true,
        'ready_to_sale' => true,
        'created_on' => true,
        'status' => true,
        'item' => true,
        'seller_item_id' => true,
        'city_id' => true,
        'commission' => true,
        'order_details' => true,
        'seller_id' => true,
        'current_stock' => true,
        'purchase_rate' => true,
        'mrp' => true,
        'item_variation_master_id' => true
    ];
}
