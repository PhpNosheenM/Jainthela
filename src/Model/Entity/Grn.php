<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Grn Entity
 *
 * @property int $id
 * @property int $seller_id
 * @property int $admin_id
 * @property int $voucher_no
 * @property string $grn_no
 * @property int $location_id
 * @property int $order_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $reference_no
 * @property float $total_taxable_value
 * @property float $total_gst
 * @property float $total_amount
 * @property \Cake\I18n\FrozenTime $created_on
 * @property string $status
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\GrnRow[] $grn_rows
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
        'seller_id' => true,
        'admin_id' => true,
        'voucher_no' => true,
        'grn_no' => true,
        'location_id' => true,
        'order_id' => true,
        'transaction_date' => true,
        'reference_no' => true,
        'total_taxable_value' => true,
        'total_gst' => true,
        'total_amount' => true,
        'created_on' => true,
        'status' => true,
        'location' => true,
        'order' => true,
        'grn_rows' => true
    ];
}
