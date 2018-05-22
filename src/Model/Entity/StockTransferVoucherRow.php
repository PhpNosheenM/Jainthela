<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StockTransferVoucherRow Entity
 *
 * @property int $id
 * @property int $stock_transfer_voucher_id
 * @property int $item_id
 * @property float $item_variation_id
 * @property float $rate
 * @property float $quantity
 *
 * @property \App\Model\Entity\StockTransferVoucher $stock_transfer_voucher
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ItemVariation $item_variation
 */
class StockTransferVoucherRow extends Entity
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
        'stock_transfer_voucher_id' => true,
        'item_id' => true,
        'item_variation_id' => true,
        'rate' => true,
        'quantity' => true,
        'stock_transfer_voucher' => true,
        'item' => true,
        'item_variation' => true
    ];
}
