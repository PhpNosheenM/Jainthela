<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PromotionDetail Entity
 *
 * @property int $id
 * @property int $promotion_id
 * @property int $category_id
 * @property int $item_id
 * @property float $discount_in_percentage
 * @property float $discount_in_amount
 * @property float $discount_of_max_amount
 * @property string $coupan_name
 * @property int $coupan_code
 * @property float $buy_quntity
 * @property float $get_quntity
 * @property int $get_item_id
 * @property string $in_wallet
 * @property string $is_free_shipping
 *
 * @property \App\Model\Entity\Promotion $promotion
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\GetItem $get_item
 * @property \App\Model\Entity\Order[] $orders
 */
class PromotionDetail extends Entity
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
        'promotion_id' => true,
        'category_id' => true,
        'item_id' => true,
        'discount_in_percentage' => true,
        'discount_in_amount' => true,
        'discount_of_max_amount' => true,
        'coupan_name' => true,
        'coupan_code' => true,
        'buy_quntity' => true,
        'get_quntity' => true,
        'get_item_id' => true,
        'in_wallet' => true,
        'is_free_shipping' => true,
        'promotion' => true,
        'category' => true,
        'item' => true,
        'get_item' => true,
        'orders' => true
    ];
}
