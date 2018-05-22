<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CreditNote Entity
 *
 * @property int $id
 * @property string $status
 * @property int $voucher_no
 * @property int $location_id
 * @property int $city_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property float $total_credit_amount
 * @property float $total_debit_amount
 * @property string $narration
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\AccountingEntry[] $accounting_entries
 * @property \App\Model\Entity\CreditNoteRow[] $credit_note_rows
 * @property \App\Model\Entity\ItemLedger[] $item_ledgers
 * @property \App\Model\Entity\ReferenceDetail[] $reference_details
 */
class CreditNote extends Entity
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
        'status' => true,
        'voucher_no' => true,
        'location_id' => true,
        'city_id' => true,
        'transaction_date' => true,
        'total_credit_amount' => true,
        'total_debit_amount' => true,
        'narration' => true,
        'created_by' => true,
        'created_on' => true,
        'location' => true,
        'city' => true,
        'accounting_entries' => true,
        'credit_note_rows' => true,
        'item_ledgers' => true,
        'reference_details' => true
    ];
}
