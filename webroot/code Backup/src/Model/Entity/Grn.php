<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Grn Entity
 *
 * @property int $id
 * @property int $voucher_no
 * @property int $grn_no
 * @property int $location_id
 * @property int $order_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $reference_no
 * @property string $status
 * @property float $total_taxable_value
 * @property float $total_gst
 * @property float $total_amount
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\SellerLedger $seller_ledger
 * @property \App\Model\Entity\PurchaseLedger $purchase_ledger
 */
class Grn extends Entity
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
        'voucher_no' => true,
        'grn_no' => true,
        'location_id' => true,
        'order_id' => true,
        'transaction_date' => true,
        'reference_no' => true,
        'status' => true,
        'total_taxable_value' => true,
        'total_gst' => true,
        'total_amount' => true,
        'location' => true,
        'order' => true,
        'seller_ledger' => true,
        'purchase_ledger' => true
    ];
}
