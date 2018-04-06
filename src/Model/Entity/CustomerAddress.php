<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerAddress Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property string $receiver_name
 * @property string $gender
 * @property string $mobile_no
 * @property int $city_id
 * @property int $location_id
 * @property int $pincode
 * @property string $house_no
 * @property string $address
 * @property string $landmark
 * @property string $latitude
 * @property string $longitude
 * @property int $default_address
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Order[] $orders
 */
class CustomerAddress extends Entity
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
        'receiver_name' => true,
        'gender' => true,
        'mobile_no' => true,
        'city_id' => true,
        'location_id' => true,
        'pincode' => true,
        'house_no' => true,
        'address' => true,
        'landmark' => true,
        'latitude' => true,
        'longitude' => true,
        'default_address' => true,
        'customer' => true,
        'city' => true,
        'location' => true,
        'orders' => true
    ];
}
