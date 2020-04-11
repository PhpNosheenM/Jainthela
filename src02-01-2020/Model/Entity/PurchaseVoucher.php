<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseVoucher Entity
 *
 * @property int $id
 * @property int $voucher_no
 * @property int $financial_year_id
 * @property int $city_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $seller_invoice_no
 * @property \Cake\I18n\FrozenDate $seller_invoice_date
 * @property string $narration
 * @property \Cake\I18n\FrozenDate $created_on
 * @property int $created_by
 * @property string $status
 *
 * @property \App\Model\Entity\FinancialYear $financial_year
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\AccountingEntry[] $accounting_entries
 * @property \App\Model\Entity\PurchaseVoucherRow[] $purchase_voucher_rows
 */
class PurchaseVoucher extends Entity
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
        'transaction_date' => true,
        'seller_invoice_no' => true,
        'seller_invoice_date' => true,
        'narration' => true,
        'created_on' => true,
        'created_by' => true,
        'status' => true,
        'financial_year' => true,
        'city' => true,
        'accounting_entries' => true,
        'purchase_voucher_rows' => true
    ];
}
