<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DeliveryCharge Entity
 *
 * @property int $id
 * @property int $city_id
 * @property float $amount
 * @property float $charge
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Order[] $orders
 */
class DeliveryCharge extends Entity
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
        'amount' => true,
        'charge' => true,
        'status' => true,
        'created_on' => true,
        'created_by' => true,
        'city' => true,
        'orders' => true
    ];
}
