<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ComboOfferDetail Entity
 *
 * @property int $id
 * @property int $combo_offer_id
 * @property int $item_variation_id
 * @property int $unit_id
 * @property float $quantity
 * @property float $rate
 * @property float $amount
 *
 * @property \App\Model\Entity\ComboOffer $combo_offer
 * @property \App\Model\Entity\ItemVariation $item_variation
 * @property \App\Model\Entity\Unit $unit
 */
class ComboOfferDetail extends Entity
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
        'combo_offer_id' => true,
        'item_variation_id' => true,
        'unit_id' => true,
        'quantity' => true,
        'rate' => true,
        'amount' => true,
        'combo_offer' => true,
        'item_variation' => true,
        'unit' => true
    ];
}
