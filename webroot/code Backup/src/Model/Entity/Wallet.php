<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Wallet Entity
 *
 * @property int $id
 * @property int $city_id
 * @property int $customer_id
 * @property int $order_id
 * @property int $plan_id
 * @property int $promotion_id
 * @property float $add_amount
 * @property float $used_amount
 * @property string $cancel_to_wallet_online
 * @property string $narration
 * @property int $return_order_id
 * @property string $amount_type
 * @property \Cake\I18n\FrozenTime $created_on
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Plan $plan
 * @property \App\Model\Entity\Promotion $promotion
 * @property \App\Model\Entity\ReturnOrder $return_order
 */
class Wallet extends Entity
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
        'order_id' => true,
        'plan_id' => true,
        'promotion_id' => true,
        'add_amount' => true,
        'used_amount' => true,
        'cancel_to_wallet_online' => true,
        'narration' => true,
        'return_order_id' => true,
        'amount_type' => true,
        'created_on' => true,
        'customer' => true,
        'city' => true,
        'order' => true,
        'plan' => true,
        'promotion' => true,
        'return_order' => true
    ];
}
