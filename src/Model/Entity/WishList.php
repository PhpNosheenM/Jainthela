<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WishList Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $status
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\WishListItem[] $wish_list_items
 */
class WishList extends Entity
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
        'customer_id' => true,
        'created_on' => true,
        'status' => true,
        'customer' => true,
        'wish_list_items' => true
    ];
}
