<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseInvoice Entity
 *
 * @property int $id
 * @property int $voucher_no
 * @property int $location_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property int $seller_ledger_id
 * @property int $purchase_ledger_id
 * @property string $narration
 * @property string $status
 * @property int $city_id
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $edited_by
 * @property \Cake\I18n\FrozenTime $edited_on
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\SellerLedger $seller_ledger
 * @property \App\Model\Entity\PurchaseLedger $purchase_ledger
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\AccountingEntry[] $accounting_entries
 * @property \App\Model\Entity\ItemLedger[] $item_ledgers
 * @property \App\Model\Entity\PurchaseInvoiceRow[] $purchase_invoice_rows
 * @property \App\Model\Entity\PurchaseReturn[] $purchase_returns
 * @property \App\Model\Entity\ReferenceDetail[] $reference_details
 */
class PurchaseInvoice extends Entity
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
        'invoice_no' => true,
        'location_id' => true,
        'purchase_invoice_id' => true,
        'transaction_date' => true,
        'seller_ledger_id' => true,
        'purchase_ledger_id' => true,
        'narration' => true,
        'entry_from' => true,
        'city_id' => true,
        'created_by' => true,
        'created_on' => true,
        'edited_by' => true,
        'edited_on' => true,
        'location' => true,
        'total_taxable_value' => true,
        'total_gst' => true,
        'total_amount' => true,
        'seller_ledger' => true,
        'purchase_ledger' => true,
        'city' => true,
        'accounting_entries' => true,
        'item_ledgers' => true,
        'purchase_invoice_rows' => true,
        'purchase_returns' => true,
        'reference_details' => true
    ];
}
