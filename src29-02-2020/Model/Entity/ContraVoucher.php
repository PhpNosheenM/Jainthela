<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContraVoucher Entity
 *
 * @property int $id
 * @property int $voucher_no
 * @property int $location_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $narration
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 * @property string $status
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\AccountingEntry[] $accounting_entries
 */
class ContraVoucher extends Entity
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
        'location_id' => true,
        'transaction_date' => true,
        'financial_year_id' => true,
        'narration' => true,
        'created_by' => true,
        'created_on' => true,
        'status' => true,
        'location' => true,
        'contra_voucher_rows' => true,
        'accounting_entries' => true
    ];
}
