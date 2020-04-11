<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LocationTransferVoucherRow Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $location_transfer_voucher_id
 * @property int $item_variation_id
 * @property int $unit_variation_id
 * @property float $quantity
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\LocationTransferVoucher $location_transfer_voucher
 * @property \App\Model\Entity\ItemVariation $item_variation
 * @property \App\Model\Entity\UnitVariation $unit_variation
 */
class LocationTransferVoucherRow extends Entity
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
        'location_transfer_voucher_id' => true,
        'item_variation_id' => true,
        'unit_variation_id' => true,
        'quantity' => true,
        'item' => true,
        'location_transfer_voucher' => true,
        'item_variation' => true,
        'unit_variation' => true
    ];
}
