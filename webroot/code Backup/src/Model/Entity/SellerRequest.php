<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SellerRequest Entity
 *
 * @property int $id
 * @property int $seller_id
 * @property int $voucher_no
 * @property int $location_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $status
 * @property float $total_taxable_value
 * @property float $total_gst
 * @property float $total_amount
 *
 * @property \App\Model\Entity\Seller $seller
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\SellerRequestRow[] $seller_request_rows
 */
class SellerRequest extends Entity
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
        'seller_id' => true,
        'voucher_no' => true,
        'location_id' => true,
        'transaction_date' => true,
        'status' => true,
        'total_taxable_value' => true,
        'total_gst' => true,
        'total_amount' => true,
        'seller' => true,
        'location' => true,
        'seller_request_rows' => true
    ];
}
