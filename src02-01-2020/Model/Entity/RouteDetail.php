<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RouteDetail Entity
 *
 * @property int $id
 * @property int $route_id
 * @property int $landmark_id
 * @property int $priority
 * @property string $status
 *
 * @property \App\Model\Entity\Route $route
 * @property \App\Model\Entity\Landmark $landmark
 */
class RouteDetail extends Entity
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
        'route_id' => true,
        'landmark_id' => true,
        'priority' => true,
        'status' => true,
        'route' => true,
        'landmark' => true
    ];
}
