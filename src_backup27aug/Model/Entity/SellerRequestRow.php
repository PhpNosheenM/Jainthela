<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SellerRequestRow Entity
 *
 * @property int $id
 * @property int $seller_request_id
 * @property int $item_id
 * @property int $item_variation_id
 * @property float $quantity
 * @property float $rate
 * @property float $taxable_value
 * @property float $net_amount
 * @property int $gst_percentage
 * @property float $gst_value
 * @property float $purchase_rate
 * @property float $sales_rate
 * @property string $gst_type
 * @property float $mrp
 *
 * @property \App\Model\Entity\SellerRequest $seller_request
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ItemVariation $item_variation
 */
class SellerRequestRow extends Entity
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
        'seller_request_id' => true,
        'item_id' => true,
        'item_variation_id' => true,
        'quantity' => true,
        'rate' => true,
        'taxable_value' => true,
        'net_amount' => true,
        'gst_percentage' => true,
        'gst_value' => true,
        'purchase_rate' => true,
        'sales_rate' => true,
        'gst_type' => true,
        'mrp' => true,
        'seller_request' => true,
        'item' => true,
        'item_variation' => true
    ];
}
