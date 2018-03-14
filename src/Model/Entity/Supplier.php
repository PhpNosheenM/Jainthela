<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Supplier Entity
 *
 * @property int $id
 * @property int $location_id
 * @property int $city_id
 * @property string $name
 * @property string $address
 * @property string $mobile_no
 * @property string $email
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $edited_on
 * @property int $edited_by
 * @property int $status
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Ledger[] $ledgers
 * @property \App\Model\Entity\ReferenceDetail[] $reference_details
 */
class Supplier extends Entity
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
        'city_id' => true,
        'name' => true,
        'address' => true,
        'mobile_no' => true,
        'email' => true,
        'created_on' => true,
        'created_by' => true,
        'edited_on' => true,
        'edited_by' => true,
        'status' => true,
        'location' => true,
        'city' => true,
        'ledgers' => true,
        'bill_to_bill_accounting' => true,
        'debit_credit' => true,
        'opening_balance_value' => true,
        'reference_details' => true
    ];
}
