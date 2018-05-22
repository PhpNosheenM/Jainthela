<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DebitNote Entity
 *
 * @property int $id
 * @property int $voucher_no
 * @property int $location_id
 * @property int $city_id
 * @property float $total_credit_amount
 * @property float $total_debit_amount
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $narration
 * @property string $status
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\AccountingEntry[] $accounting_entries
 * @property \App\Model\Entity\DebitNoteRow[] $debit_note_rows
 * @property \App\Model\Entity\ReferenceDetail[] $reference_details
 */
class DebitNote extends Entity
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
        'city_id' => true,
        'total_credit_amount' => true,
        'total_debit_amount' => true,
        'transaction_date' => true,
        'narration' => true,
        'status' => true,
        'created_by' => true,
        'created_on' => true,
        'location' => true,
        'city' => true,
        'accounting_entries' => true,
        'debit_note_rows' => true,
        'reference_details' => true
    ];
}
