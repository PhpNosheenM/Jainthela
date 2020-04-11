<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemVariationMaster Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $unit_variation_id
 * @property \Cake\I18n\FrozenTime $created_on
 * @property \Cake\I18n\FrozenTime $edited_on
 * @property int $created_by
 * @property int $edited_by
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\UnitVariation $unit_variation
 */
class ItemVariationMaster extends Entity
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
        'unit_variation_id' => true,
        'created_on' => true,
        'edited_on' => true,
        'created_by' => true,
        'edited_by' => true,
        'add_from' => true,
        'item' => true,
        'unit_variation' => true
    ];
}
