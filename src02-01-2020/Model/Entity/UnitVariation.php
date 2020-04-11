<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UnitVariation Entity
 *
 * @property int $id
 * @property int $unit_id
 * @property int $quantity_variation
 * @property float $convert_unit_qty
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 *
 * @property \App\Model\Entity\Unit $unit
 */
class UnitVariation extends Entity
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
        'unit_id' => true,
        'city_id' => true,
        'status' => true,
        'quantity_variation' => true,
        'convert_unit_qty' => true,
        'created_by' => true,
        'add_from' => true,
        'created_on' => true,
        'visible_variation' => true,
        'unit' => true
    ];
}
