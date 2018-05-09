<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WishListItem Entity
 *
 * @property int $id
 * @property int $wish_list_id
 * @property int $item_id
 * @property int $item_variation_id
 * @property int $status
 *
 * @property \App\Model\Entity\WishList $wish_list
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ItemVariation $item_variation
 */
class WishListItem extends Entity
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
        'wish_list_id' => true,
        'item_id' => true,
        'item_variation_id' => true,
        'status' => true,
        'wish_list' => true,
        'item' => true,
        'item_variation' => true
    ];
}
