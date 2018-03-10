<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Banner Entity
 *
 * @property int $id
 * @property int $city_id
 * @property string $link_name
 * @property string $name
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $status
 *
 * @property \App\Model\Entity\City $city
 */
class Banner extends Entity
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
        'link_name' => true,
        'name' => true,
        'created_on' => true,
        'status' => true,
        'city' => true
    ];
}
