<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cart Entity
 *
 * @property int $id
 * @property int $city_id
 * @property int $customer_id
 * @property int $item_variation_id
 * @property int $combo_offer_id
 * @property int $unit_id
 * @property float $quantity
 * @property float $rate
 * @property float $amount
 * @property int $cart_count
 * @property \Cake\I18n\FrozenTime $created_on
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\ItemVariation $item_variation
 * @property \App\Model\Entity\ComboOffer $combo_offer
 */
class Cart extends Entity
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
        'city_id' => true,
        'customer_id' => true,
        'item_variation_id' => true,
        'combo_offer_id' => true,
        'unit_id' => true,
        'quantity' => true,
        'rate' => true,
        'amount' => true,
        'cart_count' => true,
        'created_on' => true,
        'city' => true,
        'customer' => true,
        'item_variation' => true,
        'combo_offer' => true
    ];
}
