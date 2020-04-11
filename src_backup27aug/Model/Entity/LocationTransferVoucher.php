<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LocationTransferVoucher Entity
 *
 * @property int $id
 * @property string $voucher_no
 * @property int $financial_year_id
 * @property int $city_id
 * @property int $location_out_id
 * @property int $location_in_id
 * @property \Cake\I18n\FrozenTime $created_on
 *
 * @property \App\Model\Entity\FinancialYear $financial_year
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\LocationOut $location_out
 * @property \App\Model\Entity\LocationIn $location_in
 * @property \App\Model\Entity\LocationTransferVoucherRow[] $location_transfer_voucher_rows
 */
class LocationTransferVoucher extends Entity
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
        'financial_year_id' => true,
        'city_id' => true,
        'location_out_id' => true,
        'location_in_id' => true,
        'created_on' => true,
        'financial_year' => true,
        'city' => true,
        'location_out' => true,
        'location_in' => true,
        'location_transfer_voucher_rows' => true
    ];
}
