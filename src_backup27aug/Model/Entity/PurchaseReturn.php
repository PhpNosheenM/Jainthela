<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseReturn Entity
 *
 * @property int $id
 * @property int $purchase_invoice_id
 * @property int $financial_year_id
 * @property string $voucher_no
 * @property string $invoice_no
 * @property int $location_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property int $seller_ledger_id
 * @property int $purchase_ledger_id
 * @property string $narration
 * @property float $total_taxable_value
 * @property float $total_gst
 * @property float $total_amount
 * @property string $entry_from
 * @property int $city_id
 * @property int $created_by
 * @property int $edited_by
 * @property \Cake\I18n\FrozenTime $created_on
 * @property \Cake\I18n\FrozenTime $edited_on
 * @property string $status
 *
 * @property \App\Model\Entity\PurchaseInvoice $purchase_invoice
 * @property \App\Model\Entity\FinancialYear $financial_year
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\SellerLedger $seller_ledger
 * @property \App\Model\Entity\PurchaseLedger $purchase_ledger
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\AccountingEntry[] $accounting_entries
 * @property \App\Model\Entity\ItemLedger[] $item_ledgers
 * @property \App\Model\Entity\PurchaseReturnRow[] $purchase_return_rows
 * @property \App\Model\Entity\ReferenceDetail[] $reference_details
 */
class PurchaseReturn extends Entity
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
        'purchase_invoice_id' => true,
        'financial_year_id' => true,
        'voucher_no' => true,
        'invoice_no' => true,
        'location_id' => true,
        'transaction_date' => true,
        'seller_ledger_id' => true,
        'purchase_ledger_id' => true,
        'narration' => true,
        'total_taxable_value' => true,
        'total_gst' => true,
        'total_amount' => true,
        'entry_from' => true,
        'city_id' => true,
        'created_by' => true,
        'edited_by' => true,
        'created_on' => true,
        'edited_on' => true,
        'status' => true,
        'purchase_invoice' => true,
        'financial_year' => true,
        'location' => true,
        'seller_ledger' => true,
        'purchase_ledger' => true,
        'city' => true,
        'accounting_entries' => true,
        'item_ledgers' => true,
        'purchase_return_rows' => true,
        'ref_name' => true,
        'debit' => true
    ];
}
