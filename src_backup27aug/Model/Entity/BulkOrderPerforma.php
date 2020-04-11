<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BulkOrderPerforma Entity
 *
 * @property int $id
 * @property string $name
 * @property int $city_id
 * @property \Cake\I18n\FrozenDate $created_on
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\BulkOrderPerformaRow[] $bulk_order_performa_rows
 */
class BulkOrderPerforma extends Entity
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
        'name' => true,
        'city_id' => true,
        'created_on' => true,
        'city' => true,
        'bulk_order_performa_rows' => true
    ];
}
