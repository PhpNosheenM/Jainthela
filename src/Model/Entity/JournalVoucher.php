<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * JournalVoucher Entity
 *
 * @property int $id
 * @property int $voucher_no
 * @property int $reference_no
 * @property int $location_id
 * @property int $city_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $narration
 * @property float $total_credit_amount
 * @property float $total_debit_amount
 * @property string $status
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\AccountingEntry[] $accounting_entries
 * @property \App\Model\Entity\JournalVoucherRow[] $journal_voucher_rows
 */
class JournalVoucher extends Entity
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
        'reference_no' => true,
        'city_id' => true,
        'location_id' => true,
        'city_id' => true,
        'transaction_date' => true,
        'narration' => true,
        'total_credit_amount' => true,
        'total_debit_amount' => true,
        'status' => true,
        'created_by' => true,
        'created_on' => true,
        'location' => true,
        'city' => true,
        'accounting_entries' => true,
        'journal_voucher_rows' => true
    ];
}
