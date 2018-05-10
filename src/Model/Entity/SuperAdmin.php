<?php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * SuperAdmin Entity
 *
 * @property int $id
 * @property int $city_id
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
 * @property string $status
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Role $role
 */
class SuperAdmin extends Entity
{
	protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher())->hash($password);
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
        'city_id' => true,
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
        'city' => true,
        'role' => true
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
