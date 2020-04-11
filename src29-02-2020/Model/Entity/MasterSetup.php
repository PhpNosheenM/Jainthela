<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MasterSetup Entity
 *
 * @property int $id
 * @property int $city_id
 * @property int $cash_back_slot
 * @property float $online_amount_limit
 * @property int $cancel_order_limit
 * @property int $days
 * @property int $wallet_withdrawl_charge_per
 *
 * @property \App\Model\Entity\City $city
 */
class MasterSetup extends Entity
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
        'cash_back_slot' => true,
        'online_amount_limit' => true,
        'cancel_order_limit' => true,
        'days' => true,
        'wallet_withdrawl_charge_per' => true,
        'city' => true,
		'delivery_message' => true,
		'order_success_message' => true,
		'order_fail_message' => true,
		'membership_tc' =>true
    ];
}
