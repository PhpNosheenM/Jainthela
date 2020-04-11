<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vendor Entity
 *
 * @property int $id
 * @property int $city_id
 * @property string $name
 * @property string $gstin
 * @property string $pan
 * @property string $gstin_holder_name
 * @property string $gstin_holder_address
 * @property string $firm_name
 * @property string $firm_address
 * @property string $firm_email
 * @property string $firm_contact
 * @property string $firm_pincode
 * @property \Cake\I18n\FrozenDate $registration_date
 * @property \Cake\I18n\FrozenDate $termination_date
 * @property string $termination_reason
 * @property string $breif_decription
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property string $bill_to_bill_accounting
 * @property float $opening_balance_value
 * @property string $debit_credit
 * @property string $status
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Ledger[] $ledgers
 * @property \App\Model\Entity\VendorDetail[] $vendor_details
 */
class Vendor extends Entity
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
        'name' => true,
        'gstin' => true,
        'pan' => true,
        'firm_name' => true,
        'firm_address' => true,
        'firm_pincode' => true,
        'registration_date' => true,
        'termination_date' => true,
        'termination_reason' => true,
        'breif_decription' => true,
        'created_on' => true,
        'created_by' => true,
        'bill_to_bill_accounting' => true,
        'opening_balance_value' => true,
        'debit_credit' => true,
        'status' => true,
        'document_image' => true,
        'city' => true,
        'location' => true,
        'ledgers' => true,
        'vendor_details' => true
    ];
}
