<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Seller Entity
 *
 * @property int $id
 * @property int $city_id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $mobile_no
 * @property string $latitude
 * @property string $longitude
 * @property string $gstin
 * @property string $gstin_holder_name
 * @property string $gstin_holder_address
 * @property string $firm_name
 * @property string $firm_address
 * @property \Cake\I18n\FrozenDate $registration_date
 * @property \Cake\I18n\FrozenDate $termination_date
 * @property string $termination_reason
 * @property string $breif_decription
 * @property string $passkey
 * @property int $timeout
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property string $status
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Item[] $items
 * @property \App\Model\Entity\SellerItem[] $seller_items
 * @property \App\Model\Entity\SellerRating[] $seller_ratings
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
        'location_id' => true,
        'name' => true,
        'username' => true,
        'password' => true,
        'email' => true,
        'mobile_no' => true,
        'latitude' => true,
        'longitude' => true,
        'gstin' => true,
        'gstin_holder_name' => true,
        'gstin_holder_address' => true,
        'firm_name' => true,
        'firm_address' => true,
        'registration_date' => true,
        'termination_date' => true,
        'termination_reason' => true,
        'bill_to_bill_accounting' => true,
        'opening_balance_value' => true,
        'debit_credit' => true,
        'breif_decription' => true,
        'passkey' => true,
        'timeout' => true,
        'created_on' => true,
        'created_by' => true,
        'status' => true,
        'location' => true,
        'items' => true,
        'seller_items' => true,
        'reference_details' => true,
        'seller_ratings' => true
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
