<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Admin Entity
 *
 * @property int $id
 * @property int $location_id
 * @property int $role_id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $mobile_no
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property string $passkey
 * @property int $timeout
 * @property int $status
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\ComboOffer[] $combo_offers
 * @property \App\Model\Entity\Feedback[] $feedbacks
 * @property \App\Model\Entity\Item[] $items
 * @property \App\Model\Entity\Plan[] $plans
 * @property \App\Model\Entity\Promotion[] $promotions
 * @property \App\Model\Entity\Unit[] $units
 */
class Admin extends Entity
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
        'location_id' => true,
        'role_id' => true,
        'name' => true,
        'username' => true,
        'password' => true,
        'email' => true,
        'mobile_no' => true,
        'created_on' => true,
        'created_by' => true,
        'passkey' => true,
        'timeout' => true,
        'status' => true,
        'location' => true,
        'role' => true,
        'combo_offers' => true,
        'feedbacks' => true,
        'items' => true,
        'plans' => true,
        'promotions' => true,
        'units' => true
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
