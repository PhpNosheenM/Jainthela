<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseVoucherRow Entity
 *
 * @property int $id
 * @property int $purchase_voucher_id
 * @property string $cr_dr
 * @property int $ledger_id
 * @property float $debit
 * @property float $credit
 * @property string $mode_of_payment
 * @property string $cheque_no
 * @property \Cake\I18n\FrozenDate $cheque_date
 *
 * @property \App\Model\Entity\PurchaseVoucher $purchase_voucher
 * @property \App\Model\Entity\Ledger $ledger
 * @property \App\Model\Entity\AccountingEntry[] $accounting_entries
 * @property \App\Model\Entity\ReferenceDetail[] $reference_details
 */
class PurchaseVoucherRow extends Entity
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
        'purchase_voucher_id' => true,
        'cr_dr' => true,
        'ledger_id' => true,
        'debit' => true,
        'credit' => true,
        'mode_of_payment' => true,
        'cheque_no' => true,
        'cheque_date' => true,
        'purchase_voucher' => true,
        'ledger' => true,
        'accounting_entries' => true,
        'reference_details' => true
    ];
}
