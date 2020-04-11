<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompanyDetail Entity
 *
 * @property int $id
 * @property int $city_id
 * @property string $email
 * @property string $web
 * @property string $mobile
 * @property string $address
 * @property int $flag
 *
 * @property \App\Model\Entity\City $city
 */
class CompanyDetail extends Entity
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
        'email' => true,
        'web' => true,
        'mobile' => true,
        'address' => true,
        'flag' => true,
        'city' => true
    ];
}
