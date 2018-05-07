<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Seller Entity
 *
 * @property int $id
 * @property int $city_id
 * @property int $location_id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $mobile_no
 * @property string $latitude
 * @property string $longitude
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
 * @property string $passkey
 * @property int $timeout
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property string $status
 * @property string $bill_to_bill_accounting
 * @property float $opening_balance_value
 * @property string $debit_credit
 * @property string $saller_image
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Banner[] $banners
 * @property \App\Model\Entity\Grn[] $grns
 * @property \App\Model\Entity\HistoryItemVariation[] $history_item_variations
 * @property \App\Model\Entity\ItemLedger[] $item_ledgers
 * @property \App\Model\Entity\ItemVariation[] $item_variations
 * @property \App\Model\Entity\Item[] $items
 * @property \App\Model\Entity\Ledger[] $ledgers
 * @property \App\Model\Entity\ReferenceDetail[] $reference_details
 * @property \App\Model\Entity\SellerItem[] $seller_items
 * @property \App\Model\Entity\SellerRating[] $seller_ratings
 * @property \App\Model\Entity\SellerRequest[] $seller_requests
 */
class Seller extends Entity
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
        'location_id' => true,
        'name' => true,
        'username' => true,
        'password' => true,
        'email' => true,
        'mobile_no' => true,
        'latitude' => true,
        'longitude' => true,
        'gstin' => true,
        'pan' => true,
        'gstin_holder_name' => true,
        'gstin_holder_address' => true,
        'firm_name' => true,
        'firm_address' => true,
        'firm_email' => true,
        'firm_contact' => true,
        'firm_pincode' => true,
        'registration_date' => true,
        'termination_date' => true,
        'termination_reason' => true,
        'breif_decription' => true,
        'passkey' => true,
        'timeout' => true,
        'created_on' => true,
        'created_by' => true,
        'status' => true,
        'bill_to_bill_accounting' => true,
        'opening_balance_value' => true,
        'debit_credit' => true,
        'saller_image' => true,
        'location' => true,
        'banners' => true,
        'grns' => true,
        'history_item_variations' => true,
        'item_ledgers' => true,
        'item_variations' => true,
        'items' => true,
        'ledgers' => true,
        'reference_details' => true,
        'seller_details' => true,
        'seller_items' => true,
        'seller_ratings' => true,
        'seller_requests' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
