<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WastageVoucherRow Entity
 *
 * @property int $id
 * @property int $wastage_voucher_id
 * @property int $item_id
 * @property int $item_variation_id
 * @property float $quantity
 * @property float $rate
 * @property float $amount
 *
 * @property \App\Model\Entity\WastageVoucher $wastage_voucher
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ItemVariation $item_variation
 */
class WastageVoucherRow extends Entity
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
        'wastage_voucher_id' => true,
        'item_id' => true,
        'item_variation_id' => true,
        'quantity' => true,
        'rate' => true,
        'amount' => true,
        'wastage_voucher' => true,
        'item' => true,
        'item_variation' => true
    ];
}
