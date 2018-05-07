<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DeliveryTime Entity
 *
 * @property int $id
 * @property int $city_id
 * @property \Cake\I18n\FrozenTime $time_from
 * @property \Cake\I18n\FrozenTime $time_to
 * @property string $status
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Order[] $orders
 */
class DeliveryTime extends Entity
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
        'time_from' => true,
        'time_to' => true,
        'status' => true,
        'city' => true,
        'orders' => true
    ];
}
