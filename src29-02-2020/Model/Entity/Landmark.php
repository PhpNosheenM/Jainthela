<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Landmark Entity
 *
 * @property int $id
 * @property int $city_id
 * @property int $location_id
 * @property string $name
 * @property string $status
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\RouteRow[] $route_rows
 */
class Landmark extends Entity
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
        'location_id' => true,
        'name' => true,
        'status' => true,
        'city' => true,
        'location' => true,
        'route_rows' => true
    ];
}
