<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Unit Entity
 *
 * @property int $id
 * @property int $city_id
 * @property string $longname
 * @property string $shortname
 * @property string $unit_name
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $status
 *
 * @property \App\Model\Entity\ComboOfferDetail[] $combo_offer_details
 * @property \App\Model\Entity\ItemVariation[] $item_variations
 */
class Unit extends Entity
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
        'longname' => true,
        'shortname' => true,
        'unit_name' => true,
        'created_by' => true,
        'created_on' => true,
        'status' => true,
        'combo_offer_details' => true,
        'item_variations' => true
    ];
}
