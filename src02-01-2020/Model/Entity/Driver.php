<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * Driver Entity
 *
 * @property int $id
 * @property string $name
 * @property string $user_name
 * @property string $password
 * @property string $mobile_no
 * @property int $location_id
 * @property string $device_token
 * @property string $latitude
 * @property string $longitude
 * @property string $status
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Order[] $orders
 */
class Driver extends Entity
{
	protected function _setPassword($password)
    {
        return md5($password);
    }
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
        'name' => true,
        'user_name' => true,
        'password' => true,
        'mobile_no' => true,
        'location_id' => true,
        'device_token' => true,
        'latitude' => true,
        'longitude' => true,
        'status' => true,
        'location' => true,
        'orders' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
