<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SellerItem Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $category_id
 * @property int $seller_id
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property float $commission_percentage
 * @property \Cake\I18n\FrozenTime $commission_created_on
 * @property \Cake\I18n\FrozenTime $expiry_on_date
 * @property int $status
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Seller $seller
 * @property \App\Model\Entity\SellerItemVariation[] $seller_item_variations
 */
class SellerItem extends Entity
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
        'category_id' => true,
        'seller_id' => true,
        'created_on' => true,
        'created_by' => true,
        'commission_percentage' => true,
        'commission_created_on' => true,
        'expiry_on_date' => true,
        'status' => true,
        'item' => true,
        'items' => true,
        'category' => true,
        'seller' => true,
        'sellers' => true,
        'seller_item_variations' => true
    ];
}
