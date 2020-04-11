<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BulkOrderPerformaRow Entity
 *
 * @property int $id
 * @property int $bulk_order_performa_id
 * @property int $category_id
 * @property int $brand_id
 * @property int $item_id
 * @property int $quantity
 *
 * @property \App\Model\Entity\BulkOrderPerforma $bulk_order_performa
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Brand $brand
 * @property \App\Model\Entity\Item $item
 */
class BulkOrderPerformaRow extends Entity
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
        'id' => true,
        'bulk_order_performa_id' => true,
        'category_id' => true,
        'brand_id' => true,
        'item_id' => true,
        'quantity' => true,
        'bulk_order_performa' => true,
        'category' => true,
        'brand' => true,
        'item' => true
    ];
}
