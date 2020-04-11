<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Holiday Entity
 *
 * @property int $id
 * @property int $city_id
 * @property string $reason
 * @property \Cake\I18n\FrozenDate $date
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 *
 * @property \App\Model\Entity\City $city
 */
class Holiday extends Entity
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
        'reason' => true,
        'date' => true,
        'created_by' => true,
        'created_on' => true,
        'city' => true
    ];
}
