<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StockTransferVoucher Entity
 *
 * @property int $id
 * @property int $grn_id
 * @property int $city_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property int $location_id
 * @property int $voucher_no
 * @property string $narration
 *
 * @property \App\Model\Entity\Grn $grn
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\StockTransferVoucherRow[] $stock_transfer_voucher_rows
 */
class StockTransferVoucher extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to sales_rate
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'grn_id' => true,
        'city_id' => true,
        'transaction_date' => true,
        'location_id' => true,
        'voucher_no' => true,
        'narration' => true,
        'grn' => true,
        'city' => true,
        'location' => true,
        'stock_transfer_voucher_rows' => true
    ];
}
