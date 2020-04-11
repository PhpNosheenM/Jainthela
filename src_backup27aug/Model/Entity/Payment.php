<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $id
 * @property int $voucher_no
 * @property int $location_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $narration
 * @property string $status
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\AccountingEntry[] $accounting_entries
 * @property \App\Model\Entity\PaymentRow[] $payment_rows
 */
class Payment extends Entity
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
        'status' => true,
        'location' => true,
        'accounting_entries' => true,
        'payment_rows' => true
    ];
}
