<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Role Entity
 *
 * @property int $id
 * @property int $city_id
 * @property string $name
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property int $status
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Admin[] $admins
 */
class Role extends Entity
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
        'name' => true,
        'created_on' => true,
        'created_by' => true,
        'status' => true,
        'city' => true,
        'admins' => true
    ];
}
