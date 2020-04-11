<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LocationItem Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $item_variation_master_id
 * @property int $location_id
 * @property string $status
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ItemVariation $item_variation
 * @property \App\Model\Entity\Location $location
 */
class LocationItem extends Entity
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
        'item_id' => true,
        'item_variation_master_id' => true,
        'location_id' => true,
        'status' => true,
        'item' => true,
        'item_variation' => true,
        'location' => true
    ];
}
