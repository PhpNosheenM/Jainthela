<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseOrder Entity
 *
 * @property int $id
 * @property int $financial_year_id
 * @property int $vendor_id
 * @property int $voucher_no
 * @property int $location_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $narration
 * @property string $entry_from
 * @property int $city_id
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $edited_by
 * @property \Cake\I18n\FrozenTime $edited_on
 *
 * @property \App\Model\Entity\FinancialYear $financial_year
 * @property \App\Model\Entity\Vendor $vendor
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\PurchaseOrderRow[] $purchase_order_rows
 */
class PurchaseOrder extends Entity
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
        'financial_year_id' => true,
        'vendor_id' => true,
        'voucher_no' => true,
        'location_id' => true,
        'transaction_date' => true,
        'narration' => true,
        'entry_from' => true,
        'city_id' => true,
        'created_by' => true,
        'created_on' => true,
        'edited_by' => true,
        'edited_on' => true,
        'financial_year' => true,
        'vendor' => true,
        'location' => true,
        'city' => true,
        'purchase_order_rows' => true
    ];
}
