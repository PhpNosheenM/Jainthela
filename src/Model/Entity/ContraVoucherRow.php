<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContraVoucherRow Entity
 *
 * @property int $id
 * @property int $contra_voucher_id
 * @property int $cr_dr
 * @property int $ledger_id
 * @property float $debit
 * @property float $credit
 * @property int $mode_of_payment
 * @property int $cheque_no
 * @property int $cheque_date
 *
 * @property \App\Model\Entity\ContraVoucher $contra_voucher
 * @property \App\Model\Entity\Ledger $ledger
 * @property \App\Model\Entity\AccountingEntry[] $accounting_entries
 */
class ContraVoucherRow extends Entity
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
        'contra_voucher_id' => true,
        'cr_dr' => true,
        'ledger_id' => true,
        'debit' => true,
        'credit' => true,
        'mode_of_payment' => true,
        'cheque_no' => true,
        'cheque_date' => true,
        'contra_voucher' => true,
        'ledger' => true,
        'reference_details' => true,
        'accounting_entries' => true
    ];
}
