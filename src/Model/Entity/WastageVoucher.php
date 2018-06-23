<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WastageVoucher Entity
 *
 * @property int $id
 * @property int $voucher_no
 * @property int $city_id
 * @property int $location_id
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property string $narration
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\WastageVoucherRow[] $wastage_voucher_rows
 */
class WastageVoucher extends Entity
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
        'city_id' => true,
        'location_id' => true,
        'created_on' => true,
        'created_by' => true,
        'narration' => true,
        'city' => true,
        'location' => true,
        'wastage_voucher_rows' => true
    ];
}
